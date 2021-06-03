@extends("admindesk/layouts.master")
@section('title','Edit Shipping '.$shipping->name.' | ')

@section("body")

        <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Shipping </h3>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/shipping')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/shipping/'.$shipping->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                     
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Shipping Title <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input disabled="disabled" placeholder="Please enter shipping title" type="text" name="name" class="form-control col-md-7 col-xs-12" value="{{$shipping->name}}">
                          
                        </div>
                      </div>
                       @if($shipping->id != 1)
                       <div class="form-group">
                       
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Price <span class="required">*</span>
                        </label>
                      
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter price" type="text" name="price" class="form-control col-md-7 col-xs-12" value="{{$shipping->price}}">
                       </div>
                      </div>
                        @endif

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input <?php echo ($shipping->login=='1')?'checked':'' ?> id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                        <input type="hidden" name="login" value="{{$shipping->login ?? ''}}" id="status3">
                         <small class="txt-desc">(Please Choose Status) </small>
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
                </div>
           
@endsection
