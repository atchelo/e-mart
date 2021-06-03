@extends("front/layout.master")
@php
$user = Auth::user();
$sellerac = App\Store::where('user_id','=', $user->id)->first();
@endphp
@section('title',__('staticwords.MyFailedTrancations').' | ')
@section("body")

<div class="container-fluid">

  <div class="row">
    <div class="col-xl-3 col-lg-12 col-sm-12">
      @include('user.sidebar')
    </div>







    <div class="col-xl-9 col-lg-12 col-sm-12">

      <div class="bg-white2">
        <h5 class="user_m2">{{ __('staticwords.MyFailedTranscations') }} ({{ auth()->user()->failedtxn->count() }})</h5>
        <hr>
        <div class="table-responsive">
          <table class="table table-striped filed-block">
            <thead>
              <th>#</th>
              <th>{{ __('TXN ID') }}</th>
              <th>{{ __('Time') }}</th>
            </thead>

            <tbody>
              @foreach($failedtranscations as $key=> $ftxn)
              <tr>
                <td>{{ $key+1 }}</td>
                <td><b>{{ $ftxn->txn_id }}</b></td>
                <td>{{ date('d-m-Y h:i A',strtotime($ftxn->created_at)) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mx-auto" style="width:200px">
          {!! $failedtranscations->links() !!}
        </div>


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
@endsection