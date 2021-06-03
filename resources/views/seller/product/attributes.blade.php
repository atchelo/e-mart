@extends('admindesk.layouts.sellermaster')
@section('title','Available Product Attributes | ')
@section('body')
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title">Available Product Attributes</div>
		</div>
		<div class="box-body">
			
				<table id="full_detail_table" class="width100 table table-borderd table-responsive">
				<thead>
					<th>#</th>
					<th>Options</th>
					<th>Values</th>
					<th>In Categories</th>
					
				</thead>
				<?php $i=0;?>
				<tbody>
					@foreach($pattr as $pat)
					<?php $i++;?>
						<tr>
							<td>{{ $i }}</td>
							<td>
								<b>

								  	@php
			                      	    $k = '_'; 
			                        @endphp

			                        @if (strpos($pat->attr_name, $k) == false)
			                        
			                          {{ $pat->attr_name }}
			                           
			                        @else
			                          
			                          {{str_replace('_', ' ',$pat->attr_name)}}
			                          
			                        @endif
			                        
			                        </b>
							</td>
							<td width="60%">
								@foreach($pat->provalues->all() as $t)
									@if(strcasecmp($t->unit_value, $t->values) !=0)
									@if($pat->attr_name == "Color" || $pat->attr_name == "Colour")
									

									<div class="margin-top-15 display-flex">
                                          <div class="color-options">
                                            <ul>
                                               <li title="{{ $t->values }}" class="color varcolor active"><a href="#" title=""><i style="color: {{ $t->unit_value }}" class="fa fa-circle"></i></a>
                                                      <div class="overlay-image overlay-deactive">
                                                      </div>
                                                </li>
                                            </ul>
                                          </div>
                                       </div>
                                		<span class="tx-color">{{ $t->values }}</span>
									@else
										{{ $t->values }}{{ $t->unit_value }},
									@endif
									@else

										{{ $t->values }},
										
									@endif
								@endforeach
								
							</td>
							<td>
								@foreach($pat->cats_id as $cats)
								 @php
								 	$getcatname = App\Category::where('id',$cats)->first()->title;
								 @endphp
									{{$getcatname}},
								@endforeach
							</td>
							

							
						</tr>
					@endforeach
				</tbody>
			</table>
			

		</div>
	</div>
@endsection