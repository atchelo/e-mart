@extends('admindesk.layouts.master')
@section('title','Wallet Setting | ')
@section('body')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            Wallet Settings
        </div>
    </div>
    <div class="box-body">

        <div class="form-group">
            <label>Enable Wallet: </label>
            <br>
            <label class="switch">
                <input {{ $wallet == 1 ? "checked" : "" }} type="checkbox" class="wallet_enable" name="wallet_enable">
                <span class="knob"></span>
            </label>
            <br>
            <small class="text-muted"><i class="fa fa-question-circle"></i> It will activate the wallet on
                portal</small>
        </div>
        <hr>
        <div class="wallet-dashboard {{ $wallet == 0 ? "display-none" : "" }}">
            <p>
                <b>Wallet States:</b>
            </p>

            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-green"><i class="animated zoomIn delay-1s fa fa-line-chart" aria-hidden="true"></i>
                      </span>
          
                      <div class="info-box-content">
                        <span class="info-box-text">Active Wallet Users</span>
                        <span class="info-box-number">{{ $states['activeuser'] }}</span>
                        <small class="text-muted">(Counted active wallet users ONLY)</small>
                      </div>
                      
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>

                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-aqua"><i class="animated zoomIn fa fa-users delay-1s" aria-hidden="true"></i>
                      </span>
          
                      <div class="info-box-content">
                        <span class="info-box-text">Total Wallet Users</span>
                        <span class="info-box-number">{{ $states['totaluser'] }}</span>
                        <small class="text-muted">(Counted active and deactive wallet users)</small>
                      </div>
                      
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>

                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-orange"><i class="animated zoomIn delay-1s fa fa-bar-chart" aria-hidden="true"></i>

                      </span>
          
                      <div class="info-box-content">
                        <span class="info-box-text">Wallet Transcations</span>
                        <span class="info-box-number">{{ $states['wallettxn'] }}</span>
                        <small class="text-muted">(No of user wallet transcations made on {{ config('app.name') }})</small>
                      </div>
                      
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>

                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-primary"><i class="animated zoomIn delay-1s fa fa-calculator" aria-hidden="true"></i>

                      </span>
          
                      <div class="info-box-content">
                        <span class="info-box-text">Overall Wallet balance</span>
                        <span class="info-box-number"> <i class="{{ $defCurrency->currency_symbol }}"></i> {{ $states['overallwalletbalance'] }}</span>
                        <small class="text-muted">(Overall wallet balance of active wallet users)</small>
                      </div>
                      
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>

                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-teal"><i class="animated zoomIn delay-1s fa fa-cart-plus" aria-hidden="true"></i>

                      </span>
          
                      <div class="info-box-content">
                        <span class="info-box-text">Total Wallet Orders</span>
                        <span class="info-box-number">{{ $states['walletorders'] }}</span>
                        <small class="text-muted">(Total no. of orders made by wallet)</small>
                      </div>
                      
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
            </div>

            <hr>
            <p><b>Order Wallet Report:</b></p>
            <table id="wallet_logs_table" class="width100 table table-bordered table-striped">
                <thead>
                    <th>#</th>
                    <th>TXN ID</th>
                    <th>Note</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Transcation Date</th>
                    <th>Transcation Time</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('custom-script')
<script>

    $(function () {
      "use strict";
      var table = $('#wallet_logs_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route("admindesk.wallet.settings") }}',
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false},
              {data : 'wallet_txn_id', name : 'wallet_txn_id'},
              {data : 'note', name : 'note'},
              {data : 'type', name : 'type'},
              {data : 'amount', name : 'amount'},
              {data : 'balance', name : 'balance'},
              {data : 'txndate', name : 'txndate'},
              {data : 'txntime', name : 'txntime'},
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });
      
});

    $('.wallet_enable').on('change', function () {
        var status;
        if ($(this).is(':checked')) {
            status = 1;
            $('.wallet-dashboard').removeClass("display-none");
        } else {
            status = 0;
            $('.wallet-dashboard').addClass("display-none");
        }


        $.ajax({
            type: 'GET',
            url: '{{ route("admindesk.update.wallet.settings") }}',
            data: {
                wallet_enable: status
            },
            success: function (data) {
                if (data.code == 200) {

                    swal({
                        title: "Success ",
                        text: data.msg,
                        icon: 'success'
                    });


                } else {

                    swal({
                        title: "error",
                        text: data.msg,
                        icon: 'error'
                    });


                }
            },
            error: function (jqXHR, exception) {
                console.log(jqXHR);
            }
        });
    });
</script>
@endsection