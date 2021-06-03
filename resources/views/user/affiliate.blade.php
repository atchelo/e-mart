@extends("front.layout.master")
@php
  $user = Auth::user();
  $sellerac = App\Store::where('user_id','=', $user->id)->first();
  require_once(base_path().'/app/Http/Controllers/price.php');
@endphp
@section('title',__('staticwords.AffiliateDB').' | ')
@section("body")

<div class="container-fluid">

  <div class="row">
    <div class="col-xl-3 col-lg-12 col-sm-12">
      @include('user.sidebar')
    </div>

    <div class="col-xl-9 col-lg-12 col-sm-12">

      <div class="bg-white2">
        <a href="#howitworks" data-toggle="modal" class="mt-2 h6 float-right">
            {{ __("staticwords.howitworks") }}
        </a>
        
        <h4 class="user_m2">{{ __('staticwords.AffiliateDB') }}</h4>
        
        <hr>
        <div class="shadow-sm mt-3 card text-center">
            <div class="card-body">
                <h3 class="card-title">
                    {{__("staticwords.referHeading")}}
                </h3>
                <p class="card-text">
                    {{__("staticwords.referdesc")}}
                </p>
                <div class="form-group">
                    <input type="text" readonly class="text-dark text-center form-control cptext" value="{{ route('register',['refercode' => auth()->user()->refer_code ]) }}">
                </div>
              <a href="#" class="copylink btn btn-primary">
                  {{ __("staticwords.CopyLink") }}
              </a>
            </div>
        </div>

       <div id="howitworks" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                   <div class="modal-body">
                    {!! $aff_system->about_system !!}
                   </div>
               </div>
           </div>
       </div>

        <div class="walletlogs">
       
          @if($aff_history->count())
        
          <hr>
          <h4 class="float-right">{{ __('Total earning') }}  <i class="{{ $defCurrency->currency_symbol }}"></i> {{ $earning }}  
            @if(isset($user->wallet) && $defCurrency->currency->code != session()->get('currency')['id'])
              <small class="text-primary font-size-12">
                <b>( <i class="{{ session()->get('currency')['value'] }}"></i> {{ sprintf("%.2f",currency($earning, $from = $defCurrency->currency->code, $to = session()->get('currency')['id'] , $format = false)) }})</b> 
              </small>
            @endif
          </h4>
          <h4>{{ __('staticwords.affhistory') }}</h4>
         
          <hr>

          @foreach($aff_history as $history)
         
          <h6>
            <span
              class="pull-right text-green""> {{ __('+') }}  <i class="{{ $defCurrency->currency_symbol }}"></i> {{ sprintf("%.2f",$history->amount,2) }}
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
              @if($history->procces == 0)
              
              <p class="text-white bg-secondary p-1 rounded w-25">
                {{ __("staticwords.Pending") }}
              </p>

              @else 
                <p class="text-white bg-success p-1 rounded w-25">{{ __("staticwords.creditedtowallet") }}</p>
              @endif
              
            </small>
          </h6>
          <hr>
          @endforeach
          @endif

          @if(isset($aff_history))
          <div class="mx-auto width200px">
            {!! $aff_history->links() !!}
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
@section('script')
    <script>
        $('.copylink').on('click', function () {
            $(this).text('Copied !');
            var copyText = $('.cptext').val();
            console.log(copyText);
            $('.cptext').select();
            document.execCommand("copy");
        });
    </script>
@endsection