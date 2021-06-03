<?php
namespace App\Http\Controllers;
use App\Genral;
use Session;
use App\AutoDetectGeo;
use App\multiCurrency;
use App\CurrencyList;
use App\Allcountry;
use App\Location;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/


              
               $genral = Genral::first();
               $cur_setting = AutoDetectGeo::first()->enabel_multicurrency;
               $auto  = AutoDetectGeo::first();
               
               if(isset(Session::get('currency')['mainid'])){
                $currency  = multiCurrency::where('currency_id',Session::get('currency')['mainid'])->first();
               }
               
                
               $myip = $_SERVER['REMOTE_ADDR'];
               $ip = geoip()->getLocation($myip);
               $switch = 0;
               $exSwitch = 0;
              

              if($cur_setting == 1) {


                if ($auto->currency_by_country == 0 && $auto->auto_detect == 0) {


                      
                    
                    if ($auto->default_geo_location == NULL || $auto->default_geo_location == '') {

                      if (empty(Session::get('currency'))) {
                        
                        $currency = multiCurrency::first();
                        $currencyIsMatch = 0;

                        Session::put('currency',[
                                  'id'=>$currency->currency->code,
                                  'mainid' => $currency->currency->id,
                                  'value'=>$currency->currency_symbol,
                                  'position' => $currency->position
                        ]);
                      }else {
                        $currencyIsMatch = 0;
                      }

                    }else {

                      $getmLocation = Allcountry::where('id',$auto->default_geo_location)->first();
                      $manualCountry = CurrencyList::where('country',$getmLocation->name)->first();

                      if(!$manualCountry){
                            
                           if (empty(Session::get('currency'))) {
                               $currency = multiCurrency::first();

                              Session::put('currency',[
                                  'id'=>$currency->currency->code,
                                  'mainid' => $currency->currency->id,
                                  'value'=>$currency->currency_symbol,
                                  'position' => $currency->position
                                ]);
                            }
                        
                      }else{
                          $currencyIsMatch = 0;
                      }
                     
                     if (empty(Session::get('currency'))) {

                           $currency = multiCurrency::where('currency_id','=',$manualCountry->id)->first();

                            if (isset($currency)) {
                                Session::put('currency',[
                                  'id'=>$currency->currency->code,
                                  'mainid' => $currency->currency->id,
                                  'value'=>$currency->currency_symbol,
                                  'position' => $currency->position
                                ]);
                            }else{
                              //put default one
                              $currency = multiCurrency::first();

                              Session::put('currency',[
                                  'id'=>$currency->currency->code,
                                  'mainid' => $currency->currency->id,
                                  'value'=>$currency->currency_symbol,
                                  'position' => $currency->position
                                ]);


                            }

                     }else{
                        $currencyIsMatch = 0;
                     }

                      
                    }


                     
                }

               
               

                if ($auto->currency_by_country == 1) {

                         $findcountry = Allcountry::where('iso',$ip->iso_code)->first();
                         $location = Location::all();
                         $countryArray = array();
                         $manualcurrency = array();
                         $currencyIsMatch = 0;

                         foreach ($location as $value) {
                            $s = explode(',', $value->country_id);

                            foreach ($s as $a) {

                              if ($a == $findcountry->id) {
                                array_push($countryArray, $value);
                              }

                            }

                        }

                          foreach ($countryArray as $cid) {
                              $x =  multiCurrency::where('id',$cid->multi_currency)->first();
                              array_push($manualcurrency, $x);
                          }


                            if(!empty(Session::get('currency')) || empty(Session::get('currency'))) {

                            

                                foreach ($manualcurrency as $curency) {
                                    
                                    if (Session::get('currency')['mainid'] != $curency->currency_id){
                                        $currencyIsMatch = 1;
                                    }else {
                                       $currencyIsMatch = 0;
                                      
                                       break;
                                    }

                                }

                                if ($currencyIsMatch == 1) {


                                       //than put located country currency if has //

                                       $loc = CurrencyList::where('code',$ip->currency)->first();

                                       $coun = Allcountry::where('nicename','=',$ip->country)->first();

                                       $cur = multiCurrency::where('currency_id','=',$loc->id)->first();

                                       

                                       foreach ($location as $value3) {

                                        
                                          
                                          $s2[] = $value3->country_id;

                                            
                                          

                                            if(isset($cur)){
                                                if ($cur->currency->code == $value3->linkedtomulticurrency->currency->code && in_array($coun->id, $s2)) {

                                                  $switch = 1;
                                                  break;
                                                  
                                                }else {
                                                 $switch = 0;
                                              }
                                            }

                                         

                                          

                                          

                                          if ($switch == 1) {
                                              
                                              //putting that country and thier currency

                                              Session::put('currency',[
                                                'id'=>$cur->currency->code,
                                                'mainid' => $cur->currency->id,
                                                'value'=>$cur->currency_symbol,
                                                'position' => $cur->position
                                              ]);

                                              if ($cur->add_amount != '') {
                                                       $result = $cur->rate+$cur->add_amount;
                                              }else {
                                                       $result = $cur->rate;
                                              }

                                              $conversion_rate = $result;



                                          }else {



                                               foreach ($manualcurrency as $cry) {
                                                  
                                                
                                                  if (Session::get('currency')['mainid'] != $cry->currency_id) {
                                                     $exSwitch = 1;

                                                  }else{
                                                    break;
                                                  }

                                               
                                               }

                                               if ($exSwitch == 1) {
                                                  //put another currency

                                                    Session::put('currency',[
                                                        'id'=>$cry->currency->code,
                                                        'mainid' => $cry->currency->id,
                                                        'value'=>$cry->currency_symbol,
                                                        'position' => $cry->position
                                                      ]);

                                                    if ($cry->add_amount != '') {
                                                       $result = $cry->rate+$cry->add_amount;
                                                    }else {
                                                       $result = $cry->rate;
                                                    }

                                                    $conversion_rate = $result;
                                                
                                             }
                                                  
                                          
                                        }



                                        }

                                        

                                       

                                }
                               

                            }
                }


              if ($auto->auto_detect == 1) {

                $currencyIsMatch = 0;


                //put currency by geo-location//

                if (!Session::has('currency')) {

                  // 'auto enable';

                      $findcurrency = CurrencyList::where('code',$ip->currency)->first();
                      $currency     =  multiCurrency::where('currency_id',$findcurrency->id)->first();

                    
              if (isset($findcurrency) && isset($currency) ) {

                          Session::put('currency',[
                              'id'=>$currency->currency->code,
                              'mainid' => $currency->currency->id,
                              'value'=>$currency->currency_symbol,
                              'position' => $currency->position
                          ]);
                    
                      }else {

                        $currency = multiCurrency::where('default_currency','=',1)->first();

                        Session::put('currency',[
                            'id'=>$currency->currency->code,
                            'mainid' => $currency->currency->id,
                            'value'=>$currency->currency_symbol,
                            'position' => $currency->position
                        ]);
                        
                    }

              }

              

             }else {

                    //default currency put
                    if (!Session::has('currency')) {


                      $currency = multiCurrency::first();

                      session()->put('currency',[
                          'id'=>$currency->currency->code,
                          'mainid' => $currency->currency->id,
                          'value'=>$currency->currency_symbol,
                          'position' => $currency->position
                      ]);

                    }

            }



            $currency = multiCurrency::where('currency_id','=',Session::get('currency')['mainid'])->first();

            // echo $currency;die;
                  
             if ($currencyIsMatch != 1) {
                  
                  if ($currency->add_amount != '') {
                     $result = $currency->rate+$currency->add_amount;
                  }else {
                     $result = $currency->rate;
                  }

                  $conversion_rate = floatval($result);
             }
                  
            


              }else {
              


                
              $connected = @fsockopen("www.facebook.com", 80); 
                                        //website, port  (try 80 or 443)
            if ($connected){
                  //action when connected
                  $result = 1;
                  $api_key = '233bfd95e64a8af7b66c';
                  fclose($connected);


                  if(!empty($genral)){



                      if ($auto->currency_by_country == 0 && $auto->auto_detect == 0) {
                        
                        if ($auto->default_geo_location == NULL || $auto->default_geo_location == '') {
                        
                        if (empty(Session::get('currency'))) {
                        
                          $currency = multiCurrency::first();
                          $currencyIsMatch = 0;

                          Session::put('currency',[
                                  'id'=>$currency->currency->code,
                                  'mainid' => $currency->currency->id,
                                  'value'=>$currency->currency_symbol,
                                  'position' => $currency->position
                          ]);
                        }
                        else {
                            $currencyIsMatch = 0;
                        }

                        }else{

                       $getmLocation = Allcountry::where('id',$auto->default_geo_location)->first();
                       $manualCountry = CurrencyList::where('country',$getmLocation->name)->first();
                       if(!$manualCountry){
                            
                           if (empty(Session::get('currency'))) {
                               $currency = multiCurrency::first();

                              Session::put('currency',[
                                  'id'=>$currency->currency->code,
                                  'mainid' => $currency->currency->id,
                                  'value'=>$currency->currency_symbol,
                                  'position' => $currency->position
                                ]);
                            }
                        
                      }else{
                          $currencyIsMatch = 0;
                      }

                           if (empty(Session::get('currency'))) {

                                 $currency = multiCurrency::where('currency_id','=',$manualCountry->id)->first();

                                  if (isset($currency)) {
                                      Session::put('currency',[
                                        'id'=>$currency->currency->code,
                                        'mainid' => $currency->currency->id,
                                        'value'=>$currency->currency_symbol,
                                        'position' => $currency->position
                                      ]);
                                  }else{
                                    //put default one
                                    $currency = multiCurrency::first();

                                    Session::put('currency',[
                                        'id'=>$currency->currency->code,
                                        'mainid' => $currency->currency->id,
                                        'value'=>$currency->currency_symbol,
                                        'position' => $currency->position
                                      ]);


                                  }

                           }
                         }

                    }

                    if ($auto->currency_by_country == 1) {
                         
                         $findcountry = Allcountry::where('iso',$ip->iso_code)->first();
                         $location = Location::all();
                         $countryArray = array();
                         $manualcurrency = array();
                         $currencyIsMatch = 0;

                         foreach ($location as $value) {
                            $s = explode(',', $value->country_id);

                            foreach ($s as $a) {

                              if ($a == $findcountry->id) {
                                array_push($countryArray, $value);
                              }

                            }

                        }

                          foreach ($countryArray as $cid) {
                              $x =  multiCurrency::where('id',$cid->multi_currency)->first();
                              array_push($manualcurrency, $x);
                          }


                            if(!empty(Session::get('currency')) || empty(Session::get('currency'))) {

                                foreach ($manualcurrency as $curency) {
                                    
                                    if (Session::get('currency')['mainid'] != $curency->currency_id){
                                        $currencyIsMatch = 1;
                                    }else {
                                       $currencyIsMatch = 0;
                                      
                                       break;
                                    }

                                }

                                if ($currencyIsMatch == 1) {
                                      
                                       //than put located country currency if has //

                                       $loc = CurrencyList::where('code',$ip->currency)->first();

                                       $cur = multiCurrency::where('currency_id','=',$loc->id)->first();

                                       $coun = Allcountry::where('nicename','=',$ip->country)->first();

                                       foreach ($location as $value3) {
                                          
                                          $s2 = explode(',', $value3->country_id);

                                          foreach ($s2 as $a2) {

                                           
                                            if ($cur->currency->code == $value3->currency && $a2 == $coun->id) {

                                                $switch = 1;
                                                break;
                                                
                                              }else {
                                               $switch = 0;
                                            }

                                         

                                          }

                                          

                                          if ($switch == 1) {
                                              
                                              //putting that country and thier currency

                                              Session::put('currency',[
                                                'id'=>$cur->currency->code,
                                                'mainid' => $cur->currency->id,
                                                'value'=>$cur->currency_symbol,
                                                'position' => $cur->position
                                              ]);

                                          }else {



                                               foreach ($manualcurrency as $cry) {
                                                  
                                                
                                                  if (Session::get('currency')['mainid'] != $cry->currency_id) {
                                                     
                                                     $exSwitch = 1;

                                                  }else{
                                                    break;
                                                  }

                                               
                                               }

                                               if ($exSwitch == 1) {
                                                  //put another currency

                                                    Session::put('currency',[
                                                        'id'=>$cry->currency->code,
                                                        'mainid' => $cry->currency->id,
                                                        'value'=>$cry->currency_symbol,
                                                        'position' => $cry->position
                                                      ]);
                                                
                                             }
                                                  
                                          
                                        }



                                        }

                                        

                                       

                                }
                               

                            }



                         
                  }

                    

                    if(!Session::has('currency')){


                      if ($auto->auto_detect == 1) {

                        $myip = $_SERVER['REMOTE_ADDR'];
                        $ip = geoip()->getLocation($myip);

                        $findcurrency = CurrencyList::where('code',$ip->currency)->first();
                        $currency     =  multiCurrency::where('currency_id',$findcurrency->id)->first();

                        //put currency by geo-location//

                        if (!Session::has('currency')) {
                            
                            if (isset($findcurrency) && isset($currency)) {

                                  Session::put('currency',[
                                      'id'=>$currency->currency->code,
                                      'mainid' => $currency->currency->id,
                                      'value'=>$currency->currency_symbol,
                                      'position' => $currency->position
                                  ]);
                            
                              }else {

                                //putting default currency if not found thier country currency

                                $currency = multiCurrency::where('default_currency','=',1)->first();



                                Session::put('currency',[
                                    'id'=>$currency->currency->code,
                                    'mainid' => $currency->currency->id,
                                    'value'=>$currency->currency_symbol,
                                    'position' => $currency->position
                                ]);
                                
                            }

                      }

                     }else{
                              $currency = multiCurrency::first();

                              session()->put('currency',[
                                  'id'=>$currency->currency->code,
                                  'mainid' => $currency->currency->id,
                                  'value'=>$currency->currency_symbol,
                                  'position' => $currency->position
                              ]);
                     }

                     
                  }

                    $symbol=$genral->currency_symbol;
                    if(isset(session()->get('currency')['id'])){
                      
                      $from=$genral->currency_code;
                      $to=session()->get('currency')['id'];

                    #other API KEYS     
                    // ce96b5c0add191b1c136   
                    // 56e74be1de81a531ab8c 
                    // 233bfd95e64a8af7b66c 
                    // 47f4d75d878305374573 
                    // c530696626d7d99a0d77
                    // 5d27c573fa7b7fd30a19
                    // ad4b8a3a8d958312ce3c

                    $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$from;
                    $curl_handle=curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL,$req_url);
                    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'E-mart');
                    $response_json = curl_exec($curl_handle);
                    curl_close($curl_handle);
                 
                  // Continuing if we got a result
                  
                  if(false != $response_json) {
                        
                      // Try/catch for json_decode operation
                     try {


                   
                    $response_object = json_decode($response_json);
                    if( isset( $response_object->result ) ){
                      if($response_object->result == 'error'){
                        
                        $conv_id = "{$from}_{$to}";
                        $string = file_get_contents("http://free.currconv.com/api/v7/convert?q=$conv_id&compact=ultra&apiKey=".$api_key);
                        $json_a = json_decode($string, true);
                        $result= $json_a[$conv_id];
                      }else{
                         
                        $convr_curr = $to;
                        $result = round(($response_object->rates->$convr_curr),4);
                      }
                   }else{
                    
                     $convr_curr = $to;
                    if(isset($response_object->rates->$convr_curr)){
                        
                    $result = round(($response_object->rates->$convr_curr),4);
                    }else{
                        $conv_id = "{$from}_{$to}";
                        $string = file_get_contents("http://free.currconv.com/api/v7/convert?q=$conv_id&compact=ultra&apiKey=".$api_key);
                        $json_a = json_decode($string, true);
                        $result= $json_a[$conv_id];
                    }

                   }

                 
                   

                      }
                      catch(Exception $e) {
                          // Handle JSON parse error...
                      }

                  }else{
                    
                        $conv_id = "{$from}_{$to}";
                        $string = file_get_contents("http://free.currconv.com/api/v7/convert?q=$conv_id&compact=ultra&apiKey=".$api_key);
                        $json_a = json_decode($string, true);
                        $result= $json_a[$conv_id];
                     
                  }
                  
                   $conversion_rate = $result;
                   return $result;
                
                }

                
            }
          }else{
                  //action in connection failure

                if (empty(Session::get('currency'))) {
                    $currency = multiCurrency::first();
                    session()->put('currency',[
                                  'id'=>$currency->currency->code,
                                  'mainid' => $currency->currency->id,
                                  'value'=>$currency->currency_symbol,
                                  'position' => $currency->position
                              ]);
                }

                $result = 1;
                $conversion_rate = $result;


               echo "<b>Warning !</b> No Internet connection so currency rate could not be fetch !";
          }
              }

             
              

?>