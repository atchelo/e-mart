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
    <link href="{{ url('css/vendor/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
    <title>
      {{ __('Installing App - Step 5 - Store Creation') }}
    </title>
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
                  {{ __('Welcome To Setup Wizard - Store Setup') }}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">

            <form autocomplete="off" enctype="multipart/form-data" action="{{ route('store.step5') }}" id="step5form" method="POST" class="database-validation" novalidate>
           @csrf
          <h3>
            {{ __('Store Details') }}
          </h3>
          <hr>
  <div class="form-row">
        <br>
        <div class="col-md-4 mb-3">
             <label for="store_name">{{ __('Store name') }}:</label>
             <input name="store_name" type="text" class="form-control" id="store_name" placeholder="{{ __('Please enter store name') }}" value="{{ old('store_name') }}" required>
            
            <div class="invalid-feedback">
                {{ __('Please enter store name.') }}
            </div>
        </div>

        <div class="col-md-4 mb-3">
             <label for="mobile">{{ __('Contact No') }}:</label>
             <input pattern="[0-9]+" title="Enter valid contact no." name="mobile" type="text" class="form-control" id="mobile" placeholder="{{ __('Please enter contact no') }}" value="{{ old('mobile') }}" required>
            
            <div class="invalid-feedback">
                {{ __('Please enter contact no.') }}
            </div>
        </div>

        <div class="col-md-4 mb-3">
          <label for="email">{{ __('Contact Email') }}:</label>
             <input name="email" type="email" class="form-control" id="email" placeholder="user@info.com" value="{{ old('email') }}" required>
            
            <div class="invalid-feedback">
                {{ __('Please enter contact email.') }}
            </div>
        </div>

        <div class="col-md-6 mb-3">
             <label for="address">{{ __('Store Address') }}:</label>
             <textarea rows="4" name="address" type="text" class="form-control" placeholder="{{ __('Please enter store address') }}" value="" required>{{ old('address') }}</textarea>
            
            <div class="invalid-feedback">
                {{ __('Please enter store address.') }}
            </div>
        </div>

        <div class="col-md-6 mb-3">
          <label for="pincode">{{ __('Pincode') }}:</label>
             <input title="Enter valid pincode" pattern="[0-9]+" name="pincode" type="text" class="form-control" id="pincode" placeholder="111111" value="{{ old('pincode') }}" required>
            
            <div class="invalid-feedback">
                {{ __('Please enter Pincode.') }}
            </div>
           
             
        </div>
        
        <div class="col-md-6 mb-3">
             <label for="storelogo">{{ __('Store Logo') }}:</label>
             <input name="storelogo" type="file" class="form-control @error('storelogo') is-invalid @enderror" id="logo" />
            
              @error('storelogo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
        </div>

        <div class="col-md-6 mb-3">
          <p>{{ __('Logo Preview') }}:</p>
          <img id="logo-prev" align="center" width="150" height="150" src="" alt="">
        </div>

        <div class="col-md-4 mb-3">
                      
                    <label class="info-title" for="country_id">{{ __('Choose Country') }}:</label>
                    <select required class="js-example-basic-single form-control" name="country_id" id="country_id">
                        <option value="">{{ __('Choose Country') }}</option>
                        @foreach(App\Allcountry::all() as $country)
                            <option value="{{ $country->id }}">{{ $country->nicename }}</option>
                        @endforeach
                    </select>
                    
                   </div>

                   <div class="col-md-4 mb-3">
                       <label class="info-title" for="state_id">{{ __('Choose State') }}:</label>
                        <select class="js-example-basic-single form-control" required name="state_id" id="upload_id">
                            <option value="">{{ __('Please Choose') }}</option>
                        </select>
                   </div>

                   <div class="col-md-4 mb-3">
                       <label class="info-title" for="city_id">{{ __('Choose City') }}:</label>
                        <select class="js-example-basic-single form-control" required name="city_id" id="city_id">
                            <option value="">{{ __('Please Choose') }}</option>
                        </select>
                   </div>
    



  </div>

  <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Finish') }}...</button>

</form>

              
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | <a class="text-white" href="http://mediacity.co.in">{{ __('Media City') }}</a></p>
   		</div>
      
      <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Final Phase') }} </div>
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
    <script>var baseUrl = "<?= url('/') ?>";</script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    <script>var baseUrl = "<?= url('/') ?>";</script>
    <script src="{{ url('js/ajaxlocationlist.js') }}"></script>
    @notify_js
    @notify_render
</body>
</html>