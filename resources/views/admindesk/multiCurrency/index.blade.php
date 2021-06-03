@extends('admindesk.layouts.master')
@section('title','Currency List & Other Setting | ')
@section('body')
<div class="box">
  <div class="box-header with-border">
    <div class="box-title">
      Multiple Currency & Location Setting
    </div>
  </div>

  <div class="box-body">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs" id="currencyTabs" role="tablist">

        <li class="nav-item active">
          <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
            aria-selected="true">Currency List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
            aria-selected="false">Location</a>
        </li>
        <!-- In Beta -->
        <li class="nav-item">
          <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages"
            aria-selected="false">Checkout</a>
        </li>
        <!-- In Beta -->

      </ul>
    </div>
    <div class="tab-content">
      <div class="tab-pane fade in active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <br>
        <div class="container-fluid">
          <div class="form-group">

            <span class="margin-top-10 control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              <label>Enable Multicurrency:</label>
            </span>


            <label class="switch">

              <input onchange="enabel_currency()" type="checkbox" name="default" id="enabel"
                {{$auto_geo->enabel_multicurrency=="1"?'checked':''}}>
              <span class="knob"></span>

            </label>

            <div class="row">
              <br>
              <div class="col-md-12">
                <div class="callout callout-info">
                  <p><i class="fa fa-info-circle"></i> <b>Additioal fee:</b> If you enter additional fee for ex. 2 and
                    your currency rate is 1 than at time of conversion total conversion rate will be 3 and new rate will
                    be convert accroding to this conversion rate. It will not work on if above toggle is off.</p>
                </div>

                <div class="callout callout-success">
                  <p><i class="fa fa-info-circle"></i> <b>Note:</b> USD Rate display here will be 1 (Because open exchange free api key a/c only consider base currency as USD if you want to upgrade to Open exchange pro a/c than base currency can be changed) but at the time of conversion it take original rate like you converting an amount of 1 EURO to USD than price will be multiplies from Standard rate.</p>
                </div>

              </div>
            </div>

            <div class="box">
              <div class="box-header with-border">
                <div class="box-title">
                   Currencies
                </div>

                <button data-toggle="modal" data-target="#addCurrency" type="button" class="pull-right btn btn-success btn-md">+ {{ __('Add Currency') }}</button>
              </div>

              <div class="box-body">
                <table id="currencyTable" class="width100 table table-bordered"> 

                  <thead>
                    <tr>
                      <th>#</th>
                      <th scope="col">Currency</th>
                      <th scope="col">Rate</th>
                      <th scope="col">Additional Fee</th>
                      <th scope="col">Currency Symbol</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
    
    
                  </tbody>
    
                </table>
              </div>
            </div>

            
            
            <div  id="addCurrency" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="my-modal-title">Add New Currency</h4>
                    
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('multiCurrency.store') }}" method="POST">
                      @csrf

                      <div class="form-group">
                        <label>Currency Code: <span class="text-danger">*</span></label>
                        <input placeholder="eg. USD" value="{{ old('code') }}" required class="form-control" type="text" name="code">
                        <small class="text-muted">
                          <i class="fa fa-question-circle"></i> Currency code must be a valid ISO-3 code.
                          Find your currency ISO3 code  <a target="__blank" href="https://www1.oanda.com/currency/help/currency-iso-code-country">here</a> 
                        </small>
                      </div>

                      
                      <div class="form-group">
                        <label>Additional Charges:</label>
                        <input placeholder="eg. 0.50" min="0" step="0.01" value="{{ old('add_amount') }}"  class="form-control" type="number" name="add_amount">
                      </div>

                      <div class="form-group">
                        <label>Currency Position: <span class="text-danger">*</span></label>
                          <select data-placeholder="Please select currency position" name="position" id="position" class="form-control select2">
                            <option value="">Please select currency position</option>
                            <option value="l">Left side currency icon</option>
                            <option value="r">Right side currency icon</option>
                            <option value="ls">Left side with space currency icon</option>
                            <option value="rs">Right side with space currency icon</option>
                          </select>
                      </div>

                      <div class="form-group">
                        <label>Currency Symbol: <span class="text-danger">*</span></label>
                          <div class="input-group iconpicker-container">
                            <input placeholder="Please select currency symbol" data-placement="bottomRight" class="form-control showcur icp icp-auto iconpicker-element iconpicker-input" name="currency_symbol" value="{{ old('currency_symbol') }}" type="text">
                            <span class="input-group-addon"><i class="far fa-grin-tongue-squint"></i></span>
                          </div>
                      </div>

                      
                      
                      <div class="form-group">
                        <button type="submit" class="btn btn-success btn-md">
                          <i class="fa fa-save"></i> {{ __('Save') }}
                        </button>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>


            <div class="row pull-left ">
              <div class="col-md-6">

                <a class="btn btn-primary updateRateBtn">

                  <span id="buttontext"><i class="fa fa-refresh"></i></span> {{ __('Update Rates') }}

                </a>

              </div>
              
            </div>

            <br><br>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        @include('admindesk.multiCurrency.location')
      </div>
      <!-- In Beta -->

      <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
        @include('admindesk.multiCurrency.checkout')
      </div>

      <!-- In Beta -->

    </div>
  </div>
</div>
@endsection
@section('custom-script')
<script>
  var baseUrl = "<?= url('/') ?>";
</script>
<script src="{{ url('js/currency.js') }}"></script>
<script>
  $(function () {
      "use strict";
      var table = $('#currencyTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route("multiCurrency.index") }}',
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable : false, searchable : false},
              {data : 'code', name : 'currencies.code'},
              {data : 'rate', name : 'currencies.exchange_rate'},
              {data : 'additional_amount', name : 'multi_currencies.add_amount'},
              {data : 'symbol', name : 'multi_currencies.currency_symbol'},
              {data : 'action', name : 'action',orderable : false, searchable : false},
          ],
          order : [[0,'ASC']]
      });
      
      
$('.updateRateBtn').on('click',function(){
  $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: '{{ route("auto.update.rates") }}',
      beforeSend: function() {
        $('#buttontext').html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
      },
      success: function(data) {
        table.draw();
        console.log(data);
        var animateIn = "lightSpeedIn";
        var animateOut = "lightSpeedOut";
        $('#buttontext').html('<i class="fa fa-refresh"></i>');
        swal({
            title: "Success ",
            text: 'Currency Rates Updated !',
            icon: 'success'
          });
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
});

});
</script>
@endsection