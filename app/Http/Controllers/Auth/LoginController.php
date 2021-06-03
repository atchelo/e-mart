<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Cart;
use App\User;
use Socialite;
use Mail;
use App\Mail\WelcomeUser;
use Auth;
use Illuminate\Support\Facades\Cookie;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    

    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest')->except('logout');

    }

    public function showLoginForm()
    {
        require_once(base_path().'/app/Http/Controllers/price.php');
        return view('auth.login',compact('conversion_rate'));
    }


    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($service)
    {
        try{
            
            $userSocial = Socialite::driver($service)->user();
            
        }catch(\Exception $error){

            $userSocial = Socialite::driver($service)->stateless()->user();
            
        }

        
        $find_user = User::where('email',$userSocial->email)->first();
        
        if($find_user){
            Auth::login($find_user);
            return redirect('/');
        }else{  

           $user = new User;
           $user->name      =     $userSocial->name;
           $user->email     =     $userSocial->email != '' ? $userSocial->email : $userSocial->name.'@'.$service.'.com';
           $user->password  =     bcrypt(123456);
           $user->save();

            try{
                

                Mail::to($user['email'])->send(new WelcomeUser($user));
                
                
            }catch(\Swift_TransportException $e){
                
            }catch(\Exception $e){

            }
            
            $this->guard()->login($user);
            notify()->success('Registration Successfull !');
            return redirect('/');
       
        }
    }



    public function logout(Request $request)
    {
        
        Auth::logout();
        
        Session::forget('coupanapplied');

        Cookie::queue(Cookie::forget('two_fa'));

        notify()->success('Logged out !');
        return redirect('/');
    }

    public function adminlogout(Request $request){
        $this->performLogout($request);
        return redirect('/admindesk/login');
    }


}
