<!DOCTYPE html>
<!--
**********************************************************************************************************
    Copyright (c) 2020-2021.
**********************************************************************************************************  -->
<!--
  Template Name: emart - Laravel Multi-Vendor Ecommerce Advanced CMS
  Version: 2.3.0
  Author: Media City
-->

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(isset($selected_language) && $selected_language->rtl_available == 1) dir="rtl" @endif>

<head>
  @if(env('GOOGLE_TAG_MANAGER_ID') != '' && env('GOOGLE_TAG_MANAGER_ENABLED') == true)
    @include('googletagmanager::head')
  @endif

  @if(env('FACEBOOK_PIXEL_ID') != '')
    @include('facebook-pixel::head')
  @endif
  
  <style>
        :root{
        --background_blue_bg_color: #108BEA;
        --background_dark_blue_bg_color:#157ed2;
        --background_light_blue_bg_color:#0f6cb2;
        --background_black_bg_color: #2E353B;
        --background_white_bg_color:#FFF;
        --background_grey_bg_color:#e9e9de;
        --background_yellow_bg_color:#fdd922;
        --background_green_bg_color:#157ed2;
        --background_pink_bg_color:#ff7878;
        --text_white_color:#FFF;
        --text_black_color: #333;
        --text_light_black_color:#666;
        --text_blue_color:#157ed2;
        --text_yellow_color: #FDD922;
        --text_grey_color:#9a9a9a;
        --text_dark_grey_color:#abafb1;
        --text_dark_blue_color: #147ED2;
        --text_green_color: #12CCA7;
        --text_pink_color:#000;
    }
    
    img.lazy :not(hover-image){
        background-image: url('//via.placeholder.com/200x200.png?text=loading');
        background-repeat: no-repeat;
        background-position: 50% 50%;
    }
      
  </style>

  <!-- jQuery 3.5.4 -->
  <script src="{{url('js/jquery.min.js')}}"></script>
  


  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="all">
  @yield('meta_tags')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Theme Header Color -->
  <meta name="theme-color" content="#157ED2">
  <title>@yield('title') {{ $title }} </title>
  <!-- END Fonts -->
  @if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' && env('PWA_ENABLE') == 1)
    @laravelPWA
  @endif
  <!-- Favicon -->
  <link rel="icon" href="{{url('images/genral/'.$fevicon)}}" type="image/png" sizes="16x16">
  <link rel="stylesheet" href="{{ url('css/theme.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ url('css/app.css') }}">
  <!-- Patterns -->
  @include('front.layout.patterns.pattern1')
  @include('front.layout.patterns.pattern2')
  @include('front.layout.patterns.pattern3')
  @include('front.layout.patterns.pattern4')
  @include('front.layout.patterns.pattern5')
  <!-- Pattern End -->
  @if(isset($selected_language) && $selected_language->rtl_available == 1)
    <!-- RTL -->
      <link type="text/css" rel="stylesheet" href="{{ url('css/rtl.css') }}" compile>
      <link rel="stylesheet" href="{{ url('css/navbar-rtl.css') }}">
    <!-- END -->
  @endif
  <link rel="stylesheet" href="{{ url("css/front.css") }}">
  <!-- Custom Css -->
  @if(file_exists(public_path().'/css/custom-style.css'))
    <link rel="stylesheet" type="text/css" href="{{url('css/custom-style.css')}}">
  @endif

  <script async src="//www.googletagmanager.com/gtag/js?id={{ $seoset->google_analysis }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', '{{ $seoset->google_analysis }}');
  </script>
   
  <!-- Laravel notify css -->
  @notify_css

  <!-- Custom script head -->
  @yield('head-script')
  <!-- Custom style head -->
  @yield('stylesheet')
</head>


<body class="cnt-home">

  @include('sweet::alert')

  
  <!-- preloader -->
  <div class="display-none payment-verify-preloader">
    <div class="payment">
      <div class="payment-message">
        <i class="fa fa-spinner fa-pulse fa-fw"></i> <span class="sr-only">{{ __('Loading') }}...</span>
        {{ __('staticwords.verifyPayment') }}
        <br>
        <div class="jsonstatus">

        </div>
      </div>
    </div>
  </div>
  

  @if(env("ENABLE_PRELOADER") == 1)
  <!-- preloader -->
    <div class="front-preloader">
      <div class="status">
        <div class="status-message">
          <img height="100px" src="{{url('images/preloader/preloader.png')}}" alt="preloader">
        </div>
      </div>
    </div>
  @endif
  <!-- form submit preloader -->
  <div class="display-none preL">
    <div class="display-none preloader3"></div>
  </div>

  <!-- ============================================== HEADER ============================================== -->
  <header class="header-style-main">
    @include('front.layout.header')
  </header>

  <!-- Main Body -->
   @yield('body')

  <!-- Main Body End -->

  <!-- ==================== FOOTER ======================== -->
  @if(!empty($footer ))
  <div class="row our-features-box">
    <div class="container">
      <ul>
        <li>
          <div class="feature-box">
            @if(isset($footer->icon_section1))<i class="footericon fa {{ $footer->icon_section1 }}"></i>@endif
            <p></p>
            <div class="content-blocks">{{ $footer->shiping }}</div>
          </div>
        </li>
        <li>
          <div class="feature-box">
            @if(isset($footer->icon_section2))<i class="footericon fa {{ $footer->icon_section2 }}"></i>@endif
            <p></p>
            <div class="content-blocks">
              {{ $footer->mobile }} </div>
          </div>
        </li>
        <li>
          <div class="feature-box">
            @if(isset($footer->icon_section3))<i class="footericon fa {{ $footer->icon_section3 }}"></i>@endif
            <p></p>
            <div class="content-blocks">{{ $footer->return }}</div>
          </div>
        </li>
        <li>
          <div class="feature-box">
            @if(isset($footer->icon_section4))<i class="footericon fa {{ $footer->icon_section4 }}"></i>@endif
            <p></p>
            <div class="content">{{ $footer->money }}</div>
          </div>
        </li>

      </ul>
    </div>
  </div>
  @endif
 
  @if(count($brands) > 0)
    <div id="brands-carousel" class="logo-slider logo-slider-one">
      <div class="logo-slider-inner">

        <div id="brand-slider" class="owl-carousel home-owl-carousel custom-carousel brand-slider {{ isset($selected_language) && $selected_language->rtl_available == 1 ? 'owl-rtl' : ''}}">
          @foreach($brands as $datas)
            <div class="item m-t-15"> 
                <a href="#" class="image">
                @if(file_exists(public_path().'/images/brands/'.$datas->image) && $datas->image != '')
                  <img class="owl-lazy" title="{{ $datas->name }}" width="100px" height="110px" data-src="{{url('images/brands/'.$datas->image)}}" alt="{{ $datas->name }}"> 
                @else
                  <img class="owl-lazy" title="{{ $datas->name }}" width="100px" height="110px" data-src="{{ Avatar::create($datas->name)->toBase64() }}" alt="{{ $datas->name }}"> 
                @endif
              </a>
            </div>
          @endforeach

        </div>
        <!-- /.owl-carousel #logo-slider -->
      </div>
      <!-- /.logo-slider-inner -->
    </div>
  @endif

  <div>
    @php
    $enable_newsletter_widget = App\Widgetsetting::where('name','newsletter')->first();
    @endphp

    @if($enable_newsletter_widget->home == '1' && isset($enable_newsletter_widget) || $enable_newsletter_widget->shop == "1")
    
      <div class="container p-5 newsletter-bg-custom">
        <div class="row">
            <div class="col-sm-12 col-md-7">
              <h2 class="text-white text-center">@lang("staticwords.newsletterheading")</h2>
              <h5 class="text-light text-center">@lang("staticwords.newsletterwords")</h5>
            </div>

            <div class="col-sm-12 col-md-5">
              <div class="form-group bg-white border rounded px-2 py-2 mb-2">
                <form method="post" action="{{url('newsletter')}}">
                  @csrf
                  <div class="row">
                    <div class="col"> 
                      <input required type="email" name="email" class="form-control pl-3 shadow-none bg-transparent border-0" placeholder="Enter your email address"> 
                    </div>
                    <div class="col-auto"> <button type="submit" class="text-white btn btn-block newsletter-bg-custom"><i class="fa fa-paper-plane-o mr-2"></i>Subscribe</button> </div>
                  </div>
                </form>
          
          </div>
            </div>

        </div>
      </div>

    @endif

    
  </div>

  <!-- /.logo-slider-end -->
  <footer id="footer" class="footer color-bg">
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="address-block">
              @if(isset($genrals_settings))
              <div class="module-body">
                <ul class="toggle-footer">
                  @if(!empty($genrals_settings->address))
                  <li class="media">
                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                          class="fa fa-map-marker fa-stack-1x fa-inverse"></i> </span> </div>
                    <div class="media-body">
                      <p>{{$genrals_settings->address}}</p>
                    </div>
                  </li>
                  @endif
                  @if(!empty($genrals_settings->mobile))
                  <li class="media">
                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                          class="fa fa-mobile fa-stack-1x fa-inverse"></i> </span> </div>
                    <div class="media-body">
                      <a href="tel:{{$genrals_settings->mobile}}" tiltle="Mobile No.">{{$genrals_settings->mobile}}</a>
                    </div>
                  </li>
                  @endif
                  @if(!empty($genrals_settings->email))
                  <li class="media">
                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                          class="fa fa-envelope fa-stack-1x fa-inverse"></i> </span> </div>
                    <div class="media-body"> <span><a href="mailto:{{$genrals_settings->email}}"
                          tiltle="E-Mail">{{$genrals_settings->email}}</a></span> </div>
                  </li>
                  @endif
                </ul>
              </div>
              @endif
            </div>
            <!-- /.module-body -->
          </div>
          <!-- /.col -->

          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="module-heading module-small-screen">
              <h4 class="module-title">{{ $footer3_widget->footer2 }}</h4>
            </div>
            <!-- /.module-heading -->

            <div class="module-body module-small-screen">
              <ul class='list-unstyled'>
                @if(Auth::check())

                <li class="first"><a href="{{url('profile')}}" title="My Account">{{ __('staticwords.MyAccount') }}</a>
                </li>
                <li><a href="{{url('order')}}" title="Order History">{{ __('staticwords.OrderHistory') }}</a></li>
                @endif
                <li><a href="{{url('faq')}}" title="Faq">{{ __('staticwords.faqs') }}</a></li>
                <li><a href="{{ route('contact.us') }}"
                  title="{{ __("staticwords.ContactUs") }}">{{ __('staticwords.ContactUs') }}</a>
                </li>
                @if(isset($genrals_settings) && $genrals_settings['vendor_enable'] == 1)
                  @if(Auth::check())
                    @if(Auth::user()->role_id != 'a' && !Auth::user()->store)
                      <li class="last"><a href="{{ route('applyforseller') }}"
                        title="{{ __('staticwords.ApplyforSellerAccount') }}">{{ __('staticwords.ApplyforSellerAccount') }}</a>
                      </li>
                    @endif
                  @else
                    <li class="last"><a href="{{ route('applyforseller') }}"
                      title="{{ __('staticwords.ApplyforSellerAccount') }}">{{ __('staticwords.ApplyforSellerAccount') }}</a>
                    </li>
                  @endif
                @endif
                <li class="last"><a href="{{ route('hdesk') }}"
                    title="{{ __('staticwords.HelpCenter') }}">{{ __('staticwords.HelpCenter') }}</a>
                </li>
                <li class="last"><a href="{{ route('track.order') }}"
                  title="{{ __("staticwords.TrackOrder") }}">{{ __('staticwords.TrackOrder') }}</a>
              </li>
              </ul>
            </div>
            <!-- /.module-body -->
          </div>

          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="module-heading module-small-screen">
              <h4 class="module-title">{{ $footer3_widget->footer3 }}</h4>
            </div>

            @foreach($widget3items as $foo)
            <div class="module-body module-small-screen">
              <ul class='list-unstyled'>
                <li class="first">

                  @if($foo->link_by == 'page')
                  <a title="{{ $foo->title }}" href="{{ route('page.slug',$foo->gotopage['slug']) }}">
                    {{ $foo->title }}
                  </a>
                  @else
                  <a target="__blank" title="{{ $foo->title }}" href="{{ $foo->url }}">
                    {{ $foo->title }}
                  </a>
                  @endif

                </li>
              </ul>
            </div>
            @endforeach
            <!-- /.module-body -->
          </div>
          <!-- /.col -->

          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="module-heading module-small-screen">
              <h4 class="module-title">{{ $footer3_widget->footer4 }}</h4>
            </div>

            @foreach($widget4items as $foo)
            <div class="module-body module-small-screen">
              <ul class='list-unstyled'>
                <li class="first">

                  @if($foo->link_by == 'page')
                  <a title="{{ $foo->title }}" href="{{ route('page.slug',$foo->gotopage['slug']) }}">
                    {{ $foo->title }}
                  </a>
                  @else
                  <a target="__blank" title="{{ $foo->title }}" href="{{ $foo->url }}">
                    {{ $foo->title }}
                  </a>
                  @endif

                </li>
              </ul>
            </div>
            @endforeach

            <!-- /.module-body -->
          </div>

        </div>
      </div>
    </div>
    <div class="copyright-bar header-nav-screen">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-4 col-lg-4 no-padding social">
            <ul class="link">
              @foreach($socials as $social)
              <li class="{{$social->icon}} pull-left"><a target="_blank" rel="nofollow" href="{{$social->url}}"></a>
              </li>
              @endforeach
            </ul>
          </div>
          <div class="col-xs-12 col-sm-4 col-lg-4 no-padding copyright">
            &copy; {{ date("Y") }} @if(isset($Copyright)) {{ $Copyright }}@endif
          </div>
          <div class="col-xs-12 col-sm-4 col-lg-4 no-padding">
            <div class="clearfix payment-methods">
              
                <div class="owl-carousel home-owl-carousel owl-theme  owl-loaded owl-drag">
                @if($Api_settings->paypal_enable=='1')
                <div class="payment-item">
                  <a title="Paypal" target="__blank" href="https://paypal.com"><img
                      data-src="{{ url('images/payment/paypal.png') }}" alt="Paypal" class="owl-lazy img-fluid"></a>
                </div>
                @endif


                @if($Api_settings->stripe_enable=='1')
                <div class="payment-item">
                  <a title="Stripe" target="__blank" href="https://stripe.com/"><img
                      data-src="{{ url('images/payment/stripe.png') }}" alt="Razorpay" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->braintree_enable=='1')
                <div class="payment-item">
                  <a title="Braintree" target="__blank" href="https://www.braintreepayments.com/"><img
                      data-src="{{ url('images/payment/braintree.png') }}" alt="Braintree" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->paystack_enable =='1')
                <div class="payment-item">
                  <a title="Paystack" target="__blank" href="https://paystack.com/"><img
                      data-src="{{ url('images/payment/paystack.png') }}" alt="Paystack" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->paytm_enable=='1')
                <div class="payment-item">
                  <a title="Paytm" target="__blank" href="https://paytm.com"><img
                      data-src="{{ url('images/payment/paytm.png') }}" alt="Paytm" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->razorpay=='1')
                <div class="payment-item">
                  <a title="Razorpay" target="__blank" href="https://razorpay.com/"><img
                      data-src="{{ url('images/payment/razorpay.png') }}" alt="Razorpay" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->instamojo_enable=='1')
                <div class="payment-item">
                  <a title="Instamojo" target="__blank" href="https://www.instamojo.com/"><img
                      data-src="{{ url('images/payment/instamojo.png') }}" alt="Razorpay" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->payu_enable=='1')
                <div class="payment-item">
                  <a title="PayUMoney" target="__blank" href="https://www.payu.in/"><img
                      data-src="{{ url('images/payment/payumoney.png') }}" alt="Razorpay" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->payhere_enable == '1')
                <div class="payment-item">
                  <a title="Payhere" target="__blank" href="https://www.payhere.lk/"><img
                      data-src="{{ url('images/payment/payhere.png') }}" alt="Payhere" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->omise_enable == '1')
                <div class="payment-item">
                  <a title="Omise" target="__blank" href="https://www.omise.co"><img data-src="{{ url('images/payment/omise.png') }}"
                      alt="omise" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->cashfree_enable == '1')
                <div class="payment-item">
                  <a title="Cashfree" target="__blank" href="https://www.cashfree.com/"><img
                      data-src="{{ url('images/payment/cashfree.png') }}" alt="cashfree" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->moli_enable == '1')
                <div class="payment-item">
                  <a title="mollie" target="__blank" href="https://www.mollie.com/en"><img
                      data-src="{{ url('images/payment/mollie.png') }}" alt="mollie" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->rave_enable == '1')
                <div class="payment-item">
                  <a title="Rave" target="__blank" href="https://dashboard.flutterwave.com/"><img
                      data-src="{{ url('images/payment/rave.png') }}" alt="rave" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->skrill_enable == '1')
                <div class="payment-item">
                  <a title="Skrill" target="__blank" href="https://www.skrill.com/"><img
                      data-src="{{ url('images/payment/skrill.png') }}" alt="skrill" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->sslcommerze_enable == '1')
                <div class="payment-item">
                  <a title="SSLCommerz" target="__blank" href="https://www.sslcommerz.com/"><img
                      data-src="{{ url('images/payment/sslcommerz.png') }}" alt="skrill" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->enable_amarpay == '1')
                <div class="payment-item">
                  <a title="Aamarpay" target="__blank" href="https://aamarpay.com/"><img
                      data-src="{{ url('images/payment/aamarpay.png') }}" alt="skrill" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if($Api_settings->iyzico_enable == '1')
                <div class="payment-item">
                  <a title="Iyzico Payment" target="__blank" href="https://www.iyzico.com/"><img
                      data-src="{{ url('images/payment/iyzico.png') }}" alt="skrill" class="owl-lazy img-fluid"></a>
                </div>
                @endif

                @if(config('dpopayment.enable') == 1 && Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())
                  @include('dpopayment::front.sliderlogo')
                @endif

                @if(config('bkash.ENABLE') == 1 && Module::has('Bkash') && Module::find('Bkash')->isEnabled())
                  @include('bkash::front.sliderlogo')
                @endif

                </div>
              </div>
            
            <!-- /.payment-methods -->
          </div>
        </div>
      </div>
    </div>

    <!-- small screen copyright-bar start -->
    <div class="copyright-bar header-nav-smallscreen">
      <div class="row">
        <div class="col-md-6">
          <div class="no-padding social">
            <ul class="link">
              @foreach($socials as $social)
                <li class="{{$social->icon}} pull-left"><a target="_blank" rel="nofollow" href="{{$social->url}}"></a></li>
              @endforeach
            </ul>

            <div class="d-inline col-12 col-sm-12 col-md-12 col-lg-12 no-padding copyright">
              <span style="padding-left: 15px;">&copy; {{ date("Y") }} @if(isset($Copyright)) {{$Copyright}}</span>
              @endif
            </div>
          </div>
        </div>
       
      </div>
     
      
    </div>
    <!-- small screen copyright-bar end -->
  </footer>

  <!-- Offer Popup -->
    
  <!-- END-->

  <!-- Floating Chat Button -->
  <div id="wpButton"></div>

  @if(env('GOOGLE_TAG_MANAGER_ID') != '' && env('GOOGLE_TAG_MANAGER_ENABLED') == true)
    @include('googletagmanager::body')
  @endif

 @if(env('FACEBOOK_PIXEL_ID') != '')
  @include('facebook-pixel::body')
 @endif

  <!-- End -->
  <!-- Display GDPR7 Cokkie message -->
  @include('cookieConsent::index')
  @notify_js
  @notify_render

  <!-- Messenger Bubble -->
  @if(Request::ip() != '::1' && env('MESSENGER_CHAT_BUBBLE_URL') != '')
    <script src="{{ env('MESSENGER_CHAT_BUBBLE_URL') }}" async></script>
  @endif
  <script>
    var sendurl = @json(route('ajaxsearch'));
    var rightclick = @json($rightclick);
    var inspect = @json($inspect);
    var baseUrl = @json(url('/'));
    var crate = @json($conversion_rate);
    var exist = @json(url('shop'));
    var setstart = @json(url('setstart'));
  </script>
  <script  src="{{ url('js/master.js') }}"></script>

  <!-- Default Front JS -->
  @if(isset($selected_language) && $selected_language->rtl_available == 1)
  <!-- RTL OWL JS-->
  <script src="{{url('front/js/default.js')}}"></script>

  @else
  <!-- LTR OWL JS-->
  <script src="{{url('front/js/scripts.min.js')}}"></script>
  @endif
  <script>
    var baseUrl = @json(url('/'));
    @if(isset($selected_language) && $selected_language->rtl_available == 1)
     var rtl = true;
    @else
    var rtl = false;
    @endif
  </script>
  
  <script src="{{ url('js/app.js') }}"></script>
  @if(file_exists(public_path().'/js/custom-js.js'))
    <script defer src="{{url('js/custom-js.js')}}"></script>
  @endif
  <!-- Sweetalert JS -->
  {{-- <script src="{{ url('front/vendor/js/sweetalert.min.js') }}"></script> --}}
  
  @php
    $wp = \DB::table('whatsapp_settings')->first();
  @endphp

  @if(isset($wp) && $wp->status == 1)

  <script>
    $('#wpButton').venomButton({

      phone: '{{ $wp->phone_no }}',

      popupMessage: '{{ $wp->popupMessage }}',

      showPopup: true,

      position: '{{ $wp->position }}',

      size: '{{ $wp->size }}',

      headerTitle: '{{ $wp->headerTitle }}',

      headerColor: '{{ $wp->headerColor }}'

    });
  </script>

  @endif

@if(strlen( env('ONESIGNAL_APP_ID',""))>4)
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
  <script>
    var ONESIGNAL_APP_ID = @json(env('ONESIGNAL_APP_ID'));
    var USER_ID = '{{  auth()->user()?auth()->user()->id:"" }}';
  </script>
  <script  src="{{ url('js/onesignal.js') }}"></script>
@endif

@yield('script')

</body>

</html>