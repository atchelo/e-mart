@extends("admindesk.layouts.sellermaster")
@section('title','Edit Profile |')
@section("body")


<!-- general form elements -->

<div class="box box-widget widget-user">
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-primary">
    <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
    <h5 class="widget-user-desc">{{ Auth::user()->store->name }}</h5>
  </div>
  <div class="widget-user-image">
    @if(Auth::user()->image !="")
    <img id="preview1" src="{{url('images/user/'.Auth::user()->image)}}" class="img-circle" alt="User Image">
    @else
    <img id="preview1" class="img-circle" title="{{ Auth::user()->name }}"
      src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" />
    @endif
  </div>
  <div class="box-footer">
    <div class="row">
      <div class="col-sm-4 border-right">
        <div class="description-block">
          <h5 class="description-header">{{ Auth::user()->purchaseorder->count() }}</h5>
          <span class="description-text">TOTAL PURCHASE</span>
        </div>
        <!-- /.description-block -->
      </div>
      <!-- /.col -->
      <div class="col-sm-4 border-right">
        <div class="description-block">
          <h5 class="description-header"><i class="fa fa-map-marker"></i></h5>
          <span class="description-text">
            @if(auth()->user()->country)
              {{ auth()->user()->city ?  auth()->user()->city->name.', ' : '' }} 
              {{ auth()->user()->state ?  auth()->user()->state->name.', ' : '' }} 
              {{ auth()->user()->country->nicename }}
            @else 
              {{__("Location not updated")}}
            @endif
          </span>
        </div>
        <!-- /.description-block -->
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <div class="description-block">
          <h5 class="description-header">{{ count(Auth::user()->products) }}</h5>
          <span class="description-text">TOTAL PRODUCTS</span>
        </div>
        <!-- /.description-block -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <hr>

  <div class="box-body">
    {{-- seller profile --}}
    <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Name: <span class="required">*</span></label>
            <input placeholder="Please enter name" type="text" name="name" value="{{auth()->user()->name}}"
              class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Buisness Email: <span class="required">*</span></label>
            <input placeholder="Please enter email" type="text" name="email" value="{{auth()->user()->email}} "
              class="form-control">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="">Phone:</label>
            <input placeholder="Please Enter phone no." type="text" name="phone" value="{{auth()->user()->phone}}"
              class="form-control">
          </div>
        </div>

        <div class="col-md-6">

          <div class="form-group">
            <label>
              Mobile: <span class="required">*</span>
            </label>

            <div class="row no-gutter">
              <div class="col-md-2">
                <div class="input-group">

                  <input required pattern="[0-9]+" title="Invalid mobile no." placeholder="1" type="text"
                    name="phonecode" value="{{auth()->user()->phonecode}}" class="col-md-2 form-control">

                </div>
              </div>

              <div class="col-md-10">

                <input required pattern="[0-9]+" title="Invalid mobile no." placeholder="Please enter mobile no."
                  type="text" name="mobile" value="{{auth()->user()->mobile}}" class="col-md-10 form-control">

              </div>

            </div>

          </div>

        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="">Choose Profile picture:</label>
            <input id="image1" type="file" name="image" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Country: <span class="required">*</span></label>
            <select data-placeholder="Please select country" class="form-control select2" name="country_id"
              id="country_id">
              <option value="">Please Choose</option>
              @foreach($country as $c)

              <option value="{{$c->id}}" {{ $c->id == auth()->user()->country_id ? 'selected="selected"' : '' }}>
                {{$c->nicename}}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>State: <span class="required">*</span></label>
            <select data-placeholder="Please select state" required name="state_id" class="form-control select2"
              id="upload_id">
              <option value="">Please choose</option>
              @foreach($states as $c)
              <option value="{{$c->id}}" {{ $c->id == auth()->user()->state_id ? 'selected="selected"' : '' }}>
                {{$c->name}}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="">City:</label>
            <select data-placeholder="Please select city" name="city_id" id="city_id" class="form-control select2">
              <option value="">Please Choose</option>
              @foreach($citys as $key=>$c)

              <option value="{{ $key }}" {{ $key == auth()->user()->city_id ? 'selected' : '' }}>
                {{$c}}
              </option>
              @endforeach
            </select>
          </div>
        </div>

      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <label class="check">
            <input type="checkbox" name="update_password" value="test">
            <span class="checkmark"></span>
            Want To Update password
          </label>

          <div class="row">
            <div class="col-md-6">
              <label for="">Password: <span class="required">*</span></label>
              <input name="password" type="password" class="form-control" placeholder="Enter new password">
              <i class="fa fa-eye"></i>
            </div>
            <div class="col-md-6">
              <label for="">Confirm Password: <span class="required">*</span></label>
              <input placeholder="Enter password again to confirm" type="password" name="password_confirmation"
                class="form-control">
              <i class="fa fa-eye"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <button @if(env('DEMO_LOCK')==0) type="submit" @else title="This action is disabled in demo !"
          disabled="disabled" @endif class="btn btn-primary"><i class="fa fa-save"></i> Save Profile</button>
      </div>
      <br>
    </form>
    {{-- seller profile end --}}
  </div>


  @endsection

  @section('custom-script')

  <script>
    var baseUrl = "<?= url('/') ?>";
  </script>
  <script src="{{ url('js/ajaxlocationlist.js') }}"></script>

  @endsection