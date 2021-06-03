@extends("admindesk/layouts.master")
@section('title','Create Attribute -')

@section("body")
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title">Add Options</div>
		</div>

		<div class="box-body">
			
			<div class="callout callout-warning">
				<i class="fa fa-info-circle" aria-hidden="true"></i> Once you created option you can't Delete it ! You can only edit it
			</div>

			<div class="callout callout-info">
				<i class="fa fa-info-circle" aria-hidden="true"></i> If you want to create long attribute name with space eg. <b>Screen Size</b> than create it with '<b>_ (underscore) </b>' eg. <b>Screen_size</b>. System will add space on front end.
			</div>


			<form action="{{ route('opt.str') }}" method="POST">
				{{ csrf_field() }}

				<div class="col-md-6 form-group">
					<label for="attr_name">Name:</label>
					<input required="" type="text" name="attr_name" class="form-control"/>
						<p></p>

					<div class="form-group">
					
						
						<div class="box box-primary">
							<div class="box-header with-border">
								<label for="">Choose Category:</label>
								<label class="pull-right">
									<input type="checkbox" class="selectallbox"> Select All
								</label>
							</div>
							<div class="box-body">
								@foreach(App\Category::all() as $cat)

									<label>
									<input type="checkbox" name="cats_id[]" value="{{ $cat->id }}">
									{{ $cat->title }}
									</label>

								@endforeach
							</div>
						</div>
								
						
						
					</div>

					<div class="form-group">
						<label>
							Select Type :
						</label>
					
						<select class="form-control" name="unit_id">
							@foreach(App\Unit::all() as $unit)
								<option value="{{ $unit->id }}">{{ $unit->title }}</option>
							@endforeach
						</select>
					</div>

					<button type="submit" class="btn btn-md btn-primary">
					<i class="fa fa-plus"></i> Add
					</button>

					<a class="color111" href="{{ route('attr.index') }}">
						<button type="button" class="btn btn-md btn-default">
						<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> 
							Back
						</button>
					</a>
				</div>
					

					
				
			</form>
		</div>
	</div>
@endsection
@section('custom-script')
	<script>
		$('.selectallbox').on('click',function(){
			if($(this).is(':checked')){
				$('input:checkbox').prop('checked', this.checked);
			}else{
				$('input:checkbox').prop('checked', false);
			}
		});
	</script>
@endsection