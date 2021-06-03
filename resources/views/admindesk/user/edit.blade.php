@extends("admindesk/layouts.master")
@section('title',"Edit User - $user->name |")
@section("body")
<!-- general form elements -->

<div class="box box-widget widget-user">
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-primary">
    <h3 class="widget-user-username">{{ $user->name }}</h3>
    <h5 class="widget-user-desc">{{ $user->store['name'] ?? '' }}</h5>
  </div>
  <div class="widget-user-image">
    @if($user->image !="")
    <img title="{{ $user->name }}" id="preview1" src="{{url('images/user/'.$user->image)}}" class="img-circle">
    @else
    <img id="preview1" class="img-circle" title="{{ $user->name }}"
      src="{{ Avatar::create($user->name)->toBase64() }}" />
    @endif
  </div>
  <div class="box-footer">
    <div class="row">
      <div class="col-sm-4 border-right">
        <div class="description-block">
          <h5 class="description-header">{{ $user->purchaseorder->count() }}</h5>
          <span class="description-text">TOTAL PURCHASE</span>
        </div>
        <!-- /.description-block -->
      </div>
      <!-- /.col -->
      <div class="col-sm-4 border-right">
        <div class="description-block">
          <h5 class="description-header"><i class="fa fa-map-marker"></i></h5>
          
          <span class="description-text">@if(!isset($user->country)) Location not updated @else
            {{ $user->city->name ?? '' .' , '. $user->state->name ?? '' .' , '. $user->country->nicename ?? '' }} @endif</span>
        </div>
        <!-- /.description-block -->
      </div>
      <!-- /.col -->
      @if($user->role_id == 'v')
      <div class="col-sm-4">
        <div class="description-block">
          <h5 class="description-header">{{ count($user->products) }}</h5>
          <span class="description-text">TOTAL PRODUCTS</span>
        </div>
        <!-- /.description-block -->
      </div>
      @else
      <div class="col-sm-4">
        <div class="description-block">
          <h5 class="description-header">USER ROLE</h5>
          <span class="description-text">@if($user->role_id == 'v') Seller @elseif($user->role_id == 'a' )Admin @else
            Customer @endif</span>
        </div>
        <!-- /.description-block -->
      </div>
      @endif
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <hr>
  <div class="box-body">
    <form method="post" enctype="multipart/form-data" action="{{url('admindesk/users/'.$user->id)}}">
      {{csrf_field()}}
      {{ method_field('PUT') }}
      <div class="row">

        <div class="col-md-6">
          <div class="form-group">
            <label>Username: <span class="required">*</span></label>
            <input type="text" class="form-control" placeholder="Enter username" name="name" value="{{$user->name}}">
            <small class="text-muted"><i class="fa fa-question-circle"></i> It will display the username eg.
              John</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Useremail: <span class="required">*</span></label>
            <input placeholder="Please enter email" type="email" name="email" value="{{$user->email}} "
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
                    name="phonecode" value="{{$user->phonecode}}" class="form-control">
                   
                </div>
              </div>

              <div class="col-md-10">
                <input required pattern="[0-9]+" title="Invalid mobile no." placeholder="Please enter mobile no." type="text"
                  name="mobile" value="{{$user->mobile}}" class="form-control">
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
              name="phone" value="{{$user->phone}}" class="form-control">
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
                     
                <option {{ $user->country_id ==  $c->id ? "selected" : "" }} value="{{$c->id}}" >
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
              @foreach($states as $c)
              <option value="{{$c->id}}" {{ $c->id == $user->state_id ? 'selected="selected"' : '' }}>
                {{$c->name}}
              </option>
              @endforeach
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
              @foreach($citys as $c)
              <option value="{{$c->id}}" {{ $c->id == $user->city_id ? 'selected' : '' }}>
                {{$c->name}}
              </option>
              @endforeach
            </select>
            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select city</small>
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group">
            <label>Website:</label>
            <input placeholder="http://" type="text" id="first-name" name="website" value="{{$user->website}}"
              class="form-control">
            <small class="text-muted"><i class="fa fa-question-circle"></i> Optional field ( You can leave it blank
              )</small>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>
              User Role: <span class="required">*</span>
            </label>
            <select name="role_id" class="form-control select2">
              <option value="u" <?php echo ($user->role_id=='u')?'selected':'' ?>>Customer</option>
              <option value="a" <?php echo ($user->role_id=='a')?'selected':'' ?>>Admin</option>
              <option value="v" <?php echo ($user->role_id=='v')?'selected':'' ?>>Seller</option>
            </select>
            <small class="text-muted"><i class="fa fa-question-circle"></i> Select user type eg. (Admin,Seller or
              Customer)</small>
          </div>
        </div>

        <div class="col-md-3">
          <label for="first-name">Choose Image:</label>
          <input type="file" name="image" class="form-control">
          <small class="text-muted"><i class="fa fa-question-circle"></i> Please select user profile picture</small>
        </div>

        <div class="col-md-1">
          <div class="background11 well">
            <div data-toggle="tooltip" data-placement="right" title="You current photo">
              @if($user->image !="")
              <img src=" {{url('images/user/'.$user->image)}} " class="img-circle margin-top-15 width-40px">
              @else
              <img title="{{ $user->name }}" class="img-circle width-40px"
                src="{{ Avatar::create($user->name)->toBase64() }}" />
              @endif
            </div>
          </div>
        </div>

        @if(env('ENABLE_SELLER_SUBS_SYSTEM') == 1)
          <div class="col-md-6">
            <div class="form-group">
              <label>Select seller plan:</label>
              <select name="seller_plan" class="form-control select2" data-placeholder="Please select plan" >
                <option value="">Please select seller plan</option>
                @foreach ($plans as $plan)
                    <option {{ $user->activeSubscription && $user->activeSubscription->plan->id == $plan->id ? "selected" : "" }} value="{{ $plan->id }}"> {{ $plan->name }} ({{ $defCurrency->currency->symbol.$plan->price }})</option>
                @endforeach
              </select>
            </div>
          </div>
        @endif

        <div class="col-md-6">
          <div class="form-group">
            <label>Status:</label>
            <input <?php echo ($user->status=='1')?'checked':'' ?> id="toggle-event3" type="checkbox"
              class="tgl tgl-skewed">
            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
            <input type="hidden" name="status" value="{{$user->status}}" id="status3">
            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select user status</small>
          </div>
        </div>

        @if($wallet_system == 1 )
        @if(isset($user->wallet))
        <div class="col-md-3">
          <div class="form-group">
            <label>Wallet:</label>
            <input <?php echo ($user->wallet->status=='1')?'checked':'' ?> id="wallet" type="checkbox"
              class="tgl tgl-skewed" name="wallet_status">
            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="wallet"></label>
            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select wallet status</small>
          </div>
        </div>
        @endif
        @endif

        <div class="col-md-12 form-group">

          <h4>
            <label><input type="checkbox" name="is_pass_change" class="is_pass_change" /> {{__("Change password ?")}}</label>
          </h4>
         
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="eyeCy">
                  <label for="password">Enter Password:</label>
                  <input disabled id="password" type="password" class="passwordbox form-control" placeholder="Enter password"
                    name="password" />

                  <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
              </div>

            </div>


            <div class="col-md-6">

              <div class="form-group">
                <div class="eyeCy">
                  <label for="confirm">Confirm Password:</label>
                  <input disabled id="confirm_password" type="password" class="passwordbox form-control"
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
      <a href="{{ route('users.index',['filter' => $user->role_id == 'v' ? "sellers" : ($user->role_id == 'a' ? 'admindesk' : 'customer') ]) }}" title="Go back" class="btn btn-md btn-default btn-flat">
        <i class="fa fa-arrow-left"></i> Back
      </a>
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