<?php

namespace App\Providers;

use App\Affilate;
use App\Allcountry;
use App\AutoDetectGeo;
use App\Brand;
use App\Category;
use App\CommissionSetting;
use App\Config;
use App\DashboardSetting;
use App\Footer;
use App\FooterMenu;
use App\Genral;
use App\Jobs\CartPriceChange;
use App\Jobs\GuestCartPriceChange;
use App\Jobs\WalletExpire;
use App\Language;
use App\Location;
use App\multiCurrency;
use App\Seo;
use App\Social;
use App\ThemeSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Paginator::useBootstrap();

        Schema::defaultStringLength(191);

        // $code = @file_get_contents(public_path() . '/code.txt');

        // if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //     $ip_address = @$_SERVER['HTTP_CLIENT_IP'];
        // }
        // //whether ip is from proxy
        // elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //     $ip_address = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        // }
        // //whether ip is from remote address
        // else {
        //     $ip_address = @$_SERVER['REMOTE_ADDR'];
        // }

        // $d = \Request::getHost();
        // $domain = str_replace("www.", "", $d);

        // if ($domain == 'localhost' || strstr($domain, '.test') || strstr($domain, '192.168.0') || strstr($domain, 'mediacity.co.in')) {
        //     // No Code
        // } else {
        //     Tracker::validSettings($code, $domain, $ip_address);
        // }

        try {

            \DB::connection()->getDatabaseName();

            $data = array();

            if (Schema::hasTable('genrals') && Schema::hasTable('seos') && Schema::hasTable('theme_settings')) {

                $defCurrency = multiCurrency::with('currency')->where('default_currency', '=', 1)->first();
                $rightclick = Genral::first()->right_click;
                $guest_login = Genral::first()->guest_login;
                $inspect = Genral::first()->inspect;
                $seoset = Seo::first();
                $title = Seo::first()->project_name;
                $fevicon = Genral::first()->fevicon;
                $Copyright = Genral::first()->copyright;
                $front_logo = Genral::first()->logo;
                $price_login = Genral::first()->login;
                $genrals_settings = Genral::first();
                $theme_settings = ThemeSetting::first();
                $config = Config::first();
                $wallet_system = Genral::first()->wallet_enable;
                $Api_settings = Config::first();
                $cur_setting = AutoDetectGeo::first()->enabel_multicurrency;
                $cms = CommissionSetting::first();
                $pincodesystem = Config::first()->pincode_system;
                $dashsetting = DashboardSetting::first();
                $vendor_system = Genral::first()->vendor_enable;
                $aff_system = Affilate::first();
                $footer3_widget = Footer::first();
                $social = Social::get();

                $widget3items = FooterMenu::with(['gotopage' => function ($q) {
                    return $q->select('id', 'slug');
                }])->where('widget_postion', '=', 'footer_wid_3')->where('status', '1')->get();

                $widget4items = FooterMenu::with(['gotopage' => function ($q) {
                    return $q->select('id', 'slug');
                }])->where('widget_postion', '=', 'footer_wid_4')->where('status', '1')->get();

                

                $data = array(
                    'aff_system' => $aff_system ?? '',
                    'theme_settings' => $theme_settings ?? '',
                    'defCurrency' => $defCurrency ?? '',
                    'rightclick' => $rightclick ?? '',
                    'guest_login' => $guest_login ?? '',
                    'inspect' => $inspect ?? '',
                    'seoset' => $seoset ?? '',
                    'title' => $title ?? '',
                    'fevicon' => $fevicon ?? '',
                    'Copyright' => $Copyright ?? '',
                    'front_logo' => $front_logo ?? '',
                    'price_login' => $price_login ?? '',
                    'genrals_settings' => $genrals_settings ?? '',
                    'theme_settings' => $theme_settings ?? '',
                    'config' => $config ?? '',
                    'wallet_system' => $wallet_system ?? '',
                    'Api_settings' => $Api_settings ?? '',
                    'cur_setting' => $cur_setting ?? '',
                    'auth' => $auth ?? '',
                    'cms' => $cms ?? '',
                    'pincodesystem' => $pincodesystem ?? '',
                    'dashsetting' => $dashsetting ?? '',
                    'footer3_widget' => $footer3_widget ?? '',
                    'social' => $social ?? '',
                    'brands' => Brand::where('show_image', '1')->where('status', '1')->orderBy('id', 'desc')->get(),
                    'theme' => ThemeSetting::query(),
                    'multiCurrency' => multiCurrency::with('currency')->get(),
                    'langauges' => DB::table('locales')->where('status', '=', 1)->get(),
                    'auto' => AutoDetectGeo::first(),
                    'widget3items' => $widget3items ?? '',
                    'widget4items' => $widget4items ?? '',
                    'vendor_system' => $vendor_system ?? ''
                );

                View::composer('front.checkout', function ($view) {
                    $view->with([
                        'cart_table' => Auth::user()->cart,
                    ]);
                });

                View::composer('front.layout.master', function ($view) {

                    //Run Cart Realtime updation if price of product change during when product is already in cart
                    if (!empty(session()->get('cart'))) {
                        $cart = session()->get('cart');
                        GuestCartPriceChange::dispatchNow($cart);
                    }
                    
                    $view->with([
                        'unreadnotifications' => auth()->check() ? auth()->user()->unreadnotifications()->where('n_type','!=','order_v')->count() : 0
                    ]);

                });

                View::composer('front.layout.header', function ($view) use ($data) {

                    $total = 0;

                    if (Auth::check()) {

                        $carts = Auth::user()->cart;

                        foreach ($carts as $key => $val) {

                            if ($val->semi_total != null && $val->semi_total != 0 && $val->semi_total != '') {
                                $price = $val->semi_total;
                            } else {
                                $price = $val->price_total;
                            }

                            $total = sprintf("%.2f", $total + $price);
                        }

                    } else {

                        if (!empty(session()->get('cart'))) {

                            foreach (session()->get('cart') as $key => $val) {

                                if ($val['varofferprice'] != 0) {
                                    $price = $val['qty'] * $val['varofferprice'];
                                } else {
                                    $price = $val['qty'] * $val['varprice'];
                                }

                                $total = sprintf("%.2f", $total + $price);

                            }

                        }
                    }

                    $auto = $data['auto'];

                    $searchCategories = Category::latest()->select('id', 'title')->where('status', '1')->get();

                    $manualcurrency = array();

                    if ($auto->currency_by_country == 1) {

                        $myip = $_SERVER['REMOTE_ADDR'];
                        $ip = geoip()->getLocation($myip);
                        $findcountry = Allcountry::where('iso', $ip->iso_code)->first();
                        $location = Location::all();
                        $countryArray = array();

                        foreach ($location as $value) {
                           

                            if (in_array($findcountry->id, [$value->country_id])) {
                                array_push($countryArray, $value);
                            }

                            

                        }


                        foreach ($countryArray as $cid) {
                            $c = multiCurrency::where('id', $cid->multi_currency)->first();
                            array_push($manualcurrency, $c);
                        }

                        array_push($manualcurrency, $data['defCurrency']);


                    }

                    $view->with([
                        'auto' => $auto,
                        'manualcurrency' => $manualcurrency,
                        'searchCategories' => $searchCategories,
                        'total' => $total,
                        'auth' => Auth::user(),
                    ]);
                });

                view()->composer('*', function ($view) use ($data) {

                    try {
                        $view->with([
                            'selected_language' => Language::firstWhere('lang_code','=',session()->get('changed_language') ?? config('translatable.fallback_locale')),
                            'aff_system' => $data['aff_system'],
                            'theme_settings' => $data['theme_settings'],
                            'wallet_system' => $data['wallet_system'],
                            'seoset' => $data['seoset'],
                            'cms' => $data['cms'],
                            'defCurrency' => $data['defCurrency'],
                            'dashsetting' => $data['dashsetting'],
                            'pincodesystem' => $data['pincodesystem'],
                            'cur_setting' => $data['cur_setting'],
                            'configs' => $data['config'],
                            'rightclick' => $data['rightclick'],
                            'inspect' => $data['inspect'],
                            'title' => $data['title'],
                            'fevicon' => $data['fevicon'],
                            'auth' => $data['auth'],
                            'price_login' => $data['price_login'],
                            'guest_login' => $data['guest_login'],
                            'Copyright' => $data['Copyright'],
                            'footer3_widget' => $data['footer3_widget'],
                            'front_logo' => $data['front_logo'],
                            'genrals_settings' => $data['genrals_settings'],
                            'Api_settings' => $data['Api_settings'],
                            'socials' => $data['social'],
                            'brands' => $data['brands'],
                            'theme' => $data['theme'],
                            'multiCurrency' => $data['multiCurrency'],
                            'langauges' => $data['langauges'],
                            'widget3items' => $data['widget3items'],
                            'widget4items' => $data['widget4items'],
                            'vendor_system' => $data['vendor_system']
                        ]);

                    } catch (\Exception $e) {

                    }

                });

            }

        } catch (\Exception $e) {

        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Schema::defaultStringLength(191);
    }
}
