<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->level->level_name;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak. Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini.');
        }

        return $next($request);
    }
}
