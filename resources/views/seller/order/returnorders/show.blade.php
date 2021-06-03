@extends('admindesk.layouts.sellermaster')
@section('title',"Show Return Order #$inv_cus->order_prefix$orderid |")
@section('body')


	<div class="box" >
		<div class="box-header with-border">
			
			<div class="box-title">
				<a title="Back" href="{{ route('seller.return.index') }}" class="pull-left btn btn-md btn-default">
					<i class="fa fa-reply" aria-hidden="true"></i>
				</a>&nbsp;&nbsp;Invoice No. {{ $inv_cus->prefix }}{{ $rorder->getorder->inv_no }}{{ $inv_cus->postfix }} | Order ID: {{ $inv_cus->order_prefix.$orderid }}
			</div>
			
		</div>

		<div class="box-body">
			
			<h4>Refund Order Summary</h4>
			<p></p>
			<table class="table table-striped">
				<thead>
					<th>
						Item
					</th>
					<th>
						Qty
					</th>
					<th>
						Status
					</th>
					<th>
						Refund Total
					</th>
					<th>
						REF.No/Transcation ID
					</th>
				</thead>

				<tbody>
					<tr>
						<td>

							<div class="row">
								<div class="col-md-2">
									<img class="pro-img" src="{{url('variantimages/'.$findvar->variantimages['image2'])}}" alt=""/>
								</div>

								<div class="col-md-10">
									<b>{{ $findvar->products->name }}
							(

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

					                    echo $getvarvalue->values;

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
				            @endphp)</b>
				            <br>
				            <small><b>Sold By:</b> {{$findvar->products->store->name}}</small>
								</div>
							</div>
							
						</td>
						<td>
							{{ $rorder->qty }}
						</td>
						<td>
							<b>{{ ucfirst($rorder->status) }}</b> 
						</td>
						<td>
							<b><i class="{{ $rorder->getorder->order->paid_in }}"></i>{{ round($rorder->amount,2) }}</b>
						</td>
						<td>
							<b>{{ $rorder->txn_id }}</b>
						</td>
					</tr>
				</tbody>
			</table>
			<p></p>
			<div class="reason">
				<blockquote>
					Reason for Return: <span class="font-weight">{{ $rorder->reason }}</span>
				</blockquote>
			</div>

			<p></p>
			<div class="reason">
				<blockquote>
					Refund Method Choosen: <span class="font-weight">@if($rorder->method_choosen != 'bank') {{ ucfirst($rorder->method_choosen) }}({{ $rorder->getorder->order->payment_method }})  @else {{ ucfirst($rorder->method_choosen) }} @endif</span>
				</blockquote>
			</div>

			<div class="row no-pad">
				@if($rorder->method_choosen == 'bank')
				<div class="col-md-6 text-center">
					<div class="card card-1">
							<div class="user-header">
								<h4>User's Payment Details</h4>

							</div>
						<div class="bankdetail">
								
								<p><b>A/c Holder name: </b> {{ $rorder->bank->acname }}</p>
								<p><b>Bank Name: </b> {{ $rorder->bank->acname }}</p>
								<p><b>A/c No. </b> {{ $rorder->bank->acno }}</p>
								<p><b>IFSC Code: </b> {{ $rorder->bank->ifsc }}</p>
							</div>
						
						</div>
				
				</div>
				@endif

<div class="{{ $rorder->method_choosen !='bank' ? "col-md-12" : "col-md-6" }} text-center">
					<div class="card card-1">

							<div class="user-header">
								<h4>Pickup Location</h4>

							</div>
						<div class="bankdetail">
							
							
							
							@foreach($rorder->pickup_location as $location)
							 @php
							 	$x = json_decode($location,true);
							 @endphp
								<h4><b>{{$x['name']}}</b></h4>
								<p>
									{{ strip_tags($x['address']) }}
								</p>
								<p>{{ $x['ci'] }},{{ $x['s'] }},{{ $x['c'] }},</p>
								<p>{{ $x['pincode'] }}</p>
							
							@endforeach
						</div>
						
					</div>
				</div>
			</div>
			
			
			<p></p>
			<div class="row">
				<h4 class="margin-15">Update Refund Details</h4>
				<form action="{{ route('final.process',$rorder->id) }}" method="POST">
					@csrf

					<div class="col-md-4">
						<label>AMOUNT:</label>
						<div class="input-group">
							 <div class="input-group-addon"><i class="{{ $rorder->getorder->order->paid_in }}"></i>
							 </div>
							
							<input readonly name="amount" id="txn_amount" type="text" class="form-control" value="{{ round($rorder->amount,2) }}"/>
						

						</div>
						
					</div>

					<div class="col-md-4">
						<label>Transaction ID:</label>
						<input {{ $rorder->method_choosen == 'bank' ? "" : "readonly" }} type="text" class="form-control" value="{{ $rorder->txn_id }}" name="txn_id">
					</div>

					<div class="col-md-4">
						<label>Transaction Fees:</label>
						<div class="input-group">
							 <div class="input-group-addon"><i class="{{ $rorder->getorder->order->paid_in }}"></i>
							 </div>
					   		<input {{ $rorder->method_choosen == 'bank' ? "" : "readonly" }} placeholder="0.00" type="text" class="form-control" value="" name="txn_fee" id="txn_fee">
						</div>
						
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label>Refund Status:</label>
							<input type="text" readonly="" value="{{ ucfirst($rorder->status) }}" class="form-control">
						</div>
					</div>

					<div class="col-md-4">
						<label>Order Status:</label>
						@if($rorder->getorder->status == 'return_request')
							<input type="text" readonly="" value="{{ 'Return Requested' }}" class="form-control">
						@else
							<input type="text" readonly="" value="{{ $rorder->getorder->status }}" class="form-control">
						@endif
					</div>
				
				</form>
			</div>
		</div>
	</div>
@endsection
