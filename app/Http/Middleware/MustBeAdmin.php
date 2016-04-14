<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MustBeAdmin
{

    /**
     * Handle an incoming request.
     *
     * @param         $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return Response
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check() && Auth::guard($guard)->user()->isAdmin()) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
