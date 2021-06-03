@extends('front.layout.master')

@section('body')
<div class="body-content">
  <div class="container">
	<div class="checkout-box">
		<div class="panel-group checkout-steps" id="accordion">
				<div class="panel panel-default checkout-step-01">

	<!-- panel-heading -->
		<div class="panel-heading">
    	<h4 class="unicase-checkout-title">
	        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
	          <span>1</span>{{ __('staticwords.CheckoutMethod') }}
	        </a>
	     </h4>
    </div>
    <!-- panel-heading -->

	<div id="collapseOne" class="panel-collapse collapse in show">

		<!-- panel-body  -->
	    <div class="panel-body">
			<div class="row">		

				<!-- guest-login -->			
				<div class="col-md-6 col-sm-6 guest-login">
					<h4 class="checkout-subtitle">{{ __('staticwords.GuestorRegisterLogin') }}</h4>
					<p class="text title-tag-line">{{ __('staticwords.registerwithus') }}:</p>

					<!-- radio-form  -->
					<form class="register-form" method="post" action="{{url('user/process_to_guest')}}">
						 {{csrf_field()}}
					    <div class="radio radio-checkout-unicase">
					    @if($genrals_settings->guest_login == 1)  
					        <input id="guest" type="radio" name="checkValue" value="guest" checked>  
					        <label class="radio-button guest-check" for="guest">{{ __('staticwords.CheckoutasGuest') }}</label>
					    @endif  
					          <br>
					        <input id="register" type="radio" name="checkValue" value="register">  
					        <label class="radio-button" for="register">{{ __('staticwords.Register') }}</label>  
					    </div>  

					
					<!-- radio-form  -->

					<h4 class="checkout-subtitle outer-top-vs">{{ __('staticwords.Registerandsavetime') }}</h4>
					<p class="text title-tag-line">{{ __('staticwords.Registerwithusforfutureconvenience') }}:</p>
					
					<ul class="text instruction inner-bottom-30">
						<li class="save-time-reg">- {{ __('staticwords.Fastandeasycheckout') }}</li>
						<li>- {{ __('staticwords.Easyaccesstoyourorderhistoryandstatus') }}</li>
					</ul>

					<button type="submit" class="btn-upper btn btn-primary checkout-page-button checkout-continue ">
						{{ __('staticwords.Continue') }}
					</button>

					</form>
					
				</div>
				
				<!-- guest-login -->

				<!-- already-registered-login -->
				<div class="col-md-6 col-sm-6 already-registered-login">
					<h4 class="checkout-subtitle">{{ __('staticwords.Alreadyregistered') }}</h4>
					<p class="text title-tag-line">{{ __('staticwords.Pleaseloginbelow') }}:</p>
					<form novalidate method="POST" class="form register-form outer-top-xs" role="form" action="{{ route('ref.cart.login') }}">
                        @csrf
						<div class="form-group">
					    <label class="info-title">{{ __('staticwords.eaddress') }} <span>*</span></label>
					    <input required type="email" class="form-control unicase-form-control text-input"  name="email" placeholder="{{ __('staticwords.Enteryouremailaddress') }}" value="{{ old('email') }}">
					    @if ($errors->has('email'))
                                    <span class="invalid-feedback colorred" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
					  </div>
					  <div class="form-group">
					    <label class="info-title">{{ __('staticwords.Password') }} <span>*</span></label>
					    <input required type="password" class="form-control unicase-form-control text-input" placeholder="****" name="password">
					    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
					    <a href="{{ route('password.request') }}" class="forgot-password">{{ __('staticwords.ForgotYourPassword') }}</a>
					  </div>
					  <button type="submit" class="signin btn-upper btn btn-primary checkout-page-button">
					  	{{ __('Login') }}
					  </button>
					</form>
				</div>	
				<!-- already-registered-login -->		

			</div>			
		</div>
		<!-- panel-body  -->

	</div><!-- row -->
</div>
		</div>
	</div>
  </div>
</div>
@endsection
@section('script')
<script>

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('form');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }else{
                $('.signin').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> {{ __('staticwords.Login') }}');
            }
            form.classList.add('was-validated');
            
        }, false);
        
        });
    }, false);
    })();
</script>
@endsection