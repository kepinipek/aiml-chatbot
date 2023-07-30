<?php

namespace App\Http\Middleware;

use Auth;
use Redirect;
use Closure;
use Illuminate\Http\Request;

class Role
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->is_admin){
            return $next($request);
        }

        return Redirect::to('/')->with('error', 'Halaman yang anda cari tidak ditemukan.');
    }
}
