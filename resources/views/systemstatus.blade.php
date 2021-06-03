@extends('admindesk.layouts.master')
@section('title','System Status | ')
@section('body')

    @php

        $results = DB::select( DB::raw('SHOW VARIABLES LIKE "%version%"') );
    
        foreach ($results as $key => $result) {

            if($result->Variable_name == 'version' ){
                $db_info[] = array(
                    'value'   => $result->Value
                );
            }

            if($result->Variable_name == 'version_comment' ){
                $db_info[] = array(
                    'value'   => $result->Value
                );
            }
        }

        $servercheck= array();

    @endphp

    @component('components.box',['border' => 'with-border'])
        @slot('header')
            <div class="box-title">
                {{ __("System Status")}}
            </div>
        @endslot

        @slot('boxBody')

        
        <div id="message"></div>

        <table class="table table-bordered table-striped">
          

            <tbody>
                <tr>
                    <td>
                        <b>Laravel Version</b>
                    </td>
                    <td>
                        {{ App::version() }} <i class="fa fa-check-circle text-green"></i>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr>

        <table class="table table-bordered table-striped">
            <thead>
                
                <th colspan="2">
                    MYSQL version info
                </th>
                <th>
                    Status
                </th>
                
            </thead>
            

            <tbody>
               @foreach($db_info as $key => $info)
                    <tr>
                        <td>
                            {{ $key == 0 ? "MYSQL Version" : "Server Type" }}
                        </td>
                        <td>
                            {{ $info['value'] }}
                        </td>
                        <td>
                            @if($key == 0 && $info['value'] < 5.7)
                                @php
                                    array_push($servercheck, 0);
                                @endphp
                                <i class="fa fa-times-circle text-red"></i>
                            @else
                                @php
                                    array_push($servercheck, 1);
                                @endphp
                            <i class="fa fa-check-circle text-green"></i>
                            @endif
                        </td>
                    </tr>
               @endforeach
            </tbody>
        </table>
        <hr>
        <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>{{ __('php extensions') }}</th>
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
                  <small class="text-muted">php version required greater than than 7.2</small>
                </td>
                <td>

                  @if($v > 7.2) <i class="text-green fa fa-check-circle"></i>
                        @php
                            array_push($servercheck, 1);
                        @endphp
                    @else
                        @php
                            array_push($servercheck, 1);
                        @endphp
                    <i class="text-red fa fa-times-circle"></i>
                    <br>
                    <small>
                      Your php version is <b>{{ $v }}</b> which is not supported
                    </small>
                   
                    @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('pdo') }}</td>
                <td>

                  @if (extension_loaded('pdo'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                 
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('BCMath') }}</td>
                <td>

                  @if (extension_loaded('BCMath'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                 
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                    
                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('openssl') }}</td>
                <td>

                  @if (extension_loaded('openssl'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('fileinfo') }}</td>
                <td>

                  @if (extension_loaded('fileinfo'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                  
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                    
                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('json') }}</td>
                <td>

                  @if (extension_loaded('json'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                  
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                  
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('session') }}</td>
                <td>
                    

                  @if (extension_loaded('session'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                 
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('gd') }}</td>
                <td>

                  @if (extension_loaded('gd'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                 
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                  
                  @endif
                </td>
              </tr>



              <tr>
                <td>{{ __('allow_url_fopen') }}</td>
                <td>

                  @if (ini_get('allow_url_fopen'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                  
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                    
                    <i class="text-red fa fa-times-circle"></i>
                  
                  @endif
                </td>
              </tr>





              <tr>
                <td>{{ __('xml') }}</td>
                <td>

                  @if (extension_loaded('xml'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                 
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('tokenizer') }}</td>
                <td>

                  @if (extension_loaded('tokenizer'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                 
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                  
                  @endif
                </td>
              </tr>
              <tr>
                <td>{{ __('standard') }}</td>
                <td>

                  @if (extension_loaded('standard'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                  
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('zip') }}</td>
                <td>

                  @if (extension_loaded('zip'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                  
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('mysqli') }}</td>
                <td>

                  @if (extension_loaded('mysqli'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                 
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-red fa fa-times-circle"></i>
                 
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('mbstring') }}</td>
                <td>

                  @if (extension_loaded('mbstring'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                 
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                    <i class="text-red fa fa-times-circle"></i>
                  
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('ctype') }}</td>
                <td>

                  @if (extension_loaded('ctype'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-green fa fa-check-circle"></i>
                  
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp

                    <i class="text-red fa fa-times-circle"></i>
                  
                  @endif
                </td>
              </tr>

              <tr>
                <td>{{ __('exif') }}</td>
                <td>

                  @if (extension_loaded('exif'))

                        @php
                            array_push($servercheck, 1);
                        @endphp

                  <i class="text-green fa fa-check-circle"></i>
                
                  @else

                        @php
                            array_push($servercheck, 1);
                        @endphp
                  
                  <i class="text-red fa fa-times-circle"></i>
                 
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

                    @php
                        array_push($servercheck, 1);
                    @endphp
                  <i class="text-green fa fa-check-circle"></i>
                  @else

                    @php
                        array_push($servercheck, 1);
                    @endphp

                  <i class="text-red fa fa-times-circle"></i>
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

                    @php
                        array_push($servercheck, 1);
                    @endphp

                  <i class="text-green fa fa-check-circle"></i>
                  @else

                    @php
                        array_push($servercheck, 1);
                    @endphp

                  <i class="text-red fa fa-times-circle"></i>
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

                    @php
                        array_push($servercheck, 1);
                    @endphp

                  <i class="text-green fa fa-check-circle"></i>
                  @else

                    @php
                        array_push($servercheck, 1);
                    @endphp

                  <i class="text-red fa fa-times-circle"></i>
                  @endif
                </td>
              </tr>


            </tbody>
          </table>

            

        @endslot

    @endcomponent  
@endsection
@section('custom-script')
    <script>
        @if(!in_array(0, $servercheck))
            $("#message").html('<div class="callout callout-success"><i class="fa fa-check-circle"></i> {{ __("All good ! No problem detected so far") }}</div>');
        @else
            $('#message').html(' <div class="callout callout-danger"><i class="fa fa-times-circle"></i> {{ __("Something went wrong ! Please check status column") }}</div>');
        @endif
    </script>
@endsection