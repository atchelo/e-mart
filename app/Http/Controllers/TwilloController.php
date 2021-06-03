<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use DotenvEditor;
use Twilosms;
use Auth;

class TwilloController extends Controller
{
    public function sendsms(Request $request){

        $smsmsg = 'Your order #'.uniqid().' placed successfully ! You can view your order by visiting here:%0a';
        
        $smsurl = route('user.view.order',uniqid());

        $smsmsg .= $smsurl.'%0a%0a';

        $smsmsg .= 'Thanks for shopping with us - '.config('app.name');

        Twilosms::sendMessage($smsmsg, '+'.Auth::user()->phonecode.Auth::user()->mobile);

        return 'Done';

    }

    public function whatsapp(){
        
        $sid    = "ACd55185aa4684799f7e69f4e03db40258"; 
        $token  = "138e98035110dfd36f583db736b61b4d"; 
        $twilio = new Client($sid, $token); 
        
        $message = $twilio->messages 
                        ->create("whatsapp:+917737161477", // to 
                                array( 
                                    "from" => "whatsapp:+14155238886",       
                                    "body" => "Wh thik h " 
                                ) 
                        ); 
        
        print($message->sid);
    }

    public function changechannel(Request $request){

        
            if(isset($request->channel)){
                $env_keys_save = DotenvEditor::setKeys([
                    'DEFAULT_SMS_CHANNEL' => $request->channel,
                ]);
        
                $env_keys_save->save();
        
                return response()->json('Channel changed !');
            }

            if(isset($request->enable)){

                $config = Config::first();

                $config->sms_channel = $request->enable;

                $config->save();

                if($request->enable == '1'){
                    return response()->json('Channel Enabled !');
                }else{
                    return response()->json('Channel Disbaled !');
                }
        
            }
        

    }

    public function savesettings(Request $request){

        $env_keys_save = DotenvEditor::setKeys([
            'TWILIO_SID' => $request->TWILIO_SID,
            'TWILIO_AUTH_TOKEN' => $request->TWILIO_AUTH_TOKEN,
            'TWILIO_NUMBER' => $request->TWILIO_NUMBER
        ]);

        $env_keys_save->save();

        notify()->success("Twillo settings updated !",'Success');
        return back();

    }
}
