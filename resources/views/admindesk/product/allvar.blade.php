@extends('admindesk.layouts.master')
@section('title',"View $pro->name's All Variants - ")
@section('body')


<div class="box">



	<div class="box-header with-border">
		<div class="box-title">

			<a title="Go back to all products" href="{{ url('admindesk/products') }}" class="btn btn-sm btn-default"><i
					class="fa fa-reply" aria-hidden="true"></i></a> {{$pro->name}}'s Variant



			<small>Sold by : {{ $pro->store->name }}</small>
			<br>
			<br>


			<small>In: <span class="bolder">{{ $pro->category->title }}</b> <i class="fa fa-angle-double-right"
						aria-hidden="true"></i>
					<span class="font-weight600">{{ $pro->subcategory->title }}</span> <i
						class="fa fa-angle-double-right" aria-hidden="true"></i>
					@if(isset($pro->childcat)) {{ $pro->childcat->title }} @endif</small>

		</div>
	</div>

	<div class="box-body">

		<table class="width100 table table-bordered">
			<thead>
				<tr>
					<th class="text-green">
						<div class="inline">
							<input id="checkboxAllActive" type="checkbox" class="filled-in" name="checked[]"
								value="all" />
							<label for="checkboxAllActive" class="material-checkbox"></label>
						</div>

					</th>
					<th>Variant Detail</th>
					<th>Pricing Details</th>
					<th>Added / Updated On</th>
					<th>
						Status
					</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				@foreach($pro->subvariants as $key=> $sub)
				<tr>
					<td width="8%">
						<div class='inline'>
							<input type='checkbox' form='bulk_form'
								class='active_cb filled-in material-checkbox-input' name='checked[]'' value='
								{{$sub->id}}' id='activecheckbox{{$sub->id}}'>
							<label for='activecheckbox{{$sub->id}}' class='material-checkbox'></label>
						</div>
						<b># {{ $key+1 }}</b>
					</td>
					<td class="v-middle">
						<div class="row">
							<div class="col-md-3">

								@if(count($pro->subvariants)>0)

								@if(isset($sub->variantimages['main_image']))

								<img class="pro-img ximg2" title="{{ $pro->name }}"
									src="{{ url('variantimages/thumbnails/'.$sub->variantimages['main_image']) }}"
									alt="{{ $sub->variantimages['main_image'] }}">


								@endif
								@else
								<img class="ximg" src="{{ asset('images/no-image.png') }}" alt="no-image.png">
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

									@if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=0 &&
									$getvalname->unit_value != null )

									@if($getvalname->proattr->attr_name == "Color" || $getvalname->proattr->attr_name ==
									"Colour" || $getvalname->proattr->attr_name == "color" ||
									$getvalname->proattr->attr_name == "colour")
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

								<p><b>Stock :</b> {{ $sub->stock }} | <b>Max Qty. For Order:</b>
									{{ $sub->max_order_qty }}</p>
							</div>

						</div>



					</td>
					<td class="v-middle">

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
						<p><i class="fa fa-clock-o" aria-hidden="true"></i> <span
								class="font-weight500">{{ date('h:i A',strtotime($sub->created_at)) }}</span></p>

						<p class="greydashedborder"></p>

						<p>
							<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
							<span class="font-weight500">{{ date('M jS Y',strtotime($sub->updated_at)) }}</span>
						</p>

						<p><i class="fa fa-clock-o" aria-hidden="true"></i> <span
								class="font-weight500">{{ date('h:i A',strtotime($sub->updated_at)) }}</span></p>

					</td>

					<td class="v-middle">
						@if($sub->status == 1)

						<span class="label label-success">Active</span>

						@else

						<span class="label label-danger">Deactive</span>

						@endif
					</td>

					<td class="v-middle">

						<a target="_blank" title="View Variant" href="{{ $pro->getURL($sub) }}"
							class="btn btn-sm btn-default">
							<i class="fa fa-eye"></i>
						</a>

						<a href="{{ route('edit.var',$sub->id) }}" class="btn btn-sm btn-primary">
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