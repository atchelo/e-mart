@extends("admindesk/layouts.master")
@section('title','Add new tax rate | ')
@section("body")
      
        <div class="box">
        <div class="box-header with-border">
          <div class="box-title">Add Tax Rate</div>
          <a title="Go back" href="{{url('admindesk/tax')}} " class="btn btn-success pull-right owtbtn">< Back</a>
             <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/tax')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Tax Name <span  class="required">*</span>
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                          </select>
                          
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Zone <span  class="required">*</span>
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                           <select name="zone_id" class="form-control col-md-7 col-xs-12" id="country_id">
                          <option value="0">Please Choose</option>
                            @foreach(App\zone::all() as $zone)
                           <option value="{{$zone->id}}">
                              {{$zone->title}}
                            </option>
                            @endforeach
                          </select>
                           <small class="txt-desc">(Tax will be applied only to the selected zones.)</small>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Rate <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter rate" type="text" id="first-name" name="rate" value="{{old('rate')}}" class="form-control col-md-7 col-xs-12">
                          
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Type <span  class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="type" class="form-control col-md-7 col-xs-12">
                            <option value="p">Percentage</option>
                            <option value="f">Fix Amount</option>
                          </select>
                          <small class="txt-desc">(Please Choose Tax Type )</small>
                        </div>
                      </div>
                     
                      
                      <div class="box-footer">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                        
                      </div>
               
@endsection
