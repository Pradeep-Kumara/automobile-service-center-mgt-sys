<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class MWjobcard
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->user_role_id==2 || Auth::user()->user_role_id==3 || Auth::user()->user_role_id==4  ){

            return $next($request);
        }
        else{
            return redirect('/');
        }
    }
}
