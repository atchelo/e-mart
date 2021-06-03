@extends("front/layout.master")
@section('title', "$pro->name")
@section('meta_tags')
<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta property="og:title" content="{{ $pro->name }}" />
<meta name="keywords" content="{{ isset($pro) ? $pro->tags : $seoset->metadata_key }}">
<meta property="og:description" content="{{substr(strip_tags($pro->des), 0, 100)}}{{strlen(strip_tags( $pro->des))>100 ? '...' : ""}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->full() }}" />
<meta property="og:image" content="{{ url('variantimages/thumbnails/'.$pro->subvariants[0]->variantimages->main_image) }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description"
  content="{{substr(strip_tags($pro->des), 0, 100)}}{{strlen(strip_tags( $pro->des))>100 ? '...' : ""}}" />
<meta name="twitter:site" content="{{ url()->full() }}" />
@endsection
@section('stylesheet')
<!-- Drift Zoom CSS -->
<link rel="stylesheet" href="{{ url('css/vendor/drift-basic.min.css') }}">
@endsection
@section("body")
<nav class="navbar navbar-light display-none navbarBlue stickCartNav fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">

      <a class="navbar-brand" href="#">
        <div class="margin-top-minus-5" id="pro_section">
          <div id="pro-img"></div>
          <div id="pro-title"></div>
        </div>
      </a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div id="navbarSupportedContent">
      <ul class="nav navbar-nav navbar-right">
        <li class="nav-item">
          <div class="quant-input">
            <input type="number" value="1" class="qty-section">
          </div>
        </li>

        <li class="nav-item active">
          <div id="cartForm">
          </div>
        </li>
        <li class="nav-item">
          <div class="favorite-button header-nav-smallscreen">



            <span class="favorite-button-box">

            </span>


          </div>
        </li>
        <li class="nav-item">
          <div class="favorite-button header-nav-smallscreen">
            <span class="favorite-button-one">
              <a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="{{ __('Add to Compare') }}"
                href="{{ route('compare.product',$pro->id) }}">
                <i class="fa fa-signal"></i>
              </a>
            </span>




          </div>
        </li>





      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="breadcrumb">
  <div class="container-fluid">
    <div class="breadcrumb-inner">
      <ul class="list-inline list-unstyled">
        <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
        <li><a href="{{ $pro->category->getUrl() }}">{{ $pro->category->title }}</a></li>
        <li><a href="#">{{ $pro->subcategory->title }}</a></li>
        @if(!empty($pro->childcat->title))
        <li class='active'>
          <a href="{{ $pro->childcat->getURL() }}">
            {{ $pro->childcat->title }}
          </a>
        </li>
        @endif
      </ul>
    </div><!-- /.breadcrumb-inner -->
  </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-xs outer-top-xs-one detail-page-block">
  <div class='container-fluid'>
    <div class='row no-gutters single-product'>
      <div class='mb-5 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2 sidebar left-sidebar'>
        <div class="side-content">
          <div class="sidebar-module-container">

            @php
            $isad =
            App\DetailAds::where('position','=','prodetail')->where('linked_id',$pro->id)->where('status','=','1')->first();
            @endphp
            @if(isset($isad))
            <div class="home-banner outer-top-n outer-bottom-xs">
              @if($isad->adsensecode != '')
              @php
              html_entity_decode($isad->adsensecode);
              @endphp
              @else
              @if($isad->show_btn == '1')
              <h3 class="buy-heading" style="color:{{ $isad->hcolor }}">{{ $isad->top_heading }}</h3>
              <h5 class="buy-sub-heading" style="color:{{ $isad->scolor }}">{{ $isad->sheading }}</h5>
              <center><a href="
                   @if($isad->linkby == 'category')
                      @php
                        App\Helpers\CategoryUrl::getURL($isad->cat_id);
                      @endphp
                   @elseif($isad->linkby == 'detail')
                      @php

                          if(isset($isad->pro_id->subvariants)){
                            App\Helpers\ProductUrl::getUrl($isad->pro_id->subvariants->first()->id);
                          }
                          
                      @endphp
                   @elseif($isad->linkby == 'url')
                    {{ $isad->url }}
                   @endif" style="color:{{ $isad->btn_txt_color }};background: {{ $isad->btn_bg_color }}"
                  class="btn buy-button">{{ $isad->btn_text }}</a></center>
              <img src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise" class="img-fluid">
              @elseif($isad->show_btn == 0 && $isad->top_heading != '')
              <a href="
                  @if($isad->linkby == 'category')
                      @php
                        App\Helpers\CategoryUrl::getURL($isad->cat_id);
                      @endphp
                  @elseif($isad->linkby == 'detail')
                        @php

                          if($isad->pro_id->subvariants){
                            App\Helpers\ProductUrl::getUrl($isad->pro_id->subvariants->first()->id);
                          }
                        
                        @endphp
                  @elseif($isad->linkby == 'url')
                    {{ $isad->url }}
                  @endif
                  ">
                <h3 class="buy-heading" style="color:{{ $isad->hcolor }}">{{ $isad->top_heading }}</h3>
                <h5 class="buy-sub-heading" style="color:{{ $isad->scolor }}">{{ $isad->sheading }}</h5>
                <img class="img-fluid" src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise">
              </a>
              @else
              <a href="
                  @if($isad->linkby == 'category')
                    @php
                       App\Helpers\CategoryUrl::getURL($isad->cat_id);
                    @endphp
                  @elseif($isad->linkby == 'detail')
                      @php

                        if($isad->pro_id->subvariants){
                          App\Helpers\ProductUrl::getUrl($isad->pro_id->subvariants->first()->id);
                        }
                        
                      @endphp
                  @elseif($isad->linkby == 'url')
                    {{ $isad->url }}
                  @endif
                  ">
                <img class="img-fluid" src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise">
              </a>
              @endif
              @endif
            </div>
            @endif
            <!-- ============================================== Testimonials: END ============================================== -->
            @if(isset($enable_hotdeal) && $enable_hotdeal->shop == "1")
              <div class="mb-2 d-md-none d-sm-none d-lg-block sidebar-widget sidebar-widget-one hot-deals hot-deals-one outer-bottom-xs">
                <h3 class="section-title">{{ __('staticwords.Hotdeals') }}</h3>
                <div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-ss">

                  @foreach($hotdeals as $value)

                    @if($value->id != $pro->id)
                      @php
                        $orivar = $value->subvariants[0];
                      @endphp


                      <div class="item hot-deals-item">
                        <div class="products">
                          <div class="hot-deal-wrapper">
                            <div class="image">
                              <a href="{{ $value->getURL($value->subvariants[0]) }}" title="{{$value->name}}">
                                
                                
                                

                                @if(isset($orivar->variantimages->main_image))
                                <img class="owl-lazy"
                                  data-src="{{ url('/variantimages/thumbnails/'.$orivar->variantimages->main_image) }}"
                                  alt="{{$value->name}}">
                                <img class="owl-lazy hover-image"
                                  src="{{url('/variantimages/hoverthumbnail/'.$orivar->variantimages->image2)}}"
                                  alt="" />
                                @endif
                              </a>
                            </div>

                            @if($value->vender_offer_price != 0 || $value->vender_offer_price != null)
                              @php
                                $getdisprice = $value->vender_price - $value->vender_offer_price;
                                $gotdis = $getdisprice/$value->vender_price;
                                $offamount = $gotdis*100;
                              @endphp
                            <div class="sale-offer-tag"><span><?php echo Round($offamount) . "%"; ?><br>
                                {{ __('off') }}</span>
                            </div>

                            @endif
                            <div class="countdown">
                              <div class="timing-wrapper" data-startat="{{ $value->hotdeal->start }}"
                                data-countdown="{{ $value->hotdeal->end }}"></div>
                            </div>
                          </div>
                          <!-- /.hot-deal-wrapper -->

                          <div class="product-info text-left m-t-20">
                            <h3 class="name"><b><a href="{{ $value->getURL($value->subvariants[0]) }}"
                                  title="{{$value->name}}">{{$value->name}}</a></b></h3>
                            @php
                            $review_t = 0;
                            $price_t = 0;
                            $value_t = 0;
                            $sub_total = 0;
                            $sub_total = 0;
                            $reviews2 = $pro->reviews;
                            @endphp @if(count($reviews2))
                            @php
                            $count = count($pro->reviews);
                            foreach ($reviews2 as $review) {
                            $review_t = $review->price * 5;
                            $price_t = $review->price * 5;
                            $value_t = $review->value * 5;
                            $sub_total = $sub_total + $review_t + $price_t + $value_t;
                            }
                            $count = ($count * 3) * 5;
                            $rat = $sub_total / $count;
                            $ratings_var2 = ($rat * 100) / 5;
                            @endphp

                            <div class="">
                              <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var2; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>
                            </div>

                            @else
                            <div class="text-center">
                              {{ __('No Rating') }}
                            </div>
                            @endif

                            <div class="product-price"> <span class="price">

                                @if($price_login == 0 || Auth::check())

                                  @php
                                      $result = ProductPrice::getprice($value,$orivar)->getData();
                                  @endphp

                                @if(Session::has('currency'))
                                @if($result->offerprice == 0)
                                <span class="price"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{round($result->mainprice*$conversion_rate,2)}}</span>
                                @else

                                <span class="price"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{round($result->offerprice*$conversion_rate,2)}}</span>

                                <span class="price-before-discount"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{round($result->mainprice*$conversion_rate,2)}}</span>


                                @endif
                                @endif

                                @endif
                            </div>

                            <!-- /.product-price -->

                          </div>
                          <!-- /.product-info -->

                          <div class="cart clearfix animate-effect">
                            <div class="action">
                              <ul class="list-unstyled">
                                @php
                                $isInCart= App\Cart::where('variant_id',$orivar->id)->first();
                                $in_session = 0;

                                if(!empty(Session::has('cart'))){
                                  foreach (Session::get('cart') as $scart) {
                                    if($orivar->id == $scart['variantid']){
                                      $in_session = 1;
                                    }
                                  }
                                }


                                @endphp
                                @if($value->selling_start_at == '' || $value->selling_start_at <= date("Y-m-d
                                  H:i:s")) @if(!isset($isInCart) && $in_session==0 && $orivar->stock>0)
                                  @if($price_login != 1)
                                    <form method="POST"
                                      action="{{route('add.cart',['id' => $value->id ,'variantid' =>$orivar->id, 'varprice' => round($result->mainprice*$conversion_rate,2), 'varofferprice' => round($result->offerprice*$conversion_rate,2) ,'qty' =>$orivar->min_order_qty])}}">
                                      {{ csrf_field() }}
                                      <li class="add-cart-button btn-group">
                                        <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i
                                            class="fa fa-shopping-cart"></i> </button>
                                        <button class="btn btn-primary cart-btn" type="submit">Add to cart</button>
                                      </li>
                                    </form>
                                  @endif
                                  @else
                                  @if($orivar->stock>0 && $in_session == 1)
                                    <li class="add-cart-button btn-group">

                                      <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i
                                          class="fa fa-check"></i> </button>
                                      <button onclick="window.location='{{ url('/cart') }}'"
                                        class="btn btn-primary cart-btn" type="button">Deal in Cart</button>

                                    </li>
                                  @endif
                                  @if($orivar->stock==0)

                                    <h5 class="required" align="center">
                                      {{ __('staticwords.Outofstock') }}
                                    </h5>

                                  @endif
                                  @endif
                                  @else
                                    <h5>
                                      {{ __('staticwords.ComingSoon') }}
                                    </h5>
                                  @endif

                              </ul>
                            </div>
                            <!-- /.action -->
                          </div>



                        </div>
                      </div>
                    @endif
                
                  @endforeach


                </div>
                <!-- /.sidebar-widget -->
              </div>
            @endif

          </div>

        </div>
      </div><!-- /.sidebar -->
      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12  col-xl-10 rht-col main-content'>

        <div class="detail-block">
          <!-- ====================== data sticky: start ============= -->
          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4 gallery-holder left-sidebar">
              <div class="product-item-holder size-big single-product-gallery small-gallery">

                <div class="data-sticky ">

                  <div class="single-product-gallery-item">


                    {{-- single image through js here --}}


                  </div>

                  <!-- /.single-product-gallery-item -->

                  <div class="galleryContainer">
                    <!-- Append Slider from JS-->
                    <!--End-->
                  </div>


                  <div class="notifymeblock">

                  </div>
                </div>


                <!-- ======================= data sticky: END ========================== -->

              </div><!-- /.single-product-gallery -->



            </div><!-- /.gallery-holder -->

            <div class='col-sm-12 col-md-12 col-lg-12 col-xl-8 product-info-block main-content'>

              <div id="details-container"></div>

              <div class="product-info">
                <div class="stock-container info-container">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="pull-left">
                        <div class="stock-box">
                          <span class="label">{{ __('staticwords.Availability') }} :</span>
                        </div>
                      </div>
                      <div class="pull-left">
                        <div class="stock-box">
                          <span class="text-success stockval value">

                          </span>
                        </div>
                      </div>
                      <br><br>
                      <h1 class="name">{{$pro->name}} </h1>
                      <span class="productVars name-type"></span>
                      <div class="seller-info">{{ __('staticwords.by') }} <a
                          href="{{ route('store.view',['uuid' => $pro->store->uuid ?? 0, 'title' => $pro->store->name]) }}"
                          class="lnk">
                          {{ $pro->store->name }} @if($pro->store->verified_store) <i title="Verified"
                            class="text-green fa fa-check-circle"></i> @endif
                        </a>
                      </div>
                      <p></p>

                      <?php

                        $review_t = 0;
                        
                        $price_t = 0;

                        $value_t = 0;

                        $sub_total = 0;

                        $count = count($pro->reviews);

                        $onlyrev = array();

                        foreach ($pro->reviews as $review) {
                            $review_t = $review->qty * 5;
                            $price_t = $review->price * 5;
                            $value_t = $review->value * 5;
                            $sub_total = $sub_total + $review_t + $price_t + $value_t;
                        }

                        $count = ($count * 3) * 5;

                        if ($count != "") {
                          $rat = $sub_total / $count;

                          $ratings_var = ($rat * 100) / 5;

                          $overallrating = ($ratings_var / 2) / 10;
                        }

                        ?>

                      @php
                      $count = 0;
                      @endphp

                      @if(isset($overallrating))

                      @if(isset($ratings_var))
                      <div class="pull-left">
                        <div class="star-ratings-sprite">
                          <span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                        </div>
                      </div>
                      @endif

                      <div class="pull-left">
                        <div class="reviews-rating">
                          {{ round($overallrating,1)}} <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                      </div>

                      <div class="margin-left25">
                        <div class="reviews">
                          <a href="{{ route('allreviews',$pro->id) }}"
                            class="lnk">&nbsp;&nbsp;{{  $count =  count($pro->reviews) }} {{ __('ratings and') }}
                            {{ $reviewcount }} {{ __('reviews') }}</a>
                        </div>
                      </div>

                      <p></p>
                      @else
                      <div class="pull-left">

                        <i class="color147ED2 fa fa-star-half-o" aria-hidden="true"></i>
                        {{ __('staticwords.ratetext') }}
                      </div>
                      <br>
                      <p></p>
                      @endif

                      @if($pro->w_d !='None' && $pro->w_my !='None' && $pro->w_type !='None')

                      <p> <i class="color147ED2 fa fa-refresh" aria-hidden="true"></i> {{$pro->w_d}}
                        {{ ucfirst($pro->w_my) }} {{ __('staticwords.of') }} {{ $pro->w_type }}</p>
                      @endif

                      <p><i class="color147ED2 fa fa-handshake-o" aria-hidden="true"></i> Trust of <b>
                          {{$pro->brand->name}}</b>
                        @if($image = @file_get_contents('images/brands/'.$pro->brand->image))
                        <img alt="brandlogo" class="pro-brand" src="{{ url('/images/brands/'.$pro->brand->image) }}">
                        @else
                        <img alt="brandlogo" class="pro-brand"
                          src="{{ Avatar::create($pro->brand->name)->toBase64() }}">
                        @endif
                      </p>

                      @if($pro->selling_start_at <= date("Y-m-d H:i:s")) @else <h3>{{ __('ComingSoon') }}</h3>

                        @endif

                    </div>

                    <div class="col-md-4 col-xs-12 col-sm-12">
                      <div id="qbc" class="quantity-block">
                        <div class="quantity-top">{{ __('staticwords.tbc') }}</div>
                        <div class="quantity-heading">{{ __('staticwords.qty') }}</div>
                        <div class="qty-parent-cont">
                          <div class="quantity-container info-container">
                            <div class="row">
                              <div class="qty-count">
                                <div class="cart-quantity">
                                  <div class="quant-input">



                                  </div>
                                </div>
                              </div>
                              <div class="add-btn">

                              </div>
                            </div><!-- /.row -->
                          </div>
                        </div>
                      </div>
                    </div>

                  </div><!-- /.row -->
                </div><!-- /.stock-container -->



                <div class="rating-reviews">


                  <div class="price-container info-container">
                    <div class="row">


                      <div class="col-sm-6 col-xs-12 col-md-8">
                        <div class="price-box price-box-border">
                          <span class="price price-main dtl-price-main">

                          </span>
                          <span
                            class="margin-top-15 font-size-20 price-strike price-strike-main dtl-price-strike-main"></span>

                          &nbsp;<i data-toggle="tooltip" data-placement="left"
                            title="{{ $pro->tax_r =='' ? __('Taxes Not Included') : __('Taxes Included') }}"
                            class="color111 fa fa-info-circle"></i>
                        </div>
                        @if($pro->offer_price != 0)
                        <div class="progress-text"></div>
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        </div>

                        @endif
                      </div>

                      <!-- close-->
                      <div class="col-sm-6 col-xs-12 col-md-4">
                        <div class="favorite-button header-nav-screen">

                          <a class="btn btn-primary" data-toggle="modal" data-placement="right" title="Share"
                            data-target="#sharemodal">

                            <i class="text-white fa fa-share-alt" aria-hidden="true"></i>

                          </a>

                          <div class="modal fade" id="sharemodal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">

                                <div class="share-content modal-body">

                                </div>

                              </div>
                            </div>
                          </div>

                          <span class="favorite-button-box">

                          </span>

                          @php
                            $m=0;
                          @endphp

                          @if(!empty(Session::get('comparison')))

                          @foreach(Session::get('comparison') as $p)

                            @if($p['proid'] == $pro->id)
                              @php
                                $m = 1;
                                break;
                              @endphp
                            @else
                              @php
                                $m = 0;
                              @endphp
                            @endif

                          @endforeach

                          @endif

                          @if($m == 0)
                          <a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add to Compare"
                            href="{{ route('compare.product',$pro->id) }}">
                            <i class="fa fa-signal"></i>
                          </a>
                          @else
                          <a class="abg btn btn-primary" data-toggle="tooltip" data-placement="right"
                            title="Remove From Compare List" href="{{ route('remove.compare.product',$pro->id) }}">
                            <i class="fa fa-signal"></i>
                          </a>
                          @endif

                          @if($pro->catlog != '' && file_exists(public_path().'/productcatlog/'.$pro->catlog))
                          <a class="abg btn btn-primary" data-toggle="tooltip" data-placement="right"
                            title="Download catlog"
                            href="{{ URL::temporarySignedRoute('download.catlog', now()->addMinutes(2), ['catlog' => $pro->catlog]) }}">
                            <i class="fa fa-download"></i>
                          </a>
                          @endif

                        </div>
                      </div>

                    </div>


                  </div><!-- /.price-container -->

                  <div class="dc row">
                    @if($pincodesystem == 1)
                    <div class="col-lg-7 col-sm-6 col-xs-6 description-container">
                      <p></p>
                      <div class="delivery-location  description-heading">

                        <img alt="shoppingbag"
                          src="{{url('/images/shopping-bag.png')}}">{{ __('staticwords.deliverytext') }}


                      </div>


                      <form id="myForm" method="post">
                        {{csrf_field()}}
                        <div class="form-group">

                          <div class="input-group mb-3">
                            <input placeholder="{{ __('Enter Pincode') }}" required class="pincode-input form-control"
                              onchange="SubmitFormData()" type="text" id="deliveryPinCode" value="">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">
                                <i id="marker-map" class="fa fa-map-marker"></i>
                              </span>
                            </div>
                          </div>

                          <span id="pincodeResponce"></span>
                        </div>
                      </form>

                    </div>
                    @endif

                    <div class="col-sm-6 col-xs-6 d-block d-sm-none">
                      <b>{{ __('staticwords.Share') }}</b> : <div class="share-content"></div>
                    </div>
                    <div class="{{ $pincodesystem == 1 ? "col-md-5" : "col-md-8" }} description-container ">
                      <p></p>
                      <div class="description-heading">{{ __('staticwords.otherservices') }}</div>
                      <div class="price-container info-container">
                        <div class="delivery-detail text-center">
                          <div class="row">
                            @if($pro->codcheck == 1)
                            <div class="col-lg-3 col-4">
                              <div class="image">
                                <img src="{{url('/images/icon-cod.png')}}" class="img-fluid" alt="img">
                              </div>
                              <div class="detail text-center">{{ __('staticwords.podtext') }}</div>
                            </div>
                            @endif
                            @if($pro->return_avbl == 1)
                            <div class="col-lg-3 col-4">
                              <div data-toggle="modal" data-target="#returnmodal" class="image">
                                <img src="{{url('/images/icon-returns.png')}}" class="img-fluid" alt="img">
                              </div>
                              <div class="detail">{{ $pro->returnPolicy->days }} {{ __('staticwords.returndays') }}
                              </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="returnmodal" tabindex="-1" role="dialog"
                              aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                    <h5 class="modal-title" id="myModalLabel">{{ $pro->returnPolicy->name }}</h5>
                                  </div>
                                  <div class="modal-body">
                                    {{ $pro->returnPolicy->des }}
                                  </div>

                                </div>
                              </div>
                            </div>
                            @else
                            <div class="col-lg-3 col-4">
                              <div data-toggle="modal" data-target="#returnmodal" class="image">
                                <img src="{{url('/images/icon-returns.png')}}" class="img-fluid" alt="img">
                              </div>
                              <div class="detail">{{ __('staticwords.noreturn') }}</div>
                            </div>
                            @endif
                            @if($pro->free_shipping == 1)
                            <div class="col-lg-4 col-4">
                              <div class="image">
                                <img src="{{url('/images/icon-delivered.png')}}" class="img-fluid" alt="img">
                              </div>
                              <div class="detail">{{config('app.name')}} {{ __('staticwords.freedelivery') }}</div>
                            </div>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <hr>

                  <div class="delivery-container">
                    <div class="row">
                      <div class="col-lg-6">


                        <div class="var-box">


                          @if(isset($pro->commonvars))

                          <table border="0" class="width100">
                            @foreach($pro->commonvars as $cvar)
                            @php
                            $attrkey = "_";
                            @endphp
                            <tr>
                              <td width="20%">
                                @if (strpos($cvar->attribute->attr_name, $attrkey) == false)

                                <span class="font-size-14 font-weight-bold">{{ $cvar->attribute->attr_name }}</span>

                                @else

                                <span
                                  class="font-size-14 font-weight-bold">{{ str_replace('_', ' ', $cvar->attribute->attr_name) }}</span>

                                @endif
                              </td>
                              <td width="20%">
                                @if($cvar->attribute->attr_name == "Color" || $cvar->attribute->attr_name == "color" ||
                                $cvar->attribute->attr_name == "Colour" || $cvar->attribute->attr_name == "colour")


                                <div class="inline-flex left-minus-10">
                                  <div class="color-options">
                                    <ul>
                                      <li data-toggle="tooltip" data-placement="auto"
                                        title="{{ $cvar->provalues->values }}" class="color varcolor active"><a href="#"
                                          title=""><i style="color: {{ $cvar->provalues->unit_value }}"
                                            class="fa fa-circle"></i></a>
                                        <div class="overlay-image overlay-deactive">
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                                </div>

                                @else


                                @if(strcasecmp($cvar->provalues->values, $cvar->provalues->unit_value) !=0 &&
                                $cvar->provalues->unit_value != null)
                                <span data-toggle="tooltip" data-placement="auto"
                                  title="{{ $cvar->provalues->values }} {{ $cvar->provalues->unit_value }}"
                                  class="commonvar font-weight-bold">{{ $cvar->provalues->values }}
                                  {{ $cvar->provalues->unit_value }}</span>
                                @else
                                <span data-toggle="tooltip" data-placement="top" title="{{ $cvar->provalues->values }}"
                                  class="commonvar font-weight-bold">{{ $cvar->provalues->values }}</span>
                                @endif


                                @endif
                              </td>
                            </tr>
                            @endforeach
                          </table>
                          @endif

                          @php

                          $indexNum = 0;

                          @endphp

                          <div class="full_var_box">

                            <div class="table-responsive">
                              <table border="0" class="width100">
                                @foreach($pro->variants as $key=> $mainvariant)
                                <tr>
                                  <td width="33%">
                                    @php

                                    $getattrname =
                                    App\ProductAttributes::where('id','=',$mainvariant->attr_name)->first();

                                    @endphp

                                    <span id="Size" class="font-weight-bold">
                                      <label class="atrbName" indexnum="{{$indexNum}}" id="{{ $getattrname->id }}"
                                        value="{{ $getattrname->attr_name }}">
                                        @php
                                        $k = '_';
                                        @endphp
                                        @if (strpos($getattrname->attr_name, $k) == false)
                                        {{ $getattrname->attr_name }}
                                        @else
                                        {{str_replace('_', ' ',$getattrname->attr_name)}}
                                        @endif
                                      </label>
                                    </span>
                                  </td>
                                  <td>

                                    @foreach($mainvariant->attr_value as $subvalue)

                                    @php
                                    $getvaluename = App\ProductValues::where('id','=',$subvalue)->first();
                                    @endphp

                                    @foreach($pro->subvariants as $key=> $ss)

                                    @if($ss->main_attr_value[$getattrname->id] == $getvaluename->id)

                                    @if($getvaluename->proattr->attr_name == "Color")


                                    <a class="mainvar font-weight-bold xyz" data-toggle="tooltip" data-placement="top"
                                      @if(strcasecmp($getvaluename->values, $getvaluename->unit_value) !=0)
                                      title="{{ $getvaluename->values }}"
                                      @else
                                      title="{{ $getvaluename->values }}"
                                      @endif
                                      attr_id="{{ $getattrname->id }}"
                                      @if(strcasecmp($getvaluename->values, $getvaluename->unit_value) !=0)
                                      @if($getvaluename->proattr->attr_name == "Color")
                                      valname="{{ $getvaluename->values }}"
                                      @else
                                      valname="{{ $getvaluename->values }}{{ $getvaluename->unit_value }}"
                                      @endif
                                      @else
                                      valname="{{ $getvaluename->values }}"
                                      @endif
                                      val="{{ $getvaluename->id }}"
                                      name="{{ $getattrname->attr_name }}"
                                      s="0"
                                      id="{{ $getattrname->attr_name }}{{ $getvaluename->id }}"
                                      onclick="tagfilter('{{ $getattrname->attr_name }}','{{ $getvaluename->id }}',
                                      '{{$indexNum}}')"
                                      >


                                      <span class="ankit"><i style="color:{{ $getvaluename->unit_value }}"
                                          class="fa fa-circle"></i></span>


                                    </a>

                                    @else


                                    <a class="mainvar font-weight-bold xyz" data-toggle="tooltip" data-placement="top"
                                      @if(strcasecmp($getvaluename->values, $getvaluename->unit_value) !=0)
                                      title="{{ $getvaluename->values }} {{ $getvaluename->unit_value }}" @else
                                      title="{{ $getvaluename->values }}" @endif attr_id="{{ $getattrname->id }}"
                                      @if(strcasecmp($getvaluename->values, $getvaluename->unit_value) !=0)
                                      @if($getvaluename->proattr->attr_name == "Color")
                                      valname="{{ $getvaluename->values }}" @else
                                      valname="{{ $getvaluename->values }}{{ $getvaluename->unit_value }}" @endif @else
                                      valname="{{ $getvaluename->values }}" @endif val="{{ $getvaluename->id }}"
                                      name="{{ $getattrname->attr_name }}" s="0"
                                      id="{{ $getattrname->attr_name }}{{ $getvaluename->id }}"
                                      onclick="tagfilter('{{ $getattrname->attr_name }}','{{ $getvaluename->id }}',
                                      '{{$indexNum}}')">

                                      @if(strcasecmp($getvaluename->values, $getvaluename->unit_value) !=0 &&
                                      $getvaluename->unit_value != null)
                                      {{ $getvaluename->values }} {{ $getvaluename->unit_value }}
                                      @else
                                      {{ $getvaluename->values }}
                                      @endif

                                    </a>

                                    @endif


                                    @endif

                                    @endforeach
                                    @endforeach
                                  </td>
                                </tr>
                                @endforeach
                              </table>
                            </div>



                          </div>

                        </div>


                      </div>

                    </div>
                    <hr>
                  </div><!-- /.delivery-container -->

                  <!-- ============================ small-screen start ========================================= -->

                  <!-- ============================ small-screen end ========================================= -->
                  @if(isset($pro->key_features))
                  <div class="description-container">
                    <div class="description-heading">{{ __('staticwords.Highlight') }}</div>
                    <div class="description-list">
                      {!! $pro->key_features !!}
                    </div>
                    <div class="report-text"><a href="#reportproduct" data-toggle="modal" title="">
                        <img alt="commenticon"
                          src="{{url('/images/comment.png')}}">{{ __('staticwords.rprotext') }}.</a></div>
                  </div><!-- /.description-container -->
                  @endif
                  <br>

                </div><!-- /.product-info -->
              </div><!-- /.col-sm-7 -->

            </div><!-- /.row -->
          </div>
        </div>
        <!-- ============================================== full-screen tab start ============================================== -->
        <!-- ==============================================    ============================================== -->
        
        <div class="mt-2 product-feature">
          <div class="fast-delivery-block-block">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="fast-delivery-block">
                  <i class="fa fa-truck"></i>
                  <div class="delivery-heading">{{ __('staticwords.FastDelivery') }}</div>
                  <p>{{ __('staticwords.fastdtext') }}.</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="fast-delivery-block">
                  <i class="fa fa-cubes" aria-hidden="true"></i>
                  <div class="delivery-heading">{{ __('staticwords.QualityAssurance') }}</div>
                  <p>{{ __('staticwords.With') }} {{ config('app.name') }} {{ __('staticwords.qtext') }}.</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="fast-delivery-block">
                  <i class="fa fa-money"></i>
                  <div class="delivery-heading">{{ __('staticwords.PurchaseProtection') }}</div>
                  <p>{{ __('staticwords.PayementGatewaytext') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        

        <div id="product-tabs" class="mt-2 product-tabs display-none-block">

          <div class="row">
            <div class="col-lg-3 col-12">
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#prodesc" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-list"></i>
                  {{ __('staticwords.Description') }}</a>

                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#prospec" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-bars"></i>
                  {{ __('staticwords.prospecs') }}</a>

                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-tab-pro-reviews" role="tab" aria-controls="v-tab-pro-reviews" aria-selected="false"><i class="fa fa-star"></i>
                  {{ __('staticwords.reviewratetext') }}</a>

                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pro-comments" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-comment"></i>
                  {{ count($pro->comments) }} {{ __('staticwords.Comments') }}</a>
                
                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pro-faqs" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-question-circle"></i>
                  {{ __('staticwords.faqs') }}</a>

                

              </div>
            </div>
            <div class="col-lg-9">
              <div class="tab-content" id="v-pills-tabContent">

                <div class="tab-pane fade show active" id="prodesc" role="tabpanel" aria-labelledby="v-pills-home-tab">

                  @if($pro->des != '')
                  {!! $pro->des !!}
                  @else
                    <h4>{{ __('No Description') }}</h4>
                  @endif
                  <hr>
                  <p><b>{{ __('Tags') }}:</b>
                    @php
                    $x = explode(',', $pro->tags);
                    @endphp
                    @foreach($x as $tag)
                    <span class="badge badge-secondary"><i class="fa fa-tags"></i> {{ $tag }}</span>
                    @endforeach
                  </p>

                </div>

                <div class="tab-pane fade" id="prospec" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                  @if(count($pro->specs)>0)

                  <div class="row">
                    @foreach($pro->specs as $spec)
  
                    <div class="col-md-3 keycol">
                      <b>{{ $spec->prokeys }}</b>
                    </div>
  
                    <div class="col-md-9 keyval">
                      {{ $spec->provalues }}
                    </div>
  
                    @endforeach
                  </div>
                  @else
                  <h4>
                    {{ __('No Specifications') }}
                  </h4>
                  @endif


                </div>

                <div class="tab-pane fade" id="v-tab-pro-reviews" role="tabpanel" aria-labelledby="v-pills-messages-tab">

                    @auth
    
                    @php
                      $purchased = App\Order::where('user_id',Auth::user()->id)->get();
                      $findproinorder = 0;
                      $alreadyrated = $pro->reviews->where('user',Auth::user()->id)->first();
                    @endphp
    
                    @if(isset($purchased))
                    @foreach($purchased as $value)
                    @if(in_array($pro->id, $value->main_pro_id))
                    @php
                    $findproinorder = 1;
                    @endphp
                    @endif
                    @endforeach
                    @endif
    
                    @if($findproinorder == 1)
                    @if(isset($alreadyrated))
    
    
                    <h5>
                      {{ __('Your Review') }}
                    </h5>
                    <hr>
                    <div class="row">
    
                      <div class="col-md-2">
                        @if($alreadyrated->users->image !='')
                        <img src="{{ url('/images/user/'.$alreadyrated->users->image) }}" alt=""
                          class="img-fluid rounded-circle">
                        @else
                        <img class="img-fluid rounded-circle"
                          src="{{ Avatar::create($alreadyrated->users->name)->toBase64() }}">
                        @endif
                      </div>
    
                      <div class="col-md-8">
                        <p>
                          <b><i>{{ $alreadyrated->users->name }}</i></b>
                          <small class="pull-right rating-date">On
                            {{ date('jS M Y',strtotime($alreadyrated->created_at)) }}
                            @if($alreadyrated->status == 1)
                            <span class="badge badge-success font-weight-bold"><i class="fa fa-check"
                                aria-hidden="true"></i> {{ __('Approved') }}</span>
                            @else
                            <span class="badge badge-success font-weight-bold"><i class="fa fa-info-circle"
                                aria-hidden="true"></i> {{ __('Pending') }}</span>
                            @endif
                          </small>
                          <br>
    
                          <?php
    
                                  $user_count = count([$alreadyrated]);
                                  $user_sub_total = 0;
                                  $user_review_t = $alreadyrated->price * 5;
                                  $user_price_t = $alreadyrated->price * 5;
                                  $user_value_t = $alreadyrated->value * 5;
                                  $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
    
                                  $user_count = ($user_count * 3) * 5;
                                  $rat1 = $user_sub_total / $user_count;
                                  $ratings_var1 = ($rat1 * 100) / 5;
    
                                  ?>
                          <div class="pull-left">
                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                class="star-ratings-sprite-rating"></span>
                            </div>
                          </div>
                          <br>
                          <span class="font-weight500">{{ $alreadyrated->review }}</span>
                        </p>
                      </div>
    
                    </div>
    
                    <hr>
                    <a title="View all reviews" class="font-weight-bold pull-right"
                      href="{{ route('allreviews',$pro->id) }}">{{ __('staticwords.vall') }}</a>
                    <h5 class="title">{{ __('staticwords.recReviews') }}</h5>
    
                    <hr>
    
                    <div class="row">
    
                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="overall-rating-main-block">
                          <div class="overall-rating-block text-center">
                            @php
                            if(!isset($overallrating)){
                              $overallrating = 0;
                            }
                            @endphp
                            <h1>{{ round($overallrating,1) }}</h1>
                            <div class="overall-rating-title">{{ __('staticwords.OverallRating') }}</div>
                            <div class="rating">
                              @php
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $sub_total = 0;
                              $reviews2 = App\UserReview::where('pro_id', $pro->id)->where('status', '1')->get();
                              @endphp @if(!empty($reviews2[0]))
                              @php
                              $count = App\UserReview::where('pro_id', $pro->id)->count();
                              foreach ($reviews2 as $review) {
                              $review_t = $review->price * 5;
                              $price_t = $review->price * 5;
                              $value_t = $review->value * 5;
                              $sub_total = $sub_total + $review_t + $price_t + $value_t;
                              }
                              $count = ($count * 3) * 5;
                              $rat = $sub_total / $count;
                              $ratings_var2 = ($rat * 100) / 5;
                              @endphp
    
    
                              <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>
    
    
                              @else
                              <div class="text-center">
                                {{ __('No Rating') }}
                              </div>
                              @endif
                            </div>
                            <div class="total-review">{{$count =  count($pro->reviews)}} {{ __('Ratings &') }}
                              {{$reviewcount}} {{ __('reviews') }}</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                              <label>{{ __('staticwords.Quality') }}</label>
                              <div class="stat-1 stat-bar">
                                <span class="stat-bar-rating" role="stat-bar"
                                  style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Price') }}</label>
                              <div class="stat-2 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar"
                                  style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Value') }}</label>
                              <div class="stat-3 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar"
                                  style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                              </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                          <div class="overall-rating-block satisfied-customer-block text-center">
                            <h3>100%</h3>
                            <div class="overall-rating-title">{{ __('staticwords.SatisfiedCustomer') }}</div>
                            <p>{{ __('staticwords.customerText') }}.</p>
                          </div>
                          @endif
                        </div>
                      </div>
    
                      <div class="col-md-9">
                        <!-- All reviews will show here-->
                        @foreach($pro->reviews->take(5) as $review)
    
                        @if($review->status == "1")
                        <div class="row">
    
                          <div class="col-md-2">
                            @if($review->users->image !='')
                            <img src="{{ url('/images/user/'.$review->users->image) }}" alt=""
                              class=" rounded-circle img-fluid">
                            @else
                            <img class="rounded-circle img-fluid"
                              src="{{ Avatar::create($review->users->name)->toBase64() }}">
                            @endif
                          </div>
    
    
    
                          <div class="col-md-10">
                            <p>
                              <b><i>{{ $review->users->name }}</i></b>
                              <?php
    
                                          $user_count = count([$review]);
                                          $user_sub_total = 0;
                                          $user_review_t = $review->price * 5;
                                          $user_price_t = $review->price * 5;
                                          $user_value_t = $review->value * 5;
                                          $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
    
                                          $user_count = ($user_count * 3) * 5;
                                          $rat1 = $user_sub_total / $user_count;
                                          $ratings_var1 = ($rat1 * 100) / 5;
    
                                          ?>
                              <div class="pull-left">
                                <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                    class="star-ratings-sprite-rating"></span>
                                </div>
                              </div>
    
                              <small class="pull-right rating-date">{{ __('On') }}
                                {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                              <br>
                              <span class="font-weight500">{{ $review->review }}</span>
                            </p>
                          </div>
    
                        </div>
                        <hr>
                        @endif
    
                        @endforeach
    
    
                        <!--end-->
                      </div>
                    </div>
    
    
                    @else
                    <h5>{{ __('staticwords.ratereviewPurchase') }}</h5>
                    <hr>
                    @php
                    if(!isset($overallrating)){
                    $overallrating = 0;
                    }
                    @endphp
                    <div class="row">
                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="overall-rating-main-block">
                          <div class="overall-rating-block text-center">
                            <h1>{{ round($overallrating,1) }}</h1>
                            <div class="overall-rating-title">{{ __('staticwords.OverallRating') }}</div>
                            <div class="rating">
                              @php
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $sub_total = 0;
                              $reviews2 = App\UserReview::where('pro_id', $pro->id)->where('status', '1')->get();
                              @endphp @if(!empty($reviews2[0]))
                              @php
                              $count = App\UserReview::where('pro_id', $pro->id)->count();
                              foreach ($reviews2 as $review) {
                              $review_t = $review->price * 5;
                              $price_t = $review->price * 5;
                              $value_t = $review->value * 5;
                              $sub_total = $sub_total + $review_t + $price_t + $value_t;
                              }
                              $count = ($count * 3) * 5;
                              $rat = $sub_total / $count;
                              $ratings_var2 = ($rat * 100) / 5;
                              @endphp
    
    
                              <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>
    
    
                              @else
                              <div class="text-center">
                                {{ __('No Rating') }}
                              </div>
                              @endif
                            </div>
                            <div class="total-review">{{$count =  count($pro->reviews)}} Ratings & {{$reviewcount}}
                              reviews</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                              <label>{{ __('staticwords.Quality') }}</label>
                              <div class="stat-1 stat-bar">
                                <span class="stat-bar-rating" role="stat-bar"
                                  style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Price') }}</label>
                              <div class="stat-2 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar"
                                  style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Value') }}</label>
                              <div class="stat-3 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar"
                                  style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                              </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                          <div class="overall-rating-block satisfied-customer-block text-center">
                            <h3>100%</h3>
                            <div class="overall-rating-title">{{ __('staticwords.SatisfiedCustomer') }}</div>
                            <p>{{ __('staticwords.customerText') }}.</p>
                          </div>
                          @endif
                        </div>
                      </div>
    
                      <div class="col-md-8 product-add-review">
                        <div class="review-table">
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th class="cell-label">&nbsp;</th>
                                  <th>1 star</th>
                                  <th>2 stars</th>
                                  <th>3 stars</th>
                                  <th>4 stars</th>
                                  <th>5 stars</th>
                                </tr>
                              </thead>
                              <form class="cnt-form" method="post" action="{{url('user_review/'.$pro->id)}}">
                                {{csrf_field()}}
                                <div class="required">{{$errors->first('quality')}}</div>
                                <div class="required">{{$errors->first('Price')}}</div>
                                <div class="required">{{$errors->first('Value')}}</div>
                                <tbody>
                                  <tr>
                                    <td class="cell-label">{{ __('staticwords.Quality') }} <span class="required">*</span>
                                    </td>
                                    <td><input type="radio" name="quality" class="radio" value="1"></td>
                                    <td><input type="radio" name="quality" class="radio" value="2"></td>
                                    <td><input type="radio" name="quality" class="radio" value="3"></td>
                                    <td><input type="radio" name="quality" class="radio" value="4"></td>
                                    <td><input type="radio" name="quality" class="radio" value="5"></td>
                                  </tr>
                                  <tr>
                                    <td class="cell-label">{{ __('staticwords.Price') }} <span class="required">*</span>
                                    </td>
                                    <td><input type="radio" name="Price" class="radio" value="1"></td>
                                    <td><input type="radio" name="Price" class="radio" value="2"></td>
                                    <td><input type="radio" name="Price" class="radio" value="3"></td>
                                    <td><input type="radio" name="Price" class="radio" value="4"></td>
                                    <td><input type="radio" name="Price" class="radio" value="5"></td>
                                  </tr>
                                  <tr>
                                    <td class="cell-label">{{ __('staticwords.Value') }} <span class="required">*</span>
                                    </td>
                                    <td><input type="radio" name="Value" class="radio" value="1"></td>
                                    <td><input type="radio" name="Value" class="radio" value="2"></td>
                                    <td><input type="radio" name="Value" class="radio" value="3"></td>
                                    <td><input type="radio" name="Value" class="radio" value="4"></td>
                                    <td><input type="radio" name="Value" class="radio" value="5"></td>
                                  </tr>
                                </tbody>
                            </table>
                            <!-- /.table .table-bordered -->
                          </div>
                          <!-- /.table-responsive -->
                        </div>
                        <!-- /.review-table -->
                        <div class="review-form">
                          <div class="form-container">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <input type="hidden" class="form-control txt" id="exampleInputName" name="name" value="
                                @if(Auth::check()) {{auth()->user()->id}} @endif" placeholder="">
                                  <div class="text-red">{{$errors->first('name')}}</div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="margin-left15"
                                    for="exampleInputReview">{{ __('staticwords.Review') }}:</label>
                                  <textarea class="form-control text-rev" name="review" id="exampleInputReview" rows="5"
                                    cols="50" placeholder=""></textarea>
                                </div>
                              </div>
                            </div><!-- /.row -->
                            <div class="action text-right">
                              <button class="btn btn-primary btn-upper">{{ __('staticwords.SUBMITREVIEW') }}</button>
                            </div><!-- /.action -->
                            </form><!-- /.cnt-form -->
                          </div><!-- /.form-container -->
                        </div><!-- /.review-form -->
                      </div>
                    </div>
                    <!-- /.product-add-review -->
                    <h5>{{ __('staticwords.recReviews') }}</h5>
    
                    <hr>
    
                    @if(count($pro->reviews)>0)
                    @foreach($pro->reviews->take(5) as $review)
    
                    @if($review->status == "1")
                    <div class="row">
    
                      <div class="col-md-1">
                        @if($review->users->image !='')
                        <img src="{{ url('/images/user/'.$review->users->image) }}" alt="" width="70px" height="70px"
                          class="rounded-circle">
                        @else
                        <img width="70px" height="70px" src="{{ Avatar::create($review->users->name)->toBase64() }}"
                          class="rounded-circle">
                        @endif
                      </div>
    
                      <div class="col-md-10">
                        <p>
                          <b><i>{{ $review->users->name }}</i></b>
                          <?php
    
                                          $user_count = count([$review]);
                                          $user_sub_total = 0;
                                          $user_review_t = $review->price * 5;
                                          $user_price_t = $review->price * 5;
                                          $user_value_t = $review->value * 5;
                                          $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
    
                                          $user_count = ($user_count * 3) * 5;
                                          $rat1 = $user_sub_total / $user_count;
                                          $ratings_var1 = ($rat1 * 100) / 5;
    
                                          ?>
                          <div class="pull-left">
                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                class="star-ratings-sprite-rating"></span>
                            </div>
                          </div>
    
                          <small class="pull-right rating-date">{{ __('On') }}
                            {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                          <br>
                          <span class="font-weight500">{{ $review->review }}</span>
                        </p>
                      </div>
    
                    </div>
                    <hr>
                    @endif
    
                    @endforeach
                    @else
                    <h5><i class="fa fa-star"></i> {{ __('staticwords.ratetext') }}</h5>
                    @endif
    
                    @endif
                    @else
                    <h5>{{ __('staticwords.purchaseProText') }}</h5>
                    <hr>
                    <h5>{{ __('staticwords.recReviews') }}</h5>
                    <hr>
                    @if(count($pro->reviews)>0)
    
                    @if(!isset($overallrating))
                    @php
                    $overallrating = 0;
                    @endphp
                    @endif
                    <div class="row">
    
                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="overall-rating-main-block">
                          <div class="overall-rating-block text-center">
                            <h1>{{ round($overallrating,1) }}</h1>
                            <div class="overall-rating-title">{{ __('staticwords.OverallRating') }}</div>
                            <div class="rating">
                              @php
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $sub_total = 0;
                              $reviews2 = App\UserReview::where('pro_id', $pro->id)->where('status', '1')->get();
                              @endphp @if(!empty($reviews2[0]))
                              @php
                              $count = App\UserReview::where('pro_id', $pro->id)->count();
                              foreach ($reviews2 as $review) {
                              $review_t = $review->price * 5;
                              $price_t = $review->price * 5;
                              $value_t = $review->value * 5;
                              $sub_total = $sub_total + $review_t + $price_t + $value_t;
                              }
                              $count = ($count * 3) * 5;
                              $rat = $sub_total / $count;
                              $ratings_var2 = ($rat * 100) / 5;
                              @endphp
    
    
                              <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>
    
    
                              @else
                              <div class="text-center">
                                {{ __('No Rating') }}
                              </div>
                              @endif
                            </div>
                            <div class="total-review">{{$count =  count($pro->reviews)}} Ratings & {{$reviewcount}}
                              {{ __('reviews') }}</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                              <label>{{ __('staticwords.Quality') }}</label>
                              <div class="stat-1 stat-bar">
                                <span class="stat-bar-rating" role="stat-bar"
                                  style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Price') }}</label>
                              <div class="stat-2 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar"
                                  style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Value') }}</label>
                              <div class="stat-3 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar"
                                  style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                              </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                          <div class="overall-rating-block satisfied-customer-block text-center">
                            <h3>100%</h3>
                            <div class="overall-rating-title">{{ __('staticwords.SatisfiedCustomer') }}</div>
                            <p>{{ __('staticwords.customerText') }}</p>
                          </div>
                          @endif
                        </div>
                      </div>
    
                      <div class="col-md-9">
                        @foreach($pro->reviews->take(5) as $review)
    
                        @if($review->status == "1")
                        <div class="row">
    
                          <div class="col-md-2">
                            @if($review->users->image !='')
                            <img src="{{ url('/images/user/'.$review->users->image) }}" alt=""
                              class=" rounded-circle img-fluid">
                            @else
                            <img class="rounded-circle img-fluid"
                              src="{{ Avatar::create($review->users->name)->toBase64() }}">
                            @endif
                          </div>
    
                          <div class="col-md-10">
                            <p>
                              <b><i>{{ $review->users->name }}</i></b>
                              <?php
    
                                      $user_count = count([$review]);
                                      $user_sub_total = 0;
                                      $user_review_t = $review->price * 5;
                                      $user_price_t = $review->price * 5;
                                      $user_value_t = $review->value * 5;
                                      $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
    
                                      $user_count = ($user_count * 3) * 5;
                                      $rat1 = $user_sub_total / $user_count;
                                      $ratings_var1 = ($rat1 * 100) / 5;
    
                                    ?>
                              <div class="pull-left">
                                <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                    class="star-ratings-sprite-rating"></span>
                                </div>
                              </div>
    
                              <small class="pull-right rating-date">{{ __('On') }}
                                {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                              <br>
                              <span class="font-weight500">{{ $review->review }}</span>
                            </p>
                          </div>
    
                        </div>
                        <hr>
                        @endif
    
                        @endforeach
                      </div>
                    </div>
                    @else
                    <h5><i class="fa fa-star"></i> {{ __('staticwords.ratetext') }}</h5>
                    @endif
                    @endif
    
                    @else
                    <h5>{{ __('staticwords.Please') }} <a href="{{ route('login') }}">{{ __('staticwords.Login') }}</a>
                      {{ __('staticwords.toratethisproduct') }}</h5>
    
                    @if(count($pro->reviews)>0)
                    <hr>
                    <h5>{{ __('staticwords.recReviews') }}</h5>
    
                    <hr>
                    <div class="row">
    
                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="overall-rating-main-block">
                          <div class="overall-rating-block text-center">
                            <h1>{{ round($overallrating,1) }}</h1>
                            <div class="overall-rating-title">{{ __('staticwords.OverallRating') }}</div>
                            <div class="rating">
                              @php
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $sub_total = 0;
                              $reviews2 = App\UserReview::where('pro_id', $pro->id)->where('status', '1')->get();
                              @endphp @if(!empty($reviews2[0]))
                              @php
                              $count = App\UserReview::where('pro_id', $pro->id)->count();
                              foreach ($reviews2 as $review) {
                              $review_t = $review->price * 5;
                              $price_t = $review->price * 5;
                              $value_t = $review->value * 5;
                              $sub_total = $sub_total + $review_t + $price_t + $value_t;
                              }
                              $count = ($count * 3) * 5;
                              $rat = $sub_total / $count;
                              $ratings_var2 = ($rat * 100) / 5;
                              @endphp
    
    
                              <div class="star-ratings-sprite">
                                <span style="width:<?php echo $ratings_var; ?>%"
                                  class="star-ratings-sprite-rating"></span>
                              </div>
    
    
                              @else
                              <div class="text-center">
                                {{ __('No Rating') }}
                              </div>
                              @endif
                            </div>
                            <div class="total-review">{{$count =  count($pro->reviews)}} Ratings & {{$reviewcount}}
                              reviews</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                              <label>{{ __('staticwords.Quality') }}</label>
                              <div class="stat-1 stat-bar">
                                <span class="stat-bar-rating" role="stat-bar"
                                  style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Price') }}</label>
                              <div class="stat-2 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar"
                                  style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Value') }}</label>
                              <div class="stat-3 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar"
                                  style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                              </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                          <div class="overall-rating-block satisfied-customer-block text-center">
                            <h3>100%</h3>
                            <div class="overall-rating-title">{{ __('staticwords.SatisfiedCustomer') }}</div>
                            <p>{{ __('staticwords.customerText') }}</p>
                          </div>
                          @endif
                        </div>
                      </div>
    
                      <div class="col-md-9">
                        @foreach($pro->reviews->take(5) as $review)
    
                        @if($review->status == "1")
                        <div class="row">
    
                          <div class="col-md-2">
                            @if($review->users->image !='')
                            <img src="{{ url('/images/user/'.$review->users->image) }}" alt=""
                              class=" rounded-circle img-fluid">
                            @else
                            <img class="rounded-circle img-fluid"
                              src="{{ Avatar::create($review->users->name)->toBase64() }}">
                            @endif
                          </div>
    
                          <div class="col-md-10">
                            <p>
                              <b><i>{{ $review->users->name }}</i></b>
                              <?php
    
                                      $user_count = count([$review]);
                                      $user_sub_total = 0;
                                      $user_review_t = $review->price * 5;
                                      $user_price_t = $review->price * 5;
                                      $user_value_t = $review->value * 5;
                                      $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
    
                                      $user_count = ($user_count * 3) * 5;
                                      $rat1 = $user_sub_total / $user_count;
                                      $ratings_var1 = ($rat1 * 100) / 5;
    
                                      ?>
                              <div class="pull-left">
                                <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                    class="star-ratings-sprite-rating"></span>
                                </div>
                              </div>
    
                              <small class="pull-right rating-date">{{ __('On') }}
                                {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                              <br>
                              <span class="font-weight500">{{ $review->review }}</span>
                            </p>
                          </div>
    
                        </div>
                        <hr>
                        @endif
    
                        @endforeach
                      </div>
                    </div>
                    @endif
                    @endauth

                </div>

                <div class="tab-pane fade" id="v-pro-comments" role="tabpanel" aria-labelledby="v-pro-comments-tab">
                  <h3><i class="fa fa-comments-o"></i> {{ __('staticwords.RecentComments') }}</h3>
                  <hr>
                  @forelse($pro->comments as $key=> $comment)

                    <div class="mt-2 media border border-default p-2">
                      <img src="{{ Avatar::create($comment->name)->toGravatar() }}" class="align-self-center mr-3" alt="{{ $comment->name }}">
                      <div class="media-body">
                        <small class="float-right">{{ $comment->created_at->diffForHumans() }}</small>
                        <h5 class="mt-0">{{ $comment->name }}</h5>
                        <p class="mb-0">
                          {!! $comment->comment !!}
                        </p>
                      </div>
                    </div>

                    <div class="appendComment">

                    </div>

                  @empty

                    <h4><i class="fa fa-trophy"></i> {{ __("staticwords.NoCommentProduct") }}</h4>

                  @endforelse

                  @if(count($pro->comments)>5)

                    <p></p>
                    <div align="center" class="remove-row">
                      <button data-proid="{{ $pro->id }}" data-id="{{ $comment->id }}"
                        class="btn-more btn btn-info btn-sm">{{ __('staticwords.LoadMore') }}</button>
                    </div>
                    <p></p>

                  @endif
                      <hr>
                       <h5 class="card-title">{{ __('staticwords.LeaveAComment') }}</h5>

                       <form action="{{ route('post.comment') }}" method="POST" novalidate class="needs-validation">
                         @csrf

                        <div class="form-group">
                          <label>{{ __('staticwords.Name') }}: <span class="text-red">*</span></label>
                          <input value="{{ old('name') }}" required autofocus name="name" type="text" class="form-control"">
                          <span class="text-red">{{$errors->first('name')}}</span>
                        </div>

                        <div class="form-group">
                          
                          <label>{{ __("staticwords.eaddress") }}: <span class="text-red">*</span></label>
                          <input value="{{ old('email') }}" required name="email" type="email" class="form-control" aria-describedby="emailHelp">
                          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                          <input type="hidden" name="id" value="{{$pro->id}}">
                          <span class="text-red">{{$errors->first('email')}}</span>
                        </div>

                        

                        <div class="form-group">
                          <label>{{ __('staticwords.Comment') }}: <span class="text-red">*</span></label>
                          <textarea name="comment" required placeholder="{{ __('staticwords.Comment') }}" class="form-control" rows="3" cols="30">{{ old('comment') }}</textarea>
                          <span class="text-red">{{$errors->first('comment')}}</span>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('staticwords.Submit') }}</button>
                      </form>
                       
                   

                </div>

                <div class="tab-pane fade" id="v-pro-faqs" role="tabpanel" aria-labelledby="v-pro-comments-tab">
                  @forelse($pro->faq as $qid => $fq)
                      <h5>[Q.{{ $qid+1 }}] {{ $fq->question }}</h5>
                      <p class="h6">{!! $fq->answer !!}</p>
                      <hr>
                  @empty
                  
                    <h4>{{ __('staticwords.NOFAQ') }}</h4>
                  
                  @endforelse
                </div>
              </div>
            </div>
          </div>

          

        </div>

        
        <!-- ======================== ====================== small-screen tab end ============================================== -->
        <!-- ==============================================    ============================================== -->
        <!-- ============================================== UPSELL PRODUCTS ============================================== -->
        @if(isset($pro->relsetting))
        <div class="mt-2 card">


          <div class="card-header bg-white">
            <h5 class="card-title">{{ __('staticwords.RelatedProducts') }}</h5>
          </div>

          <div class="card-body">
            <section class="section-random section new-arriavls related-products-block">
              <div
                class="owl-responsive owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs owl-loaded owl-drag">
                @if($pro->relsetting->status == '1')



                <!-- product show manually -->
                @if(isset($pro->relproduct))
                @foreach($pro->relproduct->related_pro as $relpro)
                @php
                $relproduct = App\Product::find($relpro);
                @endphp

                @if(isset($relproduct))
                @foreach($relproduct->subvariants as $orivar)

                @if($orivar->def == '1')

                @php
                $var_name_count = count($orivar['main_attr_id']);

                $name = array();
                $var_name;
                $newarr = array();
                for($i = 0; $i<$var_name_count; $i++){ $var_id=$orivar['main_attr_id'][$i];
                  $var_name[$i]=$orivar['main_attr_value'][$var_id];
                  $name[$i]=App\ProductAttributes::where('id',$var_id)->first();

                  }


                  try{
                  $url =
                  url('details').'/'.$relproduct->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                  }catch(Exception $e)
                  {
                  $url = url('details').'/'.$relproduct->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                  }
                  @endphp

                  <div class="item item-carousel">
                    <div class="products">
                      <div class="product">

                        <div class="product-image">
                          <div class="image {{ $orivar->stock ==0 ? "pro-img-box" : ""}}">

                            <a href="{{$url}}" title="{{$relproduct->name}}">

                              @if(count($relproduct->subvariants)>0)

                              @if(isset($orivar->variantimages['image2']))
                              <img class="owl-lazy ankit {{ $orivar->stock ==0 ? "filterdimage" : ""}}"
                                data-src="{{url('/variantimages/thumbnails/'.$orivar->variantimages['main_image'])}}"
                                alt="{{$relproduct->name}}">
                              <img class="owl-lazy {{ $orivar->stock ==0 ? "filterdimage" : ""}} hover-image"
                                data-src="{{url('/variantimages/hoverthumbnail/'.$orivar->variantimages['image2'])}}"
                                alt="" />
                              @endif

                              @else
                              <img class="owl-lazy {{ $orivar->stock ==0 ? "filterdimage" : ""}}"
                                title="{{ $relproduct->name }}" data-src="{{url('/images/no-image.png')}}"
                                alt="No Image" />

                              @endif


                            </a>
                          </div>

                          @if($orivar->stock == 0)
                          <h5 align="center" class="oottext">Out of stock</h5>
                          @endif

                          @if($orivar->stock != 0 && $orivar->products->selling_start_at != null &&
                          $orivar->products->selling_start_at >= date('Y-m-d H:i:s'))
                          <h5 align="center" class="oottext2">Coming Soon !</h5>
                          @endif
                          <!-- /.image -->

                          @if($relproduct->featured=="1")
                          <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                          @elseif($pro->offer_price=="1")
                          <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                          @else
                          <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                        <!-- /.product-image -->

                        <div class="product-info text-center text-lg-left">
                          <h3 class="name"><a href="{{ $url }}"
                              title="{{$orivar->products->name}}">{{substr($relproduct->name, 0, 20)}}{{strlen($relproduct->name)>20 ? '...' : ""}}</a>
                          </h3>
                          @php
                          $reviews = ProductRating::getReview($relpro);
                          @endphp

                          @if($reviews != 0)


                          <div class="pull-left">
                            <div class="star-ratings-sprite"><span style="width:<?php echo $reviews; ?>%"
                                class="star-ratings-sprite-rating"></span></div>
                          </div>


                          @else
                          <div class="no-rating">{{'No Rating'}}</div>
                          @endif
                          <div class="description"></div>
                          <div class="product-price"> <span class="price">

                              @if($price_login == '0' || Auth::check())

                              @php

                              $result = ProductPrice::getprice($relproduct, $orivar)->getData();

                              @endphp


                              @if($result->offerprice == 0)
                              <span class="price"><i class="{{session()->get('currency')['value']}}"></i>
                                {{ sprintf("%.2f",$result->mainprice*$conversion_rate) }}</span>
                              @else

                              <span class="price"><i
                                  class="{{session()->get('currency')['value']}}"></i>{{ sprintf("%.2f",$result->offerprice*$conversion_rate) }}</span>

                              <span class="price-before-discount"><i
                                  class="{{session()->get('currency')['value']}}"></i>{{  sprintf("%.2f",$result->mainprice*$conversion_rate)  }}</span>

                              @endif

                              @endif
                          </div>
                          <!-- /.product-price -->
                        </div>
                        <!-- /.product-info -->
                        @if($orivar->products->selling_start_at != null && $orivar->products->selling_start_at >=
                        date('Y-m-d H:i:s'))
                        @elseif($orivar->stock == 0)
                        @else
                        <div class="cart clearfix animate-effect">
                          <div class="action">
                            <ul class="list-unstyled">
                              <li id="addCart" class="lnk wishlist">

                                <form method="POST"
                                  action="{{route('add.cart',['id' => $pro->id ,'variantid' =>$orivar->id, 'varprice' => $result->mainprice, 'varofferprice' => $result->offerprice ,'qty' =>$orivar->min_order_qty])}}">
                                  {{ csrf_field() }}
                                  <button title="{{ __('Add to Cart') }}" type="submit" class="addtocartcus btn">
                                    <i class="fa fa-shopping-cart"></i>
                                  </button>
                                </form>


                              </li>

                              @auth
                              @if(Auth::user()->wishlist->count()<1) <li class="lnk wishlist">

                                <a mainid="{{ $orivar->id }}" title="{{ __('Add to wishlist') }}"
                                  class="add-to-cart addtowish cursor-pointer"
                                  data-add="{{url('AddToWishList/'.$orivar->id)}}" title="{{ __('Add to wishlist') }}">
                                  <i class="icon fa fa-heart"></i>
                                </a>

                                </li>
                                @else

                                @php
                                $ifinwishlist =
                                App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$orivar->id)->first();
                                @endphp

                                @if(!empty($ifinwishlist))
                                <li class="lnk wishlist active">
                                  <a mainid="{{ $orivar->id }}" title="{{ __('Remove From wishlist') }}"
                                    class="color000 cursor-pointer add-to-cart removeFrmWish active"
                                    data-remove="{{url('removeWishList/'.$orivar->id)}}" title="Wishlist"> <i
                                      class="icon fa fa-heart"></i> </a>
                                </li>
                                @else
                                <li class="lnk wishlist"> <a title="Add to wish list" mainid="{{ $orivar->id }}"
                                    class="add-to-cart addtowish cursor-pointer text-white"
                                    data-add="{{url('AddToWishList/'.$orivar->id)}}" title="Wishlist"> <i
                                      class="activeOne icon fa fa-heart"></i> </a></li>
                                @endif

                                @endif
                                @endauth

                                <li class="lnk"> <a class="add-to-cart"
                                    href="{{route('compare.product',$orivar->products->id)}}" title="Compare"> <i
                                      class="fa fa-signal" aria-hidden="true"></i> </a> </li>

                                <li class="lnk"> <a class="add-to-cart" title="Download catlog"> <i
                                      class="fa fa-download" aria-hidden="true"></i> </a> </li>

                            </ul>
                          </div>
                          <!-- /.action -->
                        </div>
                        @endif
                        <!-- /.cart -->
                      </div>

                      <!-- /.product -->

                    </div>
                    <!-- /.products -->
                  </div>

                  @endif

                  @endforeach
                  @endif

                  @endforeach
                  @endif

                  @else

                  @foreach($pro->subcategory->products as $relpro)
                  @if(isset($pro->subcategory->products))
                  @foreach($relpro->subvariants as $orivar)

                  @if($orivar->def == '1' && $pro->id != $orivar->products->id)

                  @php
                  $var_name_count = count($orivar['main_attr_id']);

                  $name = array();
                  $var_name;
                  $newarr = array();
                  for($i = 0; $i<$var_name_count; $i++){ $var_id=$orivar['main_attr_id'][$i];
                    $var_name[$i]=$orivar['main_attr_value'][$var_id];
                    $name[$i]=App\ProductAttributes::where('id',$var_id)->first();

                    }


                    try{
                    $url =
                    url('details').'/'.$relpro->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                    }catch(\Exception $e)
                    {
                    $url = url('details').'/'.$relpro->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                    }
                    @endphp

                    <div class="item item-carousel">
                      <div class="products">
                        <div class="product">

                          <div class="product-image">
                            <div class="image {{ $orivar->stock ==0 ? "pro-img-box" : ""}}">

                              <a href="{{$url}}" title="{{$pro->name}}">

                                @if(count($pro->subvariants))

                                @if(isset($orivar->variantimages['image2']))
                                <img class="owl-lazy ankit {{ $orivar->stock ==0 ? "filterdimage" : ""}}"
                                  data-src="{{url('/variantimages/thumbnails/'.$orivar->variantimages['main_image'])}}"
                                  alt="{{$pro->name}}">
                                <img class="owl-lazy {{ $orivar->stock ==0 ? "filterdimage" : ""}} hover-image"
                                  data-src="{{url('/variantimages/hoverthumbnail/'.$orivar->variantimages['image2'])}}"
                                  alt="" />
                                @endif

                                @else
                                <img class="owl-lazy {{ $orivar->stock ==0 ? "filterdimage" : ""}}"
                                  title="{{ $pro->name }}" data-src="{{url('/images/no-image.png')}}" alt="No Image" />

                                @endif



                              </a>
                            </div>

                            @if($orivar->stock == 0)
                            <h5 align="center" class="oottext">
                              {{ __('staticwords.Outofstock') }}
                            </h5>
                            @endif

                            @if($orivar->stock != 0 && $orivar->products->selling_start_at != null &&
                            $orivar->products->selling_start_at >= date('Y-m-d H:i:s'))
                            <h5 align="center" class="oottext2">
                              {{ __('staticwords.ComingSoon') }}
                            </h5>
                            @endif
                            <!-- /.image -->

                            @if($pro->featured=="1")
                            <div class="tag hot"><span>
                                {{ __('staticwords.Hot') }}
                              </span></div>
                            @elseif($pro->offer_price=="1")
                            <div class="tag sale"><span>
                                {{ __('staticwords.Sale') }}
                              </span></div>
                            @else
                            <div class="tag new"><span>
                                {{ __('staticwords.New') }}
                              </span></div>
                            @endif
                          </div>
                          <!-- /.product-image -->

                          <div class="product-info text-center text-lg-left">
                            <h3 class="name"><a href="{{ $url }}"
                                title="{{$relpro->name}}">{{substr($relpro->name, 0, 20)}}{{strlen($relpro->name)>20 ? '...' : ""}}</a>
                            </h3>
                            @php
                            $reviews = ProductRating::getReview($relpro);
                            @endphp

                            @if($reviews != 0)


                            <div class="pull-left">
                              <div class="star-ratings-sprite"><span style="width:<?php echo $reviews; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>
                            </div>


                            @else
                            <div class="no-rating">{{'No Rating'}}</div>
                            @endif
                            <div class="description"></div>
                            <div class="product-price"> <span class="price">

                                @if($price_login == '0' || Auth::check())

                                @php

                                $result = ProductPrice::getprice($relpro, $orivar)->getData();

                                @endphp


                                @if($result->offerprice == 0)
                                <span class="price"><i class="{{session()->get('currency')['value']}}"></i>
                                  {{ sprintf("%.2f",$result->mainprice*$conversion_rate) }}</span>
                                @else

                                <span class="price"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{ sprintf("%.2f",$result->offerprice*$conversion_rate) }}</span>

                                <span class="price-before-discount"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{  sprintf("%.2f",$result->mainprice*$conversion_rate)  }}</span>

                                @endif

                                @endif
                            </div>
                            <!-- /.product-price -->
                          </div>
                          <!-- /.product-info -->
                          @if($orivar->products->selling_start_at != null && $orivar->products->selling_start_at >=
                          date('Y-m-d H:i:s'))
                          @elseif($orivar->stock == 0)
                          @else
                          <div class="cart clearfix animate-effect">
                            <div class="action">
                              <ul class="list-unstyled">
                                <li id="addCart" class="lnk wishlist">

                                  @if($price_login != 1)
                                  <form method="POST"
                                    action="{{route('add.cart',['id' => $pro->id ,'variantid' =>$orivar->id, 'varprice' => $result->mainprice, 'varofferprice' => $result->offerprice ,'qty' =>$orivar->min_order_qty])}}">
                                    {{ csrf_field() }}
                                    <button title="{{ __('Add to Cart') }}" type="submit" class="addtocartcus btn">
                                      <i class="fa fa-shopping-cart"></i>
                                    </button>
                                  </form>
                                  @endif


                                </li>

                                @auth
                                @if(Auth::user()->wishlist->count()<1) <li class="lnk wishlist">

                                  <a mainid="{{ $orivar->id }}" title="Add to wishlist"
                                    class="cursor-pointer add-to-cart addtowish"
                                    data-add="{{url('AddToWishList/'.$orivar->id)}}"
                                    title="{{ __('Add to wishlist') }}"> <i class="icon fa fa-heart"></i>
                                  </a>

                                  </li>
                                  @else

                                  @php
                                  $ifinwishlist =
                                  App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$orivar->id)->first();
                                  @endphp

                                  @if(!empty($ifinwishlist))
                                  <li class="lnk wishlist active">
                                    <a mainid="{{ $orivar->id }}" title="{{ __('Remove From wishlist') }}"
                                      class="color000 cursor-pointer add-to-cart removeFrmWish active"
                                      data-remove="{{url('removeWishList/'.$orivar->id)}}" title="Wishlist"> <i
                                        class="icon fa fa-heart"></i> </a>
                                  </li>
                                  @else
                                  <li class="lnk wishlist"> <a title="{{ __('Add to wish list') }}"
                                      mainid="{{ $orivar->id }}" class="add-to-cart addtowish text-white cursor-pointer"
                                      data-add="{{url('AddToWishList/'.$orivar->id)}}" title="Wishlist"> <i
                                        class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                  @endif
                                  @endauth

                                  <li class="lnk"> <a class="add-to-cart"
                                      href="{{route('compare.product',$relpro->id)}}" title="{{ __('Compare') }}"> <i
                                        class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                              </ul>
                            </div>
                            <!-- /.action -->
                          </div>
                          @endif
                          <!-- /.cart -->
                        </div>

                        <!-- /.product -->

                      </div>
                      <!-- /.products -->
                    </div>

                    @endif

                    @endforeach
                    @endif
                    @endforeach
                    @endif
              </div>
              <!-- /.home-owl-carousel -->
            </section>
          </div>

        </div>
        <br>
        @endif
        <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

        <!-- ============================================== HOT DEALS: END ============================================== -->

      </div><!-- /.col -->
      <!-- ============================================== BRANDS CAROUSEL ============================================== -->
      <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
    </div><!-- /.container -->



  </div><!-- /.body-content -->

  <!-- ============================================================= FOOTER ============================================================= -->

  <!-- ============================================== INFO BOXES ============================================== -->
  <!-- Report Product Modal -->
  <div class="modal fade" id="reportproduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h5 class="modal-title" id="myModalLabel">{{ __('staticwords.ReportProduct') }} {{ $pro->name }}</h5>
        </div>

        <div class="modal-body">
          <form action="{{ route('rep.pro',$pro->id) }}" method="POST">
            {{ csrf_field() }}
            <div class="form group">
              <label>{{ __('staticwords.Subject') }}: <span class="text-red">*</span></label>
              <input required type="text" name="title" class="form-control"
                placeholder="{{ __('staticwords.Whyyoureportingtheprdouctentertitle') }}">
            </div>
            <br>
            <div class="form-group">
              <label>{{ __('staticwords.Email') }}: <span class="text-red">*</span></label>
              <input name="email" required type="email" class="form-control" name="email"
                placeholder="{{ __('staticwords.Enteryouremailaddress') }}">
            </div>

            <div class="form-group">
              <label>{{ __('staticwords.Description') }}: <span class="text-red">*</span></label>
              <textarea required class="form-control" placeholder="{{ __('staticwords.Briefdescriptionofyourissue') }}"
                name="des" id="" cols="30" rows="10"></textarea>
            </div>

            <div class="form-group">
              <button class="btn btn-md btn-primary">{{ __('staticwords.SUBMITFORREVIEW') }}</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="notifyMe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-sm modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="float-right close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h6 class="modal-title" id="exampleModalLabel">Notify me</h6>

        </div>
        <div class="modal-body">
          <form action="" method="POST" class="notifyForm">
            @csrf
            <p class="help-block text-dark">
              Please enter your email to get notified
            </p>
            <div class="form-group">
              <label>Email: <span class="text-red">*</span></label>
              <input name="email" type="email" class="form-control" placeholder="enter your email" required>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-md btn-primary">Submit</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>


  @endsection
  @section('script')

  <script src="{{url('front/vendor/js/additional-methods.min.js')}}"></script>
  <!-- Drfit ZOOM JS -->
  <script src="{{ url('front/vendor/js/drift.min.js') }}"></script>
  <script src="{{ url('js/share.js') }}"></script>
  @include('front.detailpagescript')
  <script>
    var baseUrl = "<?= url('/') ?>";
  </script>
  <script src="{{ url('js/detailpage.js') }}"></script>

  @endsection