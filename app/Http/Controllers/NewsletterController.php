<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {

        if (env('MAILCHIMP_APIKEY') != '')
        {
           try{
                if (!Newsletter::isSubscribed($request->email))
                {
                    Newsletter::subscribePending($request->email);
                    notify()->success('Thanks For Subscribe !');
                    return back();
                }
                else
                {
                    notify()->error('You are already in our subscription list !');
                    return back();
                }
           }catch(\Exception $e){
                notify()->error($e->getMessage());
                return back();
           }
        }
        else
        {
            notify()->error('Mailchimp API keys not updated !');
            return back();
        }

    }
}

