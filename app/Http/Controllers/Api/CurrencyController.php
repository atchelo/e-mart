<?php

namespace App\Http\Controllers\Api;

use App\CurrencyNew;
use App\Http\Controllers\Controller;
use App\multiCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function changeCurrency(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        return $this->fetchRates($request->currency);

    }

    public function fetchRates($currency){
        
        $defcurrency = multiCurrency::firstWhere('default_currency','=',1);

        $c_currency = CurrencyNew::firstWhere('code',$currency);

        if($defcurrency && $currency){

            $from = $defcurrency->currency->code;

            $to = $currency;

            $rate = currency(1.00, $from, $to, $format = false);

            return response()->json([
                'id' => $c_currency->id ,
                'exchange_rate' => (double) sprintf("%.2f",$rate), 
                'code' => $c_currency->code, 
                'symbol' => $c_currency->symbol, 
                'font_awesome_symbol' => $c_currency->currencyextract ? $c_currency->currencyextract->currency_symbol : null
            ]);
  

        }

    }   
}
