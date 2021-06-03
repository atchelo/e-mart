<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/vendor/shards.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/install.css') }}">
    
    <title>{{ __('Installing App - Terms and Condition') }}</title>
    @notify_css
  </head>
  <body>
   	   
      <div class="display-none preL">
        <div class="display-none preloader3"></div>
      </div>

   		<div class="container">
   			<div class="card">
          <div class="card-header">
              <h3 class="m-3 text-center text-dark ">
                  {{ __('Installing eMart') }}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form action="{{ route('store.eula') }}" id="step1form" method="POST" class="needs-validation" novalidate>
                  @csrf
                  <h3>{{ __('Terms & Conditions') }}</h3>
                   <hr>
                  <div class="form-row">
                    <br>
                   <div class="col-md-12">
                      <p class="text-dark font-weight-bold">{{ __('Please read this agreement carefully before installing or using this product') }}.</p>
                      <p class="text-dark font-weight-normal">

                      {{ __('If you agree to all of the terms of this End-User License Agreement, by checking the box or clicking the button to confirm your acceptance when you first install the web application, you are agreeing to all the terms of this agreement. Also, By downloading, installing, using, or copying this web application, you accept and agree to be bound by the terms of this End-User License Agreement, you are agreeing to all the terms of this agreement. If you do not agree to all of these terms, do not check the box or click the button and/or do not use, copy or install the web application, and uninstall the web application from all your server that you own or control') }}.</p>
                      
                      <b>{{ __('Note') }}:</b> <span class="text-dark font-weight-normal">
                        {{ __("With eMart, We are using the official Payment API (Paypal, Instamojo, Payu, Stripe) which is available on Developer Center. That is a reason why our prodyuct depends on Payment API(Paypal, Instamojo, Payu, Stripe). Therefore, We are not responsible if they made too many critical changes in their side. We also don't guarantee that the compatibility of the script with Payment API will be forever. Although we always try to update the lastest version of script as soon as possible. We don't provide any refund for all problems which are originated from Payments API (Paypal, Instamojo, Payu, Stripe)") }}.
                      </span> 
                     
                     <hr>
                    <div class="custom-control custom-checkbox">
                      <input required="" type="checkbox" class="custom-control-input" id="customCheck1" name="eula"/>
                      <label class="custom-control-label" for="customCheck1"><b>{{ __('I read the terms and condition carefully and I agree on it') }}.</b></label>
                    </div>
                   </div>
                  </div>
                  
                <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Installation') }}...</button>
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | <a class="text-white" href="http://mediacity.co.in">{{ __('Media City') }}</a></p>
   		</div>
      
      <div class="corner-ribbon bottom-right sticky green shadow">{{ __('EULA') }} </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('front/vendor/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/additional-methods.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/shards.min.js') }}"></script>
    <script>var baseUrl= "<?= url('/') ?>";</script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    @notify_js
    @notify_render
</body>
</html>