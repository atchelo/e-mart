<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Userbank;
use Auth;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class UserBankController extends Controller
{
    public function index()
    {   
        require_once('price.php');
    	return view('user.bankac.bankindex',compact('conversion_rate'));
    }

    public function store(Request $request){

        $request->validate([
            'acname' => 'required',
            'bankname' => 'required',
            'acno'  => 'required|unique:userbanks,acno',
            'ifsc'  => 'required',

        ],[
            'acname.required' => 'Account name is required',
            'bankname.required' => 'Bank name is required',
            'acno.required' => 'Account no is required',
            'acno.unique' => 'Account no is already in our records',
            'ifsc.required' => 'IFSC Code is required',

        ]);

    	$newbank = new Userbank;

    	$input = $request->all();
    	$input['user_id'] = Auth::user()->id;
    	$newbank->create($input);
        notify()->success('Bank Added Successully !');
    	return back();
    }

    public function update(Request $request,$id)
    {   

        $findac = Userbank::findorfail($id); 
        $getallac = Userbank::all();
        $input = $request->all();
        
        foreach ($getallac as $value) {
            
           if($findac->id == $value->id){

                if($request->acno == $findac->acno){
                   
                   $request->validate([
                        'acname' => 'required',
                        'bankname' => 'required',
                        'acno'  => 'required',
                        'ifsc'  => 'required',

                    ],[
                        'acname.required' => 'Account name is required',
                        'bankname.required' => 'Bank name is required',
                        'acno.required' => 'Account no is required',
                        'ifsc.required' => 'IFSC Code is required',

                    ]);

                   $findac->update($input);
                   notify()->success('Bank account information updated !');
                   return back();


                }else{
                    
                    try{
                        $request->validate([
                        'acname' => 'required',
                        'bankname' => 'required',
                        'acno'  => 'required',
                        'ifsc'  => 'required',

                    ],[
                        'acname.required' => 'Account name is required',
                        'bankname.required' => 'Bank name is required',
                        'acno.required' => 'Account no is required',
                        'ifsc.required' => 'IFSC Code is required',

                    ]);

                    $findac->update($input);
                }catch(\Exception $e){
                    notify()->error('Bank account already exist !');
                    return back();
                }
                    notify()->success('Bank Account Updated Successully !');
                    return back();

                }
           }

        }

    }
    

    public function delete($id)
    {
         $userbank = Userbank::findorfail($id); 

        if(Auth::user()->id == $userbank->user_id || Auth::user()->role_id == 'a'){
            $userbank->delete();
            notify()->success('Bank deleted successfully !');
            return back();
        }else{
            notify()->error('401 Unauthorized Action !');
            return back();
        } 
    }
}
