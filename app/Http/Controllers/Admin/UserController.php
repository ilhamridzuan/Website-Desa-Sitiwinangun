<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    /**
     * Display the list of admin accounts.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("CASE WHEN role = 'superadmin' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();

        $activeSuperAdminCount = User::where('role', 'superadmin')
            ->where('is_active', true)
            ->count();

        return view('admin.users.index', compact('users', 'search', 'activeSuperAdminCount'));
    }

    /**
     * Show the form for creating a new admin account.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created admin account.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'superadmin'])],
            'password' => ['required', 'confirmed', Password::min(8)],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 100 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan akun lain.',
            'role.required' => 'Peran akun wajib dipilih.',
            'role.in' => 'Peran akun harus Admin atau Superadmin.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
            'failed_attempts' => 0,
            'locked_until' => null,
        ]);

        $this->activityLog->log(
            'create_user',
            'user',
            $user->id,
            null,
            $this->sanitizedSnapshot($user)
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Akun {$user->name} berhasil dibuat.");
    }

    /**
     * Show the form for editing an admin account or resetting its password.
     */
    public function edit(User $user): View
    {
        $isSelf = $user->id === Auth::id();
        $isLastActiveSuperAdmin = $this->isLastActiveSuperAdmin($user);

        return view('admin.users.edit', compact('user', 'isSelf', 'isLastActiveSuperAdmin'));
    }

    /**
     * Update an admin account and optionally reset its password.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'superadmin'])],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 100 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan akun lain.',
            'role.required' => 'Peran akun wajib dipilih.',
            'role.in' => 'Peran akun harus Admin atau Superadmin.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal terdiri dari 8 karakter.',
        ]);

        $isSelf = $user->id === Auth::id();
        $newRole = $validated['role'];
        $hasIsActive = $request->has('is_active');
        $requestedActive = $request->boolean('is_active');
        $passwordChanged = $request->filled('password');

        $result = DB::transaction(function () use ($user, $validated, $isSelf, $newRole, $hasIsActive, $requestedActive, $passwordChanged) {
            $lockedTarget = User::whereKey($user->id)->lockForUpdate()->firstOrFail();
            $newActive = $hasIsActive ? $requestedActive : (bool) $lockedTarget->is_active;

            if ($isSelf && ($newRole !== 'superadmin' || !$newActive)) {
                return ['error' => 'Anda tidak dapat menurunkan peran atau menonaktifkan akun yang sedang dipakai.'];
            }

            if ($this->isLastActiveSuperAdminLocked($lockedTarget) && ($newRole !== 'superadmin' || !$newActive)) {
                return ['error' => 'Sistem harus memiliki minimal satu superadmin yang aktif.'];
            }

            $oldSnapshot = $this->sanitizedSnapshot($lockedTarget);

            $lockedTarget->name = $validated['name'];
            $lockedTarget->email = $validated['email'];
            $lockedTarget->role = $newRole;
            $lockedTarget->is_active = $newActive;

            if ($passwordChanged) {
                $lockedTarget->password = Hash::make($validated['password']);
                $lockedTarget->failed_attempts = 0;
                $lockedTarget->locked_until = null;
            }

            $lockedTarget->save();

            $newSnapshot = $this->sanitizedSnapshot($lockedTarget);
            if ($passwordChanged) {
                $newSnapshot['password_changed'] = true;
            }

            $this->activityLog->log('update_user', 'user', $lockedTarget->id, $oldSnapshot, $newSnapshot);

            return ['user' => $lockedTarget];
        });

        if (isset($result['error'])) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['role' => $result['error']]);
        }

        $updatedUser = $result['user'];
        $message = $passwordChanged
            ? "Data dan password akun {$updatedUser->name} berhasil diperbarui."
            : "Data akun {$updatedUser->name} berhasil diperbarui.";

        return redirect()
            ->route('admin.users.index')
            ->with('success', $message);
    }

    /**
     * Toggle active status of another admin account.
     */
    public function toggleActive(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $result = DB::transaction(function () use ($user) {
            $lockedTarget = User::whereKey($user->id)->lockForUpdate()->firstOrFail();

            if ($lockedTarget->is_active && $this->isLastActiveSuperAdminLocked($lockedTarget)) {
                return ['error' => 'Superadmin aktif terakhir tidak dapat dinonaktifkan.'];
            }

            $oldSnapshot = $this->sanitizedSnapshot($lockedTarget);
            $lockedTarget->is_active = !$lockedTarget->is_active;

            if ($lockedTarget->is_active) {
                $lockedTarget->failed_attempts = 0;
                $lockedTarget->locked_until = null;
            }

            $lockedTarget->save();

            $this->activityLog->log(
                'toggle_user_status',
                'user',
                $lockedTarget->id,
                $oldSnapshot,
                $this->sanitizedSnapshot($lockedTarget)
            );

            return ['user' => $lockedTarget];
        });

        if (isset($result['error'])) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', $result['error']);
        }

        $updatedUser = $result['user'];
        $statusLabel = $updatedUser->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Akun {$updatedUser->name} berhasil {$statusLabel}.");
    }

    /**
     * Remove another admin account.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $result = DB::transaction(function () use ($user) {
            $lockedTarget = User::whereKey($user->id)->lockForUpdate()->firstOrFail();

            if ($this->isLastActiveSuperAdminLocked($lockedTarget)) {
                return ['error' => 'Superadmin aktif terakhir tidak dapat dihapus.'];
            }

            $oldSnapshot = $this->sanitizedSnapshot($lockedTarget);
            $name = $lockedTarget->name;
            $id = $lockedTarget->id;

            $lockedTarget->delete();

            $this->activityLog->log('delete_user', 'user', $id, $oldSnapshot, null);

            return ['name' => $name];
        });

        if (isset($result['error'])) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', $result['error']);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Akun {$result['name']} berhasil dihapus.");
    }

    private function isLastActiveSuperAdmin(User $user): bool
    {
        if ($user->role !== 'superadmin' || !$user->is_active) {
            return false;
        }

        return User::where('role', 'superadmin')
            ->where('is_active', true)
            ->where('id', '!=', $user->id)
            ->count() === 0;
    }

    private function isLastActiveSuperAdminLocked(User $lockedTarget): bool
    {
        if ($lockedTarget->role !== 'superadmin' || !$lockedTarget->is_active) {
            return false;
        }

        $otherActiveSuperAdmins = User::where('role', 'superadmin')
            ->where('is_active', true)
            ->where('id', '!=', $lockedTarget->id)
            ->lockForUpdate()
            ->count();

        return $otherActiveSuperAdmins === 0;
    }

    /**
     * Return safe user attributes for activity logging (never includes password/hash).
     */
    private function sanitizedSnapshot(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => (bool) $user->is_active,
        ];
    }
}
