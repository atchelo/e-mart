@extends("admindesk/layouts.master")
@section('title','All Countries')
@section("body")

    <div class="box">
      <div class="box-header with-border">
        <div class="box-title">Country</div>
         <div class="pull-right">
           <a href=" {{url('admindesk/country/create')}} " class="btn btn-success btn-md">+ Add Country</a>
         </div>
      </div>    
          <div class="box-body">
          <table id="country_table" class="table table-hover table-responsive width100">
            <thead>
              <tr class="table-heading-row">
                <th>ID</th>
                <th>Country Name </th>
                <th>ISO Code 2</th>
                <th>ISO Code 3</th>
                <th>Action</th>
              </tr>
            </thead>
        </table>
    
      </div>
      <!-- /.box-body -->
    </div>
  </div>

 @foreach($countries as $country)
  <div id="country{{ $country->id }}" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this country? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
                 <form method="post" action="{{url('admindesk/country/'.$country->id)}}" class="pull-right">
                        {{csrf_field()}}
                         {{method_field("DELETE")}}
                          
                 <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
 @endforeach
@endsection
@section('custom-script')
<script>
  var url = {!!json_encode( route('country.index') )!!};
</script>
<script src="{{asset('js/country.js')}}"></script>
@endsection