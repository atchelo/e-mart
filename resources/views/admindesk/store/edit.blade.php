@extends("admindesk/layouts.master")
@section('title',"Edit Store : $store->name |")
@section("body")


<div class="box box-widget widget-user-2">
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-blue">
    <div class="widget-user-image">
      <img title="{{ $store->name }}"
        src="{{ $store->store_logo !='' && file_exists(public_path().'/images/store/'.$store->store_logo) ? url('images/store/'.$store->store_logo) : Avatar::create($store->name)->toBase64() }}"
        alt="store logo">
    </div>
    <!-- /.widget-user-image -->
    <h3 class="widget-user-username">{{ $store->name }}</h3>
    <h5 class="widget-user-desc"><i class="fa fa-map-marker"></i> {{ $store->city->name ?? '' }} {{ $store->state['name'] ?? '' }}      {{ $store->country->nicename }}</h5>
  </div>
  <div class="box-footer no-padding">
    <ul class="nav nav-stacked">
      <li><a href="#">Created On <span
            class="pull-right badge bg-blue">{{ date('d-M-Y',strtotime($store->created_at)) }}</span></a></li>
      <li><a href="#">Owner <span class="pull-right badge bg-purple"> {{ $store->user->name }}</span></a></li>
      <li><a href="#">Total Orders <span class="pull-right badge bg-green">{{ $storeordercount }}</span></a></li>
      <li><a href="#">Total Products <span class="pull-right badge bg-aqua">{{ $store->products->count() }}</span></a>
      </li>
      <li><a href="#">Verified <span
            class="pull-right badge {{ $store->verified_store == '1' ? "bg-green" : "bg-primary" }}">{{ $store->verified_store == '1' ? "Yes" : "No" }}</span></a>
      </li>
      <li><a href="{{ route('store.view',['uuid' => $store->uuid ?? 0, 'title' => $store->name]) }}">View </a>
      </li>
    </ul>
  </div>
</div>
<!-- general form elements -->
<div class="box box-primary">
  <div class="box-header with-border">


    <h3 class="box-title">Edit Store</h2>





      <a href=" {{url('admindesk/stores')}} " class="btn btn-success pull-right owtbtn">
        <i class="fa fa-arrow-left"></i> Back</a> </div> <div class="box-body">

          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/stores/'.$store->id)}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}

            <div class="row">

              <div class="col-md-4">
                <label class="control-label" for="first-name">
                  {{ __('Store ID') }}:
                </label>
                <input class="form-control" type="text" readonly value="{{ $store->uuid ?? "Not set" }}">
                <small class="text-muted">
                  <i class="fa fa-question-circle"></i> {{ __('If you did not see store id hit update button to get it.') }}
                </small>
              </div>

              <div class="col-md-4">
  
                <label class="control-label" for="first-name">
                  {{ __('admindesk.storeOwner') }}: <span class="required">*</span>
                </label>
  
                <select data-placeholder="{{ __('admindesk.chooseStoreOwner') }}" required name="user_id" class="form-control select2">
                  <option value="">Please Choose Store Owner</option>
                  @foreach($users as $user)
                    <optgroup label="{{ $user->email }}">
                    <option {{ $store->user_id == $user->id ? "selected" : "" }}  value="{{$user->id}}"> {{$user->name}}</option>
                    </optgroup>
                  @endforeach
                </select>

                <small class="text-muted">
                  <i class="fa fa-question-circle"></i> {{ __('admindesk.chooseStoreOwner') }}
                </small>
  
              </div>
  
              <div class="col-md-4">
  
                <label class="control-label" for="first-name">
                  Store name: <span class="required">*</span>
                </label>
  
  
                <input placeholder="Please enter store name" type="text" id="first-name" name="name" class="form-control"
                  value="{{ $store->name }}">

                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i> {{ __('admindesk.enterStoreName') }}
                  </small>
              </div>
  
              <div class="last_btn col-md-4">
                <label class="control-label" for="first-name">
                  Business Email: <span class="required">*</span>
                </label>
  
  
                <input placeholder="Please enter buisness email" type="email" id="first-name" name="email"
                  class="form-control" value="{{ $store->email }}">
                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i> {{ __('admindesk.storeEmail') }}
                  </small>
              </div>
  
              <div class="last_btn col-md-4">
  
                <label class="control-label" for="first-name">
                  VAT/GSTIN No:
                </label>
  
  
                <input placeholder="Please enter your GSTIN/VAT No." type="text" name="vat_no" class="form-control"
                  value="{{ $store->vat_no }}">

                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i> {{ __('admindesk.gstvatno') }}
                  </small>
              </div>
  
              <div class="last_btn col-md-2">
                <label class="control-label" for="first-name">
                  Phone:
                </label>
                <input pattern="[0-9]+" title="Invalid phone no." placeholder="Please enter phone no." type="text"
                  id="first-name" name="phone" value="{{ $store->phone }}" class="form-control">
                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i> {{ __('admindesk.phoneno') }}
                  </small>
              </div>
  
              <div class="last_btn col-md-2">
                <label class="control-label" for="first-name">
                  Mobile: <span class="required">*</span>
                </label>
                <input pattern="[0-9]+" title="Invalid mobile no." placeholder="Please enter mobile no." type="text"
                  id="first-name" name="mobile" class="form-control" value="{{ $store->mobile }}">
                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i> {{ __('admindesk.mobileno') }}
                  </small>
              </div>
  
              <div class="last_btn col-md-4">
                <label class="control-label" for="first-name">
                  Store Address: <span class="required">*</span>
                </label>
                <textarea class="form-control" required name="address" id="address" cols="30" rows="5">{!! $store->address !!}</textarea>
                <small class="text-muted">
                  <i class="fa fa-question-circle"></i> {{ __('admindesk.address') }}
                </small>
              </div>
  
              <div class="col-md-4 last_btn">
                <label class="control-label" for="first-name">
                  {{ __('admindesk.Country') }}: <span class="required">*</span>
                </label>
  
                <select data-placeholder="{{ __('admindesk.selectcountry') }}" name="country_id" id="country_id" class="form-control select2 col-md-7 col-xs-12">
                  <option value="0">Please Choose</option>
                  @foreach($countrys as $country)
                  <?php
                                $iso3 = $country->country;
  
                                $country_name = DB::table('allcountry')->
                                where('iso3',$iso3)->first();
  
                                 ?>
                  <option {{ $store->country_id == $country_name->id ? 'selected' : "" }} value="{{$country_name->id}} ">{{ $country_name->nicename }}</option>
                  @endforeach
                </select>

                <small class="text-muted">
                  <i class="fa fa-question-circle"></i> {{ __('admindesk.selectcountry') }}
                </small>
              </div>
  
              <div class="col-md-4 last_btn">
                <label class="control-label" for="first-name">
                  {{ __('admindesk.State')}}: <span class="required">*</span>
                </label>
  
              <select data-placeholder="{{ __('admindesk.selectstate') }}" required name="state_id" id="upload_id" class="select2 form-control">
  
                  <option value="">Please Choose</option>
                  @foreach($store->country->states as $state)
                    <option {{ $store->state_id != 0 && $store->state_id == $state->id ? "selected" : "" }} value="{{ $state->id }}">{{ $state->name }}</option>
                  @endforeach
                </select>

                <small class="text-muted">
                  <i class="fa fa-question-circle"></i> {{ __('admindesk.selectstate') }}
                </small>
              </div>
  
              <div class="col-md-4 last_btn">
                <label class="control-label" for="first-name">
                  {{ __('admindesk.City')}}: <span class="required">*</span>
                </label>
  
              <select data-placeholder="{{ __('admindesk.selectcity') }}" required name="city_id" id="city_id" class="select2 form-control">
                  <option value="">Please Choose</option>
                  @if(isset($store->state->city))
                      @foreach($store->state->city as $city)
                        <option {{ $store->city_id != 0 && $store->city_id == $city->id ? "selected" : ""  }} value="{{ $city->id }}">{{ $city->name }}</option>
                      @endforeach
                  @endif
                </select>

                <small class="text-muted">
                  <i class="fa fa-question-circle"></i> {{ __('admindesk.selectcity') }}
                </small>

              </div>
  
              <div class="last_btn col-md-4">
                <label class="control-label" for="first-name">
                  {{ __('admindesk.pincode') }}:
                </label>
                <input pattern="[0-9]+" title="Invalid pincode/zipcode" placeholder="{{ __('admindesk.enterpincode') }}" type="text"
                  id="first-name" name="pin_code" class="form-control" value="{{ $store['pin_code'] }}">

                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i> {{ __('admindesk.enterpincode') }}
                  </small>
              </div>
  
             
  
              <div class="last_btn col-md-4">
                <label class="control-label" for="first-name">
                  {{ __('admindesk.choosePayout') }}:
                </label>
                <select data-placeholder="{{ __('admindesk.preferPayout') }}" required name="preferd" id="preferd" class="form-control select2">
                  <option value="">{{ __('admindesk.preferPayout') }}</option>
                  <option {{ $store['preferd'] == 'paypal' ? 'selected' : "" }} value="paypal">{{ __('Paypal') }}</option>
                  <option {{ $store['preferd'] == 'paytm' ? 'selected' : "" }} value="paytm">{{ __('Paytm') }}</option>
                  <option {{ $store['preferd'] == 'bank' ? 'selected' : "" }} value="bank">{{ __('Bank Transfer') }}</option>
                </select>

                <small class="text-muted">
                  <i class="fa fa-question-circle"></i> {{ __('admindesk.preferPayout') }}
                </small>
              </div>
  
              <div class="last_btn col-md-4">
                  <label> {{__('admindesk.paypalemail')}} :</label>
                  <input value="{{ $store['paypal_email'] }}" type="text" class="form-control" class="form-control" name="paypal_email" placeholder="eg:seller@paypal.com">
                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i> {{ __('admindesk.enterpaypalemail') }}
                  </small>
              </div>
  
              <div class="last_btn col-md-4">
                  <label> {{__("admindesk.PaytmMobileNo")}} : ({{ __('admindesk.IndiaApplicable') }})</label>
                  <input value="{{ $store['paytem_mobile'] }}" type="text" class="form-control" class="form-control" name="paytem_mobile" placeholder="eg:7894561230">
                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i> {{ __('admindesk.enterPaytmMobileNo') }}
                  </small>
              </div>

             
              
  
              <div class="col-md-12 last_btn">
               
                  <div class="last_btn">
                    <label>{{ __('staticwords.AccountNumber') }}</label>
                    <input class="form-control" pattern="[0-9]+" title="Invalid account no." type="text"  name="account"
                      value="{{ $store['account'] }}" placeholder="{{ __('staticwords.PleaseEnterAccountNumber') }}"> <span
                      class="required">{{$errors->first('account')}}</span>
                  </div>
      
                  <div class="last_btn">
                    <label>{{ __('staticwords.AccountName') }}:</label>
                    <input class="form-control" type="text" name="account_name" value="{{ $store['account_name'] }}"
                      placeholder="{{ __('staticwords.PleaseEnterAccountName') }}"> <span
                      class="required">{{$errors->first('bank_name')}}</span>
                  </div>
      
                  <div class="last_btn">
                    <label> {{ __('staticwords.BankName') }}:</label>
                    <input class="form-control"  type="text" name="bank_name" value="{{ $store['bank_name'] }}"
                      placeholder="{{ __('staticwords.PleaseEnterBankName') }}"> <span
                      class="required">{{$errors->first('bank_name')}}</span>
                  </div>
      
                  <div class="last_btn">
                    <label> {{ __('IFSC Code') }}:</label>
                    <input class="form-control"  type="text" name="ifsc" value="{{ $store['ifsc'] }}"
                      placeholder="{{ __('staticwords.PleaseEnterIFSCCode') }}"> <span
                      class="required">{{$errors->first('ifsc')}}</span>
                  </div>
      
                  <div class="last_btn">
                    <label>{{ __('staticwords.BranchAddress') }}: </label>
                    <input class="form-control"  type="text" id="first-name" name="branch" placeholder="Please Enter Branch Address"
                      value="{{ $store['branch'] }}">
                    <span class="required">{{$errors->first('branch')}}</span>
                  </div>
                
              </div> 

              <div class="last_btn col-md-12">
                <label class="control-label" for="first-name">
                  {{ __('admindesk.Logo') }}:
                </label>
                <input type="file" id="first-name" name="store_logo" class="form-control" value="{{old('mobile')}}">
                <small class="text-muted">
                  <i class="fa fa-question-circle"></i> {{ __('admindesk.selectStoreLogo') }}
                </small>
              </div>
             
              <div class="col-md-6">
                <label class="control-label">Store description:</label>
                <textarea name="description" id="description" cols="5" rows="5" class="form-control">{{ $store->description }}</textarea>
                <small class="text-muted">
                  <i class="fa fa-question-circle"></i>
                   It will display on your store page.
                </small>
              </div>

              <div class="col-md-6">
                  <label class="control-label">Store cover photo:</label>
                  <input type="file" class="form-control" name="cover_photo">
                  <small class="text-muted">
                    <i class="fa fa-question-circle"></i>
                    • It will display on your store page.
                    • Recommnaded size is : <b>1500 x 440 px</b>
                    • Allow format is <b>jpg,jpeg,png,gif</b>                 
                  </small>
              </div>
  
              <div class="last_btn col-md-2">
                <label class="control-label" for="first-name">
                  Status:
                </label>
                <br>
                <label class="switch">
                  <input {{ $store['status'] == '1' ? "checked" : "" }} type="checkbox" name="status">
                  <span class="knob"></span>
                </label>
  
                <br>
                <small>(Toggle the store status.)</small>
              </div>
  
              <div class="last_btn col-md-3">
                <label class="control-label" for="first-name">
                  Verified Store: 
                </label>
                <br>
                <label class="switch">
                  <input {{ $store['verified_store'] == '1' ? "checked" : "" }} type="checkbox" name="verified_store">
                  <span class="knob"></span>
                </label>
                <br>
                <small>(On The Product detail page if store is verified than it will add <i class="fa fa-check-circle text-green"></i> Symbol next to the store name.)</small>
  
              </div>
  
              <div class="col-md-12">
                <div class="box-footer">
                  
                  <a href="{{ route('stores.index') }}" class="btn btn-md btn-default"><i class="fa fa-reply"></i> Back
                    </a>
  
                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save
                    </button>
                </div>
              </div>
  
  
  
              <!--Main Row END-->
            </div>
          </form>


  </div>

  @endsection

  @section('custom-script')
  <script>
    var baseUrl = "<?= url('/') ?>";
  </script>
  <script src="{{ url('js/ajaxlocationlist.js') }}"></script>
  @endsection