<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $newActive = $request->has('is_active') ? $request->boolean('is_active') : $user->is_active;

        if ($isSelf && ($newRole !== 'superadmin' || !$newActive)) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['role' => 'Anda tidak dapat menurunkan peran atau menonaktifkan akun yang sedang dipakai.']);
        }

        if ($this->isLastActiveSuperAdmin($user) && ($newRole !== 'superadmin' || !$newActive)) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['role' => 'Sistem harus memiliki minimal satu superadmin yang aktif.']);
        }

        $oldSnapshot = $this->sanitizedSnapshot($user);
        $passwordChanged = $request->filled('password');

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $newRole;
        $user->is_active = $newActive;

        if ($passwordChanged) {
            $user->password = Hash::make($validated['password']);
            $user->failed_attempts = 0;
            $user->locked_until = null;
        }

        $user->save();

        $newSnapshot = $this->sanitizedSnapshot($user);
        if ($passwordChanged) {
            $newSnapshot['password_changed'] = true;
        }

        $this->activityLog->log('update_user', 'user', $user->id, $oldSnapshot, $newSnapshot);

        $message = $passwordChanged
            ? "Data dan password akun {$user->name} berhasil diperbarui."
            : "Data akun {$user->name} berhasil diperbarui.";

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

        if ($user->is_active && $this->isLastActiveSuperAdmin($user)) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Superadmin aktif terakhir tidak dapat dinonaktifkan.');
        }

        $oldSnapshot = $this->sanitizedSnapshot($user);
        $user->is_active = !$user->is_active;

        if ($user->is_active) {
            $user->failed_attempts = 0;
            $user->locked_until = null;
        }

        $user->save();

        $this->activityLog->log(
            'toggle_user_status',
            'user',
            $user->id,
            $oldSnapshot,
            $this->sanitizedSnapshot($user)
        );

        $statusLabel = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Akun {$user->name} berhasil {$statusLabel}.");
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

        if ($this->isLastActiveSuperAdmin($user)) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Superadmin aktif terakhir tidak dapat dihapus.');
        }

        $oldSnapshot = $this->sanitizedSnapshot($user);
        $name = $user->name;
        $id = $user->id;

        $user->delete();

        $this->activityLog->log('delete_user', 'user', $id, $oldSnapshot, null);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Akun {$name} berhasil dihapus.");
    }

    private function isLastActiveSuperAdmin(User $user): bool
    {
        if ($user->role !== 'superadmin' || !$user->is_active) {
            return false;
        }

        return User::where('role', 'superadmin')
            ->where('is_active', true)
            ->count() <= 1;
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
