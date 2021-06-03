@extends("front/layout.master")
@section('title',__('staticwords.ShoppingCart').' | ')
@section("body")
<div class="breadcrumb">
  <div class="container-fluid">
    <div class="breadcrumb-inner">
      <ul class="list-inline list-unstyled">
        <li><a href="#">{{ __('staticwords.Home') }}</a></li>
        <li class='active'>{{ __('staticwords.ShoppingCart') }}</li>
      </ul>
    </div><!-- /.breadcrumb-inner -->
  </div><!-- /.container -->
</div><!-- /.breadcrumb -->
@php
  $pro = Session('pro_qty');
  
  $value = Session::get('cart');

  if (Auth::check())
  {
      $count = $cart_table->count();
  }
  else
  {
      if (isset($value))
      {
          $count = count($value);
      }
      else
      {
          $count = 0;
      }
  }

  if(Auth::check()){
    
      $usercart = $count;
  }else{
      
      $usercart = session()->get('cart');
  }
@endphp
<div class="container-fluid">
  @if($usercart > 0 && $usercart != null)
 
  <div class="row shoppingcart-mainblock" data-sticky-container>
     <div class="col-md-9">
      @if(Session::has('validcurrency'))
        <br>
        <div class="alert alert-danger">
          <i class="fa fa-info-circle"></i> <b>{{ __('staticwords.Oscur') }} <u>{{ Session::get('currency')['id'] }}</u> {{ __('staticwords.CerrorMsg') }} !</b>
        </div>
      @endif

        <div class="shopping-cart shopping-cart-top">
          <h2 class="heading-title"><?php echo $count; ?> {{ __('staticwords.Products') }} <span>{{ __('staticwords.inyourcart') }}</span></h2>
          <div class="shopping-cart-block">
             @if(Auth::check())
         
              @foreach($cart_table as $row)

              @php
                 $orivar = $row->variant;
              @endphp
            
             
              @isset($orivar)
              
              <div class="row product">
                <div class="col-md-1 col-xs-3">
                  <div class="cart-image">
                    <a class="entry-thumbnail" href="" title="">
                     <img class="img-responsive" src="{{url('variantimages/thumbnails/'.$orivar->variantimages['main_image'])}}" alt="">
                    </a>
                  </div>
                </div>
                <div class="col-md-4 col-xs-9">
                  <div class="cart-product-name-info">
                    <h4 class='cart-product-description'>
  
  
                       @php
  
                        $var_name_count = count($orivar['main_attr_id']);
                        $name;
                        $var_name;
  
                              $newarr = array();
                              for($i = 0; $i<$var_name_count; $i++){
                                $var_id =$orivar['main_attr_id'][$i];
                                $var_name[$i] = $orivar['main_attr_value'][$var_id];
                                 
                                  $name[$i] = App\ProductAttributes::where('id',$var_id)->first();
                                  
                              }
  
  
                            try{
                              $url = url('details').'/'.$row->pro_id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                            }catch(\Exception $e)
                            {
                              $url = url('details').'/'.$row->pro_id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                            }
  
                        @endphp
  
                      <a href="{{ url($url) }}">{{$row->product->name}}</a>
                      <br>
  
                      <small>
                        (
  
                      @php
                        $varinfo = $row->variant;
                        $varcount = count($varinfo->main_attr_value);
                        $i=0;
                      @endphp
                      
                      @foreach($varinfo->main_attr_value as $key=> $orivar)
                      <?php $i++; ?>
  
                          @php
                            $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
                            $getvarvalue = App\ProductValues::where('id',$orivar)->first();
                          @endphp
  
                          @if($i < $varcount)
                            @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
                              @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                              {{ $getvarvalue->values }},
                              @else
                              {{ $getvarvalue->values }} {{ $getvarvalue->unit_value }},
                              @endif
                            @else
                              {{ $getvarvalue->values }},
                            @endif
                          @else
                            @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
                             @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                             {{ $getvarvalue->values }}
                             @else
                              {{ $getvarvalue->values }} {{ $getvarvalue->unit_value }}
                             @endif
                            @else
                              {{ $getvarvalue->values }}
                            @endif
                          @endif
                      @endforeach
                      )
                      </small>
                    </h4>                
                          
                             
                            @if(count($row->product->reviews))
  
                            @php
                                $review_t = 0;
                                $price_t = 0;
                                $value_t = 0;
                                $sub_total = 0;
                                $count =  $row->product->reviews()->count();

                                foreach($row->product->reviews as $review){
  
                                  $review_t = $review->price*5;
                                  $price_t = $review->price*5;
                                  $value_t = $review->value*5;
                                  $sub_total = $sub_total + $review_t + $price_t + $value_t;

                                }

                                $count = ($count*3) * 5;
                                
                                if($count != 0){
                                  $rat = $sub_total/$count;
                                  $ratings_var = ($rat*100)/5;
                                }
  
                                  
                              @endphp
  
                             
                            <div class="pull-left">
                              <div class="star-ratings-sprite">
                                <span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                              </div>
                            </div>
                            <br>
                           
                             @else
                              {{'No Rating'}}
                              <br>
                              @endif
                                  
                       
                    <div class="cart-product-info">
                      <span class="product-color"><b>{{ __('staticwords.SoldBy') }}:</b> <span>{{$row->product->store->name}}</span></span><br/>
                     
                      
                      @foreach($varinfo->main_attr_value as $key=> $orivar)
                        
                        @php
                          $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
                          $getvarvalue = App\ProductValues::where('id',$orivar)->first();
                        @endphp
                        <span class="product-color"><b>
  
                            @php
                                $k = '_'; 
                            @endphp
                            @if (strpos($getattrname, $k) == false)
                           
                              {{ $getattrname }}:
                             
                               
                            @else
                              
                              {{str_replace('_', ' ', $getattrname)}}:
                              
                            @endif
  
                            </b>
  
                            </span>
  
  
                         @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
                          @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                         
                        <div class="display-inline">
                          <div class="color-options">
                            <ul>
                               <li title="{{ $getvarvalue->values }}" class="color varcolor active"><a href="#" title=""><i style="color: {{ $getvarvalue->unit_value }}" class="fa fa-circle"></i></a>
                                      <div class="overlay-image overlay-deactive">
                                      </div>
                                </li>
                            </ul>
                          </div>
                        </div>
  
                          @else
                          <span>{{ $getvarvalue->values }} {{ $getvarvalue->unit_value }}</span>
                          @endif
                          <br>
                          @else
                          <span>{{ $getvarvalue->values }} </span>
                           <br> 
                          @endif
                      @endforeach
  
                      @if($varinfo->stock ==0)
                        <h4 class="text-red">{{ __('staticwords.CurrentlyOutofstock') }}</h4>
                      @endif
                    </div>
                  </div>
                </div>
  
                <div class="col-md-2 col-xs-3">
                  <div class="cart-product-quantity">
                    <div class="quant-input">
                      <div class="cart-product-quantity">
                                        <?php
  
                                          $id = $row->variant_id; 
  
                                          if($row->variant->max_order_qty == null || $row->variant->max_order_qty == 0 || $row->variant->max_order_qty == '')
                                          {
                                             $product_stock = $row->variant->stock;
                                          }else{
                                             $product_stock = $row->variant->max_order_qty;
                                          }
     
                                        ?>
              
                      <input type="number" id="rent-day" data-id="{{$row->id}}" data-type="sp" data-pr="{{$product_stock}}" name="quantity" value="{{$row->qty}}" price ="{{$row->price_total}}" variant="{{ $id }}" offerprice= "{{$row->semi_total}}" max="{{$product_stock}}" min="{{$row->variant->min_order_qty}}" >
  
                      </div> 
                    </div> 
                  </div> 
                </div>
                <div class="col-md-4 col-xs-9">
                  <div class="cart-product-name-info cart-price ">
                    <div class="cart-product-name-info cart-price ">
  
                      <div class="price-box cart-product-grand-total cart-product-sub-total">
                           @if($row->semi_total == 0)
                             <i class="price {{session()->get('currency')['value']}}"></i><span class="price cart-grand-total-price cart-sub-total-price" id="{{$row->id}}">
                               {{sprintf("%.2f",$row->price_total*$conversion_rate,2)}}
                             </span>
                           @else
                             <i class="price {{session()->get('currency')['value']}}"></i><span class="price cart-grand-total-price cart-sub-total-price" id="{{$row->id}}">
                              {{sprintf("%.2f",$row->semi_total*$conversion_rate,2)}}
                             </span>
  
                              <i class="price-strike {{session()->get('currency')['value']}}"></i><span class="price-strike" id="strike{{$row->id}}">{{sprintf("%.2f",$row->price_total*$conversion_rate,2)}}</span>
                           @endif
                       
                       
                      </div>            
                    </div>           
                  </div>
                  <div class="romove-item cart-price ">
                     <ul>
                    @if(Auth::user()->wishlist->count()<1)
                      
                      <li><a id="addtowish{{ $row->variant_id }}" onclick="addtowishlist('{{ $row->variant_id  }}')" title="Add to wishlist" class="cursor-pointer icon addtowish">{{ __('staticwords.AddToWishList') }} <i class="icon fa fa-heart"></i></a></li>
                     
                    @else
  
                      @php
                         $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$row->variant_id)->first();
                      @endphp
                      
                      @if(!empty($ifinwishlist)) 
                        <li><a id="removefromwish{{ $row->variant_id }}" onclick="removefromwishlist('{{ $row->variant_id  }}')" title="{{ __('staticwords.RemoveFromWishlist') }}" class="cursor-pointer icon removeFrmWish">{{ __('staticwords.RemoveFromWishlist') }} <i class="fa fa-heart-o"></i></a></li>
                      @else
  
                        <li><a id="addtowish{{ $row->variant_id }}" onclick="addtowishlist('{{ $row->variant_id  }}')" title="Add to wishlist" class="cursor-pointer icon addtowish">{{ __('staticwords.AddToWishList') }} <i class="icon fa fa-heart"></i></a></li>
                      @endif
                    @endif
                    
                     <li><a href="{{url('remove_table_cart/'.$row->variant_id)}}" title="Remove from cart" class="icon">{{ __('staticwords.Remove') }} <i class="fa fa-trash-o"></i></a></li>
                      
                      
                    </ul>
                  </div>
                </div>
              </div>
  
              @endisset
<!-- ======================== small screen start ============================= -->
<!-- ======================== ================== ============================= -->
            
            <!-- ====================== small screen end =================== -->
            <!-- ======================== ================== ============================= -->
            <hr>
          
            @endforeach
           
           @else
            @if(!empty(session()->get('cart')))
                @foreach($cts = Session::get('cart') as $ckey=> $row)

                  <form action="#" method="post">
                      {{ csrf_field() }}

                            @php 

                              $pro = App\Product::withTrashed()->where('id',$row['pro_id'])->first();
                              $orivar = App\AddSubVariant::withTrashed()->where('id','=',$row['variantid'])->first();
                    

                              $var_name_count = count($orivar['main_attr_id']);
                              unset($name);
                              $name = array();
                              $var_name;
                                  
                                    $newarr = array();
                                    for($i = 0; $i<$var_name_count; $i++){
                                      $var_id =$orivar['main_attr_id'][$i];
                                      $var_name[$i] = $orivar['main_attr_value'][$var_id];
                                      
                                      array_push($name,App\ProductAttributes::where('id',$var_id)->first());

                                      
                                    }

                                
                                  try{
                                    $url = url('details').'/'.$row['pro_id'].'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                                  }catch(Exception $e)
                                  {
                                    $url = url('details').'/'.$row['pro_id'].'?'.$name[0]['attr_name'].'='.$var_name[0];
                                  }

                              @endphp

                    <div class="row product">
                      <div class="col-md-1 col-xs-3">
                        <div class="cart-image">
                          
                          <a class="entry-thumbnail" href="{{url($url)}}" title="">
                            <img class="img-responsive" src="{{url('/variantimages/thumbnails/'.$orivar->variantimages['main_image'])}}" alt="">
                          </a>
                        </div>
                      </div>
                      <div class="col-md-4 col-xs-9">
                        <div class="cart-product-name-info">
                          <h4 class='cart-product-description'><a href="{{url($url)}}" title="">{{$pro->name}}</a></h4>                
                          <?php
                          $reviews = App\UserReview::where('pro_id',$row['pro_id'])->where('status','1')->get(); 
                        

                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $count =  count($reviews);
                              foreach($reviews as $review){

                              $review_t = $review->price*5;
                              $price_t = $review->price*5;
                              $value_t = $review->value*5;
                              $sub_total = $sub_total + $review_t + $price_t + $value_t;
                            }
                            if($count != 0){
                              $count = ($count*3) * 5;
                              $rat = $sub_total/$count;
                              $ratings_var = ($rat*100)/5;
                            }
                            
                          
                        
                        ?>
                        @if(count($reviews)!=0)
                          <div class="pull-left">
                          <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span></div>
                          </div>
                          <br>
                        @else
                          {{ __('No Rating') }}
                        @endif
                          <div class="cart-product-info">
                          <span class="product-color"><b>{{ __('staticwords.SoldBy') }}:</b> <span>
                              <?php 

                                $store = App\Store::where('id',$pro->store_id)->first();
                              
                              ?>
                              {{$store->name}}
                            </span></span>
                            <br>
                            @php
                            $varinfo = App\AddSubVariant::withTrashed()->where('id','=',$row['variantid'])->first();
                            @endphp
                            
                            @foreach($varinfo->main_attr_value as $key=> $orivar)
                              
                              @php
                                $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
                                $getvarvalue = App\ProductValues::where('id',$orivar)->first();
                              @endphp
                              <span class="product-color"><b>
                                  @php
                                      $k = '_'; 
                                  @endphp
                                  @if (strpos($getattrname, $k) == false)
                                  
                                    {{ $getattrname }}
                                    
                                  @else
                                    
                                    {{str_replace('_', ' ', $getattrname)}}
                                    
                                  @endif
                              </b>: 


                              @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
                                @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                                <div class="display-inline">
                                <div class="color-options">
                                  <ul>
                                    <li title="{{ $getvarvalue->values }}" class="color varcolor active"><a href="#" title=""><i style="color: {{ $getvarvalue->unit_value }}" class="fa fa-circle"></i></a>
                                            <div class="overlay-image overlay-deactive">
                                            </div>
                                      </li>
                                  </ul>
                                </div>
                              </div>
                                @else
                                <span>{{ $getvarvalue->values }} {{ $getvarvalue->unit_value }}</span>
                                @endif
                                <br>
                                @else
                                <span>{{ $getvarvalue->values }} </span></span>
                                <br> 
                                @endif
                            @endforeach
                          </div>

                        </div>
                      </div>

                      <div class="col-md-2 col-xs-3">
                        <div class="cart-product-quantity">
                          <div class="quant-input">
                            <div class="cart-product-quantity">
                                              <?php
                                              
                                              $s = App\AddSubVariant::withTrashed()->where('id', '=', $row['variantid'])->first();

                                              $limit = 0;

                                              if($s->max_order_qty == '' || $s->max_order_qty == null){
                                                $limit = $s->stock;
                                              }else{
                                                $limit = $s->max_order_qty;
                                              }
          
                                              ?>
                    
                                      <input type="number" onchange="qtych('{{ $row['variantid'] }}')" id="rent-day{{ $row['variantid'] }}" data-id="{{$s->products->id}}" data-type="sp" data-pr="{{$limit}}" name="quantity" value="{{$row['qty']}}" price ="{{$row['varprice']}}" offerprice= "{{$row['varofferprice']}}" variant="{{ $s->id }}" max="{{$limit}}" min="1" >

                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-xs-9">
                        <div class="cart-product-name-info cart-price text-right">
                          <div class="cart-product-name-info cart-price text-right">
                            
                            @if($row['varofferprice'] == 0)
                                <div class="price-box cart-product-grand-total cart-product-sub-total">
                              
                              <i class="price {{session()->get('currency')['value']}}"></i><span class="price cart-grand-total-price cart-sub-total-price" id="nofferss{{ $row['variantid'] }}">{{sprintf("%.2f",$row['qty']*$row['varprice']*$conversion_rate,2)}}</span>

                              
                            </div> 
                            @else

                            <div class="price-box cart-product-grand-total cart-product-sub-total">
                              
                            <i class="price {{session()->get('currency')['value']}}"></i><span id="offer_p{{ $row['variantid'] }}" class="price cart-grand-total-price cart-sub-total-price">{{sprintf("%.2f",$row['qty']*$row['varofferprice']*$conversion_rate,2)}}</span>

                              <i class="price-strike {{session()->get('currency')['value']}}"></i><span class="price-strike" id="nofferss{{ $row['variantid'] }}">@if(Empty($row['varofferprice'])) @else {{ sprintf("%.2f",$row['qty']*$row['varprice']*$conversion_rate,2) }} @endif</span>
                            </div> 


                            @endif
                                    
                          </div>           
                        </div>
                        
                        <div class="romove-item cart-price text-right">
                          <ul>
                            <li><a href="{{url('remove_cart/'.$row['variantid'])}}" title="Remove this item from cart?" class="icon">{{ __('staticwords.Remove') }} <i class="fa fa-trash-o"></i></a>
                            </li>
                            
                          </ul>
                        </div>
                        
                      </div>
                    </div>
                    <hr>
                  </form>

                @endforeach
            @endif
            @endif
          </div>         
        </div>
        <br>
        <div class="col-md-6 nogrid-left nogrid-left-one">
           <div class="shopping-cart shopping-cart-widget">
            
             @if(Session::has('fail'))
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('fail') }}
              </div>
             @endif

              @if(Auth::check() && App\Cart::isCoupanApplied() == 1)
                <div class="alert alert-success">
                  <form action="{{ route('removecpn') }}" method="POST">
                    @csrf
                    <button type="submit" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </form>
                    <b>{{ App\Cart::getCoupanDetail()->code.' applied successfully !'  }}</b>
                </div>
             @endif

             @if(Session::has('coupanapplied'))
                <div class="alert alert-success">
                  <form action="{{ route('removecpn') }}" method="POST">
                    @csrf
                    <button type="submit" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </form>
                    <b>{{ session()->get('coupanapplied')['code'].' applied successfully !'  }}</b>
                </div>
             @endif

              <form action="{{ route('apply.cpn') }}" method="POST">
                @csrf
                <div class="form-group">
                  <h4>{{ __('staticwords.ApplyCouponorVouchers') }}</h4>
                  <input value="@if(App\Cart::getCoupanDetail()) {{App\Cart::getCoupanDetail()->code}} @elseif(session()->has('coupanapplied')) {{ session()->get('coupanapplied')['code'] }} @endif" required="" class="form-control" name="coupon" type="text" placeholder="{{ __('staticwords.Haveacoupon') }}?">
                </div>
                <button type="submit" class="btn btn-primary checkout-btn">{{ __('staticwords.APPLY') }}</button>
              </form>
           </div>
        </div>

      </div>
       
       <div class="col-md-3 nogrid-left"  data-sticky data-sticky-for="992" data-margin-top="20"> 
        <div class="shopping-cart shopping-cart-widget">
          <h2 class="heading-title">{{ __('staticwords.PaymentDetails') }}</h2>
          <div class="cart-shopping-total">           
                    <div class="cart-sub-total totals-value" id="cart-total">
                      <div class="row">
                        <div class="col-md-6 col-xs-6 value-left">{{ __('staticwords.Subtotal') }}</div>
                        <div class="col-md-6 col-xs-6 value-right">
                          <i class="{{session()->get('currency')['value']}}"></i>
                          <span class="" id="show-total">
                            @php
                                $total = 0;
                            @endphp
                          @guest
                           @if(!empty(Session::get('cart')))

                           @php
                            $oot = array();
                           @endphp

                              @foreach($cts = Session::get('cart') as $key => $c)
                                
                                @php
                                  $stock = App\AddSubVariant::withTrashed()->find($c['variantid'])->stock;
                                @endphp

                                @if($stock == 0)
                                  @php
                                      array_push($oot, 0);
                                  @endphp
                                @endif

                                @if($c['varofferprice'] == '' || $c['varofferprice'] == 0 || $c['varofferprice'] == null)
                                  
                                  @php
                                      $price = $cts[$key]['qty']*$cts[$key]['varprice'];
                                  @endphp

                                @else

                                  @php
                                     $price = $cts[$key]['qty']*$cts[$key]['varofferprice'];
                                  @endphp

                                @endif

                                @php

                                  $total = $total+$price;
                                  
                                @endphp
                              @endforeach
                           {{sprintf("%.2f",$total*$conversion_rate,2)}}

                           @endif
                           @else
                              @php
                                  $cart_table = App\Cart::where('user_id',auth()->user()->id)->get();
                                 
                                  $oot = array();
                              @endphp

                              @if(!empty($cart_table))
                                @foreach($cart_table as $c)

                                @php
                                  $stock = App\AddSubVariant::withTrashed()->find($c->variant_id);
                                @endphp

                                @if(isset($stock) && $stock->stock == 0)
                                  @php
                                      array_push($oot, 0);
                                  @endphp
                                @endif

                                    @if($c->semi_total == '' || $c->semi_total == null)
                                        @php  $price = $c->price_total; @endphp
                                    @else
                                        @php  $price = $c->semi_total; @endphp
                                    @endif

                                    @php $total= $total+$price; @endphp
                                @endforeach
                              @endif
                        
                              {{ sprintf("%.2f",$total*$conversion_rate,2) }}
                           @endif

                            
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="cart-sub-total">
                      <div class="row">
                        <div class="col-md-6 col-xs-6 value-left">{{ __('staticwords.Shipping') }}</div>
                        <div class="col-md-6 col-xs-6 value-right">
                          <i class="{{session()->get('currency')['value']}}"></i>
                          <span class="" id="shipping">

                          <?php $shipping = 0; ?>
                          @if(Auth::check())
                            @foreach($cart_table as $key=>$cart)

                              @if($cart->product->free_shipping==0)
                                  
                                @php
                                    $shipping += ShippingPrice::calculateShipping($cart);
                                @endphp
                              
                              @if($genrals_settings->cart_amount != 0 || $genrals_settings->cart_amount != '')
                                
                                @if($total*$conversion_rate >= $genrals_settings->cart_amount*$conversion_rate)
                                   
                                  @php
                                    
                                    $shipping = 0;
                                    
                                  @endphp

                                @endif
                              
                              @endif
                            
                              @endif 

                          @endforeach
                              @else
                              <?php if(!empty($value)){  ?>
                          
                             @foreach($value as $key=>$cart)
                             @php
                               $pro = App\Product::withTrashed()->where('id','=',$cart['pro_id'])->first();
                               $variant = App\AddSubVariant::withTrashed()->where('id','=',$cart['variantid'])->first();
                               $free_shipping = App\Shipping::where('id',$pro->shipping_id)->first();
                             @endphp
                            @if($pro->free_shipping==0)
                                
                           <?php  

                                if(!empty($free_shipping)){
                                  if($free_shipping->name=="Shipping Price")
                                        {

                                        $weight = App\ShippingWeight::first();
                                        $pro_weight =  $variant->weight;
                                        if($weight->weight_to_0 >= $pro_weight)
                                        {
                                           if($weight->per_oq_0=='po')
                                          {
                                            $shipping = $shipping+$weight->weight_price_0;
                                          }
                                          else{
                                              $shipping = $shipping+$weight->weight_price_0*$cart['qty'];
                                          }
                                        }
                                        elseif($weight->weight_to_1 >= $pro_weight){
                                             if($weight->per_oq_1=='po')
                                          {
                                            $shipping = $shipping+$weight->weight_price_1;
                                          }
                                          else{
                                              $shipping = $shipping+$weight->weight_price_1*$cart['qty'];
                                          }
                                        }
                                        elseif($weight->weight_to_2 >= $pro_weight){
                                             if($weight->per_oq_2=='po')
                                          {
                                            $shipping = $shipping+$weight->weight_price_2;
                                          }
                                          else{
                                              $shipping = $shipping+$weight->weight_price_2*$cart['qty'];
                                          }
                                        }
                                        elseif($weight->weight_to_3 >= $pro_weight){
                                           if($weight->per_oq_3=='po')
                                          {
                                            $shipping = $shipping+$weight->weight_price_3;
                                          }
                                          else{
                                              $shipping = $shipping+$weight->weight_price_3*$cart['qty'];
                                          }
                                        }
                                        else{
                                           if($weight->per_oq_4=='po')
                                          {
                                            $shipping = $shipping+$weight->weight_price_4;
                                          }
                                          else{
                                              $shipping = $shipping+$weight->weight_price_4*$cart['qty'];
                                          }
                                            
                                        }
                                          
                                      }else{
                                          
                                          $shipping = $shipping+$free_shipping->price;    

                                      }
                                }
                                  
                           ?>

                           

                            @endif 

                            @if($genrals_settings->cart_amount != 0 || $genrals_settings->cart_amount != '')
                                
                                @if($total*$conversion_rate >= $genrals_settings->cart_amount*$conversion_rate)
                                  @php
                                    $shipping = 0;
                                  @endphp
                                @endif
                              
                              @endif


                            
                            @endforeach
                           <?php } ?>
                            @endif
                              
                              {{  sprintf("%.2f", $shipping*$conversion_rate) }} 
                             
                          </span>
                        </div>
                      </div>
                    </div>
                     @if(App\Cart::isCoupanApplied() == '1')
                      <div class="cart-sub-total">
                      <div class="row">
                        <div class="col-md-6 col-xs-6 value-left">{{ __('staticwords.Discount') }}</div>
                        <div class="col-md-6 col-xs-6 value-right">
                          - <i class="{{session()->get('currency')['value']}}"></i> <span class="" id="discountedam">
                            {{  sprintf("%.2f", App\Cart::getDiscount()*$conversion_rate) }}
                        </span>
                        </div>
                      </div>
                    </div>
                     @endif


                     @if(Session::has('coupanapplied'))
                     
                      <div class="cart-sub-total">
                      <div class="row">
                        <div class="col-md-6 col-xs-6 value-left">{{ __('staticwords.Discount') }}</div>
                        <div class="col-md-6 col-xs-6 value-right">
                          - <i class="{{session()->get('currency')['value']}}"></i> <span class="" id="discountedam">
                          
                           {{  sprintf("%.2f", session()->get('coupanapplied')['discount'] * $conversion_rate) }}
                        </span>
                        </div>
                      </div>
                    </div>
                     @endif

                    <div class="cart-grand-total">
                      <div class="row">
                        <div class="col-md-6 col-xs-6 value-left">{{ __('staticwords.GrandTotal') }}</div>
                        <div class="col-md-6 col-xs-6 value-right">
                          @php

                          
                            $total = sprintf('%.2f',$total*$conversion_rate);

                            $shipping = sprintf("%.2f",$shipping * $conversion_rate);

                            if(App\Cart::isCoupanApplied() == '1'){


                                $gtotal = ($shipping+$total) - sprintf(App\Cart::getDiscount() * $conversion_rate);

                            }else{

                                $gtotal = $shipping + $total;

                            }

                            if(!Auth::check()){

                                if(Session::has('coupanapplied')){
                                  
                                  $gtotal = ($shipping+$total) - (session()->get('coupanapplied')['discount'] * $conversion_rate);

                                }else{

                                  $gtotal = $shipping + $total;

                                }

                            }
                            
                            Session::put('shippingrate',$shipping);

                          @endphp
                          <i class="{{session()->get('currency')['value']}}"></i> <span class="" id="gtotal">
                          {{ sprintf("%.2f",$gtotal,2) }}
                        </span>
                        </div>
                      </div>
                    </div>

                   @auth
                        <?php  $c = count($cart_table); ?>
                   @else
                        <?php  $c = count([Session::get('cart')]);?>
                   @endauth
                 
                  
                      <div class="cart-checkout-btn">
                      @if(!Session::has('validcurrency'))
                       @if(!empty($oot) && in_array(0, $oot) || $c<1)
                       <button type="button" disabled="disabled" class="btn btn-primary checkout-btn">{{ __('staticwords.PROCCEDTOCHECKOUT') }}</button>
                       @else
                       @if(count([Session::get('cart')])>0)
                        <form action="{{url('checkout')}}" method="GET">
                          {{ csrf_field() }}

                        <button type="submit" class="btn btn-primary checkout-btn">{{ __('staticwords.PROCCEDTOCHECKOUT') }}</button>
                      </form>
                      @endif
                       @endif
                      @else
                         <button type="button" disabled="disabled" class="btn btn-primary checkout-btn">{{ __('staticwords.PROCCEDTOCHECKOUT') }}</button>
                      @endif
                      @auth
                        {{-- When user logged in empty cart by table--}}
                        
                        <form action="{{ route('empty.cart') }}" method="POST">
                          @csrf
                           <button type="submit" class="btn btn-primary checkout-btn">{{ __('staticwords.EmptyCart') }}</button>
                        </form> 

                      @else
                        {{-- When user logged in empty cart by session--}}
                        @if(Session::has('cart'))

                          <?php $token = md5(uniqid(rand(), true)); ?>
                          {{-- When user logged in empty cart by session--}}
                          <form action="{{ route('s.cart',$token) }}" method="POST">
                            @csrf
                             <button type="submit" class="btn btn-primary checkout-btn">{{ __('staticwords.EmptyCart') }}</button>
                          </form> 

                        @endif

                      @endauth
                        <!-- <span class="">Checkout with multiples address!</span> -->
                      </div>

          </div>
        </div>
      </div>
    </div>
    @else
      <div class="card">
        <div class="card-body">
          <h2 class="m-1 text-center text-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
            {{ __('staticwords.YourShoppingcartisempty') }}</h2>
        </div>
      </div>
 <br>
    @endif
</div>

@endsection
@section('script')
  <script>
    "use strict";
    
    $(function () {
  
    var conversion_rate = '{{ $conversion_rate }}';
    $('.cart-product-quantity input').change( function() {
        var p = $(this).attr('price');
        var op = $(this).attr('offerprice');
        var variantId = $(this).attr('variant');
    });
    var urlLike='{{route('rentdays')}}';
    $("body").on("change keyup", "#rent-day", function(t) {
      t.preventDefault();

        var p = $(this).attr('price');
        var op = $(this).attr('offerprice');
        var variantId = $(this).attr('variant');

          var e = $(this).val();
         
          var z = $(this).data("id");
          var stock = $(this).data("pr");
          
          if (e == stock){
             swal({
                title: "Limit reached",
                text: 'Max Order quantity limit reached !',
                icon: 'warning'
              });
          }
         
          $.ajax({
          headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          type: "GET",
          url: urlLike,
          data: {
              days: e,
              id: z,
              variant_id : variantId,
              price : p,
              offerprice : op
             
          },

        error: function (jqXHR, exception) {

        }
      }).done(function(t) {


         var pricetotal = t.pricetotal*conversion_rate;

         pricetotal = pricetotal.toFixed(2);
           
          $('#show-total').text(pricetotal);
          if(t.singletotal == 0){
            var singletotal = t.singletotal*conversion_rate;
            singletotal = singletotal.toFixed(2);
            $('#'+t.id).text(singletotal);
            $('#strike'+t.id).text();
          }
          else{
            var singletotal = t.singletotal*conversion_rate;
            singletotal = singletotal.toFixed(2);

            var noffertotal = t.noffertotal*conversion_rate;
            noffertotal     = noffertotal.toFixed(2);
            $('#'+t.id).text(singletotal);
            $('#strike'+t.id).text(noffertotal);
          }

          var discount = t.per*conversion_rate
          discount = discount.toFixed(2);
         
          var gtotal = t.gtotal*conversion_rate;
          gtotal     = gtotal.toFixed(2);
          $('#total_cart').text(gtotal);

          var shipping = t.shipping*conversion_rate;
          shipping     = shipping.toFixed(2);
          
          $('#shipping').text(t.shipping*conversion_rate);
 
          $('#discountedam').text(discount);

          $('#gtotal').text(gtotal);

          $('#send').val(shipping);

          $('#subtotal').text(gtotal);

          $('#qty'+t.id).text(e);
        
         
    }).fail(function() {
      console.log("Error occur !"); 
      })
  });
  });
  
    function qtych(id)
    {
        var conversion_rate = '{{ $conversion_rate }}';
        var urlLike='{{route('rentdays')}}';
        var p = $('#rent-day'+id).attr('price');
        var op = $('#rent-day'+id).attr('offerprice');
        var variantId = $('#rent-day'+id).attr('variant');
        var e = $('#rent-day'+id).val();
         
          var z = $('#rent-day'+id).data("id");
          var stock = $('#rent-day'+id).data("pr");
          if (e == stock){
            swal({
                title: "Limit reached",
                text: 'Max Order quantity limit reached !',
                icon: 'warning'
              });
          }
         
          $.ajax({
          headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          type: "GET",
          url: urlLike,
          data: {
              days: e,
              id: z,
              variant_id : variantId,
              price : p,
              offerprice : op
             
          },

      error: function (jqXHR, exception) {
    
}
      }).done(function(t) {

         
          
          var pricetotal = t.pricetotal*conversion_rate;
          pricetotal = pricetotal.toFixed(2); 
          $('#show-total').text(pricetotal);
          
          if(singletotal == 0){
            var singletotal = t.singletotal*conversion_rate;
            singletotal = singletotal.toFixed(2);
            $('#nofferss'+t.variant_id).text(singletotal);
          }
          else{
              var singletotal = t.singletotal*conversion_rate;
              singletotal = singletotal.toFixed(2);

              var noffertotal = t.noffertotal*conversion_rate;
              noffertotal = noffertotal.toFixed(2);

             $('#offer_p'+t.variant_id).text(singletotal);
             $('#nofferss'+t.variant_id).text(noffertotal);
          }
         
          var total = t.total*conversion_rate;
          total = total.toFixed(2);
          $('#total_cart').text(total);

          var shipping = t.shipping*conversion_rate;
          shipping = shipping.toFixed(2);

          var discount = t.per*conversion_rate
          discount = discount.toFixed(2);

          var gtotal = t.gtotal*conversion_rate;

          gtotal = gtotal.toFixed(2);

          $('#shipping').text(shipping);

          $('#gtotal').text(gtotal);

          $('#discountedam').text(discount);

          $('#send').val(shipping);

          $('#subtotal').text(total);

          $('#sqty'+t.id).text(e);

     
    }).fail(function() {
      console.log("Error occur !"); 
      })
    }

    function addtowishlist(id){
      
      var wc = $('#wishcount').text();
      wc = Number(wc);
      if(wc == 0) {
        wc = 1;
      } else {
        wc = Number(wc) + 1;
      }

      var addtowishurl = '{{ url('/AddToWishList') }}/'+id;

      

  
       $.ajax({
          url: addtowishurl,
          type: 'GET',
          success: function(response) {
             
             $('#wishcount').text(wc);


              if(response == 'success') {
                swal({
                  title: "Added",
                  text: 'Added to your wishlist !',
                  icon: 'success'
                });

                $('#addtowish'+id).parent().html('<a id="removefromwish'+id+'" onclick="removefromwishlist('+id+')" class="cursor-pointer icon kal" title="{{ __('staticwords.RemoveFromWishlist') }}">{{ __('staticwords.RemoveFromWishlist') }} <i class="fa fa-heart-o"></i></a>');
              
              } else {
                swal({
                  title: "Oops !",
                  text: 'Product is already in your wishlist !',
                  icon: 'warning'
                });
              }

          }
        });
    }

   function removefromwishlist(id){
      
      
      var removefromwishurl = '{{ url('removeWishList') }}/'+id;

      var wc = $('#wishcount').text();
      wc = Number(wc);
      if(wc == 1) {
        wc = 0;
      } else {
        wc = Number(wc) - 1;
      }

      

       $.ajax({
          url: removefromwishurl,
          type: 'GET',
          success: function(response) {
             
             $('#wishcount').text(wc);

             if(response == 'deleted') {
                swal({
                  title: "Removed",
                  text: 'Removed from your wishlist !',
                  icon: 'success'
                });

              
                $('#removefromwish'+id).parent().html('<a id="addtowish'+id+'" onclick="addtowishlist('+id+')" class="cursor-pointer icon addtowish" title="{{ __('staticwords.AddToWishList') }}">{{ __('staticwords.AddToWishList') }} <i class="fa fa-heart"></i></a>');

              } else {
                swal({
                  title: "Oops !",
                  text: 'Product is already  removed from your wishlist !',
                  icon: 'warning'
                });
              }
          }
        });
   }


  </script>


@endsection