@extends("admindesk/layouts.master")
@section('title',"General Settings |")
@section("body")
<div class="box">
  <div class="box-header with-border">
    <div class="box-title">
      {{__("General Settings")}}
    </div>
  </div>

  <div class="box-body">
    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/genral/')}}"
      data-parsley-validate>
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>
              Project Name: <span class="required">*</span>
            </label>

            <input placeholder="Please enter Project name" type="text" id="a1" name="APP_NAME"
              value="{{ env('APP_NAME') }}" class="form-control currency-icon-picker ">
            <small class="text-muted"><i class="fa fa-question-circle"></i> Project name is basically your Project
              Title.</small>
          </div>
        </div>

        <div class="col-md-6">

          <div class="form-group">
            <label>Default Email:</label>
            <input placeholder="Please Enter Email (info@example.com)" type="text" id="first-name" name="email"
              value="{{$row->email ?? ''}}" class="form-control">
            <small class="text-muted"><i class="fa fa-question-circle"></i> Default email will be used by your customer
              for contacting you.</small>
          </div>

        </div>

        <div class="col-md-6">

          <div class="form-group">
            <label>APP URL:</label>
            <input placeholder="http://" type="text" id="first-name" name="APP_URL" value="{{ env("APP_URL") }}"
              class="form-control">
            <small class="text-muted"><i class="fa fa-warning"></i> Try changing domain will cause serious
              error.</small>
          </div>

        </div>

        <div class="col-md-6">

          <div class="form-group">
            <label>Mobile:</label>

            <input placeholder="Please enter mobile no." type="text" id="first-name" name="mobile"
              value="{{$row->mobile ?? ''}}" class="form-control">

            <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter valid mobile no (it will also
              show in your site footer).</small>
          </div>

        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Copyright Text:</label>

            <input placeholder="Please enter copyright text" type="text" id="first-name" name="copyright"
              value="{{$row->copyright ?? ''}}" class="form-control">

            <small class="text-muted"><i class="fa fa-question-circle"></i> Copyright text will be shown in your site
              footer don't put YEAR on text.</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label" for="first-name">
              Default Currency:
            </label>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i
                  class="fa {{ $defCurrency->currency_symbol }}"></i></span>
              <input readonly="" class="form-control" type="text" name="currency_code"
                value="{{ $defCurrency->currency->code }}">
            </div>

            <small class="text-muted"><i class="fa fa-question-circle"></i> Default currency can be customized in
              Multiple Currency setting.</small>
          </div>
        </div>





        <div class="col-md-6">

          <div class="row">
            <div class="col-md-9">
              <label>Logo:</label>
              <input type="file" id="first-name" name="logo" class="form-control">
              <small class="text-muted"><i class="fa fa-question-circle"></i> Please choose a site logo (supported
                format: <b>PNG, JPG, JPEG, GIF</b>).</small>
            </div>

            <div class="col-custom col-md-3">
              @if(!empty($row))
              <div class="well background11">

                <img title="Current Logo" src=" {{url('images/genral/'.$row->logo)}}" class="width100px height-30">

              </div>
              @endif
            </div>
          </div>


        </div>

        <div class="col-md-6">

          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                <label>Favicon:</label>
                <input type="file" id="first-name" name="fevicon" class="form-control">
                <small class="text-muted"><i class="fa fa-question-circle"></i> Please choose a site favicon (supported
                  format: <b>PNG, JPG, JPEG</b>).</small>
              </div>
            </div>

            <div class="col-custom col-md-2">
              @if(!empty($row))
              <div class="well background11">
                <center><img class="img-responsive" title="Current Favicon"
                    src=" {{url('images/genral/'.$row->fevicon)}}" class="width100px height-30"></center>
              </div>
              @endif
            </div>
          </div>

        </div>

        <div class="col-md-6">

          <div class="form-group">
            <label>Address:</label>

            <textarea rows="3" cols="10" value="{{old('address' ?? '')}}" name="address"
              class="form-control">{{$row->address ?? ''}}</textarea>
            <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter address (it will also show in
              your site footer).</small>
          </div>

        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label" for="first-name">
              Cart Amount: <span class="required">*</span>
            </label>

            <input type="text" name="cart_amount" value="{{$row->cart_amount ?? ''}}" onkeyup="sync()"
              class="form-control">
            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter cart amount eg. 500 so if user cart
              amount is greater or equal to this amount than shipping will be free (Put <b>0</b> for disable
              it).</small>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <label for="handlingcharge">Handling Charges:</label>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i
                    class="fa {{ $defCurrency->currency_symbol }}"></i></span>
                <input step="0.1" type="number" name="handlingcharge" class="form-control" placeholder="0.00"
                  value="{{ $row->handlingcharge }}">
              </div>
            </div>

            <div class="col-md-6">
              <label for="chargeterm">Charging term: </label>
              <select class="select2 form-control" name="chargeterm" id="">
                <option {{ $row->chargeterm == 'pi' ? "selected" : "" }} value="pi">Per Item</option>
                <option {{ $row->chargeterm == 'fo' ? "selected" : "" }} value="fo">on full order</option>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-6">

          <div class="row">
            <br>
            <div class="col-md-10">
              <div class="form-group">
                <label>Preloader:</label>
                <input type="file" name="preloader" class="form-control">
                <small class="text-muted"><i class="fa fa-question-circle"></i> Change your front end preloader
                  here.</small>
              </div>
            </div>

            <div class="col-custom col-md-2">
              @if(file_exists(public_path().'/images/preloader/preloader.png'))
              <div class="well background11">
                <center><img title="Current preloader" class="img-responsive" title="Current Favicon"
                    src=" {{url('images/preloader/preloader.png')}}" class="width100px height-30"></center>
              </div>
              @endif
            </div>
          </div>
        </div>

        <div class="col-md-6 form-group">
          <br>
          @php $timestamp = time(); @endphp
          <label>Select Timezone: <span class="text-red">*</span> </label>
          <select name="TIMEZONE" id="TIMEZONE" class="form-control select2">



            @foreach (timezone_identifiers_list() as $zone)

            @php
            date_default_timezone_set($zone);
            $zones['offset'] = date('P', $timestamp);
            $zones['diff_from_gtm'] = 'UTC/GMT '.date('P', $timestamp);
            @endphp

            <option {{ env('TIMEZONE') == $zone ? "selected" : "" }} value="{{ $zone }}">
              {{ $zones['diff_from_gtm'].' '.$zone }}</option>

            @endforeach
          </select>

        </div>



      </div>

      <div class="box-footer">
        <h4><i class="fa fa-cogs" aria-hidden="true"></i> Mischievous Settings</h4>

        <div class="row">



          <div class="col-md-3">
            <div class="form-group">
              <label>Right Click:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="right_click" {{ $row->right_click=='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> If enabled than Right click will not work
                on
                whole project (<b>Recommended</b>).</small>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>Inspect Elements:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="inspect" {{ $row->inspect=='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> If enabled than Inspect element like
                <b>CTRL+U OR CTRL+SHIFT+I</b> keys not work on whole project (<b>Recommended</b>).</small>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>Login Display Price:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="login" {{ $row->login=='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> If enabled than Prices of products and
                deals
                only visible to Logged In users.</small>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>Guest Login:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="guest_login" {{ $row->guest_login=='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> If enabled than Guest checkout will be
                active on your portal.</small>
            </div>
          </div>



        </div>

        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>APP Debug:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="APP_DEBUG" @if(env('DEMO_LOCK') !=1)
                  {{ env('APP_DEBUG') == true ? "checked" : "" }} @endif>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> Turn it <b>OFF</b>. ONLY FOR Development
                purpose (<b>Recommanded</b>).</small>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>Enable Multiseller system On Portal:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="vendor_enable" {{ $row->vendor_enable== 1 ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> If enabled than Multiseller system will be
                active on your portal.</small>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>Enable email verification on user registration:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="email_verify_enable" {{ $row->email_verify_enable == 1 ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> If enabled than email verification when
                user register he/she need to verify his/her email to access the site.</small>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>Enable Cash on delivery on checkout page:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="COD_ENABLE" {{ env('COD_ENABLE') == 1 ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> If enabled than cash on delivery will
                enable on payment page.</small>
            </div>
          </div>

          <div class="col-md-3">

            <div class="form-group">
              <label>Enable Preloader:</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="ENABLE_PRELOADER" {{ env('ENABLE_PRELOADER') =='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> Enable or disable preloader by toggling
                it.</small>
            </div>
          </div>

          <div class="col-md-3">

            <div class="form-group">
              <label>Hide Sidebar :</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="HIDE_SIDEBAR" {{ env('HIDE_SIDEBAR') =='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> By toggling it make the full width front page.
                it.</small>
            </div>
          </div>

          <div class="col-md-3">

            <div class="form-group">
              <label>ENABLE Seller Subscription System :</label>
              <br>
              <label class="switch">
                <input type="checkbox" name="ENABLE_SELLER_SUBS_SYSTEM" {{ env('ENABLE_SELLER_SUBS_SYSTEM') =='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-muted"><i class="fa fa-question-circle"></i> By toggling it seller subscription system will enable on portal.</small>
            </div>
          </div>


        </div>
      </div>

      <div class="box-footer">
        <a target="__blank" title="Get your keys from here" class="text-muted pull-right"
          href="https://www.google.com/recaptcha/admin/create"><i class="fa fa-key"></i> Get Your reCAPTCHA v2 Keys From
          Here</a>
        <h4><i class="fa fa-cogs" aria-hidden="true"></i> reCaptcha v2 Settings</h4>
        <small class="text-muted"><i class="fa fa-warning"></i> reCaptcha will not work on <b>localhost (eg. on
            xammp,wammp,laragon)</b>. Read more about <a target="__blank"
            href="https://developers.google.com/recaptcha/docs/faq#localhost_support">here</a></small>
        <hr>
        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label>
                NOCAPTCHA_SECRET:
              </label>
              <input value="{{ env('NOCAPTCHA_SECRET') }}" id="NOCAPTCHA_SECRET" name="NOCAPTCHA_SECRET" type="text"
                class="form-control" placeholder="enter NOCAPTCHA SECRET key">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>
                NOCAPTCHA_SITEKEY
              </label>
              <input id="NOCAPTCHA_SITEKEY" value="{{ env('NOCAPTCHA_SITEKEY') }}" name="NOCAPTCHA_SITEKEY" type="text"
                class="form-control" placeholder="enter NOCAPTCHA SITEKEY key">
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>Enable reCaptcha on Registration :</label>
              <br>
              <label class="switch">
                <input id="captcha_enable" type="checkbox" name="captcha_enable"
                  {{ $row->captcha_enable=='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
            </div>
          </div>
        </div>
      </div>


      <div class="box-footer">
        <div class="row">
          <div class="col-md-6">
            <h4><i class="fa fa-key" aria-hidden="true"></i> OPEN EXCHANGE RATE Settings:</h4>
            <small>
              <a target="__blank" title="Get your keys from here" class="text-muted pull-right"
                href="https://openexchangerates.org/signup/free"><i class="fa fa-key"></i> Get Your OPEN EXCHANGE RATE
                KEY From
                Here</a>
            </small>
            <div class="form-group">
              <label>OPEN EXCHANGE RATE KEY : <span class="required">*</span></label>
              <br>
              <input required id="OPEN_EXCHANGE_RATE_KEY" value="{{ env('OPEN_EXCHANGE_RATE_KEY') }}"
                name="OPEN_EXCHANGE_RATE_KEY" type="text" class="form-control"
                placeholder="enter OPEN EXCHANGE RATE KEY">
            </div>
          </div>

          <div class="col-md-6">

            <h4><i class="fa fa-facebook-official" aria-hidden="true"></i>
              Messnger Bubble Chat URL:</h4>
            <small>
              <a target="__blank" title="Get your code" class="text-muted pull-right" href="https://app.respond.io/"><i
                  class="fa fa-key"></i> Get Your Code For Messenger Chat Bubble URL Here
                Here</a>
            </small>
            <div class="form-group">
              <label>MESSENGER CHAT BUBBLE URL :</label>
              <br>
              <input placeholder="https://app.respond.io/facebook/chat/plugin/XXXX/XXXXXXXXXX"
                id="MESSENGER_CHAT_BUBBLE_URL" value="{{ env('MESSENGER_CHAT_BUBBLE_URL') }}"
                name="MESSENGER_CHAT_BUBBLE_URL" type="text" class="form-control"
                placeholder="enter MESSENGER CHAT BUBBLE URL">
            </div>
          </div>
        </div>
      </div>

      <div class="box-footer">
        <a target="__blank" title="Get your keys from here" class="text-muted pull-right"
          href="https://mailchimp.com/"><i class="fa fa-key"></i> Get your mailchimp keys from here</a>
        <h4><i class="fa fa-rss"></i> {{__("MailChimp Newsletter Settings") }}</h4>
        <hr>
        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label>
                {{__("MAILCHIMP APIKEY")}}
              </label>
              <input value="{{ env('MAILCHIMP_APIKEY') }}" id="MAILCHIMP_APIKEY" name="MAILCHIMP_APIKEY" type="text"
                class="form-control" placeholder="enter MAILCHIMP APIKEY key">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>
                {{__("MAILCHIMP LIST ID")}}
              </label>
              <input id="MAILCHIMP_LIST_ID" value="{{ env('MAILCHIMP_LIST_ID') }}" name="MAILCHIMP_LIST_ID" type="text"
                class="form-control" placeholder="enter MAILCHIMP LIST ID">
            </div>
          </div>
        </div>
      </div>

      <div class="box-footer">
        <a target="__blank" title="Get your keys from here" class="text-muted pull-right"
          href="https://tagmanager.google.com/#/home/"><i class="fa fa-key"></i> Get your GTM keys from here</a>
        <h4><i class="fa fa-google"></i> {{__("Google Tag Manager Settings") }}</h4>
        <hr>
        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label>
                {{__("GOOGLE TAG MANAGER ID")}}
              </label>
              <input value="{{ env('GOOGLE_TAG_MANAGER_ID') }}" id="GOOGLE_TAG_MANAGER_ID" name="GOOGLE_TAG_MANAGER_ID" type="text"
                class="form-control" placeholder="Enter GOOGLE TAG MANAGER ID here">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Enable Google Tag Manager :</label>
              <br>
              <label class="switch">
                <input id="GOOGLE_TAG_MANAGER_ENABLED" type="checkbox" name="GOOGLE_TAG_MANAGER_ENABLED"
                  {{ env('GOOGLE_TAG_MANAGER_ENABLED') =='1' ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
            </div>
          </div>
        </div>
      </div>


      <div class="form-group">
        <button title="Click to update settings" type="submit" class="btn btn-flat btn-md btn-primary"><i
            class="fa fa-save"></i> Save Settings</button>
      </div>

    </form>
  </div>
</div>
@endsection
@section('custom-script')
<script>
  $('#captcha_enable').on('change', function () {
    if ($('#captcha_enable').is(':checked')) {
      $('#NOCAPTCHA_SECRET').attr('required', 'required');
      $('#NOCAPTCHA_SITEKEY').attr('required', 'required');
    } else {
      $('#NOCAPTCHA_SECRET').removeAttr('required');
      $('#NOCAPTCHA_SITEKEY').removeAttr('required');
    }
  })

  $('#GOOGLE_TAG_MANAGER_ENABLED').on('change', function () {
    if ($('#GOOGLE_TAG_MANAGER_ENABLED').is(':checked')) {
      $('#GOOGLE_TAG_MANAGER_ID').attr('required', 'required');
    } else {
      $('#GOOGLE_TAG_MANAGER_ID').removeAttr('required');
    }
  })
</script>
@endsection