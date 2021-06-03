@extends("admindesk/layouts.master")
@section('title','Edit Page'.$page->name.' |')
@section("body")


<div class="box">
  <div class="box-header with-border">
    <div class="box-title">Pages</div>

    <a href=" {{url('admindesk/page')}} " class="btn btn-default pull-right">
      <i class="fa fa-arrow-left"></i> Back</a>
  </div>
  <div class="box-body">
    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/page/'.$page->id)}}"
      data-parsley-validate class="form-horizontal form-label-left">
      {{csrf_field()}}
      {{ method_field('PUT') }}
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Page Name <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <input placeholder="Enter page name" type="text" id="first-name" name="name" value="{{$page->name}}"
            class="form-control col-md-7 col-xs-12">

        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description <span
            class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <textarea cols="2" id="editor1" name="des" rows="5">
                          {{ucfirst($page->des)}}
                         </textarea>
          <small class="txt-desc">(Please Enter Description)</small>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Slug <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <input placeholder="Edit your slug" type="text" required id="first-name" name="slug" value="{{$page->slug}}"
            class="form-control col-md-7 col-xs-12">

        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
          Status <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input {{ $page->status ==1 ? "checked" : "" }} id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
          <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
          <input type="hidden" name="status" value="{{ $page->status }}" id="status3">

          <small class="txt-desc">(Please Choose Status) </small>
        </div>
      </div>
      <div class="box-footer">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button class="btn btn-primary">Create</button>
        </div>
    </form>

  </div>
  <!-- /.box -->

  @endsection