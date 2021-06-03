<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="Description" content="{{$seoset->metadata_des}}" />
    <meta name="keyword" content="{{ $seoset->metadata_key }}">
    <meta name="robots" content="all">
    <meta name="author" content="{{ config('app.name') }}">
    <!-- Theme Header Color -->
    <meta name="theme-color" content="#157ED2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Maintenance mode - {{ config('app.name') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{url('images/genral/'.$fevicon)}}" type="image/png" sizes="16x16">
    <!-- Fontawesome icons -->
    <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
    <!-- Start css -->
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        .authenticate-bg {
            background: url(../public/images/authentication-bg.svg);
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }
    </style>
    <!-- End css -->
</head>

<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box error-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-8 col-lg-6">
                        <div class="text-center">
                            <img title="{{ config('app.name') }}" src="{{url('images/genral/'.$front_logo)}}" class="img-fluid error-logo" alt="logo">
                            <img src="{{ url('images/maintenance.svg') }}" class="img-fluid error-image"
                                alt="maintenance">
                                <br><br>
                            {!! $row->message !!}
                            <br>
                           <p>&copy; {{ date('Y') }} | {{ config('app.name') }} | {{ __('All rights reserved') }}</p>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>

</body>

</html>