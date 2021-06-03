<?php

namespace App\Http\Controllers;

use App\AddSubVariant;
use App\ProductNotify;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductNotifyController extends Controller
{
    public function post(Request $request,$varid){

        $variant = AddSubVariant::find($varid);

        $checkif = ProductNotify::firstWhere(['email' => $request->email,'var_id' => $varid]);

        $user = User::firstWhere('email',$request->email);

        if($checkif){
            alert()->info('<p class="font-weight-normal">You already subscribed for this product !</p>')->html()->autoclose(8000);
            return back();
        }

        if($variant){
            ProductNotify::create([
                'email' => $request->email,
                'var_id' => $varid,
                'user_id' => isset($user) ? $user->id : NULL
            ]);
        }

        alert()->success('<p class="font-weight-normal">Added to Notify List !</p>')->html()->autoclose(8000);
        return back();

    }
}
