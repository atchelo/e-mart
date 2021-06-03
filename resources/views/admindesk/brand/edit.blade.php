@extends("admindesk/layouts.master")
@section('title',"Edit Brand: $brand->name | ")
@section("body")


		
			  <div class="box" >
				<div class="box-header with-border">
				  <div class="box-title">Brand</div>
        <a href=" {{url('admindesk/brand')}} " class="btn btn-success pull-right">< Back</a>
            </div>
                    
                          
                        
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/brand/'.$brand->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Brand Name: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter brand name" type="text" id="first-name" name="name" value=" {{$brand->name}} " class="form-control col-md-7 col-xs-12">
                         
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Brand Image <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          @if($image = @file_get_contents('images/brands/'.$brand->image))
                          <img src=" {{url('images/brands/'.$brand->image)}} " height="50px" width="70px">
                          @else
                          <img src=" {{ Avatar::create($brand->name)->toBase64() }}" height="50px" width="70px">
                          @endif
                          <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
                          <br>
                          <small class="txt-desc">(Please Choose Brand Image)</small>
                        </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            Select Category: <span class="required">*</span>
                          </label>
                          
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            
                            <select multiple="multiple" class="js-example-basic-single" name="category_id[]" >
                            @foreach (App\Category::all() as $item)
                           
                             @if($brand->category_id != '')
                                <option @foreach($brand->category_id as $c)
                                      {{$c == $item->id ? 'selected' : ''}}
                                      @endforeach
                                      value="{{ $item->id }}">{{ $item->title }}</option>
                             @else
                             <option value="{{ $item->id }}">{{ $item->title }}</option>
                             @endif
                            @endforeach
                            </select>
                           
                          </div>
                        </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Show Image Footer <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input name="show_image" id="show-image"  <?php echo ($brand->show_image=='1')?'checked':'' ?> type="checkbox" class="tgl tgl-skewed">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="show-image"></label>
                         <small class="txt-desc">(If You Choose Active Then Image Show In Footer Brand Logo) </small>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input <?php echo ($brand->status=='1')?'checked':'' ?> id="toggle-event3" type="checkbox" class="tgl tgl-skewed" name="status">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                        
                         <small class="txt-desc">(Please Choose Status )</small>
                        </div>
                      </div>
                      <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  
                <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-primary">Submit</button>
              </div>
            </form>
			
          </div>
          <!-- /.box -->
      
@endsection
