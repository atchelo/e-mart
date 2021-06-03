@extends("front/layout.master")
@section('title','Register to continue |')
@section("body")
    <div class="body-content">
    <div class="container">
        <div class="sign-in-page">
            <div class="row">

<form class="register-form outer-top-xs" role="form" method="POST" action="{{ route('storeuserfromchwindow') }}">
       @csrf
<!-- create a new account -->
<div class="col-md-6 col-sm-6 create-new-account">
    <h4 class="checkout-subtitle">{{ __('Create a new account to continue') }}...</h4>
    <p class="text title-tag-line">{{ __('staticwords.Createanewaccount') }}.</p>
    
        <div class="form-group">
            <label class="info-title" for="exampleInputEmail2">{{ __('E-Mail Address') }}<span>*</span></label>
            <input value="{{ old('email') }}" type="email" class="form-control unicase-form-control text-input {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" required autofocus >

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="info-title" for="exampleInputEmail1">{{ __('Name') }}<span>*</span></label>
            <input name="name" type="text" value="{{ old('name') }}" class="form-control unicase-form-control text-input{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" >

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="info-title" for="exampleInputEmail1">{{ __('Phone Number') }} <span>*</span></label>
            <input value="{{ old('mobile') }}" type="text" class="form-control unicase-form-control text-input{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="phone" value="{{ old('address') }}" required>

             @if ($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
            @endif
        </div>

        <div class="form-group">
            <label class="info-title" for="exampleInputEmail1">{{ __('Password') }} <span>*</span></label>
            <input type="password" id="password" class="form-control unicase-form-control text-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
            @endif
        </div>

         <div class="form-group">
            <label class="info-title" for="exampleInputEmail1">{{ __('Confirm Password') }} <span>*</span></label>
            <input type="password" name="password_confirmation" id="password-confirm" class="form-control unicase-form-control text-input" required/>
        </div>

        <div class="form-group">
            <label class="info-title" for="country_id">{{ __('staticwords.PleaseChooseCountry') }}: <span>*</span></label>
            <select required="" class="form-control" name="country_id" id="country_id">
                <option value="">{{ __('staticwords.PleaseChooseCountry') }}</option>
                @foreach(App\Allcountry::all() as $country)
                    <option value="{{ $country->id }}">{{ $country->nicename }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
             <label class="info-title" for="state_id">{{ __('staticwords.PleaseChooseState') }}: <span>*</span></label>
            <select class="form-control" required="" name="state_id" id="upload_id">
                <option value="">{{ __('staticwords.PleaseChooseState') }}</option>
            </select>
        </div>

        <div class="form-group">
            <label class="info-title" for="city_id">{{ __('staticwords.PleaseChooseCity') }}: <span>*</span></label>
            <select class="form-control" required="" name="city_id" id="city_id">
                <option value="">{{ __('staticwords.PleaseChooseCity') }}</option>
            </select>
        </div>

          
</div>  

<div  class="col-md-6 col-sm-6 create-new-account">
    <h4 class="checkout-subtitle">&nbsp;</h4>
    <p class="text title-tag-line"></p>
    
                 <canvas id="canvas" class="canvas-block"></canvas>
              
</div>


<div class="col-md-12">
  <button type="submit" class="btn-upper btn btn-primary checkout-page-button">{{ __('Register') }}</button>  
</div>
 
    </form>
        </div>
      </div>
  </div>
</div><!-- /.body-content -->
@endsection
@section('script')
    <script>var baseUrl = "<?= url('/') ?>";</script>
    <script src="{{ url('js/ajaxlocationlist.js') }}"></script>
@endsection
