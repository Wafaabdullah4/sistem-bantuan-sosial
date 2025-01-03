<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

         // Cek role pengguna
        //  if (Auth::check()) {
        //     if (Auth::user()->role === 'admin') {
        //         return redirect('/admin/dashboard'); // Redirect ke dashboard admin
        //     } else {
        //         return redirect('/dashboard'); // Redirect ke dashboard user biasa
        //     }
        // }

        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/dashboard');
        // // Periksa apakah pengguna sudah login dan memiliki peran admin
        // if (Auth::check() && Auth::user()->role === 'admin') {
        //     return $next($request);
        // }

        // // Jika bukan admin, arahkan ke halaman lain atau tampilkan pesan
        // return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
