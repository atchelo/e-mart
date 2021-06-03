@extends("admindesk/layouts.master")
@section('title',"Edit Post - $blog->heading | ") 
@section("body")
  <div class="box">
     
     <div class="box-header with-border">
       
       <div class="box-title">
         <a title="Go back" href="{{ route('blog.index') }}" class="btn btn-md btn-default"><i class="fa fa-reply"></i></a>
         <div class="box-title"> Edit Post: {{ $blog->heading }} </div>
       </div>

     </div>


     <div class="box-body">
       <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/blog/'.$blog->id)}}" data-parsley-validate class="form-horizontal form-label-left"> {{csrf_field()}} {{ method_field('PUT') }}
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Heading <span class="required">*</span> </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input placeholder="Enter heading" type="text" id="first-name" name="heading" value="{{ucfirst($blog->heading)}}" class="form-control col-md-7 col-xs-12"> </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description <span class="required">*</span> </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea cols="2" id="editor1" name="des" rows="5"> {{ucfirst($blog->des)}} </textarea> <small class="txt-desc">(Please Enter Description)</small> </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Author Name: <span class="required">*</span> </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input placeholder="Enter writer name" type="text" id="first-name" name="user" value="{{ucfirst($blog->user)}}" class="form-control col-md-7 col-xs-12">
        <p class="txt-desc">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">About Author: (optional) </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea placeholder="Write something about author" type="text" id="editor1" name="about" value="{{ucfirst($blog->about)}}" class="form-control col-md-7 col-xs-12"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Designation: (optional) </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" placeholder="About author designation eg. CEO, Admin" id="first-name" name="post" value="{{ucfirst($blog->post)}}" class="form-control col-md-7 col-xs-12"> </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image <span class="required">*</span> </label>
      <div class="col-md-6 col-sm-6 col-xs-12"> <img  src=" {{url('images/blog/'.$blog->image)}}" class="width-70px height-100"/>
        <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
        <br> <small class="txt-desc">(Choose Image for blog post)</small> </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input {{$blog->status ==1 ? "checked" : ""}} id="toggle-event3" type="checkbox" class="tgl tgl-skewed">
        <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
        <input type="hidden" name="status" value="{{ $blog->status }}" id="status3">
        <small class="txt-desc">(Choose status for your post) </small>
      </div>
    </div>
    <div class="box-footer">
      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save"></i> Update Post
        </button>
      </div>
    </div>
  </form>
     </div>
  </div>

  <div class="box">
     <div class="box-header with-border">
       <div class="box-title">
         <i class="fa fa-comments-o"></i> Manage Comments
       </div>

     </div>
    
    <div class="box-body">
       <table id="commenttable" class="table table-bordered">
         <thead>
           <th>#</th>
           <th>Name</th>
           <th>Comment</th>
           <th>Action</th>
         </thead>

         <tbody>
           <tr>
             
           </tr>
         </tbody>
       </table>
    </div>

  </div>
@endsection 
@section('custom-script')
  <script>
    var url = {!! json_encode( route('load.edit.postcomments',$blog->id) ) !!};
  </script>
  <script src="{{ url('js/blogcomment.js') }}"></script>
@endsection
