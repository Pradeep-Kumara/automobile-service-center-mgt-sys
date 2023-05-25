<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class MWvehicle
{
    public function handle($request, Closure $next)
    
    {
        if(Auth::user()->user_role_id==2 || Auth::user()->user_role_id==1 || Auth::user()->user_role_id==3 ){

            return $next($request);
        }
        else{
            return redirect('/');
        }
    }
}
