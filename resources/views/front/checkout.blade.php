@extends("front/layout.master")
@section('title','Order Review & Payment - Checkout |')

@section("body")

<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
  <div class="container-fluid">
    <div class="breadcrumb-inner">
      <ul class="list-inline list-unstyled">
        <li><a href="#">{{ __('staticwords.Home') }}</a></li>
        <li>{{ __('staticwords.Checkout') }}</li>
        <li class='active'>{{ __('staticwords.OrderReviewPayment') }}</li>
      </ul>
    </div><!-- /.breadcrumb-inner -->
  </div><!-- /.container -->
</div><!-- /.breadcrumb -->


@php
\Session::forget('from-order-review-page');
\Session::forget('from-pay-page');
\Session::forget('re-verify');
$per_shipping = 0;
$tax_amount = 0;
$total_tax_amount = 0;
$total_shipping = 0;
$total = 0;
$pro = Session('pro_qty');

$stock= session('stock');
$after_tax_amount = 0;
$count = $cart_table->count();

@endphp

<div class="body-content">

  <div class="container-fluid">

    <div class="row checkout-box" data-sticky-container>
      <div class="col-xl-8 col-md-12 col-sm-12">
        <div class="panel-group checkout-steps" id="accordion">
          <!-- checkout-step-01  -->

          <!-- checkout-step-01  -->
          <div class="panel panel-default checkout-step-01">

            <!-- panel-heading -->
            <div class="panel-heading">
              <h4 class="unicase-checkout-title">
                <a data-toggle="collapse" class="@auth collapsed @endauth" data-parent="#accordion" href="#collapseOne">
                  @guest <span>1</span> {{ __('staticwords.Login') }} @else <span class="fa fa-check"></span>
                  {{ __('staticwords.LoggedIn') }} @endguest
                </a>
              </h4>
            </div>
            <!-- panel-heading -->

            <div id="collapseOne" class="panel-collapse collapse in">

              <!-- panel-body  -->
              <div class="panel-body">

                @auth
                <p class="font-size14">
                  <b><i class="text-green fa fa-check-square-o" aria-hidden="true"></i>
                    {{ Auth::user()->name }}</b> </p>
                <p class="font-weight500"><i class="text-green fa fa-check-square-o" aria-hidden="true"></i>
                  {{ Auth::user()->email }}
                </p>
                @endauth
              </div>
              <!-- panel-body  -->

            </div><!-- row -->
          </div>

          <!-- checkout-step-02  -->
          <div class="panel panel-default checkout-step-02">
            <div class="panel-heading">
              <h4 class="unicase-checkout-title">

                <a data-toggle="collapse" class="{{ $sentfromlastpage == 1 ? "" : "collapsed" }}"
                  data-parent="#accordion" href="#collapseTwo">
                  <span class="fa fa-check"></span>
                  {{ __('staticwords.ShippingInformation') }}
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse {{ $sentfromlastpage == 1 ? "in" : "" }}">

              <div class="panel-body">

                <button data-target="#mngaddress" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus"></i>
                  {{ __('staticwords.AddNewAddress') }}</button>
                <hr>
                <form action="{{route('choose.address')}}" method="post">
                  @csrf
                  <input type="hidden" name="total" value="">
                  <div class="row">

                    @foreach($addresses as $address)


                    <div class="margin-top8 col-md-6">
                      <div class="address address-1">
                        <div class="{{ session()->get('address') == $address->id ? "active" : "user-header" }}">

                          <h4><label><input {{ session()->get('address') == $address->id ? "checked" : "" }} required type="radio"
                                name="seladd" value="{{ $address->id }}" /> <b>{{$address->name}},
                                {{ $address->phone }}</b></label></h4>

                          @if($address->defaddress == 1)
                          <div class="ribbon ribbon-top-right"><span>{{ __('staticwords.Default') }}</span></div>
                          @endif
                        </div>

                        <div class="address-body">
                         
                          <span class="font-weight500"> {{ strip_tags($address->address) }}, <br>

                            <span>{{ $address->getcity ? $address->getcity->name : '' }},{{ $address->getstate->name }},{{ $address->getCountry->nicename }} {{ $address->pin_code }} </span>
                        </div>
                      </div>


                    </div>


                    @endforeach



                  </div>
                  <hr>

                  <input type="hidden" name="shipping" value="{{ $shippingcharge }}">


                  <button type="submit" class="btn btn-primary">{{__('staticwords.DeliverHere')}}</button>
                </form>

              </div>
            </div>
          </div>
          <!-- checkout-step-02 emd -->

          <!-- checkout-step-03  -->
          <div class="panel panel-default checkout-step-02">
            <div class="panel-heading">
              <h4 class="unicase-checkout-title">
                <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseThree">
                  <span class="fa fa-check"></span>{{__('staticwords.BillingInformation')}}
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
              <div class="panel-body">



                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" onchange="sameship()" id="sameasship"
                    {{ Session::get('ship_check') == Session::get('address') ? "checked" : "" }}>
                  <label class="font-weight-bold custom-control-label"
                    for="sameasship">{{ __('staticwords.BillingaddressissameasShippingaddress') }}</label>
                </div>

                <a data-target="#savedaddress" data-toggle="modal"
                  class="top-text font-weight500 pull-right">{{ __('staticwords.Orchoosedfromsavedaddress') }}
                </a>

                <!-- Saved Address Modal -->
                <!-- Modal -->
                <div class="modal fade" id="savedaddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{__('staticwords.Choosefromthelist')}}</h4>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          @foreach($addresses as $address)
                          @if(Session::get('address') != $address->id)

                          <div class="margin-top8 col-md-6">


                            <label>
                             
                              <input {{ !empty(session()->get('billing')) && session()->get('billing')['address'] == $address->address ? "checked" : "" }} value="{{ $address->id }}" type="radio" name="seladd2" id="seladd2">
                              <span class="font-size16">{{ $address->name }}, {{ $address->phone}}</span>
                                  
                                @if($address->defaddress == 1)
                                 <span class="font-weight400 badge badge-secondary">Default</span>
                                @endif
                                <br>
                                  
                                <span class="font-weight500"> {{ strip_tags($address->address) }}, <br>

                                <span>{{ $address->getcity ? $address->getcity->name : '' }},{{ $address->getstate->name }},{{ $address->getCountry->nicename }} {{ $address->pin_code }} </span>
                                </span>
                            </label>
                            
                              
                          </div>
                         
                          @endif
                          @endforeach

                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                          data-dismiss="modal">{{__('staticwords.Close')}}</button>
                        <button id="final_submit" onclick="fillbillingaddress()" type="button"
                          class="btn btn-primary"><i class="fa fa-save"></i> {{__('staticwords.Save')}}</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!--END-->

                <form id="billingForm" action="{{ route('checkout') }}" method="POST">

                  @csrf

                  <input type="hidden" id="shipval" name="sameship" value="0">

                  <hr>
                  <div class="form-group">

                    <label class="font-weight-bold" for="exampleInputEmail1">{{__('staticwords.Name')}} <span
                        class="required">*</span></label>
                    <input type="text" class="form-control unicase-form-control text-input" id="billing_name"
                      name="billing_name" value="{{ Session::get('billing')['firstname'] }}"
                      placeholder="{{ __('Please Enter Name') }}">

                  </div>

                  <div class="form-group">
                    <label class="font-weight-bold" for="exampleInputEmail2">{{__('staticwords.eaddress') }}<span
                        class="required">*</span></label>
                    <input type="text" class="form-control unicase-form-control text-input" id="billing_email"
                      name="billing_email" value="{{ Session::get('billing')['email'] }}"
                      placeholder="{{ __('Please Enter Email') }}">
                    <span class="required"></span>
                  </div>

                  <div class="form-group">
                    <label class="font-weight-bold" for="exampleInputEmail1">{{__('staticwords.ContactNumber')}}<span
                        class="required">*</span></label>
                    <input type="text" class="form-control unicase-form-control text-input" id="billing_mobile"
                      name="billing_mobile" value="{{ Session::get('billing')['mobile'] }}"
                      placeholder="{{ __('Please Enter Mobile Number') }}">

                  </div>
                  @if($pincodesystem == 1)
                  <div class="form-group">
                    <label class="font-weight-bold" for="exampleInputEmail1">Pincode<span
                        class="required">*</span></label>
                    <input type="text" class="form-control unicase-form-control text-input" id="billing_pincode"
                      name="billing_pincode" value="{{ Session::get('billing')['pincode'] }}"
                      placeholder="{{ __('Please Enter Pincode/Zipcode') }}">

                  </div>
                  @endif
                  <div class="form-group">
                    <label class="font-weight-bold" for="exampleInputEmail1">{{__('staticwords.Address')}}<span
                        class="required">*</span></label>
                    <input type="text" class="form-control unicase-form-control text-input" id="billing_address"
                      name="billing_address" value="{{ Session::get('billing')['address'] }}"
                      placeholder="{{ __('542 W. 15th Street') }}">

                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold" for="exampleInputEmail1">{{__('staticwords.Country')}} <span
                        class="required">*</span></label>
                    <select name="billing_country" class="form-control" id="billing_country">
                      <option value="0">{{__('staticwords.PleaseChooseCountry')}}</option>
                      @foreach($all_country as $c)
                      
                      <option value="{{$c->id}}"
                        {{ $c->id == Session::get('billing')['country_id'] ? 'selected' : '' }}>
                        {{$c->nicename}}
                      </option>
                      @endforeach
                    </select>

                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold" for="exampleInputEmail1">{{__('staticwords.State')}} <span
                        class="required">*</span></label>
                    <select name="billing_state" class="form-control" id="billing_state">
                      <option value="0">{{__('staticwords.PleaseChooseState')}}</option>
                      @foreach($selectedstates as $c)
                      <option value="{{$c->id}}"
                        {{ $c->id == Session::get('billing')['state'] ? 'selected="selected"' : '' }}>
                        {{$c->name}}
                      </option>
                      @endforeach
                    </select>

                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold" for="exampleInputEmail1">{{__('staticwords.City')}} <span
                        class="required">*</span></label>
                    <select name="billing_city" id="billing_city" class="form-control">
                      <option value="0">{{__('staticwords.PleaseChooseCity')}}</option>
                     
                      @foreach($selectedcities as $c)
                      <option value="{{$c->id}}"
                        {{ $c->id == Session::get('billing')['city'] ? 'selected' : '' }}>
                        {{$c->name}}
                      </option>
                      @endforeach
                    </select>
                  </div>

                  <input type="submit" class="btn btn-primary pull-right" value="Continue">
                </form>

              </div>
            </div>
          </div>
          <!-- checkout-step-03  -->

          <!-- checkout-step-04  -->
          <div class="panel panel-default checkout-step-03">
            <div class="panel-heading">
              <h4 class="unicase-checkout-title">
                <a id="orderRev" data-toggle="collapse" class="" data-parent="#accordion" href="#collapseFour">
                  <span id="o_tab">4</span>{{__('staticwords.OrderReview')}}
                </a>
              </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse show">
              <div class="panel-body">
                <div class="table-responsive">
                  <!-- View Final Address Card -->
                  <table class="table table-striped width100" align="center">
                    <thead>
                      <tr>
                        <th>
                          {{__('staticwords.ShippingAddress')}}
                        </th>

                        <th>
                          {{__('staticwords.BillingAddress')}}
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      @if(isset($selectedaddress))
                      <td>
                        <label>
                          <span class="font-size16 font-weight-bold">{{ $selectedaddress->name }}, {{ $selectedaddress->phone}}</span>
                          <br>
                          
                          <span class="font-weight500"> {{ strip_tags($selectedaddress->address) }}, <br>

                            <span>{{ $selectedaddress->getcity ? $selectedaddress->getcity->name : '' }},{{ $selectedaddress->getstate->name }},{{ $selectedaddress->getCountry->nicename }} {{ $selectedaddress->pin_code }} </span>
                          </span></label>
                      </td>
                      @else
                      <td>
                        <label>
                          {{__('No Address found !')}}
                        </label>
                      </td>
                      @endif

                      <td>
                        <label>
                          <span class="font-weight-bold">{{ Session::get('billing')['firstname'] }},
                            {{ Session::get('billing')['mobile'] }}</span>
                          <br>
                          @php
                          $c = App\Allcountry::where('id',Session::get('billing')['country_id'])->first();
                          $s = App\Allstate::where('id',Session::get('billing')['state'])->first();
                          $ci = App\Allcity::where('id',Session::get('billing')['city'])->first();
                          @endphp

                          <span class="font-size-14 font-weight-normal">
                            {{ strip_tags(Session::get('billing')['address']) }}, <br>

                            <span
                              class="font-size-14 font-weight-normal">{{ $ci ? $ci->name : '' }},{{ $s ? $s->name : '' }},{{ $c ? $c->nicename : '' }}
                              @if(!empty(Session::get('billing')['pincode'])), {{ Session::get('billing')['pincode'] }}
                              @endif</span>
                          </span>
                        </label>
                      </td>
                    </tbody>
                  </table>
                  <!-- View End Final Address Card -->
                </div>

                <section id="checkout-block" class="checkout-page-main-block">
                  <div class="container-fluid">
                    @foreach($cart_table as $row)

                    @php
                    
                    $orivar = $row->variant;
                    

                    $var_name_count = count($orivar['main_attr_id']);
                    unset($name);
                    $name = array();
                    $var_name;

                    $newarr = array();
                    for($i = 0; $i<$var_name_count; $i++){ $var_id=$orivar['main_attr_id'][$i];
                      $var_name[$i]=$orivar['main_attr_value'][$var_id];
                      $name[$i]=App\ProductAttributes::where('id',$var_id)->first();

                      }


                      try{
                        $url = url('details').'/'.$row->pro_id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                      }catch(\Exception $e)
                      {
                        $url = url('details').'/'.$row->pro_id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                      }

                      @endphp
                      <div class="row">
                        <div class="col-12 col-lg-9">
                          <div class="row no-gutters">
                            <div class="col-1 col-md-1 col-lg-1 col-xl-1">
                              <div class="checkout-page-img">
                                <img align="left" class="pro-img img-responsive"
                                  src="{{url('variantimages/thumbnails/'.$orivar->variantimages['main_image'])}}"
                                  alt="product_image">
                              </div>
                            </div>
                            <div class="col-11 col-md-11 col-xl-11">
                              <div class="checkout-page-dtl">
                                <p class="pro-des pro-des-one"><b><a href="{{ $url }}"
                                      title="{{substr($row->product->name, 0, 30)}}{{strlen($row->product->name)>30 ? '...' : ""}}">
                                      @php
                                      $varinfo =
                                      App\AddSubVariant::withTrashed()->where('id','=',$row->variant_id)->first();
                                      $varcount = count($varinfo->main_attr_value);
                                      $i=0;
                                      @endphp
                                      &nbsp;{{substr($row->product->name, 0, 30)}}{{strlen($row->product->name)>30 ? '...' : ""}}(@foreach($varinfo->main_attr_value
                                      as $key=> $orivar)
                                      <?php $i++; ?>

                                      @php
                                      $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
                                      $getvarvalue = App\ProductValues::where('id',$orivar)->first();
                                      @endphp

                                      @if($i < $varcount) @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values)
                                        != 0 && $getvarvalue->unit_value != null)
                                        @if($getvarvalue->proattr->attr_name == "Color" ||
                                        $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name
                                        == "color" || $getvarvalue->proattr->attr_name == "colour")
                                        {{ $getvarvalue->values }},
                                        @else
                                        {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }},
                                        @endif
                                        @else
                                        {{ $getvarvalue->values }},
                                        @endif
                                        @else
                                        @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 &&
                                        $getvarvalue->unit_value != null)
                                        @if($getvarvalue->proattr->attr_name == "Color" ||
                                        $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name
                                        == "color" || $getvarvalue->proattr->attr_name == "colour")
                                        {{ $getvarvalue->values }}
                                        @else
                                        {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }}
                                        @endif
                                        @else
                                        {{ $getvarvalue->values }}
                                        @endif
                                        @endif
                                        @endforeach
                                        )</a><span
                                      title="{{__('staticwords.qty')}}">&nbsp;x&nbsp;({{ $row->qty }})</span></b></p>

                                <p class="pro-des pro-des-one"><b>{{__('staticwords.Price')}}:</b>

                                  @if($row->product->offer_price != 0)
                                  
                                    @php

                                      $p=100;

                                      $taxrate_db = $row->product->tax_r;

                                      $vp = $p+$taxrate_db;

                                      $tam = $row->product->offer_price/$vp*$taxrate_db;

                                      $tam = sprintf("%.2f",$tam);

                                    @endphp

                                  @else

                                    @php

                                      $p=100;

                                      $taxrate_db = $row->product->tax_r;

                                      $vp = $p+$taxrate_db;
                                      
                                      $tam = $row->product->price/$vp*$taxrate_db;
                                     
                                      $tam = sprintf("%.2f",$tam);
                                     
                                    @endphp
                                    
                                  @endif


                                  @if($row->product->tax_r != '')



                                    @if($row->ori_offer_price != 0)

                                      <i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",($row->ori_offer_price-$tam)*$conversion_rate,2)}}

                                    @else

                                      <i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",($row->ori_price-$tam)*$conversion_rate,2)}}

                                    @endif

                                  @else

                                    @if($row->ori_offer_price != 0)
                                    
                                      <i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$row->ori_offer_price*$conversion_rate,2)}}

                                    @else

                                      <i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$row->ori_price*$conversion_rate,2)}}

                                    @endif

                                  @endif 

                                </p>
                                <p class="pro-des pro-des-one"><b>{{__('staticwords.SoldBy')}}:</b>
                                  <span>{{$row->product->store->name}}</span></p>
                                <p class="pro-des pro-des-one"> <b>{{__('staticwords.Tax')}} :</b>

                                  @if($row->product->tax != 0)

                                  <?php 
                                    $pri = array();
                                    $min_pri = array();
                                  ?>

                                  @foreach(App\TaxClass::where('id',$row->product->tax)->get(); as $tax)
                                  
                                            <?php

                                              if($tax->priority){
                                                foreach($tax->priority as $proity){

                                                  array_push($pri,$proity);

                                                }
                                              }


                                              ?>
                                 
                                              <?php
                                                  $matched = 'no';
                                                  
                                                  if($matched == 'no'){
                                                    if($pri == '' || $pri == null){
                                                    echo "Tax Not Applied";
                                                  }else{
                                                    
                                                    if($min_pri == null){
                                                     
                                                      $ch_prio = 0;
                                                      $i=0;
                                                      $x = min($pri);
                                                      array_push($min_pri, $x);
                                                      if($tax->priority){
                                                        
                                                        foreach($tax->priority as $key => $MaxPri){
                                                        
                                                        try{
                                                          if($tax->based_on[$min_pri[0]] == "billing"){
                                                           
                                                            $taxRate = App\Tax::where('id', $tax->taxRate_id[$min_pri[0]])->first();
                                                            $zone = App\Zone::where('id',$taxRate->zone_id)->first();
                                                            $store = Session::get('billing')['state'];

                                                            if(is_array($zone->name)){
                                                              
                                                              $zonecount = count($zone->name);

                                                              if($ch_prio == $min_pri[0]){
                                                                break;
                                                              }else{
                                                                foreach($zone->name as $z){
                                                                 
                                                                  $i++;

                                                                  if($store == $z)
                                                                  {
                                                                    $i = $zonecount;
                                                                    $matched = 'yes';
                                                                    if($taxRate->type=='p')
                                                                    {
                                                                      $tax_amount = $taxRate->rate;
                                                                      $price = $row->ori_offer_price == NULL && $row->ori_offer_price == 0 ? $row->ori_price * $row->qty : $row->ori_offer_price*$row->qty;
                                                                      $after_tax_amount = $price * ($tax_amount / 100);
                                                                      ?>
                                                                    <i class="{{ session()->get('currency')['value'] }}"></i>
                                                                    <?php
                                                                        $after_tax_amount = sprintf("%.2f",($after_tax_amount/$row->qty)*$conversion_rate);
                                                                    }// End if Billing Typ per And fix
                                                                    else{

                                                                      $tax_amount = $taxRate->rate;
                                                                      $price = $row->ori_offer_price == NULL && $row->ori_offer_price == 0 ? $row->ori_price * $row->qty : $row->ori_offer_price*$row->qty;
                                                                      $after_tax_amount =  $taxRate->rate;
                                                                      ?>
                                                                      <i class="{{ session()->get('currency')['value'] }}"></i>
                                                                    <?php
                                                                    
                                                                      echo sprintf("%.2f",($after_tax_amount/$row->qty)*$conversion_rate);
                                                                    }
                                                                    $ch_prio = $min_pri[0];
                                                                    break;
                                                                  }
                                                                  else{
                                                                    
                                                                    if($i == $zonecount){
                                                                      array_splice($pri, array_search($min_pri[0], $pri), 1);
                                                                      unset($min_pri);
                                                                      $min_pri = array();

                                                                    
                                                                        $x = min($pri);
                                                                        array_push($min_pri, $x);
                                                                      

                                                                      $i=0;
                                                                      break;
                                                                    }
                                                                  }
                                                                }
                                                              }

                                                            }
                                                          }else{

                                                            
                                                            
                                                            $taxRate = App\Tax::where('id', $tax->taxRate_id[$min_pri[0]])->first();
                                                            
                                                            $zone = App\Zone::where('id',$taxRate->zone_id)->first();

                                                            
                                                            $store = App\Store::where('user_id',$row->vender_id)->first();
                                                            
                                                            if(is_array($zone->name)){
                                                              
                                                              $zonecount = count($zone->name);

                                                              if($ch_prio == $min_pri[0]){
                                                                break;
                                                              }else{
                                                                foreach($zone->name as $z){

                                                                
                                                                  $i++;
                                                                  if($store->state_id == $z){
                                                                    
                                                                    $i = $zonecount;
                                                                    $matched = 'yes';
                                                                    if($taxRate->type=='p')
                                                                    {
                                                                      $tax_amount = $taxRate->rate;
                                                                      $price = $row->ori_offer_price == 0 ? $row->ori_price * $row->qty : $row->ori_offer_price*$row->qty;
                                                                      $after_tax_amount = $price * ($tax_amount / 100);
                                                                      ?>
                                                                      <i class="{{ session()->get('currency')['value'] }}"></i>
                                                                    <?php
                                                                    
                                                                      echo sprintf("%.2f",($after_tax_amount/$row->qty)*$conversion_rate);
                                                                    }// End if Billing Typ per And fix
                                                                    else{
                                                                      $tax_amount = $taxRate->rate;
                                                                      $price = $row->ori_offer_price == 0 ? $row->ori_price * $row->qty : $row->ori_offer_price*$row->qty;
                                                                      $after_tax_amount =  $taxRate->rate;
                                                                      ?>
                                                                  <i class="{{ session()->get('currency')['value'] }}"></i>
                                                                  <?php
                                                                        echo sprintf("%.2f",($after_tax_amount/$row->qty)*$conversion_rate);
                                                                    }
                                                                    $ch_prio = $min_pri[0];
                                                                    break;
                                                                  }
                                                                  else{
                                                                    if($i == $zonecount){
                                                                      array_splice($pri, array_search($min_pri[0], $pri), 1);
                                                                      unset($min_pri);
                                                                      $min_pri = array();

                                                                  
                                                                        $x = min($pri);
                                                                        array_push($min_pri, $x);
                                                                    
                                                                      $i = 0;
                                                                      break;
                                                                    }
                                                                  }
                                                                }
                                                              }

                                                            }
                                                          }
                                                        }catch(\Exception $e){
                                                          
                                                          ?>
                                  <i class="{{ session()->get('currency')['value'] }}"></i>
                                  <?php
                                                            $after_tax_amount = 0;
                                                          break;
                                                        }
                                                        
                                                      }
                                                      }
                                                    }else{
                                                      break;
                                                    }
                                                  }
                                                  }
                                                    
                                                ?>

                                  @if($row->product->store->country['nicename'] == 'India' ||  $row->product->store->country['nicename'] == 'india' )

                                  <!-- IGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE DIFFERENT -->

                                    @if($row->product->store->state['id'] != $address->getstate->id)

                                    {{ $after_tax_amount }} <b>[IGST]</b>

                                      @php
                                        Session::push('igst',$after_tax_amount*$row->qty);
                                        Session::forget('indiantax');
                                      @endphp

                                    @endif

                                  <!-- CGST + SGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE SAME -->
                                  

                                  @if($row->product->store->state['id'] == $address->getstate->id)
                                    @php
                                      $diviedtax = $after_tax_amount/2;
                                      Session::forget('igst');
                                      Session::push('indiantax', ['sgst' => $diviedtax*$row->qty, 'cgst' =>
                                      $diviedtax*$row->qty]);
                                    @endphp
                                    {{ sprintf("%.2f",($diviedtax)) }} <b>[SGST]</b> &nbsp; | &nbsp;
                                      <i class="fa {{ Session::get('currency')['value'] }}"></i>
                                    {{ sprintf("%.2f",($diviedtax)) }} <b>[CGST]</b>
                                  @endif



                                  @else
                                  {{ $after_tax_amount}}
                                  @endif

                                  @endforeach

                                  @else

                                 

                                  <i class="fa {{ Session::get('currency')['value'] }}"></i>
                                  @if($row->product->vender_offer_price != 0)

                                  @php
                                    $p=100;
                                    $taxrate_db = $row->product->tax_r;
                                    $vp = $p+$taxrate_db;
                                    $tamount = $row->product->offer_price/$vp*$taxrate_db;
                                    $tamount = sprintf("%.2f",$tamount*$conversion_rate);
                                  @endphp
                                  @else
                                  @php
                                    $p=100;
                                    $taxrate_db = $row->product->tax_r;
                                    $vp = $p+$taxrate_db;
                                    $tamount = $row->product->price/$vp*$taxrate_db;
                                    $tamount = sprintf("%.2f",$tamount*$conversion_rate);
                                  @endphp

                                  @endif

                                  @if($row->product->store->country['nicename'] == 'India' ||
                                    $row->product->store->country['nicename'] == 'india' )

                                  <!-- IGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE DIFFERENT -->

                                  @if($row->product->store->state->id != $address->getstate->id)

                                    {{ $tamount }} <b>[IGST]</b>

                                  @php
                                    Session::push('igst',$tamount*$row->qty);
                                    Session::forget('indiantax');
                                  @endphp

                                  @endif

                                  <!-- CGST + SGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE DIFFERENT -->


                                  @if($row->product->store->state['id'] == $address->getstate->id)
                                    @php
                                      $diviedtax = $tamount/2;
                                      Session::forget('igst');
                                      Session::push('indiantax', ['sgst' => $diviedtax*$row->qty, 'cgst' =>
                                      $diviedtax*$row->qty]);
                                    @endphp
                                    {{ sprintf("%.2f",($diviedtax)) }} <b>[SGST]</b> &nbsp; | &nbsp;
                                    <i class="fa {{ Session::get('currency')['value'] }}"></i>
                                    {{ sprintf("%.2f",($diviedtax)) }} <b>[CGST]</b>
                                  @endif

                                  @else
                                    {{ $tamount }} <b> [{{ $row->product->tax_r }}% ({{ $row->product->tax_name }})]</b>
                                  @endif

                                  @endif </b></p>
                                <p class="pro-des pro-des-one">
                                  <label class="text-orange font-weight500"><input
                                      onclick="localpickupcheck('{{ $row->id }}')" type="checkbox"
                                      {{ $row->ship_type ==  NULL ? "" :"checked" }} id="ship{{ $row->id }}"> <i
                                      class="fa fa-map-marker" aria-hidden="true"></i>
                                    {{__('staticwords.LocalPickup')}}</label>
                                  <br>
                                  <small class="help-block">
                                    ({{__('staticwords.iflocalpickup')}})
                                  </small>
                                </p>
                                @if($row->product->gift_pkg_charge != 0)
                                  <p class="pro-des pro-des-one">
                                    <label class="text-orange font-weight500">
                                      <input {{ $row->gift_pkg_charge != 0 ? "checked" : "" }} class="gift_pkg_charge" data-gift_charge="{{ $row->product->gift_pkg_charge }}" data-variant="{{ $row->variant->id }}" type="checkbox""></i>
                                      {{__('staticwords.GiftWrap')}} @ <i class="fa {{ Session::get('currency')['value'] }}"></i>{{ sprintf("%.2f",currency($row->product->gift_pkg_charge, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}</label>
                                  </p>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="text-right col-12 offset-md-3 col-md-9 offset-xl-0 col-xl-3">
                          <p><b>
                            @if($row->product->offer_price != 0)

                                @php

                                  $p=100;
                                  $taxrate_db = $row->product->tax_r;
                                  $vp = $p+$taxrate_db;
                                  $tamount = $row->product->offer_price/$vp*$taxrate_db;


                                  $tamount = sprintf("%.2f",$tamount);
                                  $actualtam= $tamount*$row->qty;

                                @endphp

                            @else
                           

                                @php

                                  $p=100;
                                  $taxrate_db = $row->product->tax_r;
                                  $vp = $p+$taxrate_db;
                                  $tamount = $row->product->price/$vp*$taxrate_db;
                                  

                                  $tamount = sprintf("%.2f",$tamount);
                                 
                                  $actualtam = $tamount*$row->qty;


                                @endphp

                            @endif

                              @if($row->product->tax_r == NULL)

                            
                                @if($row->ori_offer_price != 0 )
                                
                                + {{sprintf("%.2f",(($row->ori_offer_price*$row->qty)-$actualtam)*$conversion_rate)}}
                                @else

                                + {{ sprintf("%.2f",(($row->ori_price*$row->qty)-$actualtam)*$conversion_rate)}} <i class="{{session()->get('currency')['value'] }}"></i>
                                
                                @endif

                              @else
                              
                                @if($row->ori_offer_price != 0)
                                
                                + {{ sprintf("%.2f",(($row->ori_offer_price*$row->qty)-$actualtam)*$conversion_rate)}} <i
                                  class="{{session()->get('currency')['value'] }}"></i>
                                @else
                                
                                + {{sprintf("%.2f",(($row->ori_price*$row->qty)-$actualtam)*$conversion_rate)}} <i
                                  class="{{session()->get('currency')['value']}}"></i>
                                @endif

                              @endif</span></b>

                            <small class="text-muted">( <b>{{__('staticwords.TotalPrice')}}</b> )</small>
                          </p>

                          <p>
                            <b>+&nbsp;
                              @if($row->product->tax_r == NULL)

                              @php
                              $pri = array();
                              $min_pri = array();
                              @endphp

                              @foreach(App\TaxClass::where('id',$row->product->tax)->get(); as $tax)
                              <?php
                                            
                                            if(isset($tax->priority)){
                                              foreach($tax->priority as $proity){

                                                array_push($pri,$proity);
                                              
                                              }
                                            }

                                            ?>
                              @endforeach

                              @foreach(App\TaxClass::where('id',$row->product->tax)->get(); as $tax)

                              <?php
                                            $matched = 'no';
                                            if($matched == 'no'){

                                            if($pri == '' || $pri == null){
                                                echo "Tax Not Applied";
                                            }else{
                                            
                                              if($min_pri == null){
                                                $ch_prio = 0;
                                                $i=0;
                                                $x = min($pri);
                                                array_push($min_pri, $x);
                                                if(isset($tax->priority)){
                                                  foreach($tax->priority as $key => $MaxPri){

                                                      try{

                                                        if($tax->based_on[$min_pri[0]] == "billing" ){

                                                          $taxRate = App\Tax::where('id', $tax->taxRate_id[$min_pri[0]])->first();
                                                          $zone = App\Zone::where('id',$taxRate->zone_id)->first();
                                                          $store = Session::get('billing')['state'];

                                                          if(is_array($zone->name)){
                                                            $zonecount = count($zone->name);

                                                            if($ch_prio == $min_pri[0]){
                                                              break;
                                                            }else{
                                                              foreach($zone->name as $z){
                                                                $i++;
                                                                if($store == $z)
                                                                {

                                                                  $i = $zonecount;
                                                                  $matched = 'yes';
                                                                  if($taxRate->type == 'p')
                                                                  {
                                                                    $tax_amount = $taxRate->rate;
                                                                    $price = $row->ori_offer_price == 0 ? $row->ori_price * $row->qty : $row->ori_offer_price*$row->qty;
                                                                    $after_tax_amount = $price * ($tax_amount / 100);
                                                                    echo sprintf("%.2f",($after_tax_amount*$conversion_rate));
                                                                    $total_tax_amount += $after_tax_amount*$conversion_rate;
                                                                    App\Cart::where('id', $row->id)->update(array('tax_amount' => sprintf("%.2f",$after_tax_amount*$conversion_rate)));
                                                                    $after_tax_amount = $after_tax_amount;
                                                                      
                                                                      
                                                                      ?>
                              <i class="{{ session()->get('currency')['value'] }}"></i>
                              <?php
                                                                      
                                                                  }// End if Billing Typ per And fix
                                                                  else{

                                                                    $tax_amount = $taxRate->rate;
                                                                    $price = $row->ori_offer_price == 0 ? $row->ori_price * $row->qty: $row->ori_offer_price*$row->qty;
                                                                    $after_tax_amount =  $taxRate->rate;
                                                                    echo sprintf("%.2f",($after_tax_amount*$conversion_rate));
                                                                      $total_tax_amount += $after_tax_amount*$conversion_rate;
                                                                    App\Cart::where('id', $row->id)
                                                                            ->update(array('tax_amount' => sprintf("%.2f",$after_tax_amount*$conversion_rate)));
                                                                    $after_tax_amount = $after_tax_amount;
                                                                    
                                                                    
                                                                      ?>
                              <i class="{{ session()->get('currency')['value'] }}"></i>
                              <?php
                                                                    
                                                                  }
                                                                  $ch_prio = $min_pri[0];
                                                                  break;
                                                                }
                                                                else{
                                                                  if($i == $zonecount){
                                                                    array_splice($pri, array_search($min_pri[0], $pri), 1);
                                                                    unset($min_pri);
                                                                    $min_pri = array();

                                                                    
                                                                      $x = min($pri);
                                                                      array_push($min_pri, $x);
                                                                    

                                                                    $i=0;
                                                                    break;
                                                                  }
                                                                }
                                                              }
                                                            }

                                                          }
                                                        }else{

                                                          $taxRate = App\Tax::where('id', $tax->taxRate_id[$min_pri[0]])->first();
                                                          $zone = App\Zone::where('id',$taxRate->zone_id)->first();
                                                          $store = App\Store::where('user_id',$row->vender_id)->first();
                                                          if(is_array($zone->name)){
                                                            $zonecount = count($zone->name);

                                                            if($ch_prio == $min_pri[0]){
                                                              break;
                                                            }else{

                                                              foreach($zone->name as $z){
                                                                $i++;
                                                                if($store->state_id == $z){
                                                                  $i = $zonecount;
                                                                  $matched = 'yes';
                                                                  if($taxRate->type=='p')
                                                                  {
                                                                    $tax_amount = $taxRate->rate;
                                                                    $price = $row->ori_offer_price == 0 ? $row->ori_price * $row->qty : $row->ori_offer_price*$row->qty;
                                                                    $after_tax_amount = $price * ($tax_amount / 100);
                                                                    echo sprintf("%.2f",($after_tax_amount*$conversion_rate));
                                                                    $total_tax_amount += $after_tax_amount*$conversion_rate;
                                                                    App\Cart::where('id', $row->id)
                                                                            ->update(array('tax_amount' => sprintf("%.2f",$after_tax_amount*$conversion_rate)));
                                                                    $after_tax_amount = $after_tax_amount;
                                                                    
                                                                      
                                                                      ?>
                              <i class="{{ session()->get('currency')['value'] }}"></i>
                              <?php
                                                                      
                                                                  }// End if Billing Typ per And fix
                                                                  else{
                                                                    $tax_amount = $taxRate->rate;
                                                                    $price = $row->ori_offer_price == 0 ? $row->ori_price * $row->qty : $row->ori_offer_price*$row->qty;
                                                                    $after_tax_amount =  $taxRate->rate;
                                                                    echo sprintf("%.2f",($after_tax_amount*$conversion_rate));
                                                                    $total_tax_amount += $after_tax_amount*$conversion_rate;
                                                                    App\Cart::where('id', $row->id)->update(array('tax_amount' => sprintf("%.2f",$after_tax_amount*$conversion_rate)));
                                                                    $after_tax_amount = $after_tax_amount;
                                                                      
                                                                      
                                                                      ?>
                              <i class="{{ session()->get('currency')['value'] }}"></i>
                              <?php
                                                                    
                                                                  }
                                                                  $ch_prio = $min_pri[0];
                                                                  break;
                                                                }
                                                                else{
                                                                  if($i == $zonecount){
                                                                    array_splice($pri, array_search($min_pri[0], $pri), 1);
                                                                    unset($min_pri);
                                                                    $min_pri = array();

                                                                    
                                                                      $x = min($pri);
                                                                      array_push($min_pri, $x);
                                                                    
                                                                    $i = 0;
                                                                    break;
                                                                  }
                                                                }
                                                              }
                                                            }

                                                          }
                                                        }
                                                      }catch(\Exception $e){

                                                        
                                                        
                                                        echo $after_tax_amount = 0;
                                                        
                                                        ?>
                              <i class="{{ session()->get('currency')['value'] }}"></i>
                              <?php

                                                        App\Cart::where('id', $row->id)
                                                                            ->update(array('tax_amount' => sprintf("%.2f",$after_tax_amount)));

                                                        break;

                                                      }

                                                      }
                                                }
                                              }else{
                                                break;
                                              }
                                            }
                                            }
                                        
                                          ?>
                              @endforeach {{-- End Tax Class Foreach  --}}
                                              {{-- @dd($after_tax_amount) --}}
                              @else

                            


                              @if($row->product->offer_price != 0)
                              @php
                                $p=100;
                                $taxrate_db = $row->product->tax_r;
                                $vp = $p+$taxrate_db;
                                $tamount = $row->product->offer_price/$vp*$taxrate_db;
                                $tamount = sprintf("%.2f",$tamount*$conversion_rate);
                                $actualtax= $tamount*$row->qty;
                                echo $after_tax_amount = sprintf("%.2f",($actualtax));
                                $total_tax_amount += $actualtax;
                                App\Cart::where('id', $row->id)->update(array('tax_amount' =>
                                sprintf("%.2f",$actualtax)));
                              @endphp
                              @else
                                @php
                                  $p=100;
                                  $taxrate_db = $row->product->tax_r;
                                  $vp = $p+$taxrate_db;
                                  $tamount = $row->product->price/$vp*$taxrate_db;
                                  $tamount = sprintf("%.2f",$tamount*$conversion_rate);
                                  $actualtax = $tamount*$row->qty;
                                  echo $after_tax_amount = sprintf("%.2f",($actualtax));
                                  $total_tax_amount += $actualtax;
                                  App\Cart::where('id', $row->id)->update(array('tax_amount' =>
                                  sprintf("%.2f",$actualtax)));
                                @endphp
                              <i class="fa {{ Session::get('currency')['value'] }}"></i>
                              @endif


                              @endif
                            </b>
                            <small class="text-muted"><b>( {{__('staticwords.TotalTax')}} )</b></small>
                            {{-- End if Product Tax 0  --}}
                          </p>

                          @php
                          $user_id = Auth::user()->id;

                          if($row->ship_type != 'localpickup'){
                          if ($row->product->free_shipping == 0)
                          {

                          $free_shipping = App\Shipping::where('id', $row
                          ->product
                          ->shipping_id)
                          ->first();

                          if ($free_shipping)
                          {
                          if ($free_shipping->name == "Shipping Price")
                          {

                          $weight = App\ShippingWeight::first();
                          $pro_weight = $row->variant->weight;
                          if ($weight->weight_to_0 >= $pro_weight)
                          {
                          if ($weight->per_oq_0 == 'po')
                          {
                          $x = $weight->weight_price_0;
                          $total_shipping = $total_shipping + $weight->weight_price_0;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          else
                          {
                          $x = $weight->weight_price_0 * $row->qty;
                          $total_shipping = $total_shipping + $weight->weight_price_0 * $row->qty;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          }
                          elseif ($weight->weight_to_1 >= $pro_weight)
                          {
                          if ($weight->per_oq_1 == 'po')
                          {
                          $x = $weight->weight_price_1;
                          $total_shipping = $total_shipping + $weight->weight_price_1;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          else
                          {
                          $x = $weight->weight_price_1 * $row->qty;
                          $total_shipping = $total_shipping + $weight->weight_price_1 * $row->qty;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          }
                          elseif ($weight->weight_to_2 >= $pro_weight)
                          {
                          if ($weight->per_oq_2 == 'po')
                          {
                          $x = $weight->weight_price_1 * $row->qty;
                          $total_shipping = $total_shipping + $weight->weight_price_2;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          else
                          {
                          $x = $weight->weight_price_2 * $row->qty;
                          $total_shipping = $total_shipping + $weight->weight_price_2 * $row->qty;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          }
                          elseif ($weight->weight_to_3 >= $pro_weight)
                          {
                          if ($weight->per_oq_3 == 'po')
                          {
                          $x = $weight->weight_price_2 * $row->qty;
                          $total_shipping = $total_shipping + $weight->weight_price_3;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          else
                          {
                          $x = $weight->weight_price_2 * $row->qty;
                          $total_shipping = $total_shipping + $weight->weight_price_3 * $row->qty;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          }
                          else
                          {
                          if ($weight->per_oq_4 == 'po')
                          {
                          $x = $weight->weight_price_4;
                          $total_shipping = $total_shipping + $weight->weight_price_4;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }
                          else
                          {
                          $x = $weight->weight_price_4 * $row->qty;
                          $total_shipping = $total_shipping + $weight->weight_price_4 * $row->qty;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);
                          }

                          }

                          }
                          else
                          {
                          $x = $free_shipping->price;
                          $total_shipping = $total_shipping + $free_shipping->price;
                          App\Cart::where('id', $row->id)->update(['shipping' => $x]);

                          }
                          }



                          }
                          }else{
                          $total_shipping = $total_shipping+$row->shipping;
                          }
                          @endphp


                          @php
                          if($row->semi_total != 0){
                          $ctotal = $row->semi_total+$row->shipping;
                          }else{
                          $ctotal = $row->price_total+$row->shipping;
                          }
                          @endphp


                          @php

                          if(isset($ctotal)){

                          if($genrals_settings->cart_amount != 0 && $genrals_settings->cart_amount != ''){

                          if($ctotal*$conversion_rate >= $genrals_settings->cart_amount*$conversion_rate){

                          DB::table('carts')->where('user_id', '=', Auth::user()->id)->update(array('shipping' => 0));
                          $total_shipping = 0;
                          }

                          }

                          }

                          @endphp





                          <b>+ {{ sprintf("%.2f",$row->shipping*$conversion_rate) }}</b> <i
                            class="{{ session()->get('currency')['value'] }}"></i> <small class="text-muted"><b>(
                              {{__('staticwords.Shipping')}} )</b></small>
                         <p></p>
                         @if($row->gift_pkg_charge != 0)
                          <p>
                            <b>+ {{ sprintf("%.2f",$row->gift_pkg_charge*$conversion_rate) }} <i
                              class="{{ session()->get('currency')['value'] }}"></i></b>
                            <small class="text-muted">( <b>{{__('Gift Packaging charge')}}</b> )</small>
                          </p>
                          @endif
                          <small class="font-size10 text-justify" class="help-block">( {{__('staticwords.ptax')}}
                            )</small>


                          <div class="finaltotalbox">




                            <i class="{{ session()->get('currency')['value'] }}"></i>
                            <b>
                              @if($row->product->tax_r != '')
                              @if($row->semi_total != 0 && $row->semi_total != NULL)
                              <span id="totalprice{{ $row->id }}">
                                {{ sprintf("%.2f",($row->semi_total+$row->shipping)*$conversion_rate) }}
                              </span>
                              @else
                              <span id="totalprice{{ $row->id }}">
                                {{ sprintf("%.2f",($row->price_total+$row->shipping)*$conversion_rate) }}
                              </span>
                              @endif
                              @else
                              
                              <span id="totalprice{{ $row->id }}">
                               
                                @if($row->semi_total != '' && $row->semi_total != 0)
                                  {{ sprintf("%.2f",($row->semi_total+$row->gift_pkg_charge+$row->shipping+$after_tax_amount)*$conversion_rate,2) }}
                                @else
                                {{ sprintf("%.2f",($row->price_total+$row->gift_pkg_charge+$row->shipping+$after_tax_amount)*$conversion_rate) }}
                                @endif
                              </span>
                              @endif
                            </b> <small class="text-muted"><b>( {{__('staticwords.Subtotal') }})</b></small>
                            <br>
                            <small class="font-weight500">({{__('staticwords.inctax')}})</small>
                            <p></p>
                          </div>

                        </div>
                      </div>
                      <hr>
                      @endforeach

                  </div>
                </section>


                <div class="col-md-12 col-12 final_step-btn">
                  <br>
                  <button id="final_step"
                    class="pull-right btn btn-primary">{{__('staticwords.ProccedtoPayment')}}</button>
                </div>

              </div>
            </div>
          </div>
          <!-- checkout-step-03  -->

          <!-- checkout-step-04  -->
          <div class="panel panel-default checkout-step-04">
            <div class="panel-heading">
              <h4 class="unicase-checkout-title">
                <a class="collapsed" id="payment_box">
                  <span>5</span>{{__('staticwords.Payment')}}
                </a>
              </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse">
              <br>

              @php

              $config = $configs;

              $checkoutsetting_check = App\AutoDetectGeo::first();

              $listcheckOutCurrency =
              App\CurrencyCheckout::where('currency','=',Session::get('currency')['id'])->first();


              $secure_amount = 0;
              $handlingcharge = 0;

              // Calulate handling charge
              if($genrals_settings->chargeterm == 'fo'){
              // on full order handling charge
              $handlingcharge = $genrals_settings->handlingcharge;
              }elseif($genrals_settings->chargeterm == 'pi'){
              // Per item handling charge
              $totalcartitem = count($cart_table);
              $handlingcharge = $genrals_settings->handlingcharge*$totalcartitem;
              }



              //end

              foreach ($cart_table as $key => $val) {

                if ($val->product->tax_r != null && $val->product->tax == 0) {

                    if ($val->ori_offer_price != 0) {
                        //get per product tax amount
                        $p = 100;
                        $taxrate_db = $val->product->tax_r;
                        $vp = $p + $taxrate_db;
                        $taxAmnt = $val->product->offer_price / $vp * $taxrate_db;
                        $taxAmnt = sprintf("%.2f", $taxAmnt);
                        $price = ($val->ori_offer_price - $taxAmnt) * $val->qty;

                    } else {

                        $p = 100;
                        $taxrate_db = $val->product->tax_r;
                        $vp = $p + $taxrate_db;
                        $taxAmnt = $val->product->price / $vp * $taxrate_db;

                        $taxAmnt = sprintf("%.2f", $taxAmnt);

                        $price = ($val->ori_price - $taxAmnt) * $val->qty;
                    }

                  } else {

                      if ($val->semi_total != 0) {

                          $price = $val->semi_total;

                      } else {

                          $price = $val->price_total;

                      }
                  }

              $secure_amount = $secure_amount + $price;

              }

              $secure_amount = $secure_amount*$conversion_rate;
              $secure_amount = sprintf("%.2f",$secure_amount);
              $un_sec = $secure_amount;

              $handlingcharge = $handlingcharge*$conversion_rate;

              $total_gift_pkg_charge = sprintf("%.2f",auth()->user()->cart()->sum('gift_pkg_charge') * $conversion_rate);

              $secure_amount += ($total_shipping*$conversion_rate)+$total_gift_pkg_charge+$total_tax_amount+$handlingcharge;

              

              if(App\Cart::isCoupanApplied() == '1'){
                $secure_amount = $secure_amount-(App\Cart::getDiscount()*$conversion_rate);
              }


              $secure_amount = Crypt::encrypt($secure_amount);
              $handlingchargeS = Crypt::encrypt($handlingcharge);
              Session::put('handlingcharge',$handlingchargeS);





              @endphp



              <div class="row">
                <div class="col-4 col-md-3">
                  <!-- required for floating -->
                  <!-- Nav tabs -->
                  <div class="nav flex-column nav-pills" aria-orientation="vertical">

                    @if($config->paypal_enable == '1')
                    <a class="nav-link active" href="#paypalpaytab" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      Paypal</a>
                    @endif

                    @if($wallet_system == '1')
                    <a class="nav-link" href="#walletpay" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      {{ __('staticwords.Wallet') }}</a>
                    @endif

                    @if($config->braintree_enable == '1')
                    <a class="nav-link" href="#braintreePay" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      Braintree</a>
                    @endif
                    @if($config->paystack_enable == '1')
                    <a class="nav-link" href="#paystackpay" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      Paystack</a>
                    @endif
                    @if($config->instamojo_enable == '1')
                    <a class="nav-link" href="#instapaytab" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      Instamojo</a>
                    @endif
                    @if($config->stripe_enable == '1')
                    <a class="nav-link" href="#cardpaytab" data-toggle="tab">{{ __('staticwords.PayVia') }}Card</a>
                    @endif
                    @if($config->payu_enable == '1')
                    <a class="nav-link" href="#payupaytab" data-toggle="tab">{{ __('staticwords.PayVia') }} PayUBiz/
                      Money</a>
                    @endif
                    @if($config->paytm_enable == '1')
                    <a class="nav-link" href="#paytmtab" data-toggle="tab">{{ __('staticwords.PayVia') }} Paytm</a>
                    @endif
                    @if($config->razorpay == '1')
                    <a class="nav-link" href="#razorpaytab" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      RazorPay</a>
                    @endif

                    @if($config->payhere_enable == '1')
                    <a class="nav-link" href="#payheretab" data-toggle="tab">{{ __('staticwords.PayVia') }} Payhere</a>
                    @endif

                    @if($config->cashfree_enable == '1')
                    <a class="nav-link" href="#cashfreeTab" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      Cashfree</a>
                    @endif

                    @if($config->omise_enable == '1')
                    <a class="nav-link" href="#omiseTab" data-toggle="tab">{{ __('staticwords.PayVia') }} Omise</a>
                    @endif

                    @if($config->rave_enable == '1')
                    <a class="nav-link" href="#raveTab" data-toggle="tab">{{ __('staticwords.PayVia') }} Rave</a>
                    @endif

                    @if($config->moli_enable == '1')
                    <a class="nav-link" href="#mollieTab" data-toggle="tab">{{ __('staticwords.PayVia') }} Mollie</a>
                    @endif

                    @if($config->skrill_enable == '1')
                    <a class="nav-link" href="#skrillTab" data-toggle="tab">{{ __('staticwords.PayVia') }} Skrill</a>
                    @endif
                    
                    @if($config->sslcommerze_enable == '1')

                    <a class="nav-link" href="#sslcommerz" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      SSlCommerz</a>

                    @endif

                    @if($config->enable_amarpay == '1')

                    <a class="nav-link" href="#aamarpay" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      AAMARPAY</a>

                    @endif

                    @if($config->iyzico_enable == '1')

                    <a class="nav-link" href="#iyzico_payment_tab" data-toggle="tab">{{ __('staticwords.PayVia') }}
                      Iyzcio</a>

                    @endif

                    @if(config('dpopayment.enable') == 1 && Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())

                      @include("dpopayment::front.list")

                    @endif

                    @if(config('bkash.ENABLE') == 1 && Module::has('Bkash') && Module::find('Bkash')->isEnabled())

                      @include("bkash::front.list")

                    @endif

                    @foreach(App\ManualPaymentMethod::where('status','1')->get(); as $item)
                      <a class="nav-link" href="#manualpaytab{{ $item->id }}" data-toggle="tab">{{ ucfirst($item->payment_name) }}</a>
                    @endforeach

                    @if(env('BANK_TRANSFER') == 1)
                      <a class="nav-link" href="#btpaytab" data-toggle="tab">{{ __('staticwords.BankTranfer') }}</a>
                    @endif

                    @if(env('COD_ENABLE') == 1)
                      <a class="nav-link" href="#codpaytab" data-toggle="tab">{{ __('staticwords.PayOnDelivery') }}</a>
                    @endif

                  </div>
                </div>

                <div class="col-8 col-md-9">
                  <!-- Tab panes -->
                  <div class="tab-content">

                    @if($config->paypal_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane show active" id="paypalpaytab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'paypal'))

                      <form method="POST" id="payment-form" action="{!! URL::to('paypal') !!}">

                        {{ csrf_field() }}
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input class="w3-input w3-border" id="amount" type="hidden" name="amount"
                          value="{{$secure_amount}}">
                        <button type="submit" class="paypal-buy-now-button">
                          <span>{{ __('Express Checkout with') }}</span>
                          <svg aria-label="PayPal" xmlns="http://www.w3.org/2000/svg" width="90" height="33"
                            viewBox="34.417 0 90 33">
                            <path fill="#253B80"
                              d="M46.211 6.749h-6.839a.95.95 0 0 0-.939.802l-2.766 17.537a.57.57 0 0 0 .564.658h3.265a.95.95 0 0 0 .939-.803l.746-4.73a.95.95 0 0 1 .938-.803h2.165c4.505 0 7.105-2.18 7.784-6.5.306-1.89.013-3.375-.872-4.415-.972-1.142-2.696-1.746-4.985-1.746zM47 13.154c-.374 2.454-2.249 2.454-4.062 2.454h-1.032l.724-4.583a.57.57 0 0 1 .563-.481h.473c1.235 0 2.4 0 3.002.704.359.42.469 1.044.332 1.906zM66.654 13.075h-3.275a.57.57 0 0 0-.563.481l-.146.916-.229-.332c-.709-1.029-2.29-1.373-3.868-1.373-3.619 0-6.71 2.741-7.312 6.586-.313 1.918.132 3.752 1.22 5.03.998 1.177 2.426 1.666 4.125 1.666 2.916 0 4.533-1.875 4.533-1.875l-.146.91a.57.57 0 0 0 .562.66h2.95a.95.95 0 0 0 .939-.804l1.77-11.208a.566.566 0 0 0-.56-.657zm-4.565 6.374c-.316 1.871-1.801 3.127-3.695 3.127-.951 0-1.711-.305-2.199-.883-.484-.574-.668-1.392-.514-2.301.295-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.499.589.697 1.411.554 2.317zM84.096 13.075h-3.291a.955.955 0 0 0-.787.417l-4.539 6.686-1.924-6.425a.953.953 0 0 0-.912-.678H69.41a.57.57 0 0 0-.541.754l3.625 10.638-3.408 4.811a.57.57 0 0 0 .465.9h3.287a.949.949 0 0 0 .781-.408l10.946-15.8a.57.57 0 0 0-.469-.895z">
                            </path>
                            <path fill="#179BD7"
                              d="M94.992 6.749h-6.84a.95.95 0 0 0-.938.802l-2.767 17.537a.57.57 0 0 0 .563.658h3.51a.665.665 0 0 0 .656-.563l.785-4.971a.95.95 0 0 1 .938-.803h2.164c4.506 0 7.105-2.18 7.785-6.5.307-1.89.012-3.375-.873-4.415-.971-1.141-2.694-1.745-4.983-1.745zm.789 6.405c-.373 2.454-2.248 2.454-4.063 2.454h-1.031l.726-4.583a.567.567 0 0 1 .562-.481h.474c1.233 0 2.399 0 3.002.704.358.42.467 1.044.33 1.906zM115.434 13.075h-3.272a.566.566 0 0 0-.562.481l-.146.916-.229-.332c-.709-1.029-2.289-1.373-3.867-1.373-3.619 0-6.709 2.741-7.312 6.586-.312 1.918.131 3.752 1.22 5.03 1 1.177 2.426 1.666 4.125 1.666 2.916 0 4.532-1.875 4.532-1.875l-.146.91a.57.57 0 0 0 .563.66h2.949a.95.95 0 0 0 .938-.804l1.771-11.208a.57.57 0 0 0-.564-.657zm-4.565 6.374c-.314 1.871-1.801 3.127-3.695 3.127-.949 0-1.711-.305-2.199-.883-.483-.574-.666-1.392-.514-2.301.297-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.501.589.699 1.411.554 2.317zM119.295 7.23l-2.807 17.858a.569.569 0 0 0 .562.658h2.822c.469 0 .866-.34.938-.803l2.769-17.536a.57.57 0 0 0-.562-.659h-3.16a.571.571 0 0 0-.562.482z">
                            </path>
                          </svg>
                        </button>

                      </form>
                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Paypal 128 bit encryption') }}.</p>

                      @else

                      <h4>{{ __('Paypal') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane show active" id="paypalpaytab">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      <form method="POST" id="payment-form" action="{!! URL::to('paypal') !!}">

                        {{ csrf_field() }}
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input class="w3-input w3-border" id="amount" type="hidden" name="amount"
                          value="{{$secure_amount}}">
                        <button type="submit" class="paypal-buy-now-button">
                          <span>{{ __('Express Checkout with') }}</span>
                          <svg aria-label="PayPal" xmlns="http://www.w3.org/2000/svg" width="90" height="33"
                            viewBox="34.417 0 90 33">
                            <path fill="#253B80"
                              d="M46.211 6.749h-6.839a.95.95 0 0 0-.939.802l-2.766 17.537a.57.57 0 0 0 .564.658h3.265a.95.95 0 0 0 .939-.803l.746-4.73a.95.95 0 0 1 .938-.803h2.165c4.505 0 7.105-2.18 7.784-6.5.306-1.89.013-3.375-.872-4.415-.972-1.142-2.696-1.746-4.985-1.746zM47 13.154c-.374 2.454-2.249 2.454-4.062 2.454h-1.032l.724-4.583a.57.57 0 0 1 .563-.481h.473c1.235 0 2.4 0 3.002.704.359.42.469 1.044.332 1.906zM66.654 13.075h-3.275a.57.57 0 0 0-.563.481l-.146.916-.229-.332c-.709-1.029-2.29-1.373-3.868-1.373-3.619 0-6.71 2.741-7.312 6.586-.313 1.918.132 3.752 1.22 5.03.998 1.177 2.426 1.666 4.125 1.666 2.916 0 4.533-1.875 4.533-1.875l-.146.91a.57.57 0 0 0 .562.66h2.95a.95.95 0 0 0 .939-.804l1.77-11.208a.566.566 0 0 0-.56-.657zm-4.565 6.374c-.316 1.871-1.801 3.127-3.695 3.127-.951 0-1.711-.305-2.199-.883-.484-.574-.668-1.392-.514-2.301.295-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.499.589.697 1.411.554 2.317zM84.096 13.075h-3.291a.955.955 0 0 0-.787.417l-4.539 6.686-1.924-6.425a.953.953 0 0 0-.912-.678H69.41a.57.57 0 0 0-.541.754l3.625 10.638-3.408 4.811a.57.57 0 0 0 .465.9h3.287a.949.949 0 0 0 .781-.408l10.946-15.8a.57.57 0 0 0-.469-.895z">
                            </path>
                            <path fill="#179BD7"
                              d="M94.992 6.749h-6.84a.95.95 0 0 0-.938.802l-2.767 17.537a.57.57 0 0 0 .563.658h3.51a.665.665 0 0 0 .656-.563l.785-4.971a.95.95 0 0 1 .938-.803h2.164c4.506 0 7.105-2.18 7.785-6.5.307-1.89.012-3.375-.873-4.415-.971-1.141-2.694-1.745-4.983-1.745zm.789 6.405c-.373 2.454-2.248 2.454-4.063 2.454h-1.031l.726-4.583a.567.567 0 0 1 .562-.481h.474c1.233 0 2.399 0 3.002.704.358.42.467 1.044.33 1.906zM115.434 13.075h-3.272a.566.566 0 0 0-.562.481l-.146.916-.229-.332c-.709-1.029-2.289-1.373-3.867-1.373-3.619 0-6.709 2.741-7.312 6.586-.312 1.918.131 3.752 1.22 5.03 1 1.177 2.426 1.666 4.125 1.666 2.916 0 4.532-1.875 4.532-1.875l-.146.91a.57.57 0 0 0 .563.66h2.949a.95.95 0 0 0 .938-.804l1.771-11.208a.57.57 0 0 0-.564-.657zm-4.565 6.374c-.314 1.871-1.801 3.127-3.695 3.127-.949 0-1.711-.305-2.199-.883-.483-.574-.666-1.392-.514-2.301.297-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.501.589.699 1.411.554 2.317zM119.295 7.23l-2.807 17.858a.569.569 0 0 0 .562.658h2.822c.469 0 .866-.34.938-.803l2.769-17.536a.57.57 0 0 0-.562-.659h-3.16a.571.571 0 0 0-.562.482z">
                            </path>
                          </svg>
                        </button>

                      </form>
                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Paypal 128 bit encryption') }}.</p>
                    </div>
                    @endif

                    @endif

                    @if($wallet_system == 1)
                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane show" id="walletpay">
                      @if(isset(Auth::user()->wallet))
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'wallet'))
                      @if(Auth::user()->wallet->status == 1)

                      @if(round(Auth::user()->wallet->balance*$conversion_rate) >=
                      sprintf("%.2f",Crypt::decrypt($secure_amount)))
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>

                      <form action="{{ route('checkout.with.wallet') }}" method="POST">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input class="w3-input w3-border" id="amount" type="hidden" name="amount"
                          value="{{$secure_amount}}">
                        <button
                          title="{{ __('staticwords.Pay') }} {{ __('staticwords.via') }} {{ __('staticwords.Wallet') }}"
                          type="submit" class="btn btn-primary">
                          <i class="fa fa-folder-o" aria-hidden="true"></i> {{ __('staticwords.Pay') }}
                          {{ __('staticwords.via') }} {{ __('staticwords.Wallet') }}
                        </button>
                      </form>

                      @else
                      <h4>{{ __('staticwords.notenoughpoint') }}
                        <hr> <a title="Your Wallet" href="{{ route('user.wallet.show') }}">My Wallet</a></h4>
                      @endif


                      @else
                      <h4 class="text-red">{{ __('staticwords.errorwalletnotactive') }}</h4>
                      @endif

                      @else
                      <h5>{{ __('staticwords.Wallet') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h5>
                      @endif
                      @else
                      <h4>{{ __('staticwords.errorwallet') }}</h4>
                      @endif
                    </div>
                    @else
                    <div class="tab-pane show" id="walletpay">
                      @if(isset(Auth::user()->wallet))
                      @if(Auth::user()->wallet->status == 1)
                      @if(round(Auth::user()->wallet->balance*$conversion_rate) >=
                      sprintf("%.2f",Crypt::decrypt($secure_amount)))
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>
                      <form action="{{ route('checkout.with.wallet') }}" method="POST">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input class="w3-input w3-border" id="amount" type="hidden" name="amount"
                          value="{{$secure_amount}}">
                        <button
                          title="{{ __('staticwords.Pay') }} {{ __('staticwords.via') }} {{ __('staticwords.Wallet') }}"
                          type="submit" class="btn btn-primary">
                          <i class="fa fa-folder-o" aria-hidden="true"></i> {{ __('staticwords.Pay') }}
                          {{ __('staticwords.via') }} {{ __('staticwords.Wallet') }}
                        </button>
                      </form>
                      @else
                      <h4>{{ __('staticwords.notenoughpoint') }}
                        <hr> <a title="Your Wallet" href="{{ route('user.wallet.show') }}">My Wallet</a></h4>
                      @endif
                      @else
                      <h4 class="text-red">{{ __('staticwords.errorwalletnotactive') }}</h4>
                      @endif
                      @else
                      <h4>{{ __('staticwords.errorwallet') }}</h4>
                      @endif
                    </div>
                    @endif
                    @endif

                    @if($config->paystack_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane show" id="paystackpay">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'paystack'))

                      <form method="POST" action="{{ route('pay.via.paystack') }}" accept-charset="UTF-8"
                        class="form-horizontal" role="form">
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}"> {{-- required --}}
                        <input type="hidden" name="orderID" value="{{ uniqid() }}">
                        <input type="hidden" name="amount" value="{{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}">
                        {{-- required in kobo --}}
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="currency" value="{{ session()->get('currency')['id'] }}">
                        <input type="hidden" name="metadata"
                          value="{{ json_encode($array = ['key_name' => 'value',]) }}">
                        {{-- For other necessary things you want to add to your payload. it is optional though --}}
                        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                        {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{-- employ this in place of csrf_field only in laravel 5.0 --}}

                        <button class="btn btn-success btn-md" type="submit" value="Pay Now!">
                          Pay <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }} Now
                        </button>

                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Paystack Payments') }}.</p>

                      @else

                      <h4>{{ __('Paystack') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane show" id="paystackpay">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>

                      <form method="POST" action="{{ route('pay.via.paystack') }}" accept-charset="UTF-8"
                        class="form-horizontal" role="form">

                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="orderID" value="{{ uniqid() }}">
                        <input type="hidden" name="amount"
                          value="{{ sprintf("%.2f",(Crypt::decrypt($secure_amount))*100) }}"> {{-- required in kobo --}}
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="currency" value="{{ session()->get('currency')['id'] }}">
                        <input type="hidden" name="metadata"
                          value="{{ json_encode($array = ['key_name' => 'value',]) }}">
                        {{-- For other necessary things you want to add to your payload. it is optional though --}}
                        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                        {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{-- employ this in place of csrf_field only in laravel 5.0 --}}

                        <button class="btn btn-success btn-md" type="submit" value="Pay Now!">
                          Pay <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }} Now
                        </button>

                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Paystack Payments.') }}.</p>
                    </div>
                    @endif

                    @endif

                    @if($config->braintree_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane show" id="braintreePay">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'braintree'))

                      <a href="javascript:void(0);" class="payment-btn bt-btn btn btn-md btn-primary"><i
                          class="fa fa-credit-card"></i> Pay via Card / Paypal</a>
                      <div class="braintree">
                        <form method="POST" id="bt-form" action="{{ route('pay.bt') }}">
                          {{ csrf_field() }}
                          <div class="form-group">
                            <input type="hidden" class="form-control" name="amount" value="{{ $secure_amount }}">
                          </div>
                          <div class="bt-drop-in-wrapper">
                            <div id="bt-dropin"></div>
                          </div>
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <input id="nonce" name="payment_method_nonce" type="hidden" />
                          <button class="payment-final-bt d-none btn btn-md btn-primary" type="submit">
                            Pay <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }} Now
                          </button>
                          <div id="pay-errors" role="alert"></div>
                        </form>
                      </div>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Braintree Payments') }}.</p>

                      @else

                      <h4>{{ __('Braintree') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane show" id="braintreePay">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      <a href="javascript:void(0);" class="payment-btn bt-btn btn btn-md btn-primary"><i
                          class="fa fa-credit-card"></i> Pay via Card / Paypal</a>
                      <div class="braintree">
                        <form method="POST" id="bt-form" action="{{ route('pay.bt') }}">
                          {{ csrf_field() }}
                          <div class="form-group">
                            <input type="hidden" class="form-control" name="amount" value="{{ $secure_amount }}">
                          </div>
                          <div class="bt-drop-in-wrapper">
                            <div id="bt-dropin"></div>
                          </div>
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <input id="nonce" name="payment_method_nonce" type="hidden" />
                          <button class="payment-final-bt d-none btn btn-md btn-primary" type="submit">
                            Pay <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }} Now
                          </button>
                          <div id="pay-errors" role="alert"></div>
                        </form>
                      </div>
                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Braintree Payments.') }}.</p>
                    </div>
                    @endif

                    @endif

                    @if($config->instamojo_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="instapaytab">
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'instamojo'))

                      <h3>{{__('staticwords.Pay')}}<i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      <form action="{{ route('payviainsta') }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $secure_amount }}">
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        @php
                        $order = uniqid();
                        Session::put('order_id',$order);
                        @endphp

                        <button type="submit" class="insta-buy-now-button">
                          <span>{{ __('Express Checkout with ') }} <img src="{{ url('images/download.png') }}"
                              alt="instamojo" title="{{ __('Pay with Instamojo') }}"></span>
                        </button>

                      </form>

                      @else
                      <h4>{{ __('Instamojo') }} {{__('staticwords.chknotavbl')}}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="instapaytab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      <form action="{{ route('payviainsta') }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $secure_amount }}">
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        @php
                        $order = uniqid();
                        Session::put('order_id',$order);
                        @endphp



                        <button type="submit" class="insta-buy-now-button">
                          <span>{{ __('Express Checkout with') }} <img src="{{ url('images/download.png') }}"
                              alt="instamojo" title="{{ __('Pay with Instamojo') }}"></span>
                        </button>

                      </form>
                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Instamojo Payment protection') }}.</p>

                    </div>
                    @endif

                    @endif

                    @if($config->stripe_enable == '1')
                    <div class="tab-pane" id="cardpaytab">
                      @if($checkoutsetting_check->checkout_currency == 1)
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'stripe'))
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="card-wrapper"></div>
                          <br>
                          <p class="text-muted"><i class="fa fa-lock"></i>
                            {{ __('Secured Transcation Powered By Stripe Payments') }}</p>
                        </div>

                        <div class="col-md-6">
                          <div class="form-container active">
                            <form method="POST" action="{{ route('paytostripe') }}" id="credit-card">
                              @csrf
                              <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                              <div class="form-group">
                                <input max="16" class="form-control" placeholder="Card number" type="tel" name="number">
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



                              <input id="amount" type="hidden" class="form-control" name="amount"
                                value="{{ $secure_amount }}">

                              <div class="form-group">
                                <button title="{{ __('Click to complete your payment') }} !" type="submit"
                                  class="btn btn-primary btn-lg btn-block" id="confirm-purchase">{{ __('Pay') }} <i
                                    class="{{session()->get('currency')['value']}}"></i>
                                  @if(Session::has('coupanapplied'))
                                  {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}

                                  @else
                                  {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}
                                  @endif {{ __('Now') }}</button>
                              </div>


                            </form>
                          </div>
                        </div>
                      </div>

                      @else

                      <h4>{{ __('Stripe Card') }} {{__('staticwords.chknotavbl')}}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>


                      @endif
                      @else
                      <div class="row">
                        <div class="col-md-6">
                          <div class="card-wrapper"></div>
                          <br>
                          <p class="text-muted"><i class="fa fa-lock"></i>
                            {{ __('Secured Card Transcations Powered By Stripe Payments') }}</p>
                        </div>

                        <div class="col-md-6">
                          <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                          <div class="form-container active">
                            <form method="POST" action="{{route('paytostripe')}}" id="credit-card">
                              @csrf

                              <div class="form-group">
                                <input max="16" class="form-control" placeholder="Card number" type="tel" name="number">
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

                              <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                              <input id="amount" type="hidden" class="form-control" name="amount"
                                value="{{ $secure_amount }}">

                              <div class="form-group">
                                <button title="Click to complete your payment !" type="submit"
                                  class="btn btn-primary btn-lg btn-block" id="confirm-purchase">{{ __('Pay') }} <i
                                    class="{{session()->get('currency')['value']}}"></i>
                                  @if(Session::has('coupanapplied'))
                                  {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}

                                  @else
                                  {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}
                                  @endif {{ __('Now') }}</button>
                              </div>


                            </form>
                          </div>
                        </div>
                      </div>



                      @endif
                    </div>
                    @endif

                    @if($config->payu_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                      <div class="tab-pane" id="payupaytab">
                        @if(isset($listcheckOutCurrency->payment_method) &&
                        strstr($listcheckOutCurrency->payment_method,'payu'))

                        <h3>{{__('staticwords.Pay')}}<i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                        <hr>
                        <form action="{{ route('payviapayu') }}" method="POST">
                          @csrf
                          @php
                          $order = uniqid();
                          Session::put('order_id',$order);
                          @endphp
                          <input name="amount" type="hidden" value="{{ $secure_amount }}">
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <button type="submit" class="payu-buy-now-button">
                            <span>{{ __('Express checkout with') }} <img src="{{ url('images/payu.png') }}" alt="payulogo"
                                title="{{ __('Pay with PayU') }}"></span>
                          </button>
                        </form>
                        <hr>
                        <p class="text-muted"><i class="fa fa-lock"></i>
                          {{ __('Secured Transcation Powered By PayU Payments') }}</p>

                        @else
                        <h4>{{ __('Payu Money') }} {{__('staticwords.chknotavbl')}}
                          <b>{{ session()->get('currency')['id'] }}</b>.</h4>
                        @endif
                      </div>
                    @else
                      <div class="tab-pane" id="payupaytab">
                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ Crypt::decrypt($secure_amount) }}</h3>
                        <hr>
                        <form action="{{ route('payviapayu') }}" method="POST">
                          @csrf
                          @php
                          $order = uniqid();
                          Session::put('order_id',$order);
                          @endphp
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <input name="amount" type="hidden" value="{{ $secure_amount }}">
                          <button type="submit" class="payu-buy-now-button">
                            <span>{{ __('Express checkout with') }} <img src="{{ url('images/payu.png') }}" alt="payulogo"
                                title="{{ __('Pay with PayU') }}"></span>
                          </button>
                        </form>
                        <hr>
                        <p class="text-muted"><i class="fa fa-lock"></i>
                          {{ __('Secured Transcation Powered By PayU Payments') }}</p>
                      </div>
                    @endif

                    @endif

                    @if($config->payhere_enable == '1')

                    @php
                      $address = App\Address::find(session()->get('address'));
                      $payhere_order_id = uniqid();
                    @endphp

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="payheretab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'payhere'))

                      <form method="post" action="https://sandbox.payhere.lk/pay/checkout">
                        @csrf
                        <input type="hidden" name="merchant_id" value="{{ env('PAYHERE_MERCHANT_ID') }}">
                        <!-- Replace your Merchant ID -->
                        <input type="hidden" name="return_url" value="{{ url('/payhere/callback') }}">
                        <input type="hidden" name="cancel_url" value="{{ url('/checkout') }}">
                        <input type="hidden" name="notify_url" value="{{ url('/notify/payhere') }}">
                        <input type="hidden" name="order_id" value="{{ $payhere_order_id }}">
                        <input type="hidden" name="items" value="Payment For Order {{ $payhere_order_id }}">
                        <input type="hidden" name="currency" value="{{ session()->get('currency')['id'] }}">
                        <input type="hidden" name="amount" value="{{ Crypt::decrypt($secure_amount) }}">
                        <input type="hidden" name="first_name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="last_name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="phone" value="{{ Auth::user()->mobile }}">
                        <input type="hidden" name="address"
                          value="{{ isset($address) ? $address['address'] : "No Address" }}">
                        <input type="hidden" name="city" value="{{ $address->getcity['name'] ?? '' }}">
                        <input type="hidden" name="country" value="{{ $address->getCountry['nicename'] }}">
                        <button type="submit" class="payhere-buy-now-button">
                          <span> <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }} <img
                              src="{{ url('images/payhere.png') }}" alt="payherelogo" title="Pay with Payhere"></span>
                        </button>
                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Paypal 128 bit encryption') }}.</p>

                      @else

                      <h4>{{ __('Payhere') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="payheretab">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>

                      <form method="post" action="https://sandbox.payhere.lk/pay/checkout">
                        @csrf
                        <input type="hidden" name="merchant_id" value="{{ env('PAYHERE_MERCHANT_ID') }}">
                        <!-- Replace your Merchant ID -->
                        <input type="hidden" name="return_url" value="{{ url('/payhere/callback') }}">
                        <input type="hidden" name="cancel_url" value="{{ url('/checkout') }}">
                        <input type="hidden" name="notify_url" value="{{ url('/notify/payhere') }}">
                        <input type="hidden" name="order_id" value="{{ $payhere_order_id }}">
                        <input type="hidden" name="items" value="Payment For Order {{ $payhere_order_id }}">
                        <input type="hidden" name="currency" value="{{ session()->get('currency')['id'] }}">
                        <input type="hidden" name="amount" value="{{ Crypt::decrypt($secure_amount) }}">
                        <input type="hidden" name="first_name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="last_name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="phone" value="{{ Auth::user()->mobile }}">
                        <input type="hidden" name="address"
                          value="{{ isset($address) ? $address['address'] : "No Address" }}">
                        <input type="hidden" name="city" value="{{ $address->getcity['name'] ?? '' }}">
                        <input type="hidden" name="country" value="{{ $address->getCountry['nicename'] }}">
                        <button type="submit" class="payhere-buy-now-button">
                          <span> <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }} <img
                              src="{{ url('images/payhere.png') }}" alt="payherelogo" title="Pay with Payhere"></span>
                        </button>
                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Payhere transcations.') }}.</p>
                    </div>
                    @endif

                    @endif

                    @if($config->cashfree_enable == '1')


                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="cashfreeTab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'cashfree'))

                      <form action="{{ route('cashfree.pay') }}" method="POST" autocomplete="off">
                        @csrf
                        
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount" value="{{ $secure_amount  }}" />
                        <input required="" name="email" type="hidden" value="{{ Auth::user()->email }}" />
                        <input pattern="[0-9]+" required="" value="{{ Auth::user()->mobile }}" name="phone"
                          type="hidden" />


                        <button type="submit" class="cashfree-buy-now-button">
                          <span>Express checkout with <img src="{{ url('images/cashfree.svg') }}" alt="cashfree"
                              title="Pay with Cashfree"></span>
                        </button>

                      </form>


                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Cashfree secured payments.') }}.</p>

                      @else

                      <h4>{{ __('Cashfree') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="cashfreeTab">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>

                      

                      <form action="{{ route('cashfree.pay') }}" method="POST" autocomplete="off">
                        @csrf

                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount" value="{{ $secure_amount  }}" />
                        <input required="" name="email" type="hidden" value="{{ Auth::user()->email }}" />
                        <input pattern="[0-9]+" required="" value="{{ Auth::user()->mobile }}" name="phone"
                          type="hidden" />


                        <button type="submit" class="cashfree-buy-now-button">
                          <span>Express checkout with <img src="{{ url('images/cashfree.svg') }}" alt="cashfree"
                              title="Pay with Cashfree"></span>
                        </button>

                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Payhere transcations.') }}.</p>
                    </div>
                    @endif

                    @endif

                    @if($config->omise_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="omiseTab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'omise'))


                      <form id="checkoutForm" method="POST" action="{{ route('pay.via.omise') }}">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount" value="{{ $secure_amount }}" />
                        <script type="text/javascript" src="https://cdn.omise.co/omise.js"
                          data-key="{{ env('OMISE_PUBLIC_KEY') }}"
                          data-amount="{{ sprintf("%.2f",Crypt::decrypt($secure_amount))*100 }}"
                          data-frame-label="{{ config('app.name') }}"
                          data-image="{{ url('images/genral/'.$front_logo) }}"
                          data-currency="{{ session()->get('currency')['id'] }}"
                          data-default-payment-method="credit_card">
                        </script>
                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Omise secured payments.') }}.</p>

                      @else

                      <h4>{{ __('Omise') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="omiseTab">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>

                      <form id="checkoutForm" method="POST" action="{{ route('pay.via.omise') }}">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount" value="{{ $secure_amount }}" />
                        <script type="text/javascript" src="https://cdn.omise.co/omise.js"
                          data-key="{{ env('OMISE_PUBLIC_KEY') }}"
                          data-amount="{{ sprintf("%.2f",Crypt::decrypt($secure_amount))*100 }}"
                          data-frame-label="{{ config('app.name') }}"
                          data-image="{{ url('images/genral/'.$front_logo) }}"
                          data-currency="{{ session()->get('currency')['id'] }}"
                          data-default-payment-method="credit_card">
                        </script>
                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Omise transcations.') }}.</p>
                    </div>
                    @endif

                    @endif

                    @if($config->rave_enable == '1')

                    @php
                    $array = array(array('metaname' => 'color', 'metavalue' => 'blue'),
                    array('metaname' => 'size', 'metavalue' => 'big'));
                    $rave_order_id = session()->put('order_id',uniqid());
                    @endphp

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="raveTab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'rave'))

                      <form method="POST" action="{{ route('rave.pay') }}" id="paymentForm">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount"
                          value="{{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}" />
                        <input type="hidden" name="payment_method" value="both" />
                        <input type="hidden" name="description" value="Payment for order {{ $rave_order_id }}" />
                        <input type="hidden" name="country" value="NG" />
                        <input type="hidden" name="currency" value="{{ session()->get('currency')['id'] }}" />
                        <input type="hidden" name="email" value="{{ $address->email }}" />
                        <input type="hidden" name="firstname" value="{{ $address->name }}" />
                        <input type="hidden" name="lastname" value="{{ $address->name }}" />
                        <input type="hidden" name="metadata" value="{{ json_encode($array) }}">
                        <input type="hidden" name="phonenumber" value="{{ $address->phone }}" />
                        <input type="hidden" name="logo" value="{{ env('RAVE_LOGO') }}" />
                        <input type="submit" value="Pay {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}" />
                      </form>


                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Rave secured payments.') }}.</p>

                      @else

                      <h4>{{ __('Rave') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="raveTab">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>

                      <form method="POST" action="{{ route('rave.pay') }}" id="paymentForm">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount"
                          value="{{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}" />
                        <input type="hidden" name="payment_method" value="both" />
                        <input type="hidden" name="description" value="Payment for order {{ $rave_order_id }}" />
                        <input type="hidden" name="country" value="NG" />
                        <input type="hidden" name="currency" value="{{ session()->get('currency')['id'] }}" />
                        <input type="hidden" name="email" value="{{ $address->email }}" />
                        <input type="hidden" name="firstname" value="{{ $address->name }}" />
                        <input type="hidden" name="lastname" value="{{ $address->name }}" />
                        <input type="hidden" name="metadata" value="{{ json_encode($array) }}">
                        <input type="hidden" name="phonenumber" value="{{ $address->phone }}" />
                        <input type="hidden" name="logo" value="{{ env('RAVE_LOGO') }}" />
                        <input type="submit" value="Pay {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}" />
                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Rave transcations.') }}.</p>
                    </div>
                    @endif

                    @endif


                    @if($config->moli_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="mollieTab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'mollie'))

                      <form action="{{ route('mollie.pay') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount" value="{{ $secure_amount  }}" />
                        <button type="submit" class="mollie-buy-now-button">
                          <span>{{ __('Express checkout with') }} <img src="{{ url('images/moli.png') }}"
                              alt="mollielogo" title="{{ __('Pay with Mollie') }}"></span>
                        </button>
                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Mollie secured payments.') }}.</p>

                      @else

                      <h4>{{ __('Mollie') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="mollieTab">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>

                      <form action="{{ route('mollie.pay') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount" value="{{ $secure_amount  }}" />
                        <button type="submit" class="mollie-buy-now-button">
                          <span>{{ __('Express checkout with') }} <img src="{{ url('images/moli.png') }}"
                              alt="mollielogo" title="{{ __('Pay with Mollie') }}"></span>
                        </button>
                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Mollie transcations.') }}.</p>
                    </div>
                    @endif

                    @endif

                    @if($config->skrill_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="skrillTab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'skrill'))

                      <form action="{{ route('skrill.pay') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount" value="{{ $secure_amount  }}" />
                        <button type="submit" class="skrill-buy-now-button">
                          <span>{{ __('Express checkout with') }} <img src="{{ url('images/skrill.png') }}"
                              alt="skrill_logo" title="{{ __('Pay with Skrill') }}"></span>
                        </button>
                      </form>


                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Skrill secured payments.') }}.</p>

                      @else

                      <h4>{{ __('Skrill') }} {{__('staticwords.chknotavbl') }}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="skrillTab">
                      <h3>{{ __('staticwords.Pay') }} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                      <hr>

                      <form action="{{ route('skrill.pay') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input type="hidden" name="amount" value="{{ $secure_amount  }}" />
                        <button type="submit" class="skrill-buy-now-button">
                          <span>{{ __('Express checkout with') }} <img src="{{ url('images/skrill.png') }}"
                              alt="skrill_logo" title="{{ __('Pay with Skrill') }}"></span>
                        </button>
                      </form>

                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Your transcation is secured with Skrill transcations.') }}.</p>
                    </div>
                    @endif

                    @endif



                    @if($config->paytm_enable == '1')

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="paytmtab">
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'Paytm'))

                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ sprintf("%.2f",Crypt::decrypt($secure_amount),2) }}</h3>
                      <hr>
                      <form action="{{ route('payviapaytm') }}" method="POST">
                        @php
                        $order = uniqid();
                        Session::put('order_id',$order);
                        @endphp
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input name="amount" type="hidden" value="{{ $secure_amount }}">
                        <button type="submit" class="paytm-buy-now-button">
                          <span>Express checkout with <img src="{{ url('images/paywithpaytm.jpg') }}" alt="payulogo"
                              title="Pay with Paytm"></span>
                        </button>
                      </form>
                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Secured Transcation Powered By Paytm Payments') }}</p>

                      @else
                      <h4>{{ __('Paytm') }} {{__('staticwords.chknotavbl')}}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>
                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="paytmtab">
                      <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                        {{ Crypt::decrypt($secure_amount) }}</h3>
                      <hr>
                      <form action="{{ route('payviapaytm') }}" method="POST">
                        @php
                        $order = uniqid();
                        Session::put('order_id',$order);
                        @endphp
                        @csrf
                        <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                        <input name="amount" type="hidden" value="{{ $secure_amount }}">
                        <button type="submit" class="paytm-buy-now-button">
                          <span>{{ __('Express checkout with') }} <img src="{{ url('images/paywithpaytm.jpg') }}"
                              alt="payulogo" title="{{ __('Pay with Paytm') }}"></span>
                        </button>
                      </form>
                      <hr>
                      <p class="text-muted"><i class="fa fa-lock"></i>
                        {{ __('Secured Transcation Powered By Paytm Payments') }}</p>
                    </div>
                    @endif

                    @endif
                    
                    @if(env('COD_ENABLE') == 1)

                      @php
                        $codcheck = array();
                      @endphp

                      @foreach($cart_table as $cod_chk)

                        @php
                          $getproduct = App\Product::find($cod_chk->pro_id);
                          array_push($codcheck,$getproduct->codcheck);
                        @endphp

                      @endforeach

                      @if($checkoutsetting_check->checkout_currency == 1)
                        <div class="tab-pane" id="codpaytab">
                          @if(isset($listcheckOutCurrency->payment_method) &&
                          strstr($listcheckOutCurrency->payment_method,'cashOnDelivery'))

                          @if(in_array(0, $codcheck))
                          <span class="required">{{__('staticwords.someproductnotsupport')}}</span>
                          @else
                          @php
                          $token = str_random(25);
                          @endphp
                          <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ Crypt::decrypt($secure_amount) }}</h3>
                          <hr>
                          <form action="{{ route('cod.process',$token) }}" method="POST">
                            @csrf
                            <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                            <input type="hidden" name="amount" value="{{ $secure_amount }}">

                            <button title="{{__('staticwords.Poddoor')}}" type="submit" class="cod-buy-now-button">
                              <span>{{__('staticwords.Pod')}}</span> <i class="fa fa-money"></i>
                            </button>
                          </form>
                          <hr>
                          <p class="text-muted"><i class="fa fa-money"></i> {{__('staticwords.Poddoor')}}</p>
                          @endif
                          @else
                          <h4>
                            <h4>{{ __('COD') }} {{__('staticwords.chknotavbl') }}
                              <b>{{ session()->get('currency')['id'] }}</b>.</h4>
                          </h4>
                          @endif
                        </div>
                      @else
                        <div class="tab-pane" id="codpaytab">
                          @if(in_array(0, $codcheck))
                          <span class="required">{{__('staticwords.someproductnotsupport')}}</span>
                          @else
                          @php
                          $token = str_random(25);
                          @endphp
                          <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ Crypt::decrypt($secure_amount) }}</h3>
                          <hr>
                          <form action="{{ route('cod.process',$token) }}" method="POST">
                            @csrf
                            <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                            <input type="hidden" name="amount" value="{{ $secure_amount }}">
                            <button title="Pay With Cash @ Delivery Time" type="submit" class="cod-buy-now-button">
                              <span>{{__('staticwords.Pod')}}</span> <i class="fa fa-money"></i>
                            </button>
                          </form>
                          <hr>
                          <p class="text-muted"><i class="fa fa-money"></i> {{__('staticwords.Poddoor')}}</p>
                          @endif
                        </div>
                      @endif

                    @endif

                    @if($checkoutsetting_check->checkout_currency == 1)
                   
                    <div class="tab-pane" id="sslcommerz">
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'sslcommerze'))
                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ sprintf('%.2f',Crypt::decrypt($secure_amount)) }}</h3>
                        <hr>
                        <form action="{{ route('payvia.sslcommerze') }}" method="POST">
                          @csrf
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <input type="hidden" name="amount" value="{{ $secure_amount }}">
                          <button class="btn btn-primary btn-md" id="sslczPayBtn">
                              {{__("Pay Now")}} <i class="{{ session()->get('currency')['value'] }}"></i>
                              {{ sprintf('%.2f',Crypt::decrypt($secure_amount)) }}
                          </button>
                        </form>

                      @else
                        <h4>{{__('SSLCommerz')}} {{__('staticwords.chknotavbl')}}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>
                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="sslcommerz">
                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ Crypt::decrypt($secure_amount) }}</h3>
                        <hr>
                        <form action="{{ route('payvia.sslcommerze') }}" method="POST">
                          @csrf
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <input type="hidden" name="amount" value="{{ $secure_amount }}">
                          <button class="btn btn-primary btn-md" id="sslczPayBtn">
                              {{__("Pay Now")}} <i class="{{ session()->get('currency')['value'] }}"></i>
                              {{ sprintf('%.2f',Crypt::decrypt($secure_amount)) }}
                          </button>
                        </form>
                       
                    </div>
                    @endif

                    @if($checkoutsetting_check->checkout_currency == 1)
                   
                    <div class="tab-pane" id="aamarpay">
                      @if(isset($listcheckOutCurrency->payment_method) && strstr($listcheckOutCurrency->payment_method,'amarpay'))
                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ sprintf('%.2f',Crypt::decrypt($secure_amount)) }}</h3>
                        <hr>
                        
                        <div class="aamar-pay-btn">
                          {!! 
                            aamarpay_post_button([
                                'cus_name'  => auth()->user()->name, // Customer name
                                'cus_email' => auth()->user()->email, // Customer email
                                'cus_phone' => auth()->user()->mobile // Customer Phone
                            ], Crypt::decrypt($secure_amount), '<i class="fa fa-money"></i> Pay via AAMARPAY', 'btn btn-md btn-primary') 
                          !!}
                        </div>

                      @else
                        <h4>{{__('AAMARPAY')}} {{__('staticwords.chknotavbl')}}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>
                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="aamarpay">

                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ Crypt::decrypt($secure_amount) }}</h3>
                        <hr>
                        
                        <div class="aamar-pay-btn">
                          {!! 
                            aamarpay_post_button([
                                'cus_name'  => auth()->user()->name, // Customer name
                                'cus_email' => auth()->user()->email, // Customer email
                                'cus_phone' => auth()->user()->mobile // Customer Phone
                            ], Crypt::decrypt($secure_amount), '<i class="fa fa-money"></i> Pay via AAMARPAY', 'btn btn-md btn-primary') 
                            !!}
                        </div>
                       
                    </div>
                    @endif

                    @if($checkoutsetting_check->checkout_currency == 1)
                    <div class="tab-pane" id="iyzico_payment_tab">
                      @if(isset($listcheckOutCurrency->payment_method) &&
                      strstr($listcheckOutCurrency->payment_method,'iyzico'))
                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ sprintf('%.2f',Crypt::decrypt($secure_amount)) }}</h3>
                        <hr>

                        <form action="{{ route('iyzcio.pay') }}" method="POST" autocomplete="off">
                          @csrf
                          <div class="row">
                               
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Identity number:</strong>
                                        <input type="text" name="identity_number" class="form-control" placeholder="74300864791" required autocomplete="off">
                                        <small class="text-muted"><i class="fa fa-question-circle"></i> TCKN for Turkish merchants, passport number for foreign merchants</small>
                                    </div>
                                </div>
                            </div>
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <input type="hidden" value="{{ Auth::user()->email }}" name="email">
                          <input type="hidden" name="mobile" value="{{ $address->phone }}">
                          <input type="hidden" name="conversation_id" value="{{  uniqid() }}" />
                          <input type="hidden" name="amount" value="{{ $secure_amount  }}" />
                          <input type="hidden" name="currency" value="{{ session()->get('currency')['id']  }}"/>
                          <input type="hidden" name="mobile" value="{{ $address->phone }}" />
                          <input type="hidden" name="address" value="{{ $address->address }}" />
                          <input type="hidden" name="city" value="{{ $address->getcity['name'] ?? ''}}" />
                          <input type="hidden" name="state" value="{{ $address->getstate['name'] }}" />
                          <input type="hidden" name="country" value="{{ $address->getCountry['name'] }}" />
                          <input type="hidden" name="pincode" value="{{ $address->pin_code }}" />
                          <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                          <button class="btn btn-primary btn-md" title="checkout"
                            type="submit">{{__('staticwords.Pay')}}</button>
                        </form>
                        

                      @else
                        <h4>{{__('Iyzico')}} {{__('staticwords.chknotavbl')}}
                        <b>{{ session()->get('currency')['id'] }}</b>.</h4>
                      @endif
                    </div>
                    @else
                    <div class="tab-pane" id="iyzico_payment_tab">
                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ Crypt::decrypt($secure_amount) }}</h3>
                        <hr>

                        <form action="{{ route('iyzcio.pay') }}" method="POST" autocomplete="off">
                          @csrf
                          <div class="row">
                               
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Identity number:</strong>
                                        <input type="text" name="identity_number" class="form-control" placeholder="74300864791" required autocomplete="off">
                                        <small class="text-muted"><i class="fa fa-question-circle"></i> TCKN for Turkish merchants, passport number for foreign merchants</small>
                                    </div>
                                </div>
                            </div>
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <input type="hidden" value="{{ Auth::user()->email }}" name="email">
                          <input type="hidden" name="mobile" value="{{ $address->phone }}">
                          <input type="hidden" name="conversation_id" value="{{  uniqid() }}" />
                          <input type="hidden" name="amount" value="{{ $secure_amount  }}" />
                          <input type="hidden" name="currency" value="{{ session()->get('currency')['id']  }}"/>
                          <input type="hidden" name="mobile" value="{{ $address->phone }}" />
                          <input type="hidden" name="address" value="{{ $address->address }}" />
                          <input type="hidden" name="city" value="{{ $address->getcity['name'] ?? '' }}" />
                          <input type="hidden" name="state" value="{{ $address->getstate['name'] }}" />
                          <input type="hidden" name="country" value="{{ $address->getCountry['name'] }}" />
                          <input type="hidden" name="pincode" value="{{ $address->pin_code }}" />
                          <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                          <button class="btn btn-primary btn-md" title="checkout"
                            type="submit">{{__('staticwords.Pay')}}</button>
                        </form>
                        
                       
                    </div>
                    @endif

                    @if(config('dpopayment.enable') == 1 && Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())

                      @include("dpopayment::front.tab")

                    @endif 
                    
                    @if(config('bkash.ENABLE') == 1 && Module::has('Bkash') && Module::find('Bkash')->isEnabled())

                      @include("bkash::front.tab")

                    @endif 

                    @foreach(App\ManualPaymentMethod::where('status','1')->get(); as $item)
                      @php
                          $token = str_random(25);
                      @endphp
                      <div class="tab-pane" id="manualpaytab{{ $item->id }}">

                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                        <hr>

                        @if($checkoutsetting_check->checkout_currency == 1)
                          @if(isset($listcheckOutCurrency->payment_method) && strstr($listcheckOutCurrency->payment_method,$item->payment_name))

                          <form action="{{ route('manualpay.checkout',['token' => $token, 'payvia' => $item->payment_name]) }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                              <input type="hidden" name="amount" value="{{ $secure_amount }}">

                              <div class="form-group">
                                <label for="">Attach Purchase Proof <span class="text-red">*</span> </label>
                                <input required title="Please attach a purchase proof !" type="file" class="@error('purchase_proof') is-invalid @enderror form-control" name="purchase_proof"/>
                                
                                @error('purchase_proof')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                              </div>

                              <button type="submit" class="cod-buy-now-button">
                                <span>{{ $item->payment_name }}</span> <i class="fa fa-money"></i>
                              </button>
                            </form>
                            <hr>

                              <div class="row">
                                
                                <div class="col-md-12">
                                  {!! $item->description !!}
                                </div>

                              </div>
                             
                              @if($item->thumbnail != '' && file_exists(public_path().'/images/manual_payment/'.$item->thumbnail) )

                                <div class="card card-1">
                                  <div class="text-center card-body">
                                   
                                  <img width="300px" height="300px" class="img-fluid" src="{{ url('images/manual_payment/'.$item->thumbnail) }}" alt="{{ $item->thumbnail }}">
                                  </div>
                                </div>

                              

                              @endif

                          @else

                          <h4>{{ $item->payment_name }} {{__('staticwords.chknotavbl')}}
                            <b>{{ session()->get('currency')['id'] }}</b>.</h4>

                          @endif
                        @else 

                        <form action="{{ route('manualpay.checkout',['token' => $token, 'payvia' => $item->payment_name]) }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                          <input type="hidden" name="amount" value="{{ $secure_amount }}">

                          <div class="form-group">
                            <label for="">Attach Purchase Proof <span class="text-red">*</span> </label>
                            <input required title="Please attach a purchase proof !" type="file" class="@error('purchase_proof') is-invalid @enderror form-control" name="purchase_proof"/>
                            
                            @error('purchase_proof')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                          </div>

                          <button type="submit" class="cod-buy-now-button">
                            <span>{{ $item->payment_name }}</span> <i class="fa fa-money"></i>
                          </button>
                        </form>
                        <hr>

                          <div class="row">
                            
                            <div class="col-md-12">
                              {!! $item->description !!}
                            </div>
                            
                          </div>
                         
                          @if($item->thumbnail != '' && file_exists(public_path().'/images/manual_payment/'.$item->thumbnail) )

                            <div class="card card-1">
                              <div class="text-center card-body">
                               
                              <img width="300px" height="300px" class="img-fluid" src="{{ url('images/manual_payment/'.$item->thumbnail) }}" alt="{{ $item->thumbnail }}">
                              </div>
                            </div>

                          

                          @endif
                          
                        @endif
                      </div>

                    @endforeach

                    @if(env('BANK_TRANSFER') == 1)

                    @php
                      $bankT = App\BankDetail::first();
                    @endphp

                    @if($checkoutsetting_check->checkout_currency == 1)
                      <div class="tab-pane" id="btpaytab">
                        @if(isset($listcheckOutCurrency->payment_method) &&
                        strstr($listcheckOutCurrency->payment_method,'bankTransfer'))


                        @php
                        $token = str_random(25);
                        @endphp
                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ Crypt::decrypt($secure_amount) }}</h3>
                        <hr>
                        @if(!isset($bankT))
                          <h4>{{ __("staticwords.bankTransferNotAvailable") }}</h4>
                        @else
                          <form action="{{ route('bank.transfer.process',$token) }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                            <input type="hidden" name="amount" value="{{ $secure_amount }}">

                            <div class="form-group">
                              <label for="">Attach Purchase Proof <span class="text-red">*</span> </label>
                              <input required title="Please attach a purchase proof !" type="file" class="@error('purchase_proof') is-invalid @enderror form-control" name="purchase_proof"/>
                              
                              @error('purchase_proof')
                                  <span class="invalid-feedback text-danger" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror

                            </div>

                            <button title="{{__('staticwords.BankTranfer')}}" type="submit" class="cod-buy-now-button">
                              <span>{{__('staticwords.BankTranfer')}}</span> <i class="fa fa-money"></i>
                            </button>
                          </form>
                        @endif
                        <hr>
                        <p class="text-muted"><i class="fa fa-money"></i> {{__('staticwords.makebanktransfer')}}</p>

                        <div class="card card-1">
                          <div class="card-body">
                            <h4>{{__('staticwords.followingBankT')}}</h4>
                          

                            @if(isset($bankT))
                            <p>{{__('staticwords.AccountName')}}: {{ $bankT->account }}</p>
                            <p>{{ __('A/c No') }}: {{ $bankT->account }}</p>
                            <p>{{__('staticwords.BankName')}}: {{ $bankT->bankname }}</p>
                            <p>{{ __('IFSC Code') }}: {{ $bankT->ifsc }}</p>
                            @if($bankT->swift_code != '')
                              <p>{{ __('SWIFT Code') }}: {{ $bankT->swift_code }}</p>
                            @endif
                            @else
                            <p>{{__('staticwords.bankdetailerror')}}</p>
                            @endif

                          </div>
                        </div>

                        @else
                        <h4>{{__('staticwords.BankTranfer')}} {{__('staticwords.chknotavbl')}}
                          <b>{{ session()->get('currency')['id'] }}</b>.</h4>
                        @endif
                      </div>
                    @else
                      <div class="tab-pane" id="btpaytab">

                        @php
                        $token = str_random(25);
                        @endphp
                        <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                          {{ sprintf("%.2f",Crypt::decrypt($secure_amount)) }}</h3>
                        <hr>
                        @if(!isset($bankT))
                          <h4>{{ __("staticwords.bankTransferNotAvailable") }}</h4>
                        @else
                          <form action="{{ route('bank.transfer.process',$token) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                            <input type="hidden" name="amount" value="{{ $secure_amount }}">

                            <div class="form-group">
                              <label for="">Attach Purchase Proof <span class="text-red">*</span> </label>
                              <input required title="Please attach a purchase proof !" type="file" class="@error('purchase_proof') is-invalid @enderror form-control" name="purchase_proof"/>
                              
                              @error('purchase_proof')
                                  <span class="invalid-feedback text-danger" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror

                            </div>

                            <button title="{{__('staticwords.BankTranfer')}}" type="submit" class="cod-buy-now-button">
                              <span>{{__('staticwords.BankTranfer')}}</span> <i class="fa fa-money"></i>
                            </button>
                          </form>
                        @endif
                        <hr>
                        <p class="text-muted"><i class="fa fa-money"></i> {{__('staticwords.makebanktransfer')}}</p>

                        <div class="card card-1">
                          <div class="card-body">
                            <h4>{{__('staticwords.followingBankT')}}</h4>
                            
                            @if(isset($bankT))
                            <p>{{__('staticwords.AccountName')}}: {{ $bankT->account }}</p>
                            <p>{{ __('A/c No') }}: {{ $bankT->account }}</p>
                            <p>{{__('staticwords.BankName')}}: {{ $bankT->bankname }}</p>
                            <p>{{ __('IFSC Code') }}: {{ $bankT->ifsc }}</p>
                            @if($bankT->swift_code != '')
                              <p>{{ __('SWIFT Code') }}: {{ $bankT->swift_code }}</p>
                            @endif
                            @else
                            <p>{{__('staticwords.bankdetailerror')}}</p>
                            @endif

                          </div>
                        </div>

                      </div>
                    @endif

                    @endif

                    @if($config->razorpay == '1')
                      @if($checkoutsetting_check->checkout_currency == 1)

                        <div class="tab-pane" id="razorpaytab">
                          @if(isset($listcheckOutCurrency->payment_method) &&
                          strstr($listcheckOutCurrency->payment_method,'Razorpay'))
                          <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ Crypt::decrypt($secure_amount) }}</h3>
                          <hr>
                          <form id="rpayform" action="{{ route('rpay') }}" method="POST">
                            @php
                            $order = uniqid();
                            Session::put('order_id',$order);
                            @endphp
                            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZOR_PAY_KEY') }}"
                              data-amount="{{ (round(Crypt::decrypt($secure_amount),2))*100 }}"
                              data-buttontext="Pay {{ Crypt::decrypt($secure_amount) }} INR" data-name="{{ $title }}"
                              data-description="Payment For Order {{ Session::get('order_id') }}"
                              data-image="{{url('images/genral/'.$front_logo)}}" data-prefill.name="{{ $address->name }}"
                              data-prefill.email="{{ $address->email }}" data-theme.color="#157ED2">
                            </script>
                            <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                          </form>

                          @else
                          <h4>{{ __('RazorPay') }} {{__('staticwords.chknotavbl')}}
                            <b>{{ session()->get('currency')['id'] }}</b>.</h4>
                          @endif

                        </div>
                      @else
                        <div class="tab-pane" id="razorpaytab">

                          <h3>{{__('staticwords.Pay')}} <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ Crypt::decrypt($secure_amount) }}</h3>
                          <hr>
                          <form id="rpayform" action="{{ route('rpay') }}" method="POST">
                            @php
                            $order = uniqid();
                            Session::put('order_id',$order);
                            @endphp
                            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZOR_PAY_KEY') }}"
                              data-amount="{{ (round(Crypt::decrypt($secure_amount),2))*100 }}"
                              data-buttontext="Pay {{ Crypt::decrypt($secure_amount) }} INR" data-name="{{ $title }}"
                              data-description="Payment For Order {{ Session::get('order_id') }}"
                              data-image="{{url('images/genral/'.$front_logo)}}" data-prefill.name="{{ $address->name }}"
                              data-prefill.email="{{ $address->email }}" data-theme.color="#157ED2">
                            </script>
                            <input type="hidden" name="actualtotal" value="{{ $un_sec }}">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                          </form>



                        </div>
                      @endif
                    @endif
                  </div>



                </div>
              </div>

              <div class="clearfix"></div>
           </div>
          </div>
          <!-- checkout-step-04  -->



        </div><!-- /.checkout-steps -->
      </div>

      <div class="col-xl-4 col-md-12 col-sm-12">
        <div class="shopping-cart shopping-cart-widget" data-sticky data-sticky-for="992" data-margin-top="20">
          <h2 class="heading-title">{{__('staticwords.PaymentDetails')}}</h2>
          <div class="col-sm-12 cart-shopping-total">
            <table class="table">
              <thead>
                <tr>
                  <th>
                    <div class="cart-sub-total totals-value" id="cart-total">
                      <div class="row">
                        <div class="text-left col-md-4 col-4">{{__('staticwords.Subtotal')}}</div>
                        <div class="col-md-8 col-8">
                          <span class="" id="show-total">

                            <?php 
                                    if(Auth::check()){
                                      foreach(auth()->user()->cart as $key=>$val)
                                        {
                                           if ($val->product->tax_r != NULL && $val->product->tax == 0) {
                                              
                                              if ($val->ori_offer_price != 0) {
                                                  //get per product tax amount
                                                   $p=100;
                                                   $taxrate_db = $val->product->tax_r;
                                                   $vp = $p+$taxrate_db;
                                                   $taxAmnt = $val->product->offer_price/$vp*$taxrate_db;
                                                   $taxAmnt = sprintf("%.2f",$taxAmnt);
                                                   $price = ($val->ori_offer_price-$taxAmnt)*$val->qty;

                                              }else{

                                                   $p=100;
                                                   $taxrate_db = $val->product->tax_r;
                                                   $vp = $p+$taxrate_db;
                                                   $taxAmnt = $val->product->price/$vp*$taxrate_db;

                                                  $taxAmnt = sprintf("%.2f",$taxAmnt);

                                                  $price = ($val->ori_price-$taxAmnt)*$val->qty;
                                              }

                                           }else{

                                              if($val->semi_total != 0){

                                                $price = $val->semi_total;

                                              }else{

                                                $price = $val->price_total;

                                              }
                                           }
  
                                            $total = $total+$price;
                                           
                                            
                                        } 
                                    }
                                  ?>


                            <i
                              class="{{session()->get('currency')['value']}}"></i>{{ sprintf("%.2f",$total*$conversion_rate) }}
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="cart-sub-total totals-value" id="cart-total">
                      <div class="row">
                        <div class="text-left col-md-4 col-4">Tax</div>
                        <div class="col-md-8 col-8">
                          <span class="" id="show-total">

                            <i
                              class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$total_tax_amount,2)}}

                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="cart-sub-total">
                      <div class="row">
                        <div class="text-left col-lg-4 col-4">{{__('staticwords.Shipping')}}</div>
                        <div class="col-lg-8 col-8">
                          <span class="" id="shipping">

                            @if($total_shipping !=0)



                            <i class="{{session()->get('currency')['value']}}"></i>
                            <span id="totalshipping">
                              {{ number_format((float)$total_shipping*$conversion_rate , 2, '.', '')}}
                            </span>
                            @else
                            {{__('staticwords.Free')}}
                            @endif
                          </span>
                        </div>
                      </div>
                    </div>
                    @if(Auth::check() && App\Cart::isCoupanApplied() == 1)
                      <div class="cart-sub-total">
                        <div class="row">
                          <div class="col-md-6 col-xs-6 text-left">{{ __('staticwords.Discount') }}</div>
                          <div class="col-md-6 col-xs-6">
                            - <i class="{{session()->get('currency')['value']}}"></i> <span class="" id="discountedam">{{sprintf("%.2f",App\Cart::getDiscount()*$conversion_rate,2)}}</span>
                          </div>
                        </div>
                      </div>
                    @endif
                    
                    @if($total_gift_pkg_charge != 0)
                    <div class="cart-sub-total totals-value" id="cart-total">
                      <div class="row">
                        <div class="text-left col-md-4 col-7">{{__('staticwords.TotalGiftCharge')}}:</div>
                        <div class="col-md-8 col-5">
                          <span class="" id="show-total">
                            <i
                              class="{{session()->get('currency')['value']}}"></i>{{  $total_gift_pkg_charge }}
                          </span>
                        </div>
                      </div>
                    </div>
                    @endif

                    <div class="cart-sub-total totals-value" id="cart-total">
                      <div class="row">
                        <div class="text-left col-md-4 col-7">{{__('staticwords.HandlingCharge')}}:</div>
                        <div class="col-md-8 col-5">
                          <span class="" id="show-total">
                            <i
                              class="{{session()->get('currency')['value']}}"></i>{{  sprintf("%.2f",$handlingcharge) }}*
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="cart-grand-total">
                      <div class="row">
                        <div class="text-left col-lg-4 col-4">{{__('staticwords.Total')}}</div>
                        <div class="col-lg-8 col-8">

                          @php
                            $secure_pay =0;
                          @endphp

                          <span class="" id="gtotal">
                            @php

                            $total = sprintf("%.2f",$total*$conversion_rate);
                            $totals = sprintf("%.2f",$total_shipping*$conversion_rate);
                            $secure_pay = sprintf("%.2f",$totals + $total + $total_tax_amount);

                            

                            if(App\Cart::isCoupanApplied() == '1'){
                              $secure_pay = sprintf("%.2f",$secure_pay - App\Cart::getDiscount()*$conversion_rate);
                            }

                            $secure_pay = sprintf("%.2f",$secure_pay + $handlingcharge + $total_gift_pkg_charge);

                            


                            @endphp
                            <i class="{{session()->get('currency')['value']}}"></i>
                            <span id="grandtotal">
                              {{ $secure_pay }}
                            </span>
                          </span>

                          @php
                            session()->put('payamount',sprintf("%.2f",$secure_pay));
                          @endphp

                        </div>
                      </div>
                    </div>
                    <small>*{{__('staticwords.HandlingChargeNotApply')}}</small>
                  </th>
                </tr>
              </thead><!-- /thead -->
              <tbody>
                <tr>
                  <td>

                  </td>
                </tr>
              </tbody><!-- /tbody -->
            </table><!-- /table -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


{{-- Address Modal start --}}

<div class="modal fade" id="mngaddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{__('staticwords.AddNewAddress')}}</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('address.store3') }}" role="form" method="POST">
          @csrf
          <div class="form-group">
            <label>{{__('staticwords.Name')}}:</label>
            <input type="text" placeholder="{{ __('Enter name') }}" name="name" class="form-control">
          </div>

          <div class="form-group">
            <label>{{__('staticwords.PhoneNo')}}:</label>
            <input pattern="[0-9]+" type="text" name="phone" placeholder="{{ __('Enter phone no') }}"
              class="form-control">
          </div>

          <div class="form-group">
            <label>{{__('staticwords.Email')}}:</label>
            <input type="email" name="email" placeholder="{{ __('Enter email') }}" class="form-control">
          </div>

          

          <label>{{__('staticwords.Address')}}: </label>
          <textarea name="address" id="address" cols="20" rows="5" class="form-control"></textarea>
          @if($pincodesystem == 1)
          <br>
          <label>{{__('staticwords.Pincode')}}: </label>
          <input pattern="[0-9]+" placeholder="{{ __('Enter pin code') }}" type="text" id="pincode"
            class="z-index99 form-control" name="pin_code">
          <br>
          @endif

          <div class="row">
            <div class="col-md-4">

              <div class="form-group">
                <label>{{__('staticwords.Country')}} <small class="required">*</small></label>
                <select required="" name="country_id" class="form-control" id="country_id">
                  <option value="">{{ __('staticwords.PleaseChooseCountry') }}</option>
                  @foreach($all_country as $c)
                     
                    <option value="{{$c->id}}" >
                      {{$c->nicename}}
                    </option>

                  @endforeach
                </select>
              </div>

            </div>

            <div class="col-md-4">
              <label>{{__('staticwords.State')}} <small class="required"></small></label>
              <select name="state_id" class="form-control" id="upload_id">

                <option value="0">{{__('staticwords.PleaseChooseState')}}</option>

              </select>
            </div>

            <div class="col-md-4">
              <label>{{__('staticwords.City')}} <small class="required">*</small></label>

              <select name="city_id" id="city_id" class="form-control">
                <option value="0">{{__('staticwords.PleaseChooseCity')}}</option>



              </select>

              <br>
              <label class="pull-left">
                <input type="checkbox" name="setdef">
                {{__('staticwords.SetDefaultAddress')}}
              </label>
            </div>

            <div class="col-md-12">
              <button class="btn btn-primary"><i class="fa fa-plus"></i> {{__('staticwords.ADD')}}</button>
            </div>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>

{{-- Address Modal End --}}

@endsection

@section('script')
<script src="{{ url('front/vendor/js/card.js') }}"></script>
<script>
  var baseUrl = "<?= url('/') ?>";
</script>
<script>
  var carttotal = "<?= $total; ?>";
</script>
<script src="{{ url('js/orderpincode.js') }}"></script>
 <script src="{{ url('js/ajaxlocationlist.js') }}"></script>
<script src="https://js.braintreegateway.com/web/dropin/1.20.0/js/dropin.min.js"></script>

<script>
  var client_token = null;
  $(function () {
    $('.bt-btn').on('click', function () {
      $('.bt-btn').addClass('load');
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "GET",
        url: "{{ route('bttoken') }}",
        success: function (t) {
          if (t.client != null) {
            client_token = t.client;
            btform(client_token);
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
          $('.bt-btn').removeClass('load');
          alert('Payment error. Please try again later.');
        }
      });
    });
  });

  function btform(token) {
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
      } else {
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

  $('.gift_pkg_charge').on('change',function(){

    var variant = $(this).data('variant');

     if($(this).is(":checked")){
        
        var charge  = $(this).data('gift_charge');

        axios.post('{{ route("apply.giftcharge") }}',{
          variant : variant,
          charge  : charge
        }).then(res => {
          console.log(res.data);
          if(res.data == 'applied'){

            location.reload();

          }
        }).catch(err => {
            console.log(err);
        });

     }else{
        axios.post('{{ route("reset.giftcharge") }}',{
          variant : variant,
        }).then(res => {

          if(res.data == 'removed'){

            location.reload();

          }

        }).catch(err => {
            console.log(err);
        });
     }



  });
</script>
@if(config('bkash.ENABLE') == 1 && Module::has('Bkash') && Module::find('Bkash')->isEnabled())
  
    @include("bkash::front.bkashscript")
 
@endif
@endsection