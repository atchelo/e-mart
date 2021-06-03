<?php
namespace App\Http\Controllers;

use App\Allcity;
use App\Allcountry;
use App\Allstate;
use App\CanceledOrders;
use App\Charts\OrderChart;
use App\Charts\OrderDistribution;
use App\Charts\SellerPayoutLineChart;
use App\Commission;
use App\CommissionSetting;
use App\Config;
use App\Country;
use App\FullOrderCancelLog;
use App\Invoice;
use App\Order;
use App\Product;
use App\Return_Product;
use App\SellerPayout;
use App\SellerSubscription;
use App\Store;
use App\User;
use App\Vender;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\DataTables\Facades\DataTables;

class VenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       
        if (Auth::check()) {
            $auth_name = Auth::user()->name;
            $auth_id = Auth::user()->id;
        }
        $countries = Allcountry::join('countries','countries.country','=','allcountry.iso3')->select('allcountry.*')->get(); 
        $user = Auth::user();
        $store = Auth::user()->store;
        $states = Allstate::where('country_id', $store->country_id)
            ->get();
        $city = Allcity::where('state_id', $store->state_id)->get();

        return view("seller.store.edit", compact("store", "countries", "states", "city", "user", "auth_id"));
    }

    public function getInvoiceSetting(Request $request)
    {

        return view('seller.invoiceset.setting');

    }

    public function createInvoiceSetting(Request $request)
    {
        $findInvoiceSetting = Invoice::where('user_id', Auth::user()->id)
            ->first();

        if (Auth::check()) {

            if (empty($findInvoiceSetting)) {
                $createSetting = new Invoice();

                if ($file = $request->file('sign')) {
                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/sign/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name);
                    $createSetting->sign = $name;

                }

                if ($file = $request->file('seal')) {

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/seal/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name);

                    $createSetting->seal = $name;

                }

                $createSetting->user_id = Auth::user()->id;
                $createSetting->save();

                notify()->success('Invoice Setting Created !');
                return back();

            } else {
                $updateSetting = Invoice::where('user_id', Auth::user()->id)
                    ->first();
                if (Auth::user()->id == $updateSetting->user_id) {

                    if ($file = $request->file('sign')) {

                        if ($updateSetting->sign != '' && file_exists(public_path() . '/images/sign/' . $updateSetting->sign)) {
                            unlink(public_path() . '/images/sign/' . $updateSetting->sign);
                        }

                        $img = Image::make($file);

                        $destinationPath = public_path() . '/images/sign/';

                        $name = time() . $file->getClientOriginalName();

                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->save($destinationPath . $name);
                        $updateSetting->sign = $name;

                    }

                    if ($file = $request->file('seal')) {

                        if ($updateSetting->seal != '' && file_exists(public_path() . '/images/seal/' . $updateSetting->seal)) {
                            unlink(public_path() . '/images/seal/' . $updateSetting->seal);
                        }

                        $img = Image::make($file);

                        $destinationPath = public_path() . '/images/seal/';

                        $name = time() . $file->getClientOriginalName();

                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->save($destinationPath . $name);
                        $updateSetting->seal = $name;

                    }

                    $updateSetting->user_id = Auth::user()->id;
                    $updateSetting->save();
                    notify()->success('Invoice Setting Updated !');
                    return back();

                } else {

                    notify()->warning('Access denied !');
                    return redirect('/');

                }

            }

        } else {
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, ["name" => "required", "mobile" => "required", 'address' => "required", "pin_code" => "required",
        ], ["name.required" => "Store Name is Required",
            "mobile.required" => "Mobile No is Required", "pin_code.required" => "Pin Code is Required",

        ]);

        $input = $request->all();

        $auth_id = Auth::user()->id;

        $cat = Store::where('user_id', $auth_id)->where('rd', '0')->first();

        if (empty($cat)) {

            if ($file = $request->file('store_logo')) {

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/images/store/';
                $image = time() . $file->getClientOriginalName();
                $optimizeImage->save($optimizePath . $image, 72);
                $optimizeImage->resize(396, 396, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $input['store_logo'] = $image;

            }

            $input['uuid'] == Store::generateUUID();
            Store::create($input);

            notify()->success('Store created !');
            return back();

        } else {

            if ($file = $request->file('store_logo')) {

                if ($cat->store_logo != '' && file_exists(public_path() . '/images/store/' . $cat->store_logo)) {
                    unlink(public_path() . '/images/store/' . $cat->store_logo);
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/images/store/';
                $name = time() . $file->getClientOriginalName();
                $optimizeImage->save($optimizePath . $name, 72);

                $input['store_logo'] = $name;

            }

            if ($cat->uuid == '') {
                $input['uuid'] == Store::generateUUID();
            }

            $cat->update($input);
            notify()->success('Store details updated !');
            return back();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vender  $vender
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $store = Store::find($id);

        if(!$store){
            notify()->error('Your store not found !','404');
            return back();
        }

        $pincodesystem = Config::first()->pincode_system;

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:stores,email,'.$store->id,
            'mobile' => 'required|numeric',
            'address' => 'required',
            'country_id' => 'required',
            'state_id' => 'required'
        ]);

        if ($pincodesystem == 1) {

            $request->validate(['pin_code' => 'required'], ["pin_code.required" => "Pincode is required"]);

        }

        $input = $request->all();

        if ($file = $request->file('store_logo')) {

            if ($store->store_logo != '' && file_exists(public_path() . '/images/store/' . $store->store_logo)) {
                unlink(public_path() . '/images/store/' . $store->store_logo);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/';
            $name = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $name, 72);

            $input['store_logo'] = $name;

        } else {
            $input['store_logo'] = $store->store_logo;
            $store->update($input);
        }
        
        if($store->uuid == ''){
            $input['uuid']  = Store::generateUUID();
        }
        
        $store->update($input);
        notify()->success('Store details updated !',$store->name);
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Store::find($id);

        if ($store->store_logo != '' && file_exists(public_path() . '/images/store/' . $store->store_logo)) {
            unlink(public_path() . '/images/store/' . $store->store_logo);
        }

        DB::table('stores')
            ->where('id', $id)->update(['rd' => '1']);
        if ($store) {
            $auth_id = Auth::user()->id;

            DB::table('products')
                ->where('vender_id', $auth_id)->update(array(
                'status' => '0',
            ));
        }

        notify()->success('Request for delete store has been submitted !', 'Success');
        return redirect('/');
    }

    public function dashbord()
    {

        if (Auth::check() && Auth::user()->role_id == 'a') {
            return redirect(route('admindesk.main'));
        }

        $products = Product::whereHas('category')->whereHas('subvariants')->whereHas('subcategory')->whereHas('brand')->whereHas('store')->whereHas('vender')->get();


        $returnorders = Return_Product::orderBy('id', 'DESC')->get();
        $payouts = SellerPayout::where('sellerid', Auth::user()->id)
            ->count();
        $actualorder = Order::with(['user','invoices'])->whereHas('invoices')->whereHas('user')->where('status', '=', '1')->get();
        $inv_cus = Invoice::first();
        $orders = array();
        $ro2 = collect();
        $money = SellerPayout::where('sellerid', '=', Auth::user()->id)->sum('orderamount');

        /*Creating order chart*/

        $orderdata = collect();

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $totalorder = Order::whereJsonContains('vender_ids', auth()->id())
        ->select(DB::raw('DATE_FORMAT(created_at, "%M") as month'),DB::raw('count(*) as count'))
        ->where('status','1')
        ->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->get()
        ->map(function($item) use($months,$orderdata) {
                            
            foreach($months as $month){
                if($month == $item->month){
                    $orderdata->push($item->count);
                }else{
                    $orderdata->push(0);
                }
            }

            return $item;

      });


       

        $sellerorders = new OrderChart;

        $sellerorders->labels($months);

        $sellerorders->title('Total Orders In ' . date('Y'))->label('Sales')->dataset('Months', 'area', $orderdata)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0',
            'shadow' => true,
            'color' => 'rgba(44, 130, 201, 1)',
        ]);

        /*END*/

        $sellerpayouts = SellerPayout::with(['vender','singleorder'])->whereHas('vender')->whereHas('singleorder')->where('sellerid', '=', auth()->id())->get();

        /*Creating SellerPayout Chart*/

        $payoutdata = collect();

        $spayouts = SellerPayout::whereHas('vender')
                    ->whereHas('singleorder')
                    ->where('sellerid', '=', auth()->id())
                    ->select(DB::raw('DATE_FORMAT(created_at, "%M") as month'),DB::raw('count(*) as count'))
                    ->whereYear('created_at',date('Y'))
                    ->groupBy(DB::raw("MONTH(created_at)"))
                    ->groupBy(DB::raw("YEAR(created_at)"))
                    ->get()
                    ->map(function($item) use($months,$payoutdata){
                        foreach($months as $month){
                            if($month == $item->month){
                                $payoutdata->push($item->count);
                            }else{
                                $payoutdata->push(0);
                            }
                        }
            
                        return $item;
                    });

     
        $sellerpayoutdata = new SellerPayoutLineChart;

        $sellerpayoutdata->labels($months);

        $sellerpayoutdata->title('Received Payouts in ' . date('Y'))->label('Payouts')->dataset('Months', 'area', $payoutdata)->options([
            'fill' => true,
            'borderColor' => '#51C1C0',
            'shadow' => true,
            'color' => 'rgba(63, 195, 128, 1)',
        ]);

        /*End*/

        foreach ($actualorder as $value) {
            if (in_array(auth()->id(), $value->vender_ids)) {
                array_push($orders, $value);
            }
        }

        foreach ($returnorders as $key => $ro) {
            if ($ro->getorder->vender_id == auth()->id()) {
                $ro2->push($ro);
            }
        }

        $sellercanorders = collect();
        $allcanorders = CanceledOrders::orderBy('id', 'DESC')->get();
        $allfullcanceledorders = FullOrderCancelLog::orderBy('id', 'DESC')->get();
        $unreadorder = collect();
        $unreadorder2 = collect();

        /*partial cancel order section*/
        foreach ($allcanorders as $key => $value) {

            if ($value->singleOrder->vender_id == auth()->id()) {

                $sellercanorders->push($value);

            }

        }

        foreach ($sellercanorders as $key => $sorder) {

            $unreadorder->push($sorder);

        }
        /*end*/

        /*full order detect per seller section*/

        $sellerfullcanorders = collect();
        $total = 0;

        foreach ($allfullcanceledorders as $key => $forder) {
            $order = Order::find($forder->order_id);

            if (isset($order) && in_array(auth()->id(), $order->vender_ids)) {
                $sellerfullcanorders->push($forder);
            }
        }

        foreach ($sellerfullcanorders as $key => $sorder) {

            $unreadorder2->push($sorder);

        }
        /*end*/

        $partialcount = count($unreadorder);
        $partialcount2 = count($unreadorder2);

        $totalcanorders = $partialcount + $partialcount2;
        $totalreturnorders = count($ro2);

        /** Order Distribution Pie Chat */
        $fillColors2 = ['#7158e2', '#3ae374', '#ff9933'];

        // $prepaid = Order::where('payment_method', '!=', 'COD')->where('payment_method','!=','BankTransfer')->count();

        $prepaid = Order::whereJsonContains('vender_ids', Auth::user()->id)->where('payment_method', '!=', 'COD')->where('payment_method', '!=', 'BankTransfer')->where('status', '1')->count();

        $cod = Order::whereJsonContains('vender_ids', Auth::user()->id)->where('payment_method', '=', 'COD')->where('status', '1')->count();

        $bank_transfer_orders = Order::whereJsonContains('vender_ids', Auth::user()->id)->where('payment_method', '=', 'BankTransfer')->where('status', '1')->count();

        $piechart = new OrderDistribution;

        $piechart->labels(['Prepaid', 'COD', 'Bank Transfer']);

        $piechart->minimalist(true);

        $data = [$prepaid, $cod, $bank_transfer_orders];

        $piechart->title('Order Distributions')->dataset('Orders', 'pie', $data)->options([
            'fill' => 'true',
            'shadow' => true,
        ])->color($fillColors2);

        /*find store*/
        $ifstore = auth()->user()->store;

        if (!$ifstore) {
            notify()->error('Sorry Your store is not created yet ! Please apply for seller account under My account menu !');
            return back();
        }

        if ($ifstore->user->status == '0') {
            notify()->error('Your account is deactive please contact admindesk regarding this !', 'Account Deactive');
            return back();
        }

        if ($ifstore->apply_vender == '0' || $ifstore->status == '0') {
            notify()->error('Sorry Your store is not active yet ! once it will active you can start selling your items');
            return redirect('/');
        }

        return view('seller.dashbord.index', compact('money', 'payouts', 'sellerorders', 'totalreturnorders', 'orders', 'products', 'inv_cus', 'totalcanorders', 'sellerpayoutdata', 'piechart'));
    }

    public function enable()
    {
        $auth_id = auth()->id();

        $result = DB::table('stores')->where('user_id', $auth_id)->update(['rd' => '0']);

        if ($result) {
            $auth_id = Auth::user()->id;

            DB::table('products')
                ->where('vender_id', $auth_id)->update(array(
                'status' => '1',
            ));
        }

        notify()->success('Active Store');

        return back();
    }

    public function order()
    {

        
        $emptyOrder = Order::whereJsonContains('vender_ids', auth()->id())->orderBy('id','DESC')->get();

        $inv_cus = Invoice::first();

        $orderdata = collect();

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $totalorder = Order::whereJsonContains('vender_ids', auth()->id())
        ->select(DB::raw('DATE_FORMAT(created_at, "%M") as month'),DB::raw('count(*) as count'))
        ->where('status','1')
        ->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->get()
        ->map(function($item) use($months,$orderdata) {
                            
            foreach($months as $month){
                if($month == $item->month){
                    $orderdata->push($item->count);
                }else{
                    $orderdata->push(0);
                }
            }

            return $item;

      });



        $sellerorders = new OrderChart;

        $sellerorders->labels($months);

        $sellerorders->title('Total Orders In ' . date('Y'))->label('Sales')->dataset('Months', 'area', $orderdata)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0',
            'shadow' => true,
        ]);

        /*END*/

        return view('seller.order.index', compact('sellerorders', 'emptyOrder', 'inv_cus'));

    }

    public function commission()
    {

        $commissions = CommissionSetting::all();

        return view('seller.commission.index', compact('commissions'));
    }

    public function profile()
    {
        $country = Allcountry::join('countries','countries.country','=','allcountry.iso3')->select('allcountry.*')->get(); 
        $states = Allstate::where('country_id', auth()->user()->country_id)
            ->get();
        $citys = Allcity::where('state_id', auth()->user()->state_id)->pluck('name','id')->all();
        return view('seller.profile.edit', compact("country", "states", "citys"));
    }

    public function updateprofile(Request $request)
    {

        $user = User::find(auth()->id());

        $input = $request->all();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'country_id' => 'required',
            'state_id' => 'required'
        ]);

        if ($request->has('update_password')) {

            $request->validate([
                'password' => 'required|between:6,255|confirmed', 
                'password_confirmation' => 'required'
            ]);

            $newpassword = Hash::make($request->password);
            $input['password'] = $newpassword;

        }

        if ($file = $request->file('image')) {

            if ($user->image != '' && file_exists(public_path() . '/images/store/' . $user->image)) {
                unlink(public_path() . '/images/store/' . $user->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/user/';
            $name = time() . $file->getClientOriginalName();

            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $name, 90);

            $input['image'] = $name;

        }

        $user->update($input);

        notify()->success('Your Profile has been updated !');
        return back();

    }

    public function subscriptions(){

        $data = SellerSubscription::with('plan')->whereHas('plan')->where('user_id',auth()->id());

        if(request()->ajax()){
            return DataTables::of($data)
                  ->addIndexColumn()
                  ->addColumn('name',function($row){
                       return $row->plan->name;
                  })
                  ->addColumn('amount',function($row){
                      return $row->paid_currency.' '.$row->paid_amount;
                  })
                  ->addColumn('start_date',function($row){
                    return date('d-m-Y | h:i A',strtotime($row->start_date));
                  })
                  ->addColumn('end_date',function($row){
                    return date('d-m-Y | h:i A',strtotime($row->end_date));
                  })
                  ->addColumn('status',function($row){
                    if ($row->status == 1) {
                        return '<span class="label label-success">Active</span>';
                    } else {
                        return '<span class="label label-danger">Deactive</span>';
                    }
                  })
                  ->rawColumns(['status'])
                  ->make(true);
        }

        return view('seller.subscription.list');
    }

}
