@extends("front/layout.master")
@section('title','Register |')
@section("body")
@php
require_once(base_path().'/app/Http/Controllers/price.php');
@endphp
@section('stylesheet')
<style>
    .select2-selection__rendered {
        line-height: 38px !important;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .select2-selection__arrow {
        height: 34px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        text-align: center;
    }
</style>
@endsection
@php
   if(isset($selected_language) && $selected_language->rtl_available == 1){
        $class = 'offset-md-1';
   }else{
       $class = 'offset-md-3';
   }
@endphp
<div class="body-content">
    <div class="container">
        <div class="sign-in-page">
            <h4 class="checkout-subtitle">{{ __('staticwords.Createanewaccount') }}</h4>

            <form class="form outer-top-xs" role="form" method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <!-- create a new account -->

                <div class="row">

                    <div class="{{ $class }} col-md-6">
                        <p class="text-success">{{ __('Quick Sign up with') }} :</p>
                        <div class="social-btn text-center">

                            @if($configs->fb_login_enable=='1')
                                <a href="{{ route('sociallogin','facebook') }}" class="btn btn-primary btn-lg"><i class="fa fa-facebook"></i> Facebook</a>
                            @endif

                            @if($configs->twitter_enable == 1)
                                <a href="{{ route('sociallogin','twitter') }}" class="btn bg-twitter btn-lg"><i class="fa fa-twitter"></i> Twitter</a>
                            @endif

                            @if($configs->google_login_enable=='1')
                                <a href="{{ route('sociallogin','google') }}" class="btn btn-danger btn-lg"><i class="fa fa-google"></i> Google</a>
                            @endif
                            
                            @if($configs->amazon_enable=='1')
                                <a href="{{ route('sociallogin','amazon') }}" class="btn btn-warning btn-lg"><i class="fa fa-amazon"></i> Amazon</a>
                            @endif

                            @if(env('ENABLE_GITLAB') == 1 )
                                <a href="{{ route('sociallogin','gitlab') }}" class="btn bg-dark btn-lg"><i class="fa fa-gitlab"></i> Gitlab</a>
                            @endif

                            @if($configs->linkedin_enable=='1')
                                <a href="{{ route('sociallogin','linkedin') }}" class="btn bg-primary btn-lg"><i class="fa fa-linkedin"></i> Linkedin</a>
                            @endif

                            
                        </div>
                        
                        <div class="or-seperator"><b>or</b></div>

                    </div>


                    <div class="{{  $class }} col-md-6">
                        <div class="form-group">
                            <label class="info-title"
                                for="exampleInputEmail1">{{ __('staticwords.Name') }}<span>*</span></label>
                            <input required name="name" type="text" value="{{ old('name') }}"
                                class="form-control unicase-form-control text-input{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                id="name"> @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span> @endif

                           
                        </div>
                    </div>

                    <div class="{{ $class }} col-md-6">
                        <div class="form-group">
                            <label class="info-title" for="exampleInputEmail2">{{ __('staticwords.eaddress') }}
                                <span>*</span></label>
                            <input required value="{{ old('email') }}" type="email"
                                class="form-control unicase-form-control text-input {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                id="email" name="email" required autofocus>
                            @if ($errors->has('email'))
                            <span class="invalid-feedback"
                                role="alert"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    @if($genrals_settings->otp_enable == 0)
                    
                    <div class="{{  $class }} col-md-6">
                       
                        <div class="form-group">
                            <label class="info-title" for="exampleInputEmail1">{{ __('staticwords.MobileNo') }} {{__("staticwords.WithPhoneCode")}}
                                <span>*</span></label>
                                <div class="row no-gutters">
                                    <div class="col-md-2">
                                        <input required type="number" value="0" min="0" title="{{ __('Please enter valid phone code') }}." value="{{ old('phonecode') }}"
                                        class="form-control unicase-form-control text-input{{ $errors->has('phonecode') ? ' is-invalid' : '' }}" name="phonecode" id="phonecode" required>
                                    </div>

                                    <div class="col-md-10">
                                        <input required pattern="[0-9]+" title="{{ __('Please enter valid mobile no') }}."
                                        value="{{ old('mobile') }}" type="text"
                                        class="form-control unicase-form-control text-input{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="phone" required>
                                    </div>
                                </div>
                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>
                    @endif

                    @if($genrals_settings->otp_enable == 1)
                    <div class="{{  $class }} col-md-6">
                        <label class="info-title" for="exampleInputEmail1">{{ __('staticwords.MobileNo') }}
                            <span>*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <select required class="form-control select2" name="phonecode" id="phonecode">

                                    @foreach(App\Allcountry::select('phonecode','nicename')->get() as $code)
                                    <optgroup label="{{ $code->nicename }}">
                                        <option {{ old('phonecode') == $code->phonecode ? "selected" : "" }}
                                            value="{{ $code->phonecode }}">{{ $code->phonecode }}</option>
                                    </optgroup>
                                    @endforeach

                                </select>
                            </div>
                            <input required pattern="[0-9]+" title="{{ __('Please enter valid mobile no') }}."
                                value="{{ old('mobile') }}" type="text"
                                class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile"
                                id="phone" required>
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <p class="text-danger error"></p>
                        <p class="text-success success"></p>
                    </div>


                    @endif

                    <div class="{{  $class }} col-md-6">
                        <div class="form-group">
                            <label class="info-title" for="password">{{ __('staticwords.EnterPassword') }}
                                <span>*</span></label>
                            <input required type="password" id="password"
                                class="form-control unicase-form-control text-input {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                name="password" required> @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span> @endif
                        </div>
                    </div>

                    <div class="{{  $class }} col-md-6">
                        <div class="form-group">
                            <label class="info-title" for="exampleInputEmail1">{{ __('staticwords.ConfirmPassword') }}
                                <span>*</span></label>
                            <input required type="password" name="password_confirmation" id="password-confirm"
                                class="form-control unicase-form-control text-input" required />

                           

                        </div>
                    </div>
                    
                    @if($aff_system->enable_affilate == 1)
                        <div class="{{  $class }} col-md-6">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">{{ __('staticwords.ReferCode') }}
                                </label>
                                <input value="{{ app('request')->input('refercode') ?? old('refercode') }}" type="text" name="refer_code" class="{{ $errors->has('refercode') ? ' is-invalid' : '' }} form-control unicase-form-control text-input" required />

                                @if ($errors->has('refercode'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('refercode') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                    @endif


                    @if($genrals_settings->captcha_enable == 1)

                    <div class="{{  $class }} col-md-6">
                        <div class="form-group">
                            {!! no_captcha()->display() !!}
                        </div>

                        @error('g-recaptcha-response')
                        <p class="text-danger"><b>{{ $message }}</b></p>
                        @enderror
                    </div>

                    @endif
                    <div class="{{  $class }} col-md-6">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="eula" id="eula" required>
                                <label class="form-check-label" for="eula">
                                    <b>{{ __('I agree to ') }}<a href="#eulaModal" data-toggle="modal">{{ __('terms and conditions') }}</a></b>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="{{  $class }} col-md-6">
                        <button type="submit"
                            class="register btn-upper btn btn-primary checkout-page-button">{{ __('staticwords.Register') }}</button>
                        <a class="float-right"
                            href="{{ route('login') }}">{{ __('Already have account login here?') }}</a>
                    </div>


                </div>

                @php
                  $userterm = App\TermsSettings::firstWhere('key','user-register-term');
                @endphp

                <div id="eulaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="modal-title" id="my-modal-title">{{ $userterm['title'] }}</h5>
                                
                            </div>
                            <div class="modal-body">
                                <div style="overflow: scroll;max-height:500px">
                                
                                    {!! $userterm['description'] !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- /.body-content -->
@endsection
@section('script')
<script>
    "use strict";

    var baseurl = "<?= url('/') ?>";
    $(document).ready(function () {
        $('.select2').select2({
            height: '100px'
        });
    });
</script>
<script src="{{ url('js/ajaxlocationlist.js') }}"></script>
@if($genrals_settings->captcha_enable == 1)
{!! no_captcha()->script() !!}
@endif
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
                $('.register').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> {{ __('staticwords.Register') }}');
            }
            form.classList.add('was-validated');
            
        }, false);
        
        });
    }, false);
    })();
</script>
@endsection