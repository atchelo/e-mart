@extends("admindesk/layouts.master")
@section('title','Edit Social Icon')
@section("body")
    
          <div class="box" >
            <div class="box-header with-border">
              <h3 class="box-title">Edit Social Icon @if($row->icon == 'fb') Facebook @elseif($row->icon == 'tw') Twitter @else {{ ucfirst($row->icon) }} @endif </h2>
                  <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/social/'.$row->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        URL:<span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="http://" type="text" id="first-name" name="url" 
                          value="{{$row->url ?? ''}}" class="form-control col-md-7 col-xs-12">
                          
                        </div>
                    </div>
                     
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Icon:<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="icon" class="select2 form-control col-md-7 col-xs-12">
                            <option value="youtube" {{ $row->icon == 'youtube' ? 'selected="selected"' : '' }}>Youtube</option>
                            <option value="linkedin" {{ $row->icon == 'linkedin' ? 'selected="selected"' : '' }}>LinkedIn</option>
                            <option value="pintrest" {{ $row->icon == 'pintrest' ? 'selected="selected"' : '' }}>Pinterest</option>
                            <option value="rss" {{ $row->icon == 'rss' ? 'selected="selected"' : '' }} >RSS Feed</option>
                            <option value="googleplus" {{ $row->icon == 'googleplus' ? 'selected="selected"' : '' }} >Google+</option>
                            <option value="tw" {{ $row->icon == 'tw' ? 'selected="selected"' : '' }}>Twitter</option>
                            <option value="fb" {{ $row->icon == 'fb' ? 'selected="selected"' : '' }} >Facebook</option>
                            <option value="instagram" {{ $row->icon == 'instagram' ? 'selected="selected"' : '' }}>Instagram</option>
                          </select>
                          <small class="txt-desc">Please choose Icon</small>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                      Status:
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <input {{ $row->status ==1 ? "checked" : ""}} id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
                     <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                    <input type="hidden" name="status" value="{{ $row->status }}" id="status3">
                    
                     <small class="txt-desc">(Please Choose Status) </small>
                    </div>
                  </div>

                <div class="box-footer">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                    <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This action cannot be done in demo !" @endif class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>

                    <a href="{{url('admindesk/social')}}" class="btn btn-danger btn-md ">
                      <i class="fa fa-arrow-left"></i> Back
                    </a>
                  </div>
                  </form>
                    
                    
                  </div>
                 

@endsection
