<?php

namespace App\Http\Middleware;

use App\Genral;
use Closure;
use Auth;

class IsVerified
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
            
            $setting = Genral::select('email_verify_enable')->first();
           
        }catch(\Exception $e){
            
        }
       
        if(Auth::check())
        {
            if(Auth::user()->role_id != "a")
            {
                
                if($setting->email_verify_enable == '1')
                {
                    
                    if(Auth::user()->email_verified_at == NULL)
                    { 
                        return redirect()->route('verification.notice');   
                    }
                    
                }
                
            }

            return $next($request);
            
        }
        else
        {
            return $next($request);
        }
    }
}
