<!DOCTYPE html>
@php
$selected_language = App\Language::firstWhere('lang_code','=',session()->get('changed_language'));
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(isset($selected_language) && $selected_language->rtl_available == 1) dir="rtl" @endif>


<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') {{ $title }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicon -->
  <link rel="icon" href="{{url('images/genral/'.$fevicon)}}" type="image/gif" sizes="16x16">
  <!-- Google fonts -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Animation CSS -->
  <link rel="stylesheet" type="text/css" type="text/css" href="{{ url('css/vendor/animate.min.css') }}">
  <!-- Select2 CSS -->
  <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/select2.min.css') }}">
  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="{{url('admindesk/vendor/dist/css/adminboot3.css')}}">

  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="{{url('admindesk/vendor/Ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ url('admindesk/vendor/icon-font/icon-font.min.css') }}">
  <!-- Custom alert -->
  <link rel="stylesheet" href="{{ url('css/vendor/alert.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="{{url('admindesk/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
 <!-- Admin LTE Theme With RTL -->
  @if(isset($selected_language) && $selected_language->rtl_available == 1)
    <link rel="stylesheet" href="{{ url('admindesk/css/rtl/adminlte.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{url('admindesk/css/rtl/_all-skins.min.css')}}"/>
  @else
    <link type="text/css" rel="stylesheet" href="{{url('admindesk/vendor/dist/css/adminlte.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('admindesk/vendor/dist/css/skins/_all-skins.min.css')}}">
  @endif
  <!-- END -->
  <!--Datepicker-->
  <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/datepicker.css') }}">
  <!-- Preloadrer Pace -->
  <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/pace.min.css') }}">
  <!-- Fontawesome-->
  <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/fontawesome-iconpicker.min.css') }}">
  <!-- Toggle CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/toggle.css') }}">
   <!-- RTL CSS -->
   @if(isset($selected_language) && $selected_language->rtl_available == 1)
   <link rel="stylesheet" href="{{ url('admindesk/css/rtl/fonts-fa.css') }}">
   <link rel="stylesheet" href="{{ url('admindesk/css/rtl/bootstrap-rtl.min.css') }}">
   <link rel="stylesheet" href="{{ url('admindesk/css/rtl/rtl.css') }}">
 @endif
  <!-- TinyMCE Editor -->
  <script src="{{ url('admindesk/plugins/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
  <!-- Default Stylesheet -->
  <link rel="stylesheet" type="text/css" href="{{ url('admindesk/css/style.css') }}">
  @yield('stylesheet')
  <!-- jQuery v3.5.4 -->
  <script src="{{ url('js/jquery.js') }}"></script>
  <!-- Sweetalert -->
  <script src="{{ url('front/vendor/js/sweetalert.min.js') }}"></script>
  <script>
    var addedmsg = "<?=Session::get('added')?>";
    var updatedmsg = "<?=Session::get('updated')?>";
    var deletedmsg = "<?=Session::get('deleted')?>";
    var warningmsg = "<?=Session::get('warning')?>";
  </script>
  <!-- Custom alert -->
  <script src="{{ url('js/alert.js') }}"></script>
  @notify_css
</head>

<body class="hold-transition fixed skin-blue sidebar-mini pace-done">

  <div class="pace  pace-inactive">
    <div class="transform-custom pace-progress" data-progress-text="100%" data-progress="99">
      <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div>
  </div>

  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="{{ route('seller.dboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
          <img title="{{ config('app.name') }}" width="20px"
            src="{{ url('images/genral/'.$genrals_settings->fevicon) }}" alt="" />
        </span>

        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"> <img title="{{ config('app.name') }}" width="20px"
            src="{{ url('images/genral/'.$genrals_settings->fevicon) }}" alt="" />
          {{$genrals_settings->project_name}}</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav id="mainnav" class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" @if(isset($selected_language) && $selected_language->rtl_available != 1) data-toggle="push-menu" @else data-toggle="offcanvas" @endif role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <li><a title="Visit site" href="{{ url('/') }}" target="_blank">Visit site <i class="fa fa-external-link"
                  aria-hidden="true"></i></a></li>

            <li>
              <a title="Change language" href="#"><i class="fa fa-globe" aria-hidden="true"></i>&nbsp;</a>
            </li>
            <li class="m-15">

              <select class="langdropdown2 form-control" onchange="changeLang()" id="changed_lng">
                @foreach(\DB::table('locales')->where('status','=',1)->get() as $lang)
                <option {{ Session::get('changed_language') == $lang->lang_code ? "selected" : ""}}
                  value="{{ $lang->lang_code }}">{{ $lang->name }}</option>
                @endforeach
              </select>
            </li>

            <li class="dropdown notifications-menu">
              <a title="Order Notification" href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell"></i>
                @if(auth()->user()->unreadnotifications->where('n_type','=','order_v')->count())
                <span id="countNoti" class="label label-warning">

                  {{ auth()->user()->unreadnotifications->where('n_type','=','order_v')->count() }}

                </span>
                @endif
              </a>
              <ul @if(auth()->user()->unreadnotifications->where('n_type','=','order_v')->count()>2) @endif
                class="scroll dropdown-menu">
                <li class="header">@if(auth()->user()->unreadnotifications->where('n_type','=','order_v')->count())
                  You have {{ auth()->user()->unreadnotifications->where('n_type','=','order_v')->count() }} New Orders
                  Notification!
                  @else
                  <span class="text-center">No Notifications</span>
                  @endif </li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">

                    @if(auth()->user()->unreadnotifications->where('n_type','=','order_v')->count())

                    @foreach(auth()->user()->unreadNotifications->where('n_type','=','order_v') as $notification)

                    <li>




                      <small class="padding-5 pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i>
                        {{ date('jS M y',strtotime($notification->created_at)) }}</small>

                      <a title="{{ $notification->data['data'] }}" onclick="markread('{{ $notification->id }}')"
                        href="{{ url($notification->url) }}">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        <b>#{{ $notification->data['data'] }}</b>
                      </a>



                    </li>

                    @endforeach

                    @endif

                  </ul>
                </li>
                @if(auth()->user()->unreadnotifications->where('n_type','=','order_v')->count())
                <li class="footer"><a href="{{ route('mark_read_order') }}">Mark all as Read</a></li>
                @endif
              </ul>
            </li>

            @php
            $userimage = @file_get_contents('images/user/'.Auth::user()->image);
            @endphp

            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img
                  src="@auth @if($userimage){{url('images/user/'.Auth::user()->image)}} @else {{ Avatar::create(Auth::user()->name)->toBase64() }} @endif"
                  class="img-circle" alt="User Image" width="22px"> <span class="hidden-xs">Hi !
                  {{ Auth::user()->name }} @endauth</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  @if($userimage)
                  <img src="{{url('images/user/'.Auth::user()->image)}}" class="img-circle" alt="User Image">
                  @else
                  <img class="img-circle" title="{{ Auth::user()->name }}"
                    src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" />
                  @endif
                  <p>
                    @auth {{ Auth::user()->name }} @endauth
                    <small>Member Since: {{ date('M jS Y',strtotime(Auth::user()->created_at)) }}</small>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{ route('get.profile') }}" class="btn btn-default btn-flat">Edit Profile</a>
                  </div>
                  <div class="pull-right">


                    <a class="btn btn-default btn-flat" onclick="sellerlogout()" role="button">
                      {{ __('Sign out') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      class="sellerlogout display-none">
                      {{ csrf_field() }}
                    </form>
                  </div>
                </li>
              </ul>
            </li>
            <li><a class="pointer dropdown-item" onclick="sellerlogout()">
                {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="sellerlogout display-none">
                {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            @if(auth()->user()->image != '' && file_exists(public_path().'/images/user/'.auth()->user()->image))
              <img src="{{url('images/user/'.Auth::user()->image)}}" class="img-rounded img-thumbnail" alt="User Image">
            @else
              <img title="{{ Auth::user()->name }}" src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" />
            @endif
          </div>
          <div class="pull-left info">
            <p>@auth {{ Auth::user()->name }} @endauth</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li class="{{ Nav::isRoute('seller.dboard') }}"><a href="{{route('seller.dboard')}} "><i
                class="fa fa-tachometer"></i><span>Dashboard</span></a>
          <li class="{{ Nav::isRoute('get.profile') }}"><a href="{{route('get.profile')}} "><i class="fa fa-user-circle"
                aria-hidden="true"></i>
              <span>Profile</span></a></li>
          <li class="{{ Nav::isResource('store') }}"><a href="{{route('store.index')}} "><i class="fa fa-address-card-o"
                aria-hidden="true"></i>
              <span>Your Store</span> </a></li>


          <li
            class="treeview {{ Nav::isRoute('seller.get.categories') }} {{ Nav::isRoute('seller.get.subcategories') }} {{ Nav::isRoute('seller.get.childcategories') }} {{ Nav::isRoute('seller.brand.index')  }} {{ Nav::isRoute('seller.pro.vars.all')  }}  {{ Nav::isResource('seller/products') }} {{ Nav::isRoute('seller.import.product') }} {{ Nav::isRoute('seller.add.var') }} {{ Nav::isRoute('seller.manage.stock') }} {{ Nav::isRoute('seller.edit.var') }} {{ Nav::isRoute('seller.pro.vars.all') }} {{ Nav::isRoute('seller.product.attr') }}">
            <a href="#">
              <i class="fa fa-shopping-basket" aria-hidden="true"></i> <span>Products Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isRoute('seller.brand.index')  }}"><a href="{{ route('seller.brand.index') }}"><i
                    class="fa fa-circle-o"></i>Brands</a></li>
              <li class="{{ Nav::isRoute('seller.pro.vars.all')  }} {{ Nav::isResource('seller/products') }}"><a
                  href="{{route('my.products.index')}} "><i class="fa fa-circle-o"></i><span>Products</span></a></li>

              <li
                class="treeview {{ Nav::isRoute('seller.get.categories') }} {{ Nav::isRoute('seller.get.subcategories') }} {{ Nav::isRoute('seller.get.childcategories') }}">
                <a href="#"><i class="fa fa-circle-o"></i>Categories
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Nav::isRoute('seller.get.categories') }}"><a
                      href="{{route('seller.get.categories')}}"><i class="fa fa-circle-o"></i>Categories</a></li>
                  <li class="{{ Nav::isRoute('seller.get.subcategories') }}"><a
                      href="{{route('seller.get.subcategories')}}"><i class="fa fa-circle-o"></i>Subcategories</a></li>
                  <li class="{{ Nav::isRoute('seller.get.childcategories') }}"><a
                      href="{{route('seller.get.childcategories')}}"><i class="fa fa-circle-o"></i>Childcategories</a>
                  </li>
                </ul>
              </li>

              <li class="{{ Nav::isRoute('seller.product.attr') }}"><a href="{{route('seller.product.attr')}} "><i
                    class="fa fa-circle-o"></i><span>Product Attributes</span></a></li>
              @if(env('ENABLE_SELLER_SUBS_SYSTEM') == 1)
              @if(getPlanStatus() == 1 && auth()->user()->activeSubscription->plan->csv_product == 1)
                <li class="{{ Nav::isRoute('seller.import.product') }}">
                  <a href="{{route('seller.import.product')}} "><i class="fa fa-circle-o"></i><span>Import
                      Products</span></a>
                </li>
              @endif
              @else 
              <li class="{{ Nav::isRoute('seller.import.product') }}">
                <a href="{{route('seller.import.product')}} "><i class="fa fa-circle-o"></i><span>Import
                    Products</span></a>
              </li>
              @endif


            </ul>
          </li>

          <li class="treeview {{ Nav::isResource('order') }} {{ Nav::isRoute('seller.canceled.orders') }}">

            <a href="#">
              <i class="fa fa-cart-plus" aria-hidden="true"></i><span>Order Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isResource('order') }}">
                <a href="{{url('seller/orders')}} "><i class="fa fa-circle-o" aria-hidden="true"></i>
                  <span>Orders</span> </a>
              </li>

              <li class="{{ Nav::isRoute('seller.canceled.orders') }}">
                <a href="{{ route('seller.canceled.orders') }}"><i class="fa fa-circle-o"></i> Cancelled Orders</a>
              </li>

              <li class="{{ Nav::isRoute('seller.return.index') }}">
                <a href="{{ route('seller.return.index') }}"><i class="fa fa-circle-o"></i> Returned Orders</a>
              </li>
            </ul>
          </li>
          <li class="{{ Nav::isRoute('vender.invoice.setting') }}"><a href="{{ route('vender.invoice.setting') }}"><i
                class="fa fa-file-text-o" aria-hidden="true"></i> <span>Invoice Setting</span></a></li>

          <li class="{{ Nav::isRoute('seller.shipping.info') }}"><a href="{{ route('seller.shipping.info') }}"><i
                class="fa fa-cubes" aria-hidden="true"></i> <span>Shipping Information</span></a></li>
                
          <li class="{{ Nav::isRoute('seller.my.subscriptions') }}"><a href="{{ route('seller.my.subscriptions') }}"><i
                  class="fa fa-credit-card" aria-hidden="true"></i> <span>My Subscriptions</span></a></li>

          <li
            class="treeview {{ Nav::isRoute('seller.commission') }} {{ Nav::isRoute('vender.payout.show.complete') }} {{ Nav::isRoute('seller.payout.index') }}">
            <a href="#">
              <i class="fa fa-pie-chart"></i> <span>Account Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isRoute('vender.payout.show.complete') }} {{ Nav::isRoute('seller.payout.index') }}"><a
                  href="{{route('seller.payout.index')}} "><i class="fa fa-circle-o"></i> Payouts</a></li>
              <li class="{{ Nav::isRoute('seller.commission') }}"><a href="{{ route('seller.commission') }}"><i
                    class="fa fa-circle-o"></i> Commissions</a></li>

          </li>

        </ul>
        @php $vender = App\Genral::first(); @endphp
        @if($vender->cod=='vendor' || $vender->cod=='both')
        <li><a href="{{url('vender/cod')}} "><i class="fa fa-circle"></i> Cod Payment Setting </a></li>
        @endif
        </ul>
        </li>



      </section> <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">


            <div class="row tile_count">
              @if($errors->any())
              <div class="alert alert-danger">
                <ul>

                  @foreach($errors->all() as $error)

                  <li>
                    <h5>{{$error}}</h5>
                  </li>

                  @endforeach
                </ul>
              </div>


              @endif

              @if (Session::has('added'))
              <script>
                success();
              </script>
              @elseif (Session::has('updated'))
              <script>
                update();
              </script>
              @elseif (Session::has('deleted'))
              <script>
                deleted();
              </script>

              @elseif (Session::has('warning'))
              <script>
                warning();
              </script>

              @endif


              @yield('body')


              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">

      </div>
      <strong>&copy; {{ date('Y') }} | {{ config('app.name') }} | {{$Copyright}}</strong>
      <span class="pull-right"><b>v {{ config('app.version') }}</b></span>
    </footer>

    <div class="control-sidebar-bg">

    </div>
  </div>
  @notify_js
  @notify_render
  <!-- Bootstrap JS -->
  <script src="{{url('admindesk/vendor/dist/js/adminboot3.js')}}"></script>
  <!-- Colorpicker JS -->
  <script src="{{ url('admindesk/vendor/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
  <!-- jQuery UI JS -->
  <script src="{{ url('admindesk/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- plUpload JS -->
  <script src="{{ url('front/vendor/js/plupload.full.min.js') }}"></script>
  <script src="{{ url('front/vendor/js/jquery.ui.plupload.js') }}"></script>

  <!-- Fontawesome iconpicker -->
  <script src="{{ url('front/vendor/js/fontawesome-iconpicker.js') }}"></script>
  <!-- Select2 JS -->
  <script src="{{ url('front/vendor/js/select2.min.js') }}"></script>
  <!-- Moment JS -->
  <script src="{{ url('front/vendor/js/moment-with-locales.js') }}"></script>
  <!-- Datepicker JS -->
  <script src="{{ url('front/vendor/js/datepicker.js') }}"></script>
  <!-- DataTables -->
  <script src="{{asset('front/vendor/js/datatables.min.js')}}" type="text/javascript"></script>
  <!-- SlimScroll -->
  <script src="{{url('admindesk/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{url('admindesk/vendor/fastclick/lib/fastclick.js')}}"></script>
  
  @if(isset($selected_language) && $selected_language->rtl_available == 1)
    <script src="{{url('js/rtladminlte.js')}}"></script>
  @else
    <script src="{{url('admindesk/vendor/dist/js/adminlte.min.js')}}"></script>
  @endif

  <script src="{{ url('admindesk/plugins/pace/pace.min.js') }}"></script>
  <script>
    var brandindexurl = "<?= route('brand.index') ?>";
    var cityindex = "<?= route('city.index') ?>";
    var countyindex = "<?= route('country.index') ?>";
    var baseUrl = "<?= url('/') ?>";
  </script>
  <!-- Default Seller js -->
  <script src="{{ url('js/seller.js') }}"></script>
  @yield('custom-script')
</body>

</html>