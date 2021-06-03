@extends("front/layout.master")
@section('title','Seller Plans |')
@section("body")
<br>
<div class="body-content">

    <div class="container">
        <div class="row">
            <div class="offset-lg-2 col-lg-8 col-sm-12 col-md-12 col-xs-12">
                @if($configs->paytm_enable == 1)
                <div class="shadow-sm card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __("staticwords.Pay") }} <i
                                class="fa {{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",currency($plan->price, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}
                            {{__("with")}} {{__("PAYTM")}} </h5>
                        <p class="card-text">
                            {{ __("Netbanking, Debit/Credit Card, Paytm wallet, UPI available") }}
                        </p>
                        <img class="float-right shadow-sm" src="{{ url('images/payment/paytm.png') }}" width="60px"
                            alt="paytm.png" />
                        <form action="{{ route('pay.subscription.paytm') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ app('request')->input('planid') }}">
                            <button type="submit" class="btn btn-primary">
                                Proceed to BUY {{$plan->name}} Plan
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                @if($configs->stripe_enable == 1)
                <div class="shadow-sm mt-2 card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __("staticwords.Pay") }} <i
                                class="fa {{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",currency($plan->price, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}
                            {{__("with")}} {{__("STRIPE")}} </h5>
                        <p class="card-text">
                            {{ __("Pay via any credit card.") }}
                        </p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-wrapper"></div>
                                <div class="form-container active">
                                  
                                </div>
                             </div>
                            
                             <div class="mt-2 col-md-6">
                                <form method="POST" action="{{ route('pay.subscription.stripe') }}" id="credit-card">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <input max="13" class="form-control" placeholder="Card number" type="tel" name="number">
                                        @if ($errors->has('number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Full name" type="text" name="name">
                                        @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="MM/YY" type="tel" name="expiry">
                                        @if ($errors->has('expiry'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('expiry') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="CVC" type="password" name="cvc">
                                        @if ($errors->has('cvc'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cvc') }}</strong>
                                        </span>
                                        @endif
                                    </div>
        
                                    <img class="float-right shadow-sm" src="{{ url('images/payment/stripe.png') }}" width="60px"
                                    alt="stripe.png" />
                                    <div class="form-group">
                                        <input type="hidden" name="plan_id" value="{{ app('request')->input('planid') }}">
                                        <button type="submit" class="btn btn-primary">
                                            Proceed to BUY {{$plan->name}} Plan
                                        </button>
                                    </div>
        
        
                                </form>
                             </div>
                        </div>

                        
                    </div>
                </div>
                @endif

                @if($configs->razorpay == 1)
                <div class="shadow-sm mt-2 card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __("staticwords.Pay") }} <i
                                class="fa {{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",currency($plan->price, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}
                            {{__("with")}} {{__("RAZORPAY")}} </h5>
                        <p class="card-text">
                            {{ __("Netbanking, Debit/Credit Card, Amazonpay, Wallet, UPI available") }}
                        </p>
                        <img class="float-right shadow-sm" src="{{ url('images/payment/razorpay.png') }}" width="60px"
                            alt="razorpay.png" />
                        <form id="rpayform" action="{{ route('pay.subscription.razorpay') }}" method="POST">

                            <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ env('RAZOR_PAY_KEY') }}"
                                data-amount="{{ sprintf("%.2f",currency($plan->price, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false))*100 }}"
                                data-buttontext="Proceed to BUY {{$plan->name}} Plan" data-name="{{ $title }}"
                                data-description="Payment For Order {{ uniqid() }}"
                                data-image="{{url('images/genral/'.$front_logo)}}"
                                data-prefill.name="{{ auth()->user()->name }}"
                                data-prefill.email="{{ auth()->user()->email }}" data-theme.color="#157ED2">
                            </script>
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <input type="hidden" name="plan_id" value="{{ app('request')->input('planid') }}">
                        </form>
                    </div>
                </div>
                @endif

                @if($configs->paypal_enable == 1)
                <div class="shadow-sm mt-2 card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __("staticwords.Pay") }} <i
                                class="fa {{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",currency($plan->price, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}
                            {{__("with")}} {{__("PAYPAL")}} </h5>
                        <p class="card-text">
                            {{ __("Debit/Credit Card, Wallet available") }}
                        </p>
                        <img class="float-right shadow-sm" src="{{ url('images/payment/paypal.png') }}" width="60px"
                            alt="paypal.png" />
                        <form action="{{ route('pay.subscription.paypal') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ app('request')->input('planid') }}">
                            <button type="submit" class="btn btn-primary">
                                Proceed to BUY {{$plan->name}} Plan
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
<br>
@endsection
@section('script')
    <script src="{{ url('front/vendor/js/card.js') }}"></script>
    <script>
        "use strict";

        new Card({
            form: document.querySelector('#credit-card'),
            container: '.card-wrapper'
        });
    </script>
@endsection