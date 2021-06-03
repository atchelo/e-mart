@extends("admindesk/layouts.master")
@section('title','Add city')
@section("body")

        <div class="col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">City</h3>
            </div>
            <div class="box-body">
            <!-- /.box-header -->
            <!-- form start -->
                   
            <button class="btn btn-default "><a href="{{url('admindesk/city')}}" class="links">Cancel</a></button>
          </div>
          <!-- /.box -->
        </div>


<div class="container">
  <!-- Trigger the modal with a button -->
  

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add State</h4>
        </div>
        <div class="modal-body">
          
        </div>
        <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/state')}}" data-parsley-validate class="form-horizontal form-label-left">
                        
                        {{csrf_field()}}
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          State <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="state" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter State</p>
                        </div>

                      </div>
        
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Country
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="country_id" class="form-control col-md-7 col-xs-12">
                            @foreach($countrys as $country)
                                <option value="{{$country->id}}">{{$country->country}}</option>
                            @endforeach
                          </select>
                          <p class="txt-desc">Please Chooce Country</p>
                        </div>
                      </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                 
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
        <!-- footer content -->
@endsection