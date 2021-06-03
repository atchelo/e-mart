<?php

namespace App\Http\Middleware;

use App\VisitorChart;
use Closure;

class VisitingTrack
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
        try{

            $myip = request()->getClientIp();

            $ip = geoip()->getLocation($myip);

            $already_with_that_ip = VisitorChart::firstWhere('ip_address','=',$myip);

            if(!isset($already_with_that_ip)){
                VisitorChart::create([
                    'country_code' => $ip->iso_code,
                    'ip_address'   => $myip,
                    'visit_count' => 1
                ]);
        
            }

            return $next($request);
            
        }catch(\Exception $e){

            \Log::error($e->getMessage());
            return $next($request);

        }
    }
}
