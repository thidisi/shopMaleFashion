<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLoginAdminPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $emailUser = $request->session()->get('sessionEmailUser');
        // $checkEmail = filter_var(auth()->user()->email, FILTER_VALIDATE_EMAIL);
        // $checkEmail = filter_var($emailUser, FILTER_VALIDATE_EMAIL);
        // if($checkEmail) {
        //     return redirect()->route('admin.login');
        // }
        // return $next($request);
    }
}
