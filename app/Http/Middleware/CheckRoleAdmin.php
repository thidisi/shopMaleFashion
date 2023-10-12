<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission = 'staff')
    {
        if (auth()->user()->level != 'admin') {
            if ($permission == 'manager' && auth()->user()->level == 'manager') {
                return $next($request);
            }
            return abort('404');
        }
        return $next($request);
    }
}
