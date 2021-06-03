<?php
namespace App\Http\Controllers;

use App\DetailAds;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Develoepr: @nkit              =
=            Copyright (c) 2020            =
==========================================*/

class DetailAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = DetailAds::all();
        return view('admindesk/detailAds.index', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admindesk/detailAds.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $blockad = new DetailAds;

        if ($request->linkby == 'category' || $request->linkby == 'detail' || $request->linkby == 'url') {
            $request->validate(['adimage' => 'required|mimes:jpg,jpeg,png,gif,bmp'], ['adimage.required' => 'You Forget to select image !', 'adimage.mimes' => 'Please select a valid image !']);
        }

        if ($request->linkby == 'category') {

            $request->validate(['cat_id' => 'required',

            ], ['cat_id.required' => 'Please select category !']);
        }

        if ($request->linkby == 'detail') {

            $request->validate(['pro_id' => 'required'], ['pro_id.required' => 'Please select product !']);
        }

        if ($request->linkby == 'url') {

            $request->validate(['url' => 'required'], ['url.required' => 'Please enter valid url !']);
        }

        if ($request->position == 'category') {

            $request->validate(['linkedCat' => 'required'], ['linkedCat.required' => 'Please select linked category page !']);

            $blockad->linked_id = $request->linkedCat;

        } else {

            $request->validate(['linkedPro' => 'required'], ['linkedPro.required' => 'Please select product detail page !']);

            $blockad->linked_id = $request->linkedPro;

        }

        $blockad->position = $request->position;
        $blockad->linkby = $request->linkby;

        if ($request->linkby == 'category' || $request->linkby == 'detail' || $request->linkby == 'url') {

            $blockad->adsensecode = null;

            if ($file = $request->file('adimage')) {
                $img = Image::make($file);

                $destinationPath = public_path() . '/images/detailads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $blockad->adimage = $name;
            }

            $blockad->top_heading = $request->top_heading;
            $blockad->hcolor = $request->hcolor;
            $blockad->sheading = $request->sheading;
            $blockad->scolor = $request->scolor;

            if (isset($request->show_btn)) {
                $blockad->show_btn = 1;
                $blockad->btn_text = $request->btn_txt;
                $blockad->btn_txt_color = $request->btn_txt_color;
                $blockad->btn_bg_color = $request->btn_bg;
            }

        } else {

            $blockad->top_heading = null;
            $blockad->adimage = null;
            $blockad->btn_text = null;
            $blockad->btn_txt_color = null;
            $blockad->btn_bg_color = null;
            $blockad->url = null;
            $blockad->hcolor = null;
            $blockad->pro_id = null;
            $blockad->cat_id = null;
            $blockad->sheading = null;
            $blockad->scolor = null;
            $blockad->adsensecode = $request->adsensecode;
        }

        if ($request->linkby == 'category') {

            $blockad->cat_id = $request->cat_id;
            $blockad->pro_id = null;
            $blockad->url = null;

        }

        if ($request->linkby == 'detail') {

            $blockad->cat_id = $request->pro_id;
            $blockad->cat_id = null;
            $blockad->url = null;

        }

        if ($request->linkby == 'url') {
            $blockad->pro_id = null;
            $blockad->cat_id = null;
            $blockad->url = $request->url;
            $blockad->linked_id = null;
        }

        if (isset($request->status)) {
            $blockad->status = 1;
        } else {
            $blockad->status = 0;
        }

        $blockad->save();

        return back()
            ->with('added', 'Block ad has been created !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailAds  $detailAds
     * @return \Illuminate\Http\Response
     */
    public function show(DetailAds $detailAds)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailAds  $detailAds
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = DetailAds::findOrFail($id);
        return view('admindesk/detailAds.edit', compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailAds  $detailAds
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $blockad = DetailAds::findOrFail($id);

        if ($request->linkby == 'category' || $request->linkby == 'detail' || $request->linkby == 'url') {
            $request->validate(['adimage' => 'mimes:jpg,jpeg,png,gif,bmp'], ['adimage.mimes' => 'Please select a valid image !']);
        }

        if ($request->linkby == 'category') {

            $request->validate(['cat_id' => 'required', 'linkedCat' => 'required'], ['cat_id.required' => 'Please select category !']);
        }

        if ($request->linkby == 'detail') {

            $request->validate(['pro_id' => 'required'], ['pro_id.required' => 'Please select product !']);
        }

        if ($request->linkby == 'url') {

            $request->validate(['url' => 'required'], ['url.required' => 'Please enter valid url !']);
        }

        if ($request->position == 'category') {

            $request->validate(['linkedCat' => 'required'], ['linkedCat.required' => 'Please select linked category page !']);

            $blockad->linked_id = $request->linkedCat;

        } else {

            $request->validate(['linkedPro' => 'required'], ['linkedPro.required' => 'Please select product detail page !']);

            $blockad->linked_id = $request->linkedPro;

        }

        $blockad->position = $request->position;
        $blockad->linkby = $request->linkby;

        if ($request->linkby == 'category' || $request->linkby == 'detail' || $request->linkby == 'url') {

            $blockad->adsensecode = null;

            if ($file = $request->file('adimage')) {
                if (file_exists(public_path() . '/images/detailads/' . $blockad->adimage)) {
                    unlink(public_path() . '/images/detailads/' . $blockad->adimage);
                }

                $img = Image::make($file);

                $destinationPath = public_path() . '/images/detailads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $blockad->adimage = $name;
            }

            $blockad->hcolor = $request->hcolor;
            $blockad->top_heading = $request->top_heading;
            $blockad->sheading = $request->sheading;
            $blockad->scolor = $request->scolor;

            if (isset($request->show_btn)) {
                $blockad->show_btn = 1;
                $blockad->btn_text = $request->btn_txt;
                $blockad->btn_txt_color = $request->btn_txt_color;
                $blockad->btn_bg_color = $request->btn_bg;
            } else {
                $blockad->show_btn = 0;
                $blockad->btn_text = null;
                $blockad->btn_txt_color = null;
                $blockad->btn_bg_color = null;
            }

        } else {
            $blockad->top_heading = null;
            $blockad->adimage = null;
            $blockad->sheading = null;
            $blockad->scolor = null;
            $blockad->btn_text = null;
            $blockad->hcolor = null;
            $blockad->btn_txt_color = null;
            $blockad->btn_bg_color = null;
            $blockad->url = null;
            $blockad->pro_id = null;
            $blockad->cat_id = null;
            $blockad->adsensecode = $request->adsensecode;
        }

        if ($request->linkby == 'category') {

            $blockad->cat_id = $request->cat_id;
            $blockad->pro_id = null;
            $blockad->url = null;

        }

        if ($request->linkby == 'detail') {
            $blockad->pro_id = $request->pro_id;
            $blockad->cat_id = null;
            $blockad->url = null;

        }

        if ($request->linkby == 'url') {
            $blockad->pro_id = null;
            $blockad->cat_id = null;
            $blockad->url = $request->url;
        }

        if (isset($request->status)) {
            $blockad->status = 1;
        } else {
            $blockad->status = 0;
        }

        $blockad->save();

        return back()
            ->with('added', 'Block ad has been updated !');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailAds  $detailAds
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ad = DetailAds::findorFail($id);

        if ($ad->image != null) {
            if (file_exists(public_path() . '/images/detailads/' . $ad->adimage)) {
                unlink(public_path() . '/images/detailads/' . $ad->adimage);
            }
        }

        $ad->delete();

        return redirect()
            ->route("detailadvertise.index")
            ->with("deleted", "Selected advertise has been deleted !");

    }
}
