<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{

    /**
     * Handle an incoming request and check if the authenticated user's role is authorized.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param mixed ...$roles
     * @return mixed
     *
     * @throws \Symfony\Component\HttpFoundation\Response
     */

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        foreach ($roles as $role) {
            if (Auth::user()->role == $role) {
                return $next($request);
            }
        }
        abort(401);
        // return redirect()->route('login')->with('status', 'You are not authorized to access this page.');
    }
}
