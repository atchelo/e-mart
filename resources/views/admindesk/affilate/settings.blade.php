@extends('admindesk.layouts.master')
@section('title','Affiliate Settings | ')
@section('body')
@component('components.box',['border' => 'with-border'])

    @slot('header')
        <div class="box-title">
            {{ __("Affiliate Settings")}}
        </div>
    @endslot

    @slot('boxBody')
        <form action="{{ route('admindesk.affilate.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Enable affiliate ?</label>
                <br>
                <label class="switch">
                    <input type="checkbox" name="enable_affilate" {{ isset($af_settings) && $af_settings->enable_affilate =='1' ? "checked" : "" }}>
                    <span class="knob"></span>
                </label>
            </div>

            <div class="form-group">
                <label>Credit wallet amount on first purchase ?</label>
                <br>
                <label class="switch">
                    <input type="checkbox" name="enable_purchase" {{ isset($af_settings) && $af_settings->enable_purchase =='1' ? "checked" : "" }}>
                    <span class="knob"></span>
                </label>
                <br>
                <small class="text-muted"> <i class="fa fa-question-circle"></i> {{ __("IF enabled then referal amount will credited to referal once their refered user purchase something.") }}</small>
            </div>

            <div class="form-group">
                <label for="my-input">Refer code limit: <span class="text-danger">*</span></label>
                <input required value="{{ isset($af_settings) ? $af_settings->code_limit : 4 }}" id="my-input" min="4" max="6" class="form-control" type="number" name="code_limit">
                <small class="text-muted"> <i class="fa fa-question-circle"></i> {{ __("Refer code character limit eg: if you put 4 then refer code will be AB51 and if you put 6 then it will be ABCD45") }}</small>
            </div>

            <div class="form-group">
                <label for="my-input">Refer amount: <span class="text-danger">*</span></label>
                <input id="my-input" min="0" step="0.01" value="{{ isset($af_settings) ? $af_settings->refer_amount : 0 }}" class="form-control" type="number" name="refer_amount">
                <small class="text-muted"> <i class="fa fa-question-circle"></i> {{ __("Per Refer amount in default currency") }}</small>
            </div>

            <div class="form-group">
                <label>Description:</label> <small class="text-muted"> <i class="fa fa-question-circle"></i> {{ __("Some description of your affiliate system that how it gonna work?") }}</small>
                <textarea class="form-control editor" name="about_system" id="about_system" cols="10" rows="5">{{ isset($af_settings) ? $af_settings->about_system : ""  }}</textarea>
            </div>

            <div class="form-group">
                    <button class="btn btn-md btn-success">
                       <i class="fa fa-save"></i>  {{__("Save Settings")}}
                    </button>
            </div>
        </form>
    @endslot

@endcomponent
@endsection