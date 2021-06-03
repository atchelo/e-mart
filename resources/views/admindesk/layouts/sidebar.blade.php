  <!-- Left side column. contains the logo and sidebar -->
  <aside id="mainSidebar" class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if(auth()->user()->image != '' && file_exists(public_path().'/images/user/'.auth()->user()->image))
            
            <img src="{{url('images/user/'.auth()->user()->image)}}" class="img-rounded img-responsive" alt="User Image">
           
          @else
            
            <img class="img-responsive" title="{{ Auth::user()->name }}" src="{{ Avatar::create(Auth::user()->name)->toBase64() }}"/>

          @endif
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree">

        <li id="dashboard" class="{{ Nav::isRoute('admindesk.main') }}">
          <a class="treeview" href="{{ route('admindesk.main') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>

          </a>
        </li>




        <li class="treeview {{ Nav::isResource('users') }}">
              <a href="#">
                <i class="fa fa-users" aria-hidden="true"></i> <span>Users</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
    
              <ul class="treeview-menu">
                

              <li class="{{ app('request')->input('filter') == 'customer' ? "active" : "" }}"><a href="{{ route('users.index',['filter' => 'customer']) }} "><i
                  class="fa fa-circle-o"></i>All Customers </a></li>

                <li class="{{ app('request')->input('filter') == 'sellers' ? "active" : "" }}"><a href="{{ route('users.index',['filter' => 'sellers']) }}"><i
                    class="fa fa-circle-o"></i>All Sellers </a></li>

                <li class="{{ app('request')->input('filter') == 'admindesk' ? "active" : "" }}"><a href="{{ route('users.index',['filter' => 'admindesk']) }}"><i
                    class="fa fa-circle-o"></i>All Admin </a></li>

                
              </ul>
        </li>


        <li id="menum" class="{{ Nav::isResource('admin/menu') }}">
          <a class="treeview" href="{{ route('menu.index') }}">
            <i class="fa fa-window-restore" aria-hidden="true"></i> <span>Menu Management</span>

          </a>
        </li>

       @if(isset($vendor_system) && $vendor_system == 1)

        <li class="treeview {{ Nav::isRoute('get.store.request') }} {{ Nav::isResource('stores') }}">
          <a href="#">
            <i class="fa fa-cart-plus" aria-hidden="true"></i> <span>Stores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">

            <li class="{{ Nav::isResource('stores') }}"><a href="{{url('admin/stores')}} "><i
                  class="fa fa-circle-o"></i>Stores </a></li>
            
            @if($vendor_system==1)
            <li class="{{ Nav::isRoute('get.store.request') }}"><a href="{{route('get.store.request')}} "><i
                  class="fa fa-circle-o"></i>Stores Request</a></li>
            @endif
          </ul>
        </li>
        @endif

        <li id="prom"
          class="treeview {{ Nav::isResource('admin/return-policy') }} {{ Nav::isResource('brand') }} {{ Nav::isResource('coupan') }} {{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('grandcategory') }} {{ Nav::isResource('products') }} {{ Nav::isResource('unit') }} {{ Nav::isResource('special') }} {{ Nav::isRoute('attr.index') }} {{ Nav::isRoute('attr.add') }} {{ Nav::isRoute('opt.edit') }} {{ Nav::isRoute('pro.val') }} {{ Nav::isRoute('add.var') }} {{ Nav::isRoute('manage.stock') }} {{ Nav::isRoute('edit.var') }} {{ Nav::isRoute('pro.vars.all') }} {{ Nav::isRoute('import.page') }} {{ Nav::isRoute('requestedbrands.admindesk') }}">
          <a href="#">
            <i class="fa fa-shopping-basket" aria-hidden="true"></i> <span>Products Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Nav::isResource('brand') }}"><a href="{{url('admin/brand')}} "><i
                  class="fa fa-circle-o"></i>Brands</a></li>
            @if($genrals_settings->vendor_enable == 1)
            <li class="{{ Nav::isRoute('requestedbrands.admindesk') }}"><a href="{{route('requestedbrands.admindesk')}} "><i
                  class="fa fa-circle-o"></i>Requested Brands

                @php
                $brands = App\Brand::where('is_requested','=','1')->where('status','0')->orderBy('id','DESC')->count();
                @endphp

                @if($brands !=0)
                <span class="pull-right-container">
                  <small class="label pull-right bg-red">{{ $brands }}</small>
                </span>
                @endif

              </a></li>
            @endif
            <li
              class="treeview {{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('grandcategory') }}">
              <a href="#"><i class="fa fa-circle-o"></i>Categories
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li
                  class="{{ Nav::isRoute('category.index') }} {{ Nav::isRoute('category.create') }} {{ Nav::isRoute('category.edit') }}">
                  <a href="{{url('admin/category')}}"><i class="fa fa-circle-o"></i>Categories</a></li>
                <li class="{{ Nav::isResource('subcategory') }}"><a href="{{url('admin/subcategory')}}"><i
                      class="fa fa-circle-o"></i>Subcategories</a></li>
                <li class="{{ Nav::isResource('grandcategory') }}"><a href="{{url('admin/grandcategory')}}"><i
                      class="fa fa-circle-o"></i>Childcategories</a></li>
              </ul>
            </li>
            <li
              class="{{ Nav::isRoute('pro.vars.all') }} {{ Nav::isResource('products') }} {{ Nav::isRoute('add.var') }} {{ Nav::isRoute('manage.stock') }} {{ Nav::isRoute('edit.var') }}">
              <a href="{{url('admin/products')}} "> <i class="fa fa-circle-o"></i>Products </a></li>
            <li class="{{ Nav::isRoute('import.page') }}"><a href="{{ route('import.page') }}"><i
                  class="fa fa-circle-o"></i>Import Products</a></li>
            <li
              class="{{ Nav::isRoute('pro.val') }} {{ Nav::isRoute('opt.edit') }} {{ Nav::isRoute('attr.add') }}{{ Nav::isRoute('attr.index') }}">
              <a href="{{route('attr.index')}} "> <i class="fa fa-circle-o"></i>Product Attributes </a></li>

            <li class="{{ Nav::isResource('coupan') }}"><a href="{{url('admin/coupan')}} "><i
                  class="fa fa-circle-o"></i>Coupons</a></li>

            <li class="{{ Nav::isResource('admin/return-policy') }}"><a href="{{url('admin/return-policy')}} "><i
                  class="fa fa-circle-o"></i>Return Policy Settings</a></li>

            <li class="{{ Nav::isResource('unit') }}"><a href="{{url('admin/unit') }}"><i
                  class="fa fa-circle-o"></i>Units</a></li>

            <li class="{{ Nav::isResource('special') }}"><a href="{{ url('admin/special') }}"><i
                  class="fa fa-circle-o"></i>Special Offers</a></li>
          </ul>
        </li>

        <li id="ordersm"
          class="treeview {{ Nav::isResource('admindesk.pending.orders') }} {{ Nav::isRoute('admindesk.can.order') }} {{ Nav::isRoute('return.order.show') }} {{ Nav::isRoute('return.order.detail') }} {{ Nav::isRoute('return.order.index') }} {{ Nav::isResource('order') }} {{ Nav::isResource('invoice') }}">

          <a href="#">
            <i class="fa fa-list-alt" aria-hidden="true"></i> <span>Orders & Invoices</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">

            <li class="{{ Nav::isResource('order') }}"><a href="{{route('order.index')}} "><i
                  class="fa fa-circle-o"></i>All Orders </a></li>
            <li class="{{ Nav::isResource('admindesk.pending.orders') }}"><a href="{{route('admindesk.pending.orders')}} "><i
                  class="fa fa-circle-o"></i>Pending Orders </a></li>
            <li class="{{ Nav::isRoute('admindesk.can.order') }}"><a href="{{route('admindesk.can.order')}} "><i
                  class="fa fa-circle-o"></i>Canceled Orders </a></li>

            <li
              class="{{ Nav::isRoute('return.order.index') }} {{ Nav::isRoute('return.order.show') }} {{ Nav::isRoute('return.order.detail') }}">
              <a href="{{route('return.order.index')}} "><i class="fa fa-circle-o"></i>Returned Orders </a></li>

            <li class="{{ Nav::isResource('invoice') }}"><a href="{{url('admin/invoice')}} "><i
                  class="fa fa-circle-o"></i>Invoice Setting</a></li>

          </ul>
        </li>

        <li class="treeview {{ Nav::isRoute('review.index') }} {{ Nav::isRoute('r.ap') }}"> <a href="#">
            <i class="fa fa-star-half-o" aria-hidden="true"></i> <span>Reviews & Ratings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">



            <li class="{{ Nav::isRoute('review.index') }}"><a href="{{url('admin/review')}}"><i
                  class="fa fa-circle-o"></i>All Reviews</a></li>
            <li class="{{ Nav::isRoute('r.ap') }}"><a href="{{url('admin/review_approval')}}"><i
                  class="fa fa-circle-o"></i>Reviews For Approval</a></li>


          </ul>
        </li>

        <li id="martools"
          class="treeview {{ Nav::isRoute('admindesk.push.noti.settings') }} {{ Nav::isRoute('offer.get.settings') }} {{ Nav::isResource('admin/testimonial') }} {{ Nav::isResource('admin/adv') }} {{ Nav::isResource('admin/hotdeal') }} {{ Nav::isResource('admin/detailadvertise') }}">
          <a href="#">
            <i class="fa fa-line-chart" aria-hidden="true"></i><span>Marketing Tools</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{ Nav::isResource('admin/hotdeal') }}"><a href="{{url('admin/hotdeal')}}"><i
                  class="fa fa-circle-o"></i>Hot Deals</a></li>
            <li class="{{ Nav::isResource('admin/detailadvertise') }}"><a href="{{url('admin/detailadvertise')}}"><i
                  class="fa fa-circle-o"></i>Block Advertisments</a></li>
            <li class="{{ Nav::isResource('admin/adv') }}"><a href="{{url('admin/adv')}}"><i
                  class="fa fa-circle-o"></i>Advertisements</a></li>
            <li class="{{ Nav::isResource('admin/testimonial') }}"><a href="{{url('admin/testimonial')}} "><i
                  class="fa fa-circle-o"></i>Testimonials</a></li>
            <li class="{{ Nav::isRoute('offer.get.settings') }}"><a href="{{route('offer.get.settings')}} "><i
                    class="fa fa-circle-o"></i>Offer PopUp Settings</a></li>
            <li class="{{ Nav::isRoute('admindesk.push.noti.settings') }}"><a href="{{route('admindesk.push.noti.settings')}} "><i
                      class="fa fa-circle-o"></i>Push Notifications</a></li>
          </ul>

        </li>


        <li id="location"
          class="treeview {{ Nav::isRoute('country.list.pincode') }} {{ Nav::isRoute('admindesk.desti') }} {{ Nav::isRoute('country.index') }} {{ Nav::isRoute('state.index') }} {{ Nav::isRoute('city.index') }}">
          <a href="#">
            <i class="fa fa-map-marker" aria-hidden="true"></i> <span>Locations</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>


          <ul class="treeview-menu">
            <li class="{{ Nav::isResource('country') }}"><a href="{{url('admin/country')}}"><i
                  class="fa fa-circle-o"></i>Countries</a></li>
            <li class="{{ Nav::isResource('state') }}"><a href="{{url('admin/state')}}"><i
                  class="fa fa-circle-o"></i>States</a></li>
            <li class="{{ Nav::isResource('city') }}"><a href="{{url('admin/city')}}"><i
                  class="fa fa-circle-o"></i>Cities</a></li>
            <li class="{{ Nav::isRoute('country.list.pincode') }}{{ Nav::isRoute('admindesk.desti') }}"><a
                href="{{url('admin/destination')}}"><i class="fa fa-circle-o"></i>Delivery Locations</a></li>
          </ul>



        </li>

        <li id="shippingtax"
          class="treeview {{ Nav::isResource('admin/zone') }}  {{ Nav::isResource('shipping') }} {{ Nav::isResource('tax') }}">
          <a href="#">
            <i class="fa fa-fighter-jet" aria-hidden="true"></i> <span>Shipping & Taxes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{  Nav::isResource('tax_class')  }}"><a href="{{url('admin/tax_class')}}"><i
                  class="fa fa-circle-o"></i>Tax Classes</a></li>
            <li class="{{ Nav::isRoute('tax.index') }}{{ Nav::isRoute('tax.edit') }}{{ Nav::isRoute('tax.create') }}"><a
                href="{{url('admin/tax')}}"><i class="fa fa-circle-o"></i>Tax Rates</a></li>
            <li class="{{ Nav::isResource('admin/zone') }}"><a href="{{url('admin/zone')}}"><i
                  class="fa fa-circle-o"></i>Zones</a></li>
            <li class="{{ Nav::isResource('shipping') }}"><a href="{{url('admin/shipping')}}"><i
                  class="fa fa-circle-o"></i>Shipping</a></li>
          </ul>
        </li>

        <li id="commission" class="treeview {{ Nav::isResource('admin/commission') }}">
          <a href="#">
            <i class="fa fa-pie-chart" aria-hidden="true"></i><span>Commissions</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if($cms->type =='c')
            <li class="{{ Nav::isResource('admin/commission') }}"><a href="{{url('admin/commission')}} "><i
                  class="fa fa-circle-o"></i>Commissions</a></li>
            @endif
            <li><a href="{{url('admin/commission_setting')}} "><i class="fa fa-circle-o"></i>Commission Setting</a></li>
          </ul>
        </li>

        @if($genrals_settings->vendor_enable == 1)

        <li
          class="treeview {{ Nav::isRoute('seller.payout.show.complete') }} {{ Nav::isRoute('seller.payouts.index') }} {{ Nav::isRoute('seller.payout.complete') }}">
          <a href="#">
            <i class="fa fa-slack" aria-hidden="true"></i><span>Seller Payouts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="{{ Nav::isRoute('seller.payouts.index') }}"><a href="{{route('seller.payouts.index')}} "><i
                  class="fa fa-circle-o"></i>Pending Payouts</a></li>

            <li class="{{ Nav::isRoute('seller.payout.show.complete') }} {{ Nav::isRoute('seller.payout.complete') }}">
              <a href="{{ route('seller.payout.complete') }}"><i class="fa fa-circle-o"></i>Completed Payouts</a></li>

          </ul>

        </li>

        @endif




        <li id="mscur" class="{{ Nav::isResource('admin/multiCurrency') }}"><a href="{{url('admin/multiCurrency')}} "><i
              class="fa fa-money"></i><span>Multiple Currencies</span></a></li>

        <li id="slider" class="treeview {{ Nav::isRoute('front.slider') }} {{ Nav::isResource('slider') }}">
          <a href="#">
            <i class="fa fa-sliders" aria-hidden="true"></i><span>Sliders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Nav::isResource('slider') }}"><a href="{{url('admin/slider')}} "><i
                  class="fa fa-circle-o"></i>Sliders</a></li>
            <li class="{{ Nav::isRoute('front.slider') }}">
              <a href="{{route('front.slider')}} "><i class="fa fa-circle-o" aria-hidden="true"></i><span>Top Category Slider</span></a>
            </li>
          </ul>
        </li>
        @if(env('ENABLE_SELLER_SUBS_SYSTEM') == 1)
          <li id="slider" class="treeview {{ Nav::isRoute('seller.subs.listofsubs') }} {{ Nav::isResource('plans') }}">
            <a href="#">
              <i class="fa fa-credit-card"></i>
                {{__("Seller Subscriptions")}}
              </span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                <small class="label pull-right bg-red">NEW</small>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isResource('plans') }}">
                <a href="{{route('seller.subs.plans.index')}} "><i
                    class="fa fa-circle-o"></i> {{__("Packages")}}
                </a>
              </li>
              <li class="{{ Nav::isRoute('seller.subs.listofsubs') }}">
                <a href="{{ route('seller.subs.listofsubs') }}">
                  <i class="fa fa-circle-o" aria-hidden="true"></i><span>{{__("Subscribers List")}}</span>
                </a>
              </li>
            </ul>
          </li>
        @endif

        <li id="slider" class="treeview {{ Nav::isRoute('admindesk.affilate.settings') }} {{ Nav::isRoute('admindesk.affilate.dashboard') }}">
          <a href="#">
            <i class="fa fa-asterisk"></i><span>
              {{__("Affiliate Manager")}}
            </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              <small class="label pull-right bg-red">NEW</small>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Nav::isRoute('admindesk.affilate.settings') }}">
              <a href="{{route('admindesk.affilate.settings')}} "><i
                  class="fa fa-circle-o"></i> {{__("Affiliate Settings")}}
              </a>
            </li>
            @if($aff_system->enable_affilate == 1)
            <li class="{{ Nav::isRoute('admindesk.affilate.dashboard') }}">
              <a href="{{route('admindesk.affilate.dashboard')}} ">
                <i class="fa fa-circle-o" aria-hidden="true"></i><span>{{__("Affiliate Reports")}}</span>
              </a>
            </li>
            @endif
          </ul>
        </li>


        <li id="faqs" class="{{ Nav::isResource('faq') }}"><a href="{{url('admin/faq')}} "><i
              class="fa fa-question-circle-o" aria-hidden="true"></i><span>FAQ's</span></a></li>

        <li class="{{ Nav::isRoute('pwa.setting.index') }}"><a title="Progressive Web App Setting"
            href="{{route('pwa.setting.index')}} "><i class="fa fa-delicious" aria-hidden="true"></i><span>PWA
              Settings</span></a></li>

        <li id="sitesetting"
          class="treeview {{ Nav::isRoute('sms.settings') }} {{ Nav::isRoute('get.view.m.mode') }} {{ Nav::isRoute('customstyle') }} {{ Nav::isRoute('site.lang') }} {{ Nav::isResource('admin/abuse') }} {{ Nav::isResource('admin/bank_details') }} {{ Nav::isRoute('genral.index') }} {{ Nav::isRoute('mail.getset') }} {{ Nav::isRoute('gen.set') }} {{ Nav::isRoute('footer.index') }} {{ Nav::isResource('social') }} {{ Nav::isResource('page') }} {{ Nav::isResource('blog') }} {{ Nav::isRoute('seo.index') }} {{ Nav::isRoute('api.setApiView') }} {{ Nav::isRoute('get.paytm.setting') }} {{ Nav::isResource('page') }} {{ Nav::isRoute('admindesk.dash') }} {{ Nav::isRoute('static.trans')  }}">
          <a href="#">
            <i class="fa fa-cog" aria-hidden="true"></i><span>Site Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Nav::isRoute('genral.index') }}"><a href="{{url('admin/genral')}}"><i
                  class="fa fa-circle-o"></i>General Settings</a></li>
            <li class="{{ Nav::isRoute('static.trans')  }} {{ Nav::isRoute('site.lang') }}"><a
                href="{{route('site.lang')}}"><i class="fa fa-circle-o"></i>Site Languages</a></li>
            <li class="{{ Nav::isRoute('mail.getset') }}"><a href="{{url('admin/mail-settings')}}"><i
                  class="fa fa-circle-o"></i>Mail Settings</a></li>
            <li class="{{ Nav::isRoute('gen.set') }}"><a href="{{route('gen.set')}}"><i
                  class="fa fa-circle-o"></i>Social Login Settings</a></li>
            <li class="{{ Nav::isRoute('sms.settings') }}"><a href="{{route('sms.settings')}}"><i
                    class="fa fa-circle-o"></i>SMS Settings</a></li>
            <li class="{{ Nav::isRoute('admindesk.dash') }}">
              <a href="{{ route('admindesk.dash') }}">
                <i class="fa fa-circle-o" aria-hidden="true"></i><span>Admin Dashboard Settings</span></a>
            </li>

            <li class="{{ Nav::isRoute('get.view.m.mode') }}">
              <a href="{{ route('get.view.m.mode') }}">
                <i class="fa fa-circle-o" aria-hidden="true"></i><span>Maintenance Mode</span></a>
            </li>

            <li class="{{ Nav::isRoute('customstyle') }}">
              <a href="{{ route('customstyle') }}">
                <i class="fa fa-circle-o" aria-hidden="true"></i><span>Custom Style and JS</span></a>
            </li>

            <li class="{{ Nav::isRoute('footer.index') }}"><a href="{{url('admin/footer')}} "><i
                  class="fa fa-circle-o"></i>Footer Customizations</a></li>
            <li class="{{ Nav::isResource('social') }}"><a href="{{url('admin/social')}} "><i
                  class="fa fa-circle-o"></i>Social Handler Settings</a></li>
            <li class="{{ Nav::isResource('blog') }}"><a href="{{url('admin/blog')}}"><i
                  class="fa fa-circle-o"></i>Blogs</a></li>
            <li class="{{ Nav::isResource('admin/bank_details') }}"><a href="{{url('admin/bank_details')}} "><i
                  class="fa fa-circle-o" aria-hidden="true"></i><span>Bank Details</span></a></li>
            <li class="{{ Nav::isResource('page') }}"><a href="{{url('admin/page')}}"><i
                  class="fa fa-circle-o"></i>Pages</a></li>
            <li class="{{ Nav::isRoute('seo.index') }}"><a href="{{url('admin/seo')}} "><i
                  class="fa fa-circle-o"></i>SEO</a></li>
            <li class="{{ Nav::isResource('admin/abuse') }}">
              <a href="{{ url('admin/abuse') }}">
                <i class="fa fa-circle-o" aria-hidden="true"></i> <span>Abuse Word Settings</span></a>
            </li>
          </ul>
        </li>

       

        <li id="sitesetting" class="{{ Nav::isRoute('get.user.terms') }}">
          <a href="{{ route('get.user.terms') }}">
            <i class="fa fa-lock" aria-hidden="true"></i> <span>Terms Settings</span>
          </a>
        </li>

        <li id="theme-settings" class="{{ Nav::isRoute('admindesk.theme.index') }}">
          <a href="{{ route('admindesk.theme.index') }}">
            <i class="fa fa-leaf" aria-hidden="true"></i> <span>Color Options</span>
          </a>
        </li>

        <li class="{{ Nav::isRoute('payment.gateway.settings') }}">

          <a href="{{ route('payment.gateway.settings') }}"><i class="fa fa-money"></i><span>Payment Gateway
              Settings</span></a>

        </li>

        <li class="{{ Nav::isRoute('manual.payment.gateway') }}">

          <a href="{{ route('manual.payment.gateway') }}"><i class="fa fa-money"></i><span>Manual Payment Gateway</span></a>

        </li>

        <li class="{{ Nav::isRoute('widget.setting') }}">

          <a href="{{ route('widget.setting') }}"><i class="fa fa-gg"></i><span>Widgets Settings</span></span></a>

        </li>

        <li class="{{ Nav::isRoute('admindesk.wallet.settings') }}"><a href="{{ route('admindesk.wallet.settings') }}"><i
              class="fa fa-folder" aria-hidden="true"></i><span>Wallet Settings</span></a></li>

        <li id="ticket" class="{{ Nav::isRoute('tickets.admindesk') }} {{ Nav::isRoute('ticket.show') }}">
          <a href="{{ route('tickets.admindesk') }}">
            <i class="fa fa-bullhorn" aria-hidden="true"></i>
            <span>Support Tickets</span></a>
        </li>

        <li id="reppro" class="{{ Nav::isRoute('get.rep.pro') }}">
          <a href="{{ route('get.rep.pro') }}">
            <i class="fa fa-flag" aria-hidden="true"></i> <span>Reported Products</span></a>
        </li>

        <li class="{{ Nav::isRoute('addonmanger.index') }}"><a title="Progressive Web App Setting"
          href="{{route('addonmanger.index')}} "><i class="fa fa-arrow-circle-o-down"></i>
          <span>{{ __("Add-on Manager") }} <small class="label pull-right bg-red">NEW</small></span> </a></li>

        <li class="treeview {{ Nav::isRoute('admindesk.report.mostviewed') }} {{ Nav::isRoute('admindesk.stock.report') }} {{ Nav::isRoute('admindesk.sales.report') }}">
          <a href="#">
            <i class="fa fa-file-text-o"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="{{ Nav::isRoute('admindesk.stock.report') }}">
              <a href="{{ route('admindesk.stock.report') }}">
                <i class="fa fa-circle-o"></i> <span>{{__("Stock Report")}}</span>
              </a>
            </li>

            <li class="{{ Nav::isRoute('admindesk.sales.report') }}">
              <a href="{{ route('admindesk.sales.report') }}">
                <i class="fa fa-circle-o"></i> <span>{{__("Sales Report")}}</span>
              </a>
            </li>

            <li class="{{ Nav::isRoute('admindesk.report.mostviewed') }}">
              <a href="{{ route('admindesk.report.mostviewed') }}">
                <i class="fa fa-circle-o"></i> <span>{{__("Most viewed products")}}</span>
              </a>
            </li>

          </ul>
        </li>

        <li class="treeview {{ Nav::isRoute('systemstatus') }} {{ Nav::isRoute('admindesk.import.demo') }} {{ Nav::isRoute('admindesk.backup.settings') }}">
          <a href="#">
            <i class="fa fa-question-circle" aria-hidden="true"></i><span>Help & Support</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="{{ Nav::isRoute('admindesk.import.demo') }}">
              <a href="{{ url('/admin/import-demo') }}">
                <i class="fa fa-circle-o"></i> <span>Import Demo</span></a>
            </li>

            <li id="reppro" class="{{ Nav::isRoute('admindesk.backup.settings') }}">
              <a href="{{ route('admindesk.backup.settings') }}">
                <i class="fa fa-circle-o"></i> <span>Database Backup</span></a>
            </li>

            <li class="{{ Nav::isRoute('systemstatus') }}">
              <a href="{{ route('systemstatus') }}">
                <i class="fa fa-circle-o"></i> <span>System Status</span>
              </a>
            </li>  

          </ul>
        </li>

        <li >
          <a href="{{ url('clear-cache') }}">
            <i class="fa fa-rocket"></i> <span>Clear Cache</span>
          </a>
        </li>
        

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>