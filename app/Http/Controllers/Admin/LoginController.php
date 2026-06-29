<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $throttleKey = 'login_attempt:' . $request->ip();

        // 1. Rate Limiting Check (Laravel Built-in)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ])->withInput($request->only('email'));
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            RateLimiter::hit($throttleKey, 60);
            return back()->withErrors([
                'email' => 'Kredensial yang Anda masukkan tidak cocok.',
            ])->withInput($request->only('email'));
        }

        // 2. Account Locking Check (Custom DB-based lock)
        if ($user->isLocked()) {
            RateLimiter::hit($throttleKey, 60);
            $minutes = ceil(now()->diffInSeconds($user->locked_until) / 60);
            return back()->withErrors([
                'email' => "Akun Anda dikunci sementara karena 5 kegagalan login berturut-turut. Silakan coba lagi dalam {$minutes} menit.",
            ])->withInput($request->only('email'));
        }

        // 3. Attempt Authentication
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda dinonaktifkan. Hubungi superadmin.',
                ])->withInput($request->only('email'));
            }

            // Check if user has proper role
            if (!in_array($user->role, ['admin', 'superadmin'])) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Anda tidak memiliki hak akses admin.',
                ])->withInput($request->only('email'));
            }

            // Reset attempts & logging info
            $user->resetFailedAttempts();
            $user->update([
                'last_login_at' => now(),
            ]);

            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // 4. Failed attempt logic
        $user->incrementFailedAttempts();
        RateLimiter::hit($throttleKey, 60);

        if ($user->isLocked()) {
            return back()->withErrors([
                'email' => 'Akun Anda telah dikunci selama 15 menit karena 5 kali kegagalan login berturut-turut.',
            ])->withInput($request->only('email'));
        }

        $attemptsLeft = 5 - $user->failed_attempts;
        return back()->withErrors([
            'email' => "Password salah. Sisa percobaan login sebelum akun dikunci: {$attemptsLeft}.",
        ])->withInput($request->only('email'));
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda berhasil keluar.');
    }
}
