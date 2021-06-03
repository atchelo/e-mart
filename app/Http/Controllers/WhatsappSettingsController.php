<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhatsappSettingsController extends Controller
{
    public function update(Request $request){

            try{
                DB::table('whatsapp_settings')->where('id',1)->update([
                    'phone_no' => $request->phone_no,
                    'position' => $request->position,
                    'size' => $request->size,
                    'headerTitle' => $request->headerTitle,
                    'popupMessage' => $request->popupMessage,
                    'headerColor' => $request->headerColor,
                    'status' => isset($request->status) ? 1 : 0
                ]);

                notify()->success('Whatsapp settings updated !');
                return back();
            }catch(\Exception $e){
                notify()->error($e->getMessage());
                return back();
            }

    }
}
