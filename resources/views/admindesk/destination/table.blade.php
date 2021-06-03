@extends('admindesk.layouts.master')
@section('title',"Pincode List of $country->nicename |")
@section('body')
<div class="box box-primary">
  <div class="box-header with-border">
      <div class="box-title">Cities List of {{ $country->nicename }}</div>
      <a title="Go back" href="{{ route('admindesk.desti') }}" class="btn btn-sm btn-success pull-right"><< Back</a>
  </div>

  <div class="box-body">
      <table id="" class="width100 data-table table table-hover table-responsive">
          <thead>
            <tr class="table-heading-row">

              <th>ID</th>
              <th>City </th>
              <th>State </th>
              <th>Pincode </th>
               
            </tr>
          </thead>
          <tbody>
            
             
          </tbody>
  </table>
  </div>
</div>
@endsection
@section('custom-script')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/pincode.js') }}"></script>
  <script>
    var url = {!!json_encode( route('country.list.pincode',$country->id) )!!};
  </script>
  <script src="{{ url('js/pincode2.js') }}"></script>
@endsection