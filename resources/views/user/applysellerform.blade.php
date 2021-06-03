<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(isset($selected_language) && $selected_language->rtl_available == 1) dir="rtl" @endif>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="Description" content="{{$seoset->metadata_des}}" />
  <meta name="keyword" content="{{ $seoset->metadata_key }}">
  <meta name="robots" content="all">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta name="theme-color" content="#157ED2">
  <title>{{ __('staticwords.ApplyForSeller') }} - {{ $title}}</title>
  <!-- Favicon -->
  <link rel="icon" href="{{url('images/genral/'.$fevicon)}}" type="image/png" sizes="16x16">
  <!-- Google Fonts -->
  <link href="//fonts.googleapis.com/css?family=Barlow:200,300,300i,400,400i,500,500i,600,700,800" rel="stylesheet">
  <link href='//fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800'
    rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <!-- Bootstrap Core CSS -->
  <link rel="stylesheet" href="{{ url('css/vendor/select2.min.css') }}" />

  <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ url('css/vendor/jquery-ui.min.css') }}">
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', '{{ $seoset->google_analysis }}');
  </script>
  <script>
    var isIE = !!window.MSInputMethodContext && !!document.documentMode;
    var isFirefox = navigator.userAgent.toLowerCase().indexOf("firefox") > -1;

    if (isIE || isFirefox) {
      var pageStylesheet = document.createElement("link");
      pageStylesheet.rel = "stylesheet";
      pageStylesheet.type = "text/css";
      pageStylesheet.href = "{{ url('css/user-style.min.css') }}";
      document.head.appendChild(pageStylesheet);
    }
  </script>
  <style>
    /*custom font*/
    /* @import url(https://fonts.googleapis.com/css?family=Montserrat); */

    /*basic reset*/
    * {
      margin: 0;
      padding: 0;
    }

    html {
      height: 100%;
      background: #157ed2;
      /* fallback for old browsers */
      background: -webkit-linear-gradient(to left, #6441A5, #2a0845);
      /* Chrome 10-25, Safari 5.1-6 */
    }

    body {
      font-family: Barlow, Roboto, Montserrat;
      background: transparent;
    }

    /*form styles*/
    #sellerform {
      position: relative;
      margin-top: 30px;
    }

    .error {
      color: red;
    }

    #sellerform fieldset {
      background: white;
      border: 0 none;
      border-radius: 0px;
      box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
      padding: 20px 30px;
      box-sizing: border-box;
      width: 80%;
      margin: 0 10%;

      /*stacking fieldsets above each other*/
      position: relative;
    }

    /*Hide all except first fieldset*/
    #sellerform fieldset:not(:first-of-type) {
      display: none;
    }

    /*inputs*/
    #sellerform input[type="text"],
    input[type="email"],
    #sellerform textarea {
      padding: 15px;
      border: 1px solid #ccc;
      border-radius: 0px;
      margin-bottom: 10px;
      width: 100%;
      box-sizing: border-box;
      font-family: montserrat;
      color: #2C3E50;
      font-size: 13px;
    }

    #sellerform input:focus,
    #sellerform textarea:focus {
      -moz-box-shadow: none !important;
      -webkit-box-shadow: none !important;
      box-shadow: none !important;
      border: 1px solid #fdd922;
      outline-width: 0;
      transition: All 0.5s ease-in;
      -webkit-transition: All 0.5s ease-in;
      -moz-transition: All 0.5s ease-in;
      -o-transition: All 0.5s ease-in;
    }

    /*buttons*/
    #sellerform .action-button {
      width: 100px;
      background: #fdd922;
      font-weight: bold;
      color: #111;
      border: 0 none;
      border-radius: 25px;
      cursor: pointer;
      padding: 10px 5px;
      margin: 10px 5px;
    }

    #sellerform .action-button:hover,
    #sellerform .action-button:focus {
      box-shadow: 0 0 0 2px white, 0 0 0 3px #fdd922;
    }

    #sellerform .action-button-previous {
      width: 100px;
      background: #C5C5F1;
      font-weight: bold;
      color: white;
      border: 0 none;
      border-radius: 25px;
      cursor: pointer;
      padding: 10px 5px;
      margin: 10px 5px;
    }

    #sellerform .action-button-previous:hover,
    #sellerform .action-button-previous:focus {
      box-shadow: 0 0 0 2px white, 0 0 0 3px #C5C5F1;
    }

    /*headings*/
    .fs-title {
      font-size: 18px;
      text-transform: uppercase;
      color: #2C3E50;
      margin-bottom: 10px;
      letter-spacing: 2px;
      font-weight: bold;
    }

    .fs-subtitle {
      font-weight: normal;
      font-size: 13px;
      color: #666;
      margin-bottom: 20px;
    }

    /*progressbar*/
    #progressbar {
      margin-bottom: 30px;
      overflow: hidden;
      /*CSS counters to number the steps*/
      counter-reset: step;
    }

    #progressbar li {
      list-style-type: none;
      color: white;
      text-transform: uppercase;
      font-size: 9px;
      width: 25%;
      float: left;
      position: relative;
      letter-spacing: 1px;
      text-align: center;
    }

    #progressbar li:before {
      content: counter(step);
      counter-increment: step;
      width: 24px;
      height: 24px;
      line-height: 26px;
      display: block;
      font-size: 12px;
      color: #333;
      background: white;
      border-radius: 25px;
      margin: 0 auto 10px auto;
    }

    /*progressbar connectors*/
    #progressbar li:after {
      content: '';
      width: 100%;
      height: 2px;
      background: white;
      position: absolute;
      left: -50%;
      top: 9px;
      z-index: -1;
      /*put it behind the numbers*/
    }

    #progressbar li:first-child:after {
      /*connector not needed before the first step*/
      content: none;
    }

    /*marking active/completed steps green*/
    /*The number of the step and the connector before it = green*/
    #progressbar li.active:before,
    #progressbar li.active:after {
      background: #fdd922;
      color: #111;
    }


    /* Not relevant to this form */
    .dme_link {
      margin-top: 30px;
      text-align: center;
    }

    .dme_link a {
      background: #FFF;
      font-weight: bold;
      color: #ee0979;
      border: 0 none;
      border-radius: 25px;
      cursor: pointer;
      padding: 5px 25px;
      font-size: 12px;
    }

    .dme_link a:hover,
    .dme_link a:focus {
      background: #C5C5F1;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <!-- MultiStep Form -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <br>
        <h2 class="text-center text-light">{{ __('staticwords.ApplyForSeller') }}</h2>
        <form id="sellerform" novalidate class="form" method="post" enctype="multipart/form-data"
          action="{{route('apply.seller.store')}}">

          @csrf
          <!-- progressbar -->
          <ul id="progressbar">
            <li class="active">{{ __('staticwords.Agreement') }}</li>
            <li>{{ __('staticwords.StoreInformation') }}</li>
            <li>{{ __('staticwords.PaymentDetails') }}</li>
            <li>{{ __('staticwords.Submit') }}</li>
          </ul>
          <!-- fieldsets -->
          <fieldset>
            <h2 class="fs-title">{{ isset($sellerterm) ? $sellerterm->title : __('staticwords.Agreement') }}</h2>
            <h3 class="fs-subtitle">{{ __('staticwords.SellerAgreement') }}</h3>
            <hr>

            <div style="max-height:400px;overflow:scroll">
              {!! $sellerterm->description !!}
            </div>
            <hr>
            <label class="font-weight-bold"><input {{ old('eula') ? "checked" : "" }} required type="checkbox"
                name="eula"> {{ __('staticwords.IAgree') }}</label>

            <div class="errorTxt"></div>
            <input type="button" name="next" class="next action-button" value="Next" />
          </fieldset>
          <fieldset>
            <h2 class="fs-title">{{ __('staticwords.StoreInformation') }}</h2>
            <h3 class="fs-subtitle">{{ __('staticwords.TellAboutStore') }}</h3>

            <label class="float-left">{{ __('staticwords.StoreName') }}: <small class="text-danger">*</small></label>
            <input class="@error('name') is-invalid @enderror" value="{{ old('name') }}"
              title="{{ __('staticwords.Pleaseenterstorename') }}" required type="text" name="name"
              placeholder="{{ __('staticwords.Pleaseenterstorename') }}" />
            <div class="errorTxt"></div>
            @error('name')
            <span class="invalid-feedback text-danger" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label class="float-left">{{ __('staticwords.Email') }}: <small class="text-danger">*</small></label>
            <input class="@error('email') is-invalid @enderror" title="Please enter valid email" required name="email"
              type="email" value="{{old('email')}}" placeholder="{{ __('staticwords.eaddress') }}">
            <div class="errorTxt"></div>
            @error('email')
            <span class="invalid-feedback text-danger" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label class="float-left">{{ __('staticwords.MobileNo') }} <small class="text-danger">*</small></label>
            <input class="@error('mobile') is-invalid @enderror" required name="mobile" pattern="[0-9]+" type="text"
              value="{{old('mobile')}}" placeholder="{{ __('staticwords.PleaseEnterMobileNo') }}"
              title="{{ __('staticwords.PleaseEnterMobileNo') }}">
            <div class="errorTxt"></div>
            @error('mobile')
            <span class="invalid-feedback text-danger" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="form-group">
              <label class="float-left">{{ __('staticwords.Country') }}: <small class="text-danger">*</small></label>
              <select title="Please select country" required name="country_id"
                class="@error('country_id') is-invalid @enderror form-control select2" id="country_id">
                <option value="">{{ __('staticwords.PleaseChooseCountry') }}</option> @foreach($country as
                $c)
                <?php
                  $iso3 = $c->country;

                  $country_name = DB::table('allcountry')->
                  where('iso3',$iso3)->first();
                ?>
                <option value="{{$country_name->id}}" /> {{$country_name->nicename}} </option> @endforeach
              </select>
              <div class="errorTxt"></div>
              @error('country_id')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group">
              <label class="float-left">{{ __('staticwords.State') }} <small class="text-danger">*</small></label>
              <select title="Please select state" required name="state_id"
                class="@error('state_id') is-invalid @enderror form-control select2" id="upload_id">
                <option value="">{{ __('staticwords.PleaseChooseState') }}</option>
              </select>
              <div class="errorTxt"></div>
              @error('state_id')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group">
              <label class="float-left">{{ __('staticwords.City') }} <small class="text-danger">*</small></label>
              <select title="Please select city" required name="city_id" id="city_id"
                class="@error('city_id') is-invalid @enderror form-control select2">
                <option value="">{{ __('staticwords.PleaseChooseCity') }}</option>
              </select>
              <div class="errorTxt"></div>
              @error('city_id')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group">
              <label>{{ __('staticwords.StoreAddress') }} <small class="text-danger">*</small></label>
              <textarea class="@error('address') is-invalid @enderror"
                title="{{ __('staticwords.PleaseEnterStoreAddress') }}" required
                placeholder="{{ __('staticwords.PleaseEnterStoreAddress') }}" name="address" id="" cols="30"
                rows="3">{{old('address')}}</textarea>
              <div class="errorTxt"></div>
              @error('address')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group">
              <label>{{ __('staticwords.PleaseChooseStoreLogo') }}:</label>
              <br>
              <input type="file" name="store_logo" class="form-control @error('store_logo') is-invalid @enderror">
              @error('store_logo')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group">
              <label>{{ __('staticwords.Document') }}: <span class="text-danger">*</span></label>
              <br>
              <input type="file" name="document" class="form-control @error('document') is-invalid @enderror">
              <small class="text-muted">
                  • {{__("Allowed file type : jpeg,png,webp")}}
                  <br>
                  • {{__("Max file size : 2MB")}}
              </small>
              @error('document')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
          </fieldset>
          <fieldset>
            <h2 class="fs-title">{{ __('staticwords.PaymentDetails') }}</h2>
            <h3 class="fs-subtitle">Your prefered method at time of payout</h3>


            <div class="form-group">
              <label class="float-left">{{ __('staticwords.vat') }} <small class="text-danger">*</small></label>
              <input class="@error('vat_no') is-invalid @enderror" required name="vat_no" type="text"
                value="{{old('vat_no')}}" placeholder="{{ __('staticwords.PleaseEntervat') }}"
                title="{{ __('staticwords.PleaseEntervat') }}">
              <div class="errorTxt"></div>
              @error('vat_no')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group">
              <label>{{ __('staticwords.PreferredPaymentMethod') }} <span class="text-danger">*</span></label>
              <select required name="preferd" id="preferd"
                class="preferd form-control @error('preferd') is-invalid @enderror">
                <option value="">{{ __('staticwords.PleaseChoosePreferredPaymentmethod') }}</option>
                <option value="paypal">{{ __('Paypal') }}</option>
                <option value="paytm">{{ __('Paytm') }}</option>
                <option value="bank">{{ __('Bank Transfer') }}</option>
              </select>

              @error('preferd')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="paypalBox form-group">
              <label>Paypal Email:</label>
              <input name="paypal_email" type="text" placeholder="{{ __('staticwords.paypalemail') }}">
            </div>

            <div style="display: none;" class="paytmBox form-group">
              <label>Paytm Mobile No:</label>
              <input type="text" placeholder="{{ __('staticwords.PaytmMobile') }}" name="paytem_mobile">
            </div>

            <div style="display: none;" class="bankGroup">
              <div class="form-group">
                <label>{{ __('staticwords.AccountNumber') }}</label>
                <input pattern="[0-9]+" title="Invalid account no." type="text" name="account"
                  value="{{old('account')}}" placeholder="{{ __('staticwords.PleaseEnterAccountNumber') }}"> <span
                  class="required">{{$errors->first('account')}}</span>
              </div>

              <div class="form-group">
                <label>{{ __('staticwords.AccountName') }}:</label>
                <input type="text" name="account_name" value="{{old('account_name')}}"
                  placeholder="{{ __('staticwords.PleaseEnterAccountName') }}"> <span
                  class="required">{{$errors->first('bank_name')}}</span>
              </div>

              <div class="form-group">
                <label> {{ __('staticwords.BankName') }}:</label>
                <input type="text" name="bank_name" value="{{old('bank_name')}}"
                  placeholder="{{ __('staticwords.PleaseEnterBankName') }}"> <span
                  class="required">{{$errors->first('bank_name')}}</span>
              </div>

              <div class="form-group">
                <label> {{ __('IFSC Code') }}:</label>
                <input type="text" name="ifsc" value="{{old('ifsc')}}"
                  placeholder="{{ __('staticwords.PleaseEnterIFSCCode') }}"> <span
                  class="required">{{$errors->first('ifsc')}}</span>
              </div>

              <div class="form-group">
                <label>{{ __('staticwords.BranchAddress') }}: </label>
                <input type="text" id="first-name" name="branch" placeholder="Please Enter Branch Address"
                  value="{{old('branch')}}">
                <span class="required">{{$errors->first('branch')}}</span>
              </div>
            </div>

            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
          </fieldset>

          <fieldset>
            <h2 class="fs-title">{{ __('staticwords.Declaration') }}</h2>
            <hr>
            <div class="form-group">
              <label>
                <input type="checkbox" name="declare" required>
                <b>{{ __('staticwords.declaretext') }} !</b>
              </label>
            </div>
            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
            <input type="submit" name="submit" class="submit action-button" value="Submit" />
          </fieldset>
        </form>

      </div>
    </div>
  </div>
  <p class="text-center text-white ">&copy; {{ date('Y') }} | {{ $title }} | @if(isset($Copyright))
    {{ $Copyright }}@endif</p>
  <div class="text-center">
    <a href="{{ url('/') }}"><img width="100px" title="{{ $title }}" src="{{url('images/genral/'.$front_logo)}}"
        alt="logo" class="img-fluid"></a>
  </div>
  <br>
  <!-- /.MultiStep Form -->
</body>
<!-- Bootstrap JS -->
<!-- jQuery 3.5.4 -->
<script src="{{url('js/jquery.min.js')}}"></script>
<!-- Select2 JS -->
<script src="{{ url('front/vendor/js/select2.min.js') }}"></script>
<script src="{{url('/js/bootstrap.bundle.min.js')}}"></script>
<!-- jQuery UI JS -->
<script src="{{ url('admindesk/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ url('front/vendor/js/jquery.validate.min.js') }}"></script>
<script src="{{ url('front/vendor/js/additional-methods.min.js') }}"></script>
<script>
  //jQuery time
  var current_fs, next_fs, previous_fs; //fieldsets
  var left, opacity, scale; //fieldset properties which we will animate
  var animating; //flag to prevent quick multi-click glitches

  $(".next").click(function () {

    if ($('#sellerform').valid()) {
      if (animating) return false;
      animating = true;

      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      //activate next step on progressbar using the index of next_fs
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate({
        opacity: 0
      }, {
        step: function (now, mx) {
          //as the opacity of current_fs reduces to 0 - stored in "now"
          //1. scale current_fs down to 80%
          scale = 1 - (1 - now) * 0.2;
          //2. bring next_fs from the right(50%)
          left = (now * 50) + "%";
          //3. increase opacity of next_fs to 1 as it moves in
          opacity = 1 - now;
          current_fs.css({
            'transform': 'scale(' + scale + ')',
            'position': 'absolute'
          });
          next_fs.css({
            'left': left,
            'opacity': opacity
          });
        },
        duration: 800,
        complete: function () {
          current_fs.hide();
          animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
      });
    }

  });

  $(".previous").click(function () {
    if (animating) return false;
    animating = true;

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //de-activate current step on progressbar
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate({
      opacity: 0
    }, {
      step: function (now, mx) {
        //as the opacity of current_fs reduces to 0 - stored in "now"
        //1. scale previous_fs from 80% to 100%
        scale = 0.8 + (1 - now) * 0.2;
        //2. take current_fs to the right(50%) - from 0%
        left = ((1 - now) * 50) + "%";
        //3. increase opacity of previous_fs to 1 as it moves in
        opacity = 1 - now;
        current_fs.css({
          'left': left
        });
        previous_fs.css({
          'transform': 'scale(' + scale + ')',
          'opacity': opacity
        });
      },
      duration: 800,
      complete: function () {
        current_fs.hide();
        animating = false;
      },
      //this comes from the custom easing plugin
      easing: 'easeInOutBack'
    });
  });

  $(".submit").click(function () {
    return true;
  });

  $('.select2').select2({
    placeholder: "Search...",
    allowClear: true,
    width: '100%'
  });
</script>
<script>
  var baseUrl = "<?= url('/') ?>";
</script>
<script defer src="{{ url('js/ajaxlocationlist.js') }}"></script>
<script>
  jQuery(function ($) {
    var validator = $('form').validate({
      rules: {
        first: {
          required: true
        },
        second: {
          required: true
        }
      },
      messages: {},
      errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error)
        } else {
          error.insertAfter(element);
        }
      }
    });
  });

  $('.preferd').on('change', function () {

    var val = $(this).val();

    if (val == 'bank') {
      $('.bankGroup').show();
      $('.paypalBox').hide();
      $('.paytmBox').hide();
    }

    if (val == 'paytm') {
      $('.bankGroup').hide();
      $('.paypalBox').hide();
      $('.paytmBox').show();
    }

    if (val == 'paypal') {
      $('.bankGroup').hide();
      $('.paypalBox').show();
      $('.paytmBox').hide();
    }

  });
</script>

</html>