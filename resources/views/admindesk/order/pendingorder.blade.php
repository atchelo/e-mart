@extends("admindesk.layouts.master")
@section('title','Pending Orders - ')
@section("body")
		
		@if(count($orders)>0)
		
		<div class="row no-gutter">

				<div class="col-md-12">
					@foreach($orders as $order)
			 
						<div onclick="orderget({{ $order['id'] }})" id="orderbox{{ $order['id'] }}" class="orderbox col-md-12">
							<div class="box box-solid">
								<div class="box-body admin-order">
									<span class="pull-right h4" href=""><sup><i class="{{ $order['paid_in'] }}"></i> </sup>{{ $order['total'] + $order['handlingcharge'] }}</span>
									<h4>#{{ $inv_cus['order_prefix'].$order['orderid'] }}</h4>
									<div class="order-confirm">
										<div class="row">
											<div class="col-md-6">
												<div class="admin-paid">
													<p>Order By: <span>{{ $order['customername'] }}</span></p>
													<p>Paid Via: <span>{{ $order['payment_method'] }}</span></p>
												</div>
											</div>
											<div class="col-md-6">
												<a @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#cancelFULLOrder{{ $order['id'] }}" @else disabled title="This action is disabled in demo !" @endif class="ml-5 pull-right btn btn-md btn-danger">
													<i class="fa fa-times"></i> {{ __('Cancel') }}
												</a>
											
													<button type="button" @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#confirm{{ $order['id'] }}" @else disabled="" title="This action cannot be done in demo !" @endif class="marginleft-5 pull-right btn btn-md btn-primary">
														<i class="fa fa-check"></i> {{ __('Confirm') }}
													</button>

												
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Confirm Order before procced modal -->
							<div id="confirm{{ $order['id']}}" class="delete-modal modal fade" role="dialog">
		                        <div class="modal-dialog modal-sm">
		                          <!-- Modal content-->
		                          <div class="modal-content">
		                            <div class="modal-header">
		                              <button type="button" class="close" data-dismiss="modal">&times;</button>
		                              <div class="delete-icon"></div>
		                            </div>
		                            <div class="modal-body text-center">
		                              <h4 class="modal-heading">Are You Sure ?</h4>
		                              <p>Do you really want to confirm this order ? it will confirm the whole order.</p>
		                            </div>
		                            <div class="modal-footer">
		                                <form action="{{ route('quick.pay.full.order',$order['id']) }}" method="POST">
											@csrf
											<input type="hidden" name="status" value="processed">
			                                          
			                                 <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
		                                	<button type="submit" class="btn btn-danger">Yes</button>
		                              	</form>
		                            </div>
		                          </div>
		                        </div>
		                    </div>
						<!-- End -->

						<!-- Full order cancel modal-->
						@if(!isset($checkOrderCancel) || !isset($orderlog))
						  <!-- Modal -->
						<div data-backdrop="static" data-keyboard="false" class="modal fade" id="cancelFULLOrder{{ $order['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Cancel Order: #{{ $inv_cus->order_prefix.$order['orderid'] }}</h4>
						      </div>
						      <div class="modal-body">
						        @php
						          $secureorderID = Crypt::encrypt($order['id']);
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
						              <option value="Product is not match to my expectations">Product is not match to my expectations</option>
						              <option value="Other">My Reason is not listed here</option>
						          </select>
						        </div>

						        @php
						        	$user = App\User::find($order['userid']);
						        @endphp

						        @if($order->payment_method !='COD' && $order->payment_method !='BankTransfer')
						           <div class="form-group">

						              <label for="">Choose Refund Method:</label>
						              <label><input required class="source_check" type="radio" value="orignal" name="source" />Orignal Source [{{ $order->payment_method }}] </label>&nbsp;&nbsp;
						              @if($user->banks->count()>0)
						              <label><input required class="source_check" type="radio" value="bank" name="source" /> In Bank</label>

						              <select name="bank_id" id="bank_id" class="display-none form-control">
						                @foreach($user->banks as $bank)
						                  <option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
						                @endforeach
						              </select>

						              @else
						              <label><input type="radio" disabled="" /> In Bank  <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="Add a bank account in My Bank Account" aria-hidden="true"></i></label>

						              @endif
						            </div>
						            


						        @else

						         @if($user->banks->count()>0)
						              <label><input required class="source_check" type="radio" value="bank" name="source" /> In Bank</label>

						              <select name="bank_id" id="bank_id" class="display-none form-control">
						                @foreach($user->banks as $bank)
						                  <option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
						                @endforeach
						              </select>

						        @else
						              <label><input type="radio" disabled="" /> In Bank  <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="Add a bank account in My Bank Account" aria-hidden="true"></i></label>

						        @endif

						        @endif

						        <div class="alert alert-info">
						                <h5><i class="fa fa-info-circle"></i> Important !</h5>

						                <ol class="ol">
						                  <li>IF Original source is choosen than amount will be reflected to your orignal source in 1-2 days(approx).
						                  </li>

						                  <li>
						                    IF Bank Method is choosen than make sure you added a bank account else refund will not procced. IF already added than it will take 14 days to reflect amount in your bank account (Working Days*).
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

					@endforeach
				</div>
			
			

			<div class="quickorderview col-md-4">
				
				
				
			</div>
			
					

		</div>

		@else
			<h3 class="text-center">No Pending Orders !</h3>
		@endif



@endsection
@section('custom-script')
<script>
	var url = {!!json_encode( route('quickorderdtls') )!!};
</script>
<script src="{{asset('js/pendingorder.js')}}"></script>
@endsection