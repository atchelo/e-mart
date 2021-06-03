@extends('admindesk.layouts.master')
@section('title','Backup Manager | ')
@section('body')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            {{ __('Backup Manager') }}
        </div>
    </div>

    <div class="box-body">

        <div class="well">

            <div class="row">

                <form action="{{ route('dump.path.update') }}" method="POST">
                    @csrf

                    <div class="col-md-12">
                        <label for="">MySQL Dump Path:</label>
                        <div class="input-group">
                            <input name="SQL_DUMP_PATH" required type="text" class="form-control" placeholder="MY SQL DUMP PATH" value="{{ env('SQL_DUMP_PATH') }}" aria-describedby="basic-addon2">
                            <span class="input-group-addon" id="basic-addon2">
                                <button type="submit">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </span>
                            
                        </div>
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Important Note:
                            
                            <br>

                            • Usually in all hosting dump path for MYSQL is <b>/usr/bin/</b>
                            <br>
                            • If that path not work than contact your hosting provider with subject <b>"What is my MYSQL DUMP Binary path ?"</b>
                            <br>
                            • Enter the path without <b>mysqldump</b> in path"</b>
                            


                        </small>

                        <hr>
                    </div>

                </form>


                <div class="col-md-8">

                    <ul>
                        <li>
                            {{ __('It will generate only database backup of your site.') }}
                        </li>

                        <li>
                            <b>{{ __('Download URL is valid only for 1 (minute).') }}</b>
                        </li>

                        <li>
                            Make sure <b>mysql dump is enabled on your server</b> for database backup and before run
                            this or
                            run only database backup command make sure you save the mysql dump path in
                            <b>config/database.php</b>.
                        </li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <br>
                    <a @if(env('SQL_DUMP_PATH') != '') href="{{ url('admindesk/backups/process?type=onlydb') }}" @else href="#" disabled @endif class="btn btn-md btn-success">
                        <i class="fa fa-refresh"></i> {{ __('Generate database backup') }}
                    </a>
                </div>

            </div>


        </div>

        <div class="row">
            <div class="text-center col-md-8">
                {!! $html !!}
            </div>

            <div class="col-md-4">
                <div class="well">
                    <p class="text-muted"> <b>Download the latest backup</b> </p>

                    @php

                    $dir17 = storage_path() . '/app/'.config('app.name');
                    @endphp

                    <ul>

                        @foreach (array_reverse(glob("$dir17/*")) as $key=> $file)

                        @if($loop->first)
                        <li><a href="{{ URL::temporarySignedRoute('admindesk.backup.download', now()->addMinutes(1), ['filename' => basename($file)]) }}"><b>{{ basename($file)  }}
                                    (Latest)</b></a></li>
                        @else
                        <li><a href="{{ URL::temporarySignedRoute('admindesk.backup.download', now()->addMinutes(1), ['filename' => basename($file)]) }}">{{ basename($file)  }}</a>
                        </li>
                        @endif

                        @endforeach

                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection