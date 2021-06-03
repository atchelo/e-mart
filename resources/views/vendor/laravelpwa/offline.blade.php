<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Favicon -->
  <link rel="icon" href="{{ url('images/genral/'.$fevicon ?? '') }}" type="image/png" sizes="16x16">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#157ED2">
</head>
<style>
  body {
    background: #157ED2;
    font-family: Arial;
  }

  .top-x {
    color: #fff;
    position: relative;
    top: 50px;
    line-height: 1.5em;
  }

  /* The ribbons */

  .corner-ribbon {
    width: 200px;
    background: #e43;
    position: absolute;
    top: 25px;
    left: -50px;
    text-align: center;
    line-height: 50px;
    letter-spacing: 1px;
    color: #000;
    font-size: 18px;
    transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
  }

  /* Custom styles */

  .corner-ribbon.sticky {
    position: fixed;
  }

  .corner-ribbon.shadow {
    box-shadow: 0 0 3px rgba(0, 0, 0, .3);
  }


  .corner-ribbon.green {
    background: #FDD922;
  }

  .corner-ribbon.bottom-right {
    top: auto;
    right: -50px;
    bottom: 25px;
    left: auto;
    transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
  }
</style>

<body>

  <div class="container">
    <div class="row">
      <div class="">

        <center>
          <h1 class="head1">&#9889;</h1>
        </center>
        <h3 align="center" class="top-x2">{{ __('Oops ! No Connection') }}</h3>
        <h3 align="center" class="top-x3">{{ __('Please Find us !') }}</h3>

      </div>

    </div>
  </div>

</body>

</html>