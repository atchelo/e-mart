<?php
namespace App\Http\Controllers;

use App\Coupan;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class CoupanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupans = Coupan::orderBy('id', 'DESC')->get();
        return view("admindesk.coupan.index", compact("coupans"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $product = Product::all();

        return view("admindesk.coupan.add", compact('category', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $newc = new Coupan;

        if ($request->link_by == 'product')
        {
            
            $input['pro_id'] = $request->pro_id;
            $input['minamount'] = NULL;
            $input['cat_id'] = NULL;
        }
        else if($request->link_by == 'category')
        {
            $input['pro_id'] = NULL;
        }else{
            $input['pro_id'] = NULL;
            $input['cat_id'] = NULL;
        }

        if (isset($request->is_login))
        {
            $input['is_login'] = 1;
        }

        $newc->create($input);

        return redirect("admindesk/coupan")->with("added", "Coupan Has Been Created !");
    }

    public function edit($id)
    {
        $coupan = Coupan::findOrFail($id);
        return view("admindesk.coupan.edit", compact("coupan"));
    }

    public function update(Request $request, $id)
    {
        
        $newc = Coupan::find($id);

        $input = $request->all();

        if ($request->link_by == 'product')
        {
            
            $input['pro_id'] = $request->pro_id;
            $input['minamount'] = NULL;
            $input['cat_id'] = NULL;
        }
        else if($request->link_by == 'category')
        {
            $input['pro_id'] = NULL;
        }else{
            $input['pro_id'] = NULL;
            $input['cat_id'] = NULL;
        }
        
        if (isset($request->is_login))
        {
            $input['is_login'] = 1;
        }
        else
        {
            $input['is_login'] = 0;
        }

        $newc->update($input);

        notify()->success('Coupan Has Been Updated !',$newc->code);

        return redirect("admindesk/coupan");
    }

    public function destroy($id)
    {
        $newc = Coupan::find($id);
        if (isset($newc))
        {
            $newc->delete();
            return back()
                ->with('deleted', 'Coupon has been deleted');
        }
        else
        {
            return back()
                ->with('warning', '404 | Coupon not found !');
        }
    }
}

