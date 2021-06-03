@extends("admindesk/layouts.master")
@section('title',"Edit Option - $proattr->attr_name -")

@section("body")
	<div class="box" >
		<div class="box-header with-border">
			<div class="box-title">Edit Option {{ $proattr->attr_name }}</div>
		</div>

		<div class="box-body">
			<form action="{{ route('opt.update',$proattr->id) }}" method="POST">
				{{ csrf_field() }}

				<div class="col-md-6 form-group">
					<label for="attr_name">Name:</label>
					<input required="" type="text" placeholder="Please Enter name" name="attr_name" class="form-control" value="{{ $proattr->attr_name }}" />
						<p></p>

					<div class="box box-primary">
							<div class="box-header with-border">
								<label for="">Update Category:</label>
								<label class="pull-right">
									<input type="checkbox" class="selectallbox"> Select All
								</label>
							</div>

							<div class="box-body">
							

								@php

								$all_values = App\Category::pluck('id','title')->toArray();

								$old_values = $proattr->cats_id;

								$diff_values = array_diff($all_values,$old_values);
								
								@endphp

								@if(isset($old_values) && count($old_values) > 0)
					      			@foreach($old_values as $old_value)
										
										

											@php
											  $getcatname = App\Category::where('id',$old_value)->first();
											@endphp

											@if(isset($getcatname))

							      				<label>
												<input checked type="checkbox" name="cats_id[]" value="{{ $old_value }}"> {{$getcatname['title']}}
												</label>

											@endif
					      				
					      			@endforeach
					      		@endif

					      		@if(isset($diff_values))
									@foreach($diff_values as $orivalue)
										@php
									  		$getcatname = App\Category::where('id',$orivalue)->first();
										@endphp 

										@if(isset($getcatname))

											<label>
												<input type="checkbox" value="{{ $orivalue }}" name="cats_id[]"> 
											{{ $getcatname['title'] }}
											</label>

										@endif

									@endforeach
					      		@endif
							
								
							</div>
					</div>

					<button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-md btn-primary">
					<i class="fa fa-save"></i> Update
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