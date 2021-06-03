@extends("front/layout.master")
@section('title','Seller Plans |')
@section("body")
<br>
<div class="body-content">

    <div class="container">
        <div class="pricing-header px-3 py-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Pricing</h1>
            <p class="lead">
                {{ __("staticwords.pricingtext") }}
            </p>
        </div>

        <section class="pricing py-5">
            <div class="container">
                <div class="row">
                    @forelse ($plans as $plan)
                        <div class="mt-2 col-lg-3">
                            <div class="card mb-5 mb-lg-0">
                                <div class="card-body">
                                    <h5 class="card-title text-muted text-uppercase text-center">
                                        {{ $plan->name }} 
                                    </h5>
                                    <h6 class="card-price text-center"> <i class="fa {{ session()->get('currency')['value'] }}"></i> {{ sprintf("%.2f",currency($plan->price, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}<span class="period">/{{ $plan->period }}</span></h6>
                                    <hr>
                                    {!! $plan->detail !!}
                                    
                                    @if(auth()->user()->activeSubscription && date('Y-m-d h:i:s') <= auth()->user()->activeSubscription->end_date && auth()->user()->activeSubscription->status == 1 && auth()->user()->activeSubscription->plan->id == $plan->id)
                                            <button type="button" class="btn btn-block btn-success text-uppercase">
                                                    <i class="fa fa-check-circle"></i> {{__("Subscribed")}}
                                            </button>
                                        @else 
                                             <form action="{{ route('seller.plans.payment.screen') }}">
                                                @csrf
                                                <input type="hidden" name="planid" value="{{ Crypt::encrypt($plan->unique_id) }}">
                                               
                                                <button type="submit" class="btn btn-block btn-primary text-uppercase">Get Started with {{ $plan->name }} </button>
                                            </form>
                                        @endif
                                    
                                    
                                </div>
                            </div>
                        </div>
                    @empty

                    <div class="col-md-12">
                        <h4 class="text-center">
                            {{ __("No Plans Found !") }}
                        </h4>
                    </div>
                        
                    @endforelse
                    
                </div>
            </div>
        </section>
    </div>

</div>
<br>
@endsection