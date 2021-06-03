@extends("admindesk.layouts.sellermaster")
@section('title','Add Product Attributes -')
@section("body")


<div class="box">
	<div class="box-header with-border">
		<div class="box-title">
			<a title="Go back" href="{{ url('seller/products') }}" class="btn btn-sm btn-default"><i class="fa fa-reply"
					aria-hidden="true"></i></a> {{$findpro->name}}'s Variant
		</div>
	</div>


	<div class="box-body">

		<div class="callout callout-success">
			<i class="fa fa-info-circle"></i> <i>Quick Guide</i>
			<ul>
				<li>Common variant not work until you don't Link a variant.</li>
				<li>Before Link a variant click on <b>Add Variant Option</b> (You can add up to <u>2</u> variant
					option).</li>
				<li>After Link Variant option You can create unlimited variant from that options.</li>
				<li>After Add a default variant you can create unlimited common variants.</li>
			</ul>
		</div>

		<div>
			<div class="nav-tabs-custom">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist" id="myTab">
					<li role="presentation" class="active"><a href="#cmn" aria-controls="cmn" role="tab"
							data-toggle="tab">Add Common Variant</a>
					</li>
					<li role="presentation" class=""><a href="#home" aria-controls="home" role="tab"
							data-toggle="tab">Add Variant Option</a></li>
					<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Link
							Variant</a>
					</li>

				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="cmn">

						<br>
						<div class="box box-danger">
							<div class="box-header with-border">
								<div class="box-title">
									Add Common Product Variant For <b>{{ $findpro->name }}</b>
								</div>

								<a @if(env('DEMO_LOCK')==0) data-toggle="modal" href="#cmModal" @else disabled
									title="This action is disabled in demo !" @endif
									class="margin-right-8 pull-right btn btn-md btn-primary">
									<i class="fa fa-plus"></i> ADD Common Variant
								</a>
							</div>

							<div class="box-body">
								<table id="full_detail_table" class="width100 table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Variant Name</th>
											<th>Variant Value</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										@foreach($findpro->commonvars as $key=> $commonvariant)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>
												@php
												$nameofattr = App\ProductAttributes::where('id','=',$commonvariant->cm_attr_id)->first()->attr_name;
												@endphp
												@php
												$key = '_';
												@endphp
												@if (strpos($nameofattr, $key) == false)

												{{ $nameofattr }}

												@else

												{{str_replace('_', ' ', $nameofattr)}}

												@endif
											</td>
											<td>

												@php
												$nameofval = App\ProductValues::where('id','=',$commonvariant->cm_attr_val)->first();
												@endphp

												@if($nameofattr == "Color" || $nameofattr == "Colour" || $nameofattr == 'color' || $nameofattr == 'colour')

													<div class="inline-flex margin-left-minus-15">
														<div class="color-options">
															<ul>
																<li title="{{ $nameofval->values }}"
																	class="color varcolor active"><a href="#" title=""><i
																			style="color: {{ $nameofval->unit_value }}"
																			class="fa fa-circle"></i></a>
																	<div class="overlay-image overlay-deactive">
																	</div>
																</li>
															</ul>
														</div>
													</div>
													<span class="tx-color">{{ $nameofval->values }}</span>

												@else



												@if($nameofval->unit_value != null && strcasecmp($nameofval->unit_value,
												$nameofval->values) != 0)
												{{ $nameofval->values }}{{ $nameofval->unit_value }}
												@else
												{{ $nameofval->values }}
												@endif

												@endif

											</td>
											<td>
												<a data-target="#editcm{{ $commonvariant->id }}"
													class="btn btn-sm btn-primary" data-toggle="modal">
													<i class="fa fa-pencil"></i>
												</a>

												<a @if(env('DEMO_LOCK')==0) data-target="#cmdel{{ $commonvariant->id }}"
													@else disabled title="This action is disabled in demo !" @endif
													class="btn btn-sm btn-danger" data-toggle="modal">
													<i class="fa fa-trash-o"></i>
												</a>
											</td>


										</tr>
										@endforeach
									</tbody>
								</table>
							</div>

						</div>


					</div>
					<div role="tabpanel" class="tab-pane fade" id="home">
						<br>
						<div class="box box-danger">
							<div class="box-header with-border">
								<div class="box-title">
									Add Product Attributes For <b>{{ $findpro->name }}</b>
								</div>



								<a data-toggle="modal" href="#optionModal" class="pull-right btn btn-md btn-primary">
									<i class="fa fa-plus"></i> ADD Option
								</a>


							</div>

							<div class="box-body">
								<table id="full_detail_table" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Option Names</th>
											<th>Option Value</th>
											<th>Action</th>
										</tr>
									</thead>
									<?php $i=0;?>
									<tbody>
										@foreach($getopts as $opt)
										<?php $i++; ?>
										<tr>
											<td>{{ $i }}</td>
											<td>
												<b>
													@php
													$key = '_';
													@endphp
													@if (strpos($opt->getattrname->attr_name, $key) == false)

													{{ $opt->getattrname->attr_name }}

													@else

													{{str_replace('_', ' ', $opt->getattrname->attr_name)}}

													@endif
												</b>
											</td>
											<td>

												@foreach($opt->attr_value as $value)

												@php
												$originalvalue = App\ProductValues::where('id',$value)->get();
												@endphp

												@foreach($originalvalue as $value)
												@if($value->unit_value !=null && strcasecmp($value->unit_value,
												$value->values) != 0)

												@if($value->proattr->attr_name == "Color" || $value->proattr->attr_name
												== "Colour")

												<div class="inline-flex margin-left-minus-15">
													<div class="color-options">
														<ul>
															<li title="{{ $value->values }}"
																class="color varcolor active"><a href="#" title=""><i
																		style="color: {{ $value->unit_value }}"
																		class="fa fa-circle"></i></a>
																<div class="overlay-image overlay-deactive">
																</div>
															</li>
														</ul>
													</div>
												</div>
												<span class="tx-color">{{ $value->values }}</span>

												@else
												{{$value->values}}{{ $value->unit_value }},
												@endif


												@else
												{{$value->values}},
												@endif
												@endforeach
												@endforeach


											</td>

											<td>
												<button data-toggle="modal" href="#edit{{ $opt->id }}"
													class="btn btn-sm btn-primary">
													<i class="fa fa-pencil"></i>
												</button>

												<button @if(env('DEMO_LOCK')==0) data-toggle="modal"
													href="#{{ $opt->id }}var" @else disabled="" @endif
													class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i>
												</button>
											</td>


										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

					</div>
					<div role="tabpanel" class="tab-pane" id="profile">
						<br>
						<div class="box box-danger">
							<div class="box-header with-border">
								<div class="box-title">
									Link Variant For <b>{{ $findpro->name }}</b>
								</div>

								<a class="btn btn-md btn-primary pull-right"
									href="{{ route('seller.manage.stock',$findpro->id) }}">+ ADD
								</a>
							</div>

							<div class="box-body">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Additional Detail</th>
											<th>Default</th>
											<th>Action</th>
										</tr>
									</thead>

									@foreach($findpro->subvariants as $key=> $sub)
									<tr>

										<td>

											{{$key+1}}
										</td>
										<td>@foreach($sub->main_attr_value as $key=> $originalvalue)
											@if($originalvalue != 0)
											@php
											$getattrname = App\ProductAttributes::where('id',$key)->first();
											@endphp

											@php
											$getattrval = App\ProductValues::where('id',$originalvalue)->first();
											@endphp

											<b>
												@php
												$key = '_';
												@endphp
												@if (strpos($getattrname->attr_name, $key) == false)

												{{ $getattrname->attr_name }}

												@else

												{{str_replace('_', ' ', $getattrname->attr_name)}}

												@endif
											</b> :

											@if(strcasecmp($getattrval->unit_value, $getattrval->values) !=0)

											@if($getattrname->attr_name == "Color" || $getattrname->attr_name ==
											"Colour")


											<div class="margin-left-minus-15 inline-flex">
												<div class="color-options">
													<ul>
														<li title="{{ $getattrval->values }}"
															class="color varcolor active"><a href="#" title=""><i
																	style="color: {{ $getattrval->unit_value }}"
																	class="fa fa-circle"></i></a>
															<div class="overlay-image overlay-deactive">
															</div>
														</li>
													</ul>
												</div>
											</div>
											<span class="tx-color">{{ $getattrval->values }}</span>

											@else
											{{ $getattrval->values }}{{ $getattrval->unit_value }},
											@endif

											@else
											{{ $getattrval->values }}
											@endif

											<br>
											@else
											@php
											$getattrname = App\ProductAttributes::where('id',$key)->first();
											@endphp
											<b>{{ $getattrname->attr_name }}</b> :
											Not Available
											<br>
											@endif
											@endforeach
										</td>

										<td>
											<p><b>Price:</b> {{ $sub->price }}</p>
											<p><b>Stock:</b> {{ $sub->stock }}</p>
											<p><b>Weight:</b> {{ $sub->weight }}{{ $sub->unitname->short_code ?? '' }}</p>
											<p><b>Min Order Qty:</b>{{ $sub->min_order_qty }}</p>
											<p><b>Min Order Qty:</b>{{ $sub->max_order_qty }}</p>
										</td>
										<td class="v-middle custom-radios">

											<input name="def" class="setdefButton cmn" data-proid="{{ $findpro->id }}"
												id="{{ $sub->id }}" type="radio" {{ $sub->def==1 ? "checked" : "" }}>


											<label for="{{ $sub->id }}">
												<span>
													<img class="align-unset"
														src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg"
														alt="Checked Icon" />
												</span>
											</label>

										</td>
										<td class="v-middle">
											<a title="Edit variant" href="{{ route('seller.edit.var',$sub->id) }}"
												class="btn btn-md btn-sm btn-primary">
												<i class="fa fa-pencil"></i>
											</a>

											<a @if(env('DEMO_LOCK')==0) data-toggle="modal"
												href="#deletevar{{ $sub->id }}" @else
												title="This action is disabled in demo !" disabled @endif
												class="btn btn-sm btn-danger">
												<i class="fa fa-trash-o"></i>
											</a>
										</td>


									</tr>
									@endforeach
								</table>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
</div>

@foreach($findpro->commonvars as $key=> $commonvariant)
<!--Edit Modal -->
<div class="modal fade" id="editcm{{ $commonvariant->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit {{ $nameofattr }}</h4>
			</div>

			<div class="modal-body">
				<form action="{{ route('common.update',$commonvariant->id) }}" method="POST">
					@csrf
					<label for="">Edit Options:</label>
					<p></p>
					@foreach($commonvariant->attribute->provalues as $attrval)
					
						@php
						
							$nameofattr = App\ProductAttributes::where('id','=',$commonvariant->cm_attr_id)->first()->attr_name;
							$key = '_';

						@endphp

					@if (strpos($nameofattr, $key) == false)

						@php
							$nameofattr = $nameofattr;
						@endphp

					@else

						@php

						$nameofattr = 	str_replace('_', ' ', $nameofattr);
							
						@endphp
				

					@endif

					@if($nameofattr== 'Color' ||  $nameofattr == 'color' || $nameofattr == 'Colour' || $nameofattr == 'colour')
					<div class="inline-flex">
						
						<label><input {{ $commonvariant->cm_attr_val == $attrval->id ? "checked" : "" }} required class="margin-left-8" type="radio" name="cm_attr_val" value="{{ $attrval->id }}"><div class="inline-flex"><div class="color-options"><ul><li title="{{ $attrval->values }}" class="color varcolor active"><a href="#" title="{{ $attrval->values }}"><i style="color:{{ $attrval->unit_value }}" class="fa fa-circle"></i></a><div class="overlay-image overlay-deactive"></div></li></ul></div></div><span class="tx-color">{{ $attrval->values }}</span></label>

					</div>
					@else

					<label>
						<input {{ $commonvariant->cm_attr_val == $attrval->id ? "checked" : "" }} type="radio"
							name="cm_attr_val" value="{{ $attrval->id }}">
						{{ $attrval->values }}{{ $attrval->unit_value }}
					</label>

					@endif
					@endforeach
					<hr>
					<button class="btn btn-primary btn-md" type="submit"><i class="fa fa-save"></i> Save</button>
				</form>
			</div>

		</div>
	</div>
</div>

<!-- Delete Common Variant -->
<div id="cmdel{{ $commonvariant->id }}" class="delete-modal modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

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
				<form method="post" action="{{route('seller.del.common',$commonvariant->id)}}" class="pull-right">
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

@foreach($getopts as $opt)

<div id="edit{{ $opt->id }}" class="delete-modal modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="modal-title">
					Edit: <b> @php
						$key = '_';
						@endphp
						@if (strpos($opt->getattrname->attr_name, $key) == false)

						{{ $opt->getattrname->attr_name }}

						@else

						{{str_replace('_', ' ', $opt->getattrname->attr_name)}}

						@endif </b>
				</div>
			</div>
			<div class="modal-body">
				<form action="{{ route('seller.updt.var2',$opt->id) }}" method="POST">
					{{ csrf_field() }}

					<div class="form-group">
						<label><i>Choosed Option:</i>
							@php
							$key = '_';
							@endphp
							@if (strpos($opt->getattrname->attr_name, $key) == false)

							{{ $opt->getattrname->attr_name }}

							@else

							{{str_replace('_', ' ', $opt->getattrname->attr_name)}}

							@endif
						</label>

						@php
						$pvalues = App\ProductValues::where('atrr_id', $opt->attr_name)->get();
						@endphp
						<br>
						<label><input type="checkbox" class="sel_all"> Select All</label>
						<br>
						<label for="">Choose Value:</label>
						<br>


						@php

						$all_values =
						App\ProductValues::where('atrr_id',$opt->attr_name)->pluck('id','values')->toArray();

						$old_values = $opt->attr_value;
						$diff_values = array_diff($all_values,$old_values);

						@endphp

						@if(isset($old_values) && count($old_values) > 0)
						@foreach($old_values as $old_value)
						<label>
							<input checked type="checkbox" name="attr_value[]" value="{{ $old_value }}">
							@php
							$getvalname = App\ProductValues::where('id',$old_value)->first();
							@endphp
							@if(strcasecmp($getvalname->unit_value, $getvalname->values) !=0)

							@if($opt->getattrname->attr_name == "Color" || $opt->getattrname->attr_name == "Colour")


							<div class="margin-left-minus-15 inline-flex">
								<div class="color-options">
									<ul>
										<li title="{{ $getvalname->values }}" class="color varcolor active"><a href="#"
												title=""><i style="color: {{ $getvalname->unit_value }}"
													class="fa fa-circle"></i></a>
											<div class="overlay-image overlay-deactive">
											</div>
										</li>
									</ul>
								</div>
							</div>
							<span class="tx-color">{{ $getvalname->values }}</span>
							@else
							{{ $getvalname->values }}{{ $getvalname->unit_value }}
							@endif
							@else
							{{ $getvalname->values }}
							@endif
						</label>
						@endforeach
						@endif

						@if(isset($diff_values))
						@foreach($diff_values as $orivalue)
						<label>
							<input type="checkbox" value="{{ $orivalue }}" name="attr_value[]">
							@php
							$getvalname = App\ProductValues::where('id',$orivalue)->first();
							@endphp
							@if(strcasecmp($getvalname->unit_value, $getvalname->values) !=0)

							@if($opt->getattrname->attr_name == "Color" || $opt->getattrname->attr_name == "Colour")
							<div class="margin-left-minus-15 inline-flex">
								<div class="color-options">
									<ul>
										<li title="{{ $getvalname->values }}" class="color varcolor active"><a href="#"
												title=""><i style="color: {{ $getvalname->unit_value }}"
													class="fa fa-circle"></i></a>
											<div class="overlay-image overlay-deactive">
											</div>
										</li>
									</ul>
								</div>
							</div>
							<span class="tx-color">{{ $getvalname->values }}</span>
							@else
							{{ $getvalname->values }}{{ $getvalname->unit_value }}
							@endif
							@else
							{{ $getvalname->values }}
							@endif
						</label>
						@endforeach
						@endif

						<p>

						</p>
					</div>

					<button class="btn btn-md btn-primary" type="submit">
						<i class="fa fa-save"></i> Update
					</button>
				</form>


			</div>

		</div>
	</div>
</div>

<div id="{{ $opt->id }}var" class="delete-modal modal fade" role="dialog">
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
				<form method="post" action="{{route('seller.del.subvar',$opt->id)}}" class="pull-right">
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

<!--Sub variant delete modal-->
@foreach($findpro->subvariants as $key=> $sub)
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
				<form method="post" action="{{ route('seller.del.var',$sub->id) }}" class="pull-right">
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
<!--END Sub variant delete modal-->

<!-- Common Variant Modal -->
<div class="modal fade" id="cmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Product Common Variant</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('seller.add.common',$findpro->id) }}" method="POST">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="">Option Name:</label>

						@php

							$array1 = array();
							$test = collect();
							$array1[] = $findpro->category_id;
							$array2 = collect();

							foreach (App\ProductAttributes::all() as $value) {
								
								$array2 = $value->cats_id;
								$result = array_intersect($array1, $array2);

								if(in_array($findpro->category_id,$value->cats_id)){
									$test->push($value);
								}
							
							}


						@endphp

						<select required="" class="form-control" name="attr_name2" id="attr_name2">
							<option value="">Please Choose</option>
							@foreach($test as $t)
							<option value="{{ $t->id }}">

								@php
								$key = '_';
								@endphp
								@if (strpos($t->attr_name, $key) == false)

								{{ $t->attr_name }}

								@else

								{{str_replace('_', ' ', $t->attr_name)}}

								@endif

							</option>
							@endforeach
						</select>

					</div>

					<div class="form-group">
						<label for="">Option Value:</label>
						<div id="attr_value2">

						</div>

					</div>

					<button class="btn btn-md btn-primary" type="submit">
						<i class="fa fa-plus"></i> ADD
					</button>
				</form>


			</div>

		</div>
	</div>
</div>

<!--END-->

<!--Add Link varaint modal-->

<!-- Add Variant Modal -->
<div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Product Attributes</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('seller.add.str',$findpro->id) }}" method="POST">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="">Option Name:</label>

						@php

						$array1 = array();
						$test = collect();
						$array1[] = $findpro->category_id;
						$array2 = collect();
                        
						foreach (App\ProductAttributes::all() as $value) {
						$array2 = $value->cats_id;
						$result = array_intersect($array1, $array2);
                        
						if(in_array($findpro->category_id,$value->cats_id))
						{
						    $test->push($value);
						}
						}

						@endphp

						<select class="form-control" name="attr_name" id="attr_name">
							<option>Please Choose</option>
							@foreach($test as $t)
							<option value="{{ $t->id }}">

								@php
								$key = '_';
								@endphp
								@if (strpos($t->attr_name, $key) == false)

								{{$t->attr_name }}

								@else

								{{str_replace('_', ' ', $t->attr_name)}}

								@endif
							</option>
							@endforeach
						</select>

					</div>

					<div class="form-group">
						<div id="sel_box">

						</div>
						<label for="">Option Value:</label>
						<div id="attr_value">

						</div>

					</div>

					<button class="btn btn-md btn-primary" type="submit">
						<i class="fa fa-plus"></i> ADD
					</button>
				</form>


			</div>

		</div>
	</div>
</div>
<!--END-->

@endsection

@section('custom-script')
    <script>var baseUrl = "<?= url('/') ?>";</script>
	<script src="{{ url('js/sellervariant.js') }}"></script>
@endsection