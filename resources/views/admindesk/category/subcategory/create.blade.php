@extends("admindesk/layouts.master")
@section('title','Add New Subcategory |')
@section("body")
            
              <div class="box" >
                <div class="box-header with-border">
                  <h3 class="box-title">Add SubCategory</h3>
                </div>
                      <div class="panel-heading">
                          <a href=" {{url('admindesk/subcategory')}} " class="btn btn-success pull-right owtbtn">< Back</a>
                    </div>  
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/subcategory')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Parent Category: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="parent_cat" class="form-control col-md-7 col-xs-12">
                          
                            @foreach($parent as $p)
                            <option value="{{$p->id}}">{{$p->title}}</option>
                            @endforeach
                          </select>
                           <small class="txt-desc">(Please Choose Parent Category)</small>
                        </div>

                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-md btn-primary">+</button>

                      

                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                         Subcategory: <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter Subcategory name" type="text" id="first-name" name="title" class="form-control col-md-7 col-xs-12">
                        
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Icon:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          
                           <div class="input-group">
                                    <input data-placement="bottomRight" class="form-control icp icp-auto action-create" name="icon" value="fa-archive" type="text" />

                                    <span class="input-group-addon"></span>
                           </div>

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
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="tgl tgl-skewed" id="toggle-event2" type="checkbox"/>
                          <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="toggle-event2"></label>
                         <input type="hidden" name="featured" value="0" id="featured">
                         <small class="txt-desc">(If enabled than Subcategory will be featured) </small>
                        </div>
                       </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input id="toggle-event3" type="checkbox" name="status" class="tgl tgl-skewed">
                         <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                     
                         <small class="txt-desc">(Please Choose Status) </small>
                        </div>
                      </div>
                      
              <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                 
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add</button>
              </div>
            </form>
       
          </div>
          <!-- /.box -->
       
          

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                <textarea name="detail" id="editor2" cols="30" rows="10"></textarea>
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
                                 <input id="toggle-event4" type="checkbox" class="tgl tgl-skewed">
                                 <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event4"></label>
                                 <input type="hidden" value="0" name="status" id="status4">
                                 <br>
                                  <label for="">Featured:</label>
                                 <input id="toggle-event5" type="checkbox" class="tgl tgl-skewed">
                                 <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="toggle-event5"></label>
                                 <input type="hidden" value="0" name="featured" id="status5">
                                 <br>
                                <input type="submit" value="+ ADD" class="btn btn-primary btn-md">
                              </form>
                            </div>
                            
                          </div>
                        </div>
                      </div>

@endsection
