<?php

namespace App\Http\Controllers;

use App\UserReview;
use Illuminate\Http\Request;
use Stevebauman\Translation\Contracts\Translation;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class ReviewController extends Controller
{
    protected $translation;
    
    /**
     * Constructor.
     *
     * @param Translation $translation
     */
    

    public function index()
    {

         $reviews = UserReview::all();
        
        return view("admindesk.review.index",compact("reviews"));
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $data = $this->validate($request,[
            "review"=>"required",
            "gest_review"=>"required",
            
        ],[

            "review.required"=>"Review Fild is Required",
            "gest_review.required"=>"Gest Review Fild is Required",
            
          ]);

         $obj = new \App\review;

         
         $obj->review=$request->review;
         $obj->gest_review=$request->gest_review;
         
         $value=$obj->save();
         if($value){
            session()->flash("added","Review has been inserted");
            return redirect("review/create");
         }      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $review = UserReview::findOrFail($id);
        
        return view("admindesk.review.edit",compact("review"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        
         
         $update = new UserReview;
         $obj = $update->find($id);
         $obj->remark=$request->remark;
         $obj->status=$request->status;
         
         $value=$obj->save();
         if($value){
            session()->flash("updated","Review has been Update");
            return redirect("admindesk/review/");
         }
    }

    public function review_approval(){
        $reviews = UserReview::where('status','0')->get();
        
        return view("admindesk.review.index",compact("reviews"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = UserReview::find($id);
        $value = $cat->delete();
         if($value){
            session()->flash("deleted","Review Has Been Deleted");
            return back();
         }
    }
    
}
