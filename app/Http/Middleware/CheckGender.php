<?php

namespace App\Http\Middleware;

use Closure;
use auth;

class CheckGender
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth::user()){
            if(auth::user()->gender == null){
                return redirect('profile/edit');
            } else
                return $next($request);
                       
        }

        return $next($request);
        
        
    }
}
