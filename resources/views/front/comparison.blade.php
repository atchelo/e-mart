@extends("front/layout.master")
@section('title',__('staticwords.YourCompareList').' - ')
@section("body")
  
@php

   
	if(Session::has('comparison')){
		$clist = Session::get('comparison');
	foreach ($clist as $k => $row) {

		$findpro = App\Product::find($row);

		if(!isset($findpro)){

			unset($clist[$k]);

		}
	}

	Session::put('comparison',$clist);
	}
@endphp


<div class="breadcrumb">
	<div class="container-fluid">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="{{ url('/') }}">{{ __('staticwords.Home') }}</a></li>
				<li class='active'>{{ __('staticwords.YourCompareList') }}</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-xs">
	
	<div class="container-fluid">
    <div class="product-comparison">
		<div>
			<h1 class="page-title text-center heading-title">{{ __('staticwords.ProductComparison') }}</h1>
			<div class="table-responsive">
				@if(!empty(Session::get('comparison')))
				<table class="table compare-table inner-top-vs">
					<tr>
						<th>{{ __('staticwords.Products') }}</th>
						@foreach(Session::get('comparison') as $pro)
							@php
								$product = App\Product::find($pro['proid']);
							@endphp
						@if(isset($product) && $product->status == 1)
							<td>
							
							@foreach($product->subvariants as $orivar)
								@if($orivar->def == 1)

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
                                      $show_price =  round($buyerprice,2);
                                    }else{
                                       round($buyersaleprice,2);
                                     
                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                      $show_price = $buyerprice;
                                    }
                                 

                                }
                              }else{
                                
                              $comm = App\Commission::where('category_id',$product->category_id)->first();
	                           if(isset($comm)){
	                             if($comm->type=='f'){
	                               
	                               $price = $orivar->products->vender_price + $comm->rate + $orivar->price;

	                                if($orivar->products->vender_offer_price != null){
	                                  $offer =  $orivar->products->vender_offer_price + $comm->rate + $orivar->price;
	                                }else{
	                                  $offer =  $orivar->products->vender_offer_price;
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
	                                      $convert_price =  round($buyersaleprice,2);
	                                      
	                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
	                                      $show_price = round($buyerprice,2);
	                                    }
	                                 
	                                 
	                                  
	                            }
	                         }
	                            }
                          		$convert_price_form = $convert_price;
	                         	$show_price_form = $show_price;
	                         	$convert_price = $convert_price*$conversion_rate;
	                         	$show_price = $show_price*$conversion_rate;
	                          
	                            @endphp
                            
	                           

                              @endif

									@php 
		                                $var_name_count = count($orivar['main_attr_id']);
		                               
		                                $name = array();
		                                $var_name;
		                                   $newarr = array();
		                                  for($i = 0; $i<$var_name_count; $i++){
		                                    $var_id =$orivar['main_attr_id'][$i];
		                                    $var_name[$i] = $orivar['main_attr_value'][$var_id];
		                                      
		                                      $name[$i] = App\ProductAttributes::where('id',$var_id)->first();
		                                      
		                                  }


		                                try{
		                                  $url = url('details').'/'.$product->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
		                                }catch(Exception $e)
		                                {
		                                  $url = url('details').'/'.$product->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
		                                }

                             		@endphp

									<div class="product">
										<div class="product-image">
											<div class="image {{ $orivar->stock == 0 ? "pro-img-box" : ""}}"> 
                              
		                                 		<a href="{{$url}}" title="{{$product->name}}">
			                                 
					                                  @if(count($product->subvariants)>0)

					                                  @if(isset($orivar->variantimages['image2']))
					                                   <img class="{{ $orivar->stock ==0 ? "filterdimage" : ""}}" src="{{url('variantimages/thumbnails/'.$orivar->variantimages['main_image'])}}" alt="{{$product->name}}">
					                                   
					                                  @endif

					                                  @else
					                                  <img class="{{ $orivar->stock ==0 ? "filterdimage" : ""}}" title="{{ $product->name }}" src="{{url('images/no-image.png')}}" alt="No Image"/>
					                                  
					                                  @endif

				                              	</a>
                          					</div>

											<div class="product-info text-left">
												
												<h3 class="name"><a href="{{ url($url) }}">{{ $product->name }}</a></h3>
												
											</div>
										</div>
									</div>
								@endif
							@endforeach
							
						</td>
						@endif
						@endforeach


					</tr>

					<tr>
						<th></th>
						@foreach(Session::get('comparison') as $pro)
						 @php
						 	$product = App\Product::find($pro['proid']);
						 @endphp
						@if(isset($product) && $product->status == 1)
						 @foreach($product->subvariants as $orivar)
						 	@if($orivar->def == 1)


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
	                                      $show_price =  round($buyerprice,2);
	                                    }else{
	                                       round($buyersaleprice,2);
	                                     
	                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
	                                      $show_price = $buyerprice;
	                                    }
	                                 

	                                }
	                              }else{
	                                
	                              $comm = App\Commission::where('category_id',$product->category_id)->first();
		                           if(isset($comm)){
		                             if($comm->type=='f'){
		                               
		                               $price = $orivar->products->vender_price + $comm->rate + $orivar->price;

		                                if($orivar->products->vender_offer_price != null){
		                                  $offer =  $orivar->products->vender_offer_price + $comm->rate + $orivar->price;
		                                }else{
		                                  $offer =  $orivar->products->vender_offer_price;
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
		                                      $convert_price =  round($buyersaleprice,2);
		                                      
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
		                                      $convert_price =  round($buyersaleprice,2);
		                                      
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
	                            
		                            @endif
								<td>
									 @php
									  $incartcheck = 0;

						              if(Auth::check()){
						              	$incart = App\Cart::where('user_id',Auth::user()->id)->where('variant_id',$orivar->id)->first();
						              	if (isset($incart)) {
						              		$incartcheck = 1;
						              	}else{
						              		$incartcheck = 0;
						              	}
						              }else{
						              	

						              	if(!empty(Session::has('cart'))){

			                                  foreach (Session::get('cart') as $comp) {
			                                   if($orivar->id == $comp['variantid']){
			                                      $incartcheck = 1;
			                                      break;
			                                   }
			                                 }
			                               }
						              }

						            
						              
						            @endphp
									 @if($incartcheck == 1)
									 @auth
									 	<a title="{{ __('staticwords.Removefromcart') }}" href="{{route('rm.cart',$orivar->id)}}" class="btn-upper btn btn-primary">{{ __('staticwords.Removefromcart') }}</a>
									 @else
									 	<a title="{{ __('staticwords.Removefromcart') }}" href="{{route('rm.session.cart',$orivar->id)}}" class="btn-upper btn btn-primary">{{ __('staticwords.Removefromcart') }}</a>
									 @endif
             							 
             					    @else
									@if($price_login != 1)
										<form method="POST" action="{{route('add.cart',['id' => $orivar->products->id ,'variantid' =>$orivar->id, 'varprice' => $show_price_form, 'varofferprice' => $convert_price_form ,'qty' =>$orivar->min_order_qty])}}">
						                @csrf
						              <button title="{{ __('Add this variant in cart') }}" type="submit" class="btn btn-primary">{{ __('staticwords.AddtoCart') }}</button>
						              </form>
									@endif
						             @endif
								</td>
							@endif
						@endforeach
						@endif
						@endforeach
					</tr>

					<tr>
						<th>{{ __('staticwords.Rating') }}</th>
						@foreach(Session::get('comparison') as $pro)
						 @php
						 	$product = App\Product::find($pro['proid']);
						 @endphp
						 @if(isset($product) && $product->status == 1)
						<td>
							<div class="rating">
								<?php 
	                            $reviews = App\UserReview::where('pro_id',$product->id)->where('status','1')->get();
	                            ?> @if(!empty($reviews[0]))<?php
	                            $review_t = 0;
	                            $price_t = 0;
	                            $value_t = 0;
	                            $sub_total = 0;
	                            $count =  App\UserReview::where('pro_id',$product->id)->count();
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
	                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span></div>
	                          </div>
	                 
	                          
	                           @else
	                            <div class="no-rating">{{'No Rating'}}</div>
	                            @endif 
							</div>
						</td>
						@endif
						@endforeach
					</tr>

					<tr>
						<th>{{ __('staticwords.Price') }}</th>
						@foreach(Session::get('comparison') as $pro)
							@php
								$product = App\Product::find($pro['proid']);
							@endphp
							 @if(isset($product) && $product->status == 1)
							 	@foreach($product->subvariants as $orivar)
									@if($orivar->def == 1)

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
	                                      $show_price =  round($buyerprice,2);
	                                    }else{
	                                       round($buyersaleprice,2);
	                                     
	                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
	                                      $show_price = $buyerprice;
	                                    }
	                                 

	                                }
	                              }else{
	                                
	                              $comm = App\Commission::where('category_id',$product->category_id)->first();
		                           if(isset($comm)){
		                             if($comm->type=='f'){
		                               
		                               $price = $orivar->products->vender_price + $comm->rate + $orivar->price;

		                                if($orivar->products->vender_offer_price != null){
		                                  $offer =  $orivar->products->vender_offer_price + $comm->rate + $orivar->price;
		                                }else{
		                                  $offer =  $orivar->products->vender_offer_price;
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
		                                      $convert_price =  round($buyersaleprice,2);
		                                      
		                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
		                                      $show_price = round($buyerprice,2);
		                                    }
		                                  
		                            }
		                         }
		                            }
	                          		$convert_price_form = $convert_price;
		                         	$show_price_form = $show_price;
		                         	$convert_price = $convert_price*$conversion_rate;
		                         	$show_price = $show_price*$conversion_rate;
		                          
		                            @endphp
	                            
		                            @endif

	                              @endif
                             @endforeach
							 @endif
							 @if(isset($product) && $product->status == 1)
						<td>
							<div class="product-price">
								
								
									@if($price_login != 1)
										@if($convert_price != 0)
											<span class="price"> <i class="{{session()->get('currency')['value']}}"></i> {{ $convert_price }} </span>
											<span class="price-before-discount"> <i class="{{session()->get('currency')['value']}}"></i> {{ $show_price }}</span>
										@else
											<span class="price"> <i class="{{session()->get('currency')['value']}}"></i> {{ $show_price }}</span>
										@endif
									@else
									  <span class="price"><a title="Login to view price" href="{{ route('login') }}">{{ __('Login to view price') }}</a></span>
									@endif
								
								
							</div>
						</td>
					@endif
						@endforeach

						
					</tr>

					<tr>
						<th>{{ __('staticwords.Description') }}</th>
						@foreach(Session::get('comparison') as $product)
						@php
							$pro = App\Product::find($product['proid']);
						@endphp
						@if(isset($pro) && $pro->status == 1)
							<td>{!! $pro->des !!}</td>
						@endif
						@endforeach
						
					</tr>

					<tr>
						 <th>{{ __('staticwords.Availability') }}</th>
							
						 @foreach(Session::get('comparison') as $pro)
						  	 @php
								$product = App\Product::find($pro['proid']);
							 @endphp
	                     	@if(isset($product) && $product->status == 1)
	                     		<td>
	                     		@foreach($product->subvariants as $orivar)
	                     		@if($orivar->def == 1)
	                     			<p class="in-stock">{{ $orivar->stock > 0 ? __('In Stock') : __('Out of Stock') }}</p>
	                     		@endif
	                     		@endforeach
	                     	</td>
	                     	@endif
	                     @endforeach
	                     
					</tr>

					<tr>
						 <th>{{ __('staticwords.Weight') }}</th>
							
						 @foreach(Session::get('comparison') as $product)
						  	 @php
								$product = App\Product::find($product['proid']);
							 @endphp
	                     	 @if(isset($product) && $product->status == 1)
	                     	 	<td>
	                     		@foreach($product->subvariants as $orivar)
	                     		@if($orivar->def == 1)
	                     			@if(isset($orivar->unitname['short_code']))
	                     				<p class="in-stock">{{ $orivar->weight.$orivar->unitname['short_code'] }}</p>
	                     			@endif
	                     		@endif
	                     		@endforeach
	                     	</td>
	                     	 @endif
	                     @endforeach
	                     
					</tr>

					<tr>
						<th>{{ __('Specifications') }}</th>
						@foreach(Session::get('comparison') as $pro)
						@php
							$product = App\Product::find($pro['proid']);
						@endphp
							@if(isset($product) && $product->status == 1)
								<td>
								@if(count($product->specs)>0)
									<table class="width100" border="1">
										@foreach($product->specs as $spec)
										  <tr>
											<td><b>{{ $spec->prokeys }}</b></td>
											<td>{{ $spec->provalues }}</td>
										  </tr>
										@endforeach
									</table>
							    @else
							     -
								@endif
							</td>
						  @endif
						@endforeach
					</tr>

					<tr >
						<th>{{ __('Remove') }}</th>
						@foreach(Session::get('comparison') as $product)
						@php
							$pro = App\Product::find($product['proid']);
						@endphp
							@if(isset($pro) && $pro->status == 1)
								<td class='text-center'><a href="{{ route('remove.compare.product',$pro->id) }}" class="remove-icon"><i class="fa fa-times"></i></a></td>
							@endif
						@endforeach
					</tr>
				</table>
				@else
					<h2>{{ __('staticwords.YourComparisonListisempty') }}</h2>
				@endif
			</div>
            </div>
		</div>
	</div>
</div>


@endsection
@section('script')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/wishlist.js') }}"></script>
@endsection