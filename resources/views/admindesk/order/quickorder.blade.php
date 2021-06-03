<div class="box box-solid">

	<div class="box-header with-border">
		<span class="pull-right">
			<button onclick="collapseorder('{{ $order['id'] }}')" type="button" class="close" id="closebtn{{ $order['id'] }}" aria-label="Close">
                  <span aria-hidden="true">×</span>
            </button>
		</span>
		# <b>{{ $inv_cus['order_prefix'].$order['order_id'] }}</b>
		<br>
		<span>
			{{ date('d-M-Y | h:i A',strtotime($order['created_at'])) }}
		</span> 


	</div>

	<div class="box-header with-border">
		<p><b>Order from</b></p>
		<p><b>{{ $order->user->name }}</b></p>
		<p><b><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $order->user->email }}</b></p>
		@if($order->user->mobile)
			<p><b><i class="fa fa-phone" aria-hidden="true"></i> {{ $order->user->mobile }} </b></p>
		@endif
		@if(isset($order->user->country->nicename))
		<p>
			<b><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $order->user['city']['name'] }}, {{ $order->user['state']['name'] }}, {{ $order->user['country']['nicename'] }}</b>
		</p>
		@endif
	</div>

	<div class="box-header with-border">
		@foreach($order->invoices->where('status','pending') as $suborder)
			<div class="row">
				<div class="col-md-2">
					@if($suborder->variant->variantimages)
						<img width="50px" src="{{ url('/variantimages/'.$suborder->variant->variantimages['main_image']) }}" alt="" class="m-t-2 img-responsive" title="{{ $suborder->variant->products['name'] }}" alt="Product Image" />
					@else
						<img width="50px" src="{{ Avatar::create($suborder->variant->products['name'])->toBase64() }}" alt="" class="m-t-2 img-responsive" title="{{ $suborder->variant->products['name'] }}" alt="Product Image" />
					@endif
				</div>
				<div class="col-md-5">
					{{ $suborder->variant->products['name'] }} <b>(x {{ $suborder['qty'] }})</b>
				</div>
				<div class="col-md-5">
					<i class="{{ $order['paid_in'] }}"></i> {{ $suborder->price + $suborder->tax_amount + $suborder->shipping }}
					<br>
					<small>(Incl. of Tax & Shipping).</small>
				</div>
			</div>
			
		@endforeach
	</div>

	<div class="box-header with-border">
		
		<div class="row">

			<div class="text-left col-md-offset-5 col-md-4">
				<span><b>Subtotal: </b></span>
			</div>
			<div class="col-md-3">
				@if($order->discount != 0)
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order['order_total'] + $order['discount']) }}
				@else
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order['order_total'])  }}
				@endif
			</div>

			@if($order->discount != 0)
				<div class="col-md-offset-5 col-md-4">
					<b>Coupon discount: </b>
				</div>
				<div class="col-md-3">
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order['discount']) }}
				</div>
				@endif

				@if($order->gift_charge != 0)
					<div class="col-md-offset-5 col-md-4">
						<b>Gift Pkg. charges: </b>
					</div>
					<div class="col-md-3">
						+ <i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order->gift_charge) }}
					</div>
				@endif
				
				@if($order->handlingcharge != 0)
					<div class="col-md-offset-5 col-md-4">
						<b>Handling charges: </b>
					</div>
					<div class="col-md-3">
						+ <i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order->handlingcharge) }}
					</div>
				@endif

			<div class="col-md-offset-5 col-md-4">
				<b>Total: </b>
			</div>
			<div class="col-md-3">
				@if($order->discount != 0)
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order->order_total + $order->handlingcharge) }}
				@else
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order->order_total + $order->handlingcharge) }}
				@endif
			</div>

		</div>
	</div>

	<div class="box-header with-border">
		<div class="row">
			<div class="col-md-6">
				<p>Paid by:</p>
			</div>

			<div class="col-md-6">
				<p>Payment received</p>
			</div>

			<div class="col-md-6">
				<p><b>Razorpay</b></p>
			</div>

			<div class="col-md-6">
				<p><b>Yes</b></p>
			</div>

		</div>
	</div>
	

</div>