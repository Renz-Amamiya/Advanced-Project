<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CekTokenApi
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('token')) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu.');
        }
        return $next($request);
    }
}