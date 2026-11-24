<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    /**
     * Display the settings form.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.settings.index', compact('user'));
    }

    /**
     * Update the admin profile and password.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengubah password baru.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.',
        ]);

        $oldSnapshot = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        $passwordChanged = false;
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withInput($request->except(['current_password', 'password', 'password_confirmation']))
                    ->withErrors(['current_password' => 'Password saat ini yang Anda masukkan salah.']);
            }
            $user->password = Hash::make($request->password);
            $passwordChanged = true;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $newSnapshot = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        if ($passwordChanged) {
            $newSnapshot['password_changed'] = true;
        }

        $this->activityLog->log('update_own_profile', 'user', $user->id, $oldSnapshot, $newSnapshot);

        return back()->with('success', 'Pengaturan akun berhasil diperbarui.');
    }
}
