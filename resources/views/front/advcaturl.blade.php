@php
  $item = App\Category::where('id',$adv->url)->first();
  $price_array = array();
@endphp
@if($item)
@foreach($item->products as $old)

@foreach($old->subvariants as $orivar)
                          
                 
                              @php
                              $convert_price = 0;
                              $show_price = 0;
                              
                              $commision_setting = App\CommissionSetting::first();

                              if($commision_setting->type == "flat"){

                                 $commission_amount = $commision_setting->rate;
                                if($commision_setting->p_type == 'f'){
                                
                                  $totalprice = $old->vender_price+$orivar->price+$commission_amount;
                                  $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;

                                   if($old->vender_offer_price == 0){
                                       $totalprice;
                                       array_push($price_array, $totalprice);
                                    }else{
                                       $totalsaleprice;
                                      $convert_price = $totalsaleprice==''?$totalprice:$totalsaleprice;
                                      $show_price = $totalprice;
                                      array_push($price_array, $totalsaleprice);
                                    
                                    }

                                   
                                }else{

                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                 
                                    if($old->vender_offer_price ==0){
                                      $bprice = round($buyerprice,2);
                                     
                                        array_push($price_array, $bprice);
                                    }else{
                                       $bsprice = round($buyersaleprice,2);
                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                      $show_price = $buyerprice;
                                      array_push($price_array, $bsprice);
                                    
                                    }
                                 

                                }
                              }else{
                                
                              $comm = App\Commission::where('category_id',$old->category_id)->first();
                              if(isset($comm)){
                             if($comm->type=='f'){
                               
                               $price =  $old->vender_price  + $comm->rate+$orivar->price;
                               $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price;

                                $convert_price = $offer==''?$price:$offer;
                                $show_price = $price;

                                 if($old->vender_offer_price == 0){

                                       array_push($price_array, $price);
                                    }else{
                                      array_push($price_array, $offer);
                                    }

                                
                                 
                            }
                            else{

                                  $commission_amount = $comm->rate;

                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                 
                                    if($old->vender_offer_price ==0){
                                       $bprice = round($buyerprice,2);
                                        array_push($price_array, $bprice);
                                    }else{
                                       $bsprice = round($buyersaleprice,2);
                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                      $show_price = round($buyerprice,2);
                                       array_push($price_array, $bsprice);
                                    }
                                 
                                 
                                  
                            }
                         }
                            }
                         
                               @endphp
                            
                           
                             

 @endforeach
 @endforeach


                <?php

                
                if($price_array != null){
                 $firstsub =  min($price_array);
                 $startp =  round($firstsub);
                 if($startp >= $firstsub){
                    $startp = $startp-1;
                  }else{
                    $startp = $startp;
                  }

                  
                 $lastsub = max($price_array);
                 $endp =  round($lastsub);

                 if($endp <= $lastsub){
                    $endp = $endp+1;
                  }else{
                    $endp = $endp;
                  }

                }else{
                  $startp = 0.00;
                  $endp = 0.00;
                }

                if(isset($firstsub)){
                     if($firstsub == $lastsub){
                        $startp=0.00;
                    }
                }
               

                 unset($price_array); 
                
                $price_array = array();
                ?>

      
{{url('shop?category='.$adv->url.'&start='.$startp*$conversion_rate.'&end='.$endp*$conversion_rate)}}


@endif