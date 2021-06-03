<div class="d-lg-none overlay"></div>

<div class="top-bar animate-dropdown top-main-block-one">
    <div class="container-fluid">
        <div class="header-top-inner">
            <div class="cnt-account">
                <div class="display-none-block">
                    <ul class="list-unstyled">

                        @if(Auth::check())
        
                        <li id="notifications" class="dropdown notifications-menu">
                          <noti-d></noti-d>
                        </li>
        
                        @if(Auth::user()->role_id == "a")
                        <li class="first"><a target="_blank" title="Go to Admin Panel" href="{{route('admindesk.main')}}"
                            title="Admin">Admin</a></li>
                        @elseif(Auth::user()->role_id == 'v')
                        @if(isset(Auth::user()->store))
                        <li class="first"><a target="_blank" title="{{ __('staticwords.SellerDashboard') }}"
                            href="{{route('seller.dboard')}}" title="Admin">{{ __('staticwords.SellerDashboard') }}</a>
                        </li>
                        @endif
                        @endif
                        <li class="myaccount"><a href="{{url('profile')}}"
                            title="My Account"><span>{{ __('staticwords.MyAccount') }}</span></a></li>
                       
                        <li class="wishlist" id="desktop-wis-count">
                          <main-wish-count></main-wish-count>
                        </li>
                        @endif
                        @if(Auth::check())
                        <li class="login">
        
                          <a role="button" onclick="logout()">
                            {{ __('staticwords.Logout') }}
                          </a>
        
                          <form action="{{ route('logout') }}" method="POST" class="logout-form display-none">
                            {{ csrf_field() }}
                          </form>
        
                        </li>
                        @else
        
                        <li class="login animate-dropdown-one">
                          <a href="{{url('login')}}" title="Login">
                            <span>
                              {{ __('staticwords.Login') }}
                            </span>
                          </a>
                        </li>
                        <li class="myaccount"><a href="{{url('register')}}" title="Register"><span>
                              {{ __('staticwords.Register') }}
                            </span></a></li>
                        @endif
                        <li id="comparedesktop">
                            <compare-c-count></compare-c-count>
                        </li>
                        @auth
                        <li class="check"><a data-toggle="modal" href="#feeddesk"
                            title="Feedback"><span>{{ __('staticwords.Feedback') }}</span></a></li>
        
                        <li><a href="{{ route('hdesk') }}" title="Help Desk & Support">{{ __('staticwords.hpd') }}</a></li>

                         <!-- Feedback Modal -->
                    <div data-backdrop="static" data-keyboard="false" class="modal fade" id="feeddesk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="feed-head modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                  aria-hidden="true">&times;</span></button>
                              <h5 class="modal-title" id="myModalLabel"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                  {{ __('staticwords.FeedBackUs') }} </h5>
                              </div>
                              <div class="modal-body">
                              <div class="info-feed alert bg-yellow">
                                  <i class="fa fa-info-circle"></i>&nbsp;{{ __('staticwords.feedline') }}
                              </div>
                              <form class="needs-validation" action="{{ route('send.feedback') }}" method="POST" novalidate>
                                  {{ csrf_field() }}
                                  <div class="form-group">
                                  <label class="font-weight-bold" for="">{{ __('staticwords.Name') }}: <span
                                      class="required">*</span></label>
                                  <input required="" type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                                  </div>
                                  <div class="form-group">
                                  <label class="font-weight-bold" for="">{{ __('staticwords.Email') }}: <span
                                      class="required">*</span></label>
                                  <input required="" type="email" name="email" class="form-control"
                                      value="{{ Auth::user()->email }}">
                                  </div>
                                  <div class="form-group">
                                  <label class="font-weight-bold" for="">{{ __('staticwords.Message') }}: <span
                                      class="required">*</span></label>
                                  <textarea required name="msg"
                                      placeholder="Tell us What You Like about us? or What should we do to more to improve our portal."
                                      cols="30" rows="10" class="form-control"></textarea>
                                  </div>
                                  <div class="rat">
                                  <label class="font-weight-bold">&nbsp;{{ __('staticwords.RateUs') }}: <span
                                      class="required">*</span></label>
                                  <ul id="starRating" data-stars="5">
                                  </ul>
                                  <input type="hidden" id="" name="rate" value="1" class="getStar">
                                  </div>
                                  <button type="submit" class="btn btn-primary">
                                  {{ __('staticwords.Send') }}
                                  </button>
                              </form>
                              </div>
                          </div>
                      </div>
                  </div>
        
                        
                        @endauth
                      </ul>
                </div>
            </div>
            <!-- /.cnt-account -->

            <div class="cnt-block">
                <ul class="list-unstyled list-inline">
    
                  @if($auto->enabel_multicurrency == '1')
                  <select name="currency" onchange="val()" id="currency">
    
                    @if($auto->currency_by_country == 1)

                
                      
                        @forelse($manualcurrency as $currency)
        
                          @if(isset($currency->currency))
          
                            <option {{ Session::get('currency')['mainid'] == $currency->currency->id ? "selected" : "" }}
                              value="{{ $currency->currency->id }}">{{ $currency->currency->code }}
                            </option>
          
                          @endif

                        @empty

                          <option value="{{ $defCurrency->currency->id }}">{{ $defCurrency->currency->code }}</option>
        
                        @endforelse
                        

                    @else
    
                    @foreach($multiCurrency as $currency)
                      <option {{ Session::get('currency')['mainid'] == $currency->currency->id ? "selected" : "" }}
                        value="{{ $currency->currency->id }}">{{ $currency->currency->code }}
                      </option>
                    @endforeach
    
                    @endif

    
                  </select>
                  @else

    
                  <select name="currency" onchange="val()" id="currency">
    
                    <option value="{{ $defCurrency->currency->id }}">{{ $defCurrency->currency->code }}</option>
    
                  </select>
    
                  @endif
    
                  <select class="changed_language" name="" id="changed_lng">
                    @foreach($langauges as $lang)
                    <option {{ Session::get('changed_language') == $lang->lang_code ? "selected" : ""}}
                      value="{{ $lang->lang_code }}">{{ $lang->name }}</option>
                    @endforeach
                  </select>

                </ul>
                <!-- /.list-unstyled -->
            </div>
            <!-- /.cnt-cart -->
            <div class="clearfix"></div>
        </div>
        <!-- /.header-top-inner -->
    </div>
    <!-- /.container -->
</div>
<div class="main-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6  col-md-2 col-sm-2 col-lg-2 logo-holder">
                <!-- ============ LOGO ========================================= -->
                <div class="logo"> <a href="{{url('/')}}" title="{{$title}}"> <img height="50px"
                      src="{{url('images/genral/'.$front_logo)}}" alt="logo"> </a> </div>
                <!-- /.logo -->
                <!--=================== LOGO : END ================= -->
              </div>
            <!-- /.logo-holder -->

            <div class="col-lg-7 col-md-7 col-sm-7 col-12 top-search-holder">
                <!-- ====================== SEARCH AREA ======================== -->
                <div class="search-area">

                    <form method="get" enctype="multipart/form-data" action="{{url('search/')}}">
      
                      <div class="control-group search-cat-box">
      
                        <div class="input-group">
                          <span class="input-group-btn">
                            <select id="searchDropMenu" class="" name="cat">
                              <option value="all">{{ __('staticwords.AllCategory') }}</option>
                              <i class="fa fa-caret-down" aria-hidden="true"></i>
                              @foreach($searchCategories as $cat)
                                <option value="{{$cat->id}}">{{$cat->title}}</option>
                              @endforeach
                            </select>
                          </span>
                          <input required="" class="search-field" value="" placeholder="{{ __('staticwords.search') }}"
                            name="keyword">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                              <i class="fa fa-search"></i>
                            </button>
                          </span>
                        </div>
                        <!-- <button class="search-button"></button> -->
                      </div>
      
                    </form>
      
                  </div>
                <!-- ============================= SEARCH AREA : END ============================ -->
            </div>


            <!-- /.top-search-holder -->
            <div class="col-lg-3 col-md-3 col-sm-3 col-0 animate-dropdown top-cart-row">

                <!-- ==================== SHOPPING CART DROPDOWN ============================================================= -->
                <div class="dropdown dropdown-cart dropdown-cart-one">
                     <a href="#" id="cart-total-d" class="lnk-cart">
                        
                        <cart-total-d></cart-total-d>
                       
                      </a>
        
                    @guest
        
                    <div class="login-block">
                      <a href="{{ route('login') }}">{{ __('staticwords.Login') }}</a>
                    </div>
                    @endguest
                </div>
                @auth
                    @if($wallet_system == 1)
                        <div class="dropdown dropdown-cart">

                            <a title="My Wallet" href="{{ route('user.wallet.show') }}" class="lnk-cart">

                                <div class="items-cart-inner">
                                    @if($theme_settings && $theme_settings->key == 'pattern2' || $theme_settings->key == 'pattern5')
                                        <img style="width: 35px" class="wallet" src="{{ url('images/wallet-black.png') }}" alt="wallet_icon">
                                    @else
                                        <img style="width: 35px" class="wallet" src="{{ url('images/wallet.png') }}" alt="wallet_icon">
                                    @endif
                                    <div class="total-price-basket"> <span class="lbl">{{ __("staticwords.Wallet") }}</span>
                                        <span class="value">
                                            <i class="{{ session()->get('currency')['value'] }}"></i>
                                            @if(isset(Auth::user()->wallet) && Auth::user()->wallet->status == 1)
                        
                                            {{ sprintf("%.2f",currency(Auth::user()->wallet->balance, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}
                        
                                            @else
                                            0.00
                                            @endif
                                        </span>
                                    </div>

                                </div>
                            </a>

                        </div>
                    @endif
                @endauth

               
                <!-- /.dropdown-cart -->

                <!-- ======================= SHOPPING CART DROPDOWN : END================================ -->
            </div>
            <!-- /.top-cart-row -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

</div>

<div class="header-nav animate-dropdown header-nav-screen">
    <div style="padding-right : 0px; padding-left : 0px;" class="container-fluid corner">
      <div class="yamm navbar navbar-default" role="navigation">

        <div class="nav-bg-class">
          <div class="bignavbar navbar-collapse collapse display-none" id="mc-horizontal-menu-collapse">
            <div class="nav-outer">
              <ul class="nav navbar-nav">

                @include('front.layout.topmenu')

              </ul>
              <!-- /.navbar-nav -->
              <div class="clearfix"></div>
            </div>
            <!-- /.nav-outer -->
          </div>
          <!-- /.navbar-collapse -->

        </div>
        <!-- /.nav-bg-class -->
      </div>
      <!-- /.navbar-default -->
    </div>
    <!-- /.container-class -->

  </div>

<!-- Mobile Screen -->

<div class="wrapper" id="mobile-nav">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div id="dismiss">
            <i class="fa fa-arrow-left"></i>
        </div>

        <div class="sidebar-header">
            <h5>{{ __('staticwords.Welcome') }} @auth {{ Auth::user()->name }} @endauth</h5>
        </div>

        <ul class="mobile-menu-tabs nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="mob-tab nav-link active" id="menu-tab" data-toggle="tab" href="#menus" role="tab" aria-controls="menu" aria-selected="true">{{ __('staticwords.Menu') }}</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link mob-tab" id="categories-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="categories" aria-selected="false">{{ __('staticwords.Categories') }}</a>
          </li>
        </ul>
        
        <div class="menubar tab-content" id="myTabContent">

          <div class="tab-pane fade show active" id="menus" role="tabpanel" aria-labelledby="home-tab">
              <ul id="mobilemenubar" class="list-unstyled components">
                {{-- @include('front.layout.mobilemenu') --}}
                <mobile-menu-sidebar></mobile-menu-sidebar>
              </ul>

              <ul class="list-unstyled components">
                <p class="ml-2">{{ $footer3_widget->footer2 }}</p>
                @auth
                <li>
                    <a href="{{url('profile')}}" title="My Account"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp;{{ __('staticwords.MyAccount') }}</a>
                </li>
                <div class="dropdown-divider"></div>
                @if($wallet_system == 1)
                <li>
                    <a href="{{ route('user.wallet.show') }}">
                      <i class="fa fa-google-wallet"></i> &nbsp;&nbsp;{{ __('staticwords.MyWallet') }}
    
                        ( <i class="{{session()->get('currency')['value']}}"></i>@if(isset(Auth::user()->wallet)
                        && Auth::user()->wallet->status == 1)
    
                        {{ sprintf("%.2f",currency(Auth::user()->wallet->balance, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}
    
                        @else
                        0.00
                        @endif)
                      </a>
                </li>
                @endif
                <div class="dropdown-divider"></div>
                <li>
                    <a href="{{url('order')}}" title="Order History"><i class="fa fa-tasks"></i>&nbsp;&nbsp;{{ __('staticwords.OrderHistory') }}</a>
                </li>
                @endauth
                @auth
                  <div id="mobilewishlist">
                    <mobile-wish-count></mobile-wish-count>
                  </div>
                @endauth
                <div id="comparemobile">
                  <compare-m-count></compare-m-count>
                </div>
    
              </ul>

            <ul class="list-unstyled components">

              <p class="ml-2">{{$footer3_widget->footer3}}</p>

              @foreach($widget3items as $fm)
                  <li>
                      @if($fm->link_by == 'page')
                          <a title="{{ $fm->title }}" href="{{ route('page.slug',$fm->gotopage['slug']) }}">
                            <i class="fa fa-circle-o"></i>&nbsp;&nbsp;{{ $fm->title }}
                          </a>
                      @else
                          <a target="__blank" title="{{ $fm->title }}" href="{{ $fm->url }}">
                            <i class="fa fa-circle-o"></i>&nbsp;&nbsp;{{ $fm->title }}
                          </a>
                      @endif
                  </li>
              @endforeach

          </ul>
          <ul class="list-unstyled components">
              <p class="ml-2">{{ $footer3_widget->footer4 }}</p>
              @foreach($widget4items as $foo)
              <li>
                  @if($foo->link_by == 'page')
                      <a title="{{ $foo->title }}" href="{{ route('page.slug',$foo->gotopage->slug) }}">
                        <i class="fa fa-circle-o"></i>&nbsp;&nbsp;{{ $foo->title }}
                      </a>
                  @else
                      <a target="__blank" title="{{ $foo->title }}" href="{{ $foo->url }}">
                        <i class="fa fa-circle-o"></i>&nbsp;&nbsp;{{ $foo->title }}
                      </a>
                  @endif
              </li>
              @endforeach
          </ul>
        
          <ul class="list-unstyled components">
              
              <p class="ml-2">{{ __('staticwords.Others') }}</p>
                
            
              <li>
                  <a href="{{ route('hdesk') }}" title="Help Desk &amp; Support"><i class="fa fa-ticket"></i>
                  &nbsp;&nbsp;{{ __('staticwords.hpd') }}</a>
              </li>
              <div class="dropdown-divider"></div>
              <li>
                  <a title="{{ __('staticwords.ContactUs') }}" href="{{ route('contact.us') }}" title="Contact us"><i class="fa fa-phone"></i>&nbsp;&nbsp;{{ __('staticwords.ContactUs') }}
                  </a>
              </li>
              <div class="dropdown-divider"></div>
              <li>
                <a href="{{url('faq')}}" title="faq"> <i class="fa fa-question-circle"></i>&nbsp;&nbsp;{{ __('staticwords.faqs') }}</a>
              </li>
          </ul>

          </div>

          <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="profile-tab">
            <ul id="mobilesidebar" class="list-unstyled components">

              <mobile-category-sidebar></mobile-category-sidebar>
  
              {{-- @include('front.mobile.categorysidebar') --}}
  
            </ul>
          </div>

        </div>

        
        
        
        
       

    </nav>

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fa fa-align-left"></i>
                </button>

                <div class="d-flex justify-content-start">
                  <a href="{{ url('/') }}">
                      <img class="logo-img" src="{{url('images/genral/'.$front_logo)}}" alt="min_logo">
                  </a>
                </div>

                <div class="control-group search-cat-box" id="search-xs">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <select id="searchDropMenu" class="" name="cat">
                                <option value="all">{{ __('staticwords.AllCategory') }}</option>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                                @foreach($searchCategories as $cat)
                                  <option value="{{$cat->id}}">{{$cat->title}}</option>
                                @endforeach
                            </select>
                        </span>
                        <input required="" class="search-field" value="" placeholder="{{ __('staticwords.search') }}" name="keyword">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <div style="position: relative;top:-3px;" class="btn-group">


                    <button data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn d-inline-block d-lg-none ml-auto" type="button" aria-expanded="false"
                    aria-label="Toggle navigation">
                        <i class="text-white fa fa-user"></i>
                        @auth
                          @if($unreadnotifications > 0 ) 
                          
                            <span class="dotbadge badge badge-pill badge-danger">
                                &nbsp;
                            </span>

                          @endif
                        @endauth
                    </button>

                    <div id="dropdownmenu2" class="mt-0 square2 kdrop dropdown-menu {{ isset($selected_language) && $selected_language->rtl_available == 1 ? 'dropdown-menu-left' : 'dropdown-menu-right' }} dropdown-menu-lg-left">

                      <a href="{{ url('/cart') }}" class="dropdown-item" role="button"> {{ __("staticwords.Yourcart") }} (
                        @auth 

                          {{ Auth::user()->cart->count() }} 

                        @else 
                            
                          @php

                            $c = array();
                            $c = Session::get('cart');

                            if(!empty($c)){
                              $c = array_filter($c);
                            }else{
                              $c = [];
                            }

                          @endphp

                         {{ count($c) }} 
                         
                      
                      @endauth

                      )
                    
                    </a>

                      @auth

                      <a data-toggle="modal" data-target="#notificationModal" href="{{ route('login') }}" class="dropdown-item" role="button">
                        
                        {{ __('staticwords.notifications') }} 

                        <span class="badge badge-pill badge-danger">
                          {{ $unreadnotifications }}
                        </span>

                      </a>

                     
                      @endauth
                      @guest
                      <a href="{{ route('login') }}" class="dropdown-item" role="button">
                        {{ __('staticwords.Login') }}
                      </a>
                      <a href="{{ route('register') }}" class="dropdown-item" role="button">
                        {{ __('staticwords.Register') }}
                      </a>
                      @endguest
                      @auth
                      <a class="dropdown-item" role="button" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                            {{ __('staticwords.Logout') }}
                      </a>
    
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-form display-none">
                            @csrf
                        </form>
                    @endauth

                      <a data-toggle="modal" data-target="#currencyModal" class="dropdown-item" role="button">{{ __("staticwords.Currency") }} ({{  session()->get('currency')['id'] }})</a>

                      <a data-toggle="modal" data-target="#langModal" class="dropdown-item" role="button">{{ __("staticwords.Langauge") }} ({{ app()->getLocale() }})</a>

                     
                      
                      @auth

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" data-toggle="modal" href="#feed" title="Feedback"> {{ __('staticwords.Feedback') }}</a>
                      
                      @endauth
                      

                    </div>

                  </div>

                  @auth 
                    <div data-backdrop="static" data-keyboard="false" id="notificationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="notificationModaltitle" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                           

                            <button class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>

                            @if($unreadnotifications > 0)

                              <a class="color111 float-right" href="{{ route('clearall') }}">{{ __('staticwords.MarkallasRead') }}</a>

                            @endif
                            
                            <h6 class="modal-title" id="my-modal-title">{{ __("staticwords.notifications") }}   
                                <span class="badge badge-pill badge-danger">
                                  {{ $unreadnotifications }}
                                </span>
                            </h6>

                          </div>
                          <div class="modal-body">

                            @foreach(auth()->user()->unreadnotifications()->where('n_type','!=','order_v')->get() as $notification)

                              <small class="padding5P float-right"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                {{ date('jS M y',strtotime($notification->created_at)) }}</small>
                              <a class="font-weight600 color111" href="{{ $notification->n_type == "order" ? url('view/order/'.$notification->url) : url('mytickets') }}"
                                 onclick="markread('{{ $notification->id }}')"><i class="fa fa-circle-o"
                                  aria-hidden="true"></i>
                                {{ $notification->data['data'] }}
                              </a>

                              <div class="dropdown-divider"></div>

                            @endforeach

                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Feedback Modal -->
                    <div data-backdrop="static" data-keyboard="false" class="modal fade" id="feed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="feed-head modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    {{ __('staticwords.FeedBackUs') }} </h5>
                                </div>
                                <div class="modal-body">
                                <div class="info-feed alert bg-yellow">
                                    <i class="fa fa-info-circle"></i>&nbsp;{{ __('staticwords.feedline') }}
                                </div>
                                <form class="needs-validation" action="{{ route('send.feedback') }}" method="POST" novalidate>
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                    <label class="font-weight-bold" for="">{{ __('staticwords.Name') }}: <span
                                        class="required">*</span></label>
                                    <input required="" type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="form-group">
                                    <label class="font-weight-bold" for="">{{ __('staticwords.Email') }}: <span
                                        class="required">*</span></label>
                                    <input required="" type="email" name="email" class="form-control"
                                        value="{{ Auth::user()->email }}">
                                    </div>
                                    <div class="form-group">
                                    <label class="font-weight-bold" for="">{{ __('staticwords.Message') }}: <span
                                        class="required">*</span></label>
                                    <textarea required name="msg"
                                        placeholder="Tell us What You Like about us? or What should we do to more to improve our portal."
                                        cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="rat">
                                    <label class="font-weight-bold">&nbsp;{{ __('staticwords.RateUs') }}: <span
                                        class="required">*</span></label>
                                    <ul id="starRating" data-stars="5">
                                    </ul>
                                    <input type="hidden" id="" name="rate" value="1" class="getStar">
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                    {{ __('staticwords.Send') }}
                                    </button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  @endauth 
                  

                  <div data-backdrop="static" data-keyboard="false" id="currencyModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-header">

                          <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>

                          <h5 class="modal-title" id="my-modal-title">
                            {{__('staticwords.ChangeCurrency')}}
                          </h5>
                          
                        </div>
                        <div class="modal-body">

                         
                      @if($auto->enabel_multicurrency == '1')
                      <select class="form-control currency" name="currency" onchange="val()" id="currency">
        
                        @if($auto->currency_by_country == 1)

                          @if(!empty($manualcurrency))
                            @foreach($manualcurrency as $currency)
            
                                @if(isset($currency->currency))
                
                                  <option {{ Session::get('currency')['mainid'] == $currency->currency->id ? "selected" : "" }}
                                    value="{{ $currency->currency->id }}">{{ $currency->currency->code }}
                                  </option>
                
                                @endif
            
                            @endforeach
                          @else
                            <option value="{{ $defCurrency->currency->id }}">{{ $defCurrency->currency->code }}</option>
                          @endif

                        @else
                       
                        @foreach($multiCurrency as $currency)
                          <option {{ Session::get('currency')['mainid'] == $currency->currency->id ? "selected" : "" }}
                            value="{{ $currency->currency->id }}">{{ $currency->currency->code }}
                          </option>
                        @endforeach
        
                        @endif
        
                      </select>
                      @else
        
                      <select class="form-control currency" name="currency" onchange="val()" id="currency">
        
                        <option value="{{ $defCurrency->currency->id }}">{{ $defCurrency->currency->code }}</option>
        
                      </select>
        
                      @endif

                        </div>
                      </div>
                    </div>
                  </div>

                  <div data-backdrop="static" data-keyboard="false" id="langModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-header">

                          <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>

                          <h5 class="modal-title" id="my-modal-title">
                            {{__('Change Language')}}
                          </h5>
                          
                        </div>
                        <div class="modal-body">
                            
    
                            <select class="form-control changed_language" name="" id="changed_lng">
                              @foreach($langauges as $lang)
                              <option {{ Session::get('changed_language') == $lang->lang_code ? "selected" : ""}}
                                value="{{ $lang->lang_code }}">{{ $lang->name }}</option>
                              @endforeach
                            </select>

                        </div>
                      </div>
                    </div>
                  </div>


            </div>
            <div class="control-group search-cat-box" id="search-sm">
                <form method="get" enctype="multipart/form-data" action="{{url('search/')}}">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <select id="searchDropMenu" class="" name="cat">
                                <option value="all">{{ __('staticwords.AllCategory') }}</option>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                                @foreach($searchCategories as $cat)
                                  <option value="{{$cat->id}}">{{$cat->title}}</option>
                                @endforeach
                            </select>
                        </span>
                        <input required="" class="search-field" value="" placeholder="{{ __('staticwords.search') }}" name="keyword">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </nav>


    </div>

</div>

