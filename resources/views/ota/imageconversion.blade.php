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
    <link rel="stylesheet" href="{{ url('vendor/mckenziearts/laravel-notify/css/notify.css') }}">
    <title>{{ __('-|| Image Conversion ||-') }}</title>

</head>

<body>
   

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="m-3 text-center text-dark ">
                    {{ __('Image Conversion') }}
                </h3>
            </div>
            <div class="card-body" id="stepbox">
                <form autocomplete="off" action="{{ url('image/conversion/proccess') }}" id="updaterform" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    <blockquote class="text-justify text-dark font-weight-normal">
                        <p class="font-weight-bold text-primary"><i class="fa fa-check-circle"></i> Before update make
                            sure you take your database backup and script backup from server so in case if anything goes
                            wrong you can restore it.</p>
                        <p class="font-weight-bold text-danger"><i class="fa fa-warning"></i> <u>ONLY RUN If you're upgrading your script from version 1.2 else it may break your application.</u></p>
                        <hr>
                        <div class="rounded alert alert-danger">
                            <i class="fa fa-info-circle"></i>
                            Important Note:
                            <ul>
                                <li>
                                    Image conversion only require if you upgrading from <b>version 1.2</b>
                                </li>

                                <li>
                                    As this update contain a major change for image optimizations. So after update the
                                    script you need to run the image conversion also.
                                </li>

                                <li>
                                    As you click on Run image conversion make sure your system is completly up.
                                </li>
                                <li>
                                    What this conversion does actually it will take your product image -> image1 and image2 and 
                                    convert it to thumbnails and hover thumbnails. As your app have large no of product images it
                                    will take time according to it.
                                </li>
                                <li>
                                    For Shared hosting servers when you run the script genrally you will see the error after sometime
                                    <u>Internal Server 500</u>
                                    or <u>Server Request time out</u> because your script may have large no of products
                                    but server have low bandwidth.
                                    <br>
                                    On this condition just reload the page and submit the confirmation. <b>repeat this
                                        until you don't see the Complete Button.</b>
                                </li>
                            </ul>
                        </div>
                       


                    </blockquote>
                    <hr>
                    <div class="custom-control custom-checkbox">
                        <input required="" type="checkbox" class="custom-control-input" id="customCheck1" name="eula" />
                        <label class="custom-control-label"
                            for="customCheck1"><b>{{ __('I updated to version 1.3 and read the image conversion procedure carefully and I took backup already.') }}</b></label>
                    </div>
                    
                    <hr>
                    <div class="d-flex justify-content-center">
                        <button class="updatebtn btn btn-primary" type="submit"><i class="fa fa-circle-o-notch"></i> {{ __('Start Conversion') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | {{ __('emart Image converter') }} | <a class="text-white"
                href="http://mediacity.co.in">{{ __('Mediacity') }}</a></p>
    </div>

    <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Converter') }} </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('front/vendor/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/additional-methods.min.js') }}"></script>
    <!-- Essential JS UI widget -->
    <script src="{{ url('front/vendor/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('front/vendor/js/shards.min.js') }}"></script>
    <script>
        var baseUrl = "<?= url('/') ?>";
    </script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    <script src="{{ url('vendor/mckenziearts/laravel-notify/js/notify.js') }}"></script>
    <script>
        $("#updaterform").on('submit', function () {

            if ($(this).valid()) {
                $('.updatebtn').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span> Converting...');
            }

        });
    </script>
</body>

</html>