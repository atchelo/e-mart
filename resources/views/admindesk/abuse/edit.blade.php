@extends("admindesk/layouts.master")
@section('title','Abuse Word Settings | ')
@section("body")


			
			  <!-- general form elements -->
			  <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">
			  Abuse Word Settings
			  </h3>
            </div>

            <br>
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/abuse/')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Abuse Words <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter Abuse Word" type="text" id="first-name" data-role="tagsinput" name="name" value=" {{$abuse->name}} " class="form-control col-md-7 col-xs-12">
                         
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Replace Words <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter Replace Word" type="text" id="first-name" name="rep" data-role="tagsinput" value=" {{$abuse->rep}} " class="form-control col-md-7 col-xs-12">
                         
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input <?php echo ($abuse->status=='1')?'checked':'' ?> id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                        <input type="hidden" name="status" value="{{$abuse->status ?? ''}}" id="status3">
                         <small class="txt-desc">(Please Choose Status )</small>
                        </div>
                      </div>
                      <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  
                <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="This operation is disabled is demo !" @endif class="btn btn-primary">Update</button>
              </div>
            </form>
			
          </div>
          <!-- /.box -->
       


@endsection

