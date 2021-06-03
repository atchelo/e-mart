@extends('front.layout.master') 
@section('title',__('Verify Email |'))
@section('body')
<div class="container-fluid">
	<div class="row">
		<div class="terms-conditions-page width100">
			<div class="wow terms-conditions">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

				<h1 class="text-dark">{{ __('Verify Your Email Address') }}</h1>
					<hr> 
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }} <hr> <a class="btn btn-md btn-primary" role="button" href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
			</div>
		</div>
	</div>
</div>
@endsection
