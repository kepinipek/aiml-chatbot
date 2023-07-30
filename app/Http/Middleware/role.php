<?php

namespace App\Http\Middleware;

use Auth;
use Redirect;
use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->is_admin){
            return $next($request);
        }

        return Redirect::to('/')->with('error', 'Halaman yang anda cari tidak ditemukan.');
    }
}
