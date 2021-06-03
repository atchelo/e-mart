<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DashboardSetting;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class DashboardController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function dashbordsetting()
    {
        return view('admindesk.dashbord.setting');
    }

    public function dashbordsettingu(Request $request, $id)
    {
        $ds = DashboardSetting::first();

        $ds->lat_ord = $request->lat_ord;
        $ds->rct_pro = $request->rct_pro;
        $ds->rct_str = $request->rct_str;
        $ds->rct_cust = $request->rct_cust;

        $ds->max_item_ord = $request->max_item_ord;
        $ds->max_item_pro = $request->max_item_pro;
        $ds->max_item_str = $request->max_item_str;
        $ds->max_item_cust = $request->max_item_cust;

        $ds->save();
        return redirect()
            ->route('admindesk.dash')
            ->with('updated', 'Setting Updated !');

    }

    public function fbSetting(Request $request, $id)
    {
        $fb = DashboardSetting::first();

        $fb->fb_page_id = $request->fb_page_id;
        $fb->fb_page_token = $request->fb_page_token;
        $fb->fb_wid = $request->fb_wid;

        $fb->save();
        return redirect()
            ->route('admindesk.dash')
            ->with('updated', 'Widget Setting Updated !');
    }

    public function twSetting(Request $request, $id)
    {
        $tw = DashboardSetting::first();
        $tw->tw_username = $request->tw_username;
        $tw->tw_wid = $request->tw_wid;
        $tw->save();
        return redirect()
            ->route('admindesk.dash')
            ->with('updated', 'Widget Setting Updated !');
    }

    public function insSetting(Request $request, $id)
    {
        $ins = DashboardSetting::first();
        $ins->inst_username = $request->inst_username;
        $ins->insta_wid = $request->insta_wid;
        $ins->save();
        return redirect()
            ->route('admindesk.dash')
            ->with('updated', 'Widget Setting Updated !');
    }
}

