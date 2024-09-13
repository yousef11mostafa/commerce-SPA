<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @param  string|null  $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        // Check if a role is specified and if the user has the role
        if ($role && !$request->user() || !$request->user()->hasRole($role)) {
            return response()->json(['error' => 'Unauthorized - Role ' . $role ], 403);
        }



        return $next($request);
    }
}
