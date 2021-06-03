@extends("front.layout.master")
@section('title','Reset Password |')
@section('body')
@php
    require_once(base_path().'/app/Http/Controllers/price.php');
@endphp
  <div class="body-content">
    <div class="container-fluid">
        <div class="sign-in-page">
          <h4 class="text-center">Create new password for your account</h4>
          <br>
            <div class="row justify-content-center">
              
              <div id="aniBox" class="col-md-6 sign-in">
                
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                      @csrf
                      <input type="hidden" name="token" value="{{ $token }}">
                       <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                         <input placeholder="{{ __('staticwords.Enteryouremailaddress') }}" id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                 
                          @if ($errors->has('email'))
                                   <span class="help-block">
                                     <strong>{{ $errors->first('email') }}</strong>
                                   </span>
                          @endif
                         <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                         @if ($errors->has('email'))
                           <span class="invalid-feedback text-danger" role="alert">
                               <strong>{{ $errors->first('email') }}</strong>
                           </span>
                         @endif
                       </div>
                 
                        <div class="form-group has-feedback">
                         <input placeholder="{{ __('staticwords.EnterPassword') }}" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                 
                                                 @if ($errors->has('password'))
                                                     <span class="invalid-feedback text-danger" role="alert">
                                                         <strong>{{ $errors->first('password') }}</strong>
                                                     </span>
                                                 @endif
                         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                       </div>
                 
                        <div class="form-group has-feedback">
                          <input placeholder="{{ __('staticwords.ConfirmPassword') }}" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                       </div>
                       
                       <div class="row">
                         <div class="col-md-12">
                           <button type="submit" class="btn btn-block btn-primary btn-flat">
                                 {{ __('staticwords.ResetPassword') }}
                           </button>
                         </div>
                       </div>
                     
                     </form>
              </div>
            </div>
        </div>
    </div>
  </div>
@endsection