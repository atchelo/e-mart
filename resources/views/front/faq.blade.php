@extends('front.layout.master')
@section('title',"FAQ's | ")
@section('body')
<div class="checkout-box faq-page">
	<h4>{{ __('staticwords.AllFAQs') }}</h4>
	<hr>
	<div class="row">
		<div class="col-md-12">

			<div class="panel-group checkout-steps" id="accordion">
				<!-- checkout-step-01  -->

				<!-- checkout-step-01  -->
				<div class="panel panel-default checkout-step-01">
					@foreach($faqs as $key=> $faq)

						<div class="panel-heading">
							<h4 class="unicase-checkout-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#faq{{ $faq->id }}">
									<span>{{ $key+1 }}</span> {{ $faq->que }}
								</a>
							</h4>
						</div>

						<div id="faq{{ $faq->id }}" class="panel-collapse collapse show">

							<div class="panel-body">

								{{ $faq->ans }}

							</div>

						</div>

					@endforeach
				</div>

			</div>
		</div>
	</div>
</div>
@endsection