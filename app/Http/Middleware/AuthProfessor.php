<?php

namespace sportcontrol\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthProfessor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        if(Auth::user()->role == 'usuario')
            return $next($request);
        else
            return redirect()->guest('login');
    }
}
