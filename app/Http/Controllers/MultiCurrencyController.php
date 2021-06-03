<?php
namespace App\Http\Controllers;

use App\Allcountry;
use App\AutoDetectGeo;
use App\CurrencyCheckout;
use App\CurrencyNew;
use App\Location;
use App\ManualPaymentMethod;
use App\multiCurrency;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MultiCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $all_country = Allcountry::join('countries', 'countries.country', '=', 'allcountry.iso3')->select('allcountry.*')->get();

        $check_cur = multiCurrency::wherehas('currency')->with('currencyLocationSettings')->with('checkoutCurrencySettings')->get();

        $manualpaymentmethods = ManualPaymentMethod::where('status', '1')->get();

        $auto_geo = AutoDetectGeo::first();

        if ($request->ajax()) {
            $currencies = CurrencyNew::with('currencyextract');
            return DataTables::of($currencies)
                ->addIndexColumn()
                ->addcolumn('code', function ($row) {
                    $html = $row->code;

                    if (isset($row->currencyextract) && $row->currencyextract->default_currency == 1) {
                        $html .= " <span class='label label-success'>Default</span>";
                    }

                    return $html;

                })
                ->addColumn('rate', function ($row) {
                    return $row->exchange_rate;
                })
                ->addColumn('additional_amount', function ($row) {
                    return isset($row->currencyextract) ? $row->currencyextract->add_amount : 0;
                })
                ->editColumn('symbol', function ($row) {
                    $symbol = $row->currencyextract['currency_symbol'];
                    return "<i class='$symbol'></i>";
                })
                ->editColumn('action', 'admindesk.multiCurrency.action')
                ->rawColumns(['code', 'rate', 'additional_amount', 'symbol', 'action'])
                ->make(true);
        }

        

        return view('admindesk.multiCurrency.index', compact('auto_geo', 'all_country', 'check_cur', 'manualpaymentmethods'));
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
            'code' => 'required|string|max:3',
        ], [
            'code.required' => 'Currency code is required',
            'code.string' => 'Currency code should not be numeric',
            'code.max' => 'Currency code cannot be greater than 3',
        ]);

        try {

            Artisan::call('currency:manage add ' . $request->code);

            $output = Artisan::output();

            if (!strstr($output, 'success')) {
                return back()->withErrors($output)->withInput();
            }

            $currency = CurrencyNew::firstWhere('code', $request->code);

            $currency->currencyextract()->updateorCreate([

                'id' => $currency->id,

            ], [
                'add_amount' => isset($request->add_amount) ? $request->add_amount : 0.00,
                'currency_symbol' => $request->currency_symbol,
                'default_currency' => 0,
                'position' => $request->position,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Artisan::call('currency:update -o');

            notify()->success('Added', "Currency $request->code added !");

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return back()
            ->with("category_message", "Currency Has Been Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\multiCurrency  $multiCurrency
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $currency = DB::table('currency_list')->where('id', $request->currency_id)
            ->first();

        $currency = multiCurrency::where('id', $request->id)
            ->update(array(
                'currency_id' => $request->currency_id,
            ));

        return response()
            ->json(array(
                'id' => $currency->id,
                'code' => $currency->code,
            ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\multiCurrency  $multiCurrency
     * @return \Illuminate\Http\Response
     */
    public function edit(multiCurrency $multiCurrency)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\multiCurrency  $multiCurrency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {

        $currency = CurrencyNew::where('code', '=', $code)->first();

        if ($currency) {

            if (isset($currency->currencyextract)) {

                $currency->currencyextract()->update([
                    'currency_symbol' => $request->currency_symbol,
                    'add_amount' => $request->add_amount,
                    'position' => $request->position,
                ]);

            } else {
                $currency->currencyextract()->create([
                    'currency_id' => $currency->id,
                    'add_amount' => isset($request->add_amount) ? $request->add_amount : 0.00,
                    'currency_symbol' => $request->currency_symbol,
                    'default_currency' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            notify()->info("Currency $currency->code updated !", 'Updated');
            return back();

        } else {
            return back()->with('warning', '404 | Currency not found !');
        }

    }

    public function auto_update_currency(Request $request)
    {

        if ($request->ajax()) {

            try {
                Artisan::call('currency:update -o');
                return response()->json('Auto Update Successfully !');
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\multiCurrency  $multiCurrency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $obj = multiCurrency::find($id);

        if ($obj->checkoutCurrencySettings) {
            $obj->checkoutCurrencySettings->delete();
        }

        if ($obj->currencyLocationSettings) {
            $obj->currencyLocationSettings->delete();
        }

        currency()->delete($obj->currency->code);

        $obj->delete();
        notify()->error('Currency Deleted Successfully !');
        return back();
    }

    public function addLocation(Request $request)
    {

        $currs = multiCurrency::all();
        foreach ($currs as $curr) {
            $id = "country" . $curr->id;
            $multi_curr = "multi_curr" . $curr->id;
            $multi_currency = "multi_currency" . $curr->id;

            if ($request->auto_detect == 'on') {
                $geo = '1';
            } else {
                $geo = '0';
            }

            $check_loc = Location::where('multi_currency', $curr->id)
                ->first();
            if (!empty($check_loc)) {

                if (!empty($request->$id)) {
                    $child_cat = implode(",", $request->$id);
                    Location::where('multi_currency', $curr->id)
                        ->update(array(
                            'currency' => $request->$multi_curr,
                            'country_id' => $child_cat,
                            'multi_currency' => $request->$multi_currency,

                        ));
                } else {
                    Location::where('multi_currency', $curr->id)
                        ->update(array(
                            'currency' => $request->$multi_curr,
                            'country_id' => $request->$id,
                            'multi_currency' => $request->$multi_currency,

                        ));
                }

            } else {

                if (is_array($request[$id])) {

                    if (!empty($request->$id)) {
                        $child_cat = implode(",", $request->$id);
                        Location::insert(array(
                            'currency' => $request->$multi_curr,
                            'country_id' => $child_cat,

                            'multi_currency' => $request->$multi_currency,

                        ));
                    } else {
                        Location::insert(array(
                            'currency' => $request->$multi_curr,
                            'country_id' => $request->$id,

                            'multi_currency' => $request->$multi_currency,

                        ));
                    }
                }

            }

        }

        return back()->with('updated', 'Currency Setting Updated !');

    }

    public function editLocation(Request $request)
    {

        $child_cat = implode(",", $request->country);
        Location::where('multi_currency', $request->id)
            ->update(array(

                'country_id' => $child_cat,
                'currency' => $request->currency,

            ));

    }

    public function deleteLocation($id)
    {
        $obj = Location::where('multicurrency', $id)->first;
        $obj->delete();
        return back();
    }

    public function auto_change(Request $request)
    {

        $g = multiCurrency::where('id', $request->id)
            ->update(array(
                $request->name => $request->value,
            ));
        if ($g) {
            return "save";
        } else {
            return "try agin";
        }

    }

    public function auto_detect_location(Request $request)
    {

        $myip = $_SERVER['REMOTE_ADDR'];
        $ip = geoip()->getLocation($myip);

        $auto_detect = AutoDetectGeo::first();
        if (isset($auto_detect)) {
            if ($request->auto != null) {
                if ($request->auto == 1) {
                }
                AutoDetectGeo::where('id', '1')
                    ->update(array(
                        'auto_detect' => $request->auto,

                    ));
            } else if ($request->currencybyc != null) {
                AutoDetectGeo::where('id', '1')
                    ->update(array(

                        'currency_by_country' => $request->currencybyc,
                    ));
            } else if ($request->country_id != null) {

                if ($request->country_id == 0) {
                    $default_geo_location = null;
                } else {
                    $default_geo_location = $request->country_id;
                }
                AutoDetectGeo::where('id', '1')
                    ->update(array(

                        'default_geo_location' => $default_geo_location,

                    ));
            } else if ($request->checkout_currency != null) {
                AutoDetectGeo::where('id', '1')
                    ->update(array(

                        'checkout_currency' => $request->checkout_currency,

                    ));
            } else if ($request->cart_page != null) {
                AutoDetectGeo::where('id', '1')
                    ->update(array(

                        'enable_cart_page' => $request->cart_page,

                    ));
            } else if ($request->enable_multicurrency != null) {
                AutoDetectGeo::where('id', '1')
                    ->update(array(

                        'enabel_multicurrency' => $request->enable_multicurrency,

                    ));
            }

        } else {
            AutoDetectGeo::insert(array(
                'auto_detect' => $request->auto,

                'currency_by_country' => $request->currencybyc,
            ));
        }

        $flag = strtolower($ip->iso_code);

        $flag_url = url('/admindesk/flags/4x3/' . $flag . '.svg');

        return response()->json(array(
            'country' => $ip->country,
            'isoCode' => $flag_url,
        ));
    }

    public function checkOutUpdate(Request $request)
    {

        echo $request->default_checkout;

        $show_checkout = CurrencyCheckout::where('multicurrency_id', $request->currencyId)
            ->first();
        if (!empty($show_checkout)) {
            if (is_array($request->payment)) {

                $payments = implode(",", $request->payment);

                CurrencyCheckout::where('multicurrency_id', $request->currencyId)
                    ->update(array(

                        'currency' => $request->currency_checkout,
                        'default' => $request->default_checkout,
                        'checkout_currency' => $request->checkout_currency_status,
                        'payment_method' => $payments,
                        'multicurrency_id' => $request->currencyId,

                    ));
            } else {

                CurrencyCheckout::where('multicurrency_id', $request->currencyId)
                    ->update(array(

                        'currency' => $request->currency_checkout,
                        'default' => $request->default_checkout,
                        'checkout_currency' => $request->checkout_currency_status,
                        'payment_method' => $request->payment,
                        'multicurrency_id' => $request->currencyId,

                    ));
            }
        } else {
            if (is_array($request->payment)) {

                $payments = implode(",", $request->payment);
                CurrencyCheckout::insert(array(
                    'currency' => $request->currency_checkout,
                    'default' => $request->default_checkout,
                    'checkout_currency' => $request->checkout_currency_status,
                    'payment_method' => $payments,
                    'multicurrency_id' => $request->currencyId,
                ));
            } else {

                CurrencyCheckout::insert(array(
                    'currency' => $request->currency_checkout,
                    'default' => $request->default_checkout,
                    'checkout_currency' => $request->checkout_currency_status,
                    'payment_method' => $request->payment,
                    'multicurrency_id' => $request->currencyId,
                ));
            }

        }

    }

    public function defaul_check_checkout(Request $request)
    {

        CurrencyCheckout::where('multicurrency_id', '<>', $request->id)
            ->update(array(

                'default' => '0',
            ));
        CurrencyCheckout::where('multicurrency_id', $request->id)
            ->update(array(

                'default' => $request->default_checkout,

            ));
    }

}
