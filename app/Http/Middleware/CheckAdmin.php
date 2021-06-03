<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CheckAdmin
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
        if (Auth::check()) {
            
           return $auth = Auth::user();

            if ($auth->role_id == 'a') {
                return $next($request);

            } else {
                
                return abort('401','Unauthorized action');

            }

        } else {

            return redirect('login');

        }
    }
}
