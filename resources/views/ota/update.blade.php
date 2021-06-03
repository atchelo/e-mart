<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/vendor/shards.min.css') }}">
    <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ url('css/install.css') }}">
    <title>{{ __('Updater') }} | {{ config('app.name') }}</title>
</head>

<body>

    <div id="myModal" data-backdrop="static" data-keyboard="false" class="modal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h5 class="text-white modal-title">Login</h5>
              <button type="button" class="text-white close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
             <div style="display:none;" class="rounded alert alert-success">
              <i class="fa fa-check-circle"></i>  <span class="successmsg">Authorization successfull....</span>
             </div>

             <div style="display:none;" class="rounded alert alert-danger">
               <i class="fa fa-warning"></i> <span class="errormsg">Error Message...</span>
             </div>

              <form id="prelogin" action="javascript:void(0)" class="needs-validation" novalidate method="POST">
                  @csrf
                  <div class="form-group">
                      <label>Email: <span class="text-danger">*</span></label>
                      <input type="email" class="form-control" required name="email" placeholder="Enter your email address">
                  </div>

                  <div class="form-group">
                    <label>Password: <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" required name="password" placeholder="Enter password">
                  </div>

                  <div class="form-group">
                      <button type="submit" class="btn btn-md btn-success">
                          <i class="fa fa-key"></i> <span class="btntext">{{__('Login')}}</span>
                      </button>
                  </div>
              </form>

            </div>
            
          </div>
        </div>
      </div>
   

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="m-3 text-center text-dark ">
                    {{ __('Welcome To Update Wizard') }}
                </h3>
            </div>
            <div class="card-body" id="stepbox">
                <form autocomplete="off" action="{{ route('update.proccess') }}" id="updaterform" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    <blockquote class="text-justify text-dark font-weight-normal">
                        <p class="font-weight-bold text-primary"><i class="fa fa-check-circle"></i> Before update make
                            sure you take your database backup and script backup from server so in case if anything goes
                            wrong you can restore it.</p>
                        <hr>
                        <div class="rounded alert alert-danger">
                            <i class="fa fa-info-circle"></i>
                            Important Note:
                            <ul>

                                <li>
                                    Image conversion only require if you upgrading from <b><u>version 1.2</u></b>
                                </li>

                                <li>
                                    <b><u>v1.3</u></b> update contain a major change for image optimizations. So after update the
                                    script you need to run the image conversion also.
                                </li>

                                <li>
                                    As you click on Run image conversion make sure your system is completly up (Only if upgrading from v1.2).
                                </li>

                                <li>
                                    What this conversion does actually it will take your product image -> image1 and image2 and 
                                    convert it to thumbnails and hover thumbnails. As your app have large no of product images it
                                    will take time according to it (Only if upgrading from v1.2).
                                </li>
                                <li>
                                    For Shared hosting servers when you run the script genrally you will see the error after sometime
                                    <u>Internal Server 500</u>
                                    or <u>Server Request time out</u> because your script may have large no of products
                                    but server have low bandwidth.
                                    <br>
                                    On this condition just reload the page and submit the confirmation. <b>repeat this
                                        until you don't see the Complete Button.</b> (Only if upgrading from v1.2)
                                </li>
                            </ul>
                        </div>
                        <p>Before update make sure you read this <b>FAQ.</b></p>
                        <ul>
                            <li><b>Q.</b> Will This Update affect my existing data eg. product data, orders?
                                <br>
                                <b>Answer:</b> No it will not affect your existing .
                            </li>
                            <br>
                            
                            <li><b>Q.</b> Will This Update affect my customization eg. in <b>CSS,JS or in Core code</b>
                                ?
                                <br>
                                <b>Answer:</b> Yes it will affect your changes if you did changes in code files <br> If you customize <B>CSS or JS</B> using <b>Admin -> Custom Style Setting</b> Than all your change will not affect else it will affect.
                            </li>
                        </ul>


                    </blockquote>
                    <hr>
                    <div class="custom-control custom-checkbox">
                        <input required="" type="checkbox" class="custom-control-input" id="customCheck1" name="eula" />
                        <label class="custom-control-label"
                            for="customCheck1"><b>{{ __('I read the update procedure carefully and I take backup already.') }}</b></label>
                    </div>
                    <small class="font-weight-normal text-center">
                        <a target="__blank"
                            href="https://codecanyon.net/item/emart-laravel-multivendor-ecommerce-advanced-cms/25300293">Read
                            complete changelog of update by clicking here.</a>
                    </small>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <button class="updatebtn btn btn-primary" type="submit">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | {{ __('emart Updater') }} | <a class="text-white"
                href="http://mediacity.co.in">{{ __('Mediacity') }}</a></p>
    </div>

    <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Updater') }} </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('js/jquery.js') }}"></script>
    
    <script src="{{ url('front/vendor/js/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/shards.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/additional-methods.min.js') }}"></script>
    <!-- Essential JS UI widget -->
    <script src="{{ url('front/vendor/js/ej.web.all.min.js') }}"></script>
    <script>
        var baseUrl = "<?= url('/') ?>";
    </script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    <script>
        $("#updaterform").on('submit', function () {

            if ($(this).valid()) {
                $('.updatebtn').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span> Updating...');
            }

        });

        
    </script>
     @if(!Auth::check())

        <script>
        
                $('#myModal').modal('show');
        
        </script>

        <script>
            $('#prelogin').on('submit',function(){
                var emp = $(this).serialize();

                $.ajax({

                    type : 'POST',
                    data : emp,
                    url  : '{{ route('prelogin.ota.check') }}',
                    dataType : 'json',
                    beforeSend : function(){
                        $('.btntext').html('Logging in...');
                    },
                    success : function(response){
                        if(response.status == 'failed'){
                            $('.errormsg').parent().show();
                            $('.errormsg').html(response.msg);
                            $('.btntext').html('Login');
                        }else{

                            $('.errormsg').parent().hide();

                            $('.successmsg').parent().show();
                            $('.successmsg').html(response.msg);
                            
                            setTimeout(function(){
                                $('#myModal').modal('hide');
                            },500);

                        }
                    }

                });
            });
        </script>

    @elseif(Auth::check() && Auth::user()->role_id != 'a')

    <script>
        
        $('#myModal').modal('show');

    </script>
        

    @endif
</body>

</html>