@extends('admindesk.layouts.sellermaster')
@section('title',"Show Return Order Detail #$inv_cus->order_prefix$orderid |")
@section('title','Returned Orders |')
@section('body')
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title">
				<a title="Back" href="{{ route('seller.return.index') }}" class="back btn btn-md btn-default">
					<i class="fa fa-reply"></i>
				</a>


				Return & Refund Detail for Item <b>{{ $findvar->products->name }}
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
			</div>

			<a title="Print Slip" onclick="window.print()" class="back pull-right btn btn-md btn-default">
					<i class="fa fa-print"></i>
				</a>

		</div>

		<div class="box-body">

			<div class="row">
				<div class="col-md-4">
					<h5 class="margin-15">Order <b>#{{ $inv_cus->order_prefix.$orderid }}</b>
					</h5>
				</div>
				<div class="col-md-4">
					<h5 class="margin-15">TXN ID: <b>{{ $order->txn_id }}</b>
					</h5>
				</div>
				<div class="col-md-4">
					<h5 class="margin-15">Refunded On: <b>{{ date('d-m-Y @ h:i A',strtotime($order->updated_at)) }}</b></h5>
				</div>

				<div class="col-md-4">
					<h4 class="margin-15">Customer Name:
					<b>{{ ucfirst($order->user->name) }}</b></h4>
				</div>

				<div class="col-md-4">
					<h4 class="margin-15">Refund Method : <b>{{ ucfirst($order->pay_mode) }}</b></h4>
				</div>

				@if($order->pay_mode == 'bank')
					<div class="col-md-4">
						<h4 class="margin-15">Refunded To {{ ucfirst($order->user->name) }}'s Bank A/C <b>XXXX{{ substr($order->bank->acno, -4) }}</b></h4>
					</div>
				@endif

			</div>
			<hr>
			<table class="font-size-14 width100 table table-striped">
				<thead>
					<th>
						Item
					</th>

					<th>
						Qty
					</th>

					<th>
						Refunded Amount
					</th>

					<th>
						Additional Info.
					</th>
				</thead>

				<tbody>
					<tr>
						<td width="40%">
							<div class="col-md-2">
								@if($findvar->variantimages)
									<img class="pro-img" src="{{url('variantimages/'.$findvar->variantimages['main_image'])}}"/>
								@else
									<img class="pro-img" src="{{ Avatar::create($findvar->products->name) }}"/>
								@endif
							</div>
							<div class="col-md-offset-2 col-md-8">
								<a ><b>{{$findvar->products->name}}</b>

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
			                 <small><b>Sold By:</b> {{$findvar->products->store->name}}</small>
			                <br>
			               
							</div>
						</td>
						<td>
							{{$order->getorder->qty}}
						</td>

						<td><b><i class="{{ $order->mainOrder->paid_in }}"></i>{{ $order->amount }} </b><br>
                         
                        </td>

                        <td>
							
							@if($order->txn_fee !='')
								<p><b>Transcation FEE:</b> &nbsp;<i class="{{ $order->mainOrder->paid_in }}"></i>{{ $order->txn_fee }} (During Bank Transfer)</p>
							@endif
				
							@if($findvar->products->returnPolicy->amount !=0 || $findvar->products->returnPolicy->amount !='')
								<p>As per Product {{$findvar->products->returnPolicy->name}}  Policy <b>{{$findvar->products->returnPolicy->amount}}%</b> is deducted from Order Amount.</p>
							@endif
                        	
                        </td>



					</tr>
				</tbody>
			</table>

		</div>

	</div>
@endsection