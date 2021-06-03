@extends("admindesk/layouts.master")
@section('title','Edit Widgtes footer | ')
@section("body")

    <div class="col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" >
            <div class="box-header with-border">
              <h3 class="box-title">Widget footer </h2>
                  <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/widget_footer/'.$row->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                        {{ method_field('PUT') }}
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Widget Name <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="widget_name" 
                          value="{{$row->widget_name}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Widget Name</p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Widget Psition <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <select name="widget_position" class="form-control col-md-7 col-xs-12">
                            <option value="3" <?php echo ($row->widget_position=='3')?'selected':'' ?> >3</option>
                            <option value="4" <?php echo ($row->widget_position=='4')?'selected':'' ?> >4</option>
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
                          value="{{$row->menu_name}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Menu Name</p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Url <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="url" 
                          value="{{$row->url}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Url</p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          status 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="status" class="form-control col-md-7 col-xs-12">
                            <option value="0" <?php echo ($row->status=='0')?'selected':'' ?>>No</option>
                            <option value="1" <?php echo ($row->status=='1')?'selected':'' ?>>Yes</option>
                         </select>
                         <p class="txt-desc">Please Choose Status </p>
                        </div>
                    </div>
                   <div class="box-footer">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                    <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This action is disabled in demo !" disabled="disabled" @endif class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                    <button class="btn btn-default "><a href="{{url('admindesk/widget_footer')}}" class="links">Cancel</a></button>
                  </div>
                  <!-- /.box -->
                </div>



        <!-- footer content -->
@endsection
