<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna memiliki role_id = 1
        if ($request->user() && $request->user()->role_id === 1) {
            return $next($request);
        }

        // Redirect ke halaman unauthorized jika tidak memiliki akses
        return redirect()->route('unauthorized');
    }
}
