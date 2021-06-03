@extends("front.layout.master") 
@section('title','Pay '.session()->get('currency')['id'].$amount.' | ') 
@section("body")
  <div class="container-fluid">
    <div class="bg-white col-md-12">
        <br>
        <h2>{{ __('staticwords.ADD') }} &nbsp;<i class="{{ $defCurrency->currency_symbol }}"></i> {{ $amount }} {{ __('staticwords.via') }}</h2>
        <hr>
        
        <div class="container">
           <div class="row">

             @if($configs->paypal_enable == 1)
                <div class="col-md-3">
                  <form action="{{ route('wallet.add.using.paypal') }}" method="POST">
                  @csrf
                  <input type="hidden" value="{{ $amount }}" name="amount">
                  <button type="submit" class="paypal-buy-now-button">
                            <span>{{ __('staticwords.Pay') }} &nbsp;<i class="{{ $defCurrency->currency_symbol }}"></i> {{ $amount }} {{ __('staticwords.with') }}</span> 
                           <svg aria-label="PayPal" xmlns="http://www.w3.org/2000/svg" width="90" height="33" viewBox="34.417 0 90 33">
                              <path fill="#253B80" d="M46.211 6.749h-6.839a.95.95 0 0 0-.939.802l-2.766 17.537a.57.57 0 0 0 .564.658h3.265a.95.95 0 0 0 .939-.803l.746-4.73a.95.95 0 0 1 .938-.803h2.165c4.505 0 7.105-2.18 7.784-6.5.306-1.89.013-3.375-.872-4.415-.972-1.142-2.696-1.746-4.985-1.746zM47 13.154c-.374 2.454-2.249 2.454-4.062 2.454h-1.032l.724-4.583a.57.57 0 0 1 .563-.481h.473c1.235 0 2.4 0 3.002.704.359.42.469 1.044.332 1.906zM66.654 13.075h-3.275a.57.57 0 0 0-.563.481l-.146.916-.229-.332c-.709-1.029-2.29-1.373-3.868-1.373-3.619 0-6.71 2.741-7.312 6.586-.313 1.918.132 3.752 1.22 5.03.998 1.177 2.426 1.666 4.125 1.666 2.916 0 4.533-1.875 4.533-1.875l-.146.91a.57.57 0 0 0 .562.66h2.95a.95.95 0 0 0 .939-.804l1.77-11.208a.566.566 0 0 0-.56-.657zm-4.565 6.374c-.316 1.871-1.801 3.127-3.695 3.127-.951 0-1.711-.305-2.199-.883-.484-.574-.668-1.392-.514-2.301.295-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.499.589.697 1.411.554 2.317zM84.096 13.075h-3.291a.955.955 0 0 0-.787.417l-4.539 6.686-1.924-6.425a.953.953 0 0 0-.912-.678H69.41a.57.57 0 0 0-.541.754l3.625 10.638-3.408 4.811a.57.57 0 0 0 .465.9h3.287a.949.949 0 0 0 .781-.408l10.946-15.8a.57.57 0 0 0-.469-.895z"></path>
                              <path fill="#179BD7" d="M94.992 6.749h-6.84a.95.95 0 0 0-.938.802l-2.767 17.537a.57.57 0 0 0 .563.658h3.51a.665.665 0 0 0 .656-.563l.785-4.971a.95.95 0 0 1 .938-.803h2.164c4.506 0 7.105-2.18 7.785-6.5.307-1.89.012-3.375-.873-4.415-.971-1.141-2.694-1.745-4.983-1.745zm.789 6.405c-.373 2.454-2.248 2.454-4.063 2.454h-1.031l.726-4.583a.567.567 0 0 1 .562-.481h.474c1.233 0 2.399 0 3.002.704.358.42.467 1.044.33 1.906zM115.434 13.075h-3.272a.566.566 0 0 0-.562.481l-.146.916-.229-.332c-.709-1.029-2.289-1.373-3.867-1.373-3.619 0-6.709 2.741-7.312 6.586-.312 1.918.131 3.752 1.22 5.03 1 1.177 2.426 1.666 4.125 1.666 2.916 0 4.532-1.875 4.532-1.875l-.146.91a.57.57 0 0 0 .563.66h2.949a.95.95 0 0 0 .938-.804l1.771-11.208a.57.57 0 0 0-.564-.657zm-4.565 6.374c-.314 1.871-1.801 3.127-3.695 3.127-.949 0-1.711-.305-2.199-.883-.483-.574-.666-1.392-.514-2.301.297-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.501.589.699 1.411.554 2.317zM119.295 7.23l-2.807 17.858a.569.569 0 0 0 .562.658h2.822c.469 0 .866-.34.938-.803l2.769-17.536a.57.57 0 0 0-.562-.659h-3.16a.571.571 0 0 0-.562.482z"></path>
                           </svg>
                        </button>
                </form>
                </div>
             @endif
             
             @if($configs->instamojo_enable == 1)
               <div class="col-md-3">
                 <form action="{{ route('wallet.add.using.instamojo') }}" method="POST">
                   @csrf
                  <input type="hidden" value="{{ $amount }}" name="amount">
                  <button type="submit" class="insta-buy-now-button">
                    <span>{{ __('staticwords.Pay') }} &nbsp;<i class="{{ $defCurrency->currency_symbol }}"></i> {{ $amount }} {{ __('staticwords.with') }} <img src="{{ url('images/download.png') }}" alt="instamojo" title="Pay with Instamojo"></span> 
                  </button>
                </form>
               </div>
             @endif

             @if($configs->paytm_enable == 1)
               <div class="col-md-3">
                <form action="{{ route('wallet.add.using.paytm') }}" method="POST">
                  @csrf
                  <input type="hidden" value="{{ $amount }}" name="amount">
                  <button type="submit" class="paytm-buy-now-button">
                    <span>{{ __('staticwords.Pay') }} &nbsp;<i class="{{ $defCurrency->currency_symbol }}"></i> {{ $amount }} {{ __('staticwords.with') }} <img src="{{ url('images/paywithpaytm.jpg') }}" alt="paytm" title="Pay with Paytm"></span> 
                  </button>
                </form>
               </div>
              @endif
  

             @if($configs->razorpay == 1)
                
                <div class="col-md-3">
                  <form id="rpayform" action="{{ route('wallet.add.using.razorpay') }}" method="POST">
                   
                      <script src="https://checkout.razorpay.com/v1/checkout.js"
                              data-key="{{ env('RAZOR_PAY_KEY') }}"
                              data-amount="{{ $amount*100 }}"
                              data-buttontext="{{ __('staticwords.Pay') }} {{ $amount }} {{ __('staticwords.with') }} Razorpay"
                              data-name="{{ $title }}"
                              data-description="Add money in wallet"
                              data-image="{{url('images/genral/'.$front_logo)}}"
                              data-prefill.name="{{ Auth::user()->name }}"
                              data-prefill.email="{{ Auth::user()->email }}"
                              data-theme.color="#157ED2">
                      </script>
                      <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                  </form>
                </div>
             @endif

             @if($configs->braintree_enable == 1)
              <div class="col-md-6">
                <br>
                <a href="javascript:void(0);" class="payment-btn bt-btn btn btn-md btn-dark"><i class="fa fa-credit-card"></i> Pay <i class="{{ $defCurrency->currency_symbol }}"></i> {{ $amount }} with Braintree</a>
                <form method="POST" id="bt-form" action="{{ route('wallet.add.using.bt') }}">
                  {{ csrf_field() }} 
                  <div class="bt-drop-in-wrapper">
                      <div id="bt-dropin"></div>
                  </div>
                  <input type="hidden" class="form-control" name="amount" value="{{ $amount }}">  
                  <input id="nonce" name="payment_method_nonce" type="hidden" />
                  <button class="payment-final-bt d-none btn btn-md btn-success" type="submit">
                    Pay <i class="{{ $defCurrency->currency_symbol }}"></i> {{ $amount }} Now
                  </button>
                  <div id="pay-errors" role="alert"></div>
                </form>
              </div>
            @endif
             
            
             @if($configs->stripe_enable == 1)
                <div class="col-md-12 bg-white">
                  <br>
                  <h4><i class="fa fa-credit-card" aria-hidden="true"></i> {{ __('staticwords.Pay') }} &nbsp;<i class="{{ $defCurrency->currency_symbol }}"></i> {{ $amount }} (Stripe)</h4>
                  <hr>
                   <div class="row">
                     <div class="col-md-6">
                       <form method="POST" action="{{ route('wallet.add.using.stripe') }}" id="credit-card">
                          @csrf
                          
                            <div class="form-group">
                              <input class="form-control" placeholder="Card number" type="tel" name="number">
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
                          
                         
                            
                          <input id="amount" type="hidden" class="form-control" name="amount" value="{{ $amount }}">
                          
                          <div class="form-group">
                              <button title="Click to complete your payment !" type="submit" class="btn btn-primary btn-lg btn-block" id="confirm-purchase"> {{ __('staticwords.ADD') }} <i class="fa {{ $defCurrency->currency_symbol }}"></i>{{ $amount }}</button>
                          </div>
                         
                      
                        </form>
                     </div>
                     <div class="col-md-6">
                       <div class="card-wrapper"></div>
                        <div class="form-container active">
                          
                        </div>
                     </div>
                   </div>
                </div>


             @endif

           </div>
        </div>
    </div>
  </div>
@endsection
@section('script')
  <script>
    "use strict";

    new Card({
      form: document.querySelector('#credit-card'),
      container: '.card-wrapper'
    });
  </script>
  <script src="https://js.braintreegateway.com/web/dropin/1.20.0/js/dropin.min.js"></script>
  <script>
    var client_token = null;   
     $(function(){
       $('.bt-btn').on('click', function(){
         $('.bt-btn').addClass('load');
         $.ajax({
           headers: {
               "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
           },
           type: "POST",
           url: "{{ route('wallet.access.token.bt') }}",
           success: function(t) {   
               if(t.client != null){
                 client_token = t.client;
                 btform(client_token);
               }
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
             console.log(XMLHttpRequest);
             $('.bt-btn').removeClass('load');
             alert('Payment error. Please try again later.');
           }
         });
       });
     });
 
     function btform(token){
       var payform = document.querySelector('#bt-form'); 
       braintree.dropin.create({
         authorization: token,
         selector: '#bt-dropin',  
         paypal: {
           flow: 'vault'
         },
       }, function (createErr, instance) {
         if (createErr) {
           console.log('Create Error', createErr);
           swal({
            title: "Oops ! ",
            text: 'Payment Error please try again later !',
            icon: 'warning'
           });
           $('.preL').fadeOut('fast');
           $('.preloader3').fadeOut('fast');
           return false;
         }
         else{
           $('.bt-btn').hide();
           $('.payment-final-bt').removeClass('d-none');
         }
         payform.addEventListener('submit', function (event) {
         event.preventDefault();
         instance.requestPaymentMethod(function (err, payload) {
           if (err) {
             console.log('Request Payment Method Error', err);
             swal({
              title: "Oops ! ",
              text: 'Payment Error please try again later !',
              icon: 'warning'
            });
             $('.preL').fadeOut('fast');
             $('.preloader3').fadeOut('fast');
             return false;
           }
           // Add the nonce to the form and submit
           document.querySelector('#nonce').value = payload.nonce;
           payform.submit();
         });
       });
     });
     }
 </script>
@endsection
