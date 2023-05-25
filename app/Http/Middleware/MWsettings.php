<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class MWsettings
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->user_role_id==2){

            return $next($request);
        }
        else{
            return redirect('/');
        }
    }
}
