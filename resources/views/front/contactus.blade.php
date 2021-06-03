@extends('front.layout.master')
@section('title','Contact us | ')
@section('body')
<div class="body-content">
    <div class="container-fluid">
        <div class="contact-page">
            <div class="row">

                <div class="col-md-12 contact-map outer-bottom-vs">
                    <iframe width="600" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=450&amp;hl=en&amp;q={{ $settings['address'] }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                </div>
               
                <div class="col-md-8 contact-form">
                    <form action="{{ route('get.connect') }}" method="POST" novalidate class="form">
                        @csrf
                    <div class="row">
                       
                        <div class="col-md-12 contact-title">
                            <h4>{{ __('staticwords.ContactForm') }}</h4>
                        </div>
                        <div class="col-md-4 ">

                            <div class="form-group">
                                <label>{{ __('staticwords.YourName') }}: <span
                                        class="text-danger">*</span></label>
                                <input required name="name" type="text"
                                    class="@error('name') 'is-invalid' @enderror form-control unicase-form-control text-input"
                                    id="name" value="{{ old('name') }}"
                                    placeholder="{{ __('staticwords.EnterYourName') }}">


                                @error('name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group register-form">
                                <label class="info-title" for="email">{{ __('staticwords.eaddress') }}
                                    <span class="text-danger">*</span></label>
                                <input required name="email" type="email"
                                    class="@error('email') 'is-invalid' @enderror form-control unicase-form-control text-input"
                                    id="email" value="{{ old('email') }}"
                                    placeholder="{{ __('staticwords.Enteryouremailaddress') }}">

                                @error('email')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>



                        </div>
                        <div class="col-md-4">
                            <div class="form-group register-form">
                                <label class="info-title" for="subject">{{ __('staticwords.Subject') }}: <span
                                        class="text-danger">*</span></label>
                                <input required name="subject" required type="text"
                                    class="@error('subject') 'is-invalid' @enderror form-control unicase-form-control text-input"
                                    id="subject" value="{{ old('subject') }}"
                                    placeholder="{{ __('staticwords.PleaseEnterSubject') }}">


                                @error('subject')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group register-form">
                                <label class="info-title" for="message">{{ __('staticwords.Message') }}
                                    <span class="text-danger">*</span></label>
                                <textarea rows="5" cols="30" name="message" required
                                    placeholder="{{ __('staticwords.PleaseEnterMessage') }}"
                                    class="form-control @error('message') 'is-invalid' @enderror unicase-form-control"
                                    id="message">{{ old('message') }}</textarea>


                                @error('message')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 outer-bottom-small m-t-20">
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Send
                                Message</button>
                        </div>

                    </form>

                    </div>
                </div>

                <div class="col-md-4 contact-info">
                    <div class="contact-title">
                        <h4>{{ __('staticwords.Information') }}</h4>
                    </div>
                    <div class="clearfix p-1">
                        <span class="contact-i"><i class="fa fa-map-marker"></i></span>
                        <span class="contact-span">{{ $settings['address'] }}</span>
                    </div>
                    <div class="clearfix p-1">
                        <span class="contact-i"><i class="fa fa-mobile"></i></span>
                        <span class="contact-span"><a href="tel:{{ $settings['mobile'] }}">{{ $settings['mobile'] }}</a></span>
                    </div>
                    <div class="clearfix p-1">
                        <span class="contact-i"><i class="fa fa-envelope"></i></span>
                        <span class="contact-span"><a href="mail:{{ $settings['email'] }}">{{ $settings['email'] }}</a></span>
                    </div>
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
            }
            form.classList.add('was-validated');
            
        }, false);
        
        });
    }, false);
    })();
</script>  
@endsection