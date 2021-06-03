<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductAttributes;
use App\ProductValues;
use Response;
use App\AddProductVariant;
use App\AddSubVariant;
use App\CommonVariants;
use Alert;
use DB;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class SellerVariantController extends Controller
{

    public function getPage($id)
    {
        $findpro = Product::findorfail($id);
        $proattr = ProductAttributes::all();
        $getopts = AddProductVariant::where('pro_id', '=', $id)->get();
        return view('seller.productvariant.add', compact('findpro', 'proattr', 'getopts'));
    }

    public function storeCommon(Request $request, $id)
    {
        $findrows = CommonVariants::where('pro_id', '=', $id)->get();

        $findrows2 = AddProductVariant::where('pro_id', '=', $id)->get();

        foreach ($findrows as $value)
        {
            if ($request->attr_name2 == $value->cm_attr_id)
            {
                return back()
                    ->with('warning', 'Variant Already Added For This Product !');
            }
        }

        foreach ($findrows2 as $value)
        {
            if ($request->attr_name2 == $value->attr_name)
            {
                return back()
                    ->with('warning', 'Variant Already Added In Product Variant !');
            }
        }

        $newcommonvar = new CommonVariants;

        $newcommonvar->cm_attr_id = $request->attr_name2;
        $newcommonvar->cm_attr_val = $request->attr_value2;
        $newcommonvar->pro_id = $id;

        $newcommonvar->save();
        
        return redirect()
            ->route('seller.add.var', $id)->with('added', "Variant Added Successfully !");
    }

    public function delCommon(Request $request, $id)
    {
        $cmvar = CommonVariants::findorfail($id);

        $cmvar->delete();

        return redirect()
            ->route('seller.add.var', $cmvar->pro_id)
            ->with('deleted', "Variant Deleted Successfully !");
    }

    public function updatecommon(Request $request, $id)
    {
        $cvar = CommonVariants::find($id);

        if (isset($cvar))
        {
            $cvar->cm_attr_val = $request->cm_attr_val;
            $cvar->save();
            return back()
                ->with('updated', 'Common variant option updated !');
        }
        else
        {
            return back()
                ->with('warning', '404 Not found !');
        }
    }

    public function store(Request $request, $id)
    {
        $request->validate(['attr_name' => 'required', 'attr_value' => 'required'], ['attr_name.unique' => 'Option Already Added In Product !', 'attr_value.required' => 'Atleast one value is required !']);

        $findrows = AddProductVariant::where('pro_id', '=', $id)->get();
        $findrows2 = CommonVariants::where('pro_id', '=', $id)->get();

        foreach ($findrows2 as $value)
        {
            if ($request->attr_name == $value->cm_attr_id)
            {
                return back()
                    ->with('warning', 'Variant Already Added In Common Variant !');
            }
        }

        foreach ($findrows as $value)
        {
            if ($request->attr_name == $value->attr_name)
            {
                return back()
                    ->with('warning', 'Variant Already Added For This Product !');
            }
        }

        if ($findrows->count() >= 2)
        {
            return back()
                ->with('warning', 'You can add only two variant');
        }
        else
        {

            $newvar = new AddProductVariant;

            $findallsub = AddSubVariant::where('pro_id', $id)->get();
            $nArry = [];

            foreach ($findallsub as $key => $value)
            {
                
                array_push($nArry, $value['main_attr_id'][0], $request->attr_name);
             
                

                
            }
            foreach ($findallsub as $value)
            {
               
                foreach ($nArry as $key => $n)
                {
                    $request->attr_name;

                    
                    $update = AddSubVariant::where('pro_id', '=', $id)->get();

                    foreach ($update as $newup)
                    {

                        $value = $newup->main_attr_id;
                        if (count($value) <= 1)
                        {

                            foreach ($value as $cval)
                            {
                                
                                $str = $cval . '"' . ',' . '"' . $request->attr_name;
                                $str2 = array();

                                array_push($str2, $str);

                                $new = json_encode($str2);
                                $str3 = stripslashes($new);
                               
                                DB::table('add_sub_variants')->where('id', $newup->id)
                                    ->update(array(
                                    'main_attr_id' => $str3
                                ));
                                
                            }
                        }

                    }
                  
                }

            }

            $nArry2 = [];
            foreach ($findallsub as $key => $value)
            {
               
                foreach ($value['main_attr_value'] as $a => $att_v)
                {

                    array_push($nArry2, [$a => $att_v, $request->attr_name => "0"]);
                }

            }

            foreach ($findallsub as $value)
            {
                
                foreach ($nArry2 as $key => $n)
                {
                    $request->attr_name;

                    
                    $update = AddSubVariant::where('pro_id', '=', $id)->get();

                    
                    $new1 = json_encode($n);
                    DB::table('add_sub_variants')->where('id', $value->id)
                        ->update(array(
                        'main_attr_value' => $new1
                    ));
                    
                }

            }

            $newvar->attr_name = $request->attr_name;

            $newvar->attr_value = $request->attr_value;

            $newvar->pro_id = $id;

            $newvar->save();

            return back()
                ->with('added', 'Variant Added Successfully !');
        }

    }

    public function getProductValues(Request $request)
    {

        
        $getval = $request->sendval;

        $response = ProductValues::select('id', 'values', 'unit_value')->where('atrr_id', '=', $getval)->get();

        return response()
            ->json($response);

    }

    public function destroy($id)
    {

        $findpro = AddProductVariant::findorfail($id);

        $getallsub = AddSubVariant::where('pro_id', $findpro->pro_id)
            ->get();

        foreach ($getallsub as $value)
        {

            $arr = $value['main_attr_value'];

            $arr2 = $value['main_attr_id'];

            unset($arr[$findpro->attr_name]);

            if (($key = array_search($findpro->attr_name, $arr2)) !== false) {
                unset($arr2[$key]);
            }

            foreach ($arr2 as $key => $v) {
                $n2[] = $v;
            }

            $n = json_encode($arr);

            if(empty($n2)){
                
                $value->delete();  

            }else{

               DB::table('add_sub_variants')->where('id', $value->id)
                    ->update(array(
                    'main_attr_value' => $n,
                    'main_attr_id' => $n2
                ));  

            }
          
        
        }

        $findpro->delete();

        return back()
            ->with('deleted', 'Product Variant Deleted !');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['attr_value' => 'required'], ['attr_value.required' => 'Atleast one value is required !']);

        $findpro = AddProductVariant::findorfail($id);

        $findpro->attr_value = $request->attr_value;

        $findpro->save();

        return redirect()
            ->route('seller.add.var', $findpro->pro_id)
            ->with('updated', 'Product Values Updated Successfully !');
    }
}

