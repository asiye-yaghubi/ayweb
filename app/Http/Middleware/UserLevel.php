<?php

namespace App\Http\Middleware;

use Closure;

class UserLevel
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
        if(auth()->check()){
            if(auth()->user()->type=='admin'){
                return $next($request);
            }
            else{
                return redirect('/userpanel');
            }
            // return $next($request);
            
        }
    }
}
