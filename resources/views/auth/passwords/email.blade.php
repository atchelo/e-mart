@extends("front.layout.master")
@section('title','Forget Password ?')
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

                    <form method="POST" action="{{ route('password.email') }}">
                      @csrf
                      <div class="form-group has-feedback">
                        <label for="email">{{ __('staticwords.Enteremailtocontinue') }}</label>
                        <input required="" value="{{ old('email') }}" type="email" name="email" class="form-control" placeholder="{{ __('staticwords.Email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                          <span class="invalid-feedback text-danger" role="alert">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                      </div>
                      
                      <div class="row">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary">
                              {{ __('staticwords.SendPasswordResetLink') }}
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