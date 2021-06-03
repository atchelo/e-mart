@extends('admindesk.layouts.master')
@section('title','Payout Detail | ')
@section('body')
	<div class="box">
		<div class="box-header with-border">
			<a href="{{ route('seller.payouts.index') }}" title="Go back" class="btn btn-flat btn-default"><i class="fa fa-reply"></i></a>
			
			<div class="box-title">
				Order Payment Details
			</div>


		</div>

		<div class="box-body">
			
  
   
    <!-- Main content -->
    <section class="invoice2">
      <!-- title row -->
        <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Payout Slip for Order Item #{{ $inv_cus->prefix.$order->singleorder->inv_no.$inv_cus->postfix }}
            <small class="pull-right">Date: {{ date('d/m/Y',strtotime($order->created_at)) }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
         <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>{{ $genrals_settings->project_name }}</strong><br>
            {{ $genrals_settings->address }}<br>
          
            Phone: {{ $genrals_settings->mobile }}<br>
            Email: {{ $genrals_settings->email }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">


							@php
								
                $seller = App\User::findorfail($order->sellerid);
   
							@endphp
          To
          <address>
            <strong><b>{{$seller->name}}</b></strong><br>
            {{ $seller->store->address }}<br>
             {{ $seller->store->city['name'] }},  {{ $seller->store->state['name'] }},  {{ $seller->store->country['nicename'] }}<br>
            Phone: @if(isset($seller->mobile)){{$seller->mobile}}@endif
            <br>
            Email: {{ $seller->email }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #{{ $inv_cus->prefix.$order->singleorder->inv_no.$inv_cus->postfix }}</b>
          <br>
          <b>Order ID:</b> #{{ $inv_cus->order_prefix.$order->singleorder->order->order_id }}<br>
          <b>Payment Due</b>
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>Item</th>
              <th>Qty</th>
              <th>Delivered at</th>
              <th>Grand Total</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td><img height="50px" src="{{url('variantimages/thumbnails/'.$order->singleorder->variant->variantimages['main_image'])}}" alt=""/></td>
              <td><a><b>{{$order->singleorder->variant->products->name}}</b>

			                <small>
			                	@php
			                		$i=0;
			                		$varcount = count($order->singleorder->variant->main_attr_value);
			                	@endphp
			                (@foreach($order->singleorder->variant->main_attr_value as $key=> $orivars)
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
			                 <small><b>Sold By:</b>  {{$order->singleorder->variant->products->store->name}}</small></td>
              <td>{{$order->qty}}</td>
              <td>{{ date('d-M-Y | h:iA',strtotime($order->singleorder->updated_at)) }}</td>
                
               <td>{{ $order->paid_in.' '.sprintf("%.2f",$order->orderamount) }}</td>
            </tr>
            
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Methods:</p>
          
          
          <img src="{{ url('images/paypal.png') }}" alt="Paypal">
          <img width="50px" src="{{ url('images/bankt.png') }}" alt="bank_transfer" title="Bank Transfer">
			<hr>
          <div class="callout callout-success no-shadow">
          	<h5><i class="fa fa-info-circle"></i> Note:</h5>
          	@if($order->singleorder->order->handlingcharge ==0)
            @if($order->singleorder->order->payment_method !='COD')
	            	<li>Handling fee {{ $order->paid_in }} {{ sprintf("%.2f",$order->singleorder->order->handlingcharge) }} already paid out in your account
	            	</li>
            @endif
            	@endif
            	<li>Paypal payout fee additionally applied by Paypal at Transcation time</li>
            	<li>Please refer to this for payout fees for following payment gatways:
					<ul>
						<li><a title="Click to open" target="_blank" href="https://developer.paypal.com/docs/payouts/reference/fees/">Paypal Payouts</a></li>
									
					</ul>
            	</li>

          </div>
            
          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
         
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th class="width50">Subtotal:</th>
                <td>+{{  sprintf("%.2f", $order->subtotal) }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i>
                  <br>
                  <small>({{__("Gift charge inluded if any")}})</small>
                </td>
              </tr>
              
              <tr>
                <th>Tax </th>
                <td>+ {{ sprintf("%.2f",$order->tax) }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i></td>
              </tr>

              <tr>
                <th>Shipping </th>
                <td>+ {{ sprintf("%.2f",$order->shipping) }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i></td>
              </tr>

              <tr>
                <th>Total </th>
                <td>+ {{ sprintf("%.2f",$order->orderamount) }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i></td>
              </tr>

              <tr>
                <th>Commission:</th>
                <td>- @php
                                $commissions = App\CommissionSetting::all();
                                $commissionRate = 0;
                                  foreach ($commissions as $commission)
                                  {
                                      if ($commission->type == "flat")
                                      {
                                          if ($commission->p_type == "f")
                                          {

                                              $price = $order->singleorder->variant->products->vender_price + $commission->rate;
                                              $offer = $order->singleorder->variant->products->vender_offer_price + $commission->rate;
                                              $sellPrice = $price;
                                              $sellofferPrice = $offer;
                                              $cursym = $defCurrency->currency_symbol;
                                              echo "$commissionRate = $commission->rate <i class='cur_sym fa $cursym'></i>";

                                          }
                                          else
                                          {

                                              $taxrate = $commission->rate;
                                              $price1 = $order->singleorder->variant->products->vender_price;
                                              $price2 = $order->singleorder->variant->products->vender_offer_price;
                                              $tax1 = ($price1 * (($taxrate / 100)));
                                              $tax2 = ($price2 * (($taxrate / 100)));
                                              $sellPrice = $price1 + $tax1;
                                              $sellofferPrice = $price2 + $tax2;
                                              $cursym = $defCurrency->currency_symbol;

                                              if (!empty($tax2))
                                              {
                                                  $commissionRate = $tax2;
                                                  echo sprintf("%.2f",$commissionRate)." <i class='cur_sym fa $cursym'></i>";
                                              }
                                              else
                                              {
                                                  $commissionRate = $tax1;
                                                  echo sprintf("%.2f",$commissionRate)." <i class='cur_sym fa $cursym'></i>";
                                              }
                                          }
                                      }
                                      else
                                      {
                                          $cursym = $defCurrency->currency_symbol;
                                          $comm = App\Commission::where('category_id', $order->singleorder->variant->products->category_id)
                                              ->first();
                                          if (isset($comm))
                                          {
                                              if ($comm->type == 'f')
                                              {

                                                  $price = $order->singleorder->variant->products->vender_price + $comm->rate;
                                                  $offer = $order->singleorder->variant->products->vender_offer_price + $comm->rate;
                                                  $sellPrice = $price;
                                                  $sellofferPrice = $offer;
                                                  $commissionRate = $comm->rate;
                                                  echo sprintf("%.2f",$commissionRate)."<i class='cur_sym fa $cursym'></i>";

                                              }
                                              else
                                              {
                                                  $taxrate = $comm->rate;
                                                  $price1 = $order->singleorder->variant->products->vender_price;
                                                  $price2 = $order->singleorder->variant->products->vender_offer_price;
                                                  $tax1 =   ($price1 * (($taxrate / 100)));
                                                  $tax2 = ($price2 * (($taxrate / 100)));
                                                  $price = $price1 + $tax1;
                                                  $offer = $price2 + $tax2;
                                                  $sellPrice = $price;
                                                  $sellofferPrice = $offer;

                                                  if (!empty($tax2))
                                                  {
                                                      $commissionRate = $tax2;
                                                      echo sprintf("%.2f",$commissionRate)."<i class='cur_sym fa $cursym'></i>";
                                                  }
                                                  else
                                                  {
                                                      $commissionRate = $tax1;
                                                      echo sprintf("%.2f",$commissionRate)."<i class='cur_sym fa $cursym'></i>";
                                                  }
                                              }
                                          }
                                      }

                                  }
                                  /**/
                              @endphp </td>
              </tr>
              <tr>
                <th>Payable Amount:</th>
                @php
                  
                  
                  $total = round(($order->orderamount)-$commissionRate,2);
                @endphp
                <td>{{ $total }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <div class="row">
            <div class="left-15 col-md-1">
              <form action="{{ route('seller.pay',['venderid' => $order->sellerid, 'orderid' => $order->id ]) }}" method="POST">
                      @csrf
                      @php
                        
                        $amount = Crypt::encrypt(round($order->orderamount-$commissionRate,2));
                      @endphp
                      <input type="hidden" name="amount" value="{{ $amount }}">
                      <button title="Click to pay via Paypal" class="btn btn-flat btn-md bg-blue"><i class="fa fa-cc-paypal" aria-hidden="true"></i> {{ sprintf("%.2f",$order->orderamount-$commissionRate) }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i></button>
              </form>
            </div>
            <div class="left-15 col-md-1">
               
                <button type="button" data-toggle="modal" data-target="#bank_transfer" title="Pay via bank transfer" class="btn btn-flat btn-md bg-red"><i class="fa fa-university" aria-hidden="true"></i> {{ sprintf("%.2f",$order->orderamount-$commissionRate) }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i></button>
              
            </div>
            <div class="left-15 col-md-1">
              <button data-toggle="modal" data-target="#manualtransfer" class="btn btn-md btn-flat bg-navy"><i class="fa fa-circle-o"></i> Manual Transfer</button>
            </div>
          </div>
         
        
         

        </div>
      </div>
    </section>
    
    <!-- Bank Transfer Modal -->
      <div data-keyboard='false' data-backdrop='false' class="modal fade" id="bank_transfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Pay via bank transfer method</h4>
            </div>
            <div class="modal-body">
                
               <div class="row">
                 <div class="col-md-6">
                    <div class="card card-1">
                      <div class="user-header">
                        <h5>Bank Account Detail</h5>
                      </div>
                      <div class="wel">
                        <b>Account Name:</b> {{ $seller->store->account_name }} <br>
                        <b>Account No:</b> {{ $seller->store->account }} <br>
                        <b>IFSC Code:</b> {{ $seller->store->ifsc }} <br>
                        <b>Bank Name:</b> {{ $seller->store->bank_name }} <br>
                        <b>Branch:</b> {{ $seller->store->branch }} <br>
                      </div>
                    </div>
                 </div>
                <form action="{{ route('payout.bank',['venderid' => $order->sellerid, 'orderid' => $order->id ]) }}" method="POST">
                  @csrf
                  <input type="hidden" name="acno" value="{{ $seller->store->account }}">
                  <input type="hidden" name="ifsccode" value="{{ $seller->store->ifsc }}">
                  <input type="hidden" name="bankname" value="{{ $seller->store->bank_name }}">
                  <input type="hidden" name="acholder" value="{{ $seller->store->account_name }}">
                 <div class="col-md-6">
                    <div class="form-group">
                       <label for="">Transfer Method: <span class="required">*</span></label>
                        <select required="" name="transfer_type" id="" class="form-control">
                            <option value="IMPS">IMPS</option>
                            <option value="NEFT">NEFT</option>
                            <option value="RTGS">RTGS</option>
                        </select>
                    </div>

                    <div class="form-group">
                       <div class="form-group">
                         <label for="">Transfer Fee: (If applied) </label>
                         <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-minus" aria-hidden="true"></i></span>
                            <input id="txn_fee" placeholder="0.00" class="form-control" type="number" step="0.1" name="txn_fee" value="0.00">
                        </div>
                       </div>
                    </div>

                    <div class="form-group">
                        
                        <label for="">Amount:</label>
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1"><i class="{{ $defCurrency->currency_symbol }}"></i></span>
                          <input id="actualamount" type="number" class="form-control" value="{{ sprintf("%.2f",$order->orderamount-$commissionRate) }}" name="amount" step="0.01">
                        </div>
                        
                    </div>

                 </div>
               </div>

            </div>
            <div class="modal-footer">
               <button type="submit" class="btn bg-olive btn-flat">Pay <span id="amounttotal">{{ sprintf("%.2f",$order->orderamount-$commissionRate) }}</span> <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i></button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
              

          </div>
        </div>
      </div>

      <!-- Manual Transfer Modal -->
      <div data-keyboard='false' data-backdrop='false' class="modal fade" id="manualtransfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Saving Record for Manual Transfer.</h4>
            </div>
            <div class="modal-body">
                
               <div class="row">
                 
                <form action="{{ route('manual.seller.payout',['venderid' => $order->sellerid, 'orderid' => $order->id ]) }}" method="POST">
                  @csrf
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Paid via: <small class="help-block">(eg. Paytm,Paypal,RazarPay etc.)</small></label>
                      <input type="text" class="form-control" name="paidvia">
                      
                    </div> 

                    <div class="form-group">
                      <label>Transcation ID:</label>
                      <input required type="text" class="form-control" name="txn_id">
                    </div> 

                  </div>
                  
                 <div class="col-md-6">
                  

                    <div class="form-group">
                       <div class="form-group">
                         <label for="">Transfer Fee: <small class="help-block">(If applied)</small> </label>
                         <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-minus" aria-hidden="true"></i></span>
                            <input id="txn_fee2" placeholder="0.00" class="form-control" type="number" step="0.1" name="txn_fee" value="0.00">
                            <span class="input-group-addon" id="basic-addon1"><i class="{{ $defCurrency->currency_symbol }}"></i></span>
                        </div>
                       </div>
                    </div>

                    <div class="form-group">
                        
                        <label for="">Paid Amount:</label>
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1"><i class="{{ $defCurrency->currency_symbol }}"></i></span>
                          <input id="actualamount2" type="number" class="form-control" value="{{ sprintf("%.2f",$order->orderamount-$commissionRate) }}" name="amount" step="0.01">
                        </div>
                        
                    </div>

                 </div>
               </div>
              <label><input required type="checkbox" name="alreadypaid"> By Saving The Record you here by declare that payment has already done to the seller.</label>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn bg-olive btn-flat">Save Record</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
              

          </div>
        </div>
      </div>

    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
		
	</div>
@endsection
@section('custom-script')
<script>
  var oldamountsent = {!! json_encode( sprintf("%.2f",$order->orderamount-$commissionRate) ) !!};
</script>
<script src="{{ url('js/paydetail.js') }}"></script>
@endsection