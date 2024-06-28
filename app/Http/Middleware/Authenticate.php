<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAdmin
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */

     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request) $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
        {
            if(auth()->user()->level == 'admin'){
            return $next($request);
        }

     abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}

class AuthenticatePegawai
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */

     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request) $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
        {
            if(auth()->user()->level == 'pegawai'){
            return $next($request);
        }

     abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}

class AuthenticateNasabah
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */

     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request) $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
        {
            if(auth()->user()->level == 'nasabah'){
            return $next($request);
        }

     abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}

