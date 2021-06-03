@extends("admindesk/layouts.master")

@section("body")
<div class="col-xs-12">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Shipping</h3>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/shipping')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/shipping')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                     
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Shipping Title *
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Shipping Title </p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Price *
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="price" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Price </p>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input data-width="90" data-on="Active" data-off="Deactive" data-onstyle="success" data-offstyle="danger" id="toggle-event3" type="checkbox" data-toggle="toggle">
                        <input type="hidden" name="status" value="0" id="status3">
                         <p class="txt-desc">Please Choose Status </p>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
          <!-- /.box -->
        </div>



        <!-- footer content -->
@endsection
