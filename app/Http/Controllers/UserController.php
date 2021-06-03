<?php

namespace App\Http\Controllers;

use App\Allcity;
use App\Allcountry;
use App\Allstate;
use App\Country;
use App\CurrencyNew;
use App\Genral;
use App\Http\Controllers\Subs\PaymentController;
use App\SellerPlans;
use App\Store;
use App\User;
use Avatar;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Image;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin');
        $this->wallet_system = Genral::first()->wallet_enable;
    }

    public function index(Request $request)
    {
        if(!$request->get('filter')){
            notify()->error('Invalid URL');
            return redirect('/myadmin');
        }

        
        if ($request->get('filter') == 'admindesk') {
            
            if($request->get('q')){
                $users = User::where('role_id', '=', 'a')->where('name', 'LIKE', '%' . $request->get('q') . '%')->orWhere('email', 'LIKE', '%' . $request->get('q') . '%')->orderBy('id','DESC')->paginate(12);
            }else{
                $users = User::where('role_id', '=', 'a')->orderBy('id','DESC')->paginate(12);
            }

        }elseif ($request->get('filter') == 'sellers') {
            if($request->get('q')){
                $users = User::where('role_id', '=', 'v')->where('name', 'LIKE', '%' . $request->get('q') . '%')->orWhere('email', 'LIKE', '%' . $request->get('q') . '%')->orderBy('id','DESC')->paginate(12);
            }else{
                $users = User::where('role_id', '=', 'v')->orderBy('id','DESC')->paginate(12);
            }
        }elseif ($request->get('filter') == 'customer') {
            if($request->get('q')){
                $users = User::where('role_id', '=', 'u')->where('name', 'LIKE', '%' . $request->get('q') . '%')->orWhere('email', 'LIKE', '%' . $request->get('q') . '%')->orderBy('id','DESC')->paginate(12);
            }else{
                $users = User::where('role_id', '=', 'u')->orderBy('id','DESC')->paginate(12);
            }
            
        }else{
            notify()->error('Invalid URL');
            return redirect('/myadmin');
        }
       
        return view("admindesk.user.show", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $country = Allcountry::join('countries','countries.country','=','allcountry.iso3')->select('allcountry.*')->get(); 
        return view("admindesk.user.add_user", compact("country"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'image' => 'mimes:jpeg,jpg,png,bmp,gif',
        ]);

        $input = $request->all();

        $u = new User;

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/user/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image);

            $input['image'] = $image;

            $input['password'] = Hash::make($request->password);

        }

        $input['password'] = Hash::make($request->password);

        $u->create($input);

        notify()->success('User added',$request->name);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $country = Allcountry::join('countries','countries.country','=','allcountry.iso3')->select('allcountry.*')->get(); 
        $states = Allstate::where('country_id', $user->country_id)->get();
        $citys = Allcity::where('state_id', $user->state_id)->get();
        $plans = SellerPlans::where('status','1')->get();
        return view("admindesk.user.edit", compact("country","user", "states", "citys","plans"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'image' => 'mimes:jpeg,jpg,png,bmp,gif',
        ]);

        $input = $request->all();

        if (isset($request->is_pass_change)) {
            $this->validate($request, [
                'password' => 'required|between:6,255|confirmed',
                'password_confirmation' => 'required',
            ]);
            $newpass = Hash::make($request->password);
            $input['password'] = $newpass;

        } else {
            $input['password'] = $user->password;
        }

        if ($file = $request->file('image')) {

            if ($user->image != '' && file_exists(public_path() . '/images/user/' . $user->image)) {
                unlink(public_path() . '/images/user/' . $user->image);
            }

            $optimizeImage = Image::make($request->file('image'));
            $optimizePath = public_path() . '/images/user/';
            $name = time() . $file->getClientOriginalName();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $name, 72);
            $input['image'] = $name;

        }

        if(isset($request->wallet_status) && isset($user->wallet)) {
            $user->wallet()->update(['status' => '1']);
        } else {
            $user->wallet()->update(['status' => '0']);
        }

       

        if(env('ENABLE_SELLER_SUBS_SYSTEM') == 1){

            $defaultCurrency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract', function ($query) {

                return $query->where('default_currency', '1');
    
            })->first();

            if($request->seller_plan){

                $plan = SellerPlans::find($request->seller_plan);

                

                if($user->activeSubscription){
                    if($user->activeSubscription->plan->id != $plan->id){
                   
                        if($plan){
    
                            $txn_id = str_random(10);
    
                            $subs = new PaymentController;
    
                            $payment = $subs->createsubscription($plan,$txn_id,$paidamount = $plan->price,$method = 'By Admin',$user,$currency = $defaultCurrency->code);
    
                            $input['subs_id'] = $payment->id;
    
                        }
                    }
                }else{
                    if($plan){
    
                        $txn_id = str_random(10);

                        $subs = new PaymentController;

                        $payment = $subs->createsubscription($plan,$txn_id,$paidamount = $plan->price,$method = 'By Admin',$user,$currency = $defaultCurrency->code);

                        $input['subs_id'] = $payment->id;

                    }
                }

            }
            
        }else{
            $input['subs_id'] = NULL;
        }

        $user->update($input);

        notify()->success('details has been updated',"$user->name");

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->image != null && file_exists(public_path() . '/images/user/' . $user->image)) {
            unlink(public_path() . '/images/user/' . $user->image);
        }

        if ($this->wallet_system == 1 && isset($user->wallet)) {

            $user->wallet->wallethistory()->delete();
            $user->wallet->delete();

        }

        $value = $user->delete();

        if ($value) {
            notify()->error("User has been deleted !");
            return back();
        }
    }


    public function appliedform(Request $request)
    {
        $stores = \DB::table('stores')->join('allcities', 'allcities.id', '=', 'stores.city_id')->join('allstates', 'stores.state_id', '=', 'allstates.id')->join('allcountry', 'allcountry.id', '=', 'stores.country_id')->join('users', 'users.id', '=', 'stores.user_id')->select('stores.*', 'allcities.pincode as pincode', 'allcities.name as city', 'allstates.name as state', 'allcountry.name as country', 'users.name as username')->where('stores.apply_vender', '=', '0')->get();

        if ($request->ajax()) {
            return FacadesDataTables::of($stores)->addIndexColumn()
                ->addColumn('detail', function ($row) {
                    $html = '';
                    $html .= "<p><b>Store Name:</b> $row->name</p>";
                    $html .= "<p><b>Requested By:</b> $row->username</p>";
                    $html .= "<p><b>Address:</b> $row->address,</p>";
                    $html .= "<p><b>Store Location:</b> $row->city, $row->state, $row->country</p>";
                    if ($row->pincode) {
                        $html .= "<p><b>Pincode:</b> $row->pincode</p>";
                    } else {
                        $html .= "<p><b>Pincode:</b> - </p>";
                    }

                    return $html;
                })
                ->addColumn('document', function ($row) {
                    return '<a target="__blank" href="'.url('/images/store/document/'.$row->document).'" title="Download document">View attachment</a>';
                })
                ->addColumn('requested_at', function ($row) {
                    return '<b>' . date("d-M-Y | h:i A", strtotime($row->created_at)) . '</b>';
                })
                ->addColumn('action', 'admindesk.user.requestaction')
                ->rawColumns(['detail', 'document','requested_at', 'action'])
                ->make(true);
        }

        return view("admindesk.user.appliyed_vender")->withList(count($stores));
    }

    public function choose_country(Request $request)
    {

        $id = $request['catId'];

        $country = Allcountry::findOrFail($id);
        $upload = Allstate::where('country_id', $id)->pluck('name', 'id')->all();

        return response()->json($upload);
    }

    public function choose_city(Request $request)
    {

        $id = $request['catId'];

        $state = Allstate::findOrFail($id);
        $upload = Allcity::where('state_id', $id)->pluck('name', 'id')->all();

        return response()->json($upload);
    }

}
