@extends("admindesk/layouts.master")

@section("body")

<div class="display-none preL">
  <div class="display-none preloader3"></div>
</div>

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Cities</h3>
      </div>
    
      <div class="box-body">
        <div class="alert alert-success">
          <p><b><i class="fa fa-info-circle"></i> Important</b></p>
          <ul>

             <li>If you enable pincode system you are enabling per destination delivery system which mean for particular cities if you add pincode your product is deliverable only for that city.</li>
              <li>If pincode system is enabled than product is deliverable on selected pincodes only.</li>

          </ul>
        </div>
        <span class="margin-top-10 control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              <label>
                Enable Pincode Delivery System:
              </label>
        </span>
         <div class="col-md-9 col-sm-9 col-xs-12">
             <label class="switch">
            <input  type="checkbox" class="toggle-input toggle-buttons" id="pincodesystem" {{$pincodesystem == 1 ? 'checked' : ''}}>
            <span class="knob"></span>
            </label>
        </div>
        <hr>

        <table id="countryTable" class="{{ $pincodesystem == 1 ? '' : 'display-none' }} table table-striped">
            <thead>
                <th>#</th>
                <th>Country Name</th>
                <th>#</th>
            </thead>
        </table>

      </div>
    </div>
  
@endsection

@section('custom-script')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/pincode.js') }}"></script>

  @if($pincodesystem == 1)
    <script>var search = {!! json_encode( url('pincode-add') ) !!};</script>
    <script src="{{ url('js/pincode2.js') }}"></script>
  @endif
 
@endsection