@extends("admindesk/layouts.master")
@section('title',"Edit Order : $inv_cus->order_prefix$order->order_id | ")
@section("body")

@php
$orderlog = $order->fullordercancellog;
$checkOrderCancel = $order->cancellog;
$i=0;
$deliverycheck = array();
$tstatus = 0;
$cancel_valid = array();
@endphp

@if(isset($order))

@if(count($order->invoices)>1)

@foreach($order->invoices as $inv)
@if($inv->variant->products->cancel_avl != 0)
@php
array_push($cancel_valid,1);
@endphp
@else
@php
array_push($cancel_valid,0);
@endphp
@endif
@endforeach

@else
@php
array_push($cancel_valid,0);
@endphp
@endif

@foreach($order->invoices as $sorder)
@if($sorder->status == 'delivered' || $sorder->status == 'cancel_request' || $sorder->status =='return_request' ||
$sorder->status == 'returned' || $sorder->status == 'ret_ref' || $sorder->status == 'refunded')
@php
	array_push($deliverycheck, 0);
@endphp
@else
@php
	array_push($deliverycheck, 1);
@endphp
@endif
@endforeach
@endif

@if(in_array(0, $deliverycheck))
<?php
	$tstatus = 1;
?>
@endif

@if($order->manual_payment == '1')
<div class="callout callout-success">
	<i class="fa fa-info-circle"></i> This order is placed using {{ ucfirst($order->payment_method) }} method and
	purchase proof you can view <a href="{{ url('images/purchase_proof/'.$order->purchase_proof) }}"
		data-lightbox="image-1" data-title="Purchase proof for {{ $order->order_id }}">here</a> and after verify you can
	change the order status.
</div>
@endif


<div class="box">
	<div class="box-header with-border">

		<div class="box-title">
			<a title="Go Back" href="{{ url('admindesk/order') }}" class="btn btn-md btn-default"><i class="fa fa-reply"
					aria-hidden="true"></i>
			</a>

			Edit Order #{{ $inv_cus->order_prefix.$order->order_id }}


		</div>

		@if($tstatus != 1 && !$order->fullordercancellog()->count() && !$order->cancellog()->count())
		<a id="fullcanbtn" @if(env('DEMO_LOCK')==0) title="Cancel FULL Order?" data-toggle="modal"
			data-target="#cancelFULLOrder" @else disabled title="This action is disabled in demo !" @endif
			class="pull-right btn btn-md btn-danger">
			Cancel Order
		</a>
		@endif


	</div>

	<div class="box-body">
		@if(isset($orderlog))
		@if(count($orderlog->inv_id) != count($order->invoices))

		<div class="callout callout-danger">

			<p class="font-weight500 font-familycalibri">
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

			<p class="font-weight500 font-familycalibri">
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

		@if($order->refundlogs()->count() > 0)

		@foreach($order->refundlogs->sortByDesc('id') as $rlogs)

		@php
		$orivar2 = App\AddSubVariant::withTrashed()->withTrashed()->withTrashed()->find($rlogs->getorder->variant_id);
		if($orivar2){
		$varcount = count($orivar2->main_attr_value);
		}
		@endphp

		@if($orivar2)

		<div class="callout callout-danger">
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

		@endif

		@endforeach
		@endif
		@if($order->cancellog->count()>0)

		<div class="callout callout-danger">
			@foreach($order->cancellog->sortByDesc('id') as $cancellog)
			@php
			$orivar2 = App\AddSubVariant::withTrashed()->withTrashed()->findorfail($cancellog->singleOrder->variant_id);
			$varcount = count($orivar2->main_attr_value);
			@endphp
			<p><i class="fa fa-info-circle"></i> {{ date('d-m-Y | h:i A',strtotime($cancellog->updated_at)) }} • Item
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
						)</b> has been canceled

				@if($cancellog->method_choosen == 'orignal')

				and Amount <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
				is refunded to its orignal source with TXN ID: <b>{{ $cancellog->transaction_id }}</b>.


				@elseif($cancellog->method_choosen == 'bank')
				@if($cancellog->is_refunded == 'completed')
				and Amount <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
				is refunded to <b>{{ $cancellog->user->name }}'s</b> bank ac with TXN ID
				<b>{{ $cancellog->transaction_id }} @if($cancellog->txn_fee !='') <br> (TXN FEE APPLIED) <b><i
							class="{{ $order->paid_in }}"></i>{{ $cancellog->txn_fee }}</b> @endif</b>.
				@else
				and Amount <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
				is pending to <b>{{ $cancellog->user->name }}'s</b> bank ac with TXN ID/REF NO
				<b>{{ $cancellog->transaction_id }}</b> @if($cancellog->txn_fee !='') <br> (TXN FEE APPLIED) <b><i
						class="{{ $order->paid_in }}"></i>{{ $cancellog->txn_fee }}</b> @endif.
				@endif
				@endif</p>
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
						$ci = App\Allcity::where('id',$user->city_id)->first() ? App\Allcity::where('id',$user->city_id)->first()->name : '';
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
						$user = App\User::find($order->user_id);

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
						@if($order->payment_method !='COD' && $order->payment_method != 'BankTransfer')
						<p><b>Payment Recieved:</b> {{ ucfirst($order->payment_receive)  }}</p>
						@else
						<label for="pay_confirm">Payment Recieved:</label>
						<select class="form-control" name="pay_confirm" id="pay_confirm">
							<option {{ $order->payment_receive == 'yes' ? "selected" : "" }} value="yes">Yes</option>
							<option {{ $order->payment_receive == 'no' ? "selected" : "" }} value="no">No</option>
						</select>
						@endif
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

		@if($invoice->local_pick != '' && $invoice->status != 'return_request' && $invoice->status != 'refunded' &&
		$invoice->status !='ret_ref')
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


		@foreach($order->invoices as $invoice)
		@php
		$varcount = count($invoice->variant->main_attr_value);
		@endphp
		@if($invoice->local_pick !='' && $invoice->status != 'delivered' && $invoice->status != 'return_request' &&
		$invoice->status != 'refunded' && $invoice->status !='ret_ref')
		<div class="container">
			<div class="row border-box">
				<p>Update Local Pickup Delivery dates: </p>
				<div class="col-md-4">
					<h4>{{ $invoice->variant->products->name }} <small>
							(@foreach($invoice->variant->main_attr_value as $key=> $orivars)
							<?php $i++; ?>

							@php
							$getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
							$getvarvalue = App\ProductValues::where('id',$orivars)->first();
							@endphp

							@if($i < $varcount) @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
								$getvarvalue->unit_value != null)
								@if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name ==
								"Colour" || $getvarvalue->proattr->attr_name == "color" ||
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

								@if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name ==
								"Colour" || $getvarvalue->proattr->attr_name == "color" ||
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
					</h4>
				</div>
				<form method="POST" action="{{ route('update.local.delivery',$invoice->id) }}">
					@csrf
					<div class="col-md-4">
						<div class='input-group date lcpdate'>
							<input required="" name="del_date" type='text' id="datetimepicker2"
								value="{{ $invoice->loc_deliv_date }}" class="form-control" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
					<div class="col-md-4">
						<button type="submit" class="btn btn-md btn-primary">
							<i class="fa fa-save"></i> Save
						</button>
					</div>
				</form>
			</div>
		</div>
		<br>
		@endif
		@endforeach


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
					<th>Action</th>
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
									<a class="mleft22 text-justify" target="_blank" title="Click to view"
										href="{{ url($url) }}"><b>{{substr($orivar->products->name, 0, 25)}}{{strlen($orivar->products->name)>25 ? '...' : ""}}</b>

										<small>
											(@foreach($orivar->main_attr_value as $key=> $orivars)
											<?php $i++;?>

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
									<small class="mleft22"><b>Sold By:</b>{{$orivar->products->store->name}}</small>
									<br>
									<small class="mleft22"><b>Price:</b>
										<i class="{{ $invoice->order->paid_in }}"></i>

										{{ round(($invoice->price),2) }}

									</small>
									<br>
									<small class="mleft22"><b>Tax:</b> <i
											class="{{ $invoice->order->paid_in }}"></i>{{ round($invoice->tax_amount/$invoice->qty,2) }}</small>

								</div>
							</div>





					</td>

					<td>
						{{ $invoice->qty }}
					</td>

					<td>
						<div id="singleorderstatus{{ $invoice->id }}">
							@if($invoice->status == 'delivered')
							<span class="label label-success">{{ ucfirst($invoice->status) }}</span>
							@elseif($invoice->status == 'processed')
							<span class="label label-info">{{ ucfirst($invoice->status) }}</span>
							@elseif($invoice->status == 'shipped')
							<span class="label label-primary">{{ ucfirst($invoice->status) }}</span>
							@elseif($invoice->status == 'return_request')
							<span class="label label-warning">Return Requested</span>
							@elseif($invoice->status == 'returned')
							<span class="label label-success">Returned</span>
							@elseif($invoice->status == 'cancel_request')
							<span class="label label-warning">Cancelation Request</span>
							@elseif($invoice->status == 'canceled')
							<span class="label label-danger">Canceled</span>
							@elseif($invoice->status == 'refunded')
							<span class="label label-danger">Refunded</span>
							@elseif($invoice->status == 'ret_ref')
							<span class="label label-success">Return & Refunded</span>
							@else
							<span class="label label-default">{{ ucfirst($invoice->status) }}</span>
							@endif
						</div>
						<p></p>
						@php
						$cancellog =
						App\CanceledOrders::where('order_id','=',$invoice->order->id)->where('inv_id','=',$invoice->id)->first();
						@endphp



						@if(!empty($cancellog) || $invoice->status == 'canceled' || $invoice->status == 'refunded' ||
						$invoice->status == 'returned' || $invoice->status == 'refunded' || $invoice->status ==
						'ret_ref' || $invoice->status == 'return_request')

						<select disabled="" class="form-control">
							<option {{ $invoice->status =="pending" ? "selected" : "" }} value="pending">Pending
							</option>
							<option {{ $invoice->status =="processed" ? "selected" : "" }} value="processed">Processed
							</option>
							<option {{ $invoice->status =="shipped" ? "selected" : "" }} value="shipped">Shipped
							</option>
							<option {{ $invoice->status =="delivered" ? "selected" : "" }} value="delivered">Delivered
							</option>

							<option {{ $invoice->status =="return_request" ? "selected" : "" }} value="return_request">
								Return Requested</option>
							<option {{ $invoice->status =="returned" ? "selected" : "" }} value="returned">Returned
							</option>
							<option {{ $invoice->status =="cancel_request" ? "selected" : "" }} value="cancel_request">
								Canceled Request</option>

							<option {{ $invoice->status =="canceled" ? "selected" : "" }} value="canceled">Canceled
							</option>

							<option {{ $invoice->status =="refunded" ? "selected" : "" }} value="refunded">Refunded
							</option>

							<option {{ $invoice->status =="ret_ref" ? "selected" : "" }} value="refunded">Return &
								Refunded</option>

						</select>
						@else
						<select name="status" id="status{{ $invoice->id }}"
							onchange="changeStatus('{{ $invoice->id }}')" class="form-control">
							<option {{ $invoice->status =="pending" ? "selected" : "" }} value="pending">Pending
							</option>
							<option {{ $invoice->status =="processed" ? "selected" : "" }} value="processed">Processed
							</option>
							<option {{ $invoice->status =="shipped" ? "selected" : "" }} value="shipped">Shipped
							</option>
							<option {{ $invoice->status =="delivered" ? "selected" : "" }} value="delivered">Delivered
							</option>

						</select>
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

					<td>

						@php
						$log = App\CanceledOrders::where('inv_id', '=',
						$invoice->id)->where('user_id',$invoice->order->user_id)->first();
						@endphp

						@if($invoice->status != 'canceled' && $invoice->status != 'returned' && $invoice->status !=
						'return_request' && $invoice->status != 'delivered' && $invoice->status !='ret_ref' &&
						$invoice->status !='refunded' && $invoice->variant->products->cancel_avl !=0)
						<a @if(env('DEMO_LOCK')==0) id="canbtn{{ $invoice->id }}" data-toggle="modal"
							data-target="#singleordercancel{{ $invoice->id }}" @else disabled
							title="This action is disabled in demo !" @endif title="Cancel this order?" href="#"
							class="btn btn-sm btn-danger">Cancel
						</a>
						@elseif($invoice->variant->products->cancel_avl ==0)
						<a disabled class="btn btn-sm btn-danger">No Cancellation Available</a>
						@else
						<a disabled class="btn btn-sm btn-danger">No action for you.</a>
						@endif
					</td>


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

		<h4>Order Activity Logs</h4>

		@if(count($order->orderlogs)<1) <span id="ifnologs">No activity logs for this order <br></span>

			@endif

			<small><b>#{{ $inv_cus->order_prefix }}{{ $order->order_id }}</b><br></small>

			<span id="logs">


				@foreach($order->orderlogs as $logs)

				@php
				$findinvoice = App\InvoiceDownload::find($logs->inv_id)->first();
				$orivar = App\AddSubVariant::withTrashed()->withTrashed()->find($logs->variant_id);

				if($order->payment_method !='COD'){

				if(isset($cancellog)){
				$findinvoice2 = App\InvoiceDownload::where('id','=',$cancellog->inv_id)->first();
				$orivar2 = App\AddSubVariant::withTrashed()->withTrashed()->findorfail($findinvoice2->variant_id);
				}

				}
				@endphp



				<small>{{ date('d-m-Y | h:i:a',strtotime($logs->updated_at)) }} • For Order
					<b>{{ $orivar->products->name }}(@foreach($orivar->main_attr_value as $key=> $orivars)
						<?php $i++;?>

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

	</div>
</div>

@foreach($order->invoices as $o)

	@if($o->status != 'canceled' && $o->status != 'returned' && $o->status !=
							'return_request' && $o->status != 'delivered' && $o->status !='ret_ref' &&
							$o->status !='refunded' && $o->variant->products->cancel_avl != 0)
							
		<div data-backdrop="static" data-keyboard="false" class="modal fade" id="singleordercancel{{ $o->id }}" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Cancel Item: {{$orivar->products->name}}
							(@foreach($orivar->main_attr_value as $key=> $orivars)
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
								)</h4>
					</div>

					<div class="modal-body">
						@php
						$secureid = Crypt::encrypt($o->id);
						@endphp
						@if($o->status != 'returned' && $o->status != 'return_request' && $o->status != 'delivered' &&
						$o->status !='ret_ref' && $o->status !='refunded' && $o->variant->products->cancel_avl != 0)
						<form action="{{ route('cancel.item',$secureid) }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="">Choose Reason <span class="required">*</span></label>
								<select class="form-control" required="" name="comment" id="">
									<option value="">Please Choose Reason</option>
									<option value="Requested by User">Requested by User</option>
									<option value="Order Placed Mistakely">Order Placed Mistakely</option>
									<option value="Shipping cost is too much">Shipping cost is too much</option>
									<option value="Wrong Product Ordered">Wrong Product Ordered</option>
									<option value="Product is not match to my expectations">Product is not match to my
										expectations</option>
									<option value="Other">My Reason is not listed here</option>
								</select>
							</div>
							@if($order->payment_method !='COD' && $order->payment_method !=' BankTransfer')
							<div class="form-group">

								<label for="">Choose Refund Method:</label>
								<label><input onclick="hideBank('{{ $o->id }}')" id="source_check_o{{ $o->id }}" required
										type="radio" value="orignal" name="source" />Orignal Source
									[{{ $o->order->payment_method }}] </label>&nbsp;&nbsp;
								@if($order->user->banks->count()>0)
								<label><input onclick="showBank('{{ $o->id }}')" id="source_check_b{{ $o->id }}" required
										type="radio" value="bank" name="source" />In Bank</label>
								@else
								<label><input disabled="disabled" type="radio" /> In Bank <i class="fa fa-question-circle"
										data-toggle="tooltip" data-placement="right"
										title="Add a bank account in My Bank Account" aria-hidden="true"></i></label>
								@endif

								<select name="bank_id" id="bank_id_single{{ $o->id }}" class="form-control display-none">
									@foreach($order->user->banks as $bank)
									<option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
									@endforeach
								</select>

							</div>


							@else

							@if($order->user->banks->count()>0)
							<label><input onclick="showBank('{{ $o->id }}')" id="source_check_b{{ $o->id }}" required
									type="radio" value="bank" name="source" />In Bank</label>
							@else
							<label><input disabled="disabled" type="radio" /> In Bank <i class="fa fa-question-circle"
									data-toggle="tooltip" data-placement="right" title="Add a bank account in My Bank Account"
									aria-hidden="true"></i></label>
							@endif

							<select name="bank_id" id="bank_id_single{{ $o->id }}" class="display-none form-control">
								@foreach($order->user->banks as $bank)
								<option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
								@endforeach
							</select>


							@endif

							<div class="alert alert-info">
								<h5><i class="fa fa-info-circle"></i> Important !</h5>

								<ol class="ol">
									<li>IF Original source is choosen than amount will be reflected to User's orignal source in
										1-2 days(approx).
									</li>

									<li>
										IF Bank Method is choosen than make sure User added a bank account else refund will not
										procced. IF already added than it will take 14 days to reflect amount in users bank
										account (Working Days*).
									</li>

									<li>Amount will be paid in original currency which used at time of placed order.</li>

								</ol>
							</div>
							<button type="submit" class="btn btn-md btn-primary">
								Procced...
							</button>
							<p class="help-block">This action cannot be undone !</p>
							<p class="help-block">It will take time please do not close or refresh window !</p>
						</form>

						@endif

					</div>


				</div>
			</div>
		</div>
	@endif

@endforeach
<!-- Full order cancel modal-->
@if(!$order->fullordercancellog()->count())
<!-- Modal -->
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="cancelFULLOrder" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Cancel Order: #{{ $inv_cus->order_prefix.$order->order_id }}
				</h4>
			</div>
			<div class="modal-body">
				@php
					$secureorderID = Crypt::encrypt($order->id);
				@endphp
				<form method="POST" action="{{ route('full.order.cancel',$secureorderID) }}">
					@csrf

					<div class="form-group">
						<label for="">Choose Reason <span class="required">*</span></label>
						<select class="form-control" required="" name="comment" id="">
							<option value="">Please Choose Reason</option>
							<option value="Requested by User">Requested by User</option>
							<option value="Order Placed Mistakely">Order Placed Mistakely</option>
							<option value="Shipping cost is too much">Shipping cost is too much</option>
							<option value="Wrong Product Ordered">Wrong Product Ordered</option>
							<option value="Product is not match to my expectations">Product is not match to my
								expectations</option>
							<option value="Other">My Reason is not listed here</option>
						</select>
					</div>

					@if($order->payment_method !='COD' && $order->payment_method !='BankTransfer')
					<div class="form-group">

						<label for="">Choose Refund Method:</label>
						<label><input required class="source_check" type="radio" value="orignal" name="source" />Orignal
							Source [{{ $order->payment_method }}] </label>&nbsp;&nbsp;
						@if(Auth::user()->banks->count()>0)
						<label><input required class="source_check" type="radio" value="bank" name="source" /> In
							Bank</label>

						<select name="bank_id" id="bank_id" class="display-none form-control">
							@foreach($order->user->banks as $bank)
							<option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
							@endforeach
						</select>

						@else
						<label><input type="radio" disabled="" /> In Bank <i class="fa fa-question-circle"
								data-toggle="tooltip" data-placement="right"
								title="Add a bank account in My Bank Account" aria-hidden="true"></i></label>

						@endif
					</div>



					@else

					@if($order->user->banks->count()>0)
					<label><input required class="source_check" type="radio" value="bank" name="source" /> In
						Bank</label>

					<select name="bank_id" id="bank_id" class="display-none form-control">
						@foreach($order->user->banks as $bank)
						<option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
						@endforeach
					</select>

					@else
					<label><input type="radio" disabled="" /> In Bank <i class="fa fa-question-circle"
							data-toggle="tooltip" data-placement="right" title="Add a bank account in My Bank Account"
							aria-hidden="true"></i></label>

					@endif

					@endif

					<div class="alert alert-info">
						<h5><i class="fa fa-info-circle"></i> Important !</h5>

						<ol class="ol">
							<li>IF Original source is choosen than amount will be reflected to your orignal source in
								1-2 days(approx).
							</li>

							<li>
								IF Bank Method is choosen than make sure you added a bank account else refund will not
								procced. IF already added than it will take 14 days to reflect amount in your bank
								account (Working Days*).
							</li>

							<li>Amount will be paid in original currency which used at time of placed order.</li>

						</ol>
					</div>

					<button type="submit" class="btn btn-md btn-primary">
						Procced...
					</button>
				</form>
				<p class="help-block">This action cannot be undone !</p>
				<p class="help-block">It will take time please do not close or refresh window !</p>
			</div>

		</div>
	</div>
</div>
@endif
<!--END-->

@endsection
@section('custom-script')
<script>
	var url = {!!json_encode(url('/update/orderstatus')) !!};
	var userrole = {!!json_encode(Auth::user()->role_id) !!};
	var username = {!!json_encode(Auth::user()->name) !!};
	var orderid  = {!!json_encode($order->id) !!};
</script>
<script src="{{ url('js/editorder.js') }}"></script>
<script src="{{ url('js/order.js') }}"></script>
@endsection