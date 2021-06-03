<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class LoginController extends Controller
{

    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(2);
	}

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
		]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('email')){
				return response()->json(['msg' => $errors->first('email'), 'status' => 'fail']);
			}

			if($errors->first('password')){
				return response()->json(['msg' => $errors->first('password'), 'status' => 'fail']);
			}
	
		}

        $user = User::where('email','=',$request->email)->first();

        if(!$user){
            return response()->json(['msg' => 'User not found !','status' => 'fail']);
        }

        if($user['status'] != 1){
            return response()->json(['msg' => 'User is not active !','status' => 'fail']);
        }

        if(!Hash::check($request->password,$user->password)){
            return response()->json(['msg' => 'Email or password is invalid !','status' => 'fail']);
        }


        return $this->issueToken($request, 'password');

    }

    public function refresh(Request $request){
       
        if(!Auth::check()){
            return response()->json(['msg' => 'You are not logged in', 'status' => 'fail']);
        }
        

        if ($request->refresh_token) {
            return response()->json(['msg' => 'refresh_token is required', 'status' => 'fail']);
        }

        

    	return $this->issueToken($request, 'refresh_token');
    }

   public function logout(Request $request)
    { 
       
       if(Auth::check()){
            $user = Auth::user()->token();
            $user->revoke();
            $response = ['msg' => 'You have been successfully logged out!','status' => 'success'];
            return response($response, 200);
       }
        
    }
}
