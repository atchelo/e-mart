@extends("admindesk/layouts.master")
@section('title','Edit City')
@section("body")


              <div class="col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title">
                  City
                  </h3>
                      </div>
                    
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/city/'.$city->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          City <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="city_name" value=" {{$city->city_name}} " class="form-control col-md-7 col-xs-12">
                        <p class="txt-desc">Please Enter City </p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          State
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="state_id" class="form-control col-md-7 col-xs-12">
                          
                            @foreach($state as $states)
                                <option value="{{$states->id}}">{{$states->state}}</option>
                            @endforeach
                          </select>
                          <p class="txt-desc">Please Chooce State </p>
                        </div>
                      </div>
                      <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
      <button class="btn btn-default "><a href="{{url('admindesk/city')}}" class="links">Cancel</a></button>
          </div>
          <!-- /.box -->
        </div>

        <!-- footer content -->
@endsection