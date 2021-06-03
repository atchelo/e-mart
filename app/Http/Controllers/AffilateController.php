<?php

namespace App\Http\Controllers;

use App\Affilate;
use App\AffilateHistory;
use App\CurrencyNew;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AffilateController extends Controller
{
    public function settings(){

        $af_settings = Affilate::first();

        return view('admindesk.affilate.settings',compact('af_settings'));

    }

    public function update(Request $request){

        Affilate::updateorCreate([
            'id' => 1
        ],[
            'enable_affilate' => $request->enable_affilate ? 1 : 0,
            'code_limit'      => $request->code_limit,
            'refer_amount'    => $request->refer_amount,
            'about_system'    => $request->about_system,
            'enable_purchase' => $request->enable_purchase ? 1 : 0,
        ]);

        notify()->success('Affiliate settings updated !');

        return back();


    }

    public function userdashboard(){

        $af_settings = Affilate::first();

        if(!$af_settings || $af_settings->enable_affilate != 1){
            abort(404);
        }

        if(auth()->user()->refer_code == ''){

            auth()->user()->update([
                'refer_code' => User::createReferCode()
            ]);
            
        }

        $aff_history = auth()->user()->getReferals()->with(['user' => function($q){
            return $q->select('id','email');
        }])->wherehas('user')->paginate(10);

        $earning = auth()->user()->getReferals()->wherehas('user')->sum('amount');
        
        return view('user.affiliate',compact('aff_history','earning'));
    }


    public function reports(){

        $af_settings = Affilate::first();

        if(!$af_settings || $af_settings->enable_affilate != 1){
            abort(404);
        }

        $defaultCurrency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract',function($query) {

            return $query->where('default_currency','1');
        
        })->first();

        $data = AffilateHistory::with(['fromRefered' => function($q){
            return $q->select('id','name','email');
        },'user' => function($q){
            return $q->select('id','name','email');
        }])->whereHas('fromRefered')->whereHas('user');

        if(request()->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('refered_user',function($row){

                    return $row->user->name . ' ('.$row->user->email.')';

                })
                ->addColumn('user',function($row){

                    
                    return $row->fromRefered->name . ' ('.$row->fromRefered->email.')';

                })
                ->addColumn('amount',function($row) use($defaultCurrency) {

                    return $defaultCurrency->symbol.$row->amount;

                })
                ->addColumn('created_at',function($row) use($defaultCurrency) {

                    return date('d/m/Y | h:i A',strtotime($row->created_at));

                })
                ->rawColumns(['refered_user', 'user','amount','created_at'])
                ->make(true);
        }
        
        return view('admindesk.affilate.dashboard',compact('defaultCurrency'));
        
    }
}
