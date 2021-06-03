@extends("admindesk/layouts.master")
@section('title',"Mail Settings |")
@section("body")
      <div class="box">
          <div class="box-header with-border">
              <div class="box-title">Mail Settings</div>
              <a title="Click to know more" href="#help" data-toggle="modal" class="pull-right">
                <i class="fa fa-question-circle"></i> Help
              </a>
          </div>

          <div class="box-body">
              <form action="{{ route('mail.update') }}" method="POST">
                    {{ csrf_field() }}
                    @csrf
                <div class="row">
                     <div class="col-md-6">
                     <div class="form-group">
                         <label for="MAIL_FROM_NAME">Sender Name:</label>
                     <input type="text" placeholder="Enter sender name" name="MAIL_FROM_NAME"  value="{{ $env_files['MAIL_FROM_NAME'] }}"  class="form-control">
                     </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group"><label for="MAIL_DRIVER">Mail Driver: (ex. smtp,sendmail,mail)</label>
                    <input type="text" name="MAIL_DRIVER" value="{{ $env_files['MAIL_DRIVER'] }}" class="form-control"></div>
                </div>

                 <div class=" col-md-6">
                    <div class="form-group">
                        <label for="MAIL_DRIVER">Mail Address: (ex. user@info.com)</label>
                    <input type="text" name="MAIL_FROM_ADDRESS" value="{{ $env_files['MAIL_FROM_ADDRESS'] }}" class="form-control">
                    </div>
                </div>

                <div class=" col-md-6">
                   <div class="form-group">
                        <label for="MAIL_HOST">Mail Host: (ex. smtp.gmail.com)</label>
                        <input placeholder="Enter mail host" type="text" name="MAIL_HOST" value="{{ $env_files['MAIL_HOST'] }}" class="form-control">
                   </div>
                </div>

                  <div class=" col-md-6">
                    <div class="form-group">
                        <label for="MAIL_PORT">Mail PORT: (ex. 467,587,2525) </label>
                        <input type="text" placeholder="Enter mail port" name="MAIL_PORT" value="{{ $env_files['MAIL_PORT'] }}" class="form-control">
                    </div>
                </div>

                <div class=" col-md-6">
                   <div class="form-group">
                        <label for="MAIL_USERNAME">Mail Username: (info@gmail.com)</label>
                        <input placeholder="Enter mail Username" type="text" name="MAIL_USERNAME" value="{{ $env_files['MAIL_USERNAME'] }}" class="form-control">
                   </div>
                </div>

                 <div class=" col-md-6">
                    <div class="eyeCy">
                        <label for="MAIL_PASSWORD">Mail Password:</label>
                    <input type="password" value="{{ $env_files['MAIL_PASSWORD'] }}" name="MAIL_PASSWORD" id="password-field" type="password" placeholder="Please Enter Mail Password" class="form-control">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> 
                    </div>
                   
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="MAIL_ENCRYPTION">Mail Encryption: (ex. TLS,SSL,OR Leave blank)</label>
                        <input placeholder="Enter mail encryption" type="text" value="{{ $env_files['MAIL_ENCRYPTION'] }}" name="MAIL_ENCRYPTION" class="form-control"> 
                    </div>
                    
                </div>


                </div>

                 <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="This action is disabled in demo !" @endif class="btn btn-md btn-success">
                            <i class="fa fa-save"></i> Save Settings
                        </button>
              </form>
          </div>
      </div>

      <!-- Modal -->
<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Help ?</h4>
      </div>
      <div class="modal-body">
        <p>For Mail Detail Section: Enter the name with no spaces. Their are three Mail Drivers: <b>SMTP, Mail, sendmail, if SMTP is not working then check sendmail.</b></p>
        
        <blockquote>
          <ul>
            <li>Gmail SMTP setup settings:</li>
            <li>SMTP username: Your Gmail address.</li>
            <li>SMTP password: Your Gmail password. If Using Gmail then Use App Password. <a href="https://support.google.com/accounts/answer/185833?hl=en">Process of App Password</a>.</li>
            <li>SMTP server address: smtp.gmail.com.</li>
            <li>Gmail SMTP port (TLS): 587.</li>
            <li>SMTP port (SSL): 465.</li>
            <li>SMTP TLS/SSL required: yes.</li>
          </ul>

        </blockquote>

      </div>
      
    </div>
  </div>
</div>
@endsection
