<?php

namespace App\Http\Controllers;

use App\TermsSettings;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function __construct()
    {
        $this->setting = TermsSettings::all();
    }

    public function userterms(){

        $userTerm = $this->setting->firstWhere('key','user-register-term');
        $sellerTerm = $this->setting->firstWhere('key','seller-register-term');
        return view('admindesk.terms.term',compact('userTerm','sellerTerm'));

    }

    public function postuserterms(Request $request,$key){
        
        $term = $this->setting->firstWhere('key',$key);

        if($term){

            $request->validate([
                'title' => 'required',
                'description' => 'required'
            ]);

            $term->title = $request->title;
            $term->description = clean($request->description);

            $term->save();

            session()->flash('added','Terms has been updated !');

            return back();


        }else{
            session()->flash('warning','404 | Not found !');
            return redirect(route('admindesk.main'));
        }
    }
}
