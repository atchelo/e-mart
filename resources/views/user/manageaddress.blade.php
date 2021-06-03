@extends("front.layout.master")
@php
$sellerac = App\Store::where('user_id','=', $user->id)->first();
@endphp
@section('title',__('staticwords.ManageAddress').' | ')
@section("body")

<div class="container-fluid">

  <div class="row">
    <div class="col-lg-12 col-xl-3 col-sm-12">
      @include('user.sidebar')
    </div>




    <div class="col-xl-9 col-lg-12 col-sm-12">

      <div class="bg-white2 bg-white2-one">
        <button data-toggle="modal" data-target="#mngaddress" title="{{ __('staticwords.AddNew') }}"
          class="pull-right btn btn-md btn-primary">+ {{ __('staticwords.AddNew') }}</button>
        <h5 class="user_m2 ">{{ __('staticwords.ManageAddress') }}</h5>

        <hr>
        @if(count($user->addresses)>0)

        <div class="row">


          @foreach($user->addresses as $address)

          @php
          $c = App\Allcountry::where('id',$address->country_id)->first()->nicename;
          $s = App\Allstate::where('id',$address->state_id)->first()->name;
          $ci = App\Allcity::where('id',$address->city_id)->first() ?
          App\Allcity::where('id',$address->city_id)->first()->name : '';
          @endphp



          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-1 box">



              <div class="{{ $address->defaddress == 1 ? "activedef" : "user-header" }}">



                <h5><b>{{$address->name}}, {{ $address->phone }}</b></h5>

                @if($address->defaddress == 1)
                <div class="ribbon ribbon-top-right"><span>{{ __('Default') }}</span></div>
                @endif



              </div>

              <div class="card-body">

                <p>{{ strip_tags($address->address) }}, {{ $ci }}, {{ $s }}, {{ $c }}@if (isset($address->pin_code)),
                  ({{ $address->pin_code }}) @endif</p>

                <button title="{{ __('Edit Address') }}" data-toggle="modal" data-target="#editModal{{ $address->id }}"
                  class="editlabel btn btn-sm btn-info">
                  <i class="fa fa-pencil"></i>
                </button>

                <button title="{{ __('Delete Address') }}" type="button" @if(env('DEMO_LOCK')==0) data-toggle="modal"
                  data-target="#deletemodal{{ $address->id }}" @else disabled=""
                  title="This action is disabled in demo !" @endif class="delbtn btn btn-danger btn-sm"><i
                    class="fa fa-trash"></i></button>

                <br><br>

              </div>

            </div>
          </div>





          <!--Edit Modal-->
          <div data-backdrop="static" data-keyboard="false" class="modal fade" id="editModal{{ $address->id }}"
            tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                      aria-hidden="true">&times;</span></button>
                  <h5 class="modal-title" id="myModalLabel">{{ __('Edit Address') }}</h5>
                </div>
                <div class="modal-body">
                  <form action="{{ route('address.update',$address->id) }}" role="form" method="POST">
                    @csrf

                    <label class="font-weight-bold" class="font-weight-normal" for="name">{{ __('staticwords.Name') }}:
                      <span class="required">*</span></label>
                    <input required="" name="name" type="text" value="{{ $address->name }}"
                      placeholder="{{ __('edit name') }}" class="form-control">
                    <br>
                    <label class="font-weight-bold" class="font-weight-normal"
                      for="email">{{ __('staticwords.Email') }}: <span class="required">*</span></label>
                    <input type="email" placeholder="Edit Email" class="form-control" name="{{ __('email') }}"
                      value="{{ $address->email }}">
                    <br>
                    <label class="font-weight-bold" class="font-weight-normal"
                      for="email">{{ __('staticwords.PhoneNo') }}: <span class="required">*</span></label>
                    <input pattern="[0-9]+" type="text" placeholder="Edit Phone no" class="form-control"
                      name="{{ __('phone') }}" value="{{ $address->phone }}">
                    <br>
                    <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.Address') }}: <span
                        class="required">*</span></label>
                    <textarea required="" name="address" id="address" cols="20" rows="5"
                      class="form-control">{{ strip_tags($address->address) }}</textarea>
                    <br>

                    @if ($pincodesystem == 1)
                    <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.Pincode') }}: <span
                        class="required">*</span> </label>
                    <input pattern="[0-9]+" required value="{{ $address->pin_code }}"
                      onkeyup="pincodetry('{{ $address->id }}')" type="text" id="pincode{{ $address->id }}"
                      class="form-control z-index99" name="pin_code">
                    <br>
                    @endif

                    <div class="row">
                      <div class="col-md-4">

                        <div class="form-group">
                          <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.Country') }}
                            <small class="required">*</small></label>
                          <select required="" onchange="getstate('{{ $address->id }}')" name="country_id"
                            class="form-control" id="edit_country_id{{ $address->id }}">
                            <option>{{ __('staticwords.PleaseChooseCountry') }}</option>
                            @foreach($country as $c)
                            <?php
                          $iso3 = $c->country;

                          $country_name = DB::table('allcountry')->where('iso3',$iso3)->first();
                          ?>
                            <option value="{{$country_name->id}}"
                              {{ $country_name->id == $address->country_id ? 'selected="selected"' : '' }}>
                              {{$country_name->nicename}}
                            </option>
                            @endforeach
                          </select>
                        </div>

                      </div>

                      <div class="col-md-4">
                        <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.State') }} <small
                            class="required"></small></label>
                        <select required="" onchange="getcity('{{ $address->id }}')" name="state_id"
                          class="form-control" id="upload_id{{ $address->id }}">

                          @php
                          $findcon = App\Allcountry::find($address->country_id);
                          @endphp

                          <option value="">{{ __('staticwords.PleaseChooseState') }}</option>
                          @foreach($findcon->states as $state)
                          <option value="{{$state->id}}"
                            {{ $state->id == $address->state_id ? 'selected="selected"' : '' }}>
                            {{$state->name}}
                          </option>
                          @endforeach
                        </select>
                      </div>



                      <div class="col-md-4">
                        <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.City') }} <small
                            class="required">*</small></label>

                        <select required="" name="city_id" id="city_id{{ $address->id }}" class="form-control">
                          <option value="">{{ __('staticwords.PleaseChooseCity') }}</option>

                          @foreach($city = App\Allcity::where('state_id',$address->state_id)->get() as $cit)
                          <option value="{{$cit->id}}" {{ $cit->id == $address->city_id ? 'selected' : '' }}>
                            {{ $cit->name }}
                          </option>
                          @endforeach
                        </select>
                        <br>

                        <label class="font-weight-bold" class="font-weight-normal" class="pull-left">
                          <input {{ $address->defaddress == 1 ? "checked" : "" }} type="checkbox" name="setdef">
                          {{ __('staticwords.SetDefaultAddress') }}
                        </label>


                      </div>

                      <div class="col-md-12">
                        <button class="btn btn-primary"><i class="fa fa-save"></i>
                          {{ __('staticwords.Update') }}</button>
                      </div>

                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="deletemodal{{ $address->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="delete-icon"></div>
                </div>
                <div class="modal-body text-center">
                  <h5 class="modal-heading">{{ __('Are You Sure ?') }}</h5>
                  <p>{{ __('Do you really want to delete this address? This process cannot be undone') }}.</p>
                </div>
                <div class="modal-footer">
                  <form method="post" action="{{route('address.del',$address->id)}}" class="pull-right">
                    {{csrf_field()}}
                    {{method_field("DELETE")}}
                    <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">
                      {{ __('No') }}
                    </button>
                    <button type="submit" class="btn btn-danger">
                      {{ __('Yes') }}
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          @endforeach
        </div>

        @else
        <h2><a class="cursor" data-target="#mngaddress" data-toggle="modal">{{ __('staticwords.addressnot') }}</a>
        </h2>

        @endif

      </div>
    </div>


  </div>

</div>

<!-- Modal -->
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="mngaddress" tabindex="-1" role="dialog"
  aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">{{ __('staticwords.AddNew') }}</h5>
      </div>
      <div class="modal-body">
        <form action="{{ route('address.store') }}" role="form" method="POST">
          @csrf

          @php
          $ifadd = count(Auth::user()->addresses);
          @endphp

          <div class="form-group">
            <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.Name') }}:</label>
            <input required type="text" @if($ifadd<1) value="{{ Auth::user()->name }}" @else value="" @endif
              placeholder="{{ __('Enter name') }}" name="name" class="form-control">
          </div>

          <div class="form-group">
            <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.PhoneNo') }}:</label>
            <input pattern="[0-9]+" required type="text" @if($ifadd<1) value="{{ Auth::user()->mobile }}" @else value=""
              @endif name="phone" placeholder="{{ __('Enter phone no') }}" class="form-control">
          </div>

          <div class="form-group">
            <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.Email') }}:</label>
            <input required type="email" value="{{ Auth::user()->email }}" name="email"
              placeholder="{{ __('Enter email') }}" class="form-control">
          </div>

          <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.Address') }}: </label>
          <textarea required name="address" id="address" cols="20" rows="5"
            class="form-control">{{ old('address') }}</textarea>
          <br>

          @if($pincodesystem == 1)
          <label class="font-weight-bold" class="font-weight-normal">{{ __('Zipcode') }}/
            {{ __('staticwords.Pincode') }}: <span class="required">*</span> </label>
          <input pattern="[0-9]+" value="{{ old('pin_code') }}" placeholder="{{ __('Enter pin code') }}" type="text"
            id="pincode" class="form-control z-index99" name="pin_code">
          <br>
          @endif

          <div class="row">
            <div class="col-md-4">

              <div class="form-group">
                <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.Country') }} <small
                    class="required">*</small></label>
                <select required name="country_id" class="form-control" id="country_id">
                  <option value="">{{ __('staticwords.PleaseChooseCountry') }}</option>
                  @foreach($country as $c)
                  <?php
                          $iso3 = $c->country;

                          $country_name = DB::table('allcountry')->where('iso3',$iso3)->first();
                          ?>
                  <option value="{{$country_name->id}}">
                    {{$country_name->nicename}}
                  </option>
                  @endforeach
                </select>
              </div>

            </div>

            <div class="col-md-4">
              <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.State') }} <small
                  class="required"></small></label>
              <select required name="state_id" class="form-control" id="upload_id">

                <option value="">{{ __('staticwords.PleaseChooseState') }}</option>

              </select>
            </div>

            <div class="col-md-4">
              <label class="font-weight-bold" class="font-weight-normal">{{ __('staticwords.City') }} <small
                  class="required">*</small></label>


              <select required name="city_id" id="city_id" class="form-control">
                <option value="">{{ __('staticwords.PleaseChooseCity') }}</option>

              </select>
              <br>
              <label class="font-weight-bold" class="font-weight-normal" class="pull-left">
                <input type="checkbox" name="setdef">
                {{ __('staticwords.SetDefaultAddress') }}
              </label>
            </div>

            <div class="col-md-12">
              <button class="btn btn-primary"><i class="fa fa-plus"></i> {{ __('staticwords.ADD') }}</button>
            </div>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>


<!-- Change password Modal -->
<div class="z-index99 modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ __('staticwords.ChangePassword') }} ?</h5>
      </div>
      <div class="modal-body">
        <form id="form1" action="{{ route('pass.update',$user->id) }}" method="POST">
          {{ csrf_field() }}

          <div class="form-group eyeCy">


            <label class="font-weight-bold" for="confirm">{{ __('staticwords.Oldpassword') }}:</label>
            <input required="" type="password" class="form-control @error('old_password') is-invalid @enderror"
              placeholder="{{ __('staticwords.Enteroldpassword') }}" name="old_password" id="old_password" />

            <span toggle="#old_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

            @error('old_password')
            <span class="invalid-feedback text-danger" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>



          <div class="form-group eyeCy">



            <label class="font-weight-bold" for="password">{{ __('staticwords.EnterPassword') }}:</label>
            <input required="" id="password" min="6" max="255" type="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="{{ __('staticwords.EnterPassword') }}" name="password" minlength="8" />

            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

            @error('password')
            <span class="invalid-feedback text-danger" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror


          </div>



          <div class="form-group eyeCy">


            <label class="font-weight-bold" for="confirm">{{ __('staticwords.ConfirmPassword') }}:</label>
            <input required="" id="confirm_password" type="password" class="form-control"
              placeholder="{{ __('staticwords.re-enter-password') }}" name="password_confirmation" minlength="8" />

            <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

            <p id="message"></p>
          </div>


          <button @if(env('DEMO_LOCK')==0) type="submit" @else title="disabled"
            title="This action is disabled in demo !" @endif id="test" class="btn btn-md btn-success"><i
              class="fa fa-save"></i> {{ __('staticwords.SaveChanges') }}</button>
          <button id="btn_reset" data-dismiss="modal" class="btn btn-danger btn-md" type="reset">X
            {{ __('staticwords.Cancel') }}</button>
        </form>

      </div>

    </div>
  </div>
</div>


@endsection

@section('script')
<script>
  var baseUrl = "<?= url('/') ?>";
</script>
<script src="{{ url('js/ajaxlocationlist.js') }}"></script>
<script>
  var findpincodeurl = {
    !!json_encode(route('findpincode')) !!
  };
  var choosestateurl = {
    !!json_encode(url('/choose_state')) !!
  };
  var choosecityurl = {
    !!json_encode(url('/choose_city')) !!
  };
</script>
<script src="{{url('js/address.js')}}"></script>
@endsection