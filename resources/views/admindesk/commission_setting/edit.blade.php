@extends("admindesk/layouts.master")
@section('title','Commision Setting')
@section("body")
      
        <div class="box" >
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Commision Setting</h2>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/commission_setting/')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/commission_setting/'.$commission->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                        {{ method_field('PUT') }}
                      <div class="form-group" id="dd">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Set Commission
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="type" id="type" class="form-control col-md-7 col-xs-12">
                            <option value="c" {{ $commission->type == 'c' ? 'selected="selected"' : '' }} >Category</option>
                            <option value="flat" {{ $commission->type == 'flat' ? 'selected="selected"' : '' }}>Flat For All</option>
                          </select>
                          <small class="txt-desc">(Please Choose Commission Type )</small>
                        </div>
                      </div>
                      <div class="form-group" id="p_type" @if($commission->type == 'c') class="display-none" @endif >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Price Type
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="p_type" class="form-control col-md-7 col-xs-12">
                            <option value="p" <?php echo ($commission->p_type=='p')?'selected':'' ?>>Percentage</option>
                            <option value="f" <?php echo ($commission->p_type=='f')?'selected':'' ?>>Fix Amount</option>
                          </select>
                          <small class="txt-desc">(Please Choose Price Type) </small>
                        </div>
                      </div>
                      <div class="form-group" id="rate" @if($commission->type == 'c') class="display-none" @endif>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Rate <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter Commission rate" type="text" name="rate" value="{{$commission->rate}}" class="form-control col-md-7 col-xs-12">
                         
                        </div>
                      </div>
                      <div class="box-footer">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" @endif class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                        
                      </div>
               
@endsection

