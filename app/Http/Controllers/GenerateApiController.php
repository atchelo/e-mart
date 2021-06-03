<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateApiController extends Controller
{
    /*==========================================
    =            Author: Media City            =
    Author URI: https://mediacity.co.in
    =            Developer: @nkit              =
    =            Copyright (c) 2020            =
    ==========================================*/

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getkey()
    {
        if (Auth::check()) {
            $key = DB::table('api_keys')->where('user_id', '=', Auth::user()->id)->first();
            return view('admindesk.apikeys.getkey',compact('key'));

        } else {
            notify()->error('Please login to get your key');
            return redirect()->route('login');
        }
    }

    public function createKey(Request $request)
    {

        $row = DB::table('api_keys')->where('user_id', '=', Auth::user()->id)->first();

        if ($row) {

            $key = DB::table('api_keys')
              ->where('id', Auth::user()->id)
              ->update(['secret_key' => (string) Str::uuid()]);

            notify()->success('Key is re-generated successfully !');

            return back();

        } else {
            $key = DB::table('api_keys')->insert([
                'secret_key' => (string) Str::uuid(),
                'user_id' => Auth::user()->id,
            ]);

            if ($key) {
                notify()->success('Key is generated successfully !');
                return back();
            }
        }

    }
}
