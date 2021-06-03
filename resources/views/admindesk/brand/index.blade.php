@extends("admindesk.layouts.master")
@section('title','All Brands |')
@section("body")


<div class="box">
  <div class="box-header with-border">
    <div class="box-title">
      Brand
    </div>

    <a href=" {{url('admindesk/brand/create')}} " class="btn btn-md btn-success pull-right"> <i class="fa fa-plus-circle"></i> Add new brand</a>

  </div>

  <div class="box-body">
    <table id="brandTable" class="width100 table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr. No.</th>
          <th>Brand Name</th>
          <th>Brand Logo</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>

  </div>
  <!-- /.box-body -->
</div>

@foreach($brands as $brand)
<div id="{{ $brand->id }}deletebrand" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete this brand? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{url('admindesk/brand/'.$brand->id)}}" class="pull-right">
          {{csrf_field()}}
          {{method_field("DELETE")}}

          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection
@section('custom-script')
<script>
  var url = @json(route('brand.index'));
</script>
<script src="{{ url('js/brand.js') }}"></script>
@endsection