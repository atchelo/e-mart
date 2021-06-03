<?php

namespace App\Http\Controllers;

use App\Config;
use App\Msg91Setting;
use Illuminate\Http\Request;
use DotenvEditor;

class Msg91Controller extends Controller
{
    public function __construct()
    {
        $this->config = Config::first();
    }

    public function getSettings()
    {
        $settings = Msg91Setting::get();
        $config = $this->config;
        return view('admindesk.sms.settings', compact('settings','config'));
    }

    public function updateSettings(Request $request){
       

        $env_keys_save = DotenvEditor::setKeys([
            'MSG91_AUTH_KEY' => $request->MSG91_AUTH_KEY
        ]);

        $env_keys_save->save();

        $this->config->msg91_enable = isset($request->msg91_enable) ? "1" : "0";
        $this->config->save();

        if(isset($request->keys)){
            foreach($request->keys as $key => $k){
          
                Msg91Setting::where('id','=',$key)->update([
    
                    'message' => $k != 'orders' ? $request->message[$key] : NULL,
                    'sender_id' => $request->sender_id[$key],
                    'otp_length' => $k != 'orders' ? $request->otp_length[$key] : NULL,
                    'otp_expiry' => $k != 'orders' ? $request->otp_expiry[$key] : NULL,
                    'unicode' => isset($request->unicode[$key]) ? 1 : 0,
                    'flow_id' => $request->flow_id[$key]
                ]); 
            }
        }

        notify()->success('SMS settings has been updated !');

        return back();
    }

}
