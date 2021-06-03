@extends("admindesk/layouts.master")
@section('title','Edit Country | ')
@section("body")
   
          <div class="box">
            <div class="box-header with-border">
                   <h3 class="box-title">Country</h3>

                    <a href=" {{url('admindesk/country')}} " class="btn btn-success pull-right owtbtn">< Back</a>
            </div> 
                       
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/country/'.$country->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Country Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please Enter 3 Name Country Code ex. IND" type="text" id="first-name" name="country" value="{{$country->country}}" class="form-control col-md-7 col-xs-12">
                          
                        </div>
                      </div>
                     
                      <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
      
          </div>
        
@endsection