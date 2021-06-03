@extends("admindesk/layouts.master")
@section('title',"All Stores |")
@section("body")

<div class="box" >
  <div class="box-header with-border">
    <h3 class="box-title">All Stores</h3>
    <a href=" {{url('admindesk/stores/create')}} " class="btn btn-success pull-right">
      + Add new store
    </a>
  </div>

  <div class="box-body">
     <table id="store_table" class="width100 table table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>
              Store Logo
            </th>

            <th>
              Store Details
            </th>

            <th>
              Owner
            </th>

            <th>
              Status
            </th>

            <th>Store Request Accepted?</th>
            <th>Request For Delete</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          
        </tbody>
     </table>
  </div>
</div>

@endsection
@section('custom-script')
<script>
  var url = {!! json_encode( route('stores.index') ) !!};
</script>
<script src="{{url('js/store.js')}}"></script>
@endsection