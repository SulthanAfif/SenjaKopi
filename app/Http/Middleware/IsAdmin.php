<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Memberi tahu VS Code bahwa variabel ini adalah Model User milik kita
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        // Mengecek apakah user sudah login DAN memiliki role 'admin'
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tendang ke halaman utama
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}