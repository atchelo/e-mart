<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/vendor/shards.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/install.css') }}">
    <link rel="stylesheet" href="{{ url('vendor/mckenziearts/laravel-notify/css/notify.css') }}">
    <title>{{ __('Installing App - Step 1 - Basic Details') }}</title>
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
                  {{ __('Welcome To Setup Wizard') }}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form autocomplete="off" action="{{ route('store.step1') }}" id="step1form" method="POST" class="needs-validation" novalidate>
                  @csrf
                   <h3>{{ __('Basic Details') }}</h3>
                   <hr>
                  <div class="form-row">
                   
                    <br>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('App/Project Name') }}:</label>
                      <input pattern="[^' ']+" title="Make sure project name not contain any white space" name="APP_NAME" type="text" class="form-control" id="validationCustom01" placeholder="Project Name" value="{{ env('APP_NAME') }}" required>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                      <div class="invalid-feedback">
                          {{ __('Please choose a app name.') }}
                      </div>
                    </div>
                    
                     <div class="col-md-6 mb-3">
                      <label for="validationCustom01">App URL:</label>
                      <input name="APP_URL" type="url" class="form-control" id="validationCustom01" placeholder="http://" value="{{ env('APP_URL') }}" required>
                      <div class="valid-feedback">
                       {{ __(' Looks good!') }}
                      </div>
                      <div class="invalid-feedback">
                          {{ __('Please enter app url.') }}
                      </div>
                    </div>
                    
                  </div>
                  <h3>{{ __('Mail Details') }}</h3>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom03">{{ __('Mail Sender Name') }}:</label>
                      <input pattern="[^' ']+" title="Make sure sender name not contain any white space" name="MAIL_FROM_NAME" type="text" class="form-control" id="validationCustom03" placeholder="John" required value="{{ env('MAIL_FROM_NAME') }}">
                      <div class="invalid-feedback">
                        {{ __('Please enter sender name.') }}
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom04">{{ __('Mail Address') }}:</label>
                      <input type="text" name="MAIL_FROM_ADDRESS" class="form-control" id="validationCustom04" placeholder="Please enter mail address" required value="{{ env('MAIL_FROM_ADDRESS') }}">
                      <div class="invalid-feedback">
                        {{ __('Please enter mail address.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Username') }}:</label>
                      <input name="MAIL_USERNAME" type="text" class="form-control" id="validationCustom05" placeholder="Please enter mail username" required value="{{ env('MAIL_USERNAME') }}">
                      <div class="invalid-feedback">
                        {{ __('Please enter mail username.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                    </div>

                     <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Password') }}:</label>
                      <input name="MAIL_PASSWORD" type="password" placeholder="*******" class="form-control" id="validationCustom06" required value="{{ env('MAIL_PASSWORD') }}">
                      <div class="invalid-feedback">
                        {{ __('Please enter mail password.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Host') }}: <small class="text-muted">({{ __('ex: smtp.gmail.com,smtp.mailtraip.io') }})</small></label>
                      <input name="MAIL_HOST" type="text" placeholder="smtp.mailtrap.io" class="form-control" id="validationCustom07" required value="{{ env('MAIL_HOST') }}">
                      <div class="invalid-feedback">
                        {{ __('Please enter mail host.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Port') }}: <small class="text-muted">({{ __('ex: 587,465') }})</small></label>
                      <input name="MAIL_PORT" type="text" placeholder="2525" class="form-control" id="validationCustom08" required value="{{ env('MAIL_PORT') }}">
                      <div class="invalid-feedback">
                        {{ __('Please enter mail port.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Driver') }}: <small class="text-muted">({{ __('ex: smtp,sendmail,mail') }})</small></label>
                      <input name="MAIL_DRIVER" type="text" placeholder="smtp" class="form-control" id="validationCustom09" required value="{{ env('MAIL_DRIVER') }}">
                      <div class="invalid-feedback">
                       {{ __(' Please enter mail driver.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Encryption') }}:</label>
                      <input name="MAIL_ENCRYPTION" type="text" placeholder="SSL/TLS" class="form-control" id="validationCustom10" value="{{ env('MAIL_ENCRYPTION') }}">
                      <div class="invalid-feedback">
                        {{ __('Please enter mail encryption.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                    </div>

                  </div>
                  
                <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Step 2') }}...</button>
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | <a class="text-white" href="http://mediacity.co.in">{{ __('Media City') }}</a></p>
   		</div>
      
      <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Step 1') }} </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('front/vendor/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/additional-methods.min.js') }}"></script>
    <!-- Essential JS UI widget -->
    <script src="{{ url('front/vendor/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/shards.min.js') }}"></script>
    <script>var baseUrl= "<?= url('/') ?>";</script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    <script src="{{ url('vendor/mckenziearts/laravel-notify/js/notify.js') }}"></script>
    @notify_js
    @notify_render
</body>
</html>