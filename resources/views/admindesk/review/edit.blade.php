@extends("admindesk/layouts.master")
@section('Remark Review | ')
@section("body")
        
            <div class="box" >
            <div class="box-header with-border">
              <h3 class="box-title">
            Edit Review
            </h3>
                </div>
                 <div class="panel-heading">
                          <a href=" {{url('admindesk/review')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                    </div>   
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/review/'.$review->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Remark <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter remark" type="text" id="first-name" name="remark" value="{{$review->remark}}" class="form-control col-md-7 col-xs-12">
                          
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input <?php echo ($review->status=='1')?'checked':'' ?> id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                        <input type="hidden" name="status" value="{{$review->status ?? ''}}" id="status3">
                         <small class="txt-desc">(Please Choose Status) </small>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        
                          <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This action is disabled in demo !" disabled="disabled" @endif class="btn btn-success">Submit</button>
                          <br>
                        </div>
                      </div>

                    </form>
                   </div>
          <!-- /.box -->
        

@endsection
