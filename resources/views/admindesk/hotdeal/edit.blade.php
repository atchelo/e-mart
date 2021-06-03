@extends("admindesk/layouts.master")

@section("body")

@section('data-field')
Hot Deals
@endsection

        <div class="col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" >
            <div class="box-header with-border">
              <h3 class="box-title">Hot Deal </h3>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/hotdeal')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/hotdeal/'.$products->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                    
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Created Date
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class='input-group date' id='datetimepicker1'>
                          <input name="start" type='text' id="datetimepicker1" value="{{ $products->start }}" class="form-control" />
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
                          <input name="end" type='text' id="datetimepicker2" value="{{ $products->end }}" class="form-control" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                          
                        </div>
                      </div>

                    <?php $product = App\Product::all();?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Product name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="pro_id" class="form-control col-md-7 col-xs-12">
                            <option value="0">Please Select Product</option>
                            @foreach($product as $pro)
                            <option value="{{$pro->id}}" {{ $pro->id == $products->pro_id ? 'selected="selected"' : '' }}>{{$pro->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                       
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <input {{ $products->status ==1 ? "checked" : "" }} id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                        <input type="hidden" name="status" value="{{ $products->status }}" id="status3">

                          
                         
                         <small class="txt-desc">(Please Choose Status) </small>
                        </div>
                      </div>
                    
                    <div class="box-footer">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                           
                              <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                        <button class="btn btn-default "><a href="{{url('admindesk/hotdeal')}}" class="links">Cancel</a></button>
                    </div>
              <!-- /.box -->
            </div>

        <!-- footer content -->
@endsection

