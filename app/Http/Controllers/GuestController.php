<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Allcountry;
use App\Allstate;
use App\Allcity;
use Session;
use Crypt;
use Response;
use App\User;
use DB;
use Auth;
use App\Faq;
use App\Wishlist;
use Redirect;
use Illuminate\Support\MessageBag;
use App\Cart;
use App\Product;
use App\AddSubVariant;
use App\Coupan;
use Hash;
use App\Page;

class GuestController extends Controller
{

    

    public function adminLoginAs($id){
        
        $userid = Crypt::decrypt($id);
        $user = User::find($userid);

        if(isset($user)){
            Auth::login($user);
            notify()->success('Logged in as '.Auth::user()->name);
            return redirect('/');
        }else{
            return back()->with('warning','404 User Not found !');
        }
    }

    public function changelang(Request $request)
    {
        Session::put('changed_language', $request->lang);
    }

    public function sellerloginview()
    {
        return view('seller.login');
    }

    public function dosellerlogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->get('email') , 'password' => $request->get('password') ,

        ], $request->remember))
        {
            if (Auth::user()->role_id == 'v')
            {
                notify()->success('Welcome '.Auth::user()->name);
                return redirect()->intended(route('seller.dboard'));
            }
            else
            {
                Auth::logout();
                notify()->error('Access Denied !');
                return Redirect::back();
            }
        }
        else
        {
            $errors = new MessageBag(['email' => ['email' => 'Email or password is invalid or your account is deactive/ unverified.']]);
            return Redirect::back()->withErrors($errors)->withInput($request->except('password'));
            return Redirect::back();
        }
    }

    public function referfromcheckoutwindow(Request $request)
    {
        require_once ('price.php');
        return view('front.referfromchwindow', compact('conversion_rate'));
    }

    public function adminLogin(Request $request)
    {

        if (Auth::attempt(['email' => $request->get('email') , 'password' => $request->get('password') ,'is_verified' => 1, 'status' => 1

        ], $request->remember))
        {
            if (Auth::user()->role_id == 'a')
            {
                notify()->success('Welcome '.Auth::user()->name);
                return redirect()->intended(route('admindesk.main'));
            }
            else
            {
                Auth::logout();
                notify()
                    ->error('Access Denied !');
                return Redirect::back();
            }
        }
        else
        {
            $errors = new MessageBag(['email' => ['Email or password is invalid or your account is deactive/ unverified']]);
            return Redirect::back()->withErrors($errors)->withInput($request->except('password'));
            return Redirect::back();
        }
    }

    public function storereferfromcheckoutwindow(Request $request)
    {

        $request->validate(['name' => 'required', 'email' => 'email|required', 'mobile' => 'required', 'password' => 'required|min:6|max:50|confirmed', 'country_id' => 'required', 'state_id' => 'required', 'city_id' => 'required']);

        $newGuest = new User;

        $newGuest->name = $request->name;
        $newGuest->email = $request->email;
        $newGuest->mobile = $request->mobile;
        $newGuest->password = Hash::make($request->password);
        $newGuest->status = 1;
        $newGuest->country_id = $request->country_id;
        $newGuest->state_id = $request->state_id;
        $newGuest->city_id = $request->city_id;
        $newGuest->save();

        Auth::login($newGuest);

        if (Session::has('cart'))
        {

            foreach (Session::get('cart') as $key => $c)
            {

                $venderid = Product::findorFail($c['pro_id']);

                $cart = new Cart;
                $cart->user_id = Auth::user()->id;
                $cart->qty = $c['qty'];
                $cart->pro_id = $c['pro_id'];
                $cart->variant_id = $c['variantid'];
                $cart->ori_price = $c['varprice'];
                $cart->ori_offer_price = $c['varofferprice'];
                $cart->semi_total = $c['qty'] * $c['varofferprice'];
                $cart->price_total = $c['qty'] * $c['varprice'];
                $cart->vender_id = $venderid->vender_id;
                $cart->disamount = $c['discount'];
                $cart->distype = $c['distype'];
                $cart->save();
            }

        }

        Session::forget('cart');
        notify()->success('Create address to continue !');
        return redirect('/checkout');
    }

    public function guestregister(Request $request)
    {

        $request->validate(['name' => 'required|min:1', 'email' => 'email|required']);

        $newGuest = new User;

        $newGuest->name = $request->name;
        $newGuest->email = $request->email;
        $newGuest->password = Hash::make(str_random(8));
        $newGuest->status = 1;
        $newGuest->save();

        Auth::login($newGuest);

        if (Session::has('cart'))
        {

            foreach (Session::get('cart') as $key => $c)
            {

                $venderid = Product::findorFail($c['pro_id']);

                $cart = new Cart;
                $cart->user_id = Auth::user()->id;
                $cart->qty = $c['qty'];
                $cart->pro_id = $c['pro_id'];
                $cart->variant_id = $c['variantid'];
                $cart->ori_price = $c['varprice'];
                $cart->ori_offer_price = $c['varofferprice'];
                $cart->semi_total = $c['qty'] * $c['varofferprice'];
                $cart->price_total = $c['qty'] * $c['varprice'];
                $cart->vender_id = $venderid->vender_id;
                $cart->disamount = $c['discount'];
                $cart->distype = $c['distype'];
                $cart->save();
            }

        }

        if(session()->has('coupanapplied')){

            $cpn = Coupan::firstWhere('code','=',session()->get('coupanapplied')['code']);

            if(isset($cpn)){

                $applycoupan = new CouponApplyController;

                if(session()->get('coupanapplied')['appliedOn'] == 'category'){
                    $applycoupan->validCouponForCategory($cpn);
                }

                if(session()->get('coupanapplied')['appliedOn'] == 'cart'){
                    $applycoupan->validCouponForCart($cpn);
                }

                if(session()->get('coupanapplied')['appliedOn'] == 'product'){
                    $applycoupan->validCouponForProduct($cpn);
                }

                Session::forget('coupanapplied');
            }

        }

        Session::forget('cart');
        notify()->success('Create address to continue !');
        return redirect('/checkout');
    }

    public function cartlogin(Request $request)
    {

        //do login and send cart item to db cart
        if (Auth::attempt(array(
            'email' => $request->get('email') ,
            'password' => $request->get('password')
        )))
        {

            session(['email' => $request->get('email') ]);

            if (!empty(Session::get('cart')))
            {

                $SessionCart = Session::get('cart');

                foreach (Session::get('cart') as $key => $c)
                {

                    $venderid = Product::findorFail($c['pro_id']);

                    if (count(Auth::user()->cart) > 0)
                    {

                        $x = Cart::where('variant_id', $SessionCart[$key]['variantid'])->first();

                        if (isset($x))
                        {

                            $findvar = AddSubVariant::find($c['variantid']);

                            if ($findvar->max_order_qty == '')
                            {

                                if ($findvar->stock > 0)
                                {

                                    $newqty = $x->qty + $c['qty'];
                                    $newofferprice = $c['qty'] * $c['varofferprice'];
                                    $newprice = $c['qty'] * $c['varprice'];

                                    Cart::where('user_id', Auth::user()->id)
                                        ->where('variant_id', $c['variantid'])->update(['qty' => $newqty, 'semi_total' => $newofferprice, 'price_total' => $newprice]);

                                }

                            }

                        }
                        else
                        {

                            $cart = new Cart;
                            $cart->user_id = Auth::user()->id;
                            $cart->qty = $c['qty'];
                            $cart->pro_id = $c['pro_id'];
                            $cart->variant_id = $c['variantid'];
                            $cart->ori_price = $c['varprice'];
                            $cart->ori_offer_price = $c['varofferprice'];
                            $cart->semi_total = $c['qty'] * $c['varofferprice'];
                            $cart->price_total = $c['qty'] * $c['varprice'];
                            $cart->vender_id = $venderid->vender_id;
                            $cart->disamount = $c['discount'];
                            $cart->distype = $c['distype'];
                            $cart->save();

                        }

                    }
                    else
                    {

                        $cart = new Cart;
                        $cart->user_id = Auth::user()->id;
                        $cart->qty = $c['qty'];
                        $cart->pro_id = $c['pro_id'];
                        $cart->variant_id = $c['variantid'];
                        $cart->ori_price = $c['varprice'];
                        $cart->ori_offer_price = $c['varofferprice'];
                        $cart->semi_total = $c['qty'] * $c['varofferprice'];
                        $cart->price_total = $c['qty'] * $c['varprice'];
                        $cart->vender_id = $venderid->vender_id;
                        $cart->disamount = $c['discount'];
                        $cart->distype = $c['distype'];
                        $cart->save();

                    }

                }

            }

            if(session()->has('coupanapplied')){

                $cpn = Coupan::firstWhere('code','=',session()->get('coupanapplied')['code']);
    
                if(isset($cpn)){
    
                    $applycoupan = new CouponApplyController;
    
                    if(session()->get('coupanapplied')['appliedOn'] == 'category'){
                        $applycoupan->validCouponForCategory($cpn);
                    }
    
                    if(session()->get('coupanapplied')['appliedOn'] == 'cart'){
                        $applycoupan->validCouponForCart($cpn);
                    }
    
                    if(session()->get('coupanapplied')['appliedOn'] == 'product'){
                        $applycoupan->validCouponForProduct($cpn);
                    }
    
                    Session::forget('coupanapplied');
                }
    
            }

            Session::forget('cart');

            return redirect()
                ->intended('/checkout');
        }
        else
        {
            $errors = new MessageBag(['email' => ['Email or password is invalid.']]);
            return Redirect::back()->withErrors($errors)->withInput($request->except('password'));
            return Redirect::back();
        }

    }

    public function checkInWish(Request $request)
    {

        $findinWishlist = Wishlist::where('pro_id', '=', $request->varid)
            ->first();

        if (isset($findinWishlist))
        {
            return 'InWish';
        }
        else
        {
            return 'NotInWish';
        }
    }

    public function showpage($slug)
    {
        require_once ('price.php');

        $page = Page::where('status', '=', '1')->where('slug', '=', $slug)->first();

        if($page){
            return view('front.singlepage', compact('conversion_rate', 'page'));
        }else{
            notify()->error('Requested Page Not Found !');
            return redirect('/');
        }
        
    }

    public function faq()
    {
        require_once ('price.php');
        $faqs = Faq::where('status', '1')->orderBy('id', 'desc')
            ->paginate(10);
        return view('front.faq', compact('conversion_rate', 'faqs'));
    }

    public function getPinAddress(Request $request)
    {

        $term = $request->get('term');

        $result = array();

        if (Auth::check())
        {
            $queries = DB::table('addresses')->where('user_id', Auth::user()
                ->id)
                ->where('pin_code', 'LIKE', '%' . $term . '%')->get();
        }

        $queries2 = DB::table('allcities')->where('pincode', 'LIKE', '%' . $term . '%')->get();

        if (Auth::check())
        {
            foreach ($queries as $q)
            {

                $address = strlen($q->address) > 100 ? substr($q->address, 0, 100) . "..." : $q->address;

                $result[] = ['pincode' => $q->pin_code, 'value' => $q->pin_code . '(' . $address . ')'];

            }
        }

        foreach ($queries2 as $qq)
        {

            $state = Allstate::find($qq->state_id);
            $country = Allcountry::find($state->country_id)->nicename;

            $result[] = ['pincode' => $qq->pincode, 'value' => $qq->pincode . '(' . $qq->name . ',' . $state->name . ',' . $country . ')'];

        }

        if (strlen($term) > 12)
        {

            return ['Invalid Pincode'];

        }
        elseif (count($result) == 0)
        {
            return ['Delivery not available for this'];
        }
        else
        {
            return Response::json($result);
        }

    }

    public function choose_state(Request $request)
    {
       
        $id = $request['catId'];

        $country = Allcountry::find($id);
        $upload = Allstate::where('country_id', $id)->pluck('name', 'id')
            ->all();

        return response()->json($upload);
    }

    public function choose_city(Request $request)
    {

        $id = $request['catId'];

        $state = Allstate::find($id);
        $upload = Allcity::where('state_id', $id)->pluck('name', 'id')
            ->all();

        return response()
            ->json($upload);
    }

    public function changeCur(Request $request)
    {

        $start = $request->start;
        $end = $request->end;

        Session::put('prev_start', $start);
        Session::put('prev_end', $end);

    }
}

