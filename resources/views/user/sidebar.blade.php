<div class="bg-white">
    <div class="user_header">
        <h5 class="user_m">• {{ __('staticwords.Hi!') }} {{$user->name}}</h5>
    </div>
    <div align="center">
        @if($user->image !="")
        <img src="{{url('images/user/'.$user->image)}}" class="user-photo" />
        @else
        <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="user-photo" />
        @endif
        <h5>{{ $user->email }}</h5>
        <p>{{ __('staticwords.MemberSince') }}: {{ date('M jS Y',strtotime($user->created_at)) }}</p>
    </div>
    <br>
</div>

<!-- ===================== full-screen navigation start======================= -->

<div class="bg-white navigation-small-block">
    <div class="user_header">
        <h4 class="user_m">• {{ __('staticwords.UserNavigation') }}</h5>
    </div>
    <p></p>
    <div class="nav flex-column nav-pills" aria-orientation="vertical">
        <a class="nav-link padding15 {{ Nav::isRoute('user.profile') }}" href="{{ url('/profile') }}"> <i
                class="fa fa-user-circle" aria-hidden="true"></i> {{ __('staticwords.MyAccount') }}</a>

        <a class="nav-link padding15 {{ Nav::isRoute('2fa.get') }}" href="{{ url('/2fa') }}"> <i
                class="fa fa-user-circle" aria-hidden="true"></i> {{ __('2FA Auth') }}</a>
                
        @if($aff_system->enable_affilate == 1)
            <a class="nav-link padding15 {{ Nav::isRoute('user.affiliate.settings') }}" href="{{ route('user.affiliate.settings') }}">
                <i class="fa fa-users" aria-hidden="true"></i> {{ __('Affiliate Dashboard') }}
            </a>
        @endif

        <a class="nav-link padding15 {{ Nav::isRoute('user.view.order') }} {{ Nav::isRoute('user.order') }}" href="{{ url('/order') }}"> <i
                class="fa fa-dot-circle-o" aria-hidden="true"></i> {{ __('staticwords.MyOrders') }}</a>
        @if($wallet_system == 1)
        <a class="nav-link padding15 {{ Nav::isRoute('user.wallet.show') }}" href="{{ route('user.wallet.show') }}"><i
                class="fa fa-credit-card" aria-hidden="true"></i>
            {{ __('staticwords.MyWallet') }}
        </a>
        @endif
        <a class="nav-link padding15 {{ Nav::isRoute('failed.txn') }}" href="{{ route('failed.txn') }}"> <i
                class="fa fa-spinner" aria-hidden="true"></i> {{ __('staticwords.MyFailedTrancations') }}</a>

        <a class="nav-link padding15 {{ Nav::isRoute('user_t') }}" href="{{ route('user_t') }}">&nbsp;<i
                class="fa fa-ticket" aria-hidden="true"></i> {{ __('staticwords.MyTickets') }}</a>

        <a class="nav-link padding15 {{ Nav::isRoute('get.address') }}" href="{{ route('get.address') }}"><i
                class="fa fa-list-alt" aria-hidden="true"></i> {{ __('staticwords.ManageAddress') }}</a>

        <a class="nav-link padding15 {{ Nav::isRoute('mybanklist') }}" href="{{ route('mybanklist') }}"> <i
                class="fa fa-cube" aria-hidden="true"></i> {{ __('staticwords.MyBankAccounts') }}</a>



        @if($vendor_system == 1)
        @if(empty($sellerac) && Auth::user()->role_id != "a")

        <a class="nav-link padding15 {{ Nav::isRoute('applyforseller') }}" href="{{ route('applyforseller') }}"><i
                class="fa fa-address-card-o" aria-hidden="true"></i> {{ __('staticwords.ApplyforSellerAccount') }}</a>

        @elseif(Auth::user()->role_id != "a")
        <a class="nav-link padding15{{ Nav::isRoute('seller.dboard') }}" href="{{ route('seller.dboard') }}"><i
                class="fa fa-address-card-o" aria-hidden="true"></i> {{ __('staticwords.SellerDashboard') }}</a>

        @endif
        @endif


        <a class="nav-link padding15" data-toggle="modal" href="#myModal"><i class="fa fa-eye" aria-hidden="true"></i>
            {{ __('staticwords.ChangePassword') }}</a>


        <a class="nav-link padding15" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
            <i class="fa fa-power-off" aria-hidden="true"></i> {{ __('Sign out?') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
            @csrf
        </form>
        <br>
    </div>
</div>

<!-- =========================small screen navigation start ============================ -->
<div class="order-accordion navigation-full-screen">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
        <div class="card">
            <div class="card-heading" role="tab" id="headingOne">
                <h4 class="card-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false"
                        aria-controls="collapseOne">
                        <div class="user_header">
                            <h4 class="user_m">• {{ __('staticwords.UserNavigation') }}</h5>
                        </div>
                    </a>
                    </h5>
            </div>
            <div id="collapseOne" class="panel-collapse collapseOne collapse" role="tabpanel"
                aria-labelledby="headingOne">
                <div class="card-body">
                    <div class="nav flex-column nav-pills" aria-orientation="vertical">
                        <a class="nav-link padding15 {{ Nav::isRoute('user.profile') }}" href="{{ url('/profile') }}"> <i
                                class="fa fa-user-circle" aria-hidden="true"></i> {{ __('staticwords.MyAccount') }}</a>
                
                        <a class="nav-link padding15 {{ Nav::isRoute('2fa.get') }}" href="{{ url('/2fa') }}"> <i
                                class="fa fa-user-circle" aria-hidden="true"></i> {{ __('2FA Auth') }}</a>

                        @if($aff_system->enable_affilate == 1)
                            <a class="nav-link padding15 {{ Nav::isRoute('user.affiliate.settings') }}" href="{{ route('user.affiliate.settings') }}">
                                <i class="fa fa-users" aria-hidden="true"></i> {{ __('Affiliate Dashboard') }}
                            </a>
                        @endif
                
                        <a class="nav-link padding15 {{ Nav::isRoute('user.view.order') }} {{ Nav::isRoute('user.order') }}" href="{{ url('/order') }}"> <i
                                class="fa fa-dot-circle-o" aria-hidden="true"></i> {{ __('staticwords.MyOrders') }}</a>
                        @if($wallet_system == 1)
                        <a class="nav-link padding15 {{ Nav::isRoute('user.wallet.show') }}" href="{{ route('user.wallet.show') }}"><i
                                class="fa fa-credit-card" aria-hidden="true"></i>
                            {{ __('staticwords.MyWallet') }}
                        </a>
                        @endif
                        <a class="nav-link padding15 {{ Nav::isRoute('failed.txn') }}" href="{{ route('failed.txn') }}"> <i
                                class="fa fa-spinner" aria-hidden="true"></i> {{ __('staticwords.MyFailedTrancations') }}</a>
                
                        <a class="nav-link padding15 {{ Nav::isRoute('user_t') }}" href="{{ route('user_t') }}">&nbsp;<i
                                class="fa fa-ticket" aria-hidden="true"></i> {{ __('staticwords.MyTickets') }}</a>
                
                        <a class="nav-link padding15 {{ Nav::isRoute('get.address') }}" href="{{ route('get.address') }}"><i
                                class="fa fa-list-alt" aria-hidden="true"></i> {{ __('staticwords.ManageAddress') }}</a>
                
                        <a class="nav-link padding15 {{ Nav::isRoute('mybanklist') }}" href="{{ route('mybanklist') }}"> <i
                                class="fa fa-cube" aria-hidden="true"></i> {{ __('staticwords.MyBankAccounts') }}</a>
                
                
                
                        @if($vendor_system == 1)
                        @if(empty($sellerac) && Auth::user()->role_id != "a")
                
                        <a class="nav-link padding15 {{ Nav::isRoute('applyforseller') }}" href="{{ route('applyforseller') }}"><i
                                class="fa fa-address-card-o" aria-hidden="true"></i> {{ __('staticwords.ApplyforSellerAccount') }}</a>
                
                        @elseif(Auth::user()->role_id != "a")
                        <a class="nav-link padding15{{ Nav::isRoute('seller.dboard') }}" href="{{ route('seller.dboard') }}"><i
                                class="fa fa-address-card-o" aria-hidden="true"></i> {{ __('staticwords.SellerDashboard') }}</a>
                
                        @endif
                        @endif
                
                
                        <a class="nav-link padding15" data-toggle="modal" href="#myModal"><i class="fa fa-eye" aria-hidden="true"></i>
                            {{ __('staticwords.ChangePassword') }}</a>
                
                
                        <a class="nav-link padding15" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off" aria-hidden="true"></i> {{ __('Sign out?') }}
                        </a>
                
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                            @csrf
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- =========================small screen navigation end ============================ -->