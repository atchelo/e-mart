@extends("admindesk/layouts.master")
@section('title','Cities | ')
@section("body")


    <div class="box">
      <div class="box-header with-border">
        <button type="button" data-toggle="modal" data-target="#createCity" class="pull-right btn btn-md btn-primary">
          + Add new city
        </button>
        <div class="box-title">City</div>
      </div>
      
      <div class="box-body">
        <table id="citytable" class="table table-hover table-responsive">
          <thead>
            <tr class="table-heading-row">
              
              <th>ID</th>
              <th>City </th>
              <th>State </th>
              <th>Country</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!--Add new city Modal -->
<div class="modal fade" id="createCity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New State</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('city.store') }}" method="POST">
          @csrf
          <div class="form-group">
              <label class="" for="first-name">
                Select State: <span class="text-red">*</span>
              </label>
                <div class="row">
                  <div class="form-group">
                    
                    <div class="col-md-11">
                      <select required name="state_id" class="form-control col-md-7 col-xs-12">
                      
                        @foreach(App\Allstate::orderBy('name','ASC')->select('id','name')->get() as $state)
                          <option {{ old('state_id') == $state->id ? "selected" : "" }} value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                      </select>
                    </div>

                    <button data-dismiss="modal" title="Add new state" type="button" data-toggle="modal" data-target="#createState" class="btn btn-md btn-primary">+</button>

                  </div>
                  
                </div>

                
              
          </div>
          <div class="form-group">
            <label>Enter City Name: <span class="text-red">*</span></label>
            <input value="{{ old('name') }}" required type="text" class="form-control" name="name" placeholder="Enter city name">
          </div>

          <div class="form-group">
            <label>Enter City Pin/Zip or postal code: @if($pincodesystem == 1) <span class="text-red">*</span> @endif</label>
            <input {{ $pincodesystem == 1 ? "required" : "" }} value="{{ old('pincode') }}"  type="text" class="form-control" name="pincode" placeholder="Enter city pin/zip or postal code">
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-md btn-primary">+ Create</button>
          </div>
        </form>
      </div>
      
    </div>
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

        <!-- /page content -->
@endsection
@section('custom-script')
   <script>var url = {!!json_encode(route('city.index'))!!};</script>
  <script src="{{ url('js/city.js') }}"></script>
@endsection