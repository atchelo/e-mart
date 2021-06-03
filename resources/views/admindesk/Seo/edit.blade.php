@extends("admindesk/layouts.master")
@section('title','SEO Settings | ')
@section("body")


<div class="box">
  <div class="box-header with-border">
    <div class="box-title">SEO</div>
  </div>

  <div class="box-body">
    <form id="demo-form2" method="POST" enctype="multipart/form-data" action="{{ route('seo.store') }}"
      data-parsley-validate class="form-horizontal form-label-left">
      @csrf
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Project Title <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <input placeholder="Enter project title (It will also show in title bar)" type="text" id="first-name"
            name="project_name" value="{{$seo->project_name ?? ''}}" class="form-control currency-icon-picker ">

        </div>

      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Metadata Description <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <input placeholder="Enter meta data description" type="text" id="first-name" name="metadata_des"
            value="{{$seo->metadata_des ?? ''}}" class="form-control col-md-7 col-xs-12">

        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Metadata Keyword <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <input placeholder="Enter Metadata Keyword, use comma to seprate it" type="text" id="first-name"
            name="metadata_key" value="{{$seo->metadata_key ?? ''}}" class="form-control col-md-7 col-xs-12">

        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Google Analytics:
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <input placeholder="Enter Google Analytics Key" type="text" id="first-name" name="google_analysis"
            value="{{$seo->google_analysis ?? ''}}" class="form-control col-md-7 col-xs-12">

        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Facebook Pixel:
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
          
          <input placeholder="Please enter Facebook Pixel Code Key" type="text" id="first-name" name="FACEBOOK_PIXEL_ID"
            value="{{ env('FACEBOOK_PIXEL_ID') }}" class="form-control col-md-7 col-xs-12">

        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Generate Sitemap:
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <a href="{{ url('/sitemap') }}" class="btn btn-md btn-warning">{{ __('Generate') }}</a>

          @if(@file_get_contents(public_path().'/sitemap.xml'))
          Download <a href="{{ url('/sitemap/download') }}">Sitemap.xml</a>
          |
          View <a href="{{ url('/sitemap.xml') }}">Sitemap</a>
          @endif
        </div>
      </div>


      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

          <button @if(env('DEMO_LOCK')==0) type="submit" @else title="This action is disabled in demo !"
            disabled="disabled" @endif class="btn btn-success">
          <i class="fa fa-save"></i> Save Settings
          </button>
        </div>
      </div>

    </form>
  </div>
</div>
</div>
</div>


@endsection