@extends('admindesk.layouts.master')
@section('title','Push Notification Manager | ')
@section('body')
   <div class="row">
       <div class="col-md-8">
        <div class="box">
            <div class="box-header">
                <div class="box-title">
                    {{__("Push Notification Manager")}} 
                </div>
            </div>
    
            <div class="box-body">
                <form action="{{ route('admindesk.push.notif') }}" method="POST">
                    @csrf
    
                    <div class="form-group">
                        <label for="">Select User Group: <span class="text-danger">*</span> </label>
    
                        <select required data-placeholder="Please select user group" name="user_group" id="" class="select2 form-control">
                            <option value="">Please select user group</option>
                            <option {{ old('user_group') == 'all_customers' ? "selected" : "" }} value="all_customers">All Customers</option>
                            <option {{ old('user_group') == 'all_sellers' ? "selected" : "" }} value="all_sellers">All Sellers</option>
                            <option {{ old('user_group') == 'all_admins' ? "selected" : "" }} value="all_admins">All Admins</option>
                            <option {{ old('user_group') == 'all' ? "selected" : "" }} value="all">All Users (Seller + Customers + Admins)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Subject: <span class="text-red">*</span></label>
                        <input placeholder="Hey ! New stock arrived !" type="text" class="form-control" required name="subject" value="{{ old('subject') }}">
                    </div>

                    <div class="form-group">
                        <label for="">Notification Body: <span class="text-red">*</span> </label>
                        <textarea required placeholder="Hey I want to tell you something awesome thing !" class="form-control" name="message" id="" cols="3" rows="5">{{ old('message') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Target URL: </label>
                        <input value="{{ old('target_url') }}" class="form-control" name="target_url" type="url" placeholder="{{ url('/') }}">
                        <small class="text-muted">
                            <i class="fa fa-question-circle"></i> On click of notification where you want to redirect the user.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="">Notification Icon: </label>
                        <input value="{{ old('icon') }}" name="icon" class="form-control" type="url" placeholder="https://someurl/icon.png">
                        <small class="text-muted">
                            <i class="fa fa-question-circle"></i> If not enter than default icon will use which you upload at time of create one signal app.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="">Image: </label>
                        <input value="{{ old('image') }}" class="form-control" name="image" type="url" placeholder="https://someurl/image.png">
                        <small class="text-muted">
                            <i class="fa fa-question-circle"></i> <b>Recommnaded Size: 450x228 px.</b>
                        </small>
                    </div>

                    <div class="from-group">
                        <label for="">Show Button: </label>
                        <br>
                        <label class="switch">
                            <input {{ old('show_button') ? "checked" : "" }} class="show_button" type="checkbox" name="show_button">
                            <span class="knob"></span>
                        </label>
                    </div>

                    <div style="display: {{ old('show_button') ? 'block' : 'none' }};" id="buttonBox">
                        <div class="form-group">
                            <label for="">Button Text:  <span class="text-danger">*</span></label>
                            <input value="{{ old('btn_text') }}" class="form-control" name="btn_text" type="text" placeholder="Grab Now !">
                        </div>

                        <div class="form-group">
                            <label for="">Button Target URL: </label>
                            <input value="{{ old('btn_url') }}" class="form-control" name="btn_url" type="url" placeholder="https://someurl/image.png">
                            <small class="text-muted">
                                <i class="fa fa-question-circle"></i> On click of button where you want to redirect the user.
                            </small>
                        </div>
                    </div>

                    <div class="from-group">
                        <button type="submit" class="btn btn-block btn-md btn-success">
                            <i class="fa fa-location-arrow"></i> Send
                        </button>
                    </div>
    
                </form>
            </div>
        </div>
       </div>

       <div class="col-md-4">
           <div class="box">
               <div class="box-header">
                   <div class="box-title">
                        Onesignal Keys
                   </div>

                   <a title="Get one signal keys" href="https://onesignal.com/" class="pull-right" target="__blank">
                       <i class="fa fa-key"></i> Get your keys from here
                   </a>
               </div>

               <div class="box-body">
                   
                <form action="{{ route('admindesk.onesignal.keys') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="eyeCy">

                            <label for="ONESIGNAL_APP_ID"> ONESIGNAL APP ID: <span class="text-danger">*</span></label>
                            <input type="password" value="{{ env('ONESIGNAL_APP_ID') }}"
                                name="ONESIGNAL_APP_ID" placeholder="Enter ONESIGNAL APP ID " id="ONESIGNAL_APP_ID" type="password"
                                class="form-control">
                            <span toggle="#ONESIGNAL_APP_ID"
                                class="fa fa-fw fa-eye field-icon toggle-password"></span>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="eyeCy">

                            <label for="ONESIGNAL_REST_API_KEY"> ONESIGNAL REST API KEY: <span class="text-danger">*</span></label>
                            <input type="password" value="{{ env('ONESIGNAL_REST_API_KEY') }}"
                                name="ONESIGNAL_REST_API_KEY" placeholder="Enter ONESIGNAL REST API KEY " id="ONESIGNAL_REST_API_KEY" type="password"
                                class="form-control">
                            <span toggle="#ONESIGNAL_REST_API_KEY"
                                class="fa fa-fw fa-eye field-icon toggle-password"></span>

                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-md">
                           <i class="fa fa-save"></i> Save Keys
                        </button>
                    </div>
                </form>

               </div>
           </div>
       </div>
   </div>
@endsection
@section('custom-script')
    <script>
        $('.show_button').on('change',function(){

            if($(this).is(":checked")){
                $('input[name=btn_text]').attr('required','required');
                $('#buttonBox').show('fast');
            }else{
                $('input[name=btn_text]').removeAttr('required');
                $('#buttonBox').hide('fast');
            }

        });
    </script>
@endsection