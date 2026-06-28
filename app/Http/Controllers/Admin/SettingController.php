<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengubah password baru.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // Validate current password if password change is requested
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini yang Anda masukkan salah.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Pengaturan profil berhasil diperbarui.');
    }
}
