@extends("admindesk/layouts.master")
@section('title','Add new Hotdeal | ')
@section("body")


        <div class="col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" >
            <div class="box-header with-border">
              <h3 class="box-title">Hotdeal</h3>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/hotdeal/')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/hotdeal')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Created Date
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class='input-group date' id='datetimepicker1'>
                          <input name="start" type='text' id="datetimepicker1" value="" class="form-control" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                          
                        </div>
                      </div>



                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Expire Date
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class='input-group date' id='datetimepicker2'>
                          <input name="end" type='text' id="datetimepicker2" value="" class="form-control" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                          
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Product name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="pro_id" class="form-control col-md-7 col-xs-12">
                            <option value="0">Please Select Product</option>
                            @foreach($products as $pro)
                            <option value="{{$pro->id}}">{{$pro->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status <span class="required">*</span>
                        </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">

                          <input name="status" id="status" type="checkbox" class="tgl tgl-skewed">
                           <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="status"></label>
                          <small class="text-muted">(Please Choose Hotdeal Status) </small>
                        </div>
                      </div>
                    <div class="box-footer">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                           
                              <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                        <button class="btn btn-default "><a href="{{url('admindesk/hotdeal')}}" class="links">Cancel</a></button>
                    </div>
              <!-- /.box -->
            </div>


        <!-- footer content -->
@endsection



