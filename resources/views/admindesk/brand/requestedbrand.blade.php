@extends('admindesk.layouts.master')
@section('title','Requested Brands | ')
@section('body')
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title">
				Requested Brands
			</div>
		</div>

		<div class="box-body">
			<table class="table table-bordered table-striped">
				
				<thead>
					<th>#</th>
					<th>Brand Logo</th>
					<th>Brand Name</th>
					<th>Brand Proof</th>
					<th>Action</th>
				</thead>

				<tbody>
					@foreach($brands as $key=> $brand)
						<tr>
							<td>
								{{ $key+1 }}
							</td>

							<td>
								@if($brand->image !='')
									<img align="left" width="50px" height="70px" src='{{ url("images/brands/".$brand->image) }}'/>
									
								@else
									<img title="Make a variant first !" src="{{ Avatar::create($brand->name)->toBase64() }}" />
								@endif
							</td>

							<td>
								<p>{{ $brand->name }}</p>
							</td>

							<td>
								@if($brand->brand_proof !='')
									{{ url('brandproof/'.$brand->brand_proof) }}
								@else
								 -
								@endif
							</td>

							<td>
								<form action="{{ route('brand.quick.update',$brand->id) }}" method="POST">
								      {{csrf_field()}}
								      <button type="submit" class="btn btn-xs {{ $brand->status==1 ? "btn-success" : "btn-danger" }}">
								        {{ $brand->status ==1 ? 'Active' : 'Deactive' }}
								      </button>
								</form> 
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection