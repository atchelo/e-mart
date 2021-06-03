@extends("admindesk.layouts.sellermaster")
@section('title',auth()->user()->store->name.' Dashboard | ')
@section("body")

<div class="box">
  <div class="box-header with-border">

    <h3 class="box-title"><span class="lnr lnr-laptop"></span> Dashboard</h3>

  </div>
  <div class="box-body">

    @if(env('ENABLE_SELLER_SUBS_SYSTEM') == 1)
    <div class="box">
      <div class="box-header with-border">
        <div class="box-title">
          {{ __("Current Subscription") }}
        </div>
      </div>
      <div class="box-body">
        <h5><b>{{ __("Plan Name:") }}</b> {{ auth()->user()->activeSubscription->plan ? auth()->user()->activeSubscription->plan->name : 'Plan not found !' }}</h5>
        <h5><b>{{ __("Product Upload Limit:") }}</b> {{ auth()->user()->activeSubscription->plan ? auth()->user()->products()->count().' / '.auth()->user()->activeSubscription->plan->product_create : 'Plan not found !' }}</h5>
        <h5><b>{{ __("Expires ON:") }}</b> {{ auth()->user()->activeSubscription ?  date('d/m/Y h:i A',strtotime(auth()->user()->activeSubscription->end_date)) : "Not found !"}}</h5>
        <h5><b>{{ __("CSV Product Upload:") }}</b> {{ auth()->user()->activeSubscription->plan && auth()->user()->activeSubscription->plan->csv_product ? "YES"  : "NO"}}</h5>
      </div>
      <div class="box-footer">
        <a class="text-center text-muted" href="{{ route('seller.my.subscriptions') }}">
          <b> <i class="fa fa-eye"></i> {{__("View More")}}</b>
        </a>
      </div>
    </div>
    @endif


    <div class="row dbrow">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ count($products) }}</h3>

            <p>Total Products</p>
          </div>

          <div class="icon">
            <i class="fa fa-shopping-basket" aria-hidden="true"></i>

          </div>


          <a href="{{ route('my.products.index') }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{count($orders)}}<sup class="font-size-20"></sup></h3>

            <p>Total Orders</p>
          </div>
          <div class="icon">
            <i class="fa fa-area-chart" aria-hidden="true"></i>

          </div>
          <a href="{{url('seller/orders')}}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>

      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3>{{ $totalcanorders }}<sup class="font-size-20"></sup></h3>

            <p>Total Canceled Orders</p>
          </div>
          <div class="icon">
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>

          </div>
          <a href="{{ url('seller/ord/cancelled') }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3>{{ $totalreturnorders }}</h3>

            <p>Total Returned Orders</p>
          </div>

          <div class="icon">
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>

          </div>

          <a href="{{ url('seller/return/orders') }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3>{{ $payouts }}</h3>

            <p>Received Payouts</p>
          </div>

          <div class="icon">
            <i class="fa fa-money" aria-hidden="true"></i>

          </div>

          <a href="{{ route('seller.payout.index') }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $money }}</h3>

            <p>Total Earning</p>
          </div>

          <div class="icon">
            <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>

          </div>

          <a href="{{ route('seller.payout.index') }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-md-12">
        {!! $sellerorders->container() !!}
      </div>


    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header with-border">

            <h4 class="box-title"><span class="ltorder lnr lnr-star"></span> Latest Orders</h4>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>

          </div>

          <div class="ltorderbox box-body">
            <table class="table table-borderd table-responsive">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Order ID</th>
                  <th>Customer name</th>
                  <th>Qty</th>
                  <th>Price</th>
                  <th>Date</th>
                </tr>
              </thead>

              <tbody>

                @foreach($orders as $key=> $order)

                @php
                $x = App\InvoiceDownload::where('order_id','=',$order->id)->where('vender_id',auth()->id())->get();

                $total = 0;
                $qty = $x->sum('qty');

                foreach ($x as $value) {

                $total = $total+$value->qty*$value->price+$value->tax_amount+$value->shipping;

                }
                @endphp

                <tr>

                  <td>{{$key+1}}</td>
                  <td><a title="View order"
                      href="{{ route('seller.view.order',$order->order_id) }}">#{{ $inv_cus->order_prefix.$order->order_id }}</a>
                  </td>
                  <td>{{ $order->user->name }}</td>
                  <td>{{ $qty }}</td>
                  <td><i class="{{ $order->paid_in }}"></i>{{ $total }}</td>
                  <td>{{ date('d-M-Y',strtotime($order->created_at)) }}</td>

                </tr>

                @endforeach
              </tbody>
            </table>



          </div>

          <div align="center" class="box-footer">
            <a class="link-text" href="{{ url('seller/orders') }}"><i class="fa fa-eye"></i> View All Orders</a>
          </div>

        </div>
      </div>
      @if($dashsetting->rct_pro ==1)
      <div class="col-md-4">

        <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><span class="lnr lnr-pushpin"></span> Recently Added Products</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>

            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body height335 overflow-y-scroll">
            <ul class="products-list product-list-in-box">


              @foreach($products->take($dashsetting->max_item_pro) as $pro)
              @foreach($pro->subvariants as $key=> $sub)
              @if($sub->def == 1)
              @php
              $var_name_count = count($sub['main_attr_id']);
              $name = array();
              $var_name;
              $newarr = array();
              for($i = 0; $i<$var_name_count; $i++){ $var_id=$sub['main_attr_id'][$i];
                $var_name[$i]=$sub['main_attr_value'][$var_id]; $name[$i]=App\ProductAttributes::where('id',$var_id)->
                first();

                }


                try{
                $url =
                url('/details/').'/'.$pro->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                }catch(Exception $e)
                {
                $url = url('/details/').'/'.$pro->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                }

                @endphp

                <li class="item">
                  <div class="product-img">
                    @if(count($pro->subvariants)>0)
                    <center>
                      @if($sub->variantimages)
                        <img class="pro-img2"
                        src="{{ url('variantimages/thumbnails/'.$sub->variantimages['main_image']) }}"
                        alt="{{ $sub->variantimages['main_image'] }}" title="{{ $pro->name }}">
                      @else
                        <img class="pro-img2"
                        src="{{ Avatar::create($pro->name) }}" title="{{ $pro->name }}">
                      @endif
                    </center>
                    @endif
                  </div>
                  <div class="product-info">
                    <a href="{{ url($url) }}" class="product-title">{{ $pro->name }}
                      <span class="label label-success pull-right">@if($pro->vender_offer_price !=null)
                        {{ $pro->price_in }} {{ $pro->vender_offer_price+$sub->price }}
                        @else
                        {{ $pro->price_in }} {{ $pro->vender_price+$sub->price }}
                        @endif</span></a>
                    <span class="product-description">
                      {{ substr(strip_tags($pro->des),0,50)}}{{strlen(strip_tags($pro->des))>50 ? "..." : "" }}
                    </span>
                  </div>
                </li>

                @endif
                @endforeach
                @endforeach
                <!-- /.item -->
            </ul>
          </div>
          <!-- /.box-body -->
          <div class="box-footer text-center">
            <a href="{{ route('my.products.index') }}" class="link-text uppercase"><i class="fa fa-eye"></i> View All
              Products</a>
          </div>
          <!-- /.box-footer -->
        </div>
      </div>
      @endif

      <div class="col-md-4">

        <div class="box box-solid">
          <div class="box-body">
            {!! $piechart->container() !!}
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-12">
      {!! $sellerpayoutdata->container() !!}
    </div>

  </div>
</div>
</div>

@endsection
@section('custom-script')
<script src="{{ url('front/vendor/js/highcharts.js') }}" charset="utf-8"></script>
{!! $sellerorders->script() !!}
{!! $sellerpayoutdata->script() !!}
{!! $piechart->script() !!}
@endsection