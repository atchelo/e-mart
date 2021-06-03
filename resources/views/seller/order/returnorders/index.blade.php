@extends('admindesk.layouts.sellermaster')
@section('title','Returned Orders |')
@section('body')
	<div class="box" >
		<div class="box-header with-border">
			<div class="box-title">
				Retured Orders
			</div>
		</div>

		<div class="box-body">
			<div class="nav-tabs-custom">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" id="ordertabs" role="tablist">

				  	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Return Completed @if($countC>0) <span class="badge">{{$countC}}</span> @endif</a></li> 
				    <li role="presentation" ><a href="#pendingReturn" aria-controls="home" role="tab" data-toggle="tab">Pending Returns @if($countP>0) <span class="badge">{{$countP}}</span>@endif</a></li>
				     
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="home">
				    	<br>
						<table id="full_detail_table2" class="table table-striped width100">
							<thead>
								
								<th>
									#
								</th>
								<th>
									Order ID
								</th>
								<th>
									Item
								</th>
								<th>
									Refunded Amount
								</th>
								<th>
									Refund Status
								</th>

							</thead>
							
							<tbody>
								@foreach($sellerorders as $key=> $order)
									
									@if($order->status != 'initiated')
									@if(isset($order->getorder->order))
									<tr>
										<td>
											{{ $key+1 }}
										</td>
										<td><b>#{{ $inv_cus->order_prefix.$order->getorder->order->order_id }}</b>
												<br>
												<small>
													<a title="View Refund Detail" href="{{  route('seller.order.detail',$order->id)  }}">View Detail</a> 
												</small>
										</td>
										<td>
											@php
												$findvar = App\AddSubVariant::withTrashed()->findorfail($order->getorder->variant_id);


												$varcount = count($findvar->main_attr_value);
												$i=0;
				                      			$var_name_count = count($findvar['main_attr_id']);
			                      				unset($name);
						                      	$name = array();
						                      	$var_name;

					                            $newarr = array();
					                            for($i = 0; $i<$var_name_count; $i++){
					                              $var_id =$findvar['main_attr_id'][$i];
					                              $var_name[$i] = $findvar['main_attr_value'][$var_id];
					                               
					                                $name[$i] = App\ProductAttributes::where('id',$var_id)->first();
					                                
					                            }


					                          try{
					                            $url = url(url('details').'/').'/'.$findvar->products->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
					                          }catch(Exception $e)
					                          {
					                            $url = url(url('details').'/').'/'.$findvar->products->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
					                          }

			                  				@endphp

											

											<b><a target="_blank" title="{{ $findvar->products->name }} (@php
											
					 
											 $varcount = count($findvar->main_attr_value);
								    		 $var_main;
								    		 $i=0;
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
								            @endphp)" href="{{ $url }}">{{substr($findvar->products->name, 0, 25)}}{{strlen($findvar->products->name)>25 ? '...' : ""}}
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
								            @endphp)</a></b>	
										</td>
										<td>
											<i class="{{ $order->getorder->order->paid_in }}"></i>{{ $order->amount }}
										</td>
										<td>
											<label class="label label-success">
												{{ ucfirst($order->status) }}
											</label>
										</td>
									</tr>
									@endif
							
									@endif	
									
								@endforeach
								
							</tbody>

						</table>

				    </div>
				    <div role="tabpanel" class="tab-pane" id="pendingReturn">
				    	<br>
						<table id="full_detail_table" class="table table-striped width100">
							<thead>
								<th>
									#
								</th>
								<th>
									Order TYPE
								</th>
								<th>
									OrderID
								</th>
								<th>
									Pending Amount
								</th>
								<th>
									Requested By
								</th>
								<th>
									Requested on
								</th>
								
							</thead>

							<tbody>
								@foreach($sellerorders as $key=> $order)
									@if(isset($order->getorder->order) && $order->status == 'initiated')
										<tr>
											<td>{{ $key+1 }}</td>
											<td>
												@if($order->getorder->order->payment_method != 'COD')
													<label for="" class="label label-success">
														PREPAID
													</label>
												@else
													<label for="" class="label label-primary">
														COD
													</label>
												@endif
											</td>
											<td><b>#{{ $inv_cus->order_prefix.$order->getorder->order->order_id }}</b>
												<br>
												<small>
													<a title="Click to view" href="{{ route('seller.return.order.show',$order->id) }}">View Order</a>
												</small>
											</td>
											<td>
												<i class="{{ $order->getorder->order->paid_in }}"></i>{{ $order->amount }}
											</td>
											<td>
												{{ $order->user->name }}
											</td>
											<td>
												{{date('d-M-Y @ h:i A',strtotime($order->created_at))}}
											</td>
											
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
				    </div>
				  </div>

			</div>
		</div>
	</div>
@endsection