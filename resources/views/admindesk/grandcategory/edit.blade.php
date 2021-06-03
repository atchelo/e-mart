
@extends("admindesk/layouts.master")
@section('title',"Edit Childcategory: $cat->title |")
@section("body")


          <div class="box" >
            <div class="box-header with-border">
              <h3 class="box-title">Child Category </h3>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/grandcategory')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/grandcategory/'.$cat->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                         Parent Category: <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="parent_id" class="form-control col-md-7 col-xs-12" id="category_id">
                           @foreach($parent as $p)
                            <option {{ $p['id'] == $cat->category->id ? "selected" : "" }} value="{{$p->id}}"/>{{$p['title']}}</option>
                            @endforeach
                          </select>
                           <small class="txt-desc">(Please Choose Parent Category)</small>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Subcategory: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="subcat_id" class="form-control col-md-7 col-xs-12" id="upload_id">
                            @foreach($subcat as $sub)
                              <option {{ $sub->id == $cat->subcategory->id ? "selected" : "" }} value="{{ $sub->id }}">{{ $sub->title }}</option>
                            @endforeach
                          </select>
                          <small class="txt-desc">(Please Choose Subcategory) </small>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                         Child Category: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="title" value=" {{$cat['title']}} " class="form-control col-md-7 col-xs-12">
                           <small class="txt-desc">(Please Enter Category Name)</small>
                        </div>
                      </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <textarea cols="2" id="editor1" name="description" rows="5" >
                          {{ucfirst($cat->description)}}
                         </textarea>
                         <small class="txt-desc">(Please Enter Description)</small>
                        </div>
                     </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Image:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          @if(@file_get_contents('images/grandcategory/'.$cat->image))
                            <img src=" {{url('images/grandcategory/'.$cat->image)}}" class="height-50">
                          @else
                            <img title="{{ $cat->title }}" src="{{ Avatar::create($cat['title'])->toBase64() }}" />
                          @endif
                          
                          <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
                          <br>
                           <small class="txt-desc">(Please Choose image)</small>
                          </div>
                      </div>
                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Featured:
                        </label>
                        
                        <input {{ $cat->featured==1 ? 'checked' : '' }} class="tgl tgl-skewed" id="toggle-event3" type="checkbox"/>
                          <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="toggle-event3"></label>

                          <input type="hidden" value="{{ $cat->featured }}" id="featured" name="featured">
                           
                        
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status: <span class="required">*</span>
                        </label>

                        <input name="status" {{ $cat->status == 1 ? 'checked' : '' }} class="tgl tgl-skewed" id="toggle-event2" type="checkbox"/>
                        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event2"></label>
                      </div>
                      <div class="box-footer">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        
                      <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" @endif class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                    </div>
                  </form>
                  
                </div>
                <!-- /.box -->
            
@endsection

