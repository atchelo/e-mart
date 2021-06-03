@extends("admindesk/layouts.master")
@section('title','Special offer Widgets Setting')
@section("body")


		
			  <!-- general form elements -->
			  <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">
			     Special offer Widgets
			  </h3>
            </div>
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/sp_offer_widget')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Slide Number <span class="required color-red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter How many slide Number" type="text" id="first-name" name="slider" value=" {{$slide->slide_count ?? ''}} " class="form-control col-md-7 col-xs-12">
                         
                        </div>
                      </div>
                      
                      <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  
                <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This cannot is disabled in demo" @endif class="btn btn-primary">Submit</button>
              </div>
            </form>
			
          </div>
          <!-- /.box -->
      

@endsection
