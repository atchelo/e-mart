@extends('admindesk.layouts.master')
@section('title','View Payout #'.$payout->payoutid.' | ')
@section('body')
	
   <div class="box">
     <div class="box-body">
         <!-- Main content -->
    <section class="invoice2">

     <a href="{{ route('seller.payout.complete') }}" title="Go back" class="btn btn-flat btn-default"><i class="fa fa-reply"></i></a>
     <a href="{{ route('seller.print.slip',$payout->id) }}" class="pull-right btn btn-flat btn-default"><i class="fa fa-print"></i></a>
     <hr>
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
          @if($payout->paidvia == 'Paypal')
            <b>Payment Status:</b> {{ $status }}<br>
            <b>Paypal Batch ID:</b> {{ $payout->txn_id }} <br>
          @endif
          <b>Transcation ID:</b> {{ $txnid }} <br>
          <b>Payment Method:</b> {{ $payout->paidvia == 'Bank' ? "Bank Transfer [$payout->txn_type]" : $payout->paidvia }}
        </div>


        <!-- /.col -->
      </div>
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
        <div class="col-xs-6">
          <p class="lead">Paid Via:</p>
           
          @if($payout->paidvia == 'Paypal')
            <img src="{{ url('images/paypal.png') }}" alt="Paypal">
          @endif
          @if($payout->paidvia == 'Bank')
          <img width="50px" src="{{ url('images/bankt.png') }}" alt="bank_transfer" title="Bank Transfer">
          @endif

          <hr>
          <div class="callout callout-default no-shadow">
            <h5><i class="fa fa-info-circle"></i> Note:</h5>
            @if($payout->paidvia == 'Paypal')
            Payout fee of <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i>{{ $payout->txn_fee }} is additionally applied by Paypal not included in grand total.
            @elseif($payout->paidvia == 'bank')
             Bank Transfer [{{ $payout->txn_type }}] usually takes 2-3 working days or 48hours for reflect amount in user bank account.
            @else
              Amount is already paid to the seller.
            @endif
          </div>
        
        </div>


        <!-- /.col -->
        <div class="col-xs-6">
         

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th class="width50">Subtotal:</th>
                <td><i class="{{ $defCurrency->currency_symbol }}"></i> @if($payout->paidvia == 'Bank') {{  sprintf("%.2f", $payout->orderamount+$payout->txn_fee) }} @else {{  sprintf("%.2f", $payout->orderamount) }} @endif
                  
                </td>
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
    <div class="clearfix"></div>
     </div>
   </div>
  
@endsection