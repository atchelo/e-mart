@extends("front.layout.master")
@section('title',__('staticwords.YourWishlist').' ('.$wishcount.') |')
@section("body")
<div class="breadcrumb">
  <div class="container-fluid">
    <div class="breadcrumb-inner">
      <ul class="list-inline list-unstyled">
        <li><a href="{{ url('/') }}">{{ __('staticwords.Home') }}</a></li>
        <li class='active'>{{ __('staticwords.Wishlist') }}</li>
      </ul>
    </div><!-- /.breadcrumb-inner -->
  </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
  <div class="container-fluid">
    <div class="my-wishlist-page">
      <div class="row">
        <div class="col-md-12 my-wishlist">
          <h5>{{ __('staticwords.Wishlist') }} (<span class="wishtitle ">{{$wishcount}}</span>)</h5>
          <hr>
        
          @if(count($data) > 0)
         
          @foreach($data as $p)

          @php
            $orivar = $p->variant;
            $varcount = count($orivar->main_attr_value);
            $var_name_count = count($orivar['main_attr_id']);

            $name;
            $var_name;
            $newarr = array();
            for($i = 0; $i<$var_name_count; $i++){ $var_id=$orivar['main_attr_id'][$i];
              $var_name[$i]=$orivar['main_attr_value'][$var_id]; $name[$i]=App\ProductAttributes::where('id',$var_id)->
              first();

              }


              try{
              $url =
                url('details').'/'.$orivar->products->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
              }catch(Exception $e)
              {
                $url = url('details').'/'.$orivar->products->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
              }

            @endphp


            @if(isset($orivar) && $orivar->products->status == 1)
              <div id="orivar{{ $orivar->id }}" class="row">
                <div class="col-md-2 col-4">
                  <a href="{{ $url }}">
                    @if(isset($orivar->variantimages) && file_exists(public_path().'/variantimages/thumbnails/'.$orivar->variantimages->main_image))
                    <img class="wish-img" title="{{ $orivar->products->name }}"
                      src="{{ url('variantimages/thumbnails/'.$orivar->variantimages['main_image']) }}"
                      alt="{{ $orivar->variantimages['main_image'] }}">
                    @else 
                      <img class="pro-img2" src="{{ Avatar::create($orivar->products->name)->toBase64() }}"
                        alt="product name" />
                    @endif
                  </a>
                </div>

                <div class="col-md-6 col-8 btm-10">
                  <h5 class="product-name"><a title="View product" href="{{url($url)}}">{{$orivar->products->name}}
                      <small>
                        (@foreach($orivar->main_attr_value as $key=> $orivars)


                        @php
                        $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
                        $getvarvalue = App\ProductValues::where('id',$orivars)->first();
                        @endphp

                        @if($key < $varcount) @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
                          $getvarvalue->unit_value != null)
                          @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour"
                          || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                          {{ $getvarvalue->values }},
                          @else
                          {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }},
                          @endif
                          @else
                          {{ $getvarvalue->values }},
                          @endif
                          @else
                          @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value
                          != null)

                          @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour"
                          || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                          {{ $getvarvalue->values }}
                          @else
                          {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }}
                          @endif
                          @else
                          {{ $getvarvalue->values }}
                          @endif
                          @endif
                          @endforeach
                          )

                      </small></a>
                  </h5>
                  <div class="rating">
                    <?php 
                        $reviews = App\UserReview::where('pro_id',$orivar->products->id)->where('status','1')->get();
                     ?>
                    @if(!empty($reviews[0]))
                    <?php
                                  $review_t = 0;
                                  $price_t = 0;
                                  $value_t = 0;
                                  $sub_total = 0;
                                  $count =  App\UserReview::where('pro_id',$orivar->products->id)->count();
                                    foreach($reviews as $review){
                                    $review_t = $review->price*5;
                                    $price_t = $review->price*5;
                                    $value_t = $review->value*5;
                                    $sub_total = $sub_total + $review_t + $price_t + $value_t;
                                    }
                                    $count = ($count*3) * 5;
                                    $rat = $sub_total/$count;
                                    $ratings_var = ($rat*100)/5;
                                    ?>

                    <div class="pull-left">
                      <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                          class="star-ratings-sprite-rating"></span></div>
                    </div>


                    @else
                    <div class="no-rating">{{'No Rating'}}</div>
                    @endif
                  </div>
                  <div class="product-price">

                    @if($price_login == 0 || Auth::check())
                    @php
                    $convert_price = 0;
                    $show_price = 0;

                    $commision_setting = App\CommissionSetting::first();

                    if($commision_setting->type == "flat"){

                    $commission_amount = $commision_setting->rate;
                    if($commision_setting->p_type == 'f'){

                    $totalprice = $orivar->products->vender_price+$orivar->price+$commission_amount;
                    $totalsaleprice = $orivar->products->vender_offer_price + $orivar->price + $commission_amount;

                    if($orivar->products->vender_offer_price == 0){
                    $show_price = $totalprice;
                    }else{
                    $totalsaleprice;
                    $convert_price = $totalsaleprice =='' ? $totalprice:$totalsaleprice;
                    $show_price = $totalprice;
                    }


                    }else{

                    $totalprice = ($orivar->products->vender_price+$orivar->price)*$commission_amount;

                    $totalsaleprice = ($orivar->products->vender_offer_price+$orivar->price)*$commission_amount;

                    $buyerprice = ($orivar->products->vender_price+$orivar->price)+($totalprice/100);

                    $buyersaleprice = ($orivar->products->vender_offer_price+$orivar->price)+($totalsaleprice/100);


                    if($orivar->products->vender_offer_price ==0){
                    $show_price = round($buyerprice,2);
                    }else{
                    round($buyersaleprice,2);

                    $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                    $show_price = $buyerprice;
                    }


                    }
                    }else{

                    $comm = App\Commission::where('category_id',$orivar->products->category_id)->first();
                    if(isset($comm)){
                    if($comm->type=='f'){

                    $price = $orivar->products->vender_price + $comm->rate + $orivar->price;

                    if($orivar->products->vender_offer_price != null){
                    $offer = $orivar->products->vender_offer_price + $comm->rate + $orivar->price;
                    }else{
                    $offer = $orivar->products->vender_offer_price;
                    }

                    if($orivar->products->vender_offer_price == 0 || $orivar->products->vender_offer_price == null){
                    $show_price = $price;
                    }else{

                    $convert_price = $offer;
                    $show_price = $price;
                    }


                    }
                    else{

                    $commission_amount = $comm->rate;

                    $totalprice = ($orivar->products->vender_price+$orivar->price)*$commission_amount;

                    $totalsaleprice = ($orivar->products->vender_offer_price+$orivar->price)*$commission_amount;

                    $buyerprice = ($orivar->products->vender_price+$orivar->price)+($totalprice/100);

                    $buyersaleprice = ($orivar->products->vender_offer_price+$orivar->price)+($totalsaleprice/100);


                    if($orivar->products->vender_offer_price == 0){
                    $show_price = round($buyerprice,2);
                    }else{
                    $convert_price = round($buyersaleprice,2);

                    $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                    $show_price = round($buyerprice,2);
                    }



                    }
                    }else{
                    $commission_amount = 0;

                    $totalprice = ($orivar->products->vender_price+$orivar->price)*$commission_amount;

                    $totalsaleprice = ($orivar->products->vender_offer_price+$orivar->price)*$commission_amount;

                    $buyerprice = ($orivar->products->vender_price+$orivar->price)+($totalprice/100);

                    $buyersaleprice = ($orivar->products->vender_offer_price+$orivar->price)+($totalsaleprice/100);


                    if($orivar->products->vender_offer_price == 0){
                    $show_price = round($buyerprice,2);
                    }else{
                    $convert_price = round($buyersaleprice,2);

                    $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                    $show_price = round($buyerprice,2);
                    }
                    }
                    }
                    $convert_price_form = $convert_price;
                    $show_price_form = $show_price;
                    $convert_price = $convert_price*$conversion_rate;
                    $show_price = $show_price*$conversion_rate;

                    @endphp

                    @if(Session::has('currency'))
                    @if($convert_price == 0 || $convert_price == 'null')
                    <span class="color000"><i
                        class="{{session()->get('currency')['value']}}"></i>{{round($show_price,2)}}</span>
                    @else

                    <span class="price2"><i
                        class="{{session()->get('currency')['value']}}"></i>{{round($convert_price,2)}}
                    </span>

                    <span class="price-before-discount"><i
                        class="{{session()->get('currency')['value']}}"></i>{{round($show_price,2)}}
                    </span>


                    @endif
                    @endif

                    @endif
                  </div>
                  <div class="stock">
                    @if($orivar->stock == 0)
                    <span class="required">{{ __('staticwords.Outofstock') }}</span>
                    @else
                    <span class="text-green"><b>{{ __('staticwords.InStock') }}</b></span>
                    @endif
                  </div>
                </div>

                <div class="col-md-3 col-9 ">
                  @if($orivar->stock>0)
                  @php
                  $incartcheck = App\Cart::where('user_id',Auth::user()->id)->where('variant_id',$orivar->id)->first();
                  @endphp
                  @if(!empty($incartcheck))
                  <a title="Remove this variant from cart" href="{{route('rm.cart',$orivar->id)}}"
                    class="btn-upper btn btn-primary">
                    {{ __('staticwords.Removefromcart') }}
                  </a>
                  @else
                  <form method="POST"
                    action="{{route('add.cart',['id' => $orivar->products->id ,'variantid' =>$orivar->id, 'varprice' => $show_price_form, 'varofferprice' => $convert_price_form ,'qty' =>$orivar->min_order_qty])}}">
                    @csrf
                    <button title="Add this variant in cart" type="submit"
                      class="btn btn-primary">{{ __('staticwords.AddtoCart') }}</button>
                  </form>
                  @endif
                  @else
                  @php
                  $incartcheck = App\Cart::where('user_id',Auth::user()->id)->where('variant_id',$orivar->id)->first();
                  @endphp
                  @if(!empty($incartcheck))
                  <a disabled title="Remove this variant from cart" class="btn-upper btn btn-primary">
                    {{ __('staticwords.Removefromcart') }}
                  </a>
                  @else

                  <button disabled="disabled" title="Add this variant in cart"
                    class="btn btn-primary">{{ __('staticwords.AddtoCart') }}</button>

                  @endif
                  @endif
                </div>

                <div class="col-md-1 col-3">
                  @if(Auth::user()->wishlist->count()<1) <a class="font-size25" mainid="{{ $orivar->id }}"
                    data-add="{{url('AddToWishList/'.$orivar->id)}}" title="Add it to your Wishlist" href="">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                    @else
                    @php
                    $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$orivar->id)->first();
                    @endphp

                    @if(!empty($ifinwishlist))
                    <a mainid="{{ $orivar->id }}" data-remove="{{url('removeWishList/'.$orivar->id)}}"
                      title="Remove it from your Wishlist" class="removeFrmWish cursor-pointer font-size-25">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    @endif
                    @endif
                </div>
              </div>
              <hr>
            @endif


            @endforeach

            @else 

              <h3>
                <i class="fa fa-heart-o"></i> {{ __("staticwords.wishlistempty") }}
              </h3>

            @endif

        </div>
      </div><!-- /.row -->
    </div><!-- /.sigin-in-->
  </div><!-- /.container -->
</div><!-- /.body-content -->
<br>
@endsection
@section('script')
<script src="{{ url('js/wish2.js') }}"></script>
@endsection