@extends("admindesk/layouts.master")
@section('title','Add new Brand | ')
@section("body")



<div class="box">
  <div class="box-header with-border">
    <div class="box-title">Brand</div>
    <a href=" {{url('admindesk/brand')}} " class="btn btn-default pull-right">
      <i class="fa fa-arrow-left"></i> Back</a> </div> 
      <div class="box-body">
      <form id="demo-form2" method="post" enctype="multipart/form-data"
        action="{{url('admindesk/brand')}}" data-parsley-validate class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Brand Name: <span class="required">*</span>
          </label>

          <div class="col-md-6 col-sm-6 col-xs-12">
            <input placeholder="Please enter brand name" type="text" id="first-name" name="name"
              class="form-control col-md-7 col-xs-12" value="{{ old('name') }}">

          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Brand Logo: <span class="required">*</span>
          </label>

          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
            <small class="txt-desc">(Please Choose Brand Image)</small>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Select Category: <span class="required">*</span>
          </label>

          <div class="col-md-6 col-sm-6 col-xs-12">

            <select multiple="multiple" class="select2" name="category_id[]">
              @foreach (App\Category::all() as $item)
              <option value="{{ $item->id }}">{{ $item->title }}</option>
              @endforeach
            </select>

          </div>
        </div>



        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Status <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="toggle-event3" type="checkbox" name="status" class="tgl tgl-skewed">
            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>

            <small class="txt-desc">(Please Choose Status) </small>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Show Image Footer <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="show-image" type="checkbox" name="show_image" class="tgl tgl-skewed">
            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="show-image"></label>
            <small class="txt-desc">(If You Choose Active Then Image Show In Footer Brand Logo) </small>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          </form>

        </div>

        @endsection