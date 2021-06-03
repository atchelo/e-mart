@extends("admindesk/layouts.master")

@section("body")

  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">
    Check Destination
    </h3>
      </div>
      
      <div class="box-body">
        <table id="full_detail_table" class="table table-hover table-responsive">
          <thead>
            <tr class="table-heading-row">
              <th>Id</th>
              <th>City </th>
               <th>State </th>
               <th>Country </th>
                <th>Pincode </th>
               
            </tr>
          </thead>
          <tbody>
            <?php $i = 1;  ?>
             
             @foreach($city as $citys)
              <tr>
              <td>{{$citys->id}}</td>
              <td>{{$citys->name}}</td>
              <td>{{$citys->state['name']}}</td>
             
              <td><span id="show-pincode{{ $citys->id }}"></span>
              <div class="code"><input type="text" id="pincode{{ $citys->id }}" name="pincode" value="{{$citys->pincode}}" disabled>
             <button id="btnAddProfile{{$citys->id}}" onClick="checkPincode({{$citys->id}})">@if($citys->pincode==''){{'Add'}}@else {{'Edit'}}@endif</button></div></td>
              </tr>
               @endforeach
               
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('custom-script')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/pincode.js') }}"></script>
@endsection