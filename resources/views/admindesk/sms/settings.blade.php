@extends('admindesk.layouts.master')
@section('title','SMS Settings | ')
@section('body')
<div class="box">
    <div class="box-header">
        <div class="box-title">
             SMS Channels
        </div>

       
    </div>

       

    <div class="box-body">

        <div class="form-group">
            <label>Enable : <span class="text-red">*</span></label>
            <br>
            <label class="switch">
                <input class="sms_enable" id="login_unicode" {{ $config->sms_channel == 1 ? "checked" : "" }} type="checkbox">
                <span class="knob"></span>
            </label>
        </div>

        <div id="mainsmsbox" style="display: {{ $config->sms_channel == 1 ? "block" : "none" }};">
            <div class="form-group">
                <label>Please select sms channel: <span class="text-red">*</span></label>
                <select data-placeholder="Please select sms channel" class="msg_channel form-control select2" name="DEFAULT_SMS_CHANNEL" id="msg_channel">
                    <option value="">Please select sms channel</option>
                    <option {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'selected' : '' }} value="twillo">Twillo</option>
                    <option {{ env('DEFAULT_SMS_CHANNEL') == 'msg91' ? 'selected' : '' }} value="msg91">MSG-91</option>
                </select>
            </div>
    
            <hr>
    
            <div style="display: {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'block' : 'none' }};" id="twilloBox">
    
                <div class="callout callout-success">
                    <i class="fa fa-info-circle"></i> Important note:
        
                    <ul>
                        <li>Twillo Only send SMS if user did not opt for DND Services.</li>
                        <li>
                            Twillo trail will send sms only to verified no.
                        </li>
                    </ul>
        
                    
                </div>
    
                <form action="{{ route('change.twilo.settings') }}" method="POST">
                    @csrf
                  <div class="row">
                      <div class="col-md-6">
                            <div class="form-group">
                                <label>TWILIO SID: <span class="text-red">*</span></label>
                                <input {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'required' : '' }} name="TWILIO_SID" type="text" value="{{ env('TWILIO_SID') }}" class="form-control">
                            </div>
                      </div>
                      <div class="col-md-6">
                         <div class="form-group">
                            <label>TWILIO AUTH TOKEN: <span class="text-red">*</span></label>
                            <input {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'required' : '' }} name="TWILIO_AUTH_TOKEN" type="text" value="{{ env('TWILIO_AUTH_TOKEN') }}" class="form-control">
                         </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>TWILIO NUMBER: <span class="text-red">*</span></label>
                            <input {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'required' : '' }} name="TWILIO_NUMBER" type="text" value="{{ env('TWILIO_NUMBER') }}" class="form-control">
                        </div>
                     </div>
    
                     <div class="col-md-12">
                         <button type="submit" class="btn btn-md btn-primary">
                            <i class="fa fa-save"></i> Save
                         </button>
                     </div>
                  </div>
                </form>
            </div>
    
            <div style="display: {{ env('DEFAULT_SMS_CHANNEL') == 'msg91' ? 'block' : 'none' }};" id="msg91Box">
                <div class="callout callout-success">
                    <i class="fa fa-info-circle"></i> Important note:
        
                    <ul>
                        <li>MSG91 Only send SMS if user did not opt for DND Services.</li>
                        <li>
                            If msg not delivering to customer than make sure he/she updated phonecode in his/her profile.
                        </li>
                    </ul>
        
                    
                </div>
        
                <form action="{{ route('sms.update.settings') }}" method="POST">
                    @csrf
        
                    <div class="row">
        
                        <div class="col-md-12">
                            <div class="form-group eyeCy">
                                <label>MSG91 Auth Key: <span class="text-red">*</span></label>
                                <input id="MSG91_AUTH_KEY" type="password" class="form-control"
                                    value="{{ env('MSG91_AUTH_KEY') }}" name="MSG91_AUTH_KEY">
                                <span toggle="#MSG91_AUTH_KEY" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>
        
                    </div>
        
        
        
                    @foreach ($settings as $row)
                    <h4>{{ucfirst( $row->key) }} SMS Settings:</h4>
                    <hr>
        
                    <input type="hidden" name="keys[{{ $row->id }}]" value="{{ $row->key }}">
        
                    <div class="row">
                        @if($row->key != 'orders')
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Message Text (MUST WITH PLACEHOLDER ##OTP##)<span class="text-red">*</span>:</label>
                                <input placeholder="eg. Your OTP code for login is ##OTP##" type="text" min="1" max="60"
                                    class="form-control" value="{{ $row->message ? $row->message : "" }}" name="message[{{ $row->id }}]">
                            </div>
                        </div>
                        @endif
        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Enter SENDER ID: (Max char length 6) <span class="text-red">*</span></label>
                                <input placeholder="eg. SMSIND" maxlength="6" type="text" class="form-control" value="{{ $row->sender_id ? $row->sender_id : "" }}"
                                    name="sender_id[{{ $row->id }}]">
                            </div>
                        </div>
        
                       @if($row->key != 'orders')
        
                       <div class="col-md-4">
                            <div class="form-group">
                                <label>MSG91 OTP Code Expiry (In Minutes): <span class="text-red">*</span></label>
                                <input type="text" class="form-control" value="{{ $row->otp_expiry ? $row->otp_expiry : "" }}" name="otp_expiry[{{ $row->id }}]">
                            </div>
                        </div>
        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>MSG91 OTP Code Length (Max:6): <span class="text-red">*</span></label>
                                <input type="number" min="4" max="6" class="form-control" value="{{ $row->otp_length ? $row->otp_length : 4 }}" name="otp_length[{{ $row->id }}]">
                            </div>
                        </div>
        
                       @endif
        
                       <div class="col-md-4">
        
                            <div class="form-group eyeCy">
                                <label>MSG91 Flow ID: <span class="text-red">*</span></label>
                                <input id="flow_id" type="password" class="form-control"
                                    value="{{ $row->flow_id }}" name="flow_id[{{$row->id}}]">
                                <span toggle="#flow_id" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
        
                       </div>
        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Enable emoji in Msg: <span class="text-red">*</span></label>
                                <br>
                                <label class="switch">
                                    <input id="login_unicode" {{ $row->unicode == 1 ? "checked" : "" }} type="checkbox" name="unicode[{{ $row->id }}]">
                                    <span class="knob"></span>
                                </label>
                            </div>
                        </div>
                        
                        
                    </div>
                    @endforeach
        
                    <div class="form-group">
                        <label for="">Enable MSG91 </label>
                        <br>
                        <label class="switch">
                            <input id="msg91_enable" {{ $configs->msg91_enable == 1 ? "checked" : "" }} type="checkbox" name="msg91_enable">
                            <span class="knob"></span>
                        </label>
                        <br>
                        <small class="text-muted">
                            <i class="fa fa-question-circle"></i> Toggle to activate the MSG-91.
                        </small>
                    </div>
        
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary">
                            <i class="fa fa-save"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-script')
   <script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
    <script>
        $('.msg_channel').on('change',function(){

            var val = $(this).val();

            if(val == 'twillo'){
                $('#twilloBox').show();
                $('#msg91Box').hide();
            }else if(val == 'msg91'){
                $('#twilloBox').hide();
                $('#msg91Box').show();
            }

            axios.post('{{ route("change.channel") }}',{
                channel : val
            }).then(res => {
                console.log(res.data);
            }).catch(err => console.log(err));

        });

        $(".sms_enable").on('change',function(){
            if($(this).is(":checked")){
                $('#mainsmsbox').show();
                axios.post('{{ route("change.channel") }}',{
                    enable : 1
                }).then(res => {
                    console.log(res.data);
                }).catch(err => console.log(err));
            }else{
                $('#mainsmsbox').hide();
                axios.post('{{ route("change.channel") }}',{
                    enable : 0
                }).then(res => {
                    console.log(res.data);
                }).catch(err => console.log(err));
            }
        })
    </script>
@endsection