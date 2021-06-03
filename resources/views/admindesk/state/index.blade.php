@extends("admindesk/layouts.master")
@section('title','States | ')
@section("body")

  <div class="col-xs-12">
    <div class="box" >
      <div class="box-header with-border">
        <button data-toggle="modal" data-target='#createState' class="btn btn-md btn-primary pull-right">
          + Add State
        </button>
        <div class="box-title">State</div>
        </div>
           
            <div class="box-body">
        <table id="state_table" class="table table-hover table-responsive width100">
            
            <thead>
              <tr class="table-heading-row">
                <th>ID</th>
                <th>State </th>
                 <th>Country </th>
                 
              </tr>
            </thead>

              <tbody>
              

              </tbody>

        </table>
        
          </div>
          <!-- /.box-body -->
        </div>
      </div>

<!--Add new state Modal -->
<div class="modal fade" id="createState" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New State</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('state.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Select Country: <span class="text-red">*</span></label>
            <select required name="country_id" id="country_id" class="select2">
              @foreach(App\Allcountry::orderBy('name','ASC')->get() as $country)
                <option {{ old('value') == $country['id'] ? "selected" : "" }} value="{{ $country['id'] }}">{{ $country['nicename'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Enter State Name: <span class="text-red">*</span></label>
            <input value="{{ old('name') }}" required type="text" class="form-control" name="name" placeholder="Enter state name">
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-md btn-primary">+ Create</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
@endsection
@section('custom-script')
  <script>var url = {!!json_encode( route('state.index') )!!};</script>
  <script src="{{ url('js/state.js') }}"></script>
@endsection