@extends("front.layout.master")
@section('title','Guest Checkout |')
@section("body")
<div class="body-content">
    <div class="container">
        <div class="sign-in-page">

            <form novalidate class="form register-form outer-top-xs" role="form" method="POST" action="{{ route('ref.guest.register') }}">
                @csrf
                <div class="row">
                    <!-- create a new account -->
                    <div class="col-md-6 col-sm-6 create-new-account">
                        <h4 class="checkout-subtitle">{{ __('Checkout as Guest') }}</h4>

                        <div class="form-group">
                            <label class="info-title" for="email">{{ __('staticwords.eaddress') }} <span class="text-red">*</span></label>
                            <input required value="{{ old('email') }}" type="email" class="form-control unicase-form-control text-input {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" required autofocus>

                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="name">{{ __('staticwords.Name') }} <span class="text-red">*</span></label>
                            <input required name="name" type="text" value="{{ old('name') }}"
                                class="form-control unicase-form-control text-input{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"/>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="eula" id="eula" required>
                                <label class="form-check-label" for="eula">
                                    <b>{{ __('I agree to ') }}<a href="#eulaModal"
                                            data-toggle="modal">{{ __('terms and conditions') }}</a></b>
                                </label>
                            </div>
                        </div>

                        @php
                        $userterm = App\TermsSettings::firstWhere('key','user-register-term');
                        @endphp

                        <div id="eulaModal" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="my-modal-title" aria-hidden="true">
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


                    </div>

                    <div class="col-md-6 col-sm-6 create-new-account">
                        <h4 class="checkout-subtitle">&nbsp;</h4>
                        <p class="text title-tag-line"></p>

                    </div>


                    <div class="col-md-12">
                        <button type="submit" class="register btn-upper btn btn-primary checkout-page-button">{{ __('staticwords.Register') }}</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div><!-- /.body-content -->
@endsection
@section('script')
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('form');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        $('.register').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> {{ __('staticwords.Register') }}');
                    }
                    form.classList.add('was-validated');

                }, false);

            });
        }, false);
    })();
</script>
@endsection