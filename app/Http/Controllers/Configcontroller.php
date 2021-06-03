<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Button;
use DB;
use DotenvEditor;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class Configcontroller extends Controller
{


    public function __construct()
    {
        $this->config = Config::first();
    }

    public function getset()
    {

        $env_files = ['MAIL_FROM_NAME' => env('MAIL_FROM_NAME') , 'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS') , 'MAIL_DRIVER' => env('MAIL_DRIVER') , 'MAIL_HOST' => env('MAIL_HOST') , 'MAIL_PORT' => env('MAIL_PORT') , 'MAIL_USERNAME' => env('MAIL_USERNAME') , 'MAIL_PASSWORD' => env('MAIL_PASSWORD') , 'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION') ,

        ];

        return view('admindesk.mailsetting.mailset', compact('env_files'));

    }
    

    public function changeMailEnvKeys(Request $request)
    {
       
        $env_keys_save =  DotenvEditor::setKeys([

            'MAIL_FROM_NAME' => $request->MAIL_FROM_NAME, 
            'MAIL_DRIVER' => $request->MAIL_DRIVER, 
            'MAIL_HOST' => $request->MAIL_HOST, 
            'MAIL_PORT' => $request->MAIL_PORT, 
            'MAIL_USERNAME' => $request->MAIL_USERNAME, 
            'MAIL_FROM_ADDRESS' => preg_replace('/\s+/', '', $request->MAIL_FROM_ADDRESS) , 
            'MAIL_PASSWORD' => $request->MAIL_PASSWORD, 
            'MAIL_ENCRYPTION' => $request->MAIL_ENCRYPTION

        ]);

        $env_keys_save->save();

        notify()->success('Mail settings saved !');

        return back();
        

    }

    public function socialget()
    {
        $setting = $this->config;
        return view('admindesk.mailsetting.social', compact('setting'));
    }

    public function socialLoginUpdate(Request $request,$service){
        if($service == 'facebook'){
            return $this->facebookSettings($request);
        }   

        if($service == 'google'){
            return $this->googleSettings($request);
        }

        if($service == 'twitter'){
            return $this->twitterSettings($request);
        }

        if($service == 'amazon'){
            return $this->amazonSettings($request);
        }

        if($service == 'gitlab'){
            return $this->gitlabSettings($request);
        }

        if($service == 'linkedin'){
            return $this->linkedinSettings($request);
        }
    }

    public function facebookSettings($request)
    {

        $this->config->fb_login_enable = isset($request->fb_login_enable) ? 1 : 0;

        

        $env_keys_save =  DotenvEditor::setKeys([
            'FACEBOOK_CLIENT_ID' => $request->FACEBOOK_CLIENT_ID, 
            'FACEBOOK_CLIENT_SECRET' => $request->FACEBOOK_CLIENT_SECRET, 
            'FB_CALLBACK_URL' => $request->FB_CALLBACK_URL
        ]);

        $env_keys_save->save();

        $this->config->save();

        notify()->success('Facebook Login Settings Updated !');

        return back();
    }

    public function googleSettings($request)
    {
      
        $this->config->google_login_enable = isset($request->google_login_enable) ? 1 : 0;

        $env_keys_save =  DotenvEditor::setKeys([
            'GOOGLE_CLIENT_ID' => $request->GOOGLE_CLIENT_ID, 
            'GOOGLE_CLIENT_SECRET' => $request->GOOGLE_CLIENT_SECRET, 
            'GOOGLE_CALLBACK_URL' => $request->GOOGLE_CALLBACK_URL
        ]);

        $env_keys_save->save();

        $this->config->save();

        notify()->success('Google Login Settings Updated !');

        return back();
    }

    public function twitterSettings($request)
    {
    
        $this->config->twitter_enable = isset($request->twitter_enable) ? 1 : 0;

        $env_keys_save =  DotenvEditor::setKeys([
            'TWITTER_API_KEY' => $request->TWITTER_API_KEY, 
            'TWITTER_SECRET_KEY' => $request->TWITTER_SECRET_KEY, 
            'TWITTER_CALLBACK_URL' => $request->TWITTER_CALLBACK_URL
        ]);

        $env_keys_save->save();

        $this->config->save();

        notify()->success('Twitter Login Settings Updated !');

        return back();
    }

    public function amazonSettings($request)
    {
    
        $this->config->amazon_enable = isset($request->amazon_enable) ? 1 : 0;

        $env_keys_save =  DotenvEditor::setKeys([
            'AMAZON_LOGIN_ID' => $request->AMAZON_LOGIN_ID, 
            'AMAZON_LOGIN_SECRET' => $request->AMAZON_LOGIN_SECRET, 
            'AMAZON_LOGIN_CALLBACK' => $request->AMAZON_LOGIN_CALLBACK
        ]);

        $env_keys_save->save();

        $this->config->save();

        notify()->success('Amazon Login Settings Updated !');

        return back();
    }

    public function linkedinSettings($request)
    {
    
        $this->config->linkedin_enable = isset($request->linkedin_enable) ? 1 : 0;


        $env_keys_save =  DotenvEditor::setKeys([

            'LINKEDIN_CLIENT_ID' => $request->LINKEDIN_CLIENT_ID, 
            'LINKEDIN_SECRET' => $request->LINKEDIN_SECRET, 
            'LINKEDIN_CALLBACK' => $request->LINKEDIN_CALLBACK

        ]);

        $env_keys_save->save();

        $this->config->save();

        notify()->success('Linkedin Login Settings Updated !');

        return back();
    }

    public function gitlabSettings($request)
    {

        $env_keys_save =  DotenvEditor::setKeys([
            'GITLAB_CLIENT_ID' => $request->GITLAB_CLIENT_ID, 
            'GITLAB_CLIENT_SECRET' => $request->GITLAB_CLIENT_SECRET, 
            'GITLAB_CALLBACK_URL' => $request->GITLAB_CALLBACK_URL,
            'ENABLE_GITLAB' => isset($request->ENABLE_GITLAB) ? "1" : "0"
        ]);

        $env_keys_save->save();

        notify()->success('Gitlab Settings has been saved');

        return back();
       
    }

    

}

