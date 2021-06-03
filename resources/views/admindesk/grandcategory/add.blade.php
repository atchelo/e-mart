@extends("admindesk.layouts.master")
@section('title','Add New Childcategory |')
@section("body")
<div class="box" >
            <div class="box-header with-border">
              <h3 class="box-title"> Child Category</h3>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/grandcategory')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                        </div>   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/grandcategory')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Parent Category: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="parent_id" class="form-control col-md-7 col-xs-12" id="category_id">
                          <option value="0">Please Select</option>
                            @foreach($parent as $p)
                            <option value="{{$p->id}}">{{$p->title}}</option>
                            @endforeach
                          </select>
                           <span class="text-red">{{$errors->first('parent_id')}}</span>
                           <small class="txt-desc">(Please Choose Parent Category)</small>
                        </div>
                        <button title="Add Category" type="button" data-target="#catModal" data-toggle="modal" class="btn btn-md btn-primary">+</button>
                      </div>
                      <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Subcategory: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="subcat_id" class="form-control col-md-7 col-xs-12" id="upload_id">
                        </select>
                        <small class="txt-desc">(Please Choose Subcategory) </small>
                      </div>

                      <button data-toggle="modal" data-target="#subModal" title="Add Subcategory" type="button" class="btn btn-md btn-primary">
                        +
                      </button>
                    </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Child Category <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="title" class="form-control col-md-7 col-xs-12">
                          <small class="txt-desc">(Please Enter Childcategory Name)</small>
                        </div>

                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <textarea cols="2" id="editor1" name="description" rows="5" >
                         </textarea>
                         <small class="txt-desc">(Please Enter Description)</small>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Image:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
                           <small class="txt-desc">(Please Choose image)</small>
                          </div>
                      </div>
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Featured:
                        </label>
                        
                        <input class="tgl tgl-skewed" id="toggle-event3" type="checkbox"/>
                          <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="toggle-event3"></label>

                          <input value="0" type="hidden" id="featured" name="featured">
                           
                        
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status: <span class="required">*</span>
                        </label>

                        <input class="tgl tgl-skewed" id="toggle-event2" type="checkbox"/>
                          <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event2"></label>
                        <input value="0" type="hidden" id="status" name="status">
                      </div>
                    <div class="box-footer">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                       
                      <button type="submit" class="btn btn-primary">+ ADD</button>
                    </div>
                  </form>
                    
                </div>
    

<div class="modal fade" id="subModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Add Category</h4>
                            </div>

                            <div class="modal-body">
                              <form enctype="multipart/form-data" action="{{ route('quick.sub.add') }}" method="POST">
                                {{ csrf_field() }}
                                
                                <label for="">Select Category:</label>
                                <select name="category" id="" class="form-control col-md-2">
                                  @foreach($category = App\Category::all() as $cat)
                                  <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                  @endforeach
                                </select>
                                <br><br><br>
                                <label for="">Subcategory Name:</label>
                                <input required type="text" class="form-control" placeholder="Enter Subcategory name" name="title" />
                                <br>
                                <label for="">Description:</label>
                                <textarea name="detail" class="editor" cols="30" rows="10"></textarea>
                                <br>
                                <label for="">Icon:</label>
                                <div class="input-group">
                                    <input data-placement="bottomRight" class="form-control icp icp-auto action-create" name="icon" value="fa-archive" type="text" />
                                    <span class="input-group-addon"></span>
                                </div>
                                <br>
                                <label for="">Category Image:</label>
                                <input type="file" name="image" class="form-control"/>
                                <br>
                                <label for="">Status:</label>
                                 <input name="status" id="statuscat" type="checkbox" class="tgl tgl-skewed">
                                 <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="statuscat"></label>
                                 
                                 <br>
                                  <label for="">Featured:</label>
                                 <input name="featured" id="featuredcat" type="checkbox" class="tgl tgl-skewed">
                                 <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="featuredcat"></label>
                                 
                                 <br>
                                <input type="submit" value="+ ADD" class="btn btn-primary btn-md">
                              </form>
                            </div>
                            
                          </div>
                        </div>
                      </div>


<div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Add Category</h4>
                            </div>

                            <div class="modal-body">
                              <form enctype="multipart/form-data" action="{{ route('quick.cat.add') }}" method="POST">
                                {{ csrf_field() }}
                                <label for="">Category Name:</label>
                                <input required type="text" class="form-control" placeholder="Enter category name" name="title" />
                                <br>
                                <label for="">Description:</label>
                                <textarea name="detail" class="editor" cols="30" rows="10"></textarea>
                                <br>
                                <label for="">Icon:</label>
                                <div class="input-group">
                                    <input data-placement="bottomRight" class="form-control icp icp-auto action-create" name="icon" value="fa-archive" type="text" />
                                    <span class="input-group-addon"></span>
                                </div>
                                <br>
                                <label for="">Category Image:</label>
                                <input type="file" name="image" class="form-control"/>
                                <br>
                                <label for="">Status:</label>
                                 <input name="status" id="statussub" type="checkbox" class="tgl tgl-skewed">
                                 <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="statussub"></label>
                                
                                 <br>
                                  <label for="">Featured:</label>
                                 <input name="featured" id="featuredsub" type="checkbox" class="tgl tgl-skewed">
                                 <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="featuredsub"></label>
                                 
                                 <br>
                                <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-plus-circle"></i> ADD</button>
                              </form>
                            </div>
                            
                          </div>
                        </div>
                      </div>
          

              
                      
@endsection