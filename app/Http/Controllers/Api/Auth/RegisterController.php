<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class RegisterController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(2);
	}

    public function register(Request $request){

    	$validator = Validator::make($request->all(), [
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
    		'password' => 'required|min:8'
		]);

		

		if ($validator->fails()) {

			$errors = $validator->errors();

			if($errors->first('name')){
				return response()->json(['msg' => $errors->first('name'), 'status' => 'fail']);
			}

			if($errors->first('email')){
				return response()->json(['msg' => $errors->first('email'), 'status' => 'fail']);
			}

			if($errors->first('mobile')){
				return response()->json(['msg' => $errors->first('mobile'), 'status' => 'fail']);
			}

			if($errors->first('password')){
				return response()->json(['msg' => $errors->first('password'), 'status' => 'fail']);
			}
	
		}

    	User::create([
    		'name' => request('name'),
    		'email' => request('email'),
            'mobile' => request('mobile'),
    		'password' => bcrypt(request('password'))
    	]);

    	return $this->issueToken($request, 'password');

    }
}
