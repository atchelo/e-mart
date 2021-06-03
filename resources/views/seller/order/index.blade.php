@extends("admindesk.layouts.sellermaster")
@section('title','Your Orders - ')
@section("body")

  <div class="chart-box">
    <div class="box box-default box-body">
      {!! $sellerorders->container() !!}
    </div>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">
    Your Orders
    </h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="full_detail_table" class="table table-bordered table-striped">
         <thead>
            <tr>
              <th>#</th>
              <th>Order Type</th>
              <th>Order ID</th>
              <th>Total Qty</th>
              <th>Total Amount</th>
              <th>#</th>
            </tr>
          </thead>

          <tbody>
          

            @foreach($emptyOrder as $key=> $o)

             @php
              $x = App\InvoiceDownload::where('order_id','=',$o->id)->where('vender_id',Auth::user()->id)->get();

              $total = 0;

              foreach ($x as $key => $value) {
                  $total = $total+($value->qty*$value->price)+$value->tax_amount+$value->gift_charge+$value->shipping+$value->handlingcharge;
              }
             @endphp
              <tr>
                <td>{{ $key+1 }}</td>
                <td>
                    @if($o->payment_method !='COD')
                      <label class="label label-success">PREPAID</label>
                    @else
                      <label class="label label-primary">COD</label>
                    @endif
                </td>
                <td>{{ $inv_cus->order_prefix.$o->order_id }}
                <p></p>
                <small><a title="View Order" href="{{ route('seller.view.order',$o->order_id) }}">View Order</a></small> | 
                <small><a title="Edit Order" href="{{ route('seller.order.edit',$o->order_id) }}">Edit Order</a></small>
                </td>
                <td>{{ $x->sum('qty') }}</td>
                <td> <i class="{{ $o->paid_in }}"></i>{{ $total }}
                 </td>
                
               <td>
                  <a title="Print Order" href="{{ route('seller.print.order',$o->id) }}" class="btn btn-sm btn-default">
                    <i class="fa fa-print"></i>
                  </a> 
                </td>
              </tr>
            @endforeach

            

          </tbody>
         
        </table>
    
      </div>
      <!-- /.box-body -->
    </div>

@endsection
@section('custom-script')
<script src="{{ url('front/vendor/js/highcharts.js') }}" charset="utf-8"></script>
<script>
  $(".btn-box-tool").click(function(){
    $(this).toggleClass('btn-plus');
    $(".box-default").slideToggle();
  });
</script>

 {!! $sellerorders->script() !!}
@endsection