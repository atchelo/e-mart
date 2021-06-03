@extends('admindesk.layouts.sellermaster')
@section('title',"View $pro->name's All Variants - ")
@section('body')
	

	<div class="box box-primary">
		

		
		<div class="box-header with-border">
			<div class="box-title">
					
				<a title="Go back to all products" href="{{ route('my.products.index') }}" class="btn btn-sm btn-default"><i class="fa fa-reply" aria-hidden="true"></i></a> {{$pro->name}}'s Variant

				@php
					$getstorename = App\Store::where('id',$pro->store_id)->first()->name;
				@endphp
				<small>Sold by : {{ $getstorename }}</small>
				<br>
				<br>
				@php
				 $getcatname = App\Category::where('id',$pro->category_id)->first()->title;
				 $getsubcatname = App\Subcategory::where('id',$pro->child)->first()->title;
				 if(isset($pro->grand_id) && $pro->grand_id != 0){
				 	$getchildaname = App\Grandcategory::where('id',$pro->grand_id)->first();
				 }
				 
				@endphp

				<small>In: <span class="font-weight">{{ $getcatname }}</b> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
			 <span class="font-weight">{{ $getsubcatname }}</span> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
			@if(isset($pro->grand_id) && $pro->grand_id != 0) {{ $getchildaname->title }} @endif</small>

			</div>
		</div>

		<div class="box-body">
			
		

			<table class="width100" class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Variant Detail</th>
						<th>Pricing Details</th>
						<th>Added / Updated On</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach($pro->subvariants as $key=> $sub)
					<tr>
						<td class="align-middle">{{ $key+1 }}</td>
						<td class="align-middle">
							<div class="row">
								<div class="col-md-3">
									
									@if(count($pro->subvariants)>0)
										
		                                @if(isset($sub->variantimages['image2']))
		                                  
		                                  <img class="pro-img ximg2" title="{{ $pro->name }}" src="{{ url('variantimages/thumbnails/'.$sub->variantimages['main_image']) }}" alt="{{ $sub->variantimages['main_image'] }}">
		                                
		                                
		                              @endif
									@else
									<img class="ximg2 height-50" src="{{ asset('images/no-image.png') }}" alt="no-image.png">
									@endif
								</div>

								<div class="col-md-offset-1 col-md-6">
									<p><b>Variant Name:</b> {{ $pro->name }} 
										(@foreach($sub->main_attr_value as $k => $getvar)

										{{-- Getting Attribute Names --}}
										@php 
											$getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name
										@endphp
										{{-- Getting Attribute Values --}}
										
										
										@php 
											$getvalname = App\ProductValues::where('id',$getvar)->first();
										@endphp
										
										@if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=0 && $getvalname->unit_value != null )

											@if($getvalname->proattr->attr_name == "Color" || $getvalname->proattr->attr_name == "Colour" || $getvalname->proattr->attr_name == "color" || $getvalname->proattr->attr_name == "colour")
                                {{ $getvalname['values'] }}
                                @else
                                  {{ $getvalname['values'] }}{{ $getvalname->unit_value }},
                                  @endif
											

											@else
												{{ $getvalname['values']}},
											@endif
										@endforeach)
									</p>
							
									

									<p><b>Additional Price: </b> {{ $sub->price }}</p>
									<p><b>Min Qty. For Order:</b> {{ $sub->min_order_qty }}</p>

									<p><b>Stock :</b> {{ $sub->stock }} | <b>Max Qty. For Order:</b> {{ $sub->max_order_qty }}</p>
								</div>

							</div>
							
							
							
						</td>
						<td class="align-middle">
						
							@if($pro->vender_offer_price !=null)
							<p>Discounted Price : <b>{{ $pro->offer_price }}</b></p>
							<p>Selling Price : <b>{{ $pro->price }}</b></p>
							@else
							<p>Selling Price : <b>{{ $pro->price }}</b></p>
							@endif

							<p>(<b>Incl. Admin Commission in this rate</b>)</p>
						</td>

<td>
                            <p> <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> 
                              <span class="font-weight500">{{ date('M jS Y',strtotime($sub->created_at)) }},</span></p>
                            <p ><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="font-weight500">{{ date('h:i A',strtotime($sub->created_at)) }}</span></p>
                            
                            <p class="border-grey"></p>
                            
                            <p>
                               <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 
                               <span class="font-weight500">{{ date('M jS Y',strtotime($sub->updated_at)) }}</span>
                            </p>
                           
                            <p><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="font-weight500">{{ date('h:i A',strtotime($sub->updated_at)) }}</span></p>
                            
                         </td>

						<td class="align-middle">
							
							 @php 
                                      $var_name_count = count($sub['main_attr_id']);
                                     
	                                      $name;
	                                    $var_name;
	                                       $newarr = array();
                                      for($i = 0; $i<$var_name_count; $i++){
                                        $var_id =$sub['main_attr_id'][$i];
                                        $var_name[$i] = $sub['main_attr_value'][$var_id];
                                          
                                          $name[$i] = App\ProductAttributes::where('id',$var_id)->first();
                                          
                                      }


                                    try{
                                      $url = url('/details/').'/'.$pro->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                                    }catch(Exception $e)
                                    {
                                      $url = url('/details/').'/'.$pro->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                                    }

                                 @endphp

                                 <a target="_blank" title="View Variant" href="{{ $url }}" class="btn btn-sm btn-default">
								<i class="fa fa-eye"></i>
									</a>

                                
							

							<a href="{{ route('seller.edit.var',$sub->id) }}" class="btn btn-sm btn-primary">
								<i class="fa fa-pencil"></i>
							</a>
							
							<a data-toggle="modal" href="#deletevar{{ $sub->id }}" class="btn btn-sm btn-danger">
								<i class="fa fa-trash-o"></i>
							</a>
						</td>

						
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	@foreach($pro->subvariants as $key=> $sub)
	<div id="deletevar{{ $sub->id }}" class="delete-modal modal fade" role="dialog">
					        <div class="modal-dialog modal-sm">
					          <!-- Modal content-->
					          <div class="modal-content">
					            <div class="modal-header">
					              <button type="button" class="close" data-dismiss="modal">&times;</button>
					              <div class="delete-icon"></div>
					            </div>
					            <div class="modal-body text-center">
					              <h4 class="modal-heading">Are You Sure ?</h4>
					              <p>Do you really want to delete this variant? This process cannot be undone.</p>
					            </div>
					            <div class="modal-footer">
					               <form method="post" action="{{ route('del.var',$sub->id) }}" class="pull-right">
					                             {{csrf_field()}}
					                             {{method_field("DELETE")}}
					                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
					                <button type="submit" class="btn btn-danger">Yes</button>
					              </form>
					            </div>
					          </div>
					        </div>
					    </div>
	@endforeach
@endsection
