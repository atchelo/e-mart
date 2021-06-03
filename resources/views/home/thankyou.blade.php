@extends("front/layout.master")
@section('title','Order Placed Successfully |')
@section("body")
<br>
<div class="body-content">

  <div class="container-fluid">
    <div class="row">
     
      <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="thankyou-content text-center my-5">
                            <img width="350px" src="{{ url("images/thankyou.svg") }}" class="img-fluid mb-5" alt="thankyou">
                            <h2 class="text-success">{{ __('staticwords.Thankyou') }} !!!</h2>
                            <p class="my-4">{{ __("staticwords.orderplacedsuccesstext") }} #{{ app('request')->input('orderid') ?? '' }}</p>
                            <div class="button-list">
                            <a href="{{ app('request')->input('orderid') ? route('user.view.order',app('request')->input('orderid')) : '#' }}" role="button" class="btn btn-primary font-16"><i class="feather icon-map-pin "></i>View Order</a>
                            <a href="{{ url('/') }}" role="button" class="btn btn-success font-16"><i class="feather icon-file-text"></i>Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    </div>
  </div>

</div>
<br>
@endsection