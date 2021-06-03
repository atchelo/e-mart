@extends("admindesk/layouts.master")
@section('title','Add Testimonial | ')
@section("body")

@section('data-field')
Testimonial
@endsection
      <div class="col-xs-12">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Testimonial</h2>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/testimonial')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/testimonial')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Name: <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Enter Name" type="text" id="first-name" name="name" value="{{old('name')}}" class="form-control col-md-7 col-xs-12">
                          
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Rating: <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="rating" class="form-control col-md-7 col-xs-12">
                            <option value="0">Please Choose</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                          <small class="txt-desc">(Please Choose Rating)</small>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Designation: <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Enter Designation" type="text" id="first-name" name="post" value="{{old('post')}}" class="form-control col-md-7 col-xs-12">

                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Image: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
                           <small class="txt-desc">(Please Choose Client Image)</small>
                           </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description: <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <textarea cols="2" id="editor1" name="des" rows="5" >
                          {{old('des')}}
                         </textarea>
                         <small class="txt-desc">(Please Enter Description)</small>
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
                         <small class="txt-desc">(Please Choose Status) </small>
                        </div>
                      </div>

              <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  
                  <button type="submit" class="btn btn-primary">Submit</button>
              </div>
                 </form>
                
          </div>
          <!-- /.box -->
        </div>


        <!-- footer content -->
@endsection

