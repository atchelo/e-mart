@extends("admindesk/layouts.master")
@section('title',"Payment Settings |")
@section("body")
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            {{ __('Payment Settings') }}
        </div>
    </div>

    <div class="box-body">
        <div class="nav-tabs-custom">

            <div class="row">
                <div class="col-md-4">
                    <ul id="payment_tabs" class="nav nav-stacked">
                        <li class="active">
                            <a href="#tab_1" data-toggle="tab" aria-expanded="false">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-cc-paypal" aria-hidden="true"></i> Paypal Payment Settings
                                    </div>
                                    <div class="col-md-2">
                                        <i title="{{ $configs->paypal_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->paypal_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>

                            </a>
                        </li>
                        <li>
                            <a href="#tab_2" data-toggle="tab" aria-expanded="true">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-cc-discover" aria-hidden="true"></i>
                                        </i>
                                        Braintree Payment Settings
                                    </div>
                                    <div class="col-md-2">
                                        <i title="{{ $configs->braintree_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->braintree_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><a href="#tab_3" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-cc-stripe" aria-hidden="true"></i>
                                        Stripe Payment Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->stripe_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->stripe_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a></li>
                        <li><a href="#tab_4" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-product-hunt" aria-hidden="true"></i>
                                        Paystack Payment Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->paystack_enable == 1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->paystack_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a></li>
                        <li><a href="#tab_5" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-pied-piper-pp" aria-hidden="true"></i> PayuBiz/PayUMoney Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->payu_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->payu_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a></li>
                        <li><a href="#tab_6" data-toggle="tab">

                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-italic" aria-hidden="true"></i>

                                        Instamojo Payment Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->instamojo_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->instamojo_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>

                            </a></li>
                        <li><a href="#tab_7" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Paytm Payment Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->paytm_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->paytm_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a></li>
                        <li>
                            <a href="#tab_8" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-connectdevelop" aria-hidden="true"></i> Razorpay Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->razorpay==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->razorpay==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#tab_9" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i> PayHere Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->payhere_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->payhere_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#tab_11" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Cashfree Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->cashfree_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->cashfree_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#tab_12" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Skrill Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->skrill_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->skrill_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#tab_13" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Omise Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->omise_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->omise_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#tab_14" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Moli Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->moli_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->moli_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#tab_15" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Rave Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->rave_enable==1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->rave_enable==1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#tab_16" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> SSLCommerze Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->sslcommerze_enable == 1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->sslcommerze_enable == 1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#tab_ap" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> AAMARPAY Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->enable_amarpay == 1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->enable_amarpay == 1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#tab_17" data-toggle="tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> iyzico Payment
                                        Settings
                                    </div>

                                    <div class="col-md-2">
                                        <i title="{{ $configs->iyzico_enable == 1 ? "Active" : "Deactive" }}"
                                            class="fa fa-circle {{ $configs->iyzico_enable == 1 ? "text-green" : "text-red" }}"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                        </li>

                        @if(Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())
                            @include('dpopayment::admindesk.list')
                        @endif

                        @if(Module::has('Bkash') && Module::find('Bkash')->isEnabled())
                            @include('bkash::admindesk.list')
                        @endif

                        <li><a href="#tab_10" data-toggle="tab"><i class="fa fa-university" aria-hidden="true"></i>
                                Bank Transfer Payment Settings </a></li>
                    </ul>
                </div>

                <div class="col-md-8">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab_1">
                            <form action="{{ route('paypal.setting.update') }}" method="POST">
                                @csrf
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <label>Paypal Payment Settings</label>
                                        <div class="pull-right panel-title"><a target="__blank"
                                                title="Get Your Keys From here"
                                                href="https://developer.paypal.com/home/"><i class="fa fa-key"
                                                    aria-hidden="true"></i> Get Your Keys From here</a>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div id="pkey"
                                            class="form-group {{ $configs->paypal_enable==0 ? 'display-none' : ""}}">
                                            <label for="PAYPAL_CLIENT_ID">PAYPAL CLIENT ID :</label>
                                            <input type="text" name="PAYPAL_CLIENT_ID"
                                                value="{{ env('PAYPAL_CLIENT_ID') }}" class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                PAYPAL CLIENT ID</small>
                                        </div>

                                        <div id="psec"
                                            class="form-group eyeCy {{ $configs->paypal_enable==0 ? 'display-none' : ""}}">
                                            <label for="PAYPAL_SECRET">PAYPAL SECRET ID :</label>
                                            <input type="password" value="{{ env('PAYPAL_SECRET') }}"
                                                name="PAYPAL_SECRET" id="pps" class="form-control" id="paypl_secret">

                                            <span toggle="#pps"
                                                class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                PAYPAL SECRET ID</small>
                                        </div>

                                        <div id="pmode"
                                            class="form-group {{ $configs->paypal_enable==0 ? 'display-none' : ""}}">
                                            <label for="MAIL_ENCRYPTION">PAYPAL MODE :</label>
                                            <input type="text" value="{{ env('PAYPAL_MODE') }}" name="PAYPAL_MODE"
                                                class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> For Live use
                                                <b>live</b> and for Test use <b>test</b> as mode</small>
                                        </div>

                                        <input {{ $configs->paypal_enable==1 ? "checked" : "" }} name="paypal_check"
                                            id="toggle" type="checkbox" class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                            for="toggle"></label>


                                        <small class="txt-desc">(Please Enable For Paypal Payment Gateway )</small>
                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif type="submit"
                                            class="btn btn-md btn-primary">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane fade" id="tab_2">
                            <form action="{{ route('bt.setting.update') }}" method="POST">
                                @csrf
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <label>Braintree Payment Settings</label>
                                        <div class="pull-right panel-title"><a target="__blank"
                                                title="Get Your Keys From here"
                                                href="https://developers.braintreepayments.com/"><i class="fa fa-key"
                                                    aria-hidden="true"></i> Get Your Keys From here</a></div>
                                    </div>

                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label for="BRAINTREE_ENV">BRAINTREE ENVIRONMENT :</label>
                                            <input type="text" name="BRAINTREE_ENV" value="{{  env('BRAINTREE_ENV') }}"
                                                class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                BRAINTREE ENVIRONMENT <b>sandbox</b> or <b>live</b></small>
                                        </div>

                                        <div class="form-group">
                                            <label for="BRAINTREE_MERCHANT_ID">BRAINTREE MERCHANT ID :</label>
                                            <input type="text" name="BRAINTREE_MERCHANT_ID"
                                                value="{{  env('BRAINTREE_MERCHANT_ID') }}" class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                BRAINTREE MERCHANT ID Key</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="BRAINTREE_MERCHANT_ID">BRAINTREE MERCHANT ACCOUNT ID :</label>
                                            <input type="text" name="BRAINTREE_MERCHANT_ACCOUNT_ID"
                                                value="{{  env('BRAINTREE_MERCHANT_ACCOUNT_ID') }}"
                                                class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                <a target="__blank"
                                                    href="https://articles.braintreepayments.com/control-panel/important-gateway-credentials#merchant-account-id-versus-merchant-id">BRAINTREE
                                                    MERCHANT ACCOUNT ID</a> Key</small>
                                        </div>


                                        <div class="form-group eyeCy">
                                            <label for="BRAINTREE_PUBLIC_KEY">BRAINTREE PUBLIC KEY :</label>
                                            <input type="password" name="BRAINTREE_PUBLIC_KEY"
                                                value="{{ env('BRAINTREE_PUBLIC_KEY') }}" class="form-control"
                                                id="BRAINTREE_PUBLIC_KEY">
                                            <span toggle="#BRAINTREE_PUBLIC_KEY"
                                                class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                BRAINTREE PUBLIC KEY Key</small>
                                        </div>

                                        <div class="form-group eyeCy">
                                            <label for="BRAINTREE_PRIVATE_KEY">BRAINTREE PRIVATE KEY :</label>
                                            <input type="password" name="BRAINTREE_PRIVATE_KEY"
                                                value="{{ env('BRAINTREE_PRIVATE_KEY') }}" class="form-control"
                                                id="BRAINTREE_PRIVATE_KEY">
                                            <span toggle="#BRAINTREE_PRIVATE_KEY"
                                                class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                BRAINTREE PRIVATE KEY Key</small>
                                        </div>

                                        <input {{ $configs->braintree_enable==1 ? "checked" :"" }}
                                            name="braintree_enable" id="braintree_enable" type="checkbox"
                                            class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                            for="braintree_enable"></label>
                                        <small class="help-block">(Enable it For Braintree Payment Gateway )</small>
                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif type="submit"
                                            class="btn btn-md btn-primary">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane fade" id="tab_3">
                            <form action="{{ route('stripe.setting.update') }}" method="POST">
                                @csrf
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <label>Stripe Payment Settings</label>
                                        <div class="pull-right panel-title"><a target="__blank"
                                                title="Get Your Keys From here"
                                                href="https://stripe.com/docs/development"><i class="fa fa-key"
                                                    aria-hidden="true"></i> Get Your Keys From here</a></div>
                                    </div>

                                    <div class="panel-body">

                                        <div id="skey"
                                            class="form-group {{ $configs->stripe_enable==0 ? 'display-none' : ''}}">
                                            <label for="MAIL_FROM_NAME">STRIPE KEY :</label>
                                            <input type="text" name="STRIPE_KEY" value="{{  env('STRIPE_KEY') }}"
                                                class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                Stripe Key</small>
                                        </div>


                                        <div id="sst"
                                            class="form-group eyeCy {{ $configs->stripe_enable==0 ? 'display-none' : ''}}">
                                            <label for="MAIL_FROM_ADDRESS">STRIPE SECRET :</label>
                                            <input type="password" name="STRIPE_SECRET"
                                                value="{{ env('STRIPE_SECRET') }}" class="form-control" id="strip_sec">
                                            <span toggle="#strip_sec"
                                                class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                Stripe Secret Key</small>
                                        </div>

                                        <input {{ $configs->stripe_enable==1 ? "checked" :"" }} name="strip_check"
                                            id="toggle1" type="checkbox" class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                            for="toggle1"></label>
                                        <small class="help-block">(Enable it For Strip Payment Gateway )</small>
                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif type="submit"
                                            class="btn btn-md btn-primary">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane fade" id="tab_4">
                            <form action="{{ route('store.paystackupdate.settings') }}" method="POST">
                                @csrf
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <label>Paystack Payment Settings</label>
                                        <div class="pull-right panel-title"><a target="__blank"
                                                title="Get Your Keys From here"
                                                href="https://paystack.com/developers"><i class="fa fa-key"
                                                    aria-hidden="true"></i> Get Your Keys From here</a></div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group eyeCy">
                                            <label for="PAYSTACK_PUBLIC_KEY">PAYSTACK PUBLIC KEY :</label>
                                            <input type="password" name="PAYSTACK_PUBLIC_KEY"
                                                value="{{ env('PAYSTACK_PUBLIC_KEY') }}" class="form-control"
                                                id="PAYSTACK_PUBLIC_KEY">
                                            <span toggle="#PAYSTACK_PUBLIC_KEY"
                                                class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                Paystack Public Key</small>
                                        </div>

                                        <div class="form-group eyeCy">
                                            <label for="PAYSTACK_SECRET_KEY">PAYSTACK SECRET KEY :</label>
                                            <input type="password" name="PAYSTACK_SECRET_KEY"
                                                value="{{ env('PAYSTACK_SECRET_KEY') }}" class="form-control"
                                                id="PAYSTACK_SECRET_KEY">
                                            <span toggle="#PAYSTACK_SECRET_KEY"
                                                class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                Paystack Secret Key</small>
                                        </div>

                                        <div class="form-group">

                                            <label>
                                                PAYSTACK PAYMENT URL: <span class="text-red">*</span>
                                            </label>
                                            <input value="{{ env('PAYSTACK_PAYMENT_URL') }}" name="PAYSTACK_PAYMENT_URL"
                                                type="text" class="form-control"
                                                placeholder="enter paystack payment url">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                Paystack payment url</small>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                PAYSTACK MERCHANT EMAIL: <span class="text-red">*</span>
                                            </label>
                                            <input value="{{ env('MERCHANT_EMAIL') }}" name="MERCHANT_EMAIL"
                                                type="email" class="form-control" placeholder="enter merchant email">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                                Paystack merchant url</small>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                PAYSTACK MERCHANT EMAIL: <span class="text-red">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input readonly value="{{ route('paystack.callback') }}" type="text"
                                                    placeholder="https://yoursite.com/public/login/facebook/callback"
                                                    name="PAYSTACK_CALLBACK_URL" class="callback-url form-control">
                                                <span class="input-group-addon" id="basic-addon2">
                                                    <button title="Copy" type="button"
                                                        class="copy btn btn-xs btn-default">
                                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Copy this
                                                Paystack callback url to your app</small>
                                        </div>

                                        <div class="form-group">
                                            <input {{ $configs->paystack_enable == 1 ? "checked" :"" }}
                                                name="paystack_enable" id="paystack_enable" type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                for="paystack_enable"></label>
                                            <small class="help-block">(Enable it For Paystack Payment Gateway )</small>
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif
                                            class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save
                                            Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane fade" id="tab_5">
                            <form action="{{ route('store.payu.settings') }}" method="POST">
                                @csrf
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <label for="MAIL_FROM_NAME"> PayU Money API Setting (Indian Payment gateway)
                                            :</label>
                                        <div class="pull-right panel-title"><a target="__blank"
                                                title="Get Your Keys From here"
                                                href="https://developer.payumoney.com/"><i class="fa fa-key"
                                                    aria-hidden="true"></i> Get Your Keys From here</a>
                                        </div>
                                    </div>

                                    <div class="panel-body">

                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label for="">PayU Default:</label>

                                                <input value="{{ env('PAYU_DEFAULT') }}" type="text" name="PAYU_DEFAULT"
                                                    class="form-control" placeholder="PAYU DEFAULT MODE">
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> If your
                                                    account on PayUMoney use <b>money</b> else use
                                                    <b>biz</b></small>

                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>PayU Method:</label>

                                                <input value="{{ env('PAYU_METHOD') }}" type="text" name="PAYU_METHOD"
                                                    class="form-control" placeholder="PAYU DEFAULT METHOD">
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> For Live
                                                    use
                                                    <b>secure</b> and for Test use <b>test</b> as mode</small>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <div class="eyeCy">

                                                    <label for="PAYU_MERCHANT_KEY"> PayU Merchant Key:</label>
                                                    <input type="password" value="{{ env('PAYU_MERCHANT_KEY') }}"
                                                        name="PAYU_MERCHANT_KEY" id="PAYU_MERCHANT_KEY" type="password"
                                                        class="form-control">
                                                    <span toggle="#PAYU_MERCHANT_KEY"
                                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                                </div>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    Payu
                                                    merchant key</small>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <div class="eyeCy">

                                                    <label for="PAYU_MERCHANT_SALT"> PayU MERCHANT SALT:</label>
                                                    <input type="password" value="{{ env('PAYU_MERCHANT_SALT') }}"
                                                        name="PAYU_MERCHANT_SALT" id="PAYU_MERCHANT_SALT"
                                                        type="password" class="form-control">
                                                    <span toggle="#PAYU_MERCHANT_SALT"
                                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                                </div>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    Payu
                                                    merchant salt</small>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="">PayU Auth Header:</label>
                                                <input type="text" class="form-control" name="PAYU_AUTH_HEADER"
                                                    value="{{ env('PAYU_AUTH_HEADER') }}">
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    payu
                                                    auth header require only if your account is on payumoney</small>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="PAY_U_MONEY_ACC">Is it a PayUMoney account?</label>
                                                <input name="PAY_U_MONEY_ACC" id="PAY_U_MONEY_ACC"
                                                    {{ env('PAY_U_MONEY_ACC')== true ? "checked" : "" }} type="checkbox"
                                                    class="tgl tgl-skewed">
                                                <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes"
                                                    for="PAY_U_MONEY_ACC"></label>
                                            </div>

                                        </div>
                                        <label for="PAYU_REFUND_URL"> PayU API REFUND URL:</label>
                                        <input type="text" value="{{ env('PAYU_REFUND_URL') }}" name="PAYU_REFUND_URL"
                                            id="PAYU_REFUND_URL" class="form-control">

                                        <small class="text-muted">
                                            • For <b>Live</b> : https://payumoney.com/treasury/merchant/refundPayment
                                            <br>
                                            • For <b>Test</b> :
                                            https://test.payumoney.com/treasury/merchant/refundPayment
                                        </small>
                                        <p></p>

                                        <input name="payu_chk" id="toggle-event3"
                                            {{ $configs->payu_enable == "1" ? "checked"  :"" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                            for="toggle-event3"></label>


                                        <small class="txt-desc">(Enable it to active Payu Payment gateway) </small>

                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif
                                            class="btn btn-primary btn-md">
                                            <i class="fa fa-save"></i> Save Setting
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane fade" id="tab_6">

                            <form action="{{ route('instamojo.update') }}" method="POST">
                                @csrf
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <label for="MAIL_FROM_NAME"> Instamojo API Setting:</label>
                                        <div class="pull-right panel-title"><a target="__blank"
                                                title="Get Your Keys From here"
                                                href="https://www.instamojo.com/developers/"><i class="fa fa-key"
                                                    aria-hidden="true"></i> Get Your Keys From here</a></div>
                                    </div>

                                    <div class="panel-body">

                                        <label for="INSTAMOJO_URL"> Instamojo API URL:</label>
                                        <input type="text" value="{{ env('IM_URL') }}" name="IM_URL" id="INSTAMOJO_URL"
                                            class="form-control">

                                        <small class="text-muted">
                                            • For <b>Live</b> use <a href="#">https://instamojo.com/api/1.1/</a>
                                            <br>
                                            • For <b>Test</b> use <a href="">https://test.instamojo.com/api/1.1/</a>
                                        </small>
                                        <p></p>

                                        <label for="IM_REFUND_URL"> Instamojo API REFUND URL:</label>
                                        <input type="text" value="{{ env('IM_REFUND_URL') }}" name="IM_REFUND_URL"
                                            id="IM_REFUND_URL" class="form-control">

                                        <small class="text-muted">
                                            • For <b>Live</b> use <a href="#">https://instamojo.com/api/1.1/refunds/</a>
                                            <br>
                                            • For <b>Test</b> use <a
                                                href="">https://test.instamojo.com/api/1.1/refunds/</a>
                                        </small>
                                        <p></p>

                                        <div class="eyeCy">
                                            <label for="IM_API_KEY"> Private API Key:</label>
                                            <input type="password" value="{{ env('IM_API_KEY') }}" name="IM_API_KEY"
                                                id="INSTAMOJO_AUTH_KEY" type="password" class="form-control">
                                            <span toggle="#INSTAMOJO_AUTH_KEY"
                                                class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <small class="text-muted"><i class="fa fa-question-circle"></i> Please Enter
                                            Instamojo Private API Key </small>
                                        <p></p>

                                        <div class="eyeCy">
                                            <label for="IM_AUTH_TOKEN"> Private Auth Token:</label>
                                            <input type="password" value="{{ env('IM_AUTH_TOKEN') }}"
                                                name="IM_AUTH_TOKEN" id="INSTAMOJO_AUTH_TOKEN" type="password"
                                                class="form-control">
                                            <span toggle="#INSTAMOJO_AUTH_TOKEN"
                                                class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <small class="text-muted"><i class="fa fa-question-circle"></i> Please Enter
                                            Instamojo Auth Token </small>
                                        <p></p>

                                        <input name="instam_check" id="toggle-event4"
                                            {{ $configs->instamojo_enable== "1" ? "checked" : "" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                            for="toggle-event4"></label>

                                        <small class="txt-desc">(Enable it to active Instamojo Payment gateway )</small>
                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif
                                            class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save
                                            Setting</button>
                                    </div>

                                </div>

                            </form>

                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane fade" id="tab_7">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label> Paytm API Setting:</label>
                                    <div class="pull-right panel-title"><a target="__blank"
                                            title="Get Your Keys From here" href="https://developer.paytm.com/docs/"><i
                                                class="fa fa-key" aria-hidden="true"></i> Get Your Keys From here</a>
                                    </div>
                                </div>

                                <form action="{{ route('post.paytm.setting') }}" method="POST">
                                    @csrf
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label for="PAYTM_ENVIRONMENT"> PAYTM ENVIRONMENT: <span
                                                    class="required">*</span></label>
                                            <input type="text" value="{{ env('PAYTM_ENVIRONMENT') }}"
                                                name="PAYTM_ENVIRONMENT" id="PAYTM_ENVIRONMENT" type="password"
                                                class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> For Live use
                                                <b>production</b> and for Test use <b>local</b> as ENVIRONMENT</small>
                                        </div>


                                        <div class="form-group">
                                            <div class="eyeCy">
                                                <label for="PAYTM_MERCHANT_ID">PAYTM MERCHANT ID: <span
                                                        class="required">*</span></label>
                                                <input type="password" value="{{ env('PAYTM_MERCHANT_ID') }}"
                                                    name="PAYTM_MERCHANT_ID" id="PAYTM_MERCHANT_ID" type="password"
                                                    class="form-control">
                                                <span toggle="#PAYTM_MERCHANT_ID"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    PAYTM MERCHANT ID</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="eyeCy">
                                                <label for="PAYTM_MERCHANT_KEY">PAYTM MERCHANT KEY: <span
                                                        class="required">*</span></label>
                                                <input type="password" value="{{ env('PAYTM_MERCHANT_KEY') }}"
                                                    name="PAYTM_MERCHANT_KEY" id="PAYTM_MERCHANT_KEY" type="password"
                                                    class="form-control">
                                                <span toggle="#PAYTM_MERCHANT_KEY"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    PAYTM MERCHANT KEY</small>
                                            </div>
                                        </div>

                                        <p></p>

                                        <input name="paytmchk" id="paytmchk"
                                            {{ $configs->paytm_enable == 1 ? "checked" : "" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                            for="paytmchk"></label>

                                        <small class="txt-desc">(Enable to activate Paytm Payment gateway )</small>

                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif
                                            class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save
                                            Changes</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane fade" id="tab_8">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label> RazorPay API Setting:</label>
                                    <div class="pull-right panel-title"><a target="__blank"
                                            title="Get Your Keys From here" href="https://razorpay.com/docs/"><i
                                                class="fa fa-key" aria-hidden="true"></i> Get Your Keys From here</a>
                                    </div>
                                </div>
                                <form action="{{ route('post.rpay.setting') }}" method="POST">
                                    @csrf
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <div class="eyeCy">
                                                <label for="RAZOR_PAY_KEY"> RazorPay Key: <span
                                                        class="required">*</span></label>
                                                <input type="password" value="{{ env('RAZOR_PAY_KEY') }}"
                                                    name="RAZOR_PAY_KEY" id="RAZOR_PAY_KEY" type="password"
                                                    class="form-control">
                                                <span toggle="#RAZOR_PAY_KEY"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    Razorpay API key</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="eyeCy">
                                                <label for="RAZOR_PAY_SECRET"> RazorPay Secret Key: <span
                                                        class="required">*</span></label>
                                                <input type="password" value="{{ env('RAZOR_PAY_SECRET') }}"
                                                    name="RAZOR_PAY_SECRET" id="RAZOR_PAY_SECRET" type="password"
                                                    class="form-control">
                                                <span toggle="#RAZOR_PAY_SECRET"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    Razorpay secret key</small>
                                            </div>
                                        </div>
                                        <p></p>

                                        <input name="rpaycheck" id="razpay"
                                            {{ $configs->razorpay == "1" ? "checked" : "" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                            for="razpay"></label>

                                        <small class="txt-desc">(Enable to activate Razorpay Payment gateway )</small>
                                        <br><br>

                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif
                                            class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save
                                            Setting</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <!-- /.tab-pane -->
                        <div class="tab-pane fade" id="tab_9">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label> Payhere API Setting:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your Test Keys From here"
                                            href="https://sandbox.payhere.lk/account/signup/createaccount"><i
                                                class="fa fa-key" aria-hidden="true"></i> Get Your Test Keys From here
                                        </a>
                                        |
                                        <a target="__blank" title="Get Your Live Keys From here"
                                            href="https://www.payhere.lk/account/signup/createaccount"><i
                                                class="fa fa-key" aria-hidden="true"></i> Get Your Live Keys From here
                                        </a>
                                    </div>
                                </div>
                                <form action="{{ route('payhere.settings.update') }}" method="POST">
                                    @csrf
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <div class="eyeCy">
                                                <label for="PAYHERE_BUISNESS_APP_CODE"> PAYHERE BUISNESS APP CODE: <span
                                                        class="required">*</span></label>
                                                <input value="{{ env('PAYHERE_BUISNESS_APP_CODE') }}"
                                                    name="PAYHERE_BUISNESS_APP_CODE" id="PAYHERE_BUISNESS_APP_CODE"
                                                    type="text" class="form-control">

                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    PAYHERE BUISNESS APP CODE</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="eyeCy">
                                                <label for="PAYHERE_APP_SECRET"> PAYHERE APP Secret Key: <span
                                                        class="required">*</span></label>
                                                <input type="password" value="{{ env('PAYHERE_APP_SECRET') }}"
                                                    name="PAYHERE_APP_SECRET" id="PAYHERE_APP_SECRET" type="password"
                                                    class="form-control">
                                                <span toggle="#PAYHERE_APP_SECRET"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    PAYHERE APP secret key</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="eyeCy">
                                                <label for="PAYHERE_MERCHANT_ID"> PAYHERE MERCHANT ID: <span
                                                        class="required">*</span></label>
                                                <input value="{{ env('PAYHERE_MERCHANT_ID') }}"
                                                    name="PAYHERE_MERCHANT_ID" id="PAYHERE_MERCHANT_ID" type="text"
                                                    class="form-control">

                                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                    PAYHERE MERCHANT ID CODE</small>
                                            </div>
                                        </div>

                                        <p></p>
                                        <label>Payhere Payment Enviourment:</label>
                                        <input name="PAYHERE_MODE" id="PAYHERE_MODE"
                                            {{ env('PAYHERE_MODE') == "live" ? "checked" : "" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Sandbox" data-tg-on="Live"
                                            for="PAYHERE_MODE"></label>

                                        <small class="txt-desc">(Choose Payhere payment gateway enviourment.)</small>
                                        <br><br>

                                        <input name="payhere_enable" id="payhere_enable"
                                            {{ $configs->payhere_enable == "1" ? "checked" : "" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                            for="payhere_enable"></label>

                                        <small class="txt-desc">(Enable to activate Payhere Payment gateway.)</small>
                                        <br><br>

                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif
                                            class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save
                                            Setting</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->


                        <div class="tab-pane fade" id="tab_11">
                            <div class="panel panel-primary">
                                <div class="panel-heading">


                                    <label> Cashfree Payment Settings:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your Keys From here"
                                            href="https://merchant.cashfree.com/merchants/signup"><i class="fa fa-key"
                                                aria-hidden="true"></i> Get Your Keys From here
                                        </a>
                                    </div>

                                </div>

                                <form id="demo-form2" method="post" enctype="multipart/form-data"
                                    action="{{ route('cashfree.settings') }}">
                                    @csrf

                                    <div class="panel-body">


                                        <div class="form-group">
                                            <label for="my-input">CASHFREE APP ID: <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ env('CASHFREE_APP_ID') }}" id="my-input"
                                                class="form-control" type="text" name="CASHFREE_APP_ID">
                                        </div>

                                        <div class="form-group eyeCy">
                                            <label for="my-input">CASHFREE SECRET KEY: <span
                                                    class="text-danger">*</span></label>
                                            <input id="CASHFREE_SECRET_KEY" class="form-control" type="password"
                                                name="CASHFREE_SECRET_KEY" value="{{ env('CASHFREE_SECRET_KEY') }}">
                                                <span toggle="#CASHFREE_SECRET_KEY" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">CASHFREE END POINT: <span
                                                    class="required">*</span></label>
                                            <input id="my-input" class="form-control" type="text"
                                                name="CASHFREE_END_POINT" value="{{ env('CASHFREE_END_POINT') }}">

                                            <small class="text-muted">
                                                <i class="fa fa-question-circle"></i> • For <b>Live</b> use :
                                                https://api.cashfree.com | • For <b>Test</b> use :
                                                https://test.cashfree.com
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <input name="cashfree_enable" id="cashfree_enable"
                                                {{ $configs->cashfree_enable == "1" ? "checked" : "" }} type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                for="cashfree_enable"></label>

                                            <small class="txt-desc">(Enable to activate Cashfree Payment
                                                gateway.)</small>
                                        </div>

                                    </div>

                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab_12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">


                                    <label> Skrill Payment Settings:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your Keys From here"
                                            href="https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf"><i class="fa fa-key"
                                                aria-hidden="true"></i> Get Your Keys From here
                                        </a>
                                    </div>

                                </div>

                                <form id="demo-form2" method="post" enctype="multipart/form-data"
                                    action="{{ route('skrill.settings') }}">
                                    @csrf

                                    <div class="panel-body">

                                        <div class="alert alert-success">
                                            <p><i class="fa fa-info-circle"></i> Important Note:</p>
                                           <ul>
                                               <li>
                                                Skrill recommends that you open a merchant test account to help you become familiar with the Automated Payments Interface. Test accounts operate in the live environment, but funds cannot be sent from a test account to a live account.

                                                
                                               </li>
                                               <li>
                                                To obtain a test account, please register a personal account at   <a href="http://www.skrill.com" target="__blank">http://www.skrill.com</a>  , and then contact the Merchant Services team with the account details so that they can enable it.
                                               </li>
                                           </ul>
                                        </div>


                                        <div class="form-group">
                                            <label for="my-input">SKRILL MERCHANT EMAIL: <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ env('SKRILL_MERCHANT_EMAIL') }}" id="my-input"
                                                class="form-control" type="text" name="SKRILL_MERCHANT_EMAIL">
                                        </div>

                                        <div class="form-group eyeCy">
                                            <label for="my-input">SKRILL API PASSWORD: <span
                                                    class="text-danger">*</span></label>
                                            <input id="SKRILL_API_PASSWORD" class="form-control" type="password"
                                                name="SKRILL_API_PASSWORD" value="{{ env('SKRILL_API_PASSWORD') }}">
                                                <span toggle="#SKRILL_API_PASSWORD" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <div class="form-group">
                                            <input name="skrill_enable" id="skrill_enable"
                                                {{ $configs->skrill_enable == "1" ? "checked" : "" }} type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                for="skrill_enable"></label>

                                            <small class="txt-desc">(Enable to activate Skrill Payment
                                                gateway.)</small>
                                        </div>

                                    </div>

                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab_13">
                            <div class="panel panel-primary">
                                <div class="panel-heading">


                                    <label> Omise Payment Settings:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your Keys From here"
                                            href="https://dashboard.omise.co/signup?locale=en&origin=direct"><i class="fa fa-key"
                                                aria-hidden="true"></i> Get Your Keys From here
                                        </a>
                                    </div>

                                </div>

                                <form id="demo-form2" method="post" enctype="multipart/form-data"
                                    action="{{ route('omise.settings') }}">
                                    @csrf

                                    <div class="panel-body">

                                        <div class="alert alert-success">
                                            <i class="fa fa-info-circle"></i> {{ __('Omise ONLY Support JPY AND THB Currency.') }}
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">OMISE PUBLIC KEY: <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ env('OMISE_PUBLIC_KEY') }}" id="my-input"
                                                class="form-control" type="text" name="OMISE_PUBLIC_KEY">
                                        </div>

                                        <div class="form-group eyeCy">
                                            <label for="my-input">OMISE SECRET KEY: <span
                                                    class="text-danger">*</span></label>
                                            <input id="OMISE_SECRET_KEY" class="form-control" type="password"
                                                name="OMISE_SECRET_KEY" value="{{ env('OMISE_SECRET_KEY') }}">
                                            <span toggle="#OMISE_SECRET_KEY" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">OMISE API VERSION: <span
                                                    class="text-danger">*</span></label>
                                            <input id="my-input" class="form-control" type="text"
                                                name="OMISE_API_VERSION" value="{{ env('OMISE_API_VERSION') }}">

                                                <small class="text-muted">
                                                    <b>• GET API VERSION <a target="__blank" href="https://dashboard.omise.co/api-version/edit">HERE</a></b>
                                                </small>
                                        </div>

                                        <div class="form-group">
                                            <input name="omise_enable" id="omise_enable"
                                                {{ $configs->omise_enable == "1" ? "checked" : "" }} type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                for="omise_enable"></label>

                                            <small class="txt-desc">(Enable to activate Omise Payment
                                                gateway.)</small>
                                        </div>

                                    </div>

                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab_14">

                            <div class="panel panel-primary">
                                <div class="panel-heading">


                                    <label> Mollie Payment Settings:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your Keys From here"
                                            href="https://www.mollie.com/dashboard/signup?lang=en"><i class="fa fa-key"
                                                aria-hidden="true"></i> Get Your Keys From here
                                        </a>
                                    </div>

                                </div>

                                <form id="demo-form2" method="post" enctype="multipart/form-data"
                                    action="{{ route('moli.settings') }}">
                                    @csrf

                                    <div class="panel-body">

                                        <div class="alert alert-success">
                                            <i class="fa fa-info-circle"></i> {{ __('Moli Not Support INR Currency.') }}
                                        </div>

                                        <div class="form-group eyeCy">
                                            <label for="my-input">MOLLIE KEY: <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ env('MOLLIE_KEY') }}" id="MOLLIE_KEY" class="form-control" type="password" name="MOLLIE_KEY">
                                            <span toggle="#MOLLIE_KEY" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>


                                        <div class="form-group">
                                            <input name="moli_enable" id="moli_enable"
                                                {{ $configs->moli_enable == "1" ? "checked" : "" }} type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                for="moli_enable"></label>

                                            <small class="txt-desc">(Enable to activate Moli Payment
                                                gateway.)</small>
                                        </div>

                                    </div>

                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </form>

                            </div>

                        </div>

                        <div class="tab-pane fade" id="tab_15">

                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    
                                   

                                    <label>Rave Payment Settings:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your Keys From here"
                                            href="https://dashboard.flutterwave.com/login"><i class="fa fa-key"
                                                aria-hidden="true"></i> Get Your Keys From here
                                        </a>
                                    </div>

                                </div>

                                <form id="demo-form2" method="post" enctype="multipart/form-data"
                                    action="{{ route('rave.settings') }}">
                                    @csrf

                                    <div class="panel-body">

                                        <div class="alert alert-success">
                                           <i class="fa fa-info-circle"></i> {{ __('Rave ONLY Support NGN Currency.') }}
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">RAVE PUBLIC KEY: <span
                                                    class="text-danger">*</span></label>
                                            <input placeholder="XXXXXXX" value="{{ env('RAVE_PUBLIC_KEY') }}" id="my-input"
                                                class="form-control" type="password" name="RAVE_PUBLIC_KEY">
                                        </div>

                                        <div class="form-group eyeCy">
                                            <label for="my-input">RAVE SECRET KEY: <span
                                                    class="text-danger">*</span></label>
                                            <input placeholder="XXXXXXX" id="RAVE_SECRET_KEY" class="form-control" type="password"
                                                name="RAVE_SECRET_KEY" value="{{ env('RAVE_SECRET_KEY') }}">
                                            <span toggle="#RAVE_SECRET_KEY" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">RAVE Logo: <span
                                                    class="text-danger">*</span></label>
                                            <input placeholder="eg:http://yoursite.com/logo.png" id="my-input" class="form-control" type="text"
                                                name="RAVE_LOGO" value="{{ env('RAVE_LOGO') }}">
                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">RAVE PREFIX: <span
                                                    class="text-danger">*</span></label>
                                            <input placeholder="eg: rave" id="my-input" class="form-control" type="text"
                                                name="RAVE_PREFIX" value="{{ env('RAVE_PREFIX') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">RAVE COUNTRY: <span
                                                    class="text-danger">*</span></label>
                                            <input placeholder="eg:United States" id="my-input" class="form-control" type="text"
                                                name="RAVE_COUNTRY" value="{{ env('RAVE_COUNTRY') }}">
                                        </div>


                                        <div class="form-group">
                                            <label for="my-input">RAVE ENVIRONMENT: <span
                                                    class="text-danger">*</span></label>
                                            <br>
                                            <input name="RAVE_ENVIRONMENT" id="RAVE_ENVIRONMENT"
                                                {{ env('RAVE_ENVIRONMENT') == "live" ? "checked" : "" }} type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="TEST" data-tg-on="LIVE"
                                                for="RAVE_ENVIRONMENT"></label>
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">Status: <span
                                                class="text-danger">*</span></label>
                                                <br>
                                            <input name="rave_enable" id="rave_enable"
                                                {{ $configs->rave_enable == "1" ? "checked" : "" }} type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                for="rave_enable"></label>

                                            <small class="txt-desc">(Enable to activate Rave Payment
                                                gateway.)</small>
                                        </div>

                                    </div>

                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </form>

                            </div>

                        </div>

                        <div class="tab-pane fade" id="tab_ap">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>AAMARPAY Payment Settings:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your Keys From here"
                                            href="https://aamarpay.com/"><i class="fa fa-key"
                                                aria-hidden="true"></i> Get Your Keys From here
                                        </a>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <form method="post" action="{{ route('change.amarpay.settings') }}">
                                    @csrf

                                    <div class="panel-body">

                                        <div class="alert alert-success">
                                           <i class="fa fa-info-circle"></i> {{ __('AAMARPAY ONLY Support BDT (Taka) Currency.') }}
                                        </div>

                                        <div class="form-group">
                                            <label for="my-input">AAMARPAY STORE ID: <span
                                                    class="text-danger">*</span></label>
                                            <input placeholder="XXXXXXX" value="{{ env('AAMARPAY_STORE_ID') }}" id="my-input"
                                                class="form-control" type="text" name="AAMARPAY_STORE_ID">
                                        </div>

                                        <div class="form-group eyeCy">
                                            <label for="my-input">AAMARPAY KEY: <span
                                                    class="text-danger">*</span></label>
                                            <input placeholder="XXXXXXX" id="AAMARPAY_KEY" class="form-control" type="password"
                                                name="AAMARPAY_KEY" value="{{ env('AAMARPAY_KEY') }}">
                                            <span toggle="#AAMARPAY_KEY" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <div class="form-group">
                                            <input name="AAMARPAY_SANDBOX" id="AAMARPAY_SANDBOX"
                                                {{ env('AAMARPAY_SANDBOX') == "1" ? "checked" : "" }} type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                for="AAMARPAY_SANDBOX"></label>

                                            <small class="txt-desc">(Enable to activate AAMARPAY sandbox
                                                payment.)</small>
                                        </div>

                                        <div class="form-group">
                                            <input name="enable_amarpay" id="enable_amarpay"
                                                {{ $configs->enable_amarpay == "1" ? "checked" : "" }} type="checkbox"
                                                class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                for="enable_amarpay"></label>

                                            <small class="txt-desc">(Enable to activate AAMARPAY Payment
                                                gateway.)</small>
                                        </div>

                                    </div>

                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-save"></i> Save Settings
                                        </button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab_16">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    
                                   

                                    <label>SSLCommerze Payment Settings:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your Keys From here"
                                            href="https://developer.sslcommerz.com/"><i class="fa fa-key"
                                                aria-hidden="true"></i> Get Your Keys From here
                                        </a>
                                    </div>

                                </div>

                                <div class="panel-body">
                                    <form action="{{ route('sslcommerze.settings.update') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label>API Domain URL:</label>
                                            <input value="{{ env('API_DOMAIN_URL') }}" type="text" class="form-control" placeholder="enter api domain url" name="API_DOMAIN_URL">
                                            <small class="text-muted">
                                                
                                                    <p>• For <b>Sandbox</b>, use "https://sandbox.sslcommerz.com" <br> • For <b>Live</b>, use "https://securepay.sslcommerz.com"</p>
                                               
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label>STORE ID:</label>
                                            <input name="STORE_ID" value="{{ env('STORE_ID') }}" type="text" class="form-control" placeholder="enter store id">
                                            <small class="text-muted">
                                                
                                                <i class="fa fa-question-circle"></i> Enter your store id
                                               
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <div class="eyeCy">

                                                <label for="STORE_PASSWORD"> Store Password:</label>
                                                <input type="password" value="{{ env('STORE_PASSWORD') }}"
                                                    name="STORE_PASSWORD" id="STORE_PASSWORD" type="password"
                                                    class="form-control">
                                                <span toggle="#STORE_PASSWORD"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                            </div>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                store password</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Enable LOCALHOST:</label>
                                            <input name="IS_LOCALHOST" id="IS_LOCALHOST"
                                            {{ env('IS_LOCALHOST') == true ? "checked"  :"" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="False" data-tg-on="True"
                                            for="IS_LOCALHOST"></label>
                                            <small class="txt-desc">(Enable it to when it's when sandbox mode is true.) </small>
                                        </div>

                                        <div class="form-group">
                                            <label for="">SANDBOX MODE:</label>
                                            <input name="SANDBOX_MODE" id="SANDBOX_MODE"
                                            {{ env('SANDBOX_MODE') == true ? "checked"  :"" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable"
                                            for="SANDBOX_MODE"></label>
                                            <small class="txt-desc">(Enable or disable sandbox by toggle it.) </small>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Status:</label>
                                            <input name="sslcommerze_enable" id="ssl_status"
                                            {{ $configs->sslcommerze_enable == 1 ? "checked"  :"" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable"
                                            for="ssl_status"></label>
                                            <small class="txt-desc">(Active or deactive payment gateway by toggling it.) </small>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-md btn-primary">
                                                <i class="fa fa-save"></i> Save Settings
                                            </button>
                                        </div>

                                        

                                    </form>
                                </div>
                            </div>

                            
                        </div>

                        <div class="tab-pane fade" id="tab_17">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    
                                   

                                    <label>iyzico Payment Settings:</label>
                                    <div class="pull-right panel-title">
                                        <a target="__blank" title="Get Your TEST Keys From here"
                                            href="https://sandbox-merchant.iyzipay.com/auth/register"><i class="fa fa-key"
                                                aria-hidden="true"></i> Get Your TEST Keys From here
                                        </a>
                                    </div>

                                </div>

                                <div class="panel-body">
                                    <form action="{{ route('iyzico.settings.update') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label>IYZIPAY BASE URL:</label>
                                            <input value="{{ env('IYZIPAY_BASE_URL') }}" type="text" class="form-control" placeholder="enter IYZIPAY BASE URL" name="IYZIPAY_BASE_URL">
                                            <small class="text-muted">
                                                
                                                    <p>• For <b>Sandbox</b>, use "https://sandbox-api.iyzipay.com" <br> • For <b>Live</b>, use "https://api.iyzipay.com"</p>
                                               
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label>IYZIPAY API KEY:</label>
                                            <input name="IYZIPAY_API_KEY" value="{{ env('IYZIPAY_API_KEY') }}" type="text" class="form-control" placeholder="enter IYZIPAY API KEY ID">
                                            <small class="text-muted">
                                                
                                                <i class="fa fa-question-circle"></i> Enter your IYZIPAY API KEY
                                               
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <div class="eyeCy">

                                                <label for="IYZIPAY_SECRET_KEY"> IYZIPAY SECRET KEY:</label>
                                                <input type="password" value="{{ env('IYZIPAY_SECRET_KEY') }}"
                                                    name="IYZIPAY_SECRET_KEY" placeholder="enter IYZIPAY SECRET KEY " id="IYZIPAY_SECRET_KEY" type="password"
                                                    class="form-control">
                                                <span toggle="#IYZIPAY_SECRET_KEY"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                            </div>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                                IYZIPAY SECRET KEY password</small>
                                        </div>


                                        <div class="form-group">
                                            <label for="">Status:</label>
                                            <input name="iyzico_enable" id="iyzico_enable"
                                            {{ $configs->iyzico_enable == 1 ? "checked"  :"" }} type="checkbox"
                                            class="tgl tgl-skewed">
                                            <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable"
                                            for="iyzico_enable"></label>
                                            <small class="txt-desc">(Active or deactive payment gateway by toggling it.) </small>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-md btn-primary">
                                                <i class="fa fa-save"></i> Save Settings
                                            </button>
                                        </div>

                                        

                                    </form>
                                </div>
                            </div>

                            
                        </div>


                        @if(Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())
                            @include('dpopayment::admindesk.tab')
                        @endif

                        @if(Module::has('Bkash') && Module::find('Bkash')->isEnabled())
                            @include('bkash::admindesk.tab')
                        @endif

                        <div class="tab-pane fade" id="tab_10">
                            <form id="demo-form2" method="post" enctype="multipart/form-data"
                                action="{{url('admindesk/bank_details/')}}" data-parsley-validate>
                                {{csrf_field()}}
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Bank Payment Settings
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label>
                                                Bank Name <span class="text-red">*</span>
                                            </label>

                                            <input placeholder="Please enter bank name" type="text" id="first-name"
                                                name="bankname" class="form-control col-md-7 col-xs-12"
                                                value="{{$bank->bankname ?? ''}} ">
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Branch Name <span class="text-red">*</span>
                                            </label>


                                            <input placeholder="Please enter branch name" type="text" id="first-name"
                                                name="branchname" class="form-control col-md-7 col-xs-12"
                                                value="{{$bank->branchname ?? ''}} ">

                                        </div>
                                        <div class="form-group">
                                            <label>
                                                IFSC Code <span class="text-red">*</span>
                                            </label>


                                            <input placeholder="Enter IFSC code" type="text" id="first-name" name="ifsc"
                                                class="form-control col-md-7 col-xs-12" value="{{$bank->ifsc ?? ''}} ">

                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Account Number <span class="text-red">*</span>
                                            </label>

                                            <input placeholder="Enter account no." type="text" id="first-name"
                                                name="account" class="form-control col-md-7 col-xs-12"
                                                value="{{$bank->account ?? ''}}">

                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Account Name <span class="text-red">*</span>
                                            </label>


                                            <input placeholder="Enter account name" type="text" id="first-name"
                                                value="{{$bank->acountname ?? ''}}" name="acountname"
                                                class="form-control col-md-7 col-xs-12">

                                        </div>

                                    </div>

                                    <div class="panel-footer">
                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                            title="This action is disabled in demo !" @endif
                                            class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save
                                            Changes</button>
                                    </div>

                            </form>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </div>
        </div>


        <!-- /.tab-content -->
    </div>
</div>
</div>
@endsection
@section('custom-script')
<script>
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('#payment_tabs a[href="' + activeTab + '"]').tab('show');
    }

    $('.copy').on('click', function () {

        var copyText = $(this).closest('.input-group').find('.callback-url');
        copyText.select();
        //copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");
    });
</script>
@endsection