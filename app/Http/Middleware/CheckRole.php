<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login atau role user tidak ada dalam daftar $roles
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            return redirect('/dashboard')->with('error', 'Anda tidak punya akses ke fitur ini!');
        }

        return $next($request);
    }
}