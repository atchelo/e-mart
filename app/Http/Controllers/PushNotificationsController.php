<?php

namespace App\Http\Controllers;

use App\Notifications\OfferPushNotifications;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use DotenvEditor;

class PushNotificationsController extends Controller
{
    public function index()
    {
        return view('admindesk.pushnotifications.index');
    }

    public function push(Request $request)
    {

        ini_set('max_excecution_time', -1);

        ini_set('memory_limit', -1);

        $request->validate([
            'subject' => 'required|string',
            'message' => 'required'
        ]);

        if(env('ONESIGNAL_APP_ID') =='' && env('ONESIGNAL_REST_API_KEY') == ''){
            notify()->error('Please update onesignal keys in settings !','Keys not found !');
            return back()->withInput();
        }

        try {

            $usergroup = User::query();

            $data = [
                'subject' => $request->subject,
                'body' => $request->message,
                'target_url' => $request->target_url ?? null,
                'icon' => $request->icon ?? null,
                'image' => $request->image ?? null,
                'buttonChecked' => $request->show_button ? "yes" : "no",
                'button_text' => $request->btn_text ?? null,
                'button_url' => $request->btn_url ?? null,
            ];

            if ($request->user_group == 'all_customers') {

                $users = $usergroup->select('id')->where('role_id', '=', 'u')->get();

            } elseif ($request->user_group == 'all_sellers') {

                $users = $usergroup->select('id')->where('role_id', '=', 'v')->get();

            } elseif ($request->user_group == 'all_admins') {

                $users = $usergroup->select('id')->where('role_id', '=', 'a')->get();

            } else {
                // all users
                $users = $usergroup->select('id')->get();
            }

            $users = $usergroup->select('id')->get();

            Notification::send($users, new OfferPushNotifications($data));

            notify()->success('Notification pushed successfully !');
            return back();

        } catch (\Exception $e) {

            notify()->error($e->getMessage());
            return back()->withInput();

        }

    }

    public function updateKeys(Request $request){

        $request->validate([
            'ONESIGNAL_APP_ID' => 'required|string',
            'ONESIGNAL_REST_API_KEY' => 'required|string'
        ],[
            'ONESIGNAL_APP_ID.required' => 'OneSignal app id is required',
            'ONESIGNAL_REST_API_KEY.required' => 'Onesignal rest api key is required'
        ]);

        $env_keys_save = DotenvEditor::setKeys([
            'ONESIGNAL_APP_ID' => $request->ONESIGNAL_APP_ID,
            'ONESIGNAL_REST_API_KEY' => $request->ONESIGNAL_REST_API_KEY
        ]);

        $env_keys_save->save();

        notify()->success('Keys updated successfully !','OneSignal');
        return back();
    }
}
