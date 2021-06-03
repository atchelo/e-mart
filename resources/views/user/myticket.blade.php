@extends("front/layout.master")
@php
$user = Auth::user();
$sellerac = App\Store::where('user_id','=', $user->id)->first();
@endphp
@section('title',__('staticwords.MyTickets').' |')
@section("body")

<div class="container-fluid">

  <div class="row">
    <div class="col-xl-3 col-lg-12 col-sm-12">
      @include('user.sidebar')
    </div>






    <div class="col-xl-9 col-lg-12 col-sm-12">

      <div class="bg-white2">
        <h5 class="user_m2">My Tickets ({{ auth()->user()->ticket->count() }})</h5>
        <hr>

        <table class="table table-hover table-striped table-striped-two">
          <thead>
            <tr>
              <th>{{ __('Ticket No') }}.</th>
              <th>{{ __('Issue') }}</th>
              <th>{{ __('Status') }}</th>
              <th>{{ __('View') }}</th>
            </tr>
          </thead>
          @php
          $tickets = App\HelpDesk::where('user_id','=',Auth::user()->id)->latest()->paginate(10);
          @endphp
          <tbody>
            @foreach($tickets as $ticket)
            <tr>
              <td><span class="font-weight500 font-size-12">#{{ $ticket->ticket_no }}</span></td>
              <td>{{ $ticket->issue_title }}</td>
              <td>
                @if($ticket->status =="open")
                <p class="font-weight-bold"><span class="badge badge-secondary"><i class="fa fa-bullhorn"
                      aria-hidden="true"></i>
                    {{ ucfirst($ticket->status) }}</span></p>
                @elseif($ticket->status=="pending")
                <p class="font-weight-bold"> <span class="badge badge-primary"><i class="fa fa-clock-o"></i>
                    {{ ucfirst($ticket->status) }}</span></p>
                @elseif($ticket->status=="closed")
                <p class="font-weight-bold"><i class="fa fa-ban"></i> <span
                    class="badge badge-dark">{{ ucfirst($ticket->status) }}</span></p>
                @elseif($ticket->status=="solved")
                <p class="font-weight-bold"><span class="badge badge-success"><i class="fa fa-check"></i>
                    {{ ucfirst($ticket->status) }}</span></p>
                @endif
              </td>
              <td><a title="view" href="#ticket{{ $ticket->id }}" data-toggle="modal"><i class="fa fa-eye"></i></a></td>
            </tr>

            <div class="z-index99 modal fade" id="ticket{{ $ticket->id }}" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="myModal">@if($ticket->status =="open")
                      <p class="font-weight-bold"><i class="fa fa-bullhorn" aria-hidden="true"></i>
                        {{ ucfirst($ticket->status) }}</p>
                      @elseif($ticket->status=="pending")
                      <p class="font-weight-bold"><i class="fa fa-clock-o"></i> {{ ucfirst($ticket->status) }}</p>
                      @elseif($ticket->status=="closed")
                      <p class="font-weight-bold"><i class="fa fa-ban"></i> {{ ucfirst($ticket->status) }}</p>
                      @elseif($ticket->status=="solved")
                      <p class="font-weight-bold"><i class="fa fa-check"></i> {{ ucfirst($ticket->status) }}</p>
                      @endif #{{ $ticket->ticket_no }} {{ $ticket->issue_title }}
                    </h5>
                  </div>
                  <div class="modal-body">
                    {!! $ticket->issue !!}
                  </div>
                  <div class="modal-footer">

                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                      {{ __('Close') }}
                    </button>

                  </div>
                </div>
              </div>
            </div>
            @endforeach

            <!-- Modal -->


          </tbody>
        </table>
        <div align="center">
          {{ $tickets->links() }}
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