@extends('admindesk.layouts.master')
@section('title','Offer popup settings |')
@section('body')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                {{__("Offer popup settings")}}
            </div>
        </div>

        <div class="box-body">

            <div class="callout callout-success">
                <i class="fa fa-language" aria-hidden="true"></i> For translate text in different languages you can switch language from top bar than change the language and update the translations.
            </div>

            <form action="{{ route('offer.update.settings') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-12">
                        <label> Enable Offer popup ? </label>
                        <br>
                        <label class="switch">
                            <input {{ isset($settings) && $settings->enable_popup || old('enable_popup') ? "checked" : "" }} id="enable_popup" type="checkbox" name="enable_popup">
                            <span class="knob"></span>
                        </label>
                    </div>

                    <hr>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Offer popup image : <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image"/>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Heading Text (in {{ app()->getLocale() }}) : <span class="text-danger">*</span></label>
                            <input value="{{ $settings->heading ?? old('heading') }}" required type="text" class="form-control" name="heading" placeholder="Enter heading text in {{ app()->getLocale() }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Heading Text Color: <span class="text-danger">*</span></label>
                            <input value="{{ $settings->heading_color ?? old('heading_color') }}" required type="color" class="form-control" name="heading_color" placeholder="Choose color for heading text...">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Subheading Text (in {{ app()->getLocale() }}) : <span class="text-danger">*</span> </label>
                            <input value="{{ $settings->subheading ?? old('subheading') }}" required type="text" class="form-control" name="subheading" placeholder="Enter subheading text in {{ app()->getLocale() }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Subheading Text Color: <span class="text-danger">*</span></label>
                            <input value="{{ $settings->subheading_color ?? old('subheading_color') }}" required type="color" class="form-control" name="subheading_color" placeholder="Choose color for subheading text...">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Description Text (in {{ app()->getLocale() }}) :</label>
                            <input value="{{ $settings->description ?? old('description') }}" type="text" class="form-control" name="description" placeholder="Enter description text in {{ app()->getLocale() }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Description Text Color:</label>
                            <input value="{{ $settings->description_text_color ?? old('description_text_color') }}" type="color" class="form-control" name="description_text_color" placeholder="Choose color for description text...">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label> Enable Button in popup ? </label>
                        <br>
                        <label class="switch">
                            <input {{ isset($settings) && $settings->enable_button || old('enable_button') ? "checked" : "" }} id="enable_button" type="checkbox" name="enable_button">
                            <span class="knob"></span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Button Text (in {{ app()->getLocale() }}) : </label>
                            <input value="{{ $settings->button_text ?? old('button_text') }}" type="text" class="form-control" name="button_text" placeholder="Enter button text in {{ app()->getLocale() }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Button Link (in {{ app()->getLocale() }}) : </label>
                            <input value="{{ $settings->button_link ?? old('button_link') }}" type="text" class="form-control" name="button_link" placeholder="Enter button link eg:https://">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Button Text Color:</label>
                            <input value="{{ $settings->button_text_color ?? old('button_text_color') }}" type="color" class="form-control" name="button_text_color" placeholder="Choose color for button text...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Button Background Color:</label>
                            <input value="{{ $settings->button_color ?? old('button_color') }}" type="color" class="form-control" name="button_color" placeholder="Choose color for button background...">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-success">
                                <i class="fa fa-save"></i> Save Settings
                            </button>
                        </div>
                    </div>


                </div>   

            </form>
        </div>

    </div>
@endsection