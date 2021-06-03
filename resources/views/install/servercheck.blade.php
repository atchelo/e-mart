<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" crossorigin="anonymous">
  <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{ url('css/vendor/shards.min.css') }}">
  <link rel="stylesheet" href="{{ url('css/install.css') }}">
  <link rel="stylesheet" href="{{ url('vendor/mckenziearts/laravel-notify/css/notify.css') }}">
  <title>{{ __('Installing App - Server Requirement') }}</title>
  @notify_css
</head>

<body>
  <div class="display-none preL">
    <div class="display-none preloader3"></div>
  </div>

  <div class="container">
    <div class="card">
      <div class="card-header">
        <h3 class="m-3 text-center text-dark ">
          {{ __('Server Requirement') }}
        </h3>
      </div>
      <div class="card-body" id="stepbox">
        <form autocomplete="off" action="{{ route('store.server') }}" id="step1form" method="POST"
          class="needs-validation" novalidate>
          @csrf
          @php
          $servercheck= array();
          @endphp
          <div class="form-row">
            <br>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ __('php extension') }}</th>
                      <th>{{ __('Status') }}</th>
                    </tr>
                  </thead>

                  <tbody>

                    <tr>
                      @php
                      $v = phpversion();
                      @endphp
                      <td>
                        {{ __('php version') }} (<b>{{ $v }}</b>)
                        <br>
                        <small class="text-muted">php version required less than 7.4 and greater than 7.0</small>
                      </td>
                      <td>

                        @if($v > 7.2 && $v < 8.0) <i class="text-success fa fa-check-circle"></i>
                          @php
                            array_push($servercheck, 1);
                          @endphp
                          @else
                          <i class="text-danger fa fa-times-circle"></i>
                          <br>
                          <small>
                            Your php version is <b>{{ $v }}</b> which is not supported
                          </small>
                          @php
                          array_push($servercheck, 0);
                          @endphp
                          @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('pdo') }}</td>
                      <td>

                        @if (extension_loaded('pdo'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                          array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                          array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('BCMath') }}</td>
                      <td>

                        @if (extension_loaded('BCMath'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                          array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('openssl') }}</td>
                      <td>

                        @if (extension_loaded('openssl'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('fileinfo') }}</td>
                      <td>

                        @if (extension_loaded('fileinfo'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('json') }}</td>
                      <td>

                        @if (extension_loaded('json'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('session') }}</td>
                      <td>

                        @if (extension_loaded('session'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('gd') }}</td>
                      <td>

                        @if (extension_loaded('gd'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>



                    <tr>
                      <td>{{ __('allow_url_fopen') }}</td>
                      <td>

                        @if (ini_get('allow_url_fopen'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>





                    <tr>
                      <td>{{ __('xml') }}</td>
                      <td>

                        @if (extension_loaded('xml'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('tokenizer') }}</td>
                      <td>

                        @if (extension_loaded('tokenizer'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>{{ __('standard') }}</td>
                      <td>

                        @if (extension_loaded('standard'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('mysqli') }}</td>
                      <td>

                        @if (extension_loaded('mysqli'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('mbstring') }}</td>
                      <td>

                        @if (extension_loaded('mbstring'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('ctype') }}</td>
                      <td>

                        @if (extension_loaded('ctype'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>{{ __('exif') }}</td>
                      <td>

                        @if (extension_loaded('exif'))

                        <i class="text-success fa fa-check-circle"></i>
                        @php
                        array_push($servercheck, 1);
                        @endphp
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @php
                        array_push($servercheck, 0);
                        @endphp
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td><b>{{storage_path()}}</b> {{ __('is writable') }}?</td>
                      <td>
                        @php
                        $path = storage_path();
                        @endphp
                        @if(is_writable($path))
                        <i class="text-success fa fa-check-circle"></i>
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td><b>{{base_path('bootstrap/cache')}}</b> {{ __('is writable') }}?</td>
                      <td>
                        @php
                        $path = base_path('bootstrap/cache');
                        @endphp
                        @if(is_writable($path))
                        <i class="text-success fa fa-check-circle"></i>
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td><b>{{storage_path('framework/sessions')}}</b> {{ __('is writable') }}?</td>
                      <td>
                        @php
                        $path = storage_path('framework/sessions');
                        @endphp
                        @if(is_writable($path))
                        <i class="text-success fa fa-check-circle"></i>
                        @else
                        <i class="text-danger fa fa-times-circle"></i>
                        @endif
                      </td>
                    </tr>


                  </tbody>
                </table>
              </div>
            </div>

          </div>
          @if(!in_array(0, $servercheck))
          <button class="float-right step1btn btn btn-primary"
            type="submit">{{ __('Continue to Installation') }}...</button>
          @else
          <p class="pull-right text-danger">
            <b>{{ __('Some extension are missing. Contact your host provider for enable it.') }}</b></p>
          @endif
        </form>
      </div>
    </div>
    <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | <a class="text-white"
        href="http://mediacity.co.in">{{ __('Media City') }}</a></p>
  </div>

  <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Server Check') }} </div>
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
  @notify_js
  @notify_render
</body>

</html>