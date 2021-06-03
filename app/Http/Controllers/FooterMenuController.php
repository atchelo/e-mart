<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FooterMenu;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class FooterMenuController extends Controller
{
    public function store(Request $request){

    	$request->validate(['title' => 'required']);

    	$footermenu = new FooterMenu;

    	$input = $request->all();

    	if($request->link_by == 'page'){

    		$input['page_id'] = $request->page_id;
    		$input['url'] = NULL;

    	}elseif($request->link_by == 'url'){

    		$input['page_id'] = NULL;
    		$input['url'] = $request->url;
    	}

    	$input['position'] = (FooterMenu::count()+1);

    	$input['status']  = isset($request->status) ? 1 : 0;

    	$footermenu->create($input);

    	return back()->with('added',"$request->title menu has been created !");

    }

    public function update(Request $request,$id){

    	$request->validate(['title' => 'required']);

    	$footermenu = FooterMenu::find($id);

    	if(isset($footermenu)){
    		$input = $request->all();

	    	if($request->link_by == 'page'){

	    		$input['page_id'] = $request->page_id;
	    		$input['url'] = NULL;

	    	}elseif($request->link_by == 'url'){

	    		$input['page_id'] = NULL;
	    		$input['url'] = $request->url;
	    	}

	    	$input['position'] = (FooterMenu::count()+1);

	    	$input['status']  = isset($request->status) ? 1 : 0;

	    	$footermenu->update($input);

	    	return back()->with('added',"$request->title menu has been updated !");

	    	}else{
	    		return back()->with('404 | Menu not found !');
	    	}
    }

    public function delete($id){
    	$footermenu = FooterMenu::find($id);

    	if(isset($footermenu)){
    		$footermenu->delete();
    		return back()->with('success','Footer menu has been deleted !');
    	}else{
    		return back()->with('delete','404 | Footer menu not found !');
    	}
    }
}
