<?php

namespace App\Http\Controllers;

use App\Allcity;
use App\Allstate;
use App\City;
use App\Country;
use App\Mail\StoreCreated;
use App\Order;
use App\State;
use App\Store;
use App\User;
use Avatar;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Image;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $stores = Store::leftjoin('allcities', function ($join) {
            $join->on('allcities.id', '=', 'stores.city_id');
        })
            ->leftjoin('allstates', function ($join) {
                $join->on('stores.state_id', '=', 'allstates.id');
            })
            ->leftjoin('allcountry', function ($join) {
                $join->on('allcountry.id', '=', 'stores.country_id');
            })
            ->join('users', 'users.id', '=', 'stores.user_id')
            ->select('stores.*', 'allcities.name as city', 'allstates.name as state', 'allcountry.name as country', 'users.name as username')->get();

        if ($request->ajax()) {
            return DataTables::of($stores)
                ->addIndexColumn()
                ->addColumn('logo', function ($row) {
                    $image = @file_get_contents('../public/images/store/' . $row->store_logo);
                    if ($image) {
                        $logo = '<img width="70px" height="70px" src="' . url("images/store/" . $row->store_logo) . '"/>';
                    } else {
                        $logo = '<img width="70px" height="70px" src="' . Avatar::create($row->name)->toBase64() . '"/>';
                    }

                    return $logo;

                })
                ->addColumn('info', function ($store) {

                    $html = '<p><b>Name:</b> <span class="font-weight500">' . $store->name . '</span></p>';
                    $html .= '<p><b>Email:</b> <span class="font-weight500">' . $store->email . '</span></p>';
                    $html .= '<p><b>Mobile:</b> <span class="font-weight500">' . $store->mobile . '</span></p>';
                    $html .= '<p><b>Address:</b> <span class="font-weight500">' . $store->address . ' ,' . $store->city . ' ,' . $store->state . ' ,' . $store->country . '</p>';

                    if ($store->verified_store == 1) {
                        $html .= '<p><b>Verfied Store: </b> <span class="label label-success"><i class="fa fa-check-circle"></i> Verified</span></p>';
                    } else {
                        $html .= '<p><b>Verified Store: </b> <span class="label label-danger">Not Verified</span></p>';
                    }

                    return $html;

                })
                ->editColumn('status', 'admindesk.store.status')
                ->editColumn('apply', 'admindesk.store.applybtn')
                ->addColumn('rd', function ($store) {
                    if ($store->rd == '0') {
                        $btn = '<span class="label label-success">Not Received</span>';
                    } else {
                        $btn = '<span class="label label-danger">Received</span>';
                    }

                    return $btn;
                })
                ->editColumn('action', 'admindesk.store.action')
                ->rawColumns(['logo', 'info', 'status', 'apply', 'rd', 'action'])
                ->make(true);

        }

        return view("admindesk.store.index", compact("stores"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countrys = Country::all();
        $states = State::all();
        $citys = City::all();
        $users = User::where('status', '1')->get();
        return view("admindesk.store.add", compact("states", "countrys", "citys", "users"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->validate($request, [
            "name" => "required",
            "mobile" => "required",
            'address' => "required",
            'country_id' => 'required|not_in:0',
            'state_id' => 'required|not_in:0',
            'city_id' => 'required|not_in:0',
            'store_logo' => 'mimes:jpeg,jpg,webp,png|max:2000',
            "email" => "required|unique:stores,email|email|max:255",

        ], [
            "name.required" => "Store Name is Required",
            "email.required" => "Business Email is Required",
            "mobile.required" => "Mobile No is Required",

        ]);

        $validateuser = User::find($request->user_id);

        if ($validateuser->store) {
            notify()->error('User Already have a Store !');
            return back()->withInput();
        }

        $input = $request->all();

        if ($file = $request->file('store_logo')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/';
            $store_logo = time() . $file->getClientOriginalName();
            $optimizeImage->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $store_logo, 90);

            $input['store_logo'] = $store_logo;

        }

        if ($file = $request->file('cover_photo')) {

            if(!is_dir(public_path().'/images/store/cover_photo')){
                mkdir(public_path().'/images/store/cover_photo');
            }   
            
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/cover_photo/';
            $name = 'cover_'.uniqid() .'.'.$file->getClientOriginalExtension();

            $optimizeImage->resize(1500, 440, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $name, 90);
            $input['cover_photo'] = $name;

        }

        $input['status'] = isset($request->status) ? '1' : '0';
        $input['verified_store'] = isset($request->verified_store) ? '1' : '0';
        $input['apply_vender'] = '1';
        $input['uuid']  = Store::generateUUID();

        $store =  Store::create($input);

        $validateuser->role_id = 'v';
        $validateuser->save();

        // Send mail to store owner for store created 

        try{

            if(isset($store->user->email)){
                Mail::to($store->user->email)->send(new StoreCreated($store));
            }

        }catch(\Exception $e){
            \Log::error('Failed to sent email to store owner:'.$e->getMessage());
        }
        notify()->success('Store created !',$store->name);
        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countrys = Country::all();
        $citys = Allcity::all();
        $users = User::where('role_id', 'v')->orWhere('role_id', 'a')->get();
        $store = Store::find($id);
        $states = Allstate::where('country_id', $store->country_id)->get();
        $citys = Allcity::where('state_id', $store->state_id)->get();

        $getallorder = Order::select('id', 'vender_ids')->get();
        $storeorder = array();
        foreach ($getallorder as $order) {
            if (in_array($store->user->id, $order->vender_ids)) {
                array_push($storeorder, $order);
            }
        }

        $storeordercount = count($storeorder);

        return view("admindesk.store.edit", compact("store", "countrys", "states", "citys", "users", 'storeordercount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $store = Store::find($id);

        $this->validate($request, [
            "name" => "required",
            "mobile" => "required",
            'address' => "required",
            'country_id' => 'required|not_in:0',
            'state_id' => 'required|not_in:0',
            'city_id' => 'required|not_in:0',
            'store_logo' => 'mimes:jpeg,jpg,webp,png|max:2000',
            "email" => "required|email|max:255,unique:stores,email,$id",

        ], [
            "name.required" => "Store Name is Required",
            "email.required" => "Business Email is Required",
            "mobile.required" => "Mobile No is Required",

        ]);

        $store = Store::find($id);

        if(!$store) {
            notify()->error('Store Not found !','404');
            return back();
        }

        $input = $request->all();

        if ($file = $request->file('store_logo')) {

            if ($store->store_logo != null) {

                if (file_exists(public_path() . '/images/store/' . $store->store_logo)) {
                    unlink(public_path() . '/images/store/' . $store->store_logo);
                }

            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/';
            $name = time() . $file->getClientOriginalName();
            $optimizeImage->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $name, 90);
            $input['store_logo'] = $name;

        }

        if ($file = $request->file('cover_photo')) {

            if(!is_dir(public_path().'/images/store/cover_photo')){
                mkdir(public_path().'/images/store/cover_photo');
            }   

            if ($store->cover_photo != null) {

                if (file_exists(public_path() . '/images/store/cover_photo/' . $store->cover_photo)) {
                    unlink(public_path() . '/images/store/cover_photo/' . $store->cover_photo);
                }

            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/cover_photo/';
            $name = 'cover_'.uniqid() .'.'.$file->getClientOriginalExtension();
            $optimizeImage->resize(1500, 440, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $name, 90);
            $input['cover_photo'] = $name;

        }

        $input['status'] = isset($request->status) ? "1" : "0";
        $input['verified_store'] = isset($request->verified_store) ? '1' : '0';
        $input['apply_vender'] = '1';
        $input['description'] = $request->description;

        if($store->uuid == ''){
            $input['uuid']  = Store::generateUUID();
        }

        $store->update($input);

        notify()->success('Store has been updated !',$store->name);

        return redirect('admindesk/stores');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Store::find($id);

        if ($store) {

            if ($store->logo != '' && file_exists(public_path() . '/images/store/' . $store->store_logo)) {
                unlink(public_path() . '/images/store/' . $store->store_logo);
            }

            if ($store->document != '' && file_exists(public_path() . '/images/store/document' . $store->document)) {
                unlink(public_path() . '/images/store/document' . $store->document);
            }

            $store->user()->update([
                'role_id' => 'u'
            ]);

            $store->forcedelete();
            notify()->success('Store has been deleted !');
            return back();
             
        } else {
            notify()->error('Store Not found !','404');
            return back();
        }
    }
}
