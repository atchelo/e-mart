@extends("admindesk/layouts.master")
@section('title','Create new page |')
@section("body")

@section('data-field')
Pages
@endsection

<div class="box">
  <div class="box-header with-border">
    <div class="box-title">Pages</div>
      <a href=" {{url('admindesk/page')}} " class="btn btn-default pull-right">
        <i class="fa fa-arrow-left"></i> Back</a></div> 
        
        <div class="box-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/page')}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                Page Name <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <input placeholder="Enter page name" type="text" id="first-name" name="name" value="{{old('name')}}"
                  class="form-control col-md-7 col-xs-12">

              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description <span
                  class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea cols="2" id="editor1" name="des" rows="5">

                         </textarea>
                <p class="txt-desc">Please Enter Description</p>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                Slug <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <input placeholder="Enter your slug" type="text" required id="first-name" name="slug"
                  value="{{old('slug')}}" class="form-control col-md-7 col-xs-12">

              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                Status
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                <input type="hidden" name="status" value="0" id="status3">
                <small class="txt-desc">(Please Choose Status )</small>
              </div>
            </div>

            <div class="box-footer">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-success btn-md">Save</button>
              </div>
          </form>

    </div>
    <!-- /.box -->

    @endsection