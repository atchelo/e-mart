@extends('front.layout.master')
@section('title',"Return Product |")
@section('body')
	<div class="container-fluid">
		<div class="bg-white">
			 <div class="user_header"><h6 class="user_m">
			 	{{ __('staticwords.ReturnProduct') }} {{ $productname }} (

			@php

			 $varcount = count($findvar->main_attr_value);
    		 $var_main;
    		 $i=0;
    		//var code
	          foreach ($findvar->main_attr_value as $key => $orivars) {

	              $i++;

	              $getattrname = App\ProductAttributes::where('id', $key)->first()->attr_name;
	              $getvarvalue = App\ProductValues::where('id', $orivars)->first();

	              if ($i < $varcount) {
	                if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {
	                  if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

	                    echo $getvarvalue->values.',';

	                  } else {
	                    echo $getvarvalue->values . $getvarvalue->unit_value.',';
	                  }
	                } else {
	                  echo $getvarvalue->values;
	                }

	              } else {

	                if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {

	                  if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

	                    echo $getvarvalue->values;
	                  } else {
	                     echo $getvarvalue->values.$getvarvalue->unit_value;
	                  }

	                } else {
	                  echo $getvarvalue->values;
	                }

	              }
	            } 
            @endphp)
        	</h6>
        	</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<h5 class="margin-15">{{ __('Order') }} #{{ $inv_cus->order_prefix.$order->order->order_id }}
					</h5>
				</div>
				<div class="col-md-4">
					<h5 class="margin-15">{{ __('TXN ID:') }} {{ $order->order->transaction_id }}
					</h5>
				</div>
				<div class="col-md-4"></div>
			</div>
        	
        	
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<th>
						{{ __('staticwords.Item') }}
					</th>

					<th>
						{{ __('staticwords.qty') }}
					</th>

					<th>
						{{ __('staticwords.Price') }}
					</th>

					<th>{{ __('staticwords.TotalGiftCharge') }}</th>

					<th>{{ __('staticwords.HandlingCharge') }}</th>

					<th>
						{{ __('staticwords.Total') }}
					</th>

					<th>
						{{ __('staticwords.Deliveredat') }}
					</th>
				</thead>

				<tbody>
					<tr>
						<td>
							<div class="row">
							<div class="col-2">
								<img class="img-fluid" height="50px" src="{{url('variantimages/thumbnails/'.$findvar->variantimages['main_image'])}}" alt=""/>
							</div>
							<div class="col-10">
								<a title="{{ __('Click to view') }}" ><b>{{$findvar->products->name}}</b>

			                <small>
			                (@foreach($findvar->main_attr_value as $key=> $orivars)
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
			                 <small><b>{{ __('staticwords.SoldBy') }}:</b> {{$findvar->products->store->name}}</small>
			                <br>
			               
							</div>
						 </div>
						</td>
						<td>
							{{$order->qty}}
						</td>

						<td><b><i class="{{ $order->order->paid_in }}"></i>
							
								
						 		@if($order->order->discount !=0)
									
									{{ round($order->qty*$order->price+$order->tax_amount+$order->shipping-$order->discount,2) }}
								
                                @else
                                    {{ round($order->qty*$order->price+$order->tax_amount+$order->shipping,2) }}
                                @endif 
						</b><br>
                          <small>({{ __('Incl. of Tax & Shipping') }})</small>
                        </td>
						<td>
							<b><i class="{{ $order->order->paid_in }}"></i> {{ $order->gift_charge }}</b>
						</td>
						<td>
							<b><i class="{{ $order->order->paid_in }}"></i> {{ $order->handlingcharge }}</b>
						</td>
						<td>
							<b><i class="{{ $order->order->paid_in }}"></i> 

								@if($order->order->discount !=0)
									
									{{ round(($order->qty*$order->price)+$order->tax_amount+$order->handlingcharge+$order->shipping-$order->discount+$order->gift_charge,2) }}
								
                                @else
                                    {{ round(($order->qty*$order->price)+$order->tax_amount+$order->handlingcharge+$order->shipping+$order->gift_charge,2) }}
                                @endif 
                            </b>
						</td>
                        <td>
						@php
							$days = $findvar->products->returnPolicy->days;
                     		$endOn = date("d-M-Y", strtotime("$order->updated_at +$days days"));
						@endphp
                        	<span class="font-weight600">{{ date('d-M-Y @ h:i A',strtotime($order->updated_at)) }}</span>
							<br>
                        	<small class="font-weight600">({{ __('staticwords.ReturnPolicyEndsOn') }} {{ $endOn }})</small>
                        	
                        </td>



					</tr>
				</tbody>
			</table>
			</div>

			@php
				
				if($order->discount == 0){
					$amount = round(($order->qty*$order->price)+$order->tax_amount+$order->handlingcharge+$order->shipping+$order->gift_charge,2);
				}else{
					$amount = round((($order->qty*$order->price)+$order->tax_amount+$order->handlingcharge+$order->shipping)-$order->discount+$order->gift_charge,2);
				}
				
				$per = $amount*$findvar->products->returnPolicy->amount/100;

				$paidAmount = $amount-$per;

			@endphp
			
			<div class="margin-15">

				@php
					$orderId = Crypt::encrypt($order->id);
				@endphp
				<!--return form-->
				<form action="{{ route('return.process',$orderId) }}" method="POST">
					@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						

								<label class="font-weight-bold">{{ __('staticwords.ChooseReasonforReturningtheProduct') }}: <span class="required">*</span></label>
						
							
								<select required name="reason_return" id="" class="row col-12 form-control margin-left-0">
									<option value="">{{ __('staticwords.PleaseChooseReason') }}</option>

						              <option value="Order Placed Mistakely">
						              	{{ __('Order Placed Mistakely') }}
						              </option>
						              <option value="Shipping cost is too much">
						              	{{ __('Shipping cost is too much') }}
						              </option>
						              <option value="Wrong Product Ordered">
						              	{{ __('Wrong Product Ordered') }}
						              </option>
						              <option value="Product is not match to my expectations">
						              	{{ __('Product is not match to my expectations') }}
						              </option>
						              <option value="Other">
						              	{{ __('My Reason is not listed here') }}
						              </option>
								</select>
							
						
						</div>
						
						<div class="form-group">
							<label class="font-weight-bold">{{ __('staticwords.RefundedAmount') }}:</label>
							<input required type="text" class="form-control" readonly value="{{ $findvar->products->returnPolicy->amount != 0 ? round($paidAmount,2) : round($amount,2) }}">
							@php
								if($findvar->products->returnPolicy->amount != 0){
									$rfm = Crypt::encrypt(round($paidAmount,2));
								}else {
									$rfm = Crypt::encrypt(round($amount,2));
								}
							@endphp

							<input type="hidden" value="{{ $rfm }}" name="rf_am">
						</div>

					</div>
					<div class="col-md-6">
						<p></p>
						<br>
						@if($findvar->products->returnPolicy->amount != 0)
						<div class="alert alert-info">
							<h6><i class="fa fa-info-circle"></i> {{ __('staticwords.AdditionalNote') }}:</h6>
							<p>
								{{ __('staticwords.AsPerProductReturnPolicy') }} {{ $findvar->products->returnPolicy->amount }}% {{ __('staticwords.refundorderamount') }}. 

								{{ __('staticwords.RefundedAmountwillbe') }}: <b><i class="{{ $order->order->paid_in }}"></i> {{ round($paidAmount,2) }}</b>
							</p>
						</div>
						@endif
					</div>
				</div>
					
					<hr>

					<div class="row">
						<div class="col-md-6">
							<label class="h6 font-weight-bold">{{ __('staticwords.PickupLocation') }}:</label>

							@php
								 $address = App\Address::find($order->order->delivery_address);
								 $c = App\Allcountry::where('id',$address->country_id)->first()->nicename;
		                         $s = App\Allstate::where('id',$address->state_id)->first()->name;
		                         $ci = App\Allcity::where('id',$address->city_id)->first()->name;

		                         $addressA = array();

		                         $addressA = [

		                         	'name' => $address->name,
		                         	'address' => strip_tags($address->address),
		                         	'ci' 	=> $ci,
		                         	's' => $s,
		                         	'c' => $ci,
		                         	'pincode' => $address->pin_code

		                         ];

		                       


							@endphp

							<div class="form-group">

								<div class="card">
									<div class="card-body">
									
									<div class="custom-control custom-checkbox">
									  <input checked type="checkbox" name="pickupaddress[]" value="{{ json_encode($addressA,TRUE)}}" class="custom-control-input" id="customCheck1">
									  <label class="h6 custom-control-label" for="customCheck1">
									  	{{$address->name}}


									  	<p class="p-2 font-weight600">
										
										{{ strip_tags($address->address) }}<br>{{ $ci }},{{ $s }},{{ $c }} <br> {{ $address->pin_code }}
										</p>
									  </label>
									</div>
									
								</div>
								</div>
							</div>

						
					</div>

					<div class="col-md-6">
							<label class="h6 font-weight-bold">{{ __('staticwords.RefundMethod') }}:</label>
							@if($order->order->payment_method !='COD')
							<div class="form-group">
								

								<div class="custom-control custom-radio">
								  <input required="" type="radio" id="customRadio1" value="orignal" name="source" class="custom-control-input">
								  <label class="font-weight-bold custom-control-label" for="customRadio1">{{ __('staticwords.OrignalSource') }} ({{$order->order->payment_method}})</label>
								</div>
							</div>
							@endif
							<div class="form-group">
								

								<div class="custom-control custom-radio">
								  <input required name="source" value="bank" type="radio" id="customRadio2" name="customRadio" class="font-weight-bold custom-control-input">
								  <label class="custom-control-label font-weight-bold" for="customRadio2">{{ __('staticwords.Bank') }}</label>
								</div>
							</div>
							
							<div id="bank_box" class="form-group display-none">
								<label class="font-weight-bold">{{ __('staticwords.Chooseabank') }}: <span class="required">*</span></label>
								<select name="bank_id" id="bank_id" class="form-control">
									@foreach(Auth::user()->banks as $bank)
										<option value="{{ $bank->id }}">{{ $bank->bankname }} ( {{ $bank->acno }} )
										</option>
									@endforeach
								</select>
							</div>
					</div>


					</div>
					<hr>
					<button type="submit" class="btn btn-primary">{{ __('staticwords.Procced') }}...</button>
					<br><br>
				</form>
				
			<!--end-->
			</div>
			

		</div>
	</div>
@endsection
@section('script')
	<script src="{{ url('js/returnorder.js') }}"></script>
@endsection