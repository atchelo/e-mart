@extends("front/layout.master")
@php
  $user = Auth::user();
  $sellerac = App\Store::where('user_id','=', $user->id)->first();
  require_once(base_path().'/app/Http/Controllers/price.php');
@endphp
@section('title',__('staticwords.MyWallet').' | ')
@section("body")

<div class="container-fluid">

  <div class="row">
    <div class="col-xl-3 col-lg-12 col-sm-12">
      @include('user.sidebar')
    </div>

    <div class="col-xl-9 col-lg-12 col-sm-12">

      <div class="bg-white2">

        <h4 class="user_m2">{{ __('staticwords.MyWallet') }}</h4>
        <h4 class="user_m2 text-green">{{ __('staticwords.CurrentBalance') }} :
          <i class="{{ $defCurrency->currency_symbol }}"></i>
           @if(isset($user->wallet))
          {{ sprintf("%.2f",$user->wallet->balance) }} @else 0.00 @endif 
          @if(isset($user->wallet) && $defCurrency->currency->code != session()->get('currency')['id'])

          <small class="text-primary font-size-14">
            <b>( <i class="{{ session()->get('currency')['value'] }}"></i> {{ sprintf("%.2f",currency($user->wallet->balance, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }}) </b> {{ __('staticwords.amountinyourcurrency') }}</small>

          @endif
        </h4>
          <hr>
        <div class="row">




          <div class="col-6">

            <form id="mainform" action="{{ route('wallet.choose.paymethod') }}" method="POST">
              @csrf

              <div class="input-group">
                <span class="input-group-addon wallet-cur-symbol" id="basic-addon1">
                  <i class="{{ $defCurrency->currency_symbol }}"></i>
                </span>
                <input name="amount" required="" type="number" class="amountbox form-control" value="1.00"
                  placeholder="0.00" min="1" step="0.01" aria-describedby="basic-addon1">
              </div>
              <br>
              <div>


                <button type="submit" class="pull-left btn btn-primary">
                  {{ __('staticwords.proccedtopay') }}...
                </button>


              </div>

            </form>

          </div>

          <div class="col-6">

            <p class="text-muted">
              <i class="fa fa-lock"></i> {{ __('staticwords.moneynonrefundable') }}.
            </p>

            <p class="text-muted">
              <i class="fa fa-star"></i> {{ __('staticwords.usepoint') }}.
            </p>

            <p class="text-muted">
              <i class="fa fa-info-circle"></i> {{ __('staticwords.expirepoint') }}.
            </p>

            <p class="text-muted">
              <i class="fa fa-info-circle"></i> {{ __('staticwords.walletamounote') }}  <b>{{ $defCurrency->currency->code }}</b>
            </p>
          </div>


        </div>

        <div class="walletlogs">
          @if(isset($wallethistory))
          <hr>
          <h4>{{ __('staticwords.WalletHistory') }}</h4>
          <hr>

          @foreach($wallethistory->sortByDesc('id') as $history)

          <h6>
            <span
              class="pull-right {{ $history->type == 'Credit' ? "text-green" : "text-red" }}"> @if($history->type == 'Credit') {{ __('+') }} @else {{ __('-') }} @endif <i class="{{ $defCurrency->currency_symbol }}"></i> {{ sprintf("%.2f",$history->amount,2) }}
              @if(isset($user->wallet) && $defCurrency->currency->code != session()->get('currency')['id'])
              <small class="text-primary font-size-12">
                <br>
                <b>( <i class="{{ session()->get('currency')['value'] }}"></i> {{ sprintf("%.2f",currency($history->amount, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }})</b> 
              </small>
              @endif
            </span>
            {{ $history->log }}
            <br>
            <small class="text-muted font-size-12 wallet-log-history-block">
              @if($history->type == 'Credit')
              <b>{{ __('staticwords.CreditedON') }}: </b> {{ date('d/m/Y | h:i A',strtotime($history->created_at)) }} |
              <b>{{ __('Ref ID:') }}</b> {{ $history->txn_id }} | <b>{{ __('Expire ON:') }}</b>
              {{ date('d/m/Y | h:i A',strtotime($history->expire_at)) }}
              @else
              <b>{{ __('staticwords.DebitedON') }}: </b> {{ date('d/m/Y | h:i A',strtotime($history->created_at)) }} |
              <b>{{ __('Ref ID:') }}</b> {{ $history->txn_id }}
              @endif
            </small>
          </h6>
          <hr>
          @endforeach
          @endif

          @if(isset($wallethistory))
          <div class="mx-auto width200px">
            {!! $wallethistory->links() !!}
          </div>
          @endif
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ __('staticwords.ChangePassword') }} ?</h5>
      </div>
      <div class="modal-body">
        <form id="form1" action="{{ route('pass.update',$user->id) }}" method="POST">
          {{ csrf_field() }}

          <div class="form-group eyeCy">
           
              
          <label class="font-weight-bold" for="confirm">{{ __('staticwords.Oldpassword') }}:</label>
          <input required="" type="password" class="form-control @error('old_password') is-invalid @enderror" placeholder="{{ __('staticwords.Enteroldpassword') }}" name="old_password" id="old_password" />
          
          <span toggle="#old_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

          @error('old_password')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>



          <div class="form-group eyeCy">
         

            
               <label class="font-weight-bold" for="password">{{ __('staticwords.EnterPassword') }}:</label>
                <input required="" id="password" min="6" max="255" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('staticwords.EnterPassword') }}" name="password" minlength="8"/>
              
               <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            
             @error('password')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
         
          
          </div>

          
          
          <div class="form-group eyeCy">
           
              
                <label class="font-weight-bold" for="confirm">{{ __('staticwords.ConfirmPassword') }}:</label>
          <input required="" id="confirm_password" type="password" class="form-control" placeholder="{{ __('staticwords.re-enter-password') }}" name="password_confirmation" minlength="8"/>
          
          <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

           <p id="message"></p>
          </div>
          

          <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="disabled" title="This action is disabled in demo !" @endif id="test" class="btn btn-md btn-success"><i class="fa fa-save"></i> {{ __('staticwords.SaveChanges') }}</button>
          <button id="btn_reset" data-dismiss="modal" class="btn btn-danger btn-md" type="reset">X {{ __('staticwords.Cancel') }}</button>
        </form>
        
      </div>
      
    </div>
  </div>
</div>

@endsection