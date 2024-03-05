<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
         $userRole = $request->user()->role;
         //dd($userRole);
         if (!in_array($userRole, $roles)) {
            abort(401, 'Unauthorized');
        }
        return $next($request);

    }
}
