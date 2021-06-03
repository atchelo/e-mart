@extends("admindesk/layouts.master")
@section('title','Add New Faq | ')
@section("body")
     <div class="box">
            <div class="box-header with-border">
                    <h3 class="box-title"> Add Faq</h3>
                    <div class="panel-heading">
                    <a href=" {{url('admindesk/faq')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                  </div> 
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/faq')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Question <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter Question" type="text" id="first-name" name="que" value="{{old('que')}}" class="form-control col-md-7 col-xs-12">
                          
                        </div>
                      </div>
                        
					           <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Answer <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea rows="5" cols="10" placeholder="Please enter answer" type="text" id="first-name" name="ans" value="{{old('ans')}}" class="form-control"></textarea>
                          
                        </div>
                      </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status
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
        
@endsection
