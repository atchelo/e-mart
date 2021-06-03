@extends("admindesk/layouts.master")
@section('title',"View Order : $inv_cus->order_prefix$order->order_id | ")
@section("body")

@php
	$orderlog = App\FullOrderCancelLog::where('order_id',$order->id)->first();
	$i=0;
@endphp

@if($order->manual_payment == '1')
	<div class="callout callout-success">
		<i class="fa fa-info-circle"></i> This order is placed using {{ ucfirst($order->payment_method) }} method and purchase proof you can view <a href="{{ url('images/purchase_proof/'.$order->purchase_proof) }}" data-lightbox="image-1" data-title="Purchase proof for {{ $order->order_id }}">here</a> and after verify you can change the order status.
	</div>
@endif

<div class="box">

	<div class="box-header with-border">
		<div class="box-title">
			<a title="Go Back" href="{{ url('admindesk/order') }}" class="btn btn-md btn-default"><i class="fa fa-reply"
					aria-hidden="true"></i>
			</a>
			View Order #{{ $inv_cus->order_prefix.$order->order_id }}


		</div>

		<a title="Print Order" href="{{ route('order.print',$order->id) }}" class="btn btn-md btn-default pull-right"><i
				class="fa fa-print"></i></a>

		<a title="Edit Order" href="{{ route('admindesk.order.edit',$order->order_id) }}"
			class="margin-right-8 btn btn-md btn-success pull-right"><i class="fa fa-pencil"></i></a>
	</div>

	<div class="box-body">



		@if(isset($orderlog[0]))

		@if(count($orderlog[0]->inv_id) != count($order->invoices))

		<div class="callout callout-danger">

			<p class="font-familycalibri font-weight500">
				<i class="fa fa-info-circle"></i>
				<b>{{ date('d-m-Y | h:i A',strtotime($orderlog->updated_at)) }} • For Order
					#{{ $inv_cus->order_prefix.$order->order_id }} Few Items has been cancelled
					{{ $order->payment_method == 'COD' ? "." : ""  }}</b>

				@if($orderlog->method_choosen == 'orignal')

				<b> and Amount <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
					is refunded to its orignal source with TXN ID [{{ $orderlog->txn_id }}].</b>


				@elseif($orderlog->method_choosen == 'bank')
				@if($orderlog->is_refunded == 'completed')
				<b>and Amount <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
					is refunded to <b>{{ $orderlog->user->name }}'s</b> bank ac @if(isset($orderlog->bank->acno))
					XXXX{{ substr($orderlog->bank->acno, -4) }} @endif with TXN/REF No {{ $orderlog->txn_id }}
					@if($orderlog->txn_fee !='')<br>(TXN FEE APPLIED) <i class="{{ $order->paid_in }}"></i>
					{{ $orderlog->txn_fee }} @endif.</b>
				@else
				<b>Amount <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
					is pending to <b>{{ $orderlog->user->name }}'s</b> bank ac @if(isset($orderlog->bank->acno))
					XXXX{{ substr($orderlog->bank->acno, -4) }} @endif with TXN/REF. No: {{ $orderlog->txn_id }}.</b>
				@endif
				@endif
			</p>
		</div>

		@else

		<div class="callout callout-danger">

			<p class="font-familycalibri font-weight500">
				<i class="fa fa-info-circle"></i>
				<b>{{ date('d-m-Y | h:i A',strtotime($orderlog->updated_at)) }} • For Order
					#{{ $inv_cus->order_prefix.$order->order_id }} has been cancelled
					{{ $order->payment_method == 'COD' ? "." : ""  }}</b>

				@if($orderlog->method_choosen == 'orignal')

				<b> and Amount <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
					is refunded to its orignal source with TXN ID [{{ $orderlog->txn_id }}].</b>


				@elseif($orderlog->method_choosen == 'bank')
				@if($orderlog->is_refunded == 'completed')
				<b>and Amount <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
					is refunded to <b>{{ $orderlog->user->name }}'s</b> bank ac @if(isset($orderlog->bank->acno))
					XXXX{{ substr($orderlog->bank->acno, -4) }} @endif with TXN/REF No {{ $orderlog->txn_id }}
					@if($orderlog->txn_fee !='')<br>(TXN FEE APPLIED) <i class="{{ $order->paid_in }}"></i>
					{{ $orderlog->txn_fee }} @endif.</b>
				@else
				<b>Amount <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
					is pending to <b>{{ $orderlog->user->name }}'s</b> bank ac @if(isset($orderlog->bank->acno))
					XXXX{{ substr($orderlog->bank->acno, -4) }} @endif with TXN/REF. No: {{ $orderlog->txn_id }}.</b>
				@endif
				@endif
			</p>
		</div>

		@endif
		@endif

		@if($order->refundlogs->count()>0)

		@foreach($order->refundlogs->sortByDesc('id') as $rlogs)

		<div class="callout callout-danger">

			@php
				$orivar2 = App\AddSubVariant::withTrashed()->findorfail($rlogs->getorder->variant_id);
				$varcount = count($orivar2->main_attr_value);
			@endphp

			<p><i class="fa fa-info-circle"></i> {{ date('d-m-Y | h:i A',strtotime($rlogs->updated_at)) }} • Item
				<b>{{ $orivar2->products->name }}(@foreach($orivar2->main_attr_value as $key=> $orivars)
					<?php $i++;?>

					@php
						$getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
						$getvarvalue = App\ProductValues::where('id',$orivars)->first();
					@endphp

					@if($i < $varcount) @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
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
						)</b> has been @if($rlogs->getorder->status == 'return_request')
				requested for return
				@else
				@if($rlogs->getorder->status == 'ret_ref')
				Returned and refunded
				@else
				{{ ucfirst($rlogs->getorder->status) }}
				@endif
				@endif

				@if($rlogs->method_choosen == 'orignal')

				and Amount <i class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->amount }}
				is {{ $rlogs->status }} to its orignal source with TXN ID: <b>{{ $rlogs->txn_id }}</b>.


				@elseif($rlogs->method_choosen == 'bank')
				@if($rlogs->status == 'refunded')
				and Amount <i class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->amount }}
				is {{ $rlogs->status }} to <b>{{ $rlogs->user->name }}'s</b> bank ac @if(isset($rlogs->bank->acno))
				XXXX{{ substr($rlogs->bank->acno, -4) }} @endif with TXN ID: <b>{{ $rlogs->txn_id }} @if($rlogs->txn_fee
					!='') <br> (TXN FEE APPLIED) <b><i
							class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->txn_fee }}</b> @endif</b>.
				@else
				and Amount <i class="{{ $order->paid_in }}"></i>{{ $rlogs->amount }}
				is pending to <b>{{ $rlogs->user->name }}'s</b> bank ac @if(isset($rlogs->bank->acno))
				XXXX{{ substr($rlogs->bank->acno, -4) }} @endif with TXN ID/REF NO: <b>{{ $rlogs->txn_id }}</b>
				@if($rlogs->txn_fee !='') <br> (TXN FEE APPLIED) <b><i
						class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->txn_fee }}</b> @endif.
				@endif
				@endif</p>
		</div>

		@endforeach
		@endif


		@if($order->cancellog->count()>0)
		<div class="callout callout-danger">
			@foreach($order->cancellog->sortByDesc('id') as $cancellog)
				@php
					$orivar2 = App\AddSubVariant::withTrashed()->find($cancellog->singleOrder->variant_id);
					$varcount = count($orivar2->main_attr_value);
				@endphp
			@if(isset($orivar2))
			<p><i class="fa fa-info-circle"></i> {{ date('d-m-Y | h:i A',strtotime($cancellog->updated_at)) }} • Item
				<b>{{ $orivar2->products->name }}(@foreach($orivar2->main_attr_value as $key=> $orivars)
					<?php $i++; ?>

					@php
					$getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
					$getvarvalue = App\ProductValues::where('id',$orivars)->first();
					@endphp

					@if($i < $varcount) @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
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
						)</b> has been canceled

				@if($cancellog->method_choosen == 'orignal')

				and Amount <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
				is refunded to its orignal source with TXN ID: <b>{{ $cancellog->transaction_id }}</b>.


				@elseif($cancellog->method_choosen == 'bank')
				@if($cancellog->is_refunded == 'completed')
				and Amount <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
				is refunded to <b>{{ $cancellog->user->name }}'s</b> bank ac @if(isset($cancellog->bank->acno))
				XXXX{{ substr($cancellog->bank->acno, -4) }} @endif with TXN ID <b>{{ $cancellog->transaction_id }}
					@if($cancellog->txn_fee !='') <br> (TXN FEE APPLIED) <b><i
							class="{{ $order->paid_in }}"></i>{{ $cancellog->txn_fee }}</b> @endif</b>.
				@else
				and Amount <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
				is pending to <b>{{ $cancellog->user->name }}'s</b> bank ac XXXX{{ substr($cancellog->bank->acno, -4) }}
				with TXN ID/REF NO <b>{{ $cancellog->transaction_id }}</b> @if($cancellog->txn_fee !='') <br> (TXN FEE
				APPLIED) <b><i class="{{ $order->paid_in }}"></i>{{ $cancellog->txn_fee }}</b> @endif.
				@endif
				@endif
			</p>
			@endif
			@endforeach
		</div>
		@endif

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Customer Information</th>
					<th>Shipping Address</th>
					<th>Billing Address</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>
						@php
						$user = $order->user;

						$address = $order->shippingaddress;

						if($user->country_id !=''){
							$c = App\Allcountry::where('id',$user->country_id)->first()->nicename;
							$s = App\Allstate::where('id',$user->state_id)->first()->name;
							$ci = App\Allcity::where('id',$user->city_id)->first()->name;
						}


						@endphp

						<p><b>{{$user->name}}</b></p>
						<p><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $user->email }}</p>
						@if(isset($user->mobile))
						<p><i class="fa fa-phone"></i> {{$user->mobile}}</p>
						@endif
						@if(isset($c))
						<p><i class="fa fa-map-marker" aria-hidden="true"></i> {{$ci}}, {{ $s }}, {{ $c }}</p>
						@endif

					</td>
					<td>
						<p><b>{{ $address->name }}, {{ $address->phone }}</b></p>
						<p class="font-weight600">{{ strip_tags($address->address) }},</p>
						@php
							$user = $order->user;

							$c = App\Allcountry::where('id',$address->country_id)->first()->nicename;
							$s = App\Allstate::where('id',$address->state_id)->first()->name;
							$ci = App\Allcity::where('id',$address->city_id)->first() ? App\Allcity::where('id',$address->city_id)->first()->name : '';

						@endphp
						<p class="font-weight600">{{ $ci }}, {{ $s }}, {{ $ci }}</p>
						<p class="font-weight600">{{ $address->pin_code }}</p>
					</td>
					<td>
						<p><b>{{ $order->billing_address['firstname'] }}, {{ $order->billing_address['mobile'] }}</b>
						</p>
						<p class="font-weight600">{{ strip_tags($order->billing_address['address']) }},</p>
						@php


						$c = App\Allcountry::where('id',$order->billing_address['country_id'])->first()->nicename;
						$s = App\Allstate::where('id',$order->billing_address['state'])->first()->name;
						$ci = App\Allcity::where('id',$order->billing_address['city'])->first() ? App\Allcity::where('id',$order->billing_address['city'])->first()->name : '';

						@endphp
						<p class="font-weight600">{{ $ci }}, {{ $s }}, {{ $ci }}</p>
						<p class="font-weight600">
							@if(isset($order->billing_address['pincode']))
								{{ $order->billing_address['pincode'] }}
							@endif
						</p>
					</td>
				</tr>
			</tbody>
		</table>


		<table class="table table-striped">
			<thead>
				<th>
					Order Summary
				</th>
				<th></th>

				<th></th>
			</thead>

			<tbody>
				<tr>
					<td>
						<p><b>Total Qty:</b> {{ $order->qty_total }}</p>
						</p>
						<p><b>Order Total: <i class="{{ $order->paid_in }}"></i>{{ round($order->order_total,2) }}</b>
						</p>
						<p><b>Payment Recieved:</b> {{ ucfirst($order->payment_receive)  }}</p>
					</td>

					<td>
						<p><b>Payment Method: </b> {{ ucfirst($order->payment_method) }}
							<p><b>Transcation ID:</b> <b><i>{{ $order->transaction_id }}</i></b></p>


					</td>

					<td>
						<p><b>Order Date:</b> {{ date('d/m/Y @ h:i a', strtotime($order->created_at)) }}</p>
					</td>
				</tr>
			</tbody>
		</table>

		@foreach($order->invoices as $invoice)

		@php
		$varcount = count($invoice->variant->main_attr_value);
		@endphp

		@if($invoice->local_pick != '' && $invoice->status !='refunded')
		<div class="alert alert-success">
			<i class="fa fa-info-circle"></i> For Item <b>{{ $invoice->variant->products->name }} <small>
					(@foreach($invoice->variant->main_attr_value as $key=> $orivars)
					<?php $i++; ?>

					@php
					$getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
					$getvarvalue = App\ProductValues::where('id',$orivars)->first();
					@endphp

					@if($i < $varcount) @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
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

				</small></b> Customer has choosen Local Pickup. @if($invoice->status != 'delivered')
			Estd Delivery date: <span id="estddate{{ $invoice->id }}">
				{{ $invoice->loc_deliv_date == '' ? "Yet to update" : date('d-m-Y',strtotime($invoice->loc_deliv_date)) }}

				@else
				Item Delivered On: <span id="estddate{{ $invoice->id }}">
					{{ $invoice->loc_deliv_date == '' ? "Yet to update" : date('d-m-Y',strtotime($invoice->loc_deliv_date)) }}
					@endif
				</span>
		</div>
		@endif
		@endforeach

		<hr>
		<table class="table table-striped">
			<thead>
				<th>Order Details</th>
			</thead>
		</table>

		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Invoice No</th>
					<th>Item Name</th>
					<th>Qty</th>
					<th>Status</th>
					<th>Pricing & Tax</th>
					<th>Total</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				@foreach($order->invoices as $invoice)
				<tr>
					<td>
						<i>{{ $inv_cus->prefix }}{{ $invoice->inv_no }}{{ $inv_cus->postfix }}</i>
					</td>

					<td>
						@php
						$orivar = $invoice->variant;

						$varcount = count($orivar->main_attr_value);
						$i=0;
						$var_name_count = count($orivar['main_attr_id']);
						unset($name);
						$name = array();
						$var_name;

						$newarr = array();
						for($i = 0; $i<$var_name_count; $i++){ $var_id=$orivar['main_attr_id'][$i];
							$var_name[$i]=$orivar['main_attr_value'][$var_id];
							$name[$i]=App\ProductAttributes::where('id',$var_id)->first();

							}


							try{
							$url =
							url('details').'/'.$orivar->products->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
							}catch(Exception $e)
							{
							$url = url('details').'/'.$orivar->products->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
							}

							@endphp

							<div class="row">
								<div class="col-md-2">
									@if($orivar->variantimages)
									<img class="order-img"
										src="{{url('variantimages/'.$orivar->variantimages['main_image'])}}" alt="">
									@else
									<img class="order-img"
										src="{{ Avatar::create($orivar->products->name)->toBase64() }}" alt="">
									@endif
								</div>

								<div class="col-md-10">
									<a class="text-justify mleft22" target="_blank" title="Click to view"
										href="{{ url($url) }}"><b>{{substr($orivar->products->name, 0, 25)}}{{strlen($orivar->products->name)>25 ? '...' : ""}}</b>

										<small>
											(@foreach($orivar->main_attr_value as $key=> $orivars)
											<?php $i++; ?>

											@php
											$getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
											$getvarvalue = App\ProductValues::where('id',$orivars)->first();
											@endphp

											@if($i < $varcount) @if(strcasecmp($getvarvalue->unit_value,
												$getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
												@if($getvarvalue->proattr->attr_name == "Color" ||
												$getvarvalue->proattr->attr_name == "Colour" ||
												$getvarvalue->proattr->attr_name == "color" ||
												$getvarvalue->proattr->attr_name == "colour")
												{{ $getvarvalue->values }},
												@else
												{{ $getvarvalue->values }}{{ $getvarvalue->unit_value }},
												@endif
												@else
												{{ $getvarvalue->values }},
												@endif
												@else
												@if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
												$getvarvalue->unit_value != null)

												@if($getvarvalue->proattr->attr_name == "Color" ||
												$getvarvalue->proattr->attr_name == "Colour" ||
												$getvarvalue->proattr->attr_name == "color" ||
												$getvarvalue->proattr->attr_name == "colour")
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
									<small class="mleft22"><b>Sold By:</b> {{$orivar->products->store->name}}</small>
									<br>
									<small class="mleft22"><b>Price: </b> <i class="{{ $invoice->order->paid_in }}"></i>

										{{ round(($invoice->price),2) }}

									</small>

									<br>

									<small class="mleft22"><b>Tax:</b> <i
											class="{{ $invoice->order->paid_in }}"></i>{{ round(($invoice->tax_amount/$invoice->qty),2) }}

										@if($invoice->variant->products->tax_r !='')
										({{ $invoice->variant->products->tax_r.'% '.$invoice->variant->products->tax_name }}
										)

										@endif
									</small>

								</div>

							</div>





					</td>

					<td>
						{{ $invoice->qty }}
					</td>

					<td>
						@if($invoice->status == 'delivered')
						<span class="label label-success">{{ ucfirst($invoice->status) }}</span>
						@elseif($invoice->status == 'processed')
						<span class="label label-info">{{ ucfirst($invoice->status) }}</span>
						@elseif($invoice->status == 'shipped')
						<span class="label label-primary">{{ ucfirst($invoice->status) }}</span>
						@elseif($invoice->status == 'return_request')
						<span class="label label-warning">Return Request</span>
						@elseif($invoice->status == 'returned')
						<span class="label label-success">Returned</span>
						@elseif($invoice->status == 'cancel_request')
						<span class="label label-warning">Cancelation Request</span>
						@elseif($invoice->status == 'canceled')
						<span class="label label-danger">Canceled</span>
						@elseif($invoice->status == 'refunded')
						<span class="label label-primary">Refunded</span>
						@elseif($invoice->status == 'ret_ref')
						<span class="label label-success">Returned & Refunded</span>
						@else
						<span class="label label-default">{{ ucfirst($invoice->status) }}</span>
						@endif
					</td>

					<td>
						<b>Total Price:</b> <i class="{{ $invoice->order->paid_in }}"></i>

						{{ round(($invoice->price*$invoice->qty),2) }}

						<p></p>
						<b>Total Tax:</b> <i
							class="{{ $invoice->order->paid_in }}"></i>{{ round(($invoice->tax_amount),2) }}
						<p></p>
						<b>Shipping Charges:</b> <i
							class="{{ $invoice->order->paid_in }}"></i>{{ round($invoice->shipping,2) }}
						<p></p>


						<small class="help-block">(Price & TAX Multiplied with Quantity)</small>
						<p></p>


					</td>


					<td>
						<i class="{{ $invoice->order->paid_in }}"></i>

						{{ round($invoice->qty*$invoice->price+$invoice->tax_amount+$invoice->shipping,2) }}

						<br>

						<small>(Incl. of TAX & Shipping)</small>
					</td>

					<th>
						<a href="{{ route('print.invoice',['orderid' => $order->order_id, 'id' => $invoice->id]) }}"
							title="Print Invoice" href="#" class="btn btn-sm btn-default">
							<i class="fa fa-print"></i>
						</a>
					</th>
				</tr>
				@endforeach

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><b>Subtotal</b></td>
					<td><b><i
								class="{{ $invoice->order->paid_in }}"></i>{{ round($order->order_total+$order->discount,2) }}</b>
					</td>
					<td></td>
				</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><b>Coupon Discount</b></td>
					<td><b>- <i class="{{ $invoice->order->paid_in }}"></i>{{ round($order->discount,2) }}</b>
						({{ $order->coupon }})</td>
					<td></td>
				</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><b>Gift Packaging Charge</b></td>
					<td><b>+ <i class="{{ $invoice->order->paid_in }}"></i>{{ round($order->gift_charge,2) }}</b></td>
					<td></td>
				</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><b>Handling Charge</b></td>
					<td><b>+ <i class="{{ $invoice->order->paid_in }}"></i>{{ round($order->handlingcharge,2) }}</b>
					</td>
					<td></td>
				</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><b>Grand Total</b></td>
					<td><b><i class="{{ $invoice->order->paid_in }}"></i>

							{{ round($order->order_total+$order->handlingcharge,2) }}

						</b></td>
					<td></td>
				</tr>
			</tbody>
		</table>

		<hr>

		<hr>

		<h4>Order Activity Logs</h4>

		@if(count($order->orderlogs)<1) No activity logs for this order @else <small>
			<b>#{{ $inv_cus->order_prefix }}{{ $order->order_id }}</b></small>
			<br>
			<span id="logs">

				@foreach($order->orderlogs as $logs)

				@php
				$findinvoice = App\InvoiceDownload::find($logs->inv_id)->first();
				$orivar = App\AddSubVariant::withTrashed()->withTrashed()->findorfail($logs->variant_id);


				if($order->payment_method !='COD'){

				if(isset($cancellog)){
				$findinvoice2 = App\InvoiceDownload::where('id','=',$cancellog->inv_id)->first();
				$orivar2 = App\AddSubVariant::withTrashed()->withTrashed()->findorfail($findinvoice2->variant_id);
				}
				}

				@endphp



				<small>{{ date('d-m-Y | h:i:a',strtotime($logs->updated_at)) }} • For Order
					<b>{{ $orivar->products->name }}(@foreach($orivar->main_attr_value as $key=> $orivars)
						<?php $i++; ?>

						@php
						$getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
						$getvarvalue = App\ProductValues::where('id',$orivars)->first();
						@endphp

						@if($i < $varcount) @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
							$getvarvalue->unit_value != null)
							@if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name ==
							"Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name
							== "colour")
							{{ $getvarvalue->values }},
							@else
							{{ $getvarvalue->values }}{{ $getvarvalue->unit_value }},
							@endif
							@else
							{{ $getvarvalue->values }},
							@endif
							@else
							@if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
							$getvarvalue->unit_value != null)
							@if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name ==
							"Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name
							== "colour")
							{{ $getvarvalue->values }}
							@else
							{{ $getvarvalue->values }}{{ $getvarvalue->unit_value }}
							@endif
							@else
							{{ $getvarvalue->values }}
							@endif
							@endif
							@endforeach
							)</b>
					: @if($logs->user->role_id == 'a')
					<span class="text-red"><b>{{ $logs->user->name }}</b> (Admin)</span> changed status to
					<b>{{ $logs->log }}</b>
					@elseif($logs->user->role_id == 'v')
					<span class="text-blue"><b>{{ $logs->user->name }}</b> (Vendor)</span> changed status to
					<b>{{ $logs->log }}</b>
					@else
					<span class="text-green"><b>{{ $logs->user->name }}</b> (Customer)</span> changed status to
					<b>{{ $logs->log }}</b>
					@endif

				</small>
				<p></p>
				@endforeach
			</span>
			@endif
	</div>
</div>
@endsection