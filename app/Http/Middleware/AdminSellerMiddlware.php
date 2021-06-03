<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminSellerMiddlware
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
        if(Auth::user()->role_id == 'a' || Auth::user()->role_id == 'v'){
            return $next($request);
        }else{
            return abort('401','Unauthorized action');
        }
        
    }
}
