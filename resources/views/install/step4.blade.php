<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/vendor/shards.min.css') }}">
    <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ url('css/install.css') }}">
    <link rel="stylesheet" href="{{ url('vendor/mckenziearts/laravel-notify/css/notify.css') }}">
    <link href="{{ url('css/vendor/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
    <title>{{ __('Installing App - Step 4 - Creating Admin') }}</title>
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
                  {{ __('Welcome To Setup Wizard - Create Admin') }}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form autocomplete="off" enctype="multipart/form-data" action="{{ route('store.step4') }}" id="step4form" method="POST" class="needs-validation" novalidate>
                  @csrf
                   <h3>{{ __('Create Admin') }}</h3>
                   <hr>
                  <div class="form-row">
                   
                    <br>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('Please Enter Name') }}:</label>
                      <input value="{{ old('name') }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="validationCustom01" placeholder="{{ __('Enter Name') }}" value="" required>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                      @error('name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('Email') }}:</label>
                      <input value="{{ old('email') }}" name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="validationCustom01" placeholder="user@info.com" value="" required>
                       
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="eyeCy col-md-6 mb-3">
                       <label>{{ __('Password') }}:</label>
                       <input minlength="8" title="Password length must be 8 or more." type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="*****" required name="password">
                       <span toggle="#password" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                        @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="eyeCy col-md-6 mb-3">
                       <label>{{ __('Confirm Password') }}:</label>
                       <input minlength="8" title="Password length must be 8 or more." type="password" id="password_confirmation" class="form-control" placeholder="*****" required name="password_confirmation">
                       <span toggle="#password_confirmation" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                       <div class="invalid-feedback">
                          {{ __('Please confirm password') }}.
                      </div>
                    </div>

                     <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('Choose Profile Picture') }}:</label>
                      <input name="profile_photo" type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="logo" value="">
                       @error('profile_photo')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-6 p-3">
                       {{ __('Preview') }}:
                      <br>
                       <img id="logo-prev" align="center" width="150" height="150">
                    </div>

                    
                    
                  </div>
                 
                  <hr>
                <div class="form-row">
                    
                   <div class="col-md-4 mb-3">
                      
                    <label class="info-title" for="country_id">{{ __('Choose Country') }}:</label>
                    <select required class="js-example-basic-single form-control @error('country') is-invalid @enderror" name="country" id="country_id">
                        <option value="">{{ __('Choose Country') }}</option>
                        @foreach(App\Allcountry::all() as $country)
                            <option value="{{ $country->id }}">{{ $country->nicename }}</option>
                        @endforeach
                    </select>

                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                   </div>

                   <div class="col-md-4 mb-3">
                       <label class="info-title" for="state_id">{{ __('Choose State') }}:</label>
                        <select class="js-example-basic-single form-control @error('state_id') is-invalid @enderror" required name="state_id" id="upload_id">
                            <option value="">{{ __('Please Choose') }}</option>
                        </select>

                        @error('state_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                   </div>

                   <div class="col-md-4 mb-3">
                       <label class="info-title" for="city_id">{{ __('Choose City') }}:</label>
                        <select class="js-example-basic-single form-control @error('city_id') is-invalid @enderror" required name="city_id" id="city_id">
                            <option value="">
                              {{ __('Please Choose') }}
                            </option>
                        </select>

                        @error('city_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror

                   </div>
    

                  </div>
                  
                <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Step 5') }}...</button>
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | <a class="text-white" href="http://mediacity.co.in">
          {{ __('Media City') }}
        </a></p>
   		</div>
      
      <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Step 4') }} </div>
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('front/vendor/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/additional-methods.min.js') }}"></script>
<!-- Essential JS UI widget -->
    <script src="{{ url('front/vendor/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/shards.min.js') }}"></script>
    <script>var baseUrl = "<?= url('/') ?>";</script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    <script>var baseUrl = "<?= url('/') ?>";</script>
    <script src="{{ url('js/ajaxlocationlist.js') }}"></script>
    
    @notify_js
    @notify_render

</body>
</html>