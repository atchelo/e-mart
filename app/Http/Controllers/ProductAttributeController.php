<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ProductAttributes;
use App\ProductValues;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class ProductAttributeController extends Controller
{

	public function index()
	{
		$pattr = ProductAttributes::all();
		return view('admindesk.attributes.index',compact('pattr'));
	}

    public function create()
    {
    	return view('admindesk.attributes.addattr');
    }

    public function store(Request $request)
    {
        
    	$request->validate([
    		'attr_name' => 'required|unique:product_attributes,attr_name',
            'cats_id' => 'required'
    	],[
            'cats_id.required' => 'One Category is required atleast !',
            'attr_name.required' => 'Attribute name is required !',
            'attr_name.unique' => 'Option Already Added !'
        ]);
        
        if (preg_match('/\s/',$request->attr_name) ){
            $attr_name = str_replace(' ','_',$request->attr_name);
        }else{
            $attr_name = $request->attr_name;
        }
    	
		$newopt = new ProductAttributes;
    	
    	$newopt->attr_name = $attr_name;
        $newopt->unit_id = $request->unit_id;
        $newopt->cats_id = $request->cats_id;


		$newopt->save();

    	
		return redirect()->route('attr.index')->with('added','Option '.$request->attr_name.' Created Successfully !');
    }

    public function edit($id)
    {
    	$proattr = ProductAttributes::findorfail($id);

    	return view('admindesk.attributes.editattr',compact('proattr'));
    }


    public function update(Request $request, $id)
    {
    	$proattr = ProductAttributes::findorfail($id);

        $input = $request->all();
        
        if (preg_match('/\s/',$request->attr_name) ){
            $input['attr_name'] = str_replace(' ','_',$request->attr_name);
        }else{
            $input['attr_name'] = $request->attr_name;
        }

        $findsameattr = ProductAttributes::where('attr_name','=',$request->attr_name)->first();

        if(isset($findsameattr))
        {
            if(strcasecmp($request->attr_name, $findsameattr->attr_name) == 0 && $proattr->id != $findsameattr->id)
            {
                return back()->with('warning','Variant is Already there !'); 
            }else {
               $proattr->update($input);

                return redirect()->route('attr.index')->with('updated','Option Updated to '.$input['attr_name'].' Successfully !');
            } 
        }else
        {
            $proattr->update($input);

            return redirect()->route('attr.index')->with('updated','Option Updated to '.$input['attr_name'].' Successfully !');
        }
       

        if(isset($findsameattr))
        {
            if($findsameattr->attr_name == $request->attr_name && $proattr->id != $findsameattr->id)
            {
            return back()->with('warning','Variant is Already there !');
            }  
        }else{
            $proattr->update($input);

            return redirect()->route('attr.index')->with('updated','Option Updated to '.$input['attr_name'].' Successfully !');
        }
        

    	
    }

    
}
