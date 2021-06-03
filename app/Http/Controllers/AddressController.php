<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Address;
use App\Allstate;
use App\Allcity;
use App\Country;
use App\Allcountry;
use Illuminate\Support\Facades\Input;
use App\PinCod;
use Session;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class AddressController extends Controller
{
    public function getaddressView()
    {
        require_once ('price.php');
         $user = Auth::user();
        $country = Country::all();
        $city = Allcity::where('state_id', $user->state_id)->get();
        return view('user.manageaddress', compact('conversion_rate', 'city', 'user', 'country'));
    }

    public function ajaxaddress(Request $request)
    {
        $flag = $request->flag;

        if ($flag == 1)
        {

            $id = Session::get('address');
            $address = Address::findorFail($id);

            return $address;

        }
    }

    public function ajaxaddressList(Request $request)
    {
        $id = $request->id;

        $address = Address::find($id);

        session()->put('ship_from_choosen_address', $id);

        return response()->json($address);

    }

    public function pincodefinder(Request $request)
    {

        $search = $request->get('term');
        $result = array();
        $query = Allcity::where('pincode', 'LIKE', '%' . $search . '%')->get();

        foreach ($query as $q)
        {
            $findcity = Allcity::where('id', $q->id)
                ->first();
            $findstate = Allstate::where('id', $q->state_id)
                ->first();
            $findcountry = Allcountry::where('id', $findstate->country_id)
                ->first();

            $result[] = ['findcountry' => $findcountry->id, 'city' => $findcity->id, 'id' => $findstate->id, 'value' => $q->pincode . ' (' . $findcity->name . ',' . $findstate->name . ')'];
        }

        return response()
            ->json($result);
    }

    public function store(Request $request)
    {

        $alladdress = Address::where('user_id', Auth::user()->id)
            ->get();

        foreach ($alladdress as $value)
        {
            if ($value->name == $request->name && $value->address == $request->address && $value->city_id == $request->city_id && $value->state_id == $request->state_id && $value->country_id == $request->country_id && $request->pin_code == $value->pin_code)
            {
                notify()->error('Same Address Already Stored !');
                return redirect('/checkout');
                    
            }
        }

        $input = $request->all();

        $input['address'] = clean($request->address);

        $new_address = new Address;

        $findalladdress = Address::where('user_id', Auth::user()->id)
            ->where('defaddress', '=', 1)
            ->first();

        if (isset($request->setdef))
        {

            if (isset($findalladdress))
            {
                Address::where('user_id', Auth::user()->id)
                    ->where('defaddress', '=', 1)
                    ->update(['defaddress' => 0]);
            }

            $input['defaddress'] = 1;
        }
        else
        {
            $input['defaddress'] = 0;
        }

        $input['user_id'] = Auth::user()->id;
        $input['address'] = strip_tags($request->address);
        $new_address->create($input);
        notify()->success('Address added successfully !');
        return back();
    }

    public function store2(Request $request)
    {

        $input = $request->all();

        $new_address = new Address;

        $input['address'] = strip_tags($request->address);

        $findalladdress = Address::where('user_id', Auth::user()->id)
            ->where('defaddress', '=', 1)
            ->first();

        $alladdress = Address::where('user_id', Auth::user()->id)
            ->get();

        foreach ($alladdress as $value)
        {
            if ($value->name == $request->name && $value->address == $request->address && $value->city_id == $request->city_id && $value->state_id == $request->state_id && $value->country_id == $request->country_id && $request->pin_code == $value->pin_code)
            {
                notify()->error('Same Address Already Stored !');
                return redirect('/checkout');
            }
        }

        if (isset($request->setdef))
        {

            if (isset($findalladdress))
            {
                Address::where('user_id', Auth::user()->id)
                    ->where('defaddress', '=', 1)
                    ->update(['defaddress' => 0]);
            }

            $input['defaddress'] = 1;
        }
        else
        {
            $input['defaddress'] = 0;
        }

        $input['user_id'] = Auth::user()->id;
        $new_address->create($input);
        notify()->success('Address added successfully !');
        return redirect('/checkout');
    }

    public function store3(Request $request)
    {

        #validation
        $input = $request->all();
        require_once ('price.php');

        $flag = 0;
        $alladdress = Address::where('user_id', Auth::user()->id)
            ->get();

        foreach ($alladdress as $value)
        {

            if ($value->name == $request->name && $value->address == $request->address && $value->city_id == $request->city_id && $value->state_id == $request->state_id && $value->country_id == $request->country_id && $request->pin_code == $value->pin_code)
            {
                $request->name;
                $sentfromlastpage = 1;
                $flag = 1;

            }
        }

        ##end
        

        if ($flag == 1)
        {
            notify()->error('Same address already stored !');
            return view('front.checkout', compact('conversion_rate', 'sentfromlastpage'));
        }
        else
        {

            $new_address = new Address;

            $findalladdress = Address::where('user_id', Auth::user()->id)
                ->where('defaddress', '=', 1)
                ->first();

            if (isset($request->setdef))
            {

                if (isset($findalladdress))
                {
                    Address::where('user_id', Auth::user()->id)
                        ->where('defaddress', '=', 1)
                        ->update(['defaddress' => 0]);
                }

                $input['defaddress'] = 1;
            }
            else
            {
                $input['defaddress'] = 0;
            }

            $input['user_id'] = Auth::user()->id;
            $input['address'] = strip_tags($request->address);
            $new_address->create($input);
            $sentfromlastpage = 1;
            notify()->success('Address added successfully ! !');
            return view('front.checkout', compact('conversion_rate', 'sentfromlastpage'));
        }

    }

    public function update(Request $request, $id)
    {

        $new_address = Address::findorFail($id);

        $input = $request->all();

        $alladdress = Address::where('user_id', Auth::user()->id)
            ->get();

        $match = 0;

        foreach ($alladdress as $value)
        {

            if ($value->id != $new_address->id)
            {
                if ($value->name == $request->name || $value->address == $request->address || $value->city_id == $request->city_id || $value->state_id == $request->state_id || $value->country_id == $request->country_id && $request->pin_code == $value->pin_code)
                {
                    $match = 1;
                    break;
                }
            }
            else
            {
                $match = 0;
                break;
            }

        }

        if ($match == 0)
        {
            $input['user_id'] = Auth::user()->id;
            $new_address->update($input);
        }

        $findalladdress = Address::where('user_id', Auth::user()->id)
            ->where('defaddress', '=', 1)
            ->first();

        if (isset($request->setdef))
        {

            if (isset($findalladdress) && $findalladdress->id != $id)
            {
                Address::where('user_id', Auth::user()->id)
                    ->where('defaddress', '=', 1)
                    ->update(['defaddress' => 0]);

            }

            $input['defaddress'] = 1;

        }
        else
        {
            $input['defaddress'] = 0;
        }

        $input['user_id'] = Auth::user()->id;
        $input['address'] = strip_tags($request->address);
        $new_address->update($input);
        notify()->success('Address updated successfully !');
        return back();

    }

    public function delete(Request $request, $id)
    {
        $findaddress = Address::findorFail($id);

        if ($findaddress->defaddress == 1)
        {   
            notify()->error('Default address cannot be deleted !');
            return back();
        }
        else
        {
            $findaddress->delete();
            notify()->success('Address deleted !');
            return back();
        }
    }

}

