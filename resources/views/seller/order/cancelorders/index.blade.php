@extends("admindesk.layouts.sellermaster")
@section('title','Canceled Orders |')
@section('Canceled Orders')
@section("body")


<div class="box">
		<div class="box-header with-border">
			<div class="box-title">
				Canceled Orders 
			</div>
		</div>

		<div class="box-body">
			<div class="callout callout-success">
				<i class="fa fa-info-circle"></i> Note:

				<ul>
					<li>COD Orders are only viewable !</li>
					<li>For Prepaid canceled orders with refund method choosen Bank You can View Details IF refund is complete.</li>
					<li>For Prepaid canceled orders with refund method choosen orignal you can track refund status LIVE from respective Payment gateway & Update TXN/REF ID.
					</li>
				</ul>
			</div>

			<div class="nav-tabs-custom">
				 <ul class="nav nav-tabs" id="myTab" role="tablist">
				 		 <li data-toggle="popover" data-trigger="focus" title="Single Canceled Orders" data-content="If order have only 1 item than its count in single canceled orders." role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Single Canceled Orders @if($partialcount>0)<span class="badge badge-danger"><span id="pcount">{{ $partialcount }}</span> New @endif</a></li>
    					<li data-toggle="popover" data-trigger="focus" title="Bulk Canceled Orders" data-content="If order have more than 1 item than its count in Bulk canceled orders." role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Bulk Canceled Orders @if($partialcount2>0)<span class="badge badge-danger"><span id="fcount">{{ $partialcount2 }}</span> New @endif</a></li>
				 </ul>
			</div>
			
			<div class="tab-content">
				<div class="tab-pane active" id="home">
					<table id="full_detail_table" class="table table-responsive width100">
						<thead>

							<th>
								#
							</th>

							<th>
								Order TYPE
							</th>

							<th>
								ORDER ID
							</th>

							<th>
								REASON for Cancellation
							</th>

							<th>
								REFUND METHOD
							</th>

							<th>
								CUSTOMER
							</th>

							<th>
								REFUND STATUS
							</th>

						</thead>

							<tbody>
								@foreach($sellercanorders as $key=> $order)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>

											@if($order->order->payment_method != 'COD')
												<label class="label label-success">PREPAID</label>
											@else
												<label class="label label-primary">COD</label>
											@endif

										</td>
										<td>
											@if($order->read_at == NULL)
												<b>#{{ $inv_cus->order_prefix.$order->order->order_id }}</b>
											@else
												#{{ $inv_cus->order_prefix.$order->order->order_id }}
											@endif
											<br>
											<small class="text-center">
												@if($order->method_choosen == 'bank' || $order->order->payment_method == 'COD')
													<a onclick="readorder('{{ $order->id }}')" title="View Details" class="cursor-pointer" data-toggle="modal" data-target="#orderupdate{{ $order->id }}">View Details</a>
												@else

													<a onclick="readorder('{{ $order->id }}')" title="View Details" class="cursor-pointer" data-toggle="modal" data-target="#orderupdate{{ $order->id }}">View Details</a> | <a onclick="trackrefund('{{ $order->id }}')" class="cursor-pointer" title="Track REFUND">TRACK REFUND</a>
												@endif
											</small>
										</td>
										<td>
											{{ $order->comment }}
										</td>
										<td>
											 @if($order->method_choosen == 'bank')
												{{ ucfirst($order->method_choosen) }}
											 @elseif($order->method_choosen == 'orignal')
												{{ ucfirst($order->method_choosen) }} ({{ ucfirst($order->order->payment_method) }})
											 @else
											  No need for COD Orders
											 @endif
										</td>
										<td>
											@php
												$name = App\User::find($order->order->user_id)->name;
											@endphp

											@if(isset($name))
											{{ $name }}
											@else

											 No Name

											@endif
										</td>

										<td>
											@if($order->is_refunded == 'pending')
												<label class="label label-primary">{{ ucfirst($order->is_refunded) }}</label>
											@else
												<label class="label label-success">{{ ucfirst($order->is_refunded) }}</label>
											@endif
										</td>

										<!--trackmodel-->



									</tr>
								@endforeach
							</tbody>
						</table>
				</div>

			 <div role="tabpanel" class="tab-pane" id="profile">
			    	<br>
					<table id="full_detail_table2" class="table table-striped width100">
						<thead>
							<th>
								#
							</th>
							<th>
								Order TYPE
							</th>
							<th>
								Order ID
							</th>
							<th>
								REASON for Cancellation
							</th>
							<th>
								REFUND METHOD
							</th>
							<th>
								CUSTOMER
							</th>
							<th>
								REFUND STATUS
							</th>
						</thead>

						<tbody>
							@foreach($sellerfullcanorders as $key=> $fcorder)
								<tr>
									<td>{{ $key+1 }}</td>
									<td>

											@if($fcorder->getorderinfo->payment_method != 'COD')
												<label class="label label-success">PREPAID</label>
											@else
												<label class="label label-primary">COD</label>
											@endif
									</td>
									<td>
										@if($fcorder->read_at == NULL)
										<b>#{{ $inv_cus->order_prefix.$fcorder->getorderinfo->order_id }}</b>
										@else
											#{{ $inv_cus->order_prefix.$fcorder->getorderinfo->order_id }}
										@endif
										<br>
											<small class="text-center">
												@if($fcorder->method_choosen == 'bank' || $fcorder->getorderinfo->payment_method == 'COD')
													<a onclick="readfullorder('{{ $fcorder->id }}')" title="View Details" class="cursor-pointer" data-toggle="modal" data-target="#fullorderupdate{{ $fcorder->id }}">View Details</a>
												@else
													<a onclick="readfullorder('{{ $fcorder->id }}')" title="View Details" class="cursor-pointer" data-toggle="modal" data-target="#fullorderupdate{{ $fcorder->id }}">View Details</a> | <a class="cursor-pointer" title="Track REFUND" onclick="trackrefundFullCOrder('{{ $fcorder->id }}')">TRACK REFUND</a>
												@endif
											</small>
									</td>
									<td>
										{{ $fcorder->comment }}
									</td>
									<td>
											@if($fcorder->method_choosen == 'bank')
												{{ ucfirst($fcorder->method_choosen) }}
											 @elseif($fcorder->method_choosen == 'orignal')
												{{ ucfirst($fcorder->method_choosen) }} ({{ ucfirst($fcorder->getorderinfo->payment_method) }})
											 @else
											  No need for COD Orders
											 @endif
									</td>
									<td>
										{{ $fcorder->user->name }}
									</td>

									<td>
											@if($fcorder->is_refunded == 'pending')
												<label class="label label-primary">{{ ucfirst($fcorder->is_refunded) }}</label>
											@else
												<label class="label label-success">{{ ucfirst($fcorder->is_refunded) }}</label>
											@endif
									</td>


									<!-- END Full Order Update Modal -->
								</tr>
							@endforeach
						</tbody>
					</table>

			    </div>


			</div>
			 
		</div>
</div>

<!-- Single Refund Modal -->
@include('seller.order.cancelorders.singleordermodal')
<!--END-->

<!-- FULL Refund Modal -->
@include('seller.order.cancelorders.fullordermodal')
<!--END-->

@endsection
@section('custom-script')
    <script>var baseUrl = "<?= url('/') ?>";</script>
	<script src="{{ url('js/order.js') }}"></script>
@endsection