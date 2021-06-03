@extends("admindesk/layouts.master")
@section('title',"Edit Slider |")
@section("body")
  
  <div class="box">
    <div class="box-header with-border">
        <div class="box-title">
          Edit Slide
        </div>

        <div class="pull-right">
          <a title="Go back" href="{{ route('slider.index') }}" class="btn btn-md btn-default">
              <i class="fa fa-reply"></i>
          </a>
        </div>
    </div>

    <div class="box-body">
        <form action="{{ route('slider.update',$slider->id) }}" method="POST" enctype="multipart/form-data">
          {{ method_field('PUT') }}
          @csrf
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                  <label>Choose Slider Image:</label>
                  <input  type="file" class="form-control" name="image" id="image"/>
               </div>
                <div class="form-group">
                  <label for="link_by">Link BY:</label>
                  <select required="" class="form-control" name="link_by" id="link_by">
                    <option {{ $slider->link_by == 'none' ? "selected" : "" }} value="none">None</option>
                    <option {{ $slider->link_by == 'url' ? "selected" : "" }} value="url">URL</option>
                    <option {{ $slider->link_by == 'cat' ? "selected" : "" }} value="cat">Category</option>
                    <option {{ $slider->link_by == 'sub' ? "selected" : "" }} value="sub">Subcategory</option>
                    <option {{ $slider->link_by == 'child' ? "selected" : "" }} value="child">Child Category</option>
                    <option {{ $slider->link_by == 'pro' ? "selected" : "" }} value="pro">Product</option>
                  </select>
                </div>
                <div class="form-group {{ $slider->category_id !='' ? "" : 'display-none' }}" id="category_id">
                  <label>Choose Category:</label>
                  <select class="js-example-basic-single form-control" id="cat" name="category_id">
                      <option value="">Please Choose</option>
                      @foreach(App\Category::all() as $category)
                          @if($category->status == '1')
                              <option {{ $slider['category_id'] == $category->id ? "selected" : "" }} value="{{ $category->id }}">{{ $category->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                 <div class="form-group {{ $slider->child !='' ? "" : 'display-none' }}" id="subcat_id">
                  <label>Choose Subcategory:</label>
                  <select class="js-example-basic-single form-control" id="subcate" name="subcat" >
                      <option value="">Please Choose</option>
                      @foreach(App\Subcategory::all() as $sub)
                          @if($sub->status == '1')
                              <option {{ $slider['child'] == $sub->id ? "selected" : "" }} value="{{ $sub->id }}">{{ $sub->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="form-group {{ $slider->grand_id !='' ? "" : 'display-none' }}" id="child">
                  <label>Choose Chilldcategory:</label>
                  <select class="js-example-basic-single form-control" id="subcat" name="child" >
                      <option value="">Please Choose</option>
                      @foreach(App\Grandcategory::all() as $child)
                          @if($child->status == '1')
                              <option {{ $slider['grand_id'] == $child->id ? "selected" : "" }} value="{{ $child->id }}">{{ $child->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="form-group {{ $slider->product_id !='' ? "" : 'display-none' }}" id="pro">
                  <label>Choose Product:</label>
                  <select class="js-example-basic-single form-control" id="pro" name="pro" >
                      <option value="">Please Choose</option>
                      @foreach(App\Product::all() as $pro)
                          @if($pro->status == '1' && count($pro->subvariants)>0)
                              <option {{ $slider['product_id'] == $pro->id ? "selected" : "" }} value="{{ $pro->id }}">{{ $pro->name }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="form-group {{ $slider->url !='' ? "" : 'display-none' }}" id="url_box">
                  <label>Enter URL:</label>
                  <input type="url" id="url" name="url" value="{{ $slider->url }}" class="form-control" placeholder="http://www.">
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label>Slider Top Heading:</label>
                      <input name="heading" type="text" value="{{ $slider->topheading }}" placeholder="Enter top heading" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                       <label for="">Top Heading Text Color:</label>
                      <input class="form-control" type="color" value="{{ $slider->headingtextcolor }}" name="headingtextcolor">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label>Slider Sub Heading:</label>
                      <input name="subheading" type="text" value="{{ $slider->heading }}" placeholder="Enter Sub heading" class="form-control"/>
                    </div>

                    <div class="col-md-4">
                      <label for="">Subheading Text Color:</label>
                      <input class="form-control" type="color" value="{{ $slider->subheadingcolor }}" name="subheadingcolor">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label>Description Text:</label>
                      <input name="moredesc" type="text" value="{{ $slider->moredesc }}" placeholder="Enter top heading" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                       <label for="">Description Text Color:</label>
                      <input class="form-control" type="color" value="{{ $slider->moredesccolor }}" name="moredesccolor">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  
                    <div class="row">
                      
                      <div class="col-md-4">
                        <label>Button Text:</label>
                        <input name="buttonname" type="text" value="{{ $slider->buttonname }}" placeholder="Enter Button Text" class="form-control"/>
                      </div>

                      <div class="col-md-4">
                        <label for="">Button Text Color:</label>
                        <input class="form-control" type="color" value="{{ $slider->btntextcolor }}" name="btntextcolor">
                      </div>

                      <div class="col-md-4">
                        <label for="">Button Background Color:</label>
                        <input class="form-control" type="color" value="{{ $slider->btnbgcolor }}" name="btnbgcolor">
                      </div>

                    </div>
                      
                    
   
                </div>

                <div class="form-group">
                  <label for="">Status:</label>
                   <input {{ $slider->status == 1 ? "checked" : "" }} required="" id="status" type="checkbox" name="status" class="tgl tgl-skewed">
                   <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="status"></label>
                </div>

                <div class="form-group">
                  <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This action cannot be done in demo !" @endif class="btn btn-primary btn-md"><i class="fa fa-save"></i> Save Slide</button>
                </div>

             </div>
             <div class="col-md-6">
               <label for="link_by">Image Preview:</label>
               <br>
               <img id="slider_preview" class="postop width100 height500px img-responsive" title="Slider Image Preview" align="center" src="{{ url('images/slider/'.$slider->image) }}" alt="">
               
             </div>
            
           </div>
          
        </form>
    </div>
  </div>

@endsection
@section('custom-script')
  <script src="{{ url('js/slider.js') }}"></script>
@endsection