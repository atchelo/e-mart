<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/vendor/shards.min.css') }}">
    <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ url('css/install.css') }}">
    <link rel="stylesheet" href="{{ url('vendor/mckenziearts/laravel-notify/css/notify.css') }}">
    <title>{{ __('Installing App - Step 2 - Database Details') }}</title>
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
                  {{ __('Welcome To Setup Wizard - Setting Up Database') }}
              </h3>
          </div>
          <div class="card-body" id="stepbox">

            <form autocomplete="off" action="{{ route('store.step2') }}" id="step2form" method="POST" class="needs-validation" novalidate>
           @csrf
          <h3>{{ __('Database Details') }}</h3>
          <hr>
  <div class="form-row">
        <br>
        <div class="col-md-6 mb-3">
             <label for="DB_HOST">{{ __('Database Host') }}: <small class="text-muted">({{ __('ex: localhost,127.0.0.1') }})</small></label>
             <input name="DB_HOST" type="text" class="form-control" id="DB_HOST" placeholder="localhost" value="{{ env('DB_HOST') != '' ? env('DB_HOST') : old('DB_HOST') }}" required>
            
            <div class="invalid-feedback">
                {{ __('Please enter a datbase host name.') }}
            </div>
        </div>

        <div class="col-md-6 mb-3">
             <label for="DB_PORT">{{ __('Database Port') }}:</label>
             <input name="DB_PORT" type="text" class="form-control" id="DB_PORT" placeholder="3306" value="{{ env('DB_PORT') }}" required>
            
            <div class="invalid-feedback">
                {{ __('Please enter a database port.') }}
            </div>
        </div>

        <div class="col-md-6 mb-3">
             <label for="DB_DATABASE">{{ __('Database Name') }}:</label>
             <input name="DB_DATABASE" type="text" class="form-control" id="DB_DATABASE" placeholder="db_name" value="{{ env('DB_DATABASE') != '' ? env('DB_DATABASE') : old('DB_DATABASE') }}" required>
            
            <div class="invalid-feedback">
               {{ __(' Please enter a database name.') }}
            </div>
        </div>

        <div class="col-md-6 mb-3">
             <label for="DB_USERNAME">{{ __('Database Username') }}:</label>
             <input name="DB_USERNAME" type="text" class="form-control" id="DB_USERNAME" placeholder="root" value="{{ env('DB_USERNAME') !='' ? env('DB_USERNAME') : old('DB_USERNAME') }}" required>
            
            <div class="invalid-feedback">
                {{ __('Please enter a datbase username.') }}
            </div>
        </div>

        <div class="eyeCy col-md-6 mb-3">
             <label for="DB_PASSWORD">{{ __('Database Password') }}:</label>
             <input name="DB_PASSWORD" type="password" class="form-control" id="DB_PASSWORD" placeholder="*****" value="{{ env('DB_PASSWORD') }}">
              <span toggle="#DB_PASSWORD" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
            <div class="valid-feedback">
                  {{ __('Password can be blank if you testing it on localhost !') }}
             </div>
        </div>



  </div>

  <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Step 3') }}...</button>

</form>

              
          </div>
        </div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | <a class="text-white" href="http://mediacity.co.in">{{ __('Media City') }}</a></p>
      </div>
      
      <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Step 2') }} </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    <script src="{{ url('front/vendor/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/additional-methods.min.js') }}"></script>
    <!-- Essential JS UI widget -->
    <script src="{{ url('front/vendor/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/popper.min.js') }}"></script>
   
    <script src="{{ url('front/vendor/js/shards.min.js') }}"></script>
    <script>var baseUrl= "<?= url('/') ?>";</script>
    
     @notify_js
      @notify_render

</body>
</html>