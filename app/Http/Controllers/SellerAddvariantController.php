<?php
namespace App\Http\Controllers;

use App\AddSubVariant;
use App\Mail\ProductStockNotifications;
use App\Product;
use App\ProductAttributes;
use App\ProductNotify;
use App\ProductValues;
use App\VariantImages;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Image;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Developer: Media City         =
=            Copyright (c) 2020            =
==========================================*/

class SellerAddvariantController extends Controller
{
    public function getIndex($id)
    {
        $findpro = Product::findorfail($id);
        return view('seller.productvariant.subvar', compact('findpro'));
    }

    public function post(Request $request, $id)
    {
        $request->validate(['main_attr_id' => 'required', 'main_attr_value' => 'required', 'image1' => 'required'], ['main_attr_id.required' => 'Please select an option', 'main_attr_value.required' => 'Please select a value', 'image1.required' => 'Atleast one image is required']);

        $input = $request->all();

        $array2 = AddSubVariant::where('pro_id', $id)->get();

        foreach ($array2 as $key => $value) {

            $array1 = $value->main_attr_value;

            $test = $input['main_attr_value'];

            $conversion_rate = array_diff($array1, $test);

            if ($conversion_rate == null) {

                notify()->warning('Variant already exist ! Kindly Update that');

                return back();
            } else {
                foreach ($conversion_rate as $e => $new) {

                    if ($new == 0) {
                        notify()->warning('Variant already exist ! Kindly Update that');
                        return back();
                    } else {

                    }

                }

            }

        }

        $test = new AddSubVariant();
        $input['pro_id'] = $id;
        //Getting All Def
        $all_def = AddSubVariant::where('def', '=', 1)->where('pro_id', '=', $id)->get();

        if (isset($request->def)) {

            //Updating Current Def
            foreach ($all_def as $value) {
                $remove_def = AddSubVariant::where('id', '=', $value->id)
                    ->update(['def' => 0]);
            }

            $input['def'] = 1;
        } else {
            if ($all_def->count() < 1) {

                notify()->warning('Atleast one variant should be set to default !');

                return back();

            }

            $input['def'] = 0;
        }

        $test->create($input);

        $lastid = AddSubVariant::orderBy('id', 'desc')->first()->id;

        $varimage = new VariantImages();

        $path = public_path() . '/variantimages/';
        $thumbpath = public_path() . '/variantimages/thumbnails/';
        $hoverthumbpath = public_path() . '/variantimages/hoverthumbnail/';

        File::makeDirectory($path, $mode = 0777, true, true);
        File::makeDirectory($thumbpath, $mode = 0777, true, true);
        File::makeDirectory($hoverthumbpath, $mode = 0777, true, true);

        if ($file = $request->file('image1')) {

            $request->validate([
                'image1' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image1 = $name;

            $thumb = $name;

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbpath.'/' . $thumb, 95);

            $varimage->main_image = $name;

        }

        if ($file = $request->file('image2')) {

            $request->validate([
                'image2' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image2 = $name;

            $hoverthumb = $name;

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($hoverthumbpath.'/'.$hoverthumb, 95);

        }

        if ($file = $request->file('image3')) {

            $request->validate([
                'image3' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image3 = $name;

        }

        if ($file = $request->file('image4')) {

            $request->validate([
                'image4' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image4 = $name;

        }

        if ($file = $request->file('image5')) {

            $request->validate([
                'image5' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image5 = $name;

        }

        if ($file = $request->file('image6')) {

            $request->validate([
                'image6' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image6 = $name;

        }

        $varimage->var_id = $lastid;

        $varimage->save();

        notify()->success('Variant Linked Successfully !');

        return redirect()->route('seller.add.var', $id);

    }

    public function edit($id)
    {
        $vars = AddSubVariant::findorfail($id);
        return view('seller.productvariant.edit', compact('vars'));
    }

    public function delete($id)
    {
        $vars = AddSubVariant::findorfail($id);

        if ($vars->def != 1) {

            if ($vars->variantimages) {
                /** Delete Variant Images first */

                /** Deleting Main and Hover Image  */

                if ($vars->variantimages->main_image != null && file_exists('../public/variantimages/thumbnails/' . $vars->variantimages->main_image)) {
                    unlink(public_path() . '/variantimages/thumbnails/' . $vars->variantimages->main_image);
                }

                if ($vars->variantimages->image2 != null && file_exists('../public/variantimages/hoverthumbnail' . $vars->variantimages->image2)) {
                    unlink(public_path() . '/variantimages/hoverthumbnail/' . $vars->variantimages->image2);
                }

                if ($vars->variantimages->image1 != null && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image1)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image1);
                }

                if ($vars->variantimages->image2 != null && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image2)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image2);
                }

                if ($vars->variantimages->image3 != null && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image3)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image3);
                }

                if ($vars->variantimages->image4 != null && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image4)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image4);
                }

                if ($vars->variantimages->image5 != null && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image5)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image5);
                }

                if ($vars->variantimages->image6 != null && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image6)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image6);
                }
                /**End */
                $vars->variantimages->delete();
            }

            $vars->delete();
        } else {

            notify()->error('Default variant cannot be deleted !');

            return back();

        }

        notify()->success('Variant has been Deleted !');

        return back();
        
    }

    public function update(Request $request, $id)
    {
        
        $request->validate(['min_order_qty' => 'numeric|min:1'], ['min_order_qty.min' => 'Minimum order quantity must be atleast 1']);

        $vars = AddSubVariant::find($id);

        if(!$vars){
            notify()->error('Product variant not found !');
            return back();
        }


        $array2 = AddSubVariant::where('pro_id', $vars->pro_id)
            ->get();
        $all_def = AddSubVariant::where('def', '=', 1)->where('pro_id', $vars->pro_id)
            ->get();
        $all_def2 = AddSubVariant::where('pro_id', $vars->pro_id)
            ->get();

        if ($all_def2->count() < 1) {
            notify()->warning('Atleast one value should be set to default !');
            return back();
        }

        $varimage = VariantImages::where('var_id', $id)->first();

        if (!$varimage) {
            $varimage = new VariantImages();
            $varimage->var_id = $vars->id;
        }

        $path = public_path() . '/variantimages';

        $thumbpath = public_path() . '/variantimages/thumbnails/';

        if ($request->stock != null) {
            $getusers = ProductNotify::select('email')->where('var_id', '=', $id)->get();

            if (isset($getusers)) {

                $proname = $vars->products->name;

                $msg2 = __("Buy Now Before stock goes again !");

                $getusers->each(function ($user) use($vars,$proname,$msg2) {
                    try{
                        Mail::to($user->email)->send(new ProductStockNotifications($vars, $msg2, $proname));
                        \DB::table('product_stock_subscription')->where('email', '=', $user->email)->delete();
                    }catch(\Exception $e){
                        Log::error('Failed to sent product stock mail');
                    }
                });

            }
        }

        if ($file = $request->file('image1')) {

            $request->validate([
                'image1' => 'mimes:png,jpg,jpeg',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if ($varimage->image1 != null && file_exists(public_path() . '/variantimages/' . $varimage->image1)) {
                unlink(public_path() . '/variantimages/' . $varimage->image1);
            }

            if ($varimage->image1 == $varimage->main_image) {

                if ($varimage->main_image != null && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image1 = $name;

        }

        if ($file = $request->file('image2')) {

            $request->validate([
                'image2' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if ($varimage->image2 != null && file_exists(public_path() . '/variantimages/' . $varimage->image2)) {
                unlink(public_path() . '/variantimages/' . $varimage->image2);
            }

            if ($varimage->image2 == $varimage->main_image) {

                if ($varimage->main_image != '' && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;

            }

            $varimage->image2 = $name;

            /** Storing Second thumbnail for Hover ONLY FOR IMAGE 2 */

            if ($varimage->image2 != '' && file_exists(public_path().'/variantimages/hoverthumbnail/' . $varimage->image2)) {
                unlink(public_path() . '/variantimages/hoverthumbnail/' . $varimage->image2);
            }

            $hoverthumb = $name;

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbpath . '/' . $hoverthumb, 95);

        }

        if ($file = $request->file('image3')) {

            $request->validate([
                'image3' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if ($varimage->image3 != null && file_exists(public_path() . '/variantimages/' . $varimage->image3)) {
                unlink(public_path() . '/variantimages/' . $varimage->image3);
            }

            if ($varimage->image3 == $varimage->main_image) {

                if ($varimage->main_image != '' && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image3 = $name;

        }

        if ($file = $request->file('image4')) {

            $request->validate([
                'image4' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if ($varimage->image4 != null && file_exists(public_path() . '/variantimages/' . $varimage->image4)) {
                unlink(public_path() . '/variantimages/' . $varimage->image4);
            }

            if ($varimage->image4 == $varimage->main_image) {

                if ($varimage->main_image !='' && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image4 = $name;

        }

        if ($file = $request->file('image5')) {

            $request->validate([
                'image5' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if ($varimage->image5 != null && file_exists(public_path() . '/variantimages/' . $varimage->image5)) {
                unlink(public_path() . '/variantimages/' . $varimage->image5);
            }

            if ($varimage->image5 == $varimage->main_image) {

                if ($varimage->main_image != '' && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image5 = $name;

        }

        if ($file = $request->file('image6')) {

            $request->validate([
                'image6' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if ($varimage->image6 != null && file_exists(public_path() . '/variantimages/' . $varimage->image6)) {
                unlink(public_path() . '/variantimages/' . $varimage->image6);
            }

            if ($varimage->image6 == $varimage->main_image) {

                if ($varimage->main_image != '' && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image6 = $name;

        }

        $varimage->save();

        $input = $request->all();

        $current_stock = $vars->stock;
        $addstock = $request->stock;

        $newstock = ($current_stock) + ($addstock);

        if ($newstock < 0) {
            notify()->error('Stock cannot be less than 0 !');
            return back();
        }

        if (isset($request->def)) {

            //Removing Other Def If Any
            foreach ($all_def as $value) {

                if ($vars->id != $value->id) {
                    $remove_def = AddSubVariant::where('id', '=', $value->id)
                        ->update(['def' => 0]);
                }

            }

            $input['def'] = 1;
        } else {

            if ($all_def2->count() <= 1) {
                notify()->warning('Atleast one value should be set to default !');
                return back();
            }
        }

        foreach ($array2 as $key => $value) {

            $array1 = $value->main_attr_value;

            $test = $input['main_attr_value'];

            $result = array_diff($array1, $test);

            if ($result == null) {

                if ($id == $value->id) {

                    if ($request->stock == '') {

                        $input['stock'] = $vars->stock;

                    } else {
                        $input['stock'] = $vars->stock + $request->stock;
                    }

                    $vars->update($input);

                    notify()->success('Variant has been Updated !');

                    return redirect()->route('seller.add.var', $vars->pro_id);
                } else {

                    notify()->success('Linked Variant already exist !');

                    return back();
                }

            } else {
                foreach ($result as $e => $new) {

                    if ($new == 0) {

                        if ($id == $value->id) {
                            if ($request->stock == '') {

                                $input['stock'] = $vars->stock;

                            } else {
                                $existstock = $vars->stock;
                                $input['stock'] = $vars->stock + $request->stock;
                            }

                            $vars->update($input);

                            notify()->success('Linked Variant Updated !');

                            return redirect()->route('seller.add.var', $vars->pro_id);

                        } else {

                            notify()->warning('Linked Variant exist !');

                            return back();
                        }

                    } else {

                    }

                }

            }
        }

        if ($request->stock == '') {

            $input['stock'] = $vars->stock;

        } else {
            $input['stock'] = $vars->stock + $request->stock;
        }

        $vars->update($input);

        notify()->success('Variant Updated !');

        return redirect()->route('seller.add.var', $vars->pro_id);

    }

    public function gettingvar(Request $request)
    {
        $id = $request->id;
        $name = $request->value;
        $attr_name = $request->attr_name;

        $allvalues = AddSubVariant::all();

        $conversion_rate = array();

        foreach ($allvalues as $g) {
            array_push($conversion_rate, $g->main_attr_value);
        }

        $testing = array();
        $getvalname2 = array();
        foreach ($conversion_rate as $key => $val) {
            if ($val[$attr_name] === $name) {
                array_push($testing, $val);
                if ($id == 0) {
                    $getvalname = ProductValues::where('id', '=', $val[2])->first()->values;
                    array_push($getvalname2, $getvalname);
                } else {
                    $getvalname = ProductValues::where('id', '=', $val[1])->first()->values;
                    array_push($getvalname2, $getvalname);
                }

            }
        }
        $test2 = '';
        if ($id == 0) {
            $test2 = 1;
        } else {
            $test2 = 0;
        }

        if ($id == 0) {

        } else {

        }

        return response()->json([$testing, $test2, $getvalname2]);

    }

    public function ajaxGet(Request $request, $id)
    {

        $attr_name = $request->attr_name;
        $value = $request->value;
        $array1 = $request->arr;

        $newarr = array();
        $arr_count = count($array1);
        if ($arr_count > 1) {
            array_push($newarr, [$array1[0]["key"] => $array1[0]["value"], $array1[1]["key"] => $array1[1]["value"]]);
        } else {
            array_push($newarr, [$array1[0]["key"] => $array1[0]["value"],

            ]);
        }

        $t = count($newarr);

        $p_attr_id = ProductAttributes::where('attr_name', '=', $attr_name)->first()->id;

        $all_var = AddSubVariant::where('pro_id', '=', $id)->with('variantimages')
            ->get();

        foreach ($all_var as $var) {

            if ($newarr[0] == $var['main_attr_value']) {
                return $var;
            }

        }

    }

    /*On load data*/

    public function ajaxGet2(Request $request, $id)
    {
        $array1 = $request->arr;
        $newarr = array();
        $arr_count = count($array1);

        if ($arr_count > 1) {
            array_push($newarr, [$array1[0]["key"] => $array1[0]["value"], $array1[1]["key"] => $array1[1]["value"]]);
        } else {
            array_push($newarr, [$array1[0]["key"] => $array1[0]["value"],

            ]);
        }

        //Get all variant with this id
        $all_sub_var = AddSubVariant::where('pro_id', '=', $id)->with('variantimages')
            ->get();

        foreach ($all_sub_var as $value) {

            if ($value['main_attr_value'] == $newarr[0]) {
                return $value;
            }

        }

    }

    public function quicksetdefault(Request $request, $id)
    {
        $pro_id = $request->pro_id;
        $addsub = AddSubVariant::findorfail($id);

        $all_def = AddSubVariant::where('def', '=', 1)->where('pro_id', $pro_id)->get();
        $all_def2 = AddSubVariant::where('pro_id', $pro_id)->get();

        $c = count($all_def2);

        if ($all_def2->count() <= 1) {
            return response()
                ->json(array(
                    'count' => $c,
                    "msg" => "Atleast one value should set to be default",
                ));
        }

        foreach ($all_def as $value) {

            if ($id != $value->id) {
                AddSubVariant::where('id', '=', $value->id)
                    ->update(['def' => 0]);
            }

        }

        AddSubVariant::where('id', '=', $id)->update(['def' => 1]);

        return response()
            ->json(array(
                'msg' => 'Default Variant is changed !',
                'count' => $c,
                'id' => $id,
            ));

    }

}
