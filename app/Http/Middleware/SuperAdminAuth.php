<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminAuth
{
    /**
     * Allow access only to active superadmin accounts.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->is_active || $user->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang dapat mengelola akun admin.');
        }

        return $next($request);
    }
}
