<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Http\Request;
use Image;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Testimonial::all();
        return view('admindesk.testimonial.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admindesk.testimonial.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           
             'name'     =>  'required',
             'rating'   =>  'required',
             'post'     =>  'required',
             'image'    =>  'required',
             'rating'   =>  'required|not_in:0',
               
            ],[

            
             "name.required"=>"Please Enter Name...",
                
          ]);

        $input = $request->all();

        
        if ($file = $request->file('image')) 
         {
            
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/testimonial/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $input['image'] = $image;
         
         }

        $input['des'] = clean($request->des);

        $data = Testimonial::create($input);
        return back()->with("added","Testimonial Has Been Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Testimonial::find($id);
        return view("admindesk.testimonial.edit",compact("client"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        
         $input = $request->all();  
        
        if($file = $request->file('image'))
        {
            
            if ($testimonial->image != null) 
            {

                $image_file = @file_get_contents(public_path().'/images/testimonial/'.$testimonial->image);

                if($image_file)
                {
                    unlink(public_path().'/images/testimonial/'.$testimonial->image);
                }

            }

                    $optimizeImage = Image::make($file);
              $optimizePath = public_path().'/images/testimonial/';
              $name = time().$file->getClientOriginalName();
              $optimizeImage->save($optimizePath.$name, 72);

                    $input['image'] = $name;

        }

        


         else
        {
             $input['image'] = $testimonial->image;
        }

        $input['des'] = clean($request->des);

        $testimonial->update($input);

         return redirect('admindesk/testimonial')->with('updated', 'Testimonial has been updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
         if ($testimonial->image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/testimonial/'.$testimonial->image);

                if($image_file)
                {
                    
                    unlink(public_path().'/images/testimonial/'.$testimonial->image);
                }
        }
        $value = $testimonial->delete();
        if($value){
            session()->flash("deleted","testimonial Has Been Deleted");
            return redirect("admindesk/testimonial");
        }
    }
}
