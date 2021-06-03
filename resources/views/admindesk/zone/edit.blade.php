@extends("admindesk/layouts.master")
@section('title','Edit zone | ')
@section("body")

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Zone</h3>
            </div>
            
            <!-- /.box-header -->
            <!-- form start -->
            <div class="panel-heading">
                          <a href=" {{url('admindesk/zone')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                    </div> 
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/zone/'.$zone->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                {{ method_field('PUT') }}

                  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Zone Name: <span class="required">*</span>
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required value="{{ $zone->title }}" placeholder="Ex. North Zone" type="text" class="form-control" name="title">
                       </div>
                  </div>


                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Country <span class="required">*</span>
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="country_id" class="form-control col-md-7 col-xs-12" id="country_id">
                          <option value="0">Please Choose</option>
                            @foreach($country as $c)
                            <?php
                              $iso3 = $c->country;

                              $country_name = DB::table('allcountry')->
                              where('iso3',$iso3)->first();
							               ?>
                            <option value="{{$country_name->id}}" {{ $country_name->id == $zone->country_id ? 'selected="selected"' : '' }} >
                              {{$country_name->nicename}}
                            </option>
                           @endforeach
                          </select>
                           <p class="txt-desc">Please Choose Country</p>
                        </div>
                      </div>

                   
                      
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            Select Zone: <span class="required">*</span>
                          </label>
                        
                         <div class="col-md-6 col-sm-6 col-xs-12">
                           <select multiple="multiple" class="js-example-basic-single width100" name="name[]" id="upload_id">
                                @foreach ($states as $item)
                               
                                @if($zone->name != '')
                                    <option @foreach($zone->name as $c)
                                          {{$c == $item->id ? 'selected' : ''}}
                                          @endforeach
                                          value="{{ $item->id }}">{{ $item->name }}</option>
                                 @else
                                 <option value="{{ $item->id }}">{{ $item->name }}</option>
                                 @endif
                                @endforeach
                            </select>
                          </div>

                           <a onclick="SelectAllCountry2()" id="btn_sel"class="btn btn-info" isSelected="no"> 
                          <span>Select All  </span><i class="fa fa-check-square-o"></i>
                         </a>

                         <a onclick="RemoveAllCountry2()" id="btn_rem"class="btn btn-danger" isSelected="yes"> 
                          <span>Remove All  </span><i class="fa fa-window-close"></i>
                         </a>
                        </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Code <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="code" value="{{$zone->code}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter code</p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="checkbox" id="toggle-event33" class="tgl tgl-skewed" <?php echo ($zone->status=='1')?'checked':'' ?> >
                          <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event33"></label>
                         <input type="hidden" name="status" value="{{$zone->status}}" id="status3">
                         <p class="txt-desc">Please Choose Status </p>
                        </div>
                      </div>
              <!-- /.box-body -->
                <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" title="This action is disabled in demo !" @endif class="btn btn-primary">Submit</button>
              </div>
            </form>
       
          </div>
       
@endsection

@section('custom-script')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/zone.js') }}"></script> 

@endsection