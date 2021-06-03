<!--for complete order cancel-->
@foreach($comOrder as $key=> $fcorder)
		<!-- Full Order Update Modal -->
<div  data-backdrop="static" data-keyboard="false" class="modal fade" id="fullorderupdate{{ $fcorder->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="width90 modal-dialog model-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
        	UPDATE ORDER: <b>#{{ $inv_cus->order_prefix.$fcorder->getorderinfo->order_id }}</b>
        </h4>
      </div> 
      <div class="modal-body">

       	<h4><b>Order Summary</b></h4>
			<hr>
			<div class="row">
				<div class="col-md-3"><b>Customer name</b></div>
				<div class="col-md-3"><b>Cancel Order Date</b></div>
				<div class="col-md-3"><b>Cancel Order Total</b></div>
				<div class="col-md-3"><b>REFUND Transcation ID /REF. ID</b></div>

					@php
						$realamount = $fcorder->getorderinfo->order_total;
					@endphp

				<div class="col-md-3">{{ $user = App\User::find($fcorder->getorderinfo->user_id)->name }}</div>
				<div class="col-md-3">{{ date('d-m-Y @ h:i A',strtotime($fcorder->created_at)) }}</div>
				<div class="col-md-3">
					<p>Order Total : <i class="{{ $fcorder->getorderinfo->paid_in }}"></i> {{ $realamount }}</p>
					
					@if($fcorder->getorderinfo->handlingcharge != 0)
						<p>Handling Charge : <i class="{{ $fcorder->getorderinfo->paid_in }}"></i> {{ $fcorder->getorderinfo->handlingcharge }}</p>
					@endif
					@if($fcorder->amount != $realamount)
						<p>Refunded Amount : <i class="{{ $fcorder->getorderinfo->paid_in }}"></i> {{$fcorder->amount}}</p>
					@endif

					
				</div>
				<div class="col-md-3"><b>{{ $fcorder->txn_id }}</b></div>
				
				<div class="margin-top-15 col-md-3">
					<p><b>REFUND Method:</b></p>
					
						

						@if($fcorder->getorderinfo->payment_method !='COD' && $fcorder->method_choosen != 'bank')
						
								{{ ucfirst($fcorder->method_choosen) }} ({{ $fcorder->getorderinfo->payment_method }})
							@elseif($fcorder->method_choosen == 'bank')
								{{ ucfirst($fcorder->method_choosen) }}
							@else
								No Need for COD Orders
							@endif
					
				</div>

				<div class="margin-top-15 col-md-6">
					<p><b>Cancelation Reason:</b></p>
					<blockquote>
						{{ $fcorder->comment }}
					</blockquote>
				</div>
			<form id="singleorderform" action="{{ route('full.can.order',$fcorder->id) }}" method="POST">
				<div class="col-md-12">
					<div class="row">
						<div class="margin-top-15 col-md-4">
					
					<label for="">UPDATE TXN ID OR REF. NO:</label>
					<input type="text" name="transaction_id" class="form-control" value="{{ $fcorder->txn_id }}" class="form-control">
					<br>
					
					<label>Amount :</label>
					<div class="input-group">
						 <div class="input-group-addon"><i class="{{ $fcorder->getorderinfo->paid_in }}"></i></div>
					<input {{$fcorder->method_choosen == 'bank' ? "" : "readonly"}} placeholder="0.00" type="text" name="amount" class="form-control" value="{{ $fcorder->amount }}" class="form-control">
					</div>
					<small class="help-block">
						
						(UPDATE AMOUNT IF CHANGES OR TRANSCATION FEE IS CHARGED)

					</small>
					
			   
				</div>

				<div class="margin-top-15 col-md-4">
					<label for="">UPDATE REFUND STATUS:</label>
					
					@if($fcorder->getorderinfo->payment_method !='COD')
					<select onchange="updatefullorder('{{ $fcorder->id }}')" name="refund_status" class="full_refund_status{{ $fcorder->id }} form-control">
						<option {{ $fcorder->is_refunded == 'completed' ? "selected" : ""}} value="completed">Completed</option>
						<option {{ $fcorder->is_refunded == 'pending' ? "selected" : "" }} value="pending">Pending</option>
					</select>
					@else
					<select readonly onchange="updatefullorder('{{ $fcorder->id }}')" name="refund_status" class="full_refund_status{{ $fcorder->id }} form-control">
						<option {{ $fcorder->is_refunded == 'completed' ? "selected" : ""}} value="completed">Completed</option>
						
					</select>
					@endif

					<br>
					
					<label>Transcation Fee:</label>
					<div class="input-group">
						 <div class="input-group-addon"><i class="{{ $fcorder->getorderinfo->paid_in }}"></i></div>
					<input {{$fcorder->method_choosen == 'bank' ? "" : "readonly"}} placeholder="0.00" type="text" name="txn_fee" class="form-control" value="{{ $fcorder->txn_fee }}" class="form-control">
				</div>
					<small class="help-block">
						
						(UPDATE TRANSCATION FEE IF CHARGED)

					</small>
					
					
						
					
				</div>
				@if($fcorder->method_choosen == 'bank')
					@php
						$bank = App\Userbank::where('id','=',$fcorder->bank_id)->first();
					@endphp
				<div class="col-md-4">
					@if(isset($bank))
					<label>Refund {{ ucfirst($fcorder->is_refunded) }} In {{ $bank->user->name }}'s Account Following are details:</label>
					

					<div class="well">
						
						<p><b>A/C Holder Name: </b>{{$bank->acname}}</p>
						<p><b>Bank Name: </b>{{ $bank->bankname }}</p>
						<p><b>Account No: </b>{{ $bank->acno }}</p>
						<p><b>IFSC Code: </b>{{ $bank->ifsc }}</p>


					</div>
					@else
						<p>User Deleted bank ac</p>
					@endif
				</div>
				@endif

					</div>
				</div>
			</div>
			@if($fcorder->getorderinfo->discount !=0)
			<div class="callout callout-success">
				Customer Apply <b>{{ $fcorder->getorderinfo->coupon }}</b> on this order.
			</div>
			@endif
			<h4><b>Items ({{ count($fcorder->inv_id) }})</b></h4>
			

			@if(is_array($fcorder->inv_id))
				@foreach($fcorder->inv_id as $invEx)
					
					@php
					    $inv = App\InvoiceDownload::withTrashed()->find($invEx);
						$orivar = App\AddSubVariant::withTrashed()->find($inv->variant_id);
						$varcount = count($orivar->main_attr_value);
						$i=0;
					@endphp

			<div class="row">
				<div class="col-md-6">

					<div class="row">
						<div class="col-md-2">
							@if($orivar->variantimages)
								<img class="pro-img" src="{{url('variantimages/'.$orivar->variantimages['main_image'])}}">
							@else
								<img class="pro-img" src="{{ Avatar::create($orivar->products->name) }}">	
							@endif
						</div>
						<div class="col-md-6">
							<a class="color111 margin-top-15" target="_blank" title="Click to view"><b>{{$orivar->products->name}}</b>

					<small>
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

                    </small></a>
					<br>
                    <small class="margin-left-15"><b>Sold By:</b> {{$orivar->products->store->name}}
                    </small>
                    <br>
                     <small class="margin-left-15"><b>Qty:</b> {{ $inv->qty }}
                     </small>
						</div>
					</div>
					
					
			
			
				</div>

				<div class="margin-top-15 col-md-2">
					<i class="{{ $fcorder->getorderinfo->paid_in }}"></i>
					@if($fcorder->getorderinfo->discount != 0)
						@if($fcorder->getorderinfo->distype == 'product')

							@if($inv->discount !=0 || $inv->discount !='')
								<b>{{ ($inv->price*$inv->qty+$inv->tax_amount+$inv->shipping)-$fcorder->getorderinfo->discount }}</b> &nbsp;
								<strike><i class="{{ $fcorder->getorderinfo->paid_in }}"></i> {{ $inv->price*$inv->qty+$inv->tax_amount+$inv->shipping }}</strike>

							@else
								{{ $inv->price*$inv->qty+$inv->tax_amount+$inv->shipping }}
							@endif

						@elseif($fcorder->getorderinfo->distype == 'cart')
								
							<b>{{ ($inv->price*$inv->qty+$inv->tax_amount+$inv->shipping)-$inv->discount }}</b> &nbsp;
								<strike><i class="{{ $fcorder->getorderinfo->paid_in }}"></i> {{ $inv->price*$inv->qty+$inv->tax_amount+$inv->shipping }}</strike>

						@elseif($fcorder->getorderinfo->distype == 'category')
							@if($inv->discount !=0 || $inv->discount !='')
								<b>{{ ($inv->price*$inv->qty+$inv->tax_amount+$inv->shipping)-$inv->discount }}</b> &nbsp;
								<strike><i class="{{ $fcorder->getorderinfo->paid_in }}"></i> {{ $inv->price*$inv->qty+$inv->tax_amount+$inv->shipping }}</strike>
							@else
								<b>{{ ($inv->price*$inv->qty+$inv->tax_amount+$inv->shipping)-$inv->discount }}</b>
							@endif
						@endif
					@else
						{{ $inv->price*$inv->qty+$inv->tax_amount+$inv->shipping }}
					@endif
				</div>
			
				
			
				@csrf
				

				<div class="col-md-2">
					<label>
						(UPDATE ORDER STATUS)
					</label>
			<select name="order_status[]" class="single_order_status{{ $fcorder->id }} form-control">
						@if($fcorder->is_refunded == 'pending')
						<option selected value="Refund Pending">Refund Pending</option>
						@elseif($fcorder->is_refunded == 'completed')
						<option {{ $inv->status == 'refunded' ? "selected" : "" }} value="refunded">Refunded</option>
						<option {{ $inv->status == 'returned' ? "selected" : "" }} value="returned">Returned</option>
						@endif
					</select>
					
				</div>

				
			</div>

			<hr>

				@endforeach
			@endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
      </div>
    </div>
  </div>
</div>

<!-- Track Refund Modal for full cancel modal -->
<div class="modal fade" id="ordertrackfull{{ $fcorder->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="width60 modal-dialog model-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Track REFUND FOR ORDER <b>#{{ $inv_cus->order_prefix.$fcorder->getorderinfo->order_id }}</b> | TXN ID : <b>{{  $fcorder->txn_id }}</b></h4>
	      </div>
	      <div class="modal-body">
	       	 <div id="refundAreafull{{ $fcorder->id }}">
	       	 	
	       	 </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button onclick="trackrefundFullCOrder('{{ $fcorder->id }}')" type="button" class="btn btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i> REFRESH</button>
	      </div>
	    </div>
	  </div>
</div>
	
@endforeach