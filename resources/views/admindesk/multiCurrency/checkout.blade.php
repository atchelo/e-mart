<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
    {{__("Enable On Cart Page")}}
  </label>

  <div class="col-md-9 col-sm-9 col-xs-12">

    <label class="switch">
      <input type="checkbox" name="cart_page" onchange="checkoutSetting()" id="cart_page"
        {{$auto_geo->enable_cart_page=="1"?'checked':''}}>
      <span class="knob"></span>
    </label>

  </div>

  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
    {{__("Check Out Currency")}}
  </label>

  <div class="col-md-9 col-sm-9 col-xs-12">
    <label class="switch">
      <input type="checkbox" name="checkout_currency" onchange="checkoutSettingCheckout()" id="checkout_currency"
        {{$auto_geo->checkout_currency=="1"?'checked':''}}>
      <span class="knob"></span>
    </label>


  </div>

</div>


<table class="table">
  <caption>Currency Option</caption>
  <thead>
    <tr>
      <th scope="col">Currency</th>

      <th scope="col">Checkout Currency</th>
      <th scope="col">Payment Method</th>



    </tr>
  </thead>

  <form>

    <tbody>

      @if($check_cur)


      @foreach($check_cur as $key=> $cury)



      <tr>
        <td>


          {{ $cury->currency->code }}
          <input type="hidden" id="currency_checkout{{$key}}" name="currency_checkout{{$cury->id}}"
            value="{{$cury->currency->code}}">

          <input type="hidden" id="currencyId{{$key}}" value="{{$cury->id}}">
        </td>

        <td>

          <select class="js-example-basic-multiple" id="checkout_currency_status{{$key}}">

            <option value="1" @if(!empty($checkout)) {{$checkout->checkout_currency=='1'?'selected':''}} @endif>Yes
            </option>
            <option value="0" @if(!empty($checkout)) {{$checkout->checkout_currency=='0'?'selected':''}} @endif>No
            </option>

          </select>
        </td>
        <td>

         
          <select class="js-example-basic-multiple form-control pay_m" id="payment_checkout{{$key}}" name="payment[]"
            multiple="multiple">

          

            <option value="instamojo" @if(isset($cury->checkoutCurrencySettings) && in_array('instamojo',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Instamojo</option>

            <option @if(isset($cury->checkoutCurrencySettings) && in_array('wallet',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif value="wallet">Wallet</option>

            <option value="paypal" @if(isset($cury->checkoutCurrencySettings) && in_array('paypal',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif >Paypal</option>

            <option value="payu" @if(isset($cury->checkoutCurrencySettings) && in_array('payu',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>PayUBiz/ PayUMoney</option>

            <option value="stripe" @if(isset($cury->checkoutCurrencySettings) && in_array('stripe',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif >Stripe</option>

            <option value="paystack" @if(isset($cury->checkoutCurrencySettings) && in_array('paystack',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Paystack</option>

            <option @if(isset($cury->checkoutCurrencySettings) && in_array('braintree',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif value="braintree">Braintree</option>

            <option value="Razorpay" @if(isset($cury->checkoutCurrencySettings) && in_array('Razorpay',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>RazorPay</option>

            <option value="Paytm" @if(isset($cury->checkoutCurrencySettings) && in_array('Paytm',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>PayTM</option>

            <option value="payhere" @if(isset($cury->checkoutCurrencySettings) && in_array('payhere',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Payhere</option>

            <option value="bankTransfer" @if(isset($cury->checkoutCurrencySettings) && in_array('bankTransfer',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Bank Transfer</option>

            <option value="skrill" @if(isset($cury->checkoutCurrencySettings) && in_array('skrill',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Skrill</option>

            <option value="mollie" @if(isset($cury->checkoutCurrencySettings) && in_array('mollie',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Mollie</option>

            <option @if(isset($cury->checkoutCurrencySettings) && in_array('sslcommerze',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif value="sslcommerze">SslCommerze</option>

            <option value="amarpay" @if(isset($cury->checkoutCurrencySettings) && in_array('amarpay',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Amar Pay</option>

            <option @if(isset($cury->checkoutCurrencySettings) && in_array('iyzico',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif value="iyzico">iyzico</option>

            <option value="omise" @if(isset($cury->checkoutCurrencySettings) && in_array('omise',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Omise</option>

            <option value="rave" @if(isset($cury->checkoutCurrencySettings) && in_array('rave',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Rave</option>

            <option value="cashfree" @if(isset($cury->checkoutCurrencySettings) && in_array('cashfree',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Cashfree</option>

            <option value="bkash" @if(isset($cury->checkoutCurrencySettings) && in_array('bkash',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Bkash Payment (Addon)</option>
            
            <option value="dpopayment" @if(isset($cury->checkoutCurrencySettings) && in_array('dpopayment',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>DPO Payment (Addon)</option>

            <option value="cashOnDelivery" @if(isset($cury->checkoutCurrencySettings) && in_array('cashOnDelivery',explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif>Cash On Delivery</option>
            @foreach ($manualpaymentmethods as $item)
                <option @if(isset($cury->checkoutCurrencySettings) && in_array($item->payment_name,explode(',',$cury->checkoutCurrencySettings->payment_method)) ) {{ 'selected' }} @endif value="{{ $item->payment_name }}">{{ $item->payment_name }}</option>
            @endforeach

          </select>
        </td>

      </tr>


      @endforeach
      @endif



      <tr>
        <td colspan="3">
          <div class="pull-left">
            <a class="btn btn-primary" onclick="CheckoutCurrencySubmitForm()">
              <i class="fa fa-save"></i> Save
            </a>
          </div>
        </td>
      </tr>

    </tbody>

  </form>

</table>

<script>
  var baseUrl = "<?= url('/') ?>";
</script>
<script src="{{ url('js/currency.js') }}"></script>