@extends("front/layout.master")
@section('title',__('staticwords.MyOrders').' | ')
@section("body")

<div class="container-fluid">

  <div class="row">
    <div class="col-md-12 col-xl-3">
      @include('user.sidebar')
    </div>







    <div class="col-lg-9 my-order-one main-content">

      <div class="bg-white2">

        <h5 class="user_m2">{{ __('staticwords.MyOrders') }} ({{ count($orders) }})</h5>
        <hr>
        @if(count($orders)>0)
        @foreach($orders as $order)
        @php
        if($order->discount != 0){
        if($order->distype == 'category'){

        $findCoupon = App\Coupan::where('code','=',$order->coupon)->first();
        $catarray = collect();
        foreach ($order->invoices as $key => $os) {

        if($os->variant->products->category_id == $findCoupon->cat_id){

        $catarray->push($os);

        }

        }

        }
        }
        @endphp
        <div class="panel panel-default">

          <div class="panel-heading">
            <a href="{{  route('user.view.order',$order->order_id) }}"
              title="Order {{ $ord_postfix }}{{ $order->order_id }}" href="#" class="btn btn-primary">
              {{ $ord_postfix }}{{ $order->order_id }}
            </a>

            <span class="pull-right">
              <b>{{ __('Transcation ID') }}:</b> {{ $order->transaction_id }}
              <br>
              <b>{{ __('Payment Method') }}:</b> {{ $order->payment_method }}
            </span>
          </div>

          <div class="panel-body">
            @php
            $x = count($order->invoices);
            if(isset($order->invoices[0])){
            $firstarray = array($order->invoices[0]);
            }

            $morearray = array();
            $counter = 0;

            foreach ($order->invoices as $value) {
            if($counter++ >0 ){
            array_push($morearray, $value);
            }
            }

            $morecount = count($morearray);
            @endphp
            @if(isset($firstarray))
            @foreach($firstarray as $o)



            <div class="row rowbox no-pad">
              <div class="col-lg-1 col-md-2 col-sm-3 col-4 ">
                <center>
                  @if(isset($o->variant->variantimages) &&
                  file_exists(public_path().'/variantimages/thumbnails/'.$o->variant->variantimages->main_image))
                  <img class="pro-img2"
                    src="{{url('variantimages/thumbnails/'.$o->variant->variantimages->main_image)}}"
                    alt="product name" />
                  @else
                  <img class="pro-img2" src="{{ Avatar::create($o->variant->products->name)->toBase64() }}"
                    alt="product name" />
                  @endif
                </center>
              </div>

              <div class="col-lg-4 col-md-3 col-sm-3 col-7 click-view-one">
                <a target="_blank" title="Click to view"
                  href="{{ $o->variant->products->getURL($o->variant) }}"><b>{{substr($o->variant->products->name, 0, 30)}}{{strlen($o->variant->products->name)>30 ? '...' : ""}}</b>

                  <small>
                    @php
                    $i=0;
                    @endphp
                    (@foreach($o->variant->main_attr_value as $key=> $orivars)
                    <?php $i++; ?>

                    @php
                    $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
                    $getvarvalue = App\ProductValues::where('id',$orivars)->first();
                    @endphp

                    @if($i < count($o->variant->main_attr_value)) @if(strcasecmp($getvarvalue->unit_value,
                      $getvarvalue->values) != 0 &&
                      $getvarvalue->unit_value != null)
                      @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour"
                      || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                      {{ $getvarvalue->values }},
                      @else
                      {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }},
                      @endif
                      @else
                      {{ $getvarvalue->values }},
                      @endif
                      @else
                      @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value
                      != null)
                      @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour"
                      || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                      {{ $getvarvalue->values }}
                      @else
                      {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }}
                      @endif
                      @else
                      {{ $getvarvalue->values }}
                      @endif
                      @endif
                      @endforeach
                      )

                  </small>
                </a>
                <br>
                <small><b>{{ __('staticwords.SoldBy') }}:</b> {{$o->variant->products->store->name}}</small>
                <br>
                <small><b>{{ __('Qty') }}:</b> {{$o->qty}}</small>
                <br>
                @if($o->status == 'delivered')
                <span class="badge badge-pill font-weight-normal badge-success">{{ ucfirst($o->status) }}</span>
                @elseif($o->status == 'processed')
                <span class="badge badge-pill font-weight-normal badge-info">{{ ucfirst($o->status) }}</span>
                @elseif($o->status == 'shipped')
                <span class="badge badge-pill font-weight-normal badge-primary">{{ ucfirst($o->status) }}</span>
                @elseif($o->status == 'return_request')
                <span class="badge badge-pill font-weight-normal badge-warning">
                  {{ __('Return Request') }}
                </span>
                @elseif($o->status == 'returned')
                <span class="badge badge-pill font-weight-normal badge-danger">
                  {{ __('Returned') }}
                </span>
                @elseif($o->status == 'refunded')
                <span class="badge badge-pill font-weight-normal badge-success">
                  {{ __('Refunded') }}
                </span>
                @elseif($o->status == 'cancel_request')
                <span class="badge badge-pill font-weight-normal badge-warning">
                  {{ __('Cancelation Request') }}
                </span>
                @elseif($o->status == 'canceled')
                <span class="badge badge-pill font-weight-normal badge-danger">
                  {{ __('Canceled') }}
                </span>
                @elseif($o->status == 'Refund Pending')
                <span class="badge badge-pill font-weight-normal badge-success">
                  {{ __('Refund in progress') }}
                </span>
                @elseif($o->status == 'ret_ref')
                <span class="badge badge-pill font-weight-normal badge-primary">
                  {{ __('Returned & Refunded') }}
                </span>
                @else
                <span class="badge badge-pill font-weight-normal badge-secondary">{{ ucfirst($o->status) }}</span>
                @endif
              </div>

              <div class="m-8 col-md-4 offset-sm-2 col-sm-3 offset-2 col-6 m-8-no applied-block">
                <b>

                  <i class="{{ $order->paid_in }}"></i>
                  @if($o->order->discount !=0)

                  @if($o->order->distype == 'product')


                  @if($o->discount != 0)
                  {{ round(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->order->discount,2) }}
                  <small class="couponbox"><b>{{ $order->coupon }}</b> {{ __('applied') }}</small>
                  @else

                  {{ round($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}

                  @endif



                  @elseif($o->order->distype == 'category')

                  @if($o->discount != 0)
                  {{ round(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                  <br>
                  <small class="couponbox"><b>{{ $order->coupon }}</b> {{ __('applied') }}</small>
                  @else
                  {{ round($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                  @endif

                  @elseif($o->order->distype == 'cart')

                  {{ round(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                  <small class="couponbox"><b>{{ $order->coupon }}</b> {{ __('applied') }}</small>
                  @endif

                  @else
                  {{ round(($o->qty*$o->price)+$o->tax_amount+$o->shipping,2) }}
                  @endif

                </b>
                <br>
                <small>({{ __('Incl. of Tax & Shipping') }})</small>
                <br>

              </div>


            </div>


            @endforeach
            @endif

            @if($order->invoices->count()>1)
            <div align="center">
              <a class="cursor-pointer" title="{{ __('View') }} {{ $morecount }} {{ __('more order') }}"
                id="moretext{{ $firstarray[0]->order->order_id }}"
                onclick="showMore('{{ $firstarray[0]->order->order_id }}')">+{{ $morecount }} {{ __('More') }}...</a>

            </div>



            <div class="display-none" id="expandThis{{ $firstarray[0]->order->order_id }}">
              @foreach($morearray as $o)


              <br>
              <div class="rowbox row no-pad">
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                  @if(isset($o->variant->variantimages) &&
                  file_exists(public_path().'/variantimages/thumbnails/'.$o->variant->variantimages->main_image))
                  <img class="pro-img2"
                    src="{{url('variantimages/thumbnails/'.$o->variant->variantimages->main_image)}}"
                    alt="product name" />
                  @else
                  <img class="pro-img2" src="{{ Avatar::create($o->variant->products->name)->toBase64() }}"
                    alt="product name" />
                  @endif
                </div>

                <div class="col-lg-4 col-md-3 col-sm-3 col-7 click-view-one">
                  <a target="_blank" title="Click to view"
                    href="{{ $o->variant->products->getURL($o->variant) }}"><b>{{substr($o->variant->products->name, 0, 30)}}{{strlen($o->variant->products->name)>30 ? '...' : ""}}</b>

                    <small>
                      @php
                      $i=0;
                      @endphp
                      (@foreach($o->variant->main_attr_value as $key=> $orivars)
                      <?php $i++; ?>

                      @php
                      $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
                      $getvarvalue = App\ProductValues::where('id',$orivars)->first();
                      @endphp

                      @if($i < count($o->variant->main_attr_value)) @if(strcasecmp($getvarvalue->unit_value,
                        $getvarvalue->values) != 0 &&
                        $getvarvalue->unit_value != null)
                        @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name ==
                        "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name
                        == "colour")
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
                        @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name ==
                        "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name
                        == "colour")
                        {{ $getvarvalue->values }}
                        @else
                        {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }}
                        @endif
                        @else
                        {{ $getvarvalue->values }}
                        @endif
                        @endif
                        @endforeach
                        )

                    </small>
                  </a>
                  <br>
                  <small><b>{{ __('staticwords.SoldBy') }}:</b> {{$o->variant->products->store->name}}</small>
                  <br>
                  <small><b>{{ __('Qty') }}:</b> {{$o->qty}}</small>
                  <br>
                  @if($o->status == 'delivered')
                  <span class="badge badge-pill font-weight-normal badge-success">{{ ucfirst($o->status) }}</span>
                  @elseif($o->status == 'processed')
                  <span class="badge badge-pill font-weight-normal badge-info">{{ ucfirst($o->status) }}</span>
                  @elseif($o->status == 'shipped')
                  <span class="badge badge-pill font-weight-normal badge-primary">{{ ucfirst($o->status) }}</span>
                  @elseif($o->status == 'return_request')
                  <span class="badge badge-pill font-weight-normal badge-warning">Return Request</span>
                  @elseif($o->status == 'returned')
                  <span class="badge badge-pill font-weight-normal badge-danger">Returned</span>
                  @elseif($o->status == 'refunded')
                  <span class="badge badge-pill font-weight-normal badge-success">Refunded</span>
                  @elseif($o->status == 'cancel_request')
                  <span class="badge badge-pill font-weight-normal badge-warning">Cancelation Request</span>
                  @elseif($o->status == 'canceled')
                  <span class="badge badge-pill font-weight-normal badge-danger">Canceled</span>
                  @elseif($o->status == 'Refund Pending')
                  <span class="badge badge-pill font-weight-normal badge-success">Refund in progress</span>
                  @elseif($o->status == 'ret_ref')
                  <span class="badge badge-pill font-weight-normal badge-primary">Returned & Refunded</span>
                  @else
                  <span class="badge badge-pill font-weight-normal badge-secondary">{{ ucfirst($o->status) }}</span>
                  @endif
                </div>

                <div class="m-8 col-md-4 offset-sm-2 col-sm-3 offset-2 col-6 m-8-no applied-block">
                  <b><i class="{{ $order->paid_in }}"></i>
                    @if($o->order->discount !=0)

                    @if($o->order->distype == 'product')

                    @if($o->discount != 0)

                    {{ round(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                    <small class="couponbox"><b>{{ $order->coupon }}</b> {{ __('applied') }}</small>

                    @else

                    {{ round($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}

                    @endif



                    @elseif($o->order->distype == 'category')

                    @if($o->discount != 0)

                    {{ round(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                    <br>
                    <small class="couponbox"><b>{{ $order->coupon }}</b> {{ __('applied') }}</small>
                    @else
                    {{ round($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                    @endif

                    @elseif($o->order->distype == 'cart')

                    {{ round(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                    <small class="couponbox"><b>{{ $order->coupon }}</b> {{ __('applied') }}</small>
                    @endif

                    @else
                    {{ round(($o->qty*$o->price)+$o->tax_amount+$o->shipping,2) }}
                    @endif </b>
                  <br>
                  <small>({{ __('Incl. of Tax & Shipping') }})</small>

                </div>

              </div>
              @endforeach
            </div>

            <div align="center">
              <a class="display-none font-weight500" title="{{ __('Show Less') }}"
                onclick="showLess('{{ $firstarray[0]->order->order_id }}')"
                id="showless{{ $firstarray[0]->order->order_id }}">
                {{ __('Show Less') }}
              </a>
              <p></p>
            </div>

            @endif

          </div>

          <div class="panel-footer">
            <b>{{ __('Order date') }}:</b> {{ date('d-m-Y',strtotime($order->created_at)) }}
            <span class="pull-right">
              <b>{{ __('Total') }} :</b>
              <i class="{{ $order->paid_in }}"></i>

              {{ number_format((float)$order->order_total - $order->gift_charge , 2, '.', '')}}
              |
              <b>{{ __('Gift Pkg. Charges') }}:</b>
              <i class="{{ $order->paid_in }}"></i>{{ $order->gift_charge }} | 
              <b>{{ __('Handing Charges') }}:</b>
              <i class="{{ $order->paid_in }}"></i>{{ $order->handlingcharge }} |
              <b>{{ __('Order Total') }}:</b>

              <i class="{{ $order->paid_in }}"></i>
              {{ number_format((float)$order->order_total+$order->handlingcharge, 2, '.', '')}}

            </span>


          </div>

        </div>

        @endforeach

        <div class="mx-auto width200px">
          {{$orders->links()}}
        </div>

        @else
        <h3>{{ __('staticwords.ShoppingText') }}</h3>
        <div align="center">
          <img title="{{ __('staticwords.ShoppingText') }}" src="{{ url('images/noorder.jpg') }}" alt="no-order.jpg"
            width="70%">
        </div>
        @endif

      </div>

    </div>


  </div>

</div>

<!-- Change password Modal -->
<div class="z-index99 modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ __('staticwords.ChangePassword') }} ?</h5>
      </div>
      <div class="modal-body">
        <form id="form1" action="{{ route('pass.update',$user->id) }}" method="POST">
          {{ csrf_field() }}

          <div class="form-group eyeCy">


            <label class="font-weight-bold" for="confirm">{{ __('staticwords.Oldpassword') }}:</label>
            <input required="" type="password" class="form-control @error('old_password') is-invalid @enderror"
              placeholder="{{ __('staticwords.Enteroldpassword') }}" name="old_password" id="old_password" />

            <span toggle="#old_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

            @error('old_password')
            <span class="invalid-feedback text-danger" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>



          <div class="form-group eyeCy">



            <label class="font-weight-bold" for="password">{{ __('staticwords.EnterPassword') }}:</label>
            <input required="" id="password" min="6" max="255" type="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="{{ __('staticwords.EnterPassword') }}" name="password" minlength="8" />

            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

            @error('password')
            <span class="invalid-feedback text-danger" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror


          </div>



          <div class="form-group eyeCy">


            <label class="font-weight-bold" for="confirm">{{ __('staticwords.ConfirmPassword') }}:</label>
            <input required="" id="confirm_password" type="password" class="form-control"
              placeholder="{{ __('staticwords.re-enter-password') }}" name="password_confirmation" minlength="8" />

            <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

            <p id="message"></p>
          </div>


          <button @if(env('DEMO_LOCK')==0) type="submit" @else title="disabled"
            title="This action is disabled in demo !" @endif id="test" class="btn btn-md btn-success"><i
              class="fa fa-save"></i> {{ __('staticwords.SaveChanges') }}</button>
          <button id="btn_reset" data-dismiss="modal" class="btn btn-danger btn-md" type="reset">X
            {{ __('staticwords.Cancel') }}</button>
        </form>

      </div>

    </div>
  </div>
</div>

@endsection
@section('script')

<script src="{{ url('js/userorder.js') }}"></script>

@endsection