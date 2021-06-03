<?php

namespace App\Http\Controllers\Web;

use App\Adv;
use App\Helpers\CategoryUrl;
use App\Helpers\ProductUrl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvController extends Controller
{
    public function index(Request $request){

        $adv = Adv::where('position',$request->position)->where('status','1')->get();

        try{
            $adv = $adv->map(function($q){

                $content['layout'] = $q->layout;
                $content['image1'] = $q->image1 != '' ? url('images/layoutads/'.$q->image1) : null;
                $content['image2'] = $q->image2 != '' ? url('images/layoutads/'.$q->image2) : null;
                $content['image3'] = $q->image3 != '' ? url('images/layoutads/'.$q->image3) : null;
    
                if($q->cat_id1 != ''){
    
                   $content['image1link'] =  CategoryUrl::getURL($q->cat_id1);
    
                }elseif($q->pro_id1 != '' && $q->product1->subvariants){
    
                    $content['image1link'] =  ProductUrl::getURL($q->pro_id1);
    
                }else{
                    $content['image1link'] = $q->url1;
                }
    
                if($q->cat_id2 != ''){
    
                    $content['image2link'] =  CategoryUrl::getURL($q->cat_id2);
     
                 }elseif($q->pro_id2 != '' && $q->product2->subvariants){
     
                     $content['image2link'] =  ProductUrl::getURL($q->pro_id2);
     
                 }else{
                     $content['image2link'] = $q->url2;
                 }
    
                 if($q->cat_id3 != ''){
    
                    $content['image3link'] =  CategoryUrl::getURL($q->cat_id3);
     
                 }elseif($q->pro_id3 != '' && $q->product3->subvariants){
     
                     $content['image3link'] =  ProductUrl::getURL($q->pro_id3);
     
                 }else{
                     $content['image3link'] = $q->url3;
                 }
    
                return $content;
    
            });
    
            return response()->json($adv);

        }catch(\Exception $e){

            return response()->json($e->getMessage());

        }

    }
}
