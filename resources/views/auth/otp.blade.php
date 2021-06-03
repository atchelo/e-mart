@extends("front.layout.master")
@section('title','Verify OTP | ')
@section('body')
@php
    require_once(base_path().'/app/Http/Controllers/price.php');
@endphp
  <div class="body-content">
    <div class="container-fluid">
        <div class="sign-in-page">
            <div class="row justify-content-center">
              <div id="aniBox" class="col-md-6 sign-in">
                
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verifyotp') }}">
                      @csrf
                      <div class="form-group has-feedback">
                        <label for="otp">{{ __('Enter OTP') }}</label>
                        <input required="" value="{{ old('email') }}" type="text" name="otp" class="form-control @error('otp') is-invalid @enderror" placeholder="{{ __('Enter OTP') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('otp'))
                          <span class="invalid-feedback text-danger" role="alert">
                              <strong>{{ $errors->first('otp') }}</strong>
                          </span>
                        @endif
                      </div>
                      
                      <div class="row">
                        <div class="col-md-12">
                          <a role="button" href="{{ route('resend.otp') }}" class="btn btn-primary">
                            {{ __('Re-send OTP') }}
                          </a>
                          <button type="submit" class="btn btn-primary">
                              {{ __('Verify OTP') }}
                          </button>
                          <a role="button" href="{{ route('cancel.otp') }}" class="btn btn-danger">
                              {{ __('Cancel') }}
                          </a>
                        </div>
                      </div>
                    
                    </form>
              </div>
            </div>
        </div>
    </div>
  </div>
@endsection