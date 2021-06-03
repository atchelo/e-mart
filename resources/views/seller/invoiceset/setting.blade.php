@extends('admindesk.layouts.sellermaster')
@section('title','Seller Invoice Setting |')
@section('body')
@php
	$setting = App\Invoice::where('user_id',Auth::user()->id)->first();
@endphp
	<div class="box">

		<div class="box-header with-border">
			Seller Invoice Setting
		</div>

		<div class="box-body">
			<form action="{{ route('vender.invoice.sop') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-group col-md-6">
					<label for="seal">Seal/Stamp (Image) <small class="help-block">Stamp/Seal will show at bottom right of your invoice</small></label>
					<input type="file" class="form-control" name="seal">
				</div>

				<div class="form-group col-md-6">
					<label for="sign">Signature <small class="help-block">Signature will show at bottom left of your invoice</small></label>

					<input type="file" class="form-control" name="sign">
				</div>

				<div class="col-md-12">
					<button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This action is disable in demo !" disabled="disabled" @endif class="btn btn-primary btn-md"><i class="fa fa-save"></i> Save Setting</button>
				</div>
				<p>&nbsp;</p>
				</form>
				
				<div class="col-md-6">
					Preview <br>
					@if(isset($setting))
						<img width="100px" title="Your Stamp/Seal" src="{{ url('images/seal/'.$setting->seal) }}" alt="">
					@endif
				</div>

				<div class="col-md-6">
					Preview <br>
					@if(isset($setting))
						<img width="100px" title="Your Sign" src="{{ url('images/sign/'.$setting->sign) }}" alt="">
					@endif
				</div>
			</form>
		</div>

	</div>
@endsection