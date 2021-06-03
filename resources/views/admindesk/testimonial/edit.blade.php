@extends("admindesk/layouts.master")
@section('title','Edit Testimonial | ')
@section("body")

<div class="box box-primary">
  <div class="box-header with-border">
    <div class="box-title">Testimonial</div>
    <a href=" {{url('admindesk/testimonial')}} " class="btn btn-default pull-right">
      <i class="fa fa-arrow-left"></i>
    Back</a>
  </div>
         <form id="demo-form2" method="post" enctype="multipart/form-data"
            action="{{url('admindesk/testimonial/'.$client->id)}}" data-parsley-validate
            class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                Name: <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <input placeholder="Enter Name" type="text" id="first-name" name="name" value="{{$client->name}}"
                  class="form-control col-md-7 col-xs-12">

              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                Rating: <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="rating" class="form-control col-md-7 col-xs-12">
                  <option value="0">Please Choose</option>
                  <option value="1" {{$client->rating=='1' ?'selected':''}}>1</option>
                  <option value="2" {{$client->rating=='2' ?'selected':''}}>2</option>
                  <option value="3" {{$client->rating=='3' ?'selected':''}}>3</option>
                  <option value="4" {{$client->rating=='4' ?'selected':''}}>4</option>
                  <option value="5" {{$client->rating=='5' ?'selected':''}}>5</option>
                </select>
                <small class="txt-desc">(Please Choose Rating)</small>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                Designation: <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <input placeholder="Enter Designation" type="text" id="first-name" name="post" value="{{$client->post}}"
                  class="form-control col-md-7 col-xs-12">

              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Image: <span
                  class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <img src=" {{url('images/testimonial/'.$client->image)}}" class="height-50">
                <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
                <br>
                <small class="txt-desc">(Please Choose Client Image)</small>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description: <span
                  class="required"></span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea cols="2" id="editor1" name="des" rows="5">
                          {{$client->des}}
                         </textarea>
                <small class="txt-desc">(Please Enter Description)</small>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                Status:
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input {{$client->status ==1 ? "checked" : ""}} data-offstyle="danger" id="toggle-event3"
                  type="checkbox" class="tgl tgl-skewed">
                <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                <input type="hidden" name="status" value="{{ $client->status }}" id="status3">
                <small class="txt-desc">(Please Choose Status) </small>
              </div>
            </div>


            <div class="box-footer">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                  title="Sorry this operation is disabled in demo" @endif class="btn btn-primary">Submit</button>
              </div>
              </form>

            </div>
            @endsection