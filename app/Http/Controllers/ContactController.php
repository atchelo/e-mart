<?php

namespace App\Http\Controllers;

use App\Genral;
use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request){
        require_once ('price.php');
        $settings = Genral::first();
        return view('front.contactus',compact('conversion_rate','settings'));
    }

    public function getConnect(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'message' => 'required|max:10000',
            'subject' => 'required'
        ]);
        
        try{

            $mail = Genral::first();
            Mail::to($mail->email)->send(new Contact($request));
            notify()->success('Message sent successfully !');
            return back();

        }catch(\Exception $e){
            return back()->with($e->getMessage());
        }

    }
}
