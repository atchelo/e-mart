@extends("admindesk/layouts.master")
@section('title','Create Menu | ')
@section("body")
<div class="box">
    <div class="box-header with-border">
      <div class="box-title">
        Add a new menu
      </div>

      <a title="Go back" href="{{ url()->previous() }}" class="pull-right btn btn-md btn-default">
          <i class="fa fa-reply"></i> Back
      </a>
    </div>

    <div class="box-body">

      <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

          <div class="col-md-4">
            <label>
              <h3><input checked class="link_by" type="radio" name="link_by" value="cat"> Link By Categories</h3>
            </label>
            <hr>
            <label>
              <h3><input class="link_by" type="radio" name="link_by" value="page"> Link By Page</h3>
            </label>
            <hr>
            <label>
              <h3><input class="link_by" type="radio" name="link_by" value="url"> Link By Custom URL</h3>
            </label>
            <hr>
            <button type="submit" class="btn btn-success btn-lg">+ Create Menu</button>
          </div>

          <div class="col-md-8">
            <div class="form-group">
              <label>Menu name: <span class="required">*</span></label>
              <input value="{{ old('title') }}" name="title" type="text" class="form-control" placeholder="enter menu menu name" required>
            </div>

            <div class="form-group">
              <label>Menu icon : </label>
               <div id="icongroup">
                
                  <div class="input-group">
                    <input value="{{ old('icon') }}" data-placement="bottomRight" class="form-control icp icp-auto" name="icon" type="text" />
                    <span class="input-group-addon"></span>
                  </div>
                
              </div>
            </div>

            <div class="form-group categorybox">
              <label>Select categories:</label>
              <select required name="cat_id" class="form-control select2 category_id" id="category_id">
                    <option value="">Please Select</option>
                    @foreach($category->where('status','=','1') as $p)
                      <option value="{{$p->id}}">{{$p->title}}</option>
                    @endforeach
              </select>
            </div>

            <div class="form-group display-none pagebox">
              <label>Select pages:</label>
              <select name="page_id" id="pageselector" class="pageselector form-control select2">
                    <option value="">Please Choose</option>
                    @foreach($pages as $page)
                    <option value="{{$page->id}}">{{$page->name}}</option>
                    @endforeach
              </select>
            </div>

            <div class="form-group urlbox display-none">
                <label>URL: <span class="required">*</span></label>
                <input class="url form-control" type="url" placeholder="enter custom url" name="url">
            </div>

            <div class="form-group categoryboxoption">
                <label>Show categories in dropdown menu:</label>
                <br>
                <label class="switch">
                    <input type="checkbox" name="show_cat_in_dropdown" class="show_cat_in_dropdown">
                    <span class="knob"></span>
                </label>
            </div>

            <div id="maincat" class="form-group maincat display-none">
                <label for="name">Category</label>
                <ul class="list-group list-group-root well"> 
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                 @foreach(App\Category::where('status','1')->get(); as $item)  
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-parent="#accordion" aria-expanded="true" aria-controls="collapseOne">

                            <input id="categories_{{$item->id}}" type="checkbox" class="pr_cat required_one categories" name="parent_cat[]" value="{{$item->id}}">

                            <i data-toggle="collapse" href="#test{{$item->id}}" class="more-less glyphicon glyphicon-plus"></i> {{$item->title}}
                        </a>
                    </h4>
                  </div>
                <div id="test{{$item->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  @php
                    $dataList = $item->subcategory->where('status','1')->all();
                  @endphp

                  <div class="row left-15">
                    @foreach($dataList as $data)
                    <div class="col-md-6">
                      <label><input type="checkbox" name="child_cat[]" class="categories_panel required_one sub_categories sub_categories_{{$item->id}}" parents_id = "{{$item->id}}" value="{{$data['id']}}">&nbsp;{{$data['title']}}</label>
                    </div>
                    @endforeach   
                  </div>
                  
                </div>
                @endforeach
              </div>  
              </div>  
              </ul> 
            </div>

            <div class="form-group subcategoriesoption">
                <label>Show subcategories and childcategories in dropdown menu:</label>
                <br>
                <label class="switch">
                    <input class="show_child_in_dropdown" type="checkbox" name="show_child_in_dropdown" id="show_child_in_dropdown">
                    <span class="knob"></span>
                </label>
            </div>

            <div class="subcat">
              
            </div>

            <div class="form-group advertiseoption display-none">
                <label>Show advertise in mega menu:</label>
                <br>
                <label class="switch">
                    <input class="show_image" type="checkbox" name="show_image" id="show_image">
                    <span class="knob"></span>
                </label>
            </div>

             <div id="imgBanner" class="imgBanner display-none">
              <div class="form-group">

                <label>
                         Choose Side Menu Banner Image:
                </label>

                <input type="file" name="image" class="form-control">           
                

              </div>  

              <div class="form-group">
                <label>Image Link:</label>

                <input placeholder="http://" type="url" name="img_link" class="form-control">           
                <small class="help-block"><i class="fa fa-question-circle"></i> Target URL so user click on image than where to redirect him/her.</small>
              </div>     
            </div>

            <div class="form-group">
                <label>Menu Tag::</label>
                <br>
                <label class="switch">
                    <input class="menu_tag" type="checkbox" name="menu_tag" id="menu_tag">
                    <span class="knob"></span>
                </label>
            </div>

            <div id="color" class="tagcolor form-group display-none">
                <label>Tag Background:</label>
                <input type="color" name="tag_background" class="form-control" value="#FDD922">
            </div>

            
            <div class="tagtextcolor form-group display-none">
                <label>Tag Text Color:</label>
                <input type="color" name="tag_color" class="form-control" value="#157ED2">
            </div>

            <div class="tagbgcolor form-group display-none">
              <label>Tag Text:</label>
              <input placeholder="Please enter tag text" type="text" name="tag_text" class="form-control tagtext">
            </div>


            <div class="form-group">
                <label>Status:</label>
                <br>
                <label class="switch">
                    <input type="checkbox" name="status">
                    <span class="knob"></span>
                </label>
            </div>


          </div>

        </div>

      </form>

    </div>
</div>
 
@endsection
@section('custom-script')
  <script>var customcatid = null</script>
  <script src="{{ url('js/menu.js') }}" ></script>
@endsection