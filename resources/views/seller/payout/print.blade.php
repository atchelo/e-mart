<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Payout for Order Item #{{ $inv_cus->prefix.$payout->singleorder->inv_no.$inv_cus->postfix }} | eMart</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Google Font -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
  <!-- Ionicons -->
   <link rel="stylesheet" href="{{url('admindesk/vendor/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('admindesk/vendor/dist/css/adminlte.min.css')}}">

 <link rel="stylesheet" href="{{ url('admindesk/css/style.css') }}">

 

</head>
<body onload="window.print()">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice2">

     <a href="{{ route('vender.payout.show.complete',$payout->id) }}" title="Go back" class="printbtn btn btn-flat btn-default"><i class="fa fa-reply"></i></a>
     
     <hr class="printline">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Payout Slip for Order Item #{{ $inv_cus->prefix.$payout->singleorder->inv_no.$inv_cus->postfix }}
            <small class="pull-right">Date: {{ date('d/m/Y',strtotime($payout->created_at)) }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>{{ $genrals_settings->project_name }}</strong><br>
            {{ $genrals_settings->address }}<br>
          
            Phone: {{ $genrals_settings->mobile }}<br>
            Email: {{ $genrals_settings->email }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>{{ $payout->vender->name }}</strong><br>
            {{ $payout->vender->store->address }}<br>
            {{ $payout->vender->store->city['name'] }}, {{ $payout->vender->store->state['name'] }}, {{ $payout->vender->store->country['nicename'] }}<br>
            Phone: {{ $payout->vender->store->mobile }}<br>
            Email: {{ $payout->vender->store->paypal_email }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #{{ $inv_cus->prefix.$payout->singleorder->inv_no.$inv_cus->postfix }}</b><br>
          <b>Payout ID:</b> {{ $payout->payoutid}}<br>
          @if($payout->paidvia == 'Paypal') <b>Paypal Batch ID:</b> {{ $payout->txn_id }}<br> @endif
          <b>Payment Status:</b> {{ $status}}<br>
          <b>Transcation ID:</b> {{ $txnid }} <br>
          <b>Payment Method:</b> {{ $payout->paidvia == 'Bank' ? "Bank Transfer [$payout->txn_type]" : $payout->paidvia }}
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <hr>
      @if($payout->paidvia == 'Bank')
        <div class="row">
        <div class="pull-left col-sm-4 invoice-col">
           <p class="lead">Payee Bank Account Detail</p>
           <p><b>A/c no.:</b> {{ $payout->acno }}</p>
           <p><b>Payee Name:</b> {{ $payout->acholder }}</p>
           <p><b>IFSC Code:</b> {{ $payout->ifsccode }}</p>
           <p><b>Bank Name:</b> {{ $payout->bankname }}</p>
           <p><b>Branch: </b></p>
        </div>
        
      </div>
      <!-- /.row -->
      <hr>
      @endif
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              
              <th>#</th>
              <th>Image</th>
              <th>Product</th>
              <th>SKU</th>
              <th>Qty</th>
             
            </tr>
            </thead>
            <tbody>

            <tr>
              <td>1</td>
              <td>
                <img height="50px" src="{{url('variantimages/thumbnails/'.$payout->singleorder->variant->variantimages['main_image'])}}" alt=""/>
              </td>
              <td>{{ $payout->singleorder->variant->products->name }}  <small>
                        @php
                          $i=0;
                          $varcount = count($payout->singleorder->variant->main_attr_value);
                        @endphp
                      (@foreach($payout->singleorder->variant->main_attr_value as $key=> $orivars)
                                <?php $i++; ?>

                                    @php
                                      $getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
                                      $getvarvalue = App\ProductValues::where('id',$orivars)->first();
                                    @endphp

                                    @if($i < $varcount)
                                      @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
                                        @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
                                        {{ $getvarvalue->values }},
                                        @else
                                        {{ $getvarvalue->values }}{{ $getvarvalue->unit_value }},
                                        @endif
                                      @else
                                        {{ $getvarvalue->values }},
                                      @endif
                                    @else
                                      @if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
                                      @if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
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

                        </small></td>
        <td>{{ $payout->singleorder->variant->products->sku }}</td>
              <td>{{ $payout->singleorder->qty }}</td>
              
            </tr>
           
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

        <div class="row">
        <!-- accepted payments column -->
        <div class="col-md-6">
          <p class="lead">Paid Via:</p>
           @if($payout->paidvia == 'Stripe')
            <img width="60px" src="{{ url('images/bluestripe.png') }}" alt="Visa">
           @endif
          @if($payout->paidvia == 'Paypal')
            <img src="{{ url('images/paypal.png') }}" alt="Paypal">
          @endif
          @if($payout->paidvia == 'Bank')
          <img width="50px" src="{{ url('images/bankt.png') }}" alt="bank_transfer" title="Bank Transfer">
          @endif

          
        </div>
        <!-- /.col -->
        <div class="col-md-6">
         

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th class="width50">Subtotal:</th>
                <td><i class="{{ $defCurrency->currency_symbol }}"></i> @if($payout->paidvia == 'Bank') {{  sprintf("%.2f", $payout->orderamount+$payout->txn_fee) }} @else {{  sprintf("%.2f", $payout->orderamount) }} @endif</td>
              </tr>

              @if($payout->txn_fee !='')
              @if($payout->paidvia =='Paypal')
                <tr>
                  <th>Transcation Charge:</th>
                  <td><i class="{{ $defCurrency->currency_symbol }}"></i> {{ $payout->txn_fee }} <i title="Already paid by admin not included in this total" class="fa fa-info-circle"></i></td>
                </tr>
              @else
                <tr>
                  <th>Transcation Charge:</th>
                  <td> - <i class="{{ $defCurrency->currency_symbol }}"></i> {{ $payout->txn_fee }} <i title="Already paid by admin not included in this total" class="fa fa-info-circle"></i></td>
                </tr>
              @endif
              @endif

              <tr>
                <th>Total:</th>
                <td><i class="{{ $defCurrency->currency_symbol }}"></i> @if($payout->paidvia == 'Bank') {{  sprintf("%.2f", $payout->orderamount+$payout->txn_fee-$payout->txn_fee) }} @else {{  sprintf("%.2f", $payout->orderamount) }} @endif</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

     
    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>

</html>
