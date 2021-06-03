@extends("front/layout.master")
@section('title','Shipping Address - Checkout |')
@section("body")


<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container-fluid">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">{{ __('staticwords.Home') }}</a></li>
				<li>{{ __('staticwords.Checkout') }}</li>
        <li class='active'>{{ __('staticwords.ShippingAddress') }}</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->


<div class="body-content">
	<div class="container-fluid">
		<div class="row checkout-box" data-sticky-container>
			<div class="col-md-8 col-sm-12">
				<div class="panel-group checkout-steps" id="accordion">
						<!-- checkout-step-01  -->
            
              <!-- checkout-step-01  -->
              <div class="panel panel-default checkout-step-01">

              	<!-- panel-heading -->
              		<div class="panel-heading">
                  	<h4 class="unicase-checkout-title">
              	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
              	          @guest <span>1</span> {{ __('staticwords.Login') }} @else <span class="fa fa-check"></span> {{ __('staticwords.LoggedIn') }} @endguest
              	        </a>
              	     </h4>
                  </div>
                  <!-- panel-heading -->


              	<div id="collapseOne" class="panel-collapse collapse show">
	
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
						        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseTwo">
						          <span>2</span>
                      
                      {{ __('staticwords.ShippingInformation') }}
						          
						        </a>
						      </h4>
						    </div>
						    <div id="collapseTwo" class="panel-collapse collapse @auth show @endauth">
						      <div class="panel-body">
						      	<button data-target="#mngaddress"  data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus"></i> {{ __('staticwords.AddNewAddress') }}</button>
						      	<hr>
						    <form action="{{route('choose.address')}}" method="post">
						    	@csrf
						    	<input type="hidden" name="total" value="{{$total}}">
						      	<div class="row">
						    	
								 @if(count($addresses))
                 @foreach($addresses as $address)
                  

                    
                  <div class="margin-top8 col-md-6 col-sm-6">
                    <div class="address address-1 box">
                        <div class="user-header">

                            <h4><label><input @if($address->defaddress == 1) {{ 'checked' }} @endif required type="radio" name="seladd" value="{{ $address->id }}"/> <b>{{$address->name}}, {{ $address->phone }}</b></label></h4>

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
                 @else
                  <h3>{{ __('staticwords.Noaddress') }}</h3>
                 @endif

                 

								<input type="hidden" name="shipping" value="{{ $shippingcharge }}">
								 
								 </div>
								<hr>
								@if(Auth::user()->addresses->count()>0)
								<button name="step2" type="submit" class="btn btn-primary">{{ __('staticwords.DeliverHere') }}</button>
                @endif
								</form>

						      </div>
						    </div>
					  	</div>
					  	<!-- checkout-step-02  -->

              <!-- checkout-step-03  -->
              <div class="panel panel-default checkout-step-02">
                <div class="panel-heading">
                  <h4 class="unicase-checkout-title">
                    <a class="collapsed">
                      <span>3</span>{{ __('staticwords.BillingInformation') }}
                    </a>
                  </h4>
                </div>
                
              </div>
              <!-- checkout-step-03  -->



						<!-- checkout-step-04 -->
					  	<div class="panel panel-default checkout-step-03">
						    <div class="panel-heading">
						      <h4 class="unicase-checkout-title">
						        <a class="collapsed">
						       		<span>4</span>{{ __('staticwords.OrderReview') }}
						        </a>
						      </h4>
						    </div>
						    
					  	</div>
					  	<!-- checkout-step-04  -->

						<!-- checkout-step-05 -->
					    <div class="panel panel-default checkout-step-04">
						    <div class="panel-heading">
						      <h4 class="unicase-checkout-title">
						        <a class="collapsed">
						        	<span>5</span> {{ __('staticwords.Payment') }}
						        </a>
						      </h4>
						    </div>
						    
						  </div>
						<!-- checkout-step-04  -->

					
					  	
					</div><!-- /.checkout-steps -->
			</div>

			<div class="col-md-4 col-sm-12">
        <div>
        <div class="shopping-cart shopping-cart-widget" data-sticky data-sticky-for="992" data-margin-top="10">
          <h2 class="heading-title">{{ __('staticwords.PaymentDetails') }}</h2>
          <div class="col-sm-12 cart-shopping-total">
            <table class="table">
              <thead>
                <tr>
                  <th>
                    <div class="cart-sub-total totals-value" id="cart-total">
                      <div class="row">
                        <div class="text-left col-md-4 col-xs-4">{{ __('staticwords.Subtotal') }}</div>
                        <div class="col-md-8 col-xs-8">
                          <span class="text-right" id="show-total">
                              <i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$total*$conversion_rate,2)}}
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="cart-sub-total">
                      <div class="row">
                        <div class="text-left col-md-4 col-xs-4">{{ __('staticwords.Shipping') }}</div>
                        <div class="col-md-8 col-xs-8">
                            @if($shippingcharge !=0)
                              <i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$shippingcharge*$conversion_rate,2)}}
                            @else
                             {{ __('staticwords.Free') }}
                            @endif
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
                   
                    <div class="cart-grand-total">
                      <div class="row">
                        <div class="text-left col-md-4 col-xs-4">{{ __('staticwords.Total') }}</div>
                        <div class="col-md-8 col-xs-8">
                          @if(!App\Cart::isCoupanApplied() == 1)
                              <span class="text-right" id="gtotal"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",$grandtotal*$conversion_rate,2)}}</span>
                          @else
                              <span class="text-right" id="gtotal"><i class="{{session()->get('currency')['value']}}"></i>{{sprintf("%.2f",($grandtotal-App\Cart::getDiscount())*$conversion_rate,2)}}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </th>
                </tr>
              </thead><!-- /thead -->
              <tbody>
                  <tr>
                    <td>
                      <div class="cart-checkout-btn pull-right">
                       
                          <input type="hidden" name="shipping" value="{{ $shippingcharge }}">
                         
                      </div>
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
</div>

{{-- Address Modal start --}}
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="mngaddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ __('staticwords.AddNewAddress') }}</h4>
      </div>
      <div class="modal-body">
        @php
          $ifadd = count(Auth::user()->addresses);
        @endphp
        <form action="{{ route('address.store2') }}" role="form" method="POST">
           @csrf
          <div class="form-group">
            <label>{{ __('staticwords.Name') }}: <span class="required">*</span></label>
            <input required="" type="text" placeholder="Enter name" name="name" @if($ifadd<1) value="{{ Auth::user()->name }}" @else value="" @endif class="form-control">
          </div>

          <div class="form-group">
            <label>{{ __('staticwords.PhoneNo') }}: <span class="required">*</span></label>
            <input pattern="[0-9]+" required="" type="text" name="phone" @if($ifadd<1) value="{{ Auth::user()->mobile }}" @else value="" @endif placeholder="Enter phone no" class="form-control">
          </div>

           <div class="form-group">
            <label>{{ __('staticwords.Email') }}: <span class="required">*</span></label>
            <input required="" @if($ifadd<1) value="{{ Auth::user()->email }}" @else value="" @endif type="email" name="email" placeholder="Enter email" class="form-control">
          </div>
          
         

          <label>{{ __('staticwords.Address') }}: <span class="required">*</span></label>
          <textarea required="" name="address" id="address" cols="20" rows="5" class="form-control"></textarea>
          <br>
           @if ($pincodesystem == 1)
            <label>{{ __('staticwords.Pincode') }}: <span class="required">*</span></label>
            <input pattern="[0-9]+" required="" placeholder="{{ __('Enter pin code') }}" type="text" id="pincode" class="form-control z-index99" name="pin_code">
            <br>
          @endif

          <div class="row">
            <div class="col-md-4">

                <div class="form-group">
                   <label>{{ __('staticwords.Country') }} <small class="required">*</small></label>
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
              <label>{{ __('staticwords.State') }} <small class="required"></small></label>
              <select required="" name="state_id" class="form-control" id="upload_id" >
              
                  <option value="">{{ __('staticwords.PleaseChooseState') }}</option>
                 
              </select>
            </div>
            
            <div class="col-md-4">
               <label>{{ __('staticwords.City') }} </label>
                                      
              <select required="" name="city_id" id="city_id" class="form-control">
                <option value="">{{ __('staticwords.PleaseChooseCity') }}</option>

                
              </select>
              <br>
            <label class="pull-left">
              <input type="checkbox" name="setdef">
                {{ __('staticwords.SetDefaultAddress') }}
            </label>
            </div>

            <input type="hidden" name="shipping" value="{{ $shippingcharge }}">

            <div class="col-md-12">
              <button class="btn btn-primary"><i class="fa fa-plus"></i> {{ __('staticwords.ADD') }}</button>
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
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/orderpincode.js') }}"></script>
  <script>var baseUrl = "<?= url('/') ?>";</script>
 <script src="{{ url('js/ajaxlocationlist.js') }}"></script>

@endsection