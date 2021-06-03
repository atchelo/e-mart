@php 

  $pricing = array();
  $customer_price = 0;
  $customer_price=0;
  $customeroffer_price;
  $show_price = 0;
  $convert_price = 0;

  if($a != null){
      $products = array_unique($products);
  }

 $current_date = date('Y-m-d H:i:s');

@endphp

@if($products != null && count($products)>0)
    @foreach($products as $product)
            
        @foreach($product->subvariants as $key=> $sub)
            
            

            @if($price_login == 0 || Auth::user())

                @php
               

                $commision_setting = App\CommissionSetting::first();

                if($commision_setting->type == "flat"){
                    
                    $commission_amount = $commision_setting->rate;

                    if($commision_setting->p_type == 'f'){

                        if($product->tax_r !=''){
                            
                            $cit = $commission_amount*$product->tax_r/100;
                            $totalprice = $product->vender_price+$sub->price+$commission_amount+$cit;
                            
                            if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL)
                            {
                                $totalsaleprice = $product->vender_offer_price + $sub->price + $commission_amount+$cit; 
                            }else{
                                $totalsaleprice = 0;
                            }

                        }else{
                           $totalprice = $product->vender_price+$orivar->price+$commission_amount;
                           if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL)
                            {
                                $totalsaleprice = $product->vender_offer_price + $sub->price + $commission_amount; 
                            }else{
                                $totalsaleprice = 0;
                            }
                        }

                              
                       if($totalsaleprice == 0){

                            $customer_price = $totalprice;
                            $customer_price = round($customer_price * round($conversion_rate, 4), 2);
                            $convert_price = 0;
                            $show_price = $customer_price;

                       }else{

                            $customer_price = $totalsaleprice;
                            $customer_price = round($customer_price * round($conversion_rate, 4), 2);
                            $convert_price =  $totalsaleprice;
                            $show_price = $totalprice;
                       }
                        

                    }else{
                         

                        $totalprice = ($product->vender_price+$sub->price)*$commission_amount;

                        if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL){
                        $totalsaleprice = ($product->vender_offer_price+$sub->price)*$commission_amount;
                        }

                        $buyerprice = ($product->vender_price+$sub->price)+($totalprice/100);

                        if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL){
                             $buyersaleprice = ($product->vender_offer_price+$sub->price)+($totalsaleprice/100); 
                        }else {
                            $buyersaleprice = 0;
                        }
                        
                       
                       if($buyersaleprice ==0){
                             $customer_price = round($buyerprice,2);
                             $customer_price = round($customer_price * round($conversion_rate, 4), 2);
                             $convert_price  = 0;
                             $show_price = $buyerprice;
                       }else{
                            $customer_price = round($buyersaleprice,2);
                            $customer_price = round($customer_price * round($conversion_rate, 4), 2);
                            $convert_price = $buyersaleprice;
                            $show_price = $buyerprice;
                       }
                     

                    }
                }else{
                        
                    $comm = App\Commission::where('category_id',$product->category_id)->first();
                    

                    if(isset($comm)){
                        if($comm->type=='f'){
                            $commission_amount = $comm->rate;

                            if($product->tax_r !=''){

                              $cit = $commission_amount*$product->tax_r/100;
                              $totalprice = $product->vender_price+$sub->price+$commission_amount+$cit;

                              if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL)
                              {
                                  $totalsaleprice = $product->vender_offer_price + $sub->price + $commission_amount + $cit; 
                              }else{
                                  $totalsaleprice = 0;
                              }

                            }else{

                              $totalprice = $product->vender_price+$sub->price+$commission_amount;

                              if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL)
                              {
                                  $totalsaleprice = $product->vender_offer_price + $sub->price + $commission_amount; 
                              }else{
                                  $totalsaleprice = 0;
                              }

                            }


                             
                           if($totalsaleprice == 0){

                                $customer_price = $totalprice;
                                $customer_price = round($customer_price * round($conversion_rate, 4), 2);
                                $convert_price = 0;
                                $show_price = $totalprice;

                           }else{

                                $customer_price = $totalsaleprice;
                                $customer_price = round($customer_price * round($conversion_rate, 4), 2);
                                $convert_price =  $totalsaleprice;
                                $show_price = $totalprice;
                           } 

                        }
                        else{

                                $commission_amount = $comm->rate;

                                $totalprice = ($product->vender_price+$sub->price)*$commission_amount;

                                if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL){
                                $totalsaleprice = ($product->vender_offer_price+$sub->price)*$commission_amount;
                                }

                                $buyerprice = ($product->vender_price+$sub->price)+($totalprice/100);

                                if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL){
                                     $buyersaleprice = ($product->vender_offer_price+$sub->price)+($totalsaleprice/100); 
                                }else {
                                    $buyersaleprice = 0;
                                }
                                
                               
                               if($buyersaleprice ==0){
                                     $customer_price = round($buyerprice,2);
                                     $customer_price = round($customer_price * round($conversion_rate, 4), 2);
                                     $convert_price  = 0;
                                     $show_price = $buyerprice;
                               }else{
                                    $customer_price = round($buyersaleprice,2);
                                    $customer_price = round($customer_price * round($conversion_rate, 4), 2);
                                    $convert_price = $buyersaleprice;
                                    $show_price = $buyerprice;
                               }
                        }
                    }else{
                            $commission_amount = 0;

                            $totalprice = ($product->vender_price + $sub->price) * $commission_amount;

                            $totalsaleprice = ($product->vender_offer_price + $sub->price) * $commission_amount;

                            $buyerprice = ($product->vender_price + $sub->price) + ($totalprice / 100);

                            $buyersaleprice = ($product->vender_offer_price + $sub->price) + ($totalsaleprice / 100);

                            if ($product->vender_offer_price == 0)
                            {
                                $customer_price = round($buyerprice, 2);
                                $customer_price = round($customer_price * round($conversion_rate, 4) , 2);
                            }
                            else
                            {
                                $customer_price = round($buyersaleprice, 2);
                                $customer_price = round($customer_price * round($conversion_rate, 4) , 2);
                                $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                $show_price = $buyerprice;
                            }
                    }
                }

                @endphp

            @endif
@php
    $var_name_count = count($sub['main_attr_id']);

    $name;
    $var_name;
    $newarr = array();
    for($i = 0; $i<$var_name_count; $i++){ 
        $var_id=$sub['main_attr_id'][$i];
        $var_name[$i]=$sub['main_attr_value'][$var_id]; // echo($orivar['main_attr_id'][$i]);
        $name[$i]=App\ProductAttributes::where('id',$var_id)->first();

    }


    try{
        $url = url('details').'/'.$product->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
    }catch(Exception $e)
    {
        $url = url('details').'/'.$product->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
    }
    array_push($pricing, $customer_price);
    @endphp
    @if($outofstock == 1)

   
    

    @if($sub->stock > 0)

    <!-- if stock is greater than 0 start -->
    @if($start_price == 1)

    <!-- on price slider start_price = 1 and on load also -->
    @if($starts <= $customer_price && $ends>= $customer_price)
        <!-- Starts and Ends values are came from URL -->
         
        @if($a != null)
        <!-- $a = subvariant unique array only work with variant filter -->
        @foreach($a as $provars)
        <!-- Extract Variant array  -->
        @if($provars->id == $sub->id)
        <!-- match unique subvariant id to all subvariant id -->
        <?php 
      $review_t = 0;
      $price_t = 0;
      $value_t = 0;
      $sub_total = 0;
      $count =  App\UserReview::where('pro_id',$product->id)->count();
      if($count>0)
      {
        foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
        $review_t = $review->price*5;
        $price_t = $review->price*5;
        $value_t = $review->value*5;
        $sub_total = $sub_total + $review_t + $price_t + $value_t;
        }
        $count = ($count*3) * 5;
        $rat = $sub_total/$count;
        $ratings_var = ($rat*100)/5;
      
    }else{
      $ratings_var = 0;
    }
        
      ?>
 
        @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)
         
        <!-- only work with rating filter -->
        <div class="col-sm-6 col-md-4 col-lg-3 col-6 kalpana" id="updatediv">

            <div class="item">
                <div class="products">
                    <div class="product">
                        <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                        <!-- /.product-image -->

                        <div class="product-info text-left">
                            <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                    @php
                                    $newarr = array();
                                    @endphp
                                    (
                                    @foreach($sub->main_attr_value as $k => $getvar)

                                    @php
                                    $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;

                                    $getvalname = App\ProductValues::where('id',$getvar)->first();
                                    @endphp

                                    @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                    @php
                                    $conversion_rates = array_push($newarr, $getvar);
                                    @endphp

                                    @else
                                    <?php
                                      
                                      $conversion_rates = array_push($newarr, $getvar);
                                      
                                    ?>
                                    @endif
                                    @endforeach

                                    @php
                                    for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                        $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                        @endphp
                                        @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)
                                        @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                @endif
                                        @else
                                        {{ $getvalname['values'] ?? '' }}
                                        @endif
                                        @php
                                        try{
                                        $icount = count($newarr);
                                        if($i == 0){
                                        if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){ }else{
                                            echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                            @if($ratings_var !=0) <div class="pull-left star-right">
                                            <div class="star-ratings-sprite"><span
                                                    style="width:<?php echo $ratings_var; ?>%"
                                                    class="star-ratings-sprite-rating"></span>
                                            </div>
                        </div>
                        @else
                        <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                        @endif

                        <div class="description"></div>
                        <div class="product-price"> <span class="price">
                            
                                @if(!empty($conversion_rate))

                                @if($convert_price != 0)
                                <span class="price">
                                    <i class="{{session()->get('currency')['value']}}"></i>
                                    {{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                </span>
                                <span class="price-before-discount">
                                    <i class="{{session()->get('currency')['value']}}"></i>
                                    {{sprintf("%.2f",$show_price * $conversion_rate)}}
                                </span>
                                @else
                                <span class="price">
                                    <i class="{{session()->get('currency')['value']}}"></i>
                                    {{sprintf("%.2f",$show_price * $conversion_rate)}}
                                </span>

                                @endif
                                @endif
                        </div>
                        <!-- /.product-price -->
                        
                    </div>
                    <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
            
                    <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                                @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}"> <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"><a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                    </div>
                    @endif
                    <!-- /.cart -->
                </div>
                <!-- /.product -->

            </div>
        </div>
        </div>
        @else
        @if($ratings == 0)
        <div class="col-sm-6 col-md-4 col-lg-3 col-6" id="updatediv">
            <div class="item">
                <div class="products">
                    <div class="product">
                       <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                        <!-- /.product-image -->

                        <div class="product-info text-left">
                            <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                    @php
                                    $newarr = array();
                                    @endphp
                                    (
                                    @foreach($sub->main_attr_value as $k => $getvar)

                                    @php
                                    $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                    @endphp

                                    @php
                                    $getvalname = App\ProductValues::where('id',$getvar)->first();
                                    @endphp

                                    @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                    @php
                                    $conversion_rates = array_push($newarr, $getvar);
                                    @endphp
                                    @else
                                    <?php
                                          $conversion_rates = array_push($newarr, $getvar);
                                          
                                          ?>



                                    @endif
                                    @endforeach

                                    @php
                                    for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp @php
                                        $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                        @endphp

                                        @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)
                                       
                                        @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                        @endif
                                        
                                        @else


                                        {{ $getvalname['values'] ?? '' }}

                                        @endif

                                        @php

                                        try{

                                        $icount = count($newarr);
                                        if($i == 0){
                                        if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){ }else{
                                            echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                            @if($ratings_var !=0) <div class="pull-left star-right">
                                            <div class="star-ratings-sprite"><span
                                                    style="width:<?php echo $ratings_var; ?>%"
                                                    class="star-ratings-sprite-rating"></span>
                                            </div>
                        </div>
                        @else
                        <span class="font-size10">{{ __('Rating Not Available') }}</span>
                        @endif



                        <div class="description"></div>
                        <div class="product-price"> <span class="price">

                                @if(!empty($conversion_rate))

                                  @if($convert_price != 0)
                                    <span class="price"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}</span>

                                      <span class="price-before-discount"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                      </span>
                                  @else

                                      <span class="price"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                      </span>

                                  @endif

                                @endif
                        </div>
                        <!-- /.product-price -->
                      

                    </div>
                    <!-- /.product-info -->
                   @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                    <!-- /.cart -->
                </div>
                <!-- /.product -->

            </div>
           
        </div>
        </div>
        @else
          
        @endif
        @endif


        @endif
        @endforeach
        @else

        <?php 

          $review_t = 0;
          $price_t = 0;
          $value_t = 0;
          $sub_total = 0;
          $count =  App\UserReview::where('pro_id',$product->id)->count();
          if($count>0)
          {
            foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
            $review_t = $review->price*5;
            $price_t = $review->price*5;
            $value_t = $review->value*5;
            $sub_total = $sub_total + $review_t + $price_t + $value_t;
            }
            $count = ($count*3) * 5;
            $rat = $sub_total/$count;
            $ratings_var = ($rat*100)/5;
            
          }else{
              $ratings_var = 0;
          }
          
        ?>

        @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)
        <div class="col-sm-6 col-md-4 col-lg-3 col-6" id="updatediv">
            <div class="item">
                <div class="products">
                    <div class="product">
                        <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                        <!-- /.product-image -->

                        <div class="product-info text-left">
                            <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                    @php
                                    $newarr = array();
                                    @endphp
                                    (
                                    @foreach($sub->main_attr_value as $k => $getvar)

                                    @php
                                    $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                    @endphp

                                    @php
                                    $getvalname = App\ProductValues::where('id',$getvar)->first();
                                    @endphp

                                    @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                    @php
                                    $conversion_rates = array_push($newarr, $getvar);
                                    @endphp
                                    @else
                                    <?php
                                      $conversion_rates = array_push($newarr, $getvar);
                                      
                                      ?>



                                    @endif
                                    @endforeach

                                    @php
                                    for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp @php
                                        $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                        @endphp

                                        @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                        @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                        @endif

                                        @else


                                        {{ $getvalname['values'] ?? '' }}

                                        @endif

                                        @php

                                        try{

                                        $icount = count($newarr);
                                        if($i == 0){
                                        if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){ }else{
                                            echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                            @if($ratings_var !=0) <div class="pull-left star-right">
                                            <div class="star-ratings-sprite"><span
                                                    style="width:<?php echo $ratings_var; ?>%"
                                                    class="star-ratings-sprite-rating"></span>
                                            </div>
                        </div>
                        @else
                        <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                        @endif


                        <div class="description"></div>
                        <div class="product-price"> <span class="price">



                                @if(!empty($conversion_rate))

                                @if($convert_price != 0)
                               <span class="price"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}</span>

                                <span class="price-before-discount"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                </span>
                                @else

                                <span class="price"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                </span>

                                @endif
                                @endif
                        </div>
                        <!-- /.product-price -->

                    </div>
                    <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                                @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                    <!-- /.cart -->
                </div>
                <!-- /.product -->

            </div>
            <!-- /.products -->
        </div>
        </div>

        @else
        @if($ratings == 0)

        <div class="col-sm-6 col-md-4 col-lg-3 col-6 col-6" id="updatediv">
            <div class="item">
                <div class="products">
                    <div class="product">
                        <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                        <!-- /.product-image -->

                        <div class="product-info text-left">
                            <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                    @php
                                    $newarr = array();
                                    @endphp
                                    (
                                    @foreach($sub->main_attr_value as $k => $getvar)

                                    @php
                                    $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                    @endphp

                                    @php
                                    $getvalname = App\ProductValues::where('id',$getvar)->first();
                                    @endphp

                                    @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                    @php
                                    $conversion_rates = array_push($newarr, $getvar);
                                    @endphp
                                    @else
                                    <?php
                                            $conversion_rates = array_push($newarr, $getvar);
                                            
                                            ?>



                                    @endif
                                    @endforeach

                                    @php
                                    for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp @php
                                        $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                        @endphp

                                        @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                        @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                        @endif

                                        @else


                                        {{ $getvalname['values'] ?? '' }}

                                        @endif

                                        @php

                                        try{

                                        $icount = count($newarr);
                                        if($i == 0){
                                        if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){ }else{
                                            echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                            @if($ratings_var !=0) <div class="pull-left star-right">
                                            <div class="star-ratings-sprite"><span
                                                    style="width:<?php echo $ratings_var; ?>%"
                                                    class="star-ratings-sprite-rating"></span>
                                            </div>
                        </div>
                        @else
                        <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                        @endif


                        <div class="description"></div>
                        <div class="product-price"> <span class="price">



                                @if(!empty($conversion_rate))

                                @if($convert_price != 0)
                               <span class="price"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}</span>

                                <span class="price-before-discount"><i
                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                </span>
                                @else

                                <span class="price"><i
                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                </span>

                                @endif
                                @endif
                        </div>
                        <!-- /.product-price -->

                    </div>
                    <!-- /.product-info -->
                   @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                    <!-- /.cart -->
                </div>
                <!-- /.product -->

            </div>
            <!-- /.products -->
        </div>
        </div>

        @else

       

        @endif
        @endif


        @endif

        @endif
        @else

        @if($start <= $customer_price && $end>= $customer_price)

            @if($a != null)
            @foreach($a as $provars)
            @if($provars->id == $sub->id)
                <?php 
                  $review_t = 0;
                  $price_t = 0;
                  $value_t = 0;
                  $sub_total = 0;
                  $count =  App\UserReview::where('pro_id',$product->id)->count();
                  if($count>0)
                  {
                    foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                    $review_t = $review->price*5;
                    $price_t = $review->price*5;
                    $value_t = $review->value*5;
                    $sub_total = $sub_total + $review_t + $price_t + $value_t;
                    }
                    $count = ($count*3) * 5;
                    $rat = $sub_total/$count;
                    $ratings_var = ($rat*100)/5;
                    
                  }else{
                      $ratings_var = 0;
                  }
                    
                ?>

            @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)
            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                <div class="item">
                    <div class="products">
                        <div class="product">
                           <div class="product-image">
                              <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                                  
                                     <a href="{{$url}}" title="{{$product->name}}">
                                     
                                      @if(count($product->subvariants)>0)

                                      @if(isset($sub->variantimages['main_image']))
                                       <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                       <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                      @endif

                                      @else
                                      <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                      
                                      @endif  
                                  
                               
                                @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                                  <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                                @endif
                                                             
                              </a>
                              </div>
                              <!-- /.image -->
                          
                              @if($product->featured=="1")
                                <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                                @elseif($product->offer_price=="1")
                                <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                                @else
                                <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                              @endif
                            </div>
                            <!-- /.product-image -->

                            <div class="product-info text-left">
                                <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                        @php
                                        $newarr = array();
                                        @endphp
                                        (
                                        @foreach($sub->main_attr_value as $k => $getvar)

                                        @php
                                        $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                        @endphp

                                        @php
                                        $getvalname = App\ProductValues::where('id',$getvar)->first();
                                        @endphp

                                        @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                        @php
                                        $conversion_rates = array_push($newarr, $getvar);
                                        @endphp
                                        @else
                                        <?php
                                       $conversion_rates = array_push($newarr, $getvar);
                                       
                                       ?>



                                        @endif
                                        @endforeach

                                        @php
                                        for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp @php
                                            $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                            @endphp

                                            @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                            @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                            @endif

                                            @else


                                            {{ $getvalname['values'] ?? '' }}

                                            @endif

                                            @php

                                            try{

                                            $icount = count($newarr);
                                            if($i == 0){
                                            if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){ }else{
                                                echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp ) </a>
                                                </h3> @if($ratings_var !=0) <div class="pull-left star-right">
                                                <div class="star-ratings-sprite"><span
                                                        style="width:<?php echo $ratings_var; ?>%"
                                                        class="star-ratings-sprite-rating"></span>
                                                </div>
                            </div>
                            @else
                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                            @endif




                            <div class="description"></div>
                            <div class="product-price"> <span class="price">

                                    @if(!empty($conversion_rate))

                                    @if($convert_price != 0)
                                    <span class="price"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                    </span>

                                    <span class="price-before-discount"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                    </span>
                                    @else

                                    <span class="price"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                    </span>

                                    @endif
                                    @endif
                            </div>
                            <!-- /.product-price -->

                        </div>
                        <!-- /.product-info -->
                        @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                        @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                                @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                        <!-- /.cart -->
                    </div>
                    <!-- /.product -->

                  </div>
                <!-- /.products -->
                </div>
            </div>
            @else
            @if($ratings == 0)
            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                <div class="item">
                    <div class="products">
                        <div class="product">
                           <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                            <!-- /.product-image -->

                            <div class="product-info text-left">
                                <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                        @php
                                        $newarr = array();
                                        @endphp
                                        (
                                        @foreach($sub->main_attr_value as $k => $getvar)

                                        @php
                                        $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                        @endphp

                                        @php
                                        $getvalname = App\ProductValues::where('id',$getvar)->first();
                                        @endphp

                                        @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                        @php
                                        $conversion_rates = array_push($newarr, $getvar);
                                        @endphp
                                        @else
                                        <?php
                                           $conversion_rates = array_push($newarr, $getvar);
                                           
                                           ?>



                                        @endif
                                        @endforeach

                                        @php
                                        for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp @php
                                            $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                            @endphp

                                            @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                            @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                            @endif

                                            @else


                                            {{ $getvalname['values'] ?? '' }}

                                            @endif

                                            @php

                                            try{

                                            $icount = count($newarr);
                                            if($i == 0){
                                            if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){ }else{
                                                echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp ) </a>
                                                </h3> @if($ratings_var !=0) <div class="pull-left star-right">
                                                <div class="star-ratings-sprite"><span
                                                        style="width:<?php echo $ratings_var; ?>%"
                                                        class="star-ratings-sprite-rating"></span>
                                                </div>
                            </div>
                            @else
                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                            @endif




                            <div class="description"></div>
                            <div class="product-price"> <span class="price">

                                    @if(!empty($conversion_rate))

                                    @if($convert_price != 0)
                                    <span class="price"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                    </span>

                                    <span class="price-before-discount"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                    </span>
                                    @else

                                    <span class="price"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                    </span>

                                    @endif
                                    @endif
                            </div>
                            <!-- /.product-price -->

                        </div>
                        <!-- /.product-info -->
                        @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                        @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                              @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                        <!-- /.cart -->
                    </div>
                    <!-- /.product -->

                </div>
                <!-- /.products -->
            </div>
            </div>
            @else
            
            @endif
            @endif

            @endif
            @endforeach
            @else
            <?php 
              $review_t = 0;
              $price_t = 0;
              $value_t = 0;
              $sub_total = 0;
              $count =  App\UserReview::where('pro_id',$product->id)->count();
              if($count>0)
              {
                foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                $review_t = $review->price*5;
                $price_t = $review->price*5;
                $value_t = $review->value*5;
                $sub_total = $sub_total + $review_t + $price_t + $value_t;
                }
                $count = ($count*3) * 5;
                $rat = $sub_total/$count;
                $ratings_var = ($rat*100)/5;
                
              }else{
                  $ratings_var = 0;
              }
                
                ?>


            @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)
            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                <div class="item">
                    <div class="products">
                        <div class="product">
                            <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                            <!-- /.product-image -->

                            <div class="product-info text-left">
                                <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                        @php
                                        $newarr = array();
                                        @endphp
                                        (
                                        @foreach($sub->main_attr_value as $k => $getvar)

                                        @php
                                        $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                        @endphp

                                        @php
                                        $getvalname = App\ProductValues::where('id',$getvar)->first();
                                        @endphp

                                        @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                        @php
                                        $conversion_rates = array_push($newarr, $getvar);
                                        @endphp
                                        @else
                                        <?php
                                        $conversion_rates = array_push($newarr, $getvar);
                                        
                                        ?>



                                        @endif
                                        @endforeach

                                        @php
                                        for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp @php
                                            $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                            @endphp

                                            @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                            @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                            @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                            @endif

                                            @else


                                            {{ $getvalname['values'] ?? '' }}

                                            @endif

                                            @php

                                            try{

                                            $icount = count($newarr);
                                            if($i == 0){
                                            if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){ }else{
                                                echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp ) </a>
                                                </h3> @if($ratings_var !=0) <div class="pull-left star-right">
                                                <div class="star-ratings-sprite"><span
                                                        style="width:<?php echo $ratings_var; ?>%"
                                                        class="star-ratings-sprite-rating"></span>
                                                </div>
                            </div>
                            @else
                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                            @endif




                            <div class="description"></div>
                            <div class="product-price"> <span class="price">

                                    @if(!empty($conversion_rate))

                                    @if($convert_price != 0)
                                    <span class="price"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                    </span>

                                    <span class="price-before-discount"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                    </span>
                                    @else

                                    <span class="price"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                    </span>

                                    @endif
                                    @endif
                            </div>
                            <!-- /.product-price -->

                        </div>
                        <!-- /.product-info -->
                        @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                        @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                        <!-- /.cart -->
                    </div>
                    <!-- /.product -->

                </div>
                <!-- /.products -->
            </div>
            </div>
            @else
            @if($ratings == 0)
            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                <div class="item">
                    <div class="products">
                        <div class="product">
                            <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                            <!-- /.product-image -->

                            <div class="product-info text-left">
                                <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                        @php
                                        $newarr = array();
                                        @endphp
                                        (
                                        @foreach($sub->main_attr_value as $k => $getvar)

                                        @php
                                        $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                        @endphp

                                        @php
                                        $getvalname = App\ProductValues::where('id',$getvar)->first();
                                        @endphp

                                        @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                        @php
                                        $conversion_rates = array_push($newarr, $getvar);
                                        @endphp
                                        @else
                                        <?php
                                          $conversion_rates = array_push($newarr, $getvar);
                                          
                                          ?>



                                        @endif
                                        @endforeach

                                        @php
                                        for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp @php
                                            $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                            @endphp

                                            @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                            @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                           @endif

                                            @else


                                            {{ $getvalname['values'] ?? '' }}

                                            @endif

                                            @php

                                            try{

                                            $icount = count($newarr);
                                            if($i == 0){
                                            if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){ }else{
                                                echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp ) </a>
                                                </h3> @if($ratings_var !=0) <div class="pull-left star-right">
                                                <div class="star-ratings-sprite"><span
                                                        style="width:<?php echo $ratings_var; ?>%"
                                                        class="star-ratings-sprite-rating"></span>
                                                </div>
                            </div>
                            @else
                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                            @endif




                            <div class="description"></div>
                            <div class="product-price"> <span class="price">

                                    @if(!empty($conversion_rate))

                                    @if($convert_price != 0)
                                    <span class="price"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                    </span>

                                    <span class="price-before-discount"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                    </span>
                                    @else

                                    <span class="price"><i
                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                    </span>

                                    @endif
                                    @endif
                            </div>
                            <!-- /.product-price -->

                        </div>
                        <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                        <!-- /.cart -->
                    </div>
                    <!-- /.product -->

                </div>
            </div>
            </div>
            @else
            
            @endif
            @endif

            @endif
            @endif
            @endif
            @else

            {{--  <span>{{ __('staticwords.ComingSoon') }}</span>  Product will show here --}} 

            @endif



            @else
            {{--   <span>{{ __('staticwords.ComingSoon') }}</span> include --}}
            @if($sub->stock > 0)
            @if($start_price == 1)

            @if($starts <= $customer_price && $ends>= $customer_price)

             
                @if($a != null)
                @foreach($a as $provars)
                @if($provars->id == $sub->id)
                <?php 
                      $review_t = 0;
                      $price_t = 0;
                      $value_t = 0;
                      $sub_total = 0;
                      $count =  App\UserReview::where('pro_id',$product->id)->count();
                      if($count>0)
                      {
                        foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                        $review_t = $review->price*5;
                        $price_t = $review->price*5;
                        $value_t = $review->value*5;
                        $sub_total = $sub_total + $review_t + $price_t + $value_t;
                        }
                        $count = ($count*3) * 5;
                        $rat = $sub_total/$count;
                        $ratings_var = ($rat*100)/5;
                      
                    }else{
                      $ratings_var = 0;
                    }
                        
                      ?>


                @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)

                <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">

                    <div class="item">
                        <div class="products">
                            <div class="product">
                                <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                                <!-- /.product-image -->

                                <div class="product-info text-left">
                                    <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                            @php
                                            $newarr = array();
                                            @endphp
                                            (
                                            @foreach($sub->main_attr_value as $k => $getvar)

                                            @php
                                            $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                            @endphp

                                            @php
                                            $getvalname = App\ProductValues::where('id',$getvar)->first();
                                            @endphp

                                            @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                            @php
                                            $conversion_rates = array_push($newarr, $getvar);
                                            @endphp
                                            @else
                                            <?php
                                    $conversion_rates = array_push($newarr, $getvar);
                                    
                                    ?>



                                            @endif
                                            @endforeach

                                            @php
                                            for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp
                                                @php $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                @endphp

                                                @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                                @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                @endif

                                                @else


                                                {{ $getvalname['values'] ?? '' }}

                                                @endif

                                                @php

                                                try{

                                                $icount = count($newarr);
                                                if($i == 0){
                                                if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){
                                                    }else{ echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp
                                                    ) </a> </h3> @if($ratings_var !=0) <div class="pull-left star-right">
                                                    <div class="star-ratings-sprite"><span
                                                            style="width:<?php echo $ratings_var; ?>%"
                                                            class="star-ratings-sprite-rating"></span>
                                                    </div>
                                </div>
                                @else
                                <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                @endif



                                <div class="description"></div>
                                <div class="product-price"> <span class="price">



                                        @if(!empty($conversion_rate))

                                        @if($convert_price != 0)
                                        <span class="price"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                        </span>

                                        <span class="price-before-discount"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                        </span>
                                        @else

                                        <span class="price"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                        </span>

                                        @endif
                                        @endif
                                </div>
                                <!-- /.product-price -->

                            </div>
                            <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                              @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                            <!-- /.cart -->
                        </div>
                        <!-- /.product -->

                    </div>
                    <!-- /.products -->
                </div>
                </div>
                @else
                
                @if($ratings == 0)

                <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                    <div class="item">
                        <div class="products">
                            <div class="product">
                                <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                                <!-- /.product-image -->

                                <div class="product-info text-left">
                                    <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                            @php
                                            $newarr = array();
                                            @endphp
                                            (
                                            @foreach($sub->main_attr_value as $k => $getvar)

                                            @php
                                            $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                            @endphp

                                            @php
                                            $getvalname = App\ProductValues::where('id',$getvar)->first();
                                            @endphp

                                            @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                            @php
                                            $conversion_rates = array_push($newarr, $getvar);
                                            @endphp
                                            @else
                                            <?php
                                          $conversion_rates = array_push($newarr, $getvar);
                                          
                                          ?>



                                            @endif
                                            @endforeach

                                            @php
                                            for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp
                                                @php $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                @endphp

                                                @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                                @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                @endif

                                                @else


                                                {{ $getvalname['values'] ?? '' }}

                                                @endif

                                                @php

                                                try{

                                                $icount = count($newarr);
                                                if($i == 0){
                                                if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){
                                                    }else{ echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp
                                                    ) </a> </h3> @if($ratings_var !=0) <div class="pull-left star-right">
                                                    <div class="star-ratings-sprite"><span
                                                            style="width:<?php echo $ratings_var; ?>%"
                                                            class="star-ratings-sprite-rating"></span>
                                                    </div>
                                </div>
                                @else
                                <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                @endif



                                <div class="description"></div>
                                <div class="product-price"> <span class="price">



                                        @if(!empty($conversion_rate))

                                        @if($convert_price != 0)
                                        <span class="price"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                        </span>

                                        <span class="price-before-discount"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                        </span>
                                        @else

                                        <span class="price"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                        </span>

                                        @endif
                                        @endif
                                </div>
                                <!-- /.product-price -->

                            </div>
                            <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                            <!-- /.cart -->
                        </div>
                        <!-- /.product -->

                    </div>
                </div>
                </div>
                @else
                  
                @endif
                @endif


                @endif
                @endforeach
                @else
      
                <?php 
                  $review_t = 0;
                  $price_t = 0;
                  $value_t = 0;
                  $sub_total = 0;
                  $count =  App\UserReview::where('pro_id',$product->id)->count();
                  if($count>0)
                  {
                    foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                    $review_t = $review->price*5;
                    $price_t = $review->price*5;
                    $value_t = $review->value*5;
                    $sub_total = $sub_total + $review_t + $price_t + $value_t;
                    }
                    $count = ($count*3) * 5;
                    $rat = $sub_total/$count;
                    $ratings_var = ($rat*100)/5;
                    
                  }else{
                      $ratings_var = 0;
                  }
                    
                  ?>
      
                @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)
              
                <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                    <div class="item">
                        <div class="products">
                            <div class="product">
                                <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                                <!-- /.product-image -->

                                <div class="product-info text-left">
                                    <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                            @php
                                            $newarr = array();
                                            @endphp
                                            (
                                            @foreach($sub->main_attr_value as $k => $getvar)

                                            @php
                                            $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                            @endphp

                                            @php
                                            $getvalname = App\ProductValues::where('id',$getvar)->first();
                                            @endphp

                                            @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                            @php
                                            $conversion_rates = array_push($newarr, $getvar);
                                            @endphp
                                            @else
                                            <?php
                                      $conversion_rates = array_push($newarr, $getvar);
                                      
                                      ?>



                                            @endif
                                            @endforeach

                                            @php
                                            for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp
                                                @php $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                @endphp

                                                @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)

                                                @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                @endif

                                                @else


                                                {{ $getvalname['values'] ?? '' }}

                                                @endif

                                                @php

                                                try{

                                                $icount = count($newarr);
                                                if($i == 0){
                                                if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){
                                                    }else{ echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp
                                                    ) </a> </h3> @if($ratings_var !=0) <div class="pull-left star-right">
                                                    <div class="star-ratings-sprite"><span
                                                            style="width:<?php echo $ratings_var; ?>%"
                                                            class="star-ratings-sprite-rating"></span>
                                                    </div>
                                </div>
                                @else
                                <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                @endif


                                <div class="description"></div>
                                <div class="product-price"> <span class="price">



                                        @if(!empty($conversion_rate))

                                        @if($convert_price != 0)
                                        <span class="price"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                        </span>

                                        <span class="price-before-discount"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                        </span>
                                        @else

                                        <span class="price"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                        </span>

                                        @endif
                                        @endif
                                </div>
                                <!-- /.product-price -->
                                <!-- /.product-price -->

                            </div>
                            <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                            <!-- /.cart -->
                        </div>
                        <!-- /.product -->

                    </div>
                    <!-- /.products -->
                </div>
                </div>

                @else

                @if($ratings == 0)
                  
                <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                    <div class="item">
                        <div class="products">
                            <div class="product">
                                <div class="product-image">
                                  <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                                      
                                         <a href="{{$url}}" title="{{$product->name}}">
                                         
                                          @if(count($product->subvariants)>0)

                                          @if(isset($sub->variantimages['main_image']))
                                           <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                           <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                          @endif

                                          @else
                                          <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                          
                                          @endif  
                                      
                                   
                                          @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                                            <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                                          @endif
                                                                       
                                        </a>
                                  </div>
                                  <!-- /.image -->
                                  
                                  @if($product->featured=="1")
                                    <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                                    @elseif($product->offer_price=="1")
                                    <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                                    @else
                                    <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                                  @endif
                                </div>
                                <!-- /.product-image -->

                                <div class="product-info text-left">
                                    <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                            @php
                                            $newarr = array();
                                            @endphp
                                            (
                                            @foreach($sub->main_attr_value as $k => $getvar)

                                            @php
                                            $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name;
                                            @endphp

                                            @php
                                            $getvalname = App\ProductValues::where('id',$getvar)->first();
                                            @endphp

                                            @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                            @php
                                            $conversion_rates = array_push($newarr, $getvar);
                                            @endphp
                                            @else
                                            <?php
                                            $conversion_rates = array_push($newarr, $getvar);
                                            
                                            ?>



                                            @endif
                                            @endforeach

                                            @php
                                            for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){ @endphp
                                                @php $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                @endphp

                                                @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)
                                                
                                                @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                @endif
                                                

                                                @else


                                                {{ $getvalname['values'] ?? '' }}

                                                @endif

                                                @php

                                                try{

                                                $icount = count($newarr);
                                                if($i == 0){
                                                if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){
                                                    }else{ echo ',' ; } } } }else{ } }catch(Exception $e){ } } } @endphp
                                                    ) </a> </h3> 
                                                    @if($ratings_var !=0) 
                                                      <div class="pull-left star-right">
                                                        <div class="star-ratings-sprite"><span
                                                                style="width:<?php echo $ratings_var; ?>%"
                                                                class="star-ratings-sprite-rating"></span>
                                                        </div>
                                                      </div>
                                                    @else
                                                    <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                                    @endif


                                <div class="description"></div>
                                <div class="product-price"> <span class="price">



                                        @if(!empty($conversion_rate))

                                        @if($convert_price != 0)
                                        <span class="price"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                        </span>

                                        <span class="price-before-discount"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                        </span>
                                        @else

                                        <span class="price"><i
                                                class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                        </span>

                                        @endif
                                        @endif
                                </div>
                                <!-- /.product-price -->

                            </div>
                            <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                            <!-- /.cart -->
                        </div>
                        <!-- /.product -->

                    </div>
                </div>
                </div>

                @else

                

                @endif
                @endif


                @endif

                @endif
                @else

                @if($start <= $customer_price && $end>= $customer_price)
                    @if($a != null)
                    @foreach($a as $provars)
                    @if($provars->id == $sub->id)
                    <?php 
                      $review_t = 0;
                      $price_t = 0;
                      $value_t = 0;
                      $sub_total = 0;
                      $count =  App\UserReview::where('pro_id',$product->id)->count();
                      if($count>0)
                      {
                        foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                        $review_t = $review->price*5;
                        $price_t = $review->price*5;
                        $value_t = $review->value*5;
                        $sub_total = $sub_total + $review_t + $price_t + $value_t;
                        }
                        $count = ($count*3) * 5;
                        $rat = $sub_total/$count;
                        $ratings_var = ($rat*100)/5;
                        
                      }else{
                          $ratings_var = 0;
                      }
                        
                        ?>


                    @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)

                    <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                        <div class="item">
                            <div class="products">
                                <div class="product">
                                    <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                                    <!-- /.product-image -->

                                    <div class="product-info text-left">
                                        <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                @php
                                                $newarr = array();
                                                @endphp
                                                (
                                                @foreach($sub->main_attr_value as $k => $getvar)

                                                @php
                                                $getattrname =
                                                App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                @endphp

                                                @php
                                                $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                @endphp

                                                @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                                @php
                                                $conversion_rates = array_push($newarr, $getvar);
                                                @endphp
                                                @else
                                                <?php
                                       $conversion_rates = array_push($newarr, $getvar);
                                       
                                       ?>



                                                @endif
                                                @endforeach

                                                @php
                                                for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                                    @endphp @php
                                                    $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                    @endphp

                                                    @if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=
                                                    0)

                                                    @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                        {{ $getvalname['values'] ?? '' }}
                                                    @else
                                                        {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                    @endif

                                                    @else


                                                    {{ $getvalname['values'] ?? '' }}

                                                    @endif

                                                    @php

                                                    try{

                                                    $icount = count($newarr);
                                                    if($i == 0){
                                                    if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){
                                                        }else{ echo ',' ; } } } }else{ } }catch(Exception $e){ } } }
                                                        @endphp ) </a> </h3> @if($ratings_var !=0) <div
                                                        class="pull-left star-right">
                                                        <div class="star-ratings-sprite"><span
                                                                style="width:<?php echo $ratings_var; ?>%"
                                                                class="star-ratings-sprite-rating"></span>
                                                        </div>
                                    </div>
                                    @else
                                    <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                    @endif




                                    <div class="description"></div>
                                    <div class="product-price"> <span class="price">

                                            @if(!empty($conversion_rate))

                                            @if($convert_price != 0)
                                            <span class="price"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                            </span>

                                            <span class="price-before-discount"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                            </span>
                                            @else

                                            <span class="price"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                            </span>

                                            @endif
                                            @endif
                                    </div>
                                    <!-- /.product-price -->

                                </div>
                                <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                                @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                                <!-- /.cart -->
                            </div>
                            <!-- /.product -->

                        </div>
                    </div>
                    </div>
                    @else


                    @if($ratings == 0)
                    <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                        <div class="item">
                            <div class="products">
                                <div class="product">
                                    <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                                    <!-- /.product-image -->

                                    <div class="product-info text-left">
                                        <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                @php
                                                $newarr = array();
                                                @endphp
                                                (
                                                @foreach($sub->main_attr_value as $k => $getvar)

                                                @php
                                                $getattrname =
                                                App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                @endphp

                                                @php
                                                $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                @endphp

                                                @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                                @php
                                                $conversion_rates = array_push($newarr, $getvar);
                                                @endphp
                                                @else
                                                <?php
                                           $conversion_rates = array_push($newarr, $getvar);
                                           
                                           ?>



                                                @endif
                                                @endforeach

                                                @php
                                                for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                                    @endphp @php
                                                    $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                    @endphp

                                                    @if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=
                                                    0)

                                                    @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                    {{ $getvalname['values'] ?? '' }}
                                                    @else
                                                    {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                    @endif

                                                    @else


                                                    {{ $getvalname['values'] ?? '' }}

                                                    @endif

                                                    @php

                                                    try{

                                                    $icount = count($newarr);
                                                    if($i == 0){
                                                    if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){
                                                        }else{ echo ',' ; } } } }else{ } }catch(Exception $e){ } } }
                                                        @endphp ) </a> </h3> @if($ratings_var !=0) <div
                                                        class="pull-leftstar-right">
                                                        <div class="star-ratings-sprite"><span
                                                                style="width:<?php echo $ratings_var; ?>%"
                                                                class="star-ratings-sprite-rating"></span>
                                                        </div>
                                    </div>
                                    @else
                                    <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                    @endif




                                    <div class="description"></div>
                                    <div class="product-price"> <span class="price">

                                            @if(!empty($conversion_rate))

                                            @if($convert_price != 0)
                                            <span class="price"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                            </span>

                                            <span class="price-before-discount"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                            </span>
                                            @else

                                            <span class="price"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                            </span>

                                            @endif
                                            @endif
                                    </div>
                                    <!-- /.product-price -->

                                </div>
                                <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                @if(!empty($ifinwishlist))
                                    <li class="lnk wishlist active">
                                        <a
                                            class="cursor-pointer color000"
                                            mainid="{{ $sub->id }}" 
                                            title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active"
                                            data-remove="{{url('removeWishList/'.$sub->id)}}"
                                            >
                                            <i class="icon fa fa-heart"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="lnk wishlist">
                                        <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i>
                                        </a>
                                    </li>
                                @endif

                                @endif
                              @endauth
                                <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                                <!-- /.cart -->
                            </div>
                            <!-- /.product -->

                        </div>
                    </div>
                    </div>
                    @else
                    
                    @endif
                    @endif

                    @endif
                    @endforeach
                    @else
                    <?php 
                          $review_t = 0;
                          $price_t = 0;
                          $value_t = 0;
                          $sub_total = 0;
                          $count =  App\UserReview::where('pro_id',$product->id)->count();
                          if($count>0)
                          {
                            foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                            $review_t = $review->price*5;
                            $price_t = $review->price*5;
                            $value_t = $review->value*5;
                            $sub_total = $sub_total + $review_t + $price_t + $value_t;
                            }
                            $count = ($count*3) * 5;
                            $rat = $sub_total/$count;
                            $ratings_var = ($rat*100)/5;
                            
                          }else{
                              $ratings_var = 0;
                          }
    
                    ?>

                    @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)

                    <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                        <div class="item">
                            <div class="products">
                                <div class="product">
                                    <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                                    <!-- /.product-image -->

                                    <div class="product-info text-left">
                                        <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                @php
                                                $newarr = array();
                                                @endphp
                                                (
                                                @foreach($sub->main_attr_value as $k => $getvar)

                                                @php
                                                $getattrname =
                                                App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                @endphp

                                                @php
                                                $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                @endphp

                                                @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                                @php
                                                $conversion_rates = array_push($newarr, $getvar);
                                                @endphp
                                                @else
                                                <?php
                                       $conversion_rates = array_push($newarr, $getvar);
                                       
                                       ?>



                                                @endif
                                                @endforeach

                                                @php
                                                for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                                    @endphp @php
                                                    $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                    @endphp

                                                    @if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=
                                                    0)

                                                    @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                    {{ $getvalname['values'] ?? '' }}
                                                    @else
                                                    {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                    @endif

                                                    @else


                                                    {{ $getvalname['values'] ?? '' }}

                                                    @endif

                                                    @php

                                                    try{

                                                    $icount = count($newarr);
                                                    if($i == 0){
                                                    if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){
                                                        }else{ echo ',' ; } } } }else{ } }catch(Exception $e){ } } }
                                                        @endphp ) </a> </h3> @if($ratings_var !=0) <div
                                                        class="pull-left star-right">
                                                        <div class="star-ratings-sprite"><span
                                                                style="width:<?php echo $ratings_var; ?>%"
                                                                class="star-ratings-sprite-rating"></span>
                                                        </div>
                                    </div>
                                    @else
                                    <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                    @endif




                                    <div class="description"></div>
                                    <div class="product-price"> <span class="price">

                                            @if(!empty($conversion_rate))

                                            @if($convert_price != 0)
                                            <span class="price"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                            </span>

                                            <span class="price-before-discount"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                            </span>
                                            @else

                                            <span class="price"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                            </span>

                                            @endif
                                            @endif
                                    </div>
                                    <!-- /.product-price -->

                                </div>
                                <!-- /.product-info -->
                                @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
            
                    <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                    </div>
                    @endif
                                <!-- /.cart -->
                            </div>
                            <!-- /.product -->

                        </div>
                    </div>
                    </div>
                    @else
                    @if($ratings == 0)
                    <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                        <div class="item">
                            <div class="products">
                                <div class="product">
                                    <div class="product-image">
                          <div class="image {{ $sub->stock ==0 ? "pro_img-box" : ""}}"> 
                              
                                 <a href="{{$url}}" title="{{$product->name}}">
                                 
                                  @if(count($product->subvariants)>0)

                                  @if(isset($sub->variantimages['main_image']))
                                   <img class="lazy {{ $sub->stock == 0 ? "filterdimage" : ""}}" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$sub->products->name}}">
                                   <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}  hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                  @endif

                                  @else
                                  <img class="lazy {{ $sub->stock ==0 ? "filterdimage" : ""}}" title="{{ $sub->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                  
                                  @endif  
                              
                           
                            @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                              <h6 align="center" class="oottext2"><span>{{ __('staticwords.ComingSoon') }}</span></h6>
                            @endif
                                                         
                          </a>
                          </div>
                          <!-- /.image -->
                          
                          @if($product->featured=="1")
                            <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                            @else
                            <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                                    <!-- /.product-image -->

                                    <div class="product-info text-left">
                                        <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                @php
                                                $newarr = array();
                                                @endphp
                                                (
                                                @foreach($sub->main_attr_value as $k => $getvar)

                                                @php
                                                $getattrname =
                                                App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                @endphp

                                                @php
                                                $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                @endphp

                                                @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) != 0)


                                                @php
                                                $conversion_rates = array_push($newarr, $getvar);
                                                @endphp
                                                @else
                                                <?php
                                         $conversion_rates = array_push($newarr, $getvar);
                                         
                                         ?>



                                                @endif
                                                @endforeach

                                                @php
                                                for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                                    @endphp @php
                                                    $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                    @endphp

                                                    @if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=
                                                    0)

                                                    @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                @endif

                                                    @else


                                                    {{ $getvalname['values'] ?? '' }}

                                                    @endif

                                                    @php

                                                    try{

                                                    $icount = count($newarr);
                                                    if($i == 0){
                                                    if($i < $icount){ if($newarr[$i+1]==0){ }else{ if($newarr[$i]==0){
                                                        }else{ echo ',' ; } } } }else{ } }catch(Exception $e){ } } }
                                                        @endphp ) </a> </h3> @if($ratings_var !=0) <div
                                                        class="pull-left star-right">
                                                        <div class="star-ratings-sprite"><span
                                                                style="width:<?php echo $ratings_var; ?>%"
                                                                class="star-ratings-sprite-rating"></span>
                                                        </div>
                                    </div>
                                    @else
                                    <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                    @endif




                                    <div class="description"></div>
                                    <div class="product-price"> <span class="price">

                                            @if(!empty($conversion_rate))

                                            @if($convert_price != 0)
                                            <span class="price"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                            </span>

                                            <span class="price-before-discount"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                            </span>
                                            @else

                                            <span class="price"><i
                                                    class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                            </span>

                                            @endif
                                            @endif
                                    </div>
                                    <!-- /.product-price -->

                                </div>
                                <!-- /.product-info -->
                    @if($sub->stock != 0 && $sub->products->selling_start_at != null && $sub->products->selling_start_at >= $current_date)
                    @else
                        <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                {{ csrf_field() }}
                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                        
                                    </form>
                                </li>
                                @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                 <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                        </div>
                    @endif
                                <!-- /.cart -->
                            </div>
                            <!-- /.product -->

                        </div>
                    </div>
                    </div>
                    @else
                    
                    @endif
                    @endif

                    @endif
                    @endif
                    @endif
                    @else



                    @if($start_price == 1)

                    @if($starts <= $customer_price && $ends>= $customer_price)


                        @if($a != null)
                        @foreach($a as $provars)
                        @if($provars->id == $sub->id)
                        <?php 
                          $review_t = 0;
                          $price_t = 0;
                          $value_t = 0;
                          $sub_total = 0;
                          $count =  App\UserReview::where('pro_id',$product->id)->count();
                          if($count>0)
                          {
                            foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                            $review_t = $review->price*5;
                            $price_t = $review->price*5;
                            $value_t = $review->value*5;
                            $sub_total = $sub_total + $review_t + $price_t + $value_t;
                            }
                            $count = ($count*3) * 5;
                            $rat = $sub_total/$count;
                            $ratings_var = ($rat*100)/5;
                          
                        }else{
                          $ratings_var = 0;
                        }
                            
                          ?>

                        @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)

                        <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                             
                            <div class="item">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image">
                                                <a href="{{ url($url) }}">

                                                    <div class="pro_img-box">
               
                                    
                                                        @if(count($product->subvariants)>0)

                                                        @if(isset($sub->variantimages['main_image']))
                                                         <img class="lazy filterdimage" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$product->name}}">
                                                         <img class="lazy filterdimage hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                                        @endif

                                                        @else
                                                        <img class="lazy filterdimage" title="{{ $product->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                                        
                                                        @endif

                                                    </div>
                                                    
                                                </a>
                                            </div>
                                            <!-- /.image -->

                                            <h6 align="center" class="oottext"><span>{{ __('staticwords.Outofstock') }}</span></h6>

                                            @if($product->featured=="1")
                                                <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                                                @elseif($product->offer_price=="1")
                                                <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                                                @else
                                                <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                                            @endif
                                        </div>
                                        <!-- /.product-image -->

                                        <div class="product-info text-left">

                                            <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                    @php
                                                    $newarr = array();
                                                    @endphp
                                                    (
                                                    @foreach($sub->main_attr_value as $k => $getvar)

                                                    @php
                                                    $getattrname =
                                                    App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                    @endphp

                                                    @php
                                                    $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                    @endphp

                                                    @if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=
                                                    0)


                                                    @php
                                                    $conversion_rates = array_push($newarr, $getvar);
                                                    @endphp
                                                    @else
                                                    <?php
                                    $conversion_rates = array_push($newarr, $getvar);
                                    
                                    ?>



                                                    @endif
                                                    @endforeach

                                                    @php
                                                    for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                                        @endphp @php
                                                        $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                        @endphp

                                                        @if(strcasecmp($getvalname['values'], $getvalname['unit_value'])
                                                        != 0)

                                                        @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                {{ $getvalname['values'] ?? '' }}
                                                @else
                                                {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                @endif

                                                        @else


                                                        {{ $getvalname['values'] ?? '' }}

                                                        @endif

                                                        @php

                                                        try{

                                                        $icount = count($newarr);
                                                        if($i == 0){
                                                        if($i < $icount){ if($newarr[$i+1]==0){ }else{
                                                            if($newarr[$i]==0){ }else{ echo ',' ; } } } }else{ }
                                                            }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                                            @if($ratings_var !=0) <div class="pull-left star-right">
                                                            <div class="star-ratings-sprite"><span
                                                                    style="width:<?php echo $ratings_var; ?>%"
                                                                    class="star-ratings-sprite-rating"></span>
                                                            </div>
                                        </div>
                                        @else
                                        <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                        @endif



                                        <div class="description"></div>
                                        <div class="product-price"> <span class="price">



                                                @if(!empty($conversion_rate))

                                                @if($convert_price != 0)
                                                <span class="price"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                                </span>

                                                <span class="price-before-discount"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                </span>
                                                @else

                                                <span class="price"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                </span>

                                                @endif
                                                @endif
                                        </div>
                                        <!-- /.product-price -->

                                    </div>
                                    <!-- /.product-info -->
                                    @if($sub->stock>0)
                                    <div class="cart clearfix animate-effect">
                                        <div class="action">
                                            <ul class="list-unstyled">
                                                <li class="add-cart-button btn-group">
                                                    <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                        {{ csrf_field() }}
                                                           <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                                
                                                </form>
                                                </li>
                                               @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                                <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                                            </ul>
                                        </div>
                                        <!-- /.action -->
                                    </div>
                                    @endif
                                    <!-- /.cart -->
                                </div>
                                <!-- /.product -->

                            </div>
                            <!-- /.products -->
                        </div>
                        </div>
                        @else
                        @if($ratings == 0)
                        <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                            <div class="item">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image">
                                                <a href="{{ url($url) }}">
                                                    <div class="pro_img-box">
                                                        @if(count($product->subvariants)>0)

                                                        @if(isset($sub->variantimages['main_image']))
                                                         <img class="lazy filterdimage" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$product->name}}">
                                                         <img class="lazy filterdimage hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                                        @endif

                                                        @else
                                                        <img class="lazy filterdimage" title="{{ $product->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                                        
                                                        @endif
                                                    </div>
                                                   
                                                </a>
                                            </div>
                                            <!-- /.image -->
                                             <h6 align="center" class="oottext"><span>{{ __('staticwords.Outofstock') }}</span></h6>

                                            @if($product->featured=="1")
                                                <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                                                @elseif($product->offer_price=="1")
                                                <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                                                @else
                                                <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                                            @endif
                                        </div>
                                        <!-- /.product-image -->

                                        <div class="product-info text-left">

                                            <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                    @php
                                                    $newarr = array();
                                                    @endphp
                                                    (
                                                    @foreach($sub->main_attr_value as $k => $getvar)

                                                    @php
                                                    $getattrname =
                                                    App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                    @endphp

                                                    @php
                                                    $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                    @endphp

                                                    @if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=
                                                    0)


                                                    @php
                                                    $conversion_rates = array_push($newarr, $getvar);
                                                    @endphp
                                                    @else
                                                    <?php
                                          $conversion_rates = array_push($newarr, $getvar);
                                          
                                          ?>



                                                    @endif
                                                    @endforeach

                                                    @php
                                                    for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                                        @endphp @php
                                                        $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                        @endphp

                                                        @if(strcasecmp($getvalname['values'], $getvalname['unit_value'])
                                                        != 0)

                                                        @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                        {{ $getvalname['values'] ?? '' }}
                                                        @else
                                                        {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                        @endif

                                                        @else


                                                        {{ $getvalname['values'] ?? '' }}

                                                        @endif

                                                        @php

                                                        try{

                                                        $icount = count($newarr);
                                                        if($i == 0){
                                                        if($i < $icount){ if($newarr[$i+1]==0){ }else{
                                                            if($newarr[$i]==0){ }else{ echo ',' ; } } } }else{ }
                                                            }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                                            @if($ratings_var !=0) <div class="pull-left star-right
                                                            <div class="star-ratings-sprite"><span
                                                                    style="width:<?php echo $ratings_var; ?>%"
                                                                    class="star-ratings-sprite-rating"></span>
                                                            </div>
                                        </div>
                                        @else
                                        <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                        @endif



                                        <div class="description"></div>
                                        <div class="product-price"> <span class="price">



                                                @if(!empty($conversion_rate))

                                                @if($convert_price != 0)
                                                <span class="price"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                                </span>

                                                <span class="price-before-discount"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                </span>
                                                @else

                                                <span class="price"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                </span>

                                                @endif
                                                @endif
                                        </div>
                                        <!-- /.product-price -->

                                    </div>
                                    <!-- /.product-info -->
                                    @if($sub->stock>0)
                                        <div class="cart clearfix animate-effect">
                                            <div class="action">
                                                <ul class="list-unstyled">
                                                    <li class="add-cart-button btn-group">
                                                      <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                    {{ csrf_field() }}
                                                       <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                            
                                                    </form>
                                                    </li>
                                                    @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                                     <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                                                </ul>
                                            </div>
                                            <!-- /.action -->
                                        </div>
                                    @endif
                                    <!-- /.cart -->
                                </div>
                                <!-- /.product -->

                            </div>
                            <!-- /.products -->
                        </div>
                        </div>
                        @else
                        
                        @endif
                        @endif


                        @endif
                        @endforeach
                        @else

                        @php 
                          $review_t = 0;
                          $price_t = 0;
                          $value_t = 0;
                          $sub_total = 0;
                          $count =  App\UserReview::where('pro_id',$product->id)->count();
                          if($count>0)
                          {
                            foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                            $review_t = $review->price*5;
                            $price_t = $review->price*5;
                            $value_t = $review->value*5;
                            $sub_total = $sub_total + $review_t + $price_t + $value_t;
                            }
                            $count = ($count*3) * 5;
                            $rat = $sub_total/$count;
                            $ratings_var = ($rat*100)/5;
                            
                          }else{
                              $ratings_var = 0;
                          }
                            
                          @endphp

                        @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)

                        <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                            <div class="item">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image">
                                                <a href="{{ url($url) }}">
                                                    <div class="pro_img-box">
                                                        @if(count($product->subvariants)>0)

                                                        @if(isset($sub->variantimages['main_image']))
                                                         <img class="lazy filterdimage" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$product->name}}">
                                                         <img class="filterdimage hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                                        @endif

                                                        @else
                                                        <img class="lazy filterdimage" title="{{ $product->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                                        
                                                        @endif
                                                    </div>
                                                    
                                                </a>
                                            </div>
                                            <!-- /.image -->
                                            <h6 align="center" class="oottext"><span>{{ __('staticwords.Outofstock') }}</span></h6>

                                            @if($product->featured=="1")
                                                <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                                                @elseif($product->offer_price=="1")
                                                <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                                                @else
                                                <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                                            @endif
                                        </div>
                                        <!-- /.product-image -->

                                        <div class="product-info text-left">

                                            <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                    @php
                                                    $newarr = array();
                                                    @endphp
                                                    (
                                                    @foreach($sub->main_attr_value as $k => $getvar)

                                                    @php
                                                    $getattrname =
                                                    App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                    @endphp

                                                    @php
                                                    $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                    @endphp

                                                    @if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=
                                                    0)


                                                    @php
                                                    $conversion_rates = array_push($newarr, $getvar);
                                                    @endphp
                                                    @else
                                                    
                                                    @php
                                                      $conversion_rates = array_push($newarr, $getvar);
                                                    @endphp

                                                    @endif
                                                    @endforeach

                                                    @php
                                                    for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                                        @endphp @php
                                                        $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                        @endphp

                                                        @if(strcasecmp($getvalname['values'], $getvalname['unit_value'])
                                                        != 0)

                                                        @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                        {{ $getvalname['values'] ?? '' }}
                                                        @else
                                                        {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                        @endif

                                                        @else


                                                        {{ $getvalname['values'] ?? '' }}

                                                        @endif

                                                        @php

                                                        try{

                                                        $icount = count($newarr);
                                                        if($i == 0){
                                                        if($i < $icount){ if($newarr[$i+1]==0){ }else{
                                                            if($newarr[$i]==0){ }else{ echo ',' ; } } } }else{ }
                                                            }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                                            @if($ratings_var !=0) <div class="pull-left star-right">
                                                            <div class="star-ratings-sprite"><span
                                                                    style="width:<?php echo $ratings_var; ?>%"
                                                                    class="star-ratings-sprite-rating"></span>
                                                            </div>
                                        </div>
                                        @else
                                        <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                        @endif


                                        <div class="description"></div>
                                        <div class="product-price"> <span class="price">



                                                @if(!empty($conversion_rate))

                                                @if($convert_price != 0)
                                                <span class="price"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                                </span>

                                                <span class="price-before-discount"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                </span>
                                                @else

                                                <span class="price"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                </span>

                                                @endif
                                                @endif
                                        </div>
                                        <!-- /.product-price -->

                                    </div>
                                    <!-- /.product-info -->
                                    @if($sub->stock>0)
                                        <div class="cart clearfix animate-effect">
                                            <div class="action">
                                                <ul class="list-unstyled">
                                                    <li class="add-cart-button btn-group">
                                                         <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                                {{ csrf_field() }}
                                                                   <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                                        
                                                        </form>
                                                    </li>
                                                    @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color000" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                                     <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                                                </ul>
                                            </div>
                                            <!-- /.action -->
                                        </div>
                                    @endif
                                    <!-- /.cart -->
                                </div>
                                <!-- /.product -->

                            </div>
                            <!-- /.products -->
                        </div>
                        </div>

                        @else
                        @if($ratings == 0)
                        <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                            <div class="item">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image">
                                                <a href="{{ url($url) }}">
                                                    <div class="pro_img-box">
                                                        @if(count($product->subvariants)>0)

                                                        @if(isset($sub->variantimages['main_image']))
                                                         <img class="lazy filterdimage" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$product->name}}">
                                                         <img class="filterdimage hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                                        @endif

                                                        @else
                                                        <img class="lazy filterdimage" title="{{ $product->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                                        
                                                        @endif
                                                    </div>
                                                    
                                                </a>
                                            </div>
                                            <!-- /.image -->
                                            <h6 align="center" class="oottext"><span>{{ __('staticwords.Outofstock') }}</span></h6>

                                            
                                        </div>
                                        <!-- /.product-image -->

                                        <div class="product-info text-left">

                                            <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                    @php
                                                    $newarr = array();
                                                    @endphp
                                                    (
                                                    @foreach($sub->main_attr_value as $k => $getvar)

                                                    @php
                                                    $getattrname =
                                                    App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                    @endphp

                                                    @php
                                                    $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                    @endphp

                                                    @if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=
                                                    0)


                                                    @php
                                                    $conversion_rates = array_push($newarr, $getvar);
                                                    @endphp
                                                    @else
                                                    <?php
                                            $conversion_rates = array_push($newarr, $getvar);
                                            
                                            ?>



                                                    @endif
                                                    @endforeach

                                                    @php
                                                    for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr !=0){
                                                        @endphp @php
                                                        $getvalname=App\ProductValues::where('id',$newarr[$i])->first();
                                                        @endphp

                                                        @if(strcasecmp($getvalname['values'], $getvalname['unit_value'])
                                                        != 0)

                                                        @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                        {{ $getvalname['values'] ?? '' }}
                                                        @else
                                                        {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                        @endif

                                                        @else


                                                        {{ $getvalname['values'] ?? '' }}

                                                        @endif

                                                        @php

                                                        try{

                                                        $icount = count($newarr);
                                                        if($i == 0){
                                                        if($i < $icount){ if($newarr[$i+1]==0){ }else{
                                                            if($newarr[$i]==0){ }else{ echo ',' ; } } } }else{ }
                                                            }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                                            @if($ratings_var !=0) <div class="pull-left star-right">
                                                            <div class="star-ratings-sprite"><span
                                                                    style="width:<?php echo $ratings_var; ?>%"
                                                                    class="star-ratings-sprite-rating"></span>
                                                            </div>
                                        </div>
                                        @else
                                        <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                        @endif


                                        <div class="description"></div>
                                        <div class="product-price"> <span class="price">



                                                @if(!empty($conversion_rate))

                                                @if($convert_price != 0)
                                                <span class="price"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                                </span>

                                                <span class="price-before-discount"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                </span>
                                                @else

                                                <span class="price"><i
                                                        class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                </span>

                                                @endif
                                                @endif
                                        </div>
                                        <!-- /.product-price -->
                                        <!-- /.product-price -->

                                    </div>
                                    <!-- /.product-info -->
                                    @if($sub->stock>0)
                                        <div class="cart clearfix animate-effect">
                                            <div class="action">
                                                <ul class="list-unstyled">
                                                    <li class="add-cart-button btn-group">
                                                         <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                            {{ csrf_field() }}
                                                       <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                            
                                                        </form>
                                                    </li>
                                                    @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                                   <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                                                </ul>
                                            </div>
                                            <!-- /.action -->
                                        </div>
                                    @endif
                                    <!-- /.cart -->
                                </div>
                                <!-- /.product -->

                            </div>
                            <!-- /.products -->
                        </div>
                        </div>
                        @else
                          
                        @endif
                        @endif


                        @endif

                        @endif
                        @else
                        @if($start <= $customer_price && $end>= $customer_price)
                            @if($a != null)
                            @foreach($a as $provars)
                            @if($provars->id == $sub->id)
                            <?php 
                          $review_t = 0;
                          $price_t = 0;
                          $value_t = 0;
                          $sub_total = 0;
                          $count =  App\UserReview::where('pro_id',$product->id)->count();
                          if($count>0)
                          {
                            foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                            $review_t = $review->price*5;
                            $price_t = $review->price*5;
                            $value_t = $review->value*5;
                            $sub_total = $sub_total + $review_t + $price_t + $value_t;
                            }
                            $count = ($count*3) * 5;
                            $rat = $sub_total/$count;
                            $ratings_var = ($rat*100)/5;
                            
                          }else{
                              $ratings_var = 0;
                          }
                            
                            ?>

                            @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)
                            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                                <div class="item">
                                    <div class="products">
                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a href="{{ url($url) }}">
                                                        <div class="pro_img-box">
                                                            @if(count($product->subvariants)>0)

                                                        @if(isset($sub->variantimages['main_image']))
                                                         <img class="lazy filterdimage" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$product->name}}">
                                                         <img class="filterdimage hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                                        @endif

                                                        @else
                                                        <img class="lazy filterdimage" title="{{ $product->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                                        
                                                        @endif
                                                        </div>
                                                        
                                                    </a>
                                                </div>
                                                <!-- /.image -->
                                                <h6 align="center" class="oottext"><span>{{ __('staticwords.Outofstock') }}</span></h6>

                                            @if($product->featured=="1")
                                                <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                                                @elseif($product->offer_price=="1")
                                                <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                                                @else
                                                <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                                            @endif

                                            </div>
                                            <!-- /.product-image -->

                                            <div class="product-info text-left">

                                                <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                        @php
                                                        $newarr = array();
                                                        @endphp
                                                        (
                                                        @foreach($sub->main_attr_value as $k => $getvar)

                                                        @php
                                                        $getattrname =
                                                        App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                        @endphp

                                                        @php
                                                        $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                        @endphp

                                                        @if(strcasecmp($getvalname['values'], $getvalname['unit_value'])
                                                        != 0)


                                                        @php
                                                        $conversion_rates = array_push($newarr, $getvar);
                                                        @endphp
                                                        @else
                                                        <?php
                                       $conversion_rates = array_push($newarr, $getvar);
                                       
                                       ?>



                                                        @endif
                                                        @endforeach

                                                        @php
                                                        for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr
                                                            !=0){ @endphp @php
                                                            $getvalname=App\ProductValues::where('id',$newarr[$i])->
                                                            first();
                                                            @endphp

                                                            @if(strcasecmp($getvalname['values'],
                                                            $getvalname['unit_value']) != 0)

                                                            @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                            {{ $getvalname['values'] ?? '' }}
                                                            @else
                                                            {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                            @endif

                                                            @else


                                                            {{ $getvalname['values'] ?? '' }}

                                                            @endif

                                                            @php

                                                            try{

                                                            $icount = count($newarr);
                                                            if($i == 0){
                                                            if($i < $icount){ if($newarr[$i+1]==0){ }else{
                                                                if($newarr[$i]==0){ }else{ echo ',' ; } } } }else{ }
                                                                }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                                                @if($ratings_var !=0) <div class="pull-left star-right">
                                                                <div class="star-ratings-sprite"><span
                                                                        style="width:<?php echo $ratings_var; ?>%"
                                                                        class="star-ratings-sprite-rating"></span>
                                                                </div>
                                            </div>
                                            @else
                                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                            @endif




                                            <div class="description"></div>
                                            <div class="product-price"> <span class="price">

                                                    @if(!empty($conversion_rate))

                                                    @if($convert_price != 0)
                                                    <span class="price"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                                    </span>

                                                    <span class="price-before-discount"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                    </span>
                                                    @else

                                                    <span class="price"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                    </span>

                                                    @endif
                                                    @endif
                                            </div>
                                            <!-- /.product-price -->

                                        </div>
                                        <!-- /.product-info -->
                                        @if($sub->stock>0)
                                            <div class="cart clearfix animate-effect">
                                            <div class="action">
                                                <ul class="list-unstyled">
                                                    <li class="add-cart-button btn-group">
                                                       <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                            {{ csrf_field() }}
                                                               <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                                    
                                                    </form>
                                                    </li>
                                                    @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                                     <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                                                </ul>
                                            </div>
                                            <!-- /.action -->
                                            </div>
                                        @endif
                                        <!-- /.cart -->
                                    </div>
                                    <!-- /.product -->

                                </div>
                                <!-- /.products -->
                            </div>
                            </div>
                            @else
                            @if($ratings == 0)
                            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                                <div class="item">
                                    <div class="products">
                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a href="{{ url($url) }}">
                                                        <div class="pro_img-box">
                                                           @if(count($product->subvariants)>0)

                                                        @if(isset($sub->variantimages['main_image']))
                                                         <img class="lazy filterdimage" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$product->name}}">
                                                         <img class="lazy filterdimage hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                                        @endif

                                                        @else
                                                        <img class="lazy filterdimage" title="{{ $product->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                                        
                                                        @endif
                                                        </div>
                                                       
                                                    </a>
                                                </div>
                                                <!-- /.image -->
                                                 <h6 align="center" class="oottext"><span>{{ __('staticwords.Outofstock') }}</span></h6>

                                               
                                            </div>
                                            <!-- /.product-image -->

                                            <div class="product-info text-left">

                                                <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                        @php
                                                        $newarr = array();
                                                        @endphp
                                                        (
                                                        @foreach($sub->main_attr_value as $k => $getvar)

                                                        @php
                                                        $getattrname =
                                                        App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                        @endphp

                                                        @php
                                                        $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                        @endphp

                                                        @if(strcasecmp($getvalname['values'], $getvalname['unit_value'])
                                                        != 0)


                                                        @php
                                                        $conversion_rates = array_push($newarr, $getvar);
                                                        @endphp
                                                        @else
                                                        <?php
                                           $conversion_rates = array_push($newarr, $getvar);
                                           
                                           ?>



                                                        @endif
                                                        @endforeach

                                                        @php
                                                        for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr
                                                            !=0){ @endphp @php
                                                            $getvalname=App\ProductValues::where('id',$newarr[$i])->
                                                            first();
                                                            @endphp

                                                            @if(strcasecmp($getvalname['values'],
                                                            $getvalname['unit_value']) != 0)

                                                            @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                            {{ $getvalname['values'] ?? '' }}
                                                            @else
                                                            {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                            @endif

                                                            @else


                                                            {{ $getvalname['values'] ?? '' }}

                                                            @endif

                                                            @php

                                                            try{

                                                            $icount = count($newarr);
                                                            if($i == 0){
                                                            if($i < $icount){ if($newarr[$i+1]==0){ }else{
                                                                if($newarr[$i]==0){ }else{ echo ',' ; } } } }else{ }
                                                                }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                                                @if($ratings_var !=0) <div class="pull-left star-right">
                                                                <div class="star-ratings-sprite"><span
                                                                        style="width:<?php echo $ratings_var; ?>%"
                                                                        class="star-ratings-sprite-rating"></span>
                                                                </div>
                                            </div>
                                            @else
                                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                            @endif




                                            <div class="description"></div>
                                            <div class="product-price"> <span class="price">

                                                    @if(!empty($conversion_rate))

                                                    @if($convert_price != 0)
                                                    <span class="price"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                                    </span>

                                                    <span class="price-before-discount"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                    </span>
                                                    @else

                                                    <span class="price"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                    </span>

                                                    @endif
                                                    @endif
                                            </div>
                                            <!-- /.product-price -->

                                        </div>
                                        <!-- /.product-info -->
                                         @if($sub->stock>0)
                                            <div class="cart clearfix animate-effect">
                                            <div class="action">
                                                <ul class="list-unstyled">
                                                    <li class="add-cart-button btn-group">
                                                        <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                            {{ csrf_field() }}
                                                               <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                                    
                                                    </form>
                                                </form>
                                                    </li>
                                                    @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                                    <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                                                </ul>
                                            </div>
                                            <!-- /.action -->
                                            </div>
                                        @endif
                                        <!-- /.cart -->
                                    </div>
                                    <!-- /.product -->

                                </div>
                                <!-- /.products -->
                            </div>
                            </div>
                            @else
                            
                            @endif
                            @endif

                            @endif
                            @endforeach
                            @else
                            
                            <?php 
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $count =  App\UserReview::where('pro_id',$product->id)->count();
                              if($count>0)
                              {
                                foreach(App\UserReview::where('pro_id',$product->id)->where('status','1')->get() as $review){
                                $review_t = $review->price*5;
                                $price_t = $review->price*5;
                                $value_t = $review->value*5;
                                $sub_total = $sub_total + $review_t + $price_t + $value_t;
                                }
                                $count = ($count*3) * 5;
                                $rat = $sub_total/$count;
                                $ratings_var = ($rat*100)/5;
                                
                              }else{
                                  $ratings_var = 0;
                              }
                                
                                ?>

                            @if($ratings_var != null && $start_rat !=null && $ratings_var >= $start_rat)
  
                            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                                <div class="item">
                                    <div class="products">
                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a href="{{ url($url) }}">
                                                        <div class="pro_img-box">
                                                            @if(count($product->subvariants)>0)

                                                        @if(isset($sub->variantimages['main_image']))
                                                         <img class="lazy filterdimage" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$product->name}}">
                                                         <img class="lazy filterdimage hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                                        @endif

                                                        @else
                                                        <img class="lazy filterdimage" title="{{ $product->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                                        
                                                        @endif
                                                        </div>
                                                       
                                                    </a>
                                                </div>
                                                <!-- /.image -->
                                                 <h6 align="center" class="oottext"><span>{{ __('staticwords.Outofstock') }}</span></h6>

                                                
                                            </div>
                                            <!-- /.product-image -->

                                            <div class="product-info text-left">

                                                <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                        @php
                                                        $newarr = array();
                                                        @endphp
                                                        (
                                                        @foreach($sub->main_attr_value as $k => $getvar)

                                                        @php
                                                        $getattrname =
                                                        App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                        @endphp

                                                        @php
                                                        $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                        @endphp

                                                        @if(strcasecmp($getvalname['values'], $getvalname['unit_value'])
                                                        != 0)


                                                        @php
                                                        $conversion_rates = array_push($newarr, $getvar);
                                                        @endphp
                                                        @else
                                                        <?php
                                       $conversion_rates = array_push($newarr, $getvar);
                                       
                                       ?>



                                                        @endif
                                                        @endforeach

                                                        @php
                                                        for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr
                                                            !=0){ @endphp @php
                                                            $getvalname=App\ProductValues::where('id',$newarr[$i])->
                                                            first();
                                                            @endphp

                                                            @if(strcasecmp($getvalname['values'],
                                                            $getvalname['unit_value']) != 0)

                                                            @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                            {{ $getvalname['values'] ?? '' }}
                                                            @else
                                                            {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                            @endif

                                                            @else


                                                            {{ $getvalname['values'] ?? '' }}

                                                            @endif

                                                            @php

                                                            try{

                                                            $icount = count($newarr);
                                                            if($i == 0){
                                                            if($i < $icount){ if($newarr[$i+1]==0){ }else{
                                                                if($newarr[$i]==0){ }else{ echo ',' ; } } } }else{ }
                                                                }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                                                @if($ratings_var !=0) <div class="pull-left star-right">
                                                                <div class="star-ratings-sprite"><span
                                                                        style="width:<?php echo $ratings_var; ?>%"
                                                                        class="star-ratings-sprite-rating"></span>
                                                                </div>
                                            </div>
                                            @else
                                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                            @endif




                                            <div class="description"></div>
                                            <div class="product-price"> <span class="price">

                                                    @if(!empty($conversion_rate))

                                                    @if($convert_price != 0)
                                                    <span class="price"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                                    </span>

                                                    <span class="price-before-discount"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                    </span>
                                                    @else

                                                    <span class="price"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                    </span>

                                                    @endif
                                                    @endif
                                            </div>
                                            <!-- /.product-price -->
                                            <!-- /.product-price -->

                                        </div>
                                        <!-- /.product-info -->
                                        @if($sub->stock>0)
                                            <div class="cart clearfix animate-effect">
                                            <div class="action">
                                                <ul class="list-unstyled">
                                                    <li class="add-cart-button btn-group">
                                                         <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                            {{ csrf_field() }}
                                                               <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                                    
                                                    </form>
                                                    </li>
                                                    @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                                    <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                                                </ul>
                                            </div>
                                            <!-- /.action -->
                                            </div>
                                        @endif
                                        <!-- /.cart -->
                                    </div>
                                    <!-- /.product -->

                                </div>
                                <!-- /.products -->
                            </div>
                            </div>
                            @else
                            @if($ratings == 0)

                            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4 col-6" id="updatediv">
                                <div class="item">
                                    <div class="products">
                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a href="{{ url($url) }}">
                                                        <div class="pro_img-box">
                                                            @if(count($product->subvariants)>0)

                                                        @if(isset($sub->variantimages['main_image']))
                                                         <img class="lazy filterdimage" data-src="{{url('variantimages/thumbnails/'.$sub->variantimages['main_image'])}}" alt="{{$product->name}}">
                                                         <img class="lazy filterdimage hover-image" data-src="{{url('variantimages/hoverthumbnail/'.$sub->variantimages['image2'])}}" alt=""/>
                                                        @endif

                                                        @else
                                                        <img class="lazy filterdimage" title="{{ $product->name }}" data-src="{{url('images/no-image.png')}}" alt="No Image"/>
                                                        
                                                        @endif
                                                        </div>
                                                        
                                                    </a>
                                                </div>
                                                <!-- /.image -->
                                                <h6 align="center" class="oottext"><span>{{ __('staticwords.Outofstock') }}</span></h6>

                                                
                                            </div>
                                            <!-- /.product-image -->

                                            <div class="product-info text-left">

                                                <h3 class="name"><a href="{{ url($url) }}">{{$product->name}}

                                                        @php
                                                        $newarr = array();
                                                        @endphp
                                                        (
                                                        @foreach($sub->main_attr_value as $k => $getvar)

                                                        @php
                                                        $getattrname =
                                                        App\ProductAttributes::where('id',$k)->first()->attr_name;
                                                        @endphp

                                                        @php
                                                        $getvalname = App\ProductValues::where('id',$getvar)->first();
                                                        @endphp

                                                        @if(strcasecmp($getvalname['values'], $getvalname['unit_value'])
                                                        != 0)


                                                        @php
                                                        $conversion_rates = array_push($newarr, $getvar);
                                                        @endphp
                                                        @else
                                                        <?php
                                         $conversion_rates = array_push($newarr, $getvar);
                                         
                                         ?>



                                                        @endif
                                                        @endforeach

                                                        @php
                                                        for($i = 0; $i<count($newarr); $i++){ $newarr[$i]; if($newarr
                                                            !=0){ @endphp @php
                                                            $getvalname=App\ProductValues::where('id',$newarr[$i])->
                                                            first();
                                                            @endphp

                                                            @if(strcasecmp($getvalname['values'],
                                                            $getvalname['unit_value']) != 0)

                                                            @if( $getvalname->proattr['attr_name'] == "Color" ||  $getvalname->proattr['attr_name'] == "Colour" ||  $getvalname->proattr['attr_name'] =="color" ||  $getvalname->proattr['attr_name'] == "colour")
                                                            {{ $getvalname['values'] ?? '' }}
                                                            @else
                                                            {{ $getvalname['values'] ?? '' }}{{ $getvalname['unit_value'] }}
                                                            @endif

                                                            @else


                                                            {{ $getvalname['values'] ?? '' }}

                                                            @endif

                                                            @php

                                                            try{

                                                            $icount = count($newarr);
                                                            if($i == 0){
                                                            if($i < $icount){ if($newarr[$i+1]==0){ }else{
                                                                if($newarr[$i]==0){ }else{ echo ',' ; } } } }else{ }
                                                                }catch(Exception $e){ } } } @endphp ) </a> </h3>
                                                                @if($ratings_var !=0) <div class="pull-left star-right">
                                                                <div class="star-ratings-sprite"><span
                                                                        style="width:<?php echo $ratings_var; ?>%"
                                                                        class="star-ratings-sprite-rating"></span>
                                                                </div>
                                            </div>
                                            @else
                                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                                            @endif




                                            <div class="description"></div>
                                            <div class="product-price"> <span class="price">

                                                    @if(!empty($conversion_rate))

                                                    @if($convert_price != 0)
                                                    <span class="price"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$convert_price * $conversion_rate)}}
                                                    </span>

                                                    <span class="price-before-discount"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                    </span>
                                                    @else

                                                    <span class="price"><i
                                                            class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$show_price * $conversion_rate)}}
                                                    </span>

                                                    @endif
                                                    @endif
                                            </div>
                                            <!-- /.product-price -->

                                        </div>
                                        <!-- /.product-info -->
                                        @if($sub->stock>0)
                                            <div class="cart clearfix animate-effect">
                                            <div class="action">
                                                <ul class="list-unstyled">
                                                    <li class="add-cart-button btn-group">

                                                       <form method="POST" action="{{route('add.cart',['id' => $product->id ,'variantid' =>$sub->id, 'varprice' => $show_price, 'varofferprice' => $convert_price ,'qty' =>$sub->min_order_qty])}}">
                                                            {{ csrf_field() }}
                                                               <button class="btn btn-primary icon"  type="submit"> <i class="fa fa-shopping-cart"></i> </button>
                                                                    
                                                      </form>
                                                        
                                                    </li>
                                                   @auth
                              @if(Auth::user()->wishlist->count()<1)
                                <li class="lnk wishlist"> 

                                <a mainid="{{ $sub->id }}" title="{{ __('staticwords.AddToWishList') }}" class="add-to-cart addtowish cursor-pointer" data-add="{{url('AddToWishList/'.$sub->id)}}" title="{{ __('staticwords.AddToWishList') }}"> <i class="icon fa fa-heart"></i> 
                                </a> 

                                </li>
                              @else

                                @php
                                  $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$sub->id)->first();
                                @endphp

                                  @if(!empty($ifinwishlist)) 
                                       <li class="lnk wishlist active">
                                        <a mainid="{{ $sub->id }}"  title="{{ __('staticwords.RemoveFromWishlist') }}" class="add-to-cart removeFrmWish active cursor-pointer color000" data-remove="{{url('removeWishList/'.$sub->id)}}" > <i class="icon fa fa-heart"></i> </a> 
                                      </li>
                                  @else
                                      <li class="lnk wishlist"> <a title="{{ __('staticwords.AddToWishList') }}" mainid="{{ $sub->id }}" class="add-to-cart addtowish cursor-pointer color-white" data-add="{{url('AddToWishList/'.$sub->id)}}" > <i class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                @endif
                              @endauth
                                                    <li class="lnk"> <a class="add-to-cart" href="{{route('compare.product',$sub->products->id)}}" {{ __('staticwords.Compare') }}> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                                                </ul>
                                            </div>
                                            <!-- /.action -->
                                            </div>
                                        @endif
                                        <!-- /.cart -->
                                    </div>
                                    <!-- /.product -->

                                </div>
                                <!-- /.products -->
                            </div>
                            </div>
                            @else
                           
                            @endif
                            @endif

                            @endif
                            @endif
                            @endif



                            @endif
                            @endif


                            @endforeach
                            @endforeach
                            @else
                            <div class="mx-auto">
                                <img class="lazy" data-src="{{ url('images/nocart.jpg') }}" alt="404 Not Found"
                                    title="No Matching conversion_rate Found or there is no product in this category !">
                                <h3>{{ __('No Matching Product Found or there is no product in this category !') }}</h3>
                            </div>
                            @endif
                              <?php
                               if($pricing != null){
                                  $first_cat=min($pricing);
                                  $last_cat=max($pricing);
                               }else{
                                  $first_cat=0;
                                  $last_cat=0;
                               }
                               if($brand_names == null || $tags_pro == null){
                                $brandAvl = 0;
                               }else{
                                $brandAvl = 1;
                               }
                               if($slider == 'yes'){
                                 $sliding = 1;
                               }else{
                                 $sliding = 0;
                               }
                              ?>

                          


<script>var baseUrl = "<?= url('/') ?>";</script>
<script data-src="{{ url('js/wishlist.js') }}"></script>
<script>
  var lprice = {!! json_encode( $first_cat * round($conversion_rate, 4) ) !!};
  var hprice = {!! json_encode( $last_cat * round($conversion_rate, 4) ) !!};
  var brandAvl = '{!! json_encode( $brandAvl ) !!}';
  var sliding = '{!! json_encode($sliding) !!}';
  var tag_chk = '{!! json_encode($tag_check) !!}';
</script>
<script data-src="{{asset('js/filterproduct.js')}}"></script>