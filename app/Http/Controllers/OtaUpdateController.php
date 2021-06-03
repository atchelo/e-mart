<?php

namespace App\Http\Controllers;

use App\Affilate;
use App\Config;
use App\CurrencyCheckout;
use App\CurrencyList;
use App\CurrencyNew;
use App\Location;
use App\multiCurrency;
use App\OfferPopup;
use App\PWASetting;
use DotenvEditor;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class OtaUpdateController extends Controller
{
    use ThrottlesLogins;

    protected $maxAttempts = 3;
    protected $decayMinutes = 1;

    public function update(Request $request)
    {

        if (config('app.version') == '1.3') {

            $output = Artisan::call('migrate --path=database/migrations/update1_3');

            $op2 = Artisan::call('migrate');

            $listofcurrency = multiCurrency::all();

            $currency = array();

            foreach ($listofcurrency as $cur) {
                array_push($currency, $cur->currency->code);
            }

            Artisan::call('currency:manage add USD');

            if (in_array('USD', $currency)) {

                foreach ($currency as $c) {
                    Artisan::call('currency:manage add ' . $c);
                }

            } else {

                foreach ($currency as $c) {

                    Artisan::call('currency:manage add ' . $c);
                }

            }

            $cur = Artisan::call('currency:update -o');

            if (strstr(env('OPEN_EXCHANGE_RATE_KEY'), '11f0cdf')) {

                $env_keys_save = DotenvEditor::setKeys([
                    'OPEN_EXCHANGE_RATE_KEY' => '',
                ]);

                $env_keys_save->save();

            }

            $add_on_field = "\nNOCAPTCHA_SITEKEY=\nNOCAPTCHA_SECRET=\nPAYSTACK_PUBLIC_KEY=\nPAYSTACK_SECRET_KEY=\nPAYSTACK_PAYMENT_URL=\nMERCHANT_EMAIL=\nOPEN_EXCHANGE_RATE_KEY=\nMESSENGER_CHAT_BUBBLE_URL";

            @file_put_contents(base_path() . '/.env', $add_on_field . PHP_EOL, FILE_APPEND);
        }

        /** version 1.4 Code */

        if (config('app.version') == '1.4') {

            $this->updateToVersion1_4();

        }

        /** version 1.5 Code */
        $this->updateToVersion1_5();

        /** version 1.6 Code */
        $this->updateToVersion1_6();

        /** version 1.7 Code */
        $this->updateToVersion1_7();

        /** version 1.8 code */

        $this->updateToVersion1_8();

        /** version 1.9 code */

        $this->updateToVersion1_9();

        /** version 2.0 code */

        $this->updateToVersion2_0();

        /** version 2.1 code */

        $this->updateToVersion2_1();

        /** version 2.2 code */

        $this->updateToVersion2_2();

        /** Verion 2.3 code */

        $this->updateToVersion2_3();

        /** Wrap up */

        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        notify()->success('Updated to version ' . config('app.version'). 'successfully !','Version '.config('app.version'));

        return redirect('/');

    }

    public function updateToVersion1_4()
    {

        Artisan::call('migrate --path=database/migrations/update1_4');

        $output = Artisan::output();

        foreach (multiCurrency::all() as $currency) {

            $r = CurrencyList::firstWhere('id', $currency->currency_id);

            $c = CurrencyNew::firstWhere('code', $r->code);

            if ($r && $c) {

                $currency->currency_id = $c->id;
                $currency->save();

            }

        }

        /** Resetting Some Settings */

        Location::truncate();
        CurrencyCheckout::truncate();

        /** Done  */

        /** Some Seeds */

        Artisan::call('db:seed --class=ThemeSettingsTableSeeder');
        Artisan::call('db:seed --class=WhatsappSettingsTableSeeder');

        /** Done */
    }

    public function updateToVersion1_5()
    {
        Artisan::call('migrate --path=database/migrations/update1_5');
        $output = Artisan::output();
    }

    public function updateToVersion1_6()
    {

        try {

            Artisan::call('migrate --path=database/migrations/update1_6');
            rename(public_path() . '/images/adv', public_path() . '/images/layoutads');

        } catch (\Exception $e) {
            \Log::error("OTA 1.6 ERROR:" . $e->getMessage());
        }

    }

    public function updateToVersion1_7()
    {

        try {

            Artisan::call('migrate --path=database/migrations/update1_7');

            if (file_exists(public_path() . '/manifest.json')) {
                unlink(public_path() . '/manifest.json');
            }

            if (file_exists(public_path() . '/sw.js')) {
                unlink(public_path() . '/sw.js');
            }

            if (Schema::hasTable('offer_popups')) {

                if (OfferPopup::count() < 1) {
                    Artisan::call('db:seed --class=OfferPopupsTableSeeder');
                }

            }

            if (Schema::hasTable('p_w_a_settings')) {

                if (PWASetting::count() < 1) {
                    Artisan::call('db:seed --class=PWASettingsTableSeeder');
                    Artisan::output();
                }

            }

        } catch (\Exception $e) {
            \Log::error("OTA 1.7 ERROR:" . $e->getMessage());
        }

        $pwa_setting = DotenvEditor::setKeys([
            'PWA_ENABLE' => 1,
            'ENABLE_PRELOADER' => 1,
        ]);

        $pwa_setting->save();

    }

    public function updateToVersion1_8()
    {

        try {

            Artisan::call('migrate --path=database/migrations/update1_8');

        } catch (\Exception $e) {
            \Log::error("OTA 1.8 ERROR:" . $e->getMessage());
        }

    }

    public function updateToVersion1_9()
    {

        try {
            
            Artisan::call('migrate --path=database/migrations/update1_9');

        } catch (\Exception $e) {
            \Log::error("OTA 1.9 ERROR:" . $e->getMessage());
        }

    }

    public function updateToVersion2_0()
    {
        try {

            Artisan::call('migrate --path=database/migrations/update2_0');

        } catch (\Exception $e) {
            \Log::error("OTA 2.0 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_1()
    {
        try {

            Artisan::call('migrate --path=database/migrations/update2_1');

        } catch (\Exception $e) {
            \Log::error("OTA 2.1 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_2()
    {
        try {

            if (file_exists(base_path() . '/database/migrations/update2_1/2021_03_22_102151_add_columns.php')) {
                unlink(base_path() . '/database/migrations/update2_1/2021_03_22_102151_add_columns.php');
            }

            Artisan::call('migrate --path=database/migrations/update2_2');

        } catch (\Exception $e) {
            \Log::error("OTA 2.2 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_3()
    {
        try {

            Artisan::call('migrate --path=database/migrations/update2_3');

            if (Affilate::count() < 1) {
                Artisan::call('db:seed --class=AffilatesTableSeeder');
            }

        } catch (\Exception $e) {
            \Log::error("OTA 2.3 ERROR:" . $e->getMessage());
        }
    }

    public function getotaview()
    {

        return view('ota.update');

    }

    public function prelogin(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password'),

                'is_verified' => 1, 'status' => 1])) {

                if (Auth::user()->role_id != 'a') {
                    Auth::logout();
                    return response()->json(['status' => 'failed', 'msg' => 'No Permission !']);
                }

                return response()->json(['status' => 'success', 'Authorization successfull...']);

            } else {
                return response()->json(['status' => 'failed', 'msg' => 'Invalid email address or wrong password !']);
            }
        }
    }
}
