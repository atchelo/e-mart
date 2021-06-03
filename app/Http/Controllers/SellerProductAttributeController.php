<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductAttributes;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class SellerProductAttributeController extends Controller
{
    public function index(){
    	$pattr = ProductAttributes::all();
    	return view('seller.product.attributes',compact('pattr'));
    }
}
