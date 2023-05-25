<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        return $next($request);
    }

// namespace App\Http\Middleware;
// use Closure;
// use Illuminate\Support\Facades\Auth;

// class Admin
// {
//     public function handle($request, Closure $next)
//     {
//         if(Auth::user()->user_role_iduser_role==1){

//             return $next($request);
//         }
//         else{
//             return redirect('/');
//         }
//     }

// }

}
