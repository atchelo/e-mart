@extends("admindesk/layouts.master")
@section('title','Create New Return Policy | ')
@section("body")

<!-- general form elements -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Add Return Policy</h3>
  </div>
  <div class="panel-heading">
    <a href=" {{ url('admindesk/return-policy') }} " class="btn btn-success pull-right owtbtn">
      < Back</a> </div> <!-- /.box-header -->
        <!-- form start -->
        <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/return-policy')}}"
          data-parsley-validate class="form-horizontal form-label-left">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              Policy Name: <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <input placeholder="Enter Policy Name" type="text" id="first-name" name="name"
                class="form-control col-md-7 col-xs-12" value="{{old('name')}}">
            </div>

          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              Amount: <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <input placeholder="%" type="text" id="first-name" name="amount" class="form-control col-md-7 col-xs-12"
                value="{{old('amount')}}">
              <span>(Please enter amount in Percentage)</span>
            </div>

          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              Return days: <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <input placeholder="Please enter product return days" type="text" id="first-name" name="days"
                class="form-control col-md-7 col-xs-12">

            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              Description: <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea cols="2" id="editor1" value="{{old('des' ?? '')}}" name="des" rows="5"
                class="form-control col-md-7 col-xs-12">
                          {{old('des')}} 
                         </textarea>
              <small class="txt-desc">(Please Enter Return Description)</small>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              Status:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
              <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
              <input type="hidden" name="status" value="0" id="status3">
              <small class="txt-desc">(Please Choose Status )</small>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              Return Accept By:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="max-width-250px col-md-3 form-control" name="return_acp" id="">
                <option>Please choose</option>
                <option value="auto">Auto</option>
                <option value="admin">Admin</option>
                <option value="vender">Vender</option>
              </select>
              <br><br>
              <small class="txt-desc">(Please Choose an option to select who can accept return)</small>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          <br>
        </form>
        <br>

        @endsection