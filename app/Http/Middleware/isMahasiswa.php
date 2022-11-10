<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isMahasiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->exists('login') == 1)
        {
            if ($request->session()->exists('akses') == 1) {
                return $next($request);
            }
            return redirect()->route('login_mahasiswa')->with(['error' => 'Gagal, akses anda tidak dikenali !']);
        }
        return redirect()->route('login_mahasiswa')->with(['error' => 'Gagal, silahkan masuk untuk melanjutkan !']);
    }
}
