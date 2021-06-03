@extends("admindesk/layouts.master")
@section('title','Footer Customization |')
@section("body")
  <div  class="box">
    <div class="box-header with-border">
        <div class="box-title">
          Footer Customization
        </div>

         <a title="Need Help?" data-target="#helpModal" data-toggle="modal" class="cpointer need-help pull-right"><i class="fa fa-question-circle"></i> Need Help</a>
    </div>

    <div class="box-body">
        
        <h3>Footer Widget Customize:</h3>
        <hr>
  
         <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/footer/')}}">
            @csrf

            <div class="row">

              <div class="col-md-3">
                  <div class="card card-1">

                    <div class="user-header">
                      
                      <h4>Footer Section 1 Label:</h4>

                    </div>

                    <div class="padding-15">
                      
                      <div class="form-group">
                        <label>Enter Section 1 Label:</label>
                        <input placeholder="Enter Footer Section 1 title" type="text" name="shiping" value="{{$row->shiping ?? ''}}" class="form-control">
                        <p></p>
                        <label>Choose Icon:</label>
                        <div class="input-group">
                           <div class="input-group-addon"></div>
                            <input class="form-control icp icp-auto action-create" name="icon_section1" value="{{ $row->icon_section1 }}" type="text" />
                        </div>
                        
                      </div>

                    </div>
              
                  </div>
              </div>

              <div class="col-md-3">
                  <div class="card card-1">

                    <div class="user-header">
                      
                      <h4>Footer Section 2 Label:</h4>

                    </div>

                    <div class="padding-15">
                      
                      <div class="form-group">
                        <label>Enter Section 2 Label:</label>
                        <input placeholder="Enter Footer Section 2 title" type="text" name="mobile" value="{{$row->mobile ?? ''}}" class="form-control">
                        <p></p>
                        <label>Choose Icon:</label>
                        <div class="input-group">
                           <div class="input-group-addon"></div>
                            <input class="form-control icp icp-auto action-create" name="icon_section2" value="{{ $row->icon_section2 }}" type="text" />
                        </div>
                      </div>

                    </div>
              
                  </div>
              </div>

             

              <div class="col-md-3">
                  <div class="card card-1">

                    <div class="user-header">
                      
                      <h4>Footer Section 3 Label:</h4>

                    </div>

                    <div class="padding-15">
                      
                      <div class="form-group">
                        <label>Enter Section 3 Label:</label>
                        <input placeholder="Enter Footer Section 4 title" type="text" name="return" value="{{$row->return ?? ''}}" class="form-control">
                        <p></p>
                        <label>Choose Icon:</label>
                        <div class="input-group">
                           <div class="input-group-addon"></div>
                            <input class="form-control icp icp-auto action-create" name="icon_section3" value="{{ $row->icon_section3 }}" type="text" />
                        </div>
                      </div>

                    </div>
              
                  </div>
              </div>

               <div class="col-md-3">
                  <div class="card card-1">

                    <div class="user-header">
                      
                      <h4>Footer Section 4 Label:</h4>

                    </div>

                    <div class="padding-15">
                      
                      <div class="form-group">
                        <label>Enter Section 4 Label:</label>
                        <input placeholder="Enter Footer Section 3 title" type="text" name="money" value="{{$row->money ?? ''}}" class="form-control">
                        <p></p>
                        <label>Choose Icon:</label>
                        <div class="input-group">
                           <div class="input-group-addon"></div>
                            <input class="form-control icp icp-auto action-create" name="icon_section4" value="{{ $row->icon_section4 }}" type="text" />
                        </div>
                      </div>

                    </div>
              
                  </div>
              </div>

            </div>

            <h3>Footer Section Customize:</h3>
            <hr>

            <div class="row">
                <div class="col-md-4">
                  
                  <div class="card card-1">

                    <div class="user-header">
                      
                      <h4>Widget Section 1 Label:</h4>

                    </div>

                    <div class="padding-15">
                        <div class="form-group">
                           <label for="">Enter Widget 1 Title:</label>
                           <input placeholder="Enter Widget1 title" type="text" name="footer2" value="{{$row->footer2 ?? ''}}" class="form-control">
                        </div>
                    </div>

                  </div>

                </div>
                <div class="col-md-4">
                    
                    <div class="card card-1">

                    <div class="user-header">
                      
                      <h4>Widget Section 2 Label:</h4>

                    </div>

                    <div class="padding-15">
                        <div class="form-group">
                           <label for="">Enter Widget 2 Title:</label>
                           <input placeholder="Enter Widget2 title" type="text" name="footer3" value="{{$row->footer3 ?? ''}}" class="form-control">
                        </div>
                    </div>

                  </div>

                </div>
                <div class="col-md-4">
                    <div class="card card-1">

                    <div class="user-header">
                      
                      <h4>Widget Section 3 Label:</h4>

                    </div>

                    <div class="padding-15">
                        <div class="form-group">
                           <label for="">Enter Widget 3 Title:</label>
                           <input placeholder="Enter Widget3 title" type="text" name="footer4" value="{{$row->footer4 ?? ''}}" class="form-control">
                        </div>
                    </div>

                  </div>
                </div>
            </div>

            <p></p>
            <div class="form-group">
              <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" @endif class="btn btn-md btn-primary">
                <i class="fa fa-save"></i> Save Settings !
              </button>
            </div>
         </form>
    </div>
  </div>

  <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="width60 modal-dialog model-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Example of Footer Widgets & Footer Sections</h4>
        </div>

        <div class="modal-body">
            <img src="{{ url('images/footerhelp.png') }}" title="Footer Help Example" alt="help-footer" class="img-responsive">
        </div>
       
      </div>
    </div>
  </div>
@endsection
