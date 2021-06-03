@extends("admindesk/layouts.master")
@section('title',"Add New Slider |")
@section("body")
  
  <div class="box">
    <div class="box-header with-border">
        <div class="box-title">
          Create a new slider
        </div>
    </div>

    <div class="box-body">
        <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                  <label>Choose Slider Image:</label>
                  <input required="" type="file" class="form-control" name="image" id="image"/>
               </div>
                <div class="form-group">
                  <label for="link_by">Link BY:</label>
                  <select required="" class="form-control" name="link_by" id="link_by">
                    <option value="none">None</option>
                    <option value="url">URL</option>
                    <option value="cat">Category</option>
                    <option value="sub">Subcategory</option>
                    <option value="child">Child Category</option>
                    <option value="pro">Product</option>
                  </select>
                </div>
                <div class="display-none form-group" id="category_id">
                  <label>Choose Category:</label>
                  <select class="js-example-basic-single form-control" id="cat" name="category_id">
                      <option value="">Please Choose</option>
                      @foreach(App\Category::all() as $category)
                          @if($category->status == '1')
                              <option value="{{ $category->id }}">{{ $category->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                 <div class="display-none form-group" id="subcat_id">
                  <label>Choose Subcategory:</label>
                  <select class="js-example-basic-single form-control" id="subcat" name="subcat" >
                      <option value="">Please Choose</option>
                      @foreach(App\Subcategory::all() as $sub)
                          @if($sub->status == '1')
                              <option value="{{ $sub->id }}">{{ $sub->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="display-none form-group" id="child">
                  <label>Choose Chilldcategory:</label>
                  <select class="js-example-basic-single form-control" id="sub" name="child" >
                      <option value="">Please Choose</option>
                      @foreach(App\Grandcategory::all() as $child)
                          @if($child->status == '1')
                              <option value="{{ $child->id }}">{{ $child->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="display-none form-group" id="pro">
                  <label>Choose Product:</label>
                  <select class="js-example-basic-single form-control" id="pro" name="pro" >
                      <option value="">Please Choose</option>
                      @foreach(App\Product::all() as $pro)
                          @if($pro->status == '1' && count($pro->subvariants)>0)
                              <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="display-none form-group" id="url_box">
                  <label>Enter URL:</label>
                  <input type="url" id="url" name="url" class="form-control" placeholder="http://www.">
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label>Slider Top Heading:</label>
                      <input name="heading" type="text" value="" placeholder="Enter top heading" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                       <label for="">Text Color:</label>
                      <input class="form-control" type="color" value="" name="headingtextcolor">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label>Slider Sub Heading:</label>
                      <input name="subheading" type="text" value="" placeholder="Enter Sub heading" class="form-control"/>
                    </div>

                    <div class="col-md-4">
                      <label for="">Text Color:</label>
                      <input class="form-control" type="color" value="" name="subheadingcolor">
                    </div>
                  </div>
                </div>

                  <div class="form-group">
                  
                    <div class="row">
                      
                      <div class="col-md-4">
                        <label>Button Text:</label>
                        <input name="buttonname" type="text" value="" placeholder="Enter Button Text" class="form-control"/>
                      </div>

                      <div class="col-md-4">
                        <label for="">Button Text Color:</label>
                        <input class="form-control" type="color" value="" name="btntextcolor">
                      </div>

                      <div class="col-md-4">
                        <label for="">Button Background Color:</label>
                        <input class="form-control" type="color" value="" name="btnbgcolor">
                      </div>

                    </div>
                      
                    
   
                </div>

                <div class="form-group">
                  <label for="">Status:</label>
                   <input required="" id="status" type="checkbox" name="status" class="tgl tgl-skewed">
                   <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="status"></label>
                </div>

                <div class="form-group">
                  <button class="btn btn-primary btn-md"><i class="fa fa-plus"></i> ADD Slide</button>
                </div>

             </div>
             <div class="col-md-6">
               <label for="link_by">Image Preview:</label>
               <br><br>
               <img src="{{ url('images/sliderpreview.png') }}" class="img-responsive postop" id="slider_preview" title="Image Preview" align="center">
               
             </div>
            
           </div>
        </form>
    </div>
  </div>

@endsection
@section('custom-script')
  <script src="{{ url('js/slider.js') }}"></script>
@endsection