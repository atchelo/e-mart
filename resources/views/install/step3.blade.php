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
    <link rel="stylesheet" href="{{ url('css/bootstrap-iconpicker.min.css') }}">
    <link href="{{ url('css/vendor/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
    <title>{{ __('Installing App - Step 3 - Basic Settings') }}</title>

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
                  {{ __('Welcome To Setup Wizard - Basic Site Setting') }}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form autocomplete="off" enctype="multipart/form-data" action="{{ route('store.step3') }}" id="step3form" method="POST" class="needs-validation" novalidate>
                  @csrf
                   <h3>{{ __('Site Setting') }}</h3>
                   <hr>
                  <div class="form-row">
                   
                    <br>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('Project Title') }}:</label>
                      <input name="project_name" type="text" class="form-control" id="validationCustom01" placeholder="Project Name" value="" required>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                      <div class="invalid-feedback">
                          {{ __('Please enter project title.') }}
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="validationCustom02">{{ __('Default Email') }}:</label>
                      <input name="email" type="text" class="form-control" id="validationCustom02" placeholder="user@info.com" value="" required>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                      <div class="invalid-feedback">
                         {{ __(' Please enter email.') }}
                      </div>
                    </div>
                     
                  </div>
                
                  <hr>
                <div class="form-row">

                  <div class="col-md-4 mb-3">

                        <div class="form-group">
                          <label>{{ __('Select Currency icon') }}: </label>
                          <div class="input-group">
                            <input required="" value="fa fa-btc" type="text" class="form-control" id="iconvalue" name="currency_symbol">
                            <div class="input-group-append">
                                  <button class="btn btn-md btn-primary" id="iconpick"></button>
                            </div>
                          </div>
                        </div>

                        <div class="invalid-feedback">
                          {{ __('Please select currency icon.') }}
                        </div>
                        <div class="valid-feedback">
                          {{ __('Looks good!') }}
                        </div>

                    </div>
                    
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom05">{{ __('Choose Default Currency') }}: </label>
                      <select required class="currencyBox form-control js-example-basic-single" name="currency">
                          <option value="">{{ __('Please choose') }}</option>
                          @foreach(App\CurrencyList::all() as $currency)
                              <option value="{{ $currency->code }}">{{ $currency->code.' ('.$currency->country.')' }}</option>
                          @endforeach
                      </select>
                      <div class="invalid-feedback">
                       {{ __('Please select default currency.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                      <small class="text-danger help-block"><i class="fa fa-warning"></i> {{ __('This cant be changed in future') }} !</small>
                    </div>

                   
                     <div class="col-md-4 mb-3">
                      <label>{{ __('Choose Country') }}:</label>
                      <select required class="form-control countryBox" name="country" required>
                        <option value="">{{ __('Please choose country') }}</option>
                        @foreach(App\Allcountry::all() as $country)
                              <option value="{{ $country->iso3 }}">{{ $country->nicename}}</option>
                        @endforeach
                      </select>
                       <div class="invalid-feedback">
                        {{ __('Please select country.') }}
                      </div>
                       <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                     </div>

                    
    

                  </div>
                  
                <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Step 4') }}...</button>
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | <a class="text-white" href="http://mediacity.co.in">{{ __('Media City') }}</a></p>
   		</div>
      
      <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Step 3') }}</div>
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('front/vendor/js/bootstrap-iconpicker.min.js') }}"></script>
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