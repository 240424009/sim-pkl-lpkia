<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek naha user geus login atawa durung
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Cek naha role user nu login aya dina daptar role nu diizinkeun
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses Ditolak! Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}