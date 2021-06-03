@extends("admindesk/layouts.master")
@section('title','Edit Commision')
@section("body")
      <div class="col-xs-12">
        <!-- general form elements -->
        <div class="box box-primary" >
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Commision</h2>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/commission/')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/commission/'.$commission->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                        {{ method_field('PUT') }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Category <span class="required">*</span>
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="category_id" class="form-control col-md-7 col-xs-12" id="country_id">
                          <option value="0">Please Choose</option>
                            @foreach($category as $cat)
                           <option value="{{$cat->id}}" {{ $commission->category_id == $cat->id ? 'selected="selected"' : '' }}>
                              {{$cat->title}}
                            </option>
                            @endforeach
                          </select>
                           <small class="txt-desc">(Please Choose Category)</small>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Rate <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter commission rate" type="text" id="first-name" name="rate" value="{{$commission->rate}}" class="form-control col-md-7 col-xs-12">
                          
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Type <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="type" class="form-control col-md-7 col-xs-12">
                            <option value="p" <?php echo ($commission->type=='p')?'selected':'' ?>>Percentage</option>
                            <option value="f" <?php echo ($commission->type=='f')?'selected':'' ?>>Fix Amount</option>
                          </select>
                          <small class="txt-desc">(Please Choose Type) </small>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input <?php echo ($commission->status=='1')?'checked':'' ?> id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                        <input type="hidden" name="status" value="{{$commission->status ?? ''}}" id="status3">
                         <small class="txt-desc">(Please Choose Status) </small>
                        </div>
                      </div>
                      
                      <div class="box-footer">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" @endif class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                        
                      </div>
                <!-- /.box -->
                </div>


        <!-- footer content -->
@endsection
