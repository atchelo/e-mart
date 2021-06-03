<?php

namespace App\Http\Controllers;

use App\CurrencyNew;
use App\SellerPlans;
use App\SellerSubscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SellerSubscriptionController extends Controller
{
    public function index()
    {

        abort_if(env('ENABLE_SELLER_SUBS_SYSTEM') == 0, 404);

        $defaultCurrency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract', function ($query) {

            return $query->where('default_currency', '1');

        })->first();

        $plans = SellerPlans::select('*');

        if (request()->ajax()) {
            return DataTables::of($plans)
                ->addIndexColumn()
                ->editColumn('name', function ($plan) {
                    return "<b>$plan->name</b>";
                })
                ->editColumn('price', function ($plan) use ($defaultCurrency) {
                    return $defaultCurrency->symbol . $plan->price;
                })
                ->editColumn('period', function ($plan) {
                    return $plan->validity .' '. $plan->period;
                })
                ->editColumn('features', function ($plan) {
                    $status = $plan->csv_product == 1 ? "YES" : "NO";
                    $html = '<p>CSV Product Enable: ' . $status .'</p>';
                    $html .= '<p>Product Create Limit: ' . $plan->product_create . '</p>';
                    return $html;
                })
                ->editColumn('status', function ($plan) {
                    if ($plan->status == 1) {
                        return '<span class="label label-success">Active</span>';
                    } else {
                        return '<span class="label label-danger">Deactive</span>';
                    }
                })
                ->editColumn('action', 'admindesk.plans.action')
                ->rawColumns(['name', 'price', 'period', 'features', 'status', 'action'])
                ->make(true);
        }

        return view('admindesk.plans.index');

    }

    public function create()
    {

        abort_if(env('ENABLE_SELLER_SUBS_SYSTEM') == 0, 404);

        $defaultCurrency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract', function ($query) {

            return $query->where('default_currency', '1');

        })->first();

        return view('admindesk.plans.create', compact('defaultCurrency'));

    }

    public function edit($id)
    {

        $plan = SellerPlans::firstWhere('unique_id', $id);

        if (!$plan) {
            notify()->error('Plan not found !', '404');
            return redirect(route('seller.subs.plans.index'));
        }

        $defaultCurrency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract', function ($query) {

            return $query->where('default_currency', '1');

        })->first();

        return view('admindesk.plans.edit', compact('plan', 'defaultCurrency'));

    }

    public function store(Request $request)
    {

        abort_if(env('ENABLE_SELLER_SUBS_SYSTEM') == 0, 404);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'validity' => 'required|numeric',
            'period' => 'required|string',
            'product_create' => 'required|numeric',
        ]);

        $input = $request->all();

        $input['unique_id'] = Str::uuid();
        $input['status'] = $request->status ? 1 : 0;
        $input['csv_product'] = $request->csv_product ? 1 : 0;

        SellerPlans::create($input);

        notify()->success('Plan created !', $request->name);

        return redirect(route('seller.subs.plans.index'));

    }

    public function update(Request $request, $id)
    {

        abort_if(env('ENABLE_SELLER_SUBS_SYSTEM') == 0, 404);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'validity' => 'required|numeric',
            'period' => 'required|string',
            'product_create' => 'required|numeric',
        ]);

        $plan = SellerPlans::find($id);

        if (!$plan) {
            notify()->error('Plan not found !', '404');
            return redirect(route('seller.subs.plans.index'));
        }

        $input = $request->all();

        $input['status'] = $request->status ? 1 : 0;
        $input['csv_product'] = $request->csv_product ? 1 : 0;

        $plan->update($input);

        notify()->success('Plan updated !', $request->name);

        return redirect(route('seller.subs.plans.index'));

    }

    public function frontendplans(){

        abort_if(auth()->user()->role_id == 'a' || auth()->user()->role_id == 'u', 404);
        abort_if(env('ENABLE_SELLER_SUBS_SYSTEM') == 0, 404);
        abort_if(!auth()->user()->store, 404);

        $plans = SellerPlans::where('status','1')->get();

        require 'price.php';

        return view('front.sellerplans.list',compact('plans','conversion_rate'));

    }

    public function paymentscreen(Request $request){

        $plan = SellerPlans::firstWhere('unique_id',Crypt::decrypt($request->planid));

        if(!$plan){
            notify()->error('Plan not found','404');
            return back();
        }

        require 'price.php';

        return view('front.sellerplans.payment',compact('plan','conversion_rate'));

    }

    public function listofsubscribers(){
        
         $data =  SellerSubscription::with(['user','plan' => function($q){
            return $q->select('id','name');
        }])->whereHas('plan')->whereHas('user');

        if (request()->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('plan_name',function($row){
                    return '<b>'.$row->plan->name.'</b>';
                })
                ->editColumn('amount',function($row){
                    return '<b>'.$row->paid_currency.' '.$row->paid_amount.'</b>';
                })
                ->editColumn('user',function($row){
                    return '<b>'.$row->user->name .' ('.$row->user->email.')'.'</b>';
                })
                ->addColumn('start_date',function($row){
                    return date('d-m-Y | h:i A',strtotime($row->start_date));
                  })
                  ->addColumn('end_date',function($row){
                    return date('d-m-Y | h:i A',strtotime($row->end_date));
                })
                ->editColumn('status',function($row){
                    if ($row->status == 1) {
                        return '<span class="label label-success">Active</span>';
                    } else {
                        return '<span class="label label-danger">Deactive</span>';
                    }
                })
                ->editColumn('action','admindesk.subscription.action')
                ->rawColumns(['plan_name', 'amount','user','start_date', 'end_date', 'status','action'])
                ->make(true);
        }

        return view('admindesk.subscription.index');

    }

    public function destroy($id){

        $plan = SellerPlans::firstWhere('unique_id',$id);

        if(!$plan){
            notify()->error('Plan not found','404');
            return back();
        }
        

        $plan->subscriptions()->delete();

        $plan->delete();

        

        notify()->success('Plan deleted','Success');
           
        return back();

    }

    public function deleteSubscription($id){

       $data =  SellerSubscription::find($id);

       if(!$data){
            notify()->success('Subscription not found !','404');
            return back(); 
       }

       $data->delete();

       notify()->success('Subscription deleted !');

       return back();

    }
}
