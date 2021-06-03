@extends('admindesk.layouts.master')
@section('title','Color Settings | ')
@section('body')
<div class="box">
    <div class="box-header with-border">
        
        <div class="box-title">
            {{ __('Color Settings') }}
        </div>
       
    </div>

    <div class="box-body">
        <form action="{{ route('admindesk.theme.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>{{ __('Choose Pattern :') }} </label>
                <br>
                <select required class="theme_pattern form-control select2" name="key" id="key">
                  

                    <option value="default" {{ $themesettings && $themesettings->key == 'default' ? "selected" : "" }}>Default Theme</option>

                    <option {{ $themesettings && $themesettings->key == 'pattern1' ? "selected" : "" }} value="pattern1">Pattern 1</option>

                    <option {{ $themesettings && $themesettings->key == 'pattern2' ? "selected" : "" }} value="pattern2">Pattern 2</option>

                    <option {{ $themesettings && $themesettings->key == 'pattern3' ? "selected" : "" }} value="pattern3">Pattern 3</option>

                    <option {{ $themesettings && $themesettings->key == 'pattern4' ? "selected" : "" }} value="pattern4">Pattern 4</option>

                    <option {{ $themesettings && $themesettings->key == 'pattern5' ? "selected" : "" }} value="pattern5">Pattern 5</option>

                </select>
            </div>

            <div style="{{ $themesettings && $themesettings['key'] == 'default' ? "display:none;" : "" }}" class="color_options form-group">
                <label>{{ __('Choose Color Scheme :') }} </label>
                <br>
                <select {{ $themesettings && $themesettings['key'] != 'default' ? 'required' : "" }} class="theme_pattern_options form-control select2" name="theme_pattern_options" id="theme_pattern_options">


                    <option {{ $themesettings && $themesettings->theme_name == 'yellow_blue' ? "selected" : "" }} value="yellow_blue">Yellow + Blue</option>

                    <option {{ $themesettings && $themesettings->theme_name == 'gold_blue' ? "selected" : "" }} value="gold_blue">Gold + Blue</option>

                    <option {{ $themesettings && $themesettings->theme_name == 'marron_brown' ? "selected" : "" }} value="marron_brown">Marron + Brown</option>

                    <option {{ $themesettings && $themesettings->theme_name == 'greenlight_greendark' ? "selected" : "" }} value="greenlight_greendark">Green Light + Green Dark</option>

                    <option {{ $themesettings && $themesettings->theme_name == 'greendark_greenlight' ? "selected" : "" }} value="greendark_greenlight">Green Dark + Green Light</option>

                    <option {{ $themesettings && $themesettings->theme_name == 'yellow_darkblue' ? "selected" : "" }} value="yellow_darkblue">Yellow + Dark Blue</option>

                    <option {{ $themesettings && $themesettings->theme_name == 'darkpink_darkgrey' ? "selected" : "" }} value="darkpink_darkgrey">Dark Pink + Dark Grey</option>

                    <option {{ $themesettings && $themesettings->theme_name == 'lightgrey_lightgold' ? "selected" : "" }} value="lightgrey_lightgold">Light Grey + Light Gold</option>

                    <option {{ $themesettings && $themesettings->theme_name == 'black_lightblue' ? "selected" : "" }} value="black_lightblue">Black + Light Blue</option>
                
                </select>
            </div>
            

            <div class="form-group">
                <button class="btn btn-md btn-primary" type="submit">
                    <i class="fa fa-save"></i> {{ __('Save Settings') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('custom-script')
    <script>
        $('.theme_pattern').on('change',function(){

            var pattern = $(this).val();

            if(pattern == 'pattern1'){
                $('.color_options').show();
            }

            if(pattern == 'pattern2'){
                $('.color_options').show();
            }

            if(pattern == 'pattern3'){
                $('.color_options').show();
            }

            if(pattern == 'pattern4'){
                $('.color_options').show();
            }

            if(pattern == 'pattern5'){
                $('.color_options').show();
            }

            if(pattern == 'default'){
                $('.color_options').hide();
               
            }


        });
    </script>
@endsection