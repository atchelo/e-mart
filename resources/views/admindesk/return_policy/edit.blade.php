@extends("admindesk/layouts.master")
@section('title','Edit Return Policy | ')
@section("body")
        
    <!-- general form elements -->
    <div class="box" >
      <div class="box-header with-border">
        <h3 class="box-title">Edit Return Policy</h3>
      </div>
      <div class="panel-heading">
          <a href=" {{url('admindesk/return-policy')}} " class="btn btn-success pull-right owtbtn">< Back</a>
        </div>  
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/return_policy/update/'.$policy->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                  Policy Name: <span class="required">*</span>
                </label>
                
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input placeholder="Enter Policy Name" type="text" id="first-name" name="name" class="form-control col-md-7 col-xs-12" value="{{$policy->name ?? ''}}">
                </div>

              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                  Amount: <span class="required">*</span>
                </label>
                
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input placeholder="%" type="text" id="first-name" name="amount" class="form-control col-md-7 col-xs-12" value="{{$policy->amount ?? ''}}">
                  <span>(Please enter amount in Percentage)</span>
                  
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                  Return days: <span class="required">*</span>
                </label>
                
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input placeholder="Please enter product return days" type="text" id="first-name" name="days" class="form-control col-md-7 col-xs-12" value="{{$policy->days ?? ''}}">
                 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                  Description: <span class="required">*</span>
                </label>
                
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea cols="2" id="editor1"  value="{{$policy->des ?? ''}}" name="des" rows="5"  class="form-control col-md-7 col-xs-12">
                  {{$policy->des ?? ''}}
                 </textarea>
                  <small class="txt-desc">Please Enter Return Description</small>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                  Status:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <input <?php echo ($policy->status=='1')?'checked':'' ?> id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                 <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                <input type="hidden" name="status" value="{{$policy->status ?? ''}}" id="status3">
                 <small class="txt-desc">(Please Choose Status )</small>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                  Return Accept By:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="max-width-250px col-md-3 form-control" name="return_acp" id="">
                    <option>Please choose</option>
                    <option {{ $policy->return_acp=="auto" ? "selected" : "" }} value="auto">Auto</option>
                    <option {{ $policy->return_acp=="admindesk" ? "selected" : "" }} value="admin">Admin</option>
                    <option {{ $policy->return_acp=="vender" ? "selected" : "" }} value="vender">Vender</option>
                  </select>
                  <br><br>
                 <small class="txt-desc">(Please Choose an option to select who can accept return)</small>
                </div>
              </div>
               
           <div class="box-footer">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
         
        <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This action is disabled in demo !" @endif class="btn btn-primary">Submit</button>
      </div>
    </form>
     
  </div>
        

@endsection
