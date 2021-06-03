@extends("front/layout.master")
@php
$user = Auth::user();
$sellerac = App\Store::where('user_id','=', $user->id)->first();
@endphp
@section('title',__('staticwords.MyBankAccounts').' | ')
@section("body")

<div class="preL display-none">
  <div class="loaderT display-none">
  </div>
</div>
<div class="container-fluid">

  <div class="row">
    <div class="col-md-12 col-xl-3">
      @include('user.sidebar')
    </div>






    <div class="col-md-12 col-xl-9">

      <div class="bg-white2 bg-white2-one">
        <a data-toggle="modal" data-target="#addnewbank" title="Add new bank account"
          class="text-white float-right btn btn-info">+ {{ __('staticwords.ADDNewbank') }}</a>
        <h5 class="user_m2">{{ __('staticwords.MyBankAccounts') }} ({{ auth()->user()->banks->count() }})</h5>

        <hr>

        <table class="table table-hover table-hoverone">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('A/C Holder Name') }}</th>
              <th>{{ __('Bank name') }}</th>
              <th>{{ __('IFSC Code') }}</th>
              <th>{{ __('A/C No') }}.</th>
              <th>{{ __('Action') }}</th>
            </tr>
          </thead>

          <tbody>
            @foreach(Auth::user()->banks as $key=> $bank)
            <tr>
              <td>
                {{ $key+1 }}
              </td>
              <td><span class="font-weight500 font-size-12 label label-md label-primary">{{ $bank->acname }}</span></td>
              <td>{{ $bank->bankname }}</td>
              <td>
                {{ $bank->ifsc }}
              </td>
              <td>
                {{ $bank->acno }}
              </td>
              <td>
                <div class="row">
                  <div class="col-md-2">
                    <button title="{{ __('Edit') }}" data-toggle="modal" data-target="#editbank{{ $bank->id }}"
                      type="button" class="btn btn-sm btn-success ">
                      <i class="fa fa-pencil"></i>
                    </button>
                  </div>
                  <div class="margin-left-5 col-md-2">
                    <button @if(env('DEMO_LOCK')==0) data-toggle="modal" data-target="#deletebank{{ $bank->id }}"
                      title="{{ __('Delete') }}" @else disabled="disabled" title="This action is disabled in demo !"
                      @endif class="btn btn-sm btn-danger ">
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </div>
              </td>
            </tr>


            @endforeach

            <!-- Modal -->


          </tbody>
        </table>
        <div align="center">

        </div>

      </div>
    </div>


  </div>

</div>

<!-- Modal for edit bank ac -->
@foreach(Auth::user()->banks as $key=> $bank)
<div data-backdrop="static" data-keyboard="false" id="editbank{{ $bank->id }}" class="z-index99 delete-modal modal fade"
  role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-heading">{{ $bank->bankname.' ('.$bank->acno.')' }}</h4>
      </div>
      <div class="modal-body">

        <form action="{{ route('user.bank.update',$bank->id) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>{{ __('Ac Holder Name') }} <span class="required">*</span></label>
            <input value="{{ $bank->acname }}" required="" type="text" class="form-control" name="acname">
            <div class="required">{{$errors->first('acname')}}</div>
          </div>

          <div class="form-group">
            <label>{{ __('Bank Name') }}: <span class="required">*</span></label>
            <input value="{{ $bank->bankname }}" required="" type="text" class="form-control" name="bankname">
            <div class="required">{{$errors->first('bankname')}}</div>
          </div>

          <div class="form-group">
            <label>{{ __('Account No') }}.: <span class="required">*</span></label>
            <input pattern="[0-9]+" value="{{ $bank->acno }}" required="" type="text" class="form-control" name="acno">
            <div class="required">{{$errors->first('acno')}}</div>
          </div>

          <div class="form-group">
            <label>{{ __('IFSC Code') }}: <span class="required">*</span></label>
            <input value="{{ $bank->ifsc }}" required="" type="text" class="form-control" name="ifsc">
            <div class="required">{{$errors->first('ifsc')}}</div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          {{ __('Close') }}
        </button>
        <button @if(env('DEMO_LOCK')==0) type="submit" @else title="This action is disabled in demo !"
          disabled="disabled" @endif class="btn btn-primary">
          {{ __('Save') }}
        </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
<!--end-->

<!-- Modal for delete bank ac -->
@foreach(Auth::user()->banks as $key=> $bank)
<div id="deletebank{{ $bank->id }}" class="z-index99 delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h5 class="modal-heading">
          {{ __('Are You Sure ?') }}
        </h5>
        <p>{{ __('Do you really want to delete this bank account') }} <b>{{ $bank->bankname }}</b>?
          {{ __('This process cannot be undone') }}.</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{route('user.bank.delete',$bank->id)}}" class="pull-right">
          {{csrf_field()}}
          {{method_field("DELETE")}}
          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">
            {{ __('No') }}
          </button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
<!--end-->

<!-- Modal for adding bank ac -->
<div data-backdrop="static" data-keyboard="false" class="z-index99 modal fade" id="addnewbank" tabindex="-1"
  role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog model-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">
          {{ __('Add New Bank Ac') }}
        </h5>
      </div>
      <div class="modal-body">
        <form action="{{ route('user.bank.add') }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="font-weight-bold">{{ __('Ac Holder Name') }}: <span class="required">*</span></label>
            <input value="{{ old('acname') }}" required="" type="text" class="form-control" name="acname">
            <div class="required">{{$errors->first('acname')}}</div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">{{ __('Bank Name') }}: <span class="required">*</span></label>
            <input value="{{ old('bankname') }}" required="" type="text" class="form-control" name="bankname">
            <div class="required">{{$errors->first('bankname')}}</div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">{{ __('Account No') }}.: <span class="required">*</span></label>
            <input pattern="[0-9]+" value="{{ old('acno') }}" required="" type="text" class="form-control" name="acno">
            <div class="required">{{$errors->first('acno')}}</div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">{{ __('IFSC Code') }}: <span class="required">*</span></label>
            <input value="{{ old('ifsc') }}" required="" type="text" class="form-control" name="ifsc">
            <div class="required">{{$errors->first('ifsc')}}</div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          {{ __('Close') }}
        </button>
        <button type="submit" class="btn btn-primary">
          {{ __('staticwords.Save') }}
        </button>
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
<script src="{{ url('js/profile.js') }}"></script>
<script src="{{ url('js/bank.js') }}"></script>
@endsection