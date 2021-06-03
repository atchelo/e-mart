<?php

namespace App\Http\Middleware;

use App\Maintainence;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MaintainenceMode
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
        
        if(\DB::connection()->getDatabaseName()){

           if(\Schema::hasTable('table_maintainence_mode')){

                $row = Maintainence::first();

                if(isset($row) && $row->status == 1 && !empty($row->allowed_ips) && !in_array($request->ip(),$row->allowed_ips)){

                    if(Auth::check() && Auth::user()->role_id == 'a'){
                        return $next($request);
                    }

                    return Response(view('maintain', compact('row')));

                }else{
                    return $next($request);
                }
            
            } 
        }

        return $next($request);

        
        
    }
}
