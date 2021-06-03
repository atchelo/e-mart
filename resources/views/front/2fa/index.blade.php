@extends('front.layout.master')
@section('title',"2 Factor Auth | ")
@section('body')
<div class="checkout-box faq-page">
	<h4>{{ __('Enable 2 Factor Auth') }}</h4>
	<hr>
	<div class="row">
		
			<div class="col-md-8">

				<div class="card">

					<div class="card-body">

						<h6>
							Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.
						</h6>

						@if($data['google2fa_url'] != '' )
							1. Scan this QR code with your Google Authenticator App:
						@endif
						
						@if($data['google2fa_url'] != '' )
						<div>
							{!! $data['google2fa_url'] !!}
						</div>
						@endif
						<hr>
						@if($data['google2fa_url'] == '' )
						<form action="{{ url('/generate2faSecret') }}" method="POST">
							@csrf
							
							<div class="form-group">
								<button type="submit" class="btn btn-md btn-primary">
									Generate Secret Key to Enable 2FA
								</button>
							</div>

						</form>
						@endif

						@if(auth()->user()->google2fa_secret != '' && auth()->user()->google2fa_enable == 0 )
						<form action="{{ url('/2fa-valid') }}" method="POST">
							@csrf
							<div class="form-group">
								<label class="font-weight-normal">Enter pin from app or above code: <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="one_time_password">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-md btn-primary">
									{{__('Enable 2FA Auth')}}
								</button>
							</div>
						</form>
						@endif

						@if(auth()->user()->google2fa_enable == 1)
							<form action="{{ url('/disable-2fa') }}" method="POST">
								@csrf

								<div class="form-group">
									<label class="font-weight-normal">Enter current password to disable 2FA: <span class="text-danger">*</span></label>
									<input required type="password" placeholder="Enter current password" class="form-control @error('password') is-invalid @enderror" name="password">

									@error('password')
										<span class="invalid-feedback text-danger" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-md btn-primary">
										{{__('Disable 2FA Auth')}}
									</button>
								</div>
							</form>
						@endif
					</div>
				</div>
			</div>
	</div>
</div>
@endsection