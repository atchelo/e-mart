@extends("admindesk/layouts.master")
@section('title',"Edit Category: $cat->title |")
@section("body")



        
          <div class="box" >
            <div class="box-header with-border">
              <h3 class="box-title">Edit Category</h3>
            </div>
            <div class="panel-heading">
                          <a href=" {{url('admindesk/category')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                    </div>   
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/category/'.$cat->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Category: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter category name" type="text" id="first-name" name="title" value="{{$cat->title}}" class="form-control col-md-7 col-xs-12">
                             
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <textarea cols="2" id="editor1" name="description" rows="5" >
                          {{ucfirst($cat->description)}}
                         </textarea>
                         <small class="txt-desc">(Please Enter Description)</small>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Icon:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          
                           <div class="input-group">
                                    <input data-placement="bottomRight" class="form-control icp icp-auto action-create" name="icon" value="{{ $cat->icon }}" type="text" />

                                    <span class="input-group-addon"></span>
                           </div>

                        </div>
                      </div>
				             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Image:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            @if(@file_get_contents('images/category/'.$cat->image))
                            <img width="50px" height="80px" src=" {{url('images/category/'.$cat->image)}}">
                          @else
                            <img title="{{ $cat->title }}" src="{{ Avatar::create($cat['title'])->toBase64() }}" />
                          @endif
                          <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
                          <br>
                           <small class="txt-desc">(Please choose a Image)</small>
                          </div>
                      </div>
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Featured:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="tgl tgl-skewed" id="toggle-event2" <?php echo ($cat->featured=='1')?'checked':'' ?> type="checkbox"/>
                            <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="toggle-event2"></label>
                          <input type="hidden" name="featured" value="{{$cat->featured}}" id="featured">
                          
                         <small class="txt-desc">(If enabled than Category will be featured)</small>
                        </div>
                       </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input class="tgl tgl-skewed" id="toggle-event3" type="checkbox" <?php echo ($cat->status=='1')?'checked':'' ?>>
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                        <input type="hidden" name="status" value="{{$cat->status}}" id="status3">
                         <small class="txt-desc">(Please Choose Status )</small>
                        </div>
                      </div>
                             <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                 
                <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" @endif class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
              </div>
            </form>
      
          </div>
          <!-- /.box -->
       
@endsection
