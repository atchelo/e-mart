@extends("admindesk/layouts.master")
@section('title','Widgtes footer | ')
@section("body")

    <div class="col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" >
            <div class="box-header with-border">
              <h3 class="box-title">Widget footer </h2>
                  <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/widget_footer')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Widget Name <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="widget_name" 
                          value="{{ old('widget_name')}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Widget Name</p>
                        </div>
                      </div>
                     
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Widget Psition <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <select name="widget_position" class="form-control col-md-7 col-xs-12">
                            <option value="3" >3</option>
                            <option value="4" >4</option>
                         </select>
                          <p class="txt-desc">Please Enter Widget Psition</p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Menu Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="menu_name" 
                          value="{{ old('menu_name')}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Menu Name</p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Url <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="url" 
                          value="{{ old('url')}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Url</p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          status 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="status" class="form-control col-md-7 col-xs-12">
                            <option value="1" >Yes</option>
                            <option value="0" >No</option>
                         </select>
                         <p class="txt-desc">Please Choose Status </p>
                        </div>
                    </div>
                   <div class="box-footer">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                    <button class="btn btn-default "><a href="{{url('admindesk/widget_footer')}}" class="links">Cancel</a></button>
                  </div>
                  <!-- /.box -->
                </div>



        <!-- footer content -->
@endsection
