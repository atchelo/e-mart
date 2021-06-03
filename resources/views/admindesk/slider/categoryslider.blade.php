@extends('admindesk.layouts.master')
@section('title','Front Category Slider | ')
@section('body')
	<div class="box">

		<div class="box-header with-border">
			<div class="box-title">
				Front Category Slider
			</div>
		</div>

		<div class="box-body">

			<div class="row">
				<div class="col-md-8">
					<div class="callout callout-success">
						<i class="fa fa-info-circle"></i> ONLY those category will list here who have atleast one complete product. (Complete product means product with atleast one variant)
					</div>
					<form action="{{ route('front.slider.post') }}" method="POST">
						@csrf
						<div class="form-group">
							<label>Select Category: <span class="required">*</span></label>
							<select multiple="multiple" class="js-example-basic-single" name="category_ids[]" id="" class="form-control">
								
									@foreach (App\Category::where('status','=','1')->get(); as $item)
										@if($item->products->count()>0)
											@if(isset($slider) && $slider->category_ids != '')
												<option @foreach($slider['category_ids'] as $c)
												{{$c == $item['id'] ? 'selected' : ''}}
												@endforeach
												value="{{ $item['id'] }}">{{ $item['title'] }}</option>
											@else
												<option value="{{ $item['id'] }}">{{ $item['title'] }}</option>
											@endif
										@endif
									@endforeach
								
							</select>
						</div>

						<div class="form-group">
							
							<div class="row">
								<div class="col-md-4">
									<label>Product Show In Slider: <span class="required">*</span></label>
									<input type="number" value="{{ $slider->pro_limit ?? '' }}" min="1" max="50" name="pro_limit" class="form-control">
								</div>
							</div>
								
						</div>

						<div class="form-group">
							 <input {{ isset($slider->status) && $slider->status == 1 ? "checked" : "" }} id="status" name="status" class="tgl tgl-skewed" type="checkbox">
                        	 <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="status"></label>
						</div>

						<div class="form-group">
							<button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This action cannot be done in demo !" disabled="disabled" @endif class="btn btn-md btn-primary">
								<i class="fa fa-save"></i> Save
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
