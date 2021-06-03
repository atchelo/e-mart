<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>{{ __('Print Invoice:') }} {{ $inv_cus->prefix.$getInvoice->inv_no.$inv_cus->postfix }}</title>
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{ url('admindesk/css/style.css') }}">
	<style>
		 
	        .padding-15{
	        	padding : 15px;
	        }
	      
	</style>
</head>

	@php
									
		$orivar = App\AddSubVariant::withTrashed()->findorfail($getInvoice->variant_id);
		$i=0;
		$varcount = count($orivar->main_attr_value);
		$store = App\Store::where('id',$orivar->products->store_id)->first();

    @endphp

<body>
	<div class="container-fluid">
		<h3 class="text-center">{{ __('Invoice:') }} {{ $inv_cus->prefix.$getInvoice->inv_no.$inv_cus->postfix }}</h3>
		<div class="row justify-content-md-center">
			<div class="printheader padding-15">
				<br>
				<a href="{{ url()->previous() }}" title="Go back" class="p_btn2 pull-left btn btn-md btn-default"><i class="fa fa-reply" aria-hidden="true"></i></a>
				

		  		
		  	 <button title="Print Order" onclick="printIT()" class="p_btn pull-right btn btn-md btn-default"><i class="fa fa-print"></i></button>
				<table class="table table-striped">
				<thead>

					<th>
						{{ $inv_cus->prefix.$getInvoice->inv_no.$inv_cus->postfix }}
						<br>
						{{ __('TXN ID:') }}{{ $getInvoice->order->transaction_id }}
						@if($store->vat_no != '')
							<br>
							{{ 'VAT/GSTIN No:' }}
							{{ $store->vat_no }}
						@endif
					</th>

					<th>
						
					</th>

					<th>
						{{ __('Ordered From') }} {{ $title }}
						<br>
						<b>{{ __('Payment Method:') }} {{ $getInvoice->order->payment_method }}</b>
					</th>

					
				</tr>
				</thead>
				
					<tbody>
						
						<tr>
							<td colspan="2">
								<b>{{ $store->name }},</b>
								<br>
								{{ $store->address }},
								<br>
									@php
										
										$c = App\Allcountry::where('id',$store->country_id)->first()->nicename;
					                    $s = App\Allstate::where('id',$store->state_id)->first()->name;
					                    $ci = App\Allcity::where('id',$store->city_id)->first() ? App\Allcity::where('id',$store->city_id)->first()->name : '';
		                 
									@endphp
								
								{{$ci}},{{$s}},{{$c}}
								<br>
								{{$store->pin_code}}

							</td>

							<td>
								<b>{{ __('Order ID:') }}</b> {{  $inv_cus->order_prefix.$getInvoice->order->order_id }}
								<br>
								<b>{{ __('Invoice No:') }}</b> {{ $inv_cus->prefix.$getInvoice->inv_no.$inv_cus->postfix }}
								<br>
								<b>{{ __('Date:') }}</b> {{ date('d-m-Y',strtotime($getInvoice->created_at)) }}
							</td>
						</tr>
						@php
							$city = App\Allcountry::where('id',$address->country_id)->first()->nicename;
		                    $state = App\Allstate::where('id',$address->state_id)->first()->name;
		                    $country = App\Allcity::where('id',$address->city_id)->first() ? App\Allcity::where('id',$address->city_id)->first()->name : '';
						@endphp
						<tr>
							<th>
								<b>
									{{ __('Shipping Address') }}
								</b>
							</th>

							<th></th>

							<th>
								<b>
									{{ __('Billing Address') }}
								</b>
							</th>
						</tr>

						<tr>
							<td colspan="2">
								<p><b>{{ $address->name }}, {{ $address->phone }}</b></p>
								<p class="font-weight">{{ strip_tags($address->address) }}</p>
								<p class="font-weight">{{ $city }}, {{ $state }}, {{ $country }}</p>
									<p class="font-weight">{{ $address->pin_code }}</p>
							</td>
							<td>
									<p><b>{{ $getInvoice->order->billing_address['firstname'] }}, {{ $getInvoice->order->billing_address['mobile'] }}</b></p>
									<p class="font-weight">{{ strip_tags($getInvoice->order->billing_address['address']) }},</p>
									@php
										

					                    $bcountry = App\Allcountry::where('id',$getInvoice->order->billing_address['country_id'])->first()->nicename;
					                    $bstate = App\Allstate::where('id',$getInvoice->order->billing_address['state'])->first() ? App\Allstate::where('id',$getInvoice->order->billing_address['state'])->first()->name : '';
					                    $bcity = App\Allcity::where('id',$getInvoice->order->billing_address['city'])->first() ? App\Allcity::where('id',$getInvoice->order->billing_address['city'])->first()->name : '';
		                 
									@endphp
									<p class="font-weight">{{ $bcity }}, {{ $bstate }}, {{ $bcountry }}</p>
									<p class="font-weight">{{ $getInvoice->order->billing_address['pincode'] ?? '' }}</p>
							</td>
						</tr>

					</tbody>

				</table>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th>{{ __('Item') }}</th>
							<th>{{ __('Qty') }}</th>
							<th>{{ __('Pricing & Shipping') }}</th>
							<th>{{ __('TAX') }}</th>
							<th>{{ __('Total') }}</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td><b>{{$orivar->products->name}} <small>
										(@foreach($orivar->main_attr_value as $key=> $orivars)
					                    <?php $i++; ?>

					                        @php
					                          $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
					                          $getvarvalue = App\ProductValues::where('id',$orivars)->first();
					                        @endphp

					                        @if($i < $varcount)
					                          @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
					                            @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
					                            {{ $getvarvalue->values }},
					                            @else
					                            {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }},
					                            @endif
					                          @else
					                            {{ $getvarvalue->values }},
					                          @endif
					                        @else
					                          @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
					                            @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
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

					                    </small>
										</a>
											<br>
										<small><b>{{ __('Sold By:') }}</b> {{$orivar->products->store->name}}</small>
											<br>
										<small class="tax"><b>{{ __('Price:') }}</b> <i class="{{ $getInvoice->order->paid_in }}"></i>
											
											{{ number_format((float)$getInvoice->price , 2, '.', '')}}

										
										</small>
										<br>
										<small class="tax"><b>{{ __('Tax:') }}</b> <i class="{{ $getInvoice->order->paid_in }}"></i>
										{{ number_format((float)$getInvoice->tax_amount/$getInvoice->qty , 2, '.', '')}}
										</small>
										</td>
							<td valign="middle">
								{{ $getInvoice->qty }}
							</td>
							<td>
									<p><b>{{ __('Price:') }}</b> <i class="{{ $getInvoice->order->paid_in }}"></i>
										
											{{ round($getInvoice->qty*$getInvoice->price,2) }}</p>
										
										<p class="ship"><b>{{ __('Shipping:') }}</b> <i class="{{ $getInvoice->order->paid_in }}"></i>{{ round( $getInvoice->shipping,2) }}</p></b>
										<small class="help-block">({{ __('Price Multiplied with Qty.') }})</small>
							</td>
							<td>
								
								@if($getInvoice->igst != NULL)
		                          <p><i class="{{ $getInvoice->order->paid_in }}"></i> {{ sprintf("%.2f",$getInvoice->igst) }}</p>
		                        @endif
								@if($getInvoice->sgst != NULL)
									<p><i class="{{ $getInvoice->order->paid_in }}"></i> {{ sprintf("%.2f",$getInvoice->sgst) }} (SGST)</p>
								@endif
								@if($getInvoice->cgst != NULL)
									<p><i class="{{ $getInvoice->order->paid_in }}"></i> {{ sprintf("%.2f",$getInvoice->cgst) }} (CGST)</p>
								@endif
								<p><b>Total:</b> <i class="{{ $getInvoice->order->paid_in }}"></i>{{ round($getInvoice->tax_amount,2) }}</p>
								@if($orivar->products->tax_r !='' && $getInvoice->igst != NULL && $getInvoice->cgst != NULL && $getInvoice->sgst != NULL)
								
									<p>({{ $orivar->products->tax_name }})</p>
								
								@endif
								
								<small class="help-block">(Tax Multiplied with Qty.)</small>
							</td>
							<td>
								<i class="{{ $getInvoice->order->paid_in }}"></i>
								
									{{ round($getInvoice->qty*$getInvoice->price+$getInvoice->tax_amount+$getInvoice->shipping,2) }}
								<br>
								<small class="help-block">({{ __('Incl. of Tax & Shipping') }})</small>
							</td>
						</tr>
						@if( $getInvoice->order->discount !=0)	
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>
									<b>{{ __('Coupon Discount:') }}</b>
								</td>
								<td>

									@if($getInvoice->order->discount !=0)
										
										- <i class="{{ $getInvoice->order->paid_in }}"></i> {{ round($getInvoice->discount,2) }}

									@endif
									
								</td>
						</tr>
						@endif
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<b>
									{{ __('Gift Pkg Charges:') }}
								</b>
							</td>
							<td>
								+ <i class="{{ $getInvoice->order->paid_in }}"></i> {{ $getInvoice->gift_charge }}
							</td>
						</tr>
						<tr>
								<td></td>
								<td></td>
								<td></td>
								<td>
									<b>
										{{ __('Handling Charges:') }}
									</b>
								</td>
								<td>
									+ <i class="{{ $getInvoice->order->paid_in }}"></i> {{ $getInvoice->handlingcharge }}
								</td>
							</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<b>
									{{ __('Grand Total:') }}
								</b>
							</td>
							<td>
								@if( $getInvoice->order->discount == 0)	
									<i class="{{ $getInvoice->order->paid_in }}"></i> {{ round( $getInvoice->qty*$getInvoice->price+$getInvoice->tax_amount+$getInvoice->handlingcharge+$getInvoice->shipping+$getInvoice->gift_charge,2) }}
								@else
									<i class="{{ $getInvoice->order->paid_in }}"></i> {{ round( $getInvoice->qty*$getInvoice->price+$getInvoice->tax_amount-$getInvoice->discount+$getInvoice->handlingcharge+$getInvoice->shipping+$getInvoice->gift_charge,2) }}
								@endif
							</td>
						</tr>
					</tbody>
				</table>
				<p class="margin-top-minus-15"><b>{{ __('Terms:') }} </b>{{ $inv_cus->terms }}</p>
				<table class="table">
					<tr>
						@if(!empty($invSetting->seal))
							<td>
								{{ __('Seal:') }}
								<br>
								<img width="50px" src="{{ url('images/seal/'.$invSetting->seal) }}" alt="">
							</td>
						@endif
						@if(!empty($invSetting->sign))
							<td>
								{{ __('Sign:') }} <br>
							   <img width="50px" src="{{ url('images/sign/'.$invSetting->sign) }}" alt="">
							</td>
						@endif
					</tr>
				</table>

			</div>
		<div>
	
	<p></p>
	</div>
	
	

</body>
<script src="{{ url('js/script.js') }}"></script>
</html>