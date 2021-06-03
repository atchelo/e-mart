<?php

namespace App\Http\Controllers;

use App\OfferPopup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Image;

class OfferPopUpController extends Controller
{
    public function __construct()
    {
        $this->settings = OfferPopup::first();
    }

    public function getSettings(){
        $settings = $this->settings;
        return view('admindesk.popupsetting.settings',compact('settings'));
    }

    public function dontShow(Request $request){

        if($request->ajax()){
            if($request->opt == 1){
                Cookie::queue('popup','0',2628000);
                return response()->json(['msg' => 'Popup will not show'],200);
            }else{
                Cookie::forget('popup');
                return response()->json(['msg' => 'Popup will show'],200);
            }
        }

    }

    public function updateSettings(Request $request){

        $input = $request->all();

        $input['enable_popup'] = isset($request->enable_popup) ? "1" : "0";
        $input['enable_button'] = isset($request->enable_button) ? "1" : "0";

        if (!is_dir(public_path() . '/images/offerpopup')) {
            mkdir(public_path() . '/images/offerpopup');
        }

       if(isset($this->settings)){

            if ($request->image) {

                $image = $request->file('image');
                $input['image'] = 'popup_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/offerpopup');
                $img = Image::make($image->path());

                if ($this->settings->image != '' && file_exists(public_path() . '/images/offerpopup/' . $this->settings->image)) {
                    unlink(public_path() . '/images/offerpopup/' . $this->settings->image);
                }

                $img->save($destinationPath . '/' . $input['image']);

            }
             
            $this->settings->update($input);


       }else{

            $setting = new OfferPopup;

            if ($request->image) {

                $image = $request->file('image');
                $input['image'] = 'popup_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/offerpopup');
                $img = Image::make($image->path());

                $img->save($destinationPath . '/' . $input['image']);

            }

            $setting->create($input);

       }

       notify()->success('Offer popup settings updated !');
       return back();

    }
}
