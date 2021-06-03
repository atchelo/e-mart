@extends("admindesk/layouts.master")
@section('title',"Add new user |")
@section("body")
<!-- general form elements -->

<div class="box box-widget widget-user">
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-primary">
    <h3 class="widget-user-username">{{ 'Create a new user'}}</h3>
  </div>
  <div class="widget-user-image">
    
    <img id="preview1" class="img-circle" src="{{ Avatar::create('U')->toBase64() }}" />
   
  </div>
  <div class="box-body">
    <br>
    <form method="post" enctype="multipart/form-data" action="{{url('admindesk/users/')}}">
      @csrf
      
      <div class="row">

        <div class="col-md-6">
          <div class="form-group">
            <label>Username: <span class="required">*</span></label>
            <input type="text" class="form-control" placeholder="Enter username" name="name" value="{{ old('name') }}">
            <small class="text-muted"><i class="fa fa-question-circle"></i> It will display the username eg.
              John</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Useremail: <span class="required">*</span></label>
            <input placeholder="Please enter email" type="email" name="email" value="{{ old('email') }} "
              class="form-control">
            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter valid email address with @
              symbol</small>
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
                    name="phonecode" value="{{old('phonecode')}}" class="form-control">
                   
                </div>
              </div>

              <div class="col-md-10">
                <input required pattern="[0-9]+" title="Invalid mobile no." placeholder="Please enter mobile no." type="text"
                  name="mobile" value="{{old('mobile')}}" class="form-control">
                <small class="pull-right text-muted"><i class="fa fa-question-circle"></i> Enter valid mobile no. eg.
                  7894561230</small>
              </div>



            </div>



          </div>

        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Phone:</label>
            <input pattern="[0-9]+" title="Invalid Phone no." placeholder="Please enter phone no." type="text"
              name="phone" value="{{old('phone')}}" class="form-control">
            <small class="text-muted"><i class="fa fa-question-circle"></i> Enter valid phone no. eg.
              0141-123456</small>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">

            <label>
              Country:
            </label>

            <select data-placeholder="Please select country" name="country_id" class="form-control select2" id="country_id">
              
              <option value="">Please Choose</option>
              @foreach($country as $c)
                     
                <option value="{{$c->id}}" >
                  {{$c->nicename}}
                </option>

              @endforeach
            </select>

            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select country</small>

          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>
              State:
            </label>

            <select data-placeholder="Please select state" required name="state_id" class="form-control select2" id="upload_id">
              <option value="">Please choose</option>
              
            </select>

            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select state</small>

          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label for="first-name">
              City:
            </label>
            <select data-placeholder="Please select city" name="city_id" id="city_id" class="form-control select2">
              <option value="">Please Choose</option>
              
            </select>
            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select city</small>
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group">
            <label>Website:</label>
            <input placeholder="http://" type="text" id="first-name" name="website" value="{{ old('website') }}"
              class="form-control">
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>
              User Role: <span class="required">*</span>
            </label>
            <select name="role_id" class="form-control select2">
              <option {{ app('request')->input('type') == "customer" ? "selected" : "" }} value="u">Customer</option>
              <option {{ app('request')->input('type') == "admindesk" ? "selected" : "" }} value="a">Admin</option>
              <option {{ app('request')->input('type') == "sellers" ? "selected" : "" }} value="v">Seller</option>
            </select>
            <small class="text-muted"><i class="fa fa-question-circle"></i> Select user type eg. (Admin,Seller or
              Customer)</small>
          </div>
        </div>

        <div class="col-md-6">
          <label for="first-name">Choose Image:</label>
          <input type="file" name="image" class="form-control">
          <small class="text-muted"><i class="fa fa-question-circle"></i> Please select user profile picture</small>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Status:</label>
            <input checked id="toggle-event3" type="checkbox"
              class="tgl tgl-skewed">
            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
            <input type="hidden" name="status" value="1" id="status3">
            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select user status</small>
          </div>
        </div>

       
        <div class="col-md-12 form-group">

         
         
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="eyeCy">
                  <label for="password">Enter Password:</label>
                  <input  id="password" type="password" class="passwordbox form-control" placeholder="Enter password"
                    name="password" />

                  <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
              </div>

            </div>


            <div class="col-md-6">

              <div class="form-group">
                <div class="eyeCy">
                  <label for="confirm">Confirm Password:</label>
                  <input  id="confirm_password" type="password" class="passwordbox form-control"
                    placeholder="Re-enter password for confirmation" name="password_confirmation" />

                  <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>

                <span class="required">{{$errors->first('password_confirmation')}}</span>
              </div>




            </div>



          </div>
        </div>
        

      </div>
      <button @if(env('DEMO_LOCK')==0) type="submit" title="Click to save user details" @else
        title="This action is disabled in demo !" disabled="disabled" @endif class="btn btn-md bg-blue btn-flat">
        <i class="fa fa-save"></i> Save User
      </button>
      <a href="{{ route('users.index',['filter' => app('request')->input('type') ]) }}" title="Go back" class="btn btn-md btn-default btn-flat">
        <i class="fa fa-arrow-left"></i> Back</a>
      </button>
    </form>
  </div>
</div>
@endsection
@section('custom-script')
<script>
  var baseUrl = "<?= url('/') ?>";
</script>
<script src="{{ url("js/ajaxlocationlist.js") }}"></script>
@endsection