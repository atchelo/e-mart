@extends("admindesk/layouts.master")
@section('title','Create new Specialoffer | ')
@section("body")

@section('data-field')
Hot Deals
@endsection

     
          <div class="box" >
            <div class="box-header with-border">
              <h3 class="box-title">Add Special Offer</h3>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/special/')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/special')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
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
                        
                        <div class="col-md-6">
                          <input id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                        <input type="hidden" name="status" value="0" id="status3">
                         <small class="text-desc">(Please Choose Status)</small>
                        </div>
                        

                       
                    </div>
                    <div class="box-footer">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                           
                              <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                        
                    </div>
              <!-- /.box -->
            
@endsection


