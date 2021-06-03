<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsVendor
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

            $auth = Auth::user();

            if ($auth->role_id == 'v' || $auth->role_id == 'a') {

                if (getPlanStatus() == 1) {

                    return $next($request);

                } else {
                    notify()->error('Please subscribe a plan to continue !');
                    return redirect(route('front.seller.plans'));
                    
                }

            } else {

                return abort('401', 'Unauthorized action');

            }

        } else {

            return abort('401', 'Unauthorized action');

        }

    }
}
