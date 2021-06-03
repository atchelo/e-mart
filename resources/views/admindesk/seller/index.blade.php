@extends('admindesk.layouts.master')
@section('title','Seller Payments | ')
@section('body')
  <div class="box">
    <div class="box-header with-border">
      <div class="box-title">
        Seller Due Payouts
      </div>
    </div>

    <div class="box-body">
      	<table id="payouttable" class="width100 table table-bordered table-striped">
      		<thead>
      			<th>#</th>
      			<th>Order TYPE</th>
      			<th>Order ID</th>
      			<th>Order Amount</th>
      			<th>Seller Details</th>
      			<th>Action</th>
      		</thead>

      		<tbody>
      			
      		</tbody>
      	</table>
    </div>
  </div>
@endsection
@section('custom-script')
<script>
  var url = {!! json_encode(route('seller.payouts.index')) !!};
</script>
<script src="{{ url('js/payindex.js') }}"></script>
@endsection