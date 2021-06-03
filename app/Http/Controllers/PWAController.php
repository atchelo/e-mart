<?php

namespace App\Http\Controllers;

use App\PWASetting;
use DotenvEditor;
use Illuminate\Http\Request;
use Image;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class PWAController extends Controller
{

    public function __construct()
    {
        $pwa_settings = PWASetting::first();
        $this->pwa_settings = $pwa_settings;
    }

    public function index()
    {
        $pwa_settings = $this->pwa_settings;
        return view('admindesk.pwa.index', compact('pwa_settings'));
    }

    public function updatesetting(Request $request)
    {
        if(env('DEMO_LOCK') == 1){
            notify()->error('This action is disabled in demo !');
            return back();
        }

        $env_keys_save = DotenvEditor::setKeys([
            'PWA_ENABLE' => isset($request->PWA_ENABLE) ? "1" : "0",
            'PWA_BG_COLOR' => $request->PWA_BG_COLOR,
            'PWA_THEME_COLOR' => $request->PWA_THEME_COLOR,
        ]);


        $pwa_settings = $this->pwa_settings;

        $input = $request->all();

        $input['app_name'] = $request->app_name;

        $input['start_url'] = url('/');

        if ($file = $request->file('shorticon_1')) {

            $input['shorticon_1'] = 'cart_' . uniqid() . '.' . $request->file('shorticon_1')->getClientOriginalExtension();

            if (isset($pwa_settings) && $pwa_settings->shorticon_1 != '' && file_exists(public_path() . '/images/icons/' . $pwa_settings->shorticon_1)) {
                unlink(public_path() . '/images/icons/' . $pwa_settings->shorticon_1);
            }

            $file->move('images/icons', $input['shorticon_1']);

            $env_keys_save = DotenvEditor::setKeys([
                'SHORTCUT_ICON_CART' => url('/').'/images/icons/'.$input['shorticon_1'],
                'SHORTCUT_ICON_CART_LINK' => route('user.cart')
            ]);

        }

        if ($file = $request->file('shorticon_2')) {

            $input['shorticon_2'] = 'wishlist_' . uniqid() . '.' . $request->file('shorticon_2')->getClientOriginalExtension();

            if (isset($pwa_settings) && $pwa_settings->shorticon_2 != '' && file_exists(public_path() . '/images/icons/' . $pwa_settings->shorticon_2)) {
                unlink(public_path() . '/images/icons/' . $pwa_settings->shorticon_2);
            }

            $file->move('images/icons', $input['shorticon_2']);

            $env_keys_save = DotenvEditor::setKeys([
                'SHORTCUT_ICON_WISHLIST' => url('/').'/images/icons/'.$input['shorticon_2'],
                'SHORTCUT_ICON_WISHLIST_LINK' => route('my.wishlist')
            ]);

        }

        if ($file = $request->file('shorticon_3')) {

            $input['shorticon_3'] = 'login_' . uniqid() . '.' . $request->file('shorticon_3')->getClientOriginalExtension();

            if (isset($pwa_settings) && $pwa_settings->shorticon_3 != '' && file_exists(public_path() . '/images/icons/' . $pwa_settings->shorticon_3)) {
                unlink(public_path() . '/images/icons/' . $pwa_settings->shorticon_3);
            }

            $file->move('images/icons', $input['shorticon_3']);

            $env_keys_save = DotenvEditor::setKeys([
                'SHORTCUT_ICON_LOGIN' => url('/').'/images/icons/'.$input['shorticon_3'],
                'SHORTCUT_ICON_LOGIN_LINK' => route('login')
            ]);

        }

        if (!$this->pwa_settings) {
            $pwa = new PWASetting;
            $pwa->create($input);
        } else {
            $this->pwa_settings->update($input);
        }

        $env_keys_save->save();

        notify()->success('PWA App Setting Updated !');

        return back();

    }

    public function updateicons(Request $request)
    {

        if(env('DEMO_LOCK') == 1){
            notify()->error('This action is disabled in demo !');
            return back();
        }
        
        $pwa_settings = $this->pwa_settings;

        $input = $request->all();

        $request->validate([
            'icon_512' => 'mimes:png|max:2000',
            'splash_2048' => 'mimes:png|max:2000',
        ]);

        
        $destinationPath = public_path('/images/icons');

        if ($request->file('icon_512')) {

            ini_set('max_execution_time', -1);

            $image = $request->file('icon_512');

            $img = Image::make($image->path());


            // 512 x 512

            $icon512 = 'icon_512x512.' . $image->getClientOriginalExtension();

            $img->resize(512, 512);

            $img->save($destinationPath . '/' . $icon512, 90);

            // 256x256

            $icon256 = 'icon_256x256.' . $image->getClientOriginalExtension();

            $img->resize(256, 256);

            $img->save($destinationPath . '/' . $icon256, 90);

            // 192x192

            $icon192 = 'icon_192x192.' . $image->getClientOriginalExtension();

            $img->resize(192, 192);

            $img->save($destinationPath . '/' . $icon192, 90);

            // 144x144

            $icon144 = 'icon_144x144.' . $image->getClientOriginalExtension();

            $img->resize(144, 144);

            $img->save($destinationPath . '/' . $icon144, 90);

            // 128x128

            $icon128 = 'icon_128x128.' . $image->getClientOriginalExtension();

            $img->resize(128, 128);

            $img->save($destinationPath . '/' . $icon128, 90);

            // 96x96

            $icon96 = 'icon_96x96.' . $image->getClientOriginalExtension();

            $img->resize(96, 96);

            $img->save($destinationPath . '/' . $icon96, 90);

            // 72x72

            $icon72 = 'icon_72x72.' . $image->getClientOriginalExtension();

            $img->resize(72, 72);

            $img->save($destinationPath . '/' . $icon72, 90);

            // 48x48

            $icon48 = 'icon_48x48.' . $image->getClientOriginalExtension();

            $img->resize(48, 48);

            $img->save($destinationPath . '/' . $icon48, 90);

        }

        /** Splash Screens */

        if ($file = $request->file('splash_2048')) {

            ini_set('max_execution_time', -1);

            $image = $request->file('splash_2048');

            $img = Image::make($image->path());

            // 2048x2732

            $splash2732 = 'splash-2048x2732.' . $image->getClientOriginalExtension();

            $img->resize(2048, 2732);

            $img->save($destinationPath . '/' . $splash2732, 95);

            // 1668x2388

            $splash2388 = 'splash-1668x2388.' . $image->getClientOriginalExtension();

            $img->resize(1668, 2388);

            $img->save($destinationPath . '/' . $splash2388, 95);

            // 1668x2224

            $splash2224 = 'splash-1668x2224.' . $image->getClientOriginalExtension();

            $img->resize(1668, 2224);

            $img->save($destinationPath . '/' . $splash2224, 95);

            // 1536x2048

            $splash2048 = 'splash-1536x2048.' . $image->getClientOriginalExtension();

            $img->resize(1536, 2048);

            $img->save($destinationPath . '/' . $splash2048, 95);

            // 1242x2688

            $splash2688 = 'splash-1242x2688.' . $image->getClientOriginalExtension();

            $img->resize(1242, 2688);

            $img->save($destinationPath . '/' . $splash2688, 95);

            // 1242x2208

            $splash2208 = 'splash-1242x2208.' . $image->getClientOriginalExtension();

            $img->resize(1242, 2208);

            $img->save($destinationPath . '/' . $splash2208, 95);

            // 1125x2436

            $splash2436 = 'splash-1125x2436.' . $image->getClientOriginalExtension();

            $img->resize(1125, 2436);

            $img->save($destinationPath . '/' . $splash2436, 95);

            // 828x1792

            $splash1792 = 'splash-828x1792.' . $image->getClientOriginalExtension();

            $img->resize(828, 1792);

            $img->save($destinationPath . '/' . $splash1792, 95);

            // 750x1334

            $splash1334 = 'splash-750x1334.' . $image->getClientOriginalExtension();

            $img->resize(750, 1334);

            $img->save($destinationPath . '/' . $splash1334, 95);

            // 640x1136

            $splash1136 = 'splash-640x1136.' . $image->getClientOriginalExtension();

            $img->resize(640, 1136);

            $img->save($destinationPath . '/' . $splash1136, 95);

        }

        \Artisan::call('view:cache');
        \Artisan::call('view:clear');

        notify()->success('Icons are updated !');

        return back();
    }
}