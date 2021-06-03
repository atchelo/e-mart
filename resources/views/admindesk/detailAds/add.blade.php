@extends("admindesk/layouts.master")
@section('title','Block Detail Page Advertisements | ')
@section("body")
<div class="col-md-6">
  <div class="box">
    <div class="box-header with-border">
      <a class="btn btn-default btn-flat" href="{{ route('detailadvertise.index') }}"><i class="fa fa-reply"></i></a>
      <div class="box-title">
        Block Detail Page Advertisements
      </div>
    </div>
    
    <div class="box-body">
        <form action="{{route('detailadvertise.store')}}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label>Select Position: <span class="required">*</span></label>
            <select required="" name="position" id="position" class="form-control">
                <option value="category">On Category Page</option>
                <option value="prodetail">On Product Detail Page</option>
            </select>
          </div>

           <div id="linkedPro" class="display-none form-group">
          <label>Display Product Page: <span class="required">*</span></label>
          <select name="linkedPro" id="" class="select2 form-control">
              @foreach(App\Product::where('status','=','1')->get() as $pro)
                <option value="{{ $pro->id }}">{{ $pro->name }}</option>
              @endforeach
          </select>
          <small class="help-block"><i class="fa fa-question-circle"></i> Select a product page where you want to display this ad.</small>
        </div>

        <div id="linkedCat" class="form-group">
          <label>Display Category Page: <span class="required">*</span></label>
          <select name="linkedCat" id="" class="select2 form-control">
              @foreach(App\Category::where('status','=','1')->get() as $cat)
                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
              @endforeach
          </select>
          <small class="help-block"><i class="fa fa-question-circle"></i> Select a category page where you want to display this ad.</small>
        </div>

          <div class="form-group">
            <label>Link By: <span class="required">*</span></label>
            <select required="" name="linkby" id="linkby" class="form-control">
                <option value="category">By Category Page</option>
                <option value="detail">By Product Page</option>
                <option value="url">By Custom URL</option> 
                <option value="adsense">By Google Adsense</option>
            </select>
          </div>

       
        
        <div id="customad">

            <div class="form-group">
              <label>Choose Image: <span class="required">*</span></label>
              <input id="adImage" type="file" class="form-control" name="adimage">
            </div>

            <div class="form-group">
              <label>Preview: </label>
              <br>
              <img id="adPreview" src="">
            </div>

            <div id="catbox" class="form-group">
              <label>Select Category: <span class="required">*</span></label>
              <select name="cat_id" id="" class="select2 form-control">
                  @foreach(App\Category::where('status','=','1')->get() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                  @endforeach
              </select>
            </div>

            <div id="probox" class="display-none form-group">
              <label>Select Product: <span class="required">*</span></label>
              <select name="pro_id" id="" class="select2 form-control">
                  @foreach(App\Product::where('status','=','1')->get() as $pro)
                    <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                  @endforeach
              </select>
              <small class="help-block"><i class="fa fa-question-circle"></i> Select a product page so when user click on ad he/she will redirect to this product page </small>
            </div>

            <div class="form-group">
              <label>Heading Text: </label>
              <input value="{{ old('top_heading') }}" name="top_heading" placeholder="Enter heading text" type="text" class="form-control" id="top_heading">
            </div>

            <div class="form-group">
               <label>Heading Text Color: </label>
               <div class="input-group my-colorpicker2 colorpicker-element">
                <input value="{{ old('hcolor') }}" placeholder="Choose Color" name="hcolor" type="text" class="form-control">
                <div class="input-group-addon">
                    <i></i>
                  </div>
               </div>
            </div>

            <div class="form-group">
              <label>Subheading Text: </label>
              <input value="{{ old('sheading') }}" name="sheading" placeholder="Enter subheading text" type="text" class="form-control" id="top_heading">
            </div>

            <div class="form-group">
               <label>Subheading Text Color: </label>
               <div class="input-group my-colorpicker2 colorpicker-element">
                <input value="{{ old('scolor') }}" placeholder="Choose Color" name="scolor" type="text" class="form-control">
                <div class="input-group-addon">
                    <i></i>
                  </div>
               </div>
            </div>

            <div id="urlbox" class="display-none form-group">
              <label>Custom URL: </label>
              <input value="{{ old('url') }}" placeholder="http://" type="text" class="form-control" id="url" name="url">
            </div>

            <div class="form-group">
              <label>Show Button:</label>
              <br>
              <label class="switch">
                <input type="checkbox" class="show_btn toggle-input toggle-buttons" name="show_btn">
                <span class="knob"></span>
              </label>
            </div>

            <div class="display-none" id="buttongroup">
              <div class="form-group">
                <label>Button Text: </label>
                <input value="{{ old('btn_txt') }}" placeholder="Enter button text" type="text" class="form-control" id="btn_txt" name="btn_txt">
              </div>

             <div class="form-group">
                 <label>Button Text Color: </label>
                 <div class="input-group my-colorpicker2 colorpicker-element">
                  <input value="{{ old('btn_txt_color') }}" placeholder="Choose Color" name="btn_txt_color" type="text" class="form-control">
                  <div class="input-group-addon">
                      <i></i>
                    </div>
                 </div>
              </div>

              <div class="form-group">
                 <label>Button Background Color: </label>
                 <div class="input-group my-colorpicker2 colorpicker-element">
                    <input value="{{ old('btn_bg') }}" placeholder="Choose Color" name="btn_bg" type="text" class="form-control">
                    <div class="input-group-addon">
                      <i></i>
                    </div>
                 </div>
              </div>

            </div>
          </div>

          <div id="adsenseBox" class="display-none form-group">
            <label>Google Adsense Code: </label>
            <textarea name="adsensecode" cols="30" rows="5" placeholder="Paste your Adsense code script here" class="form-control">{{ old('adsensecode') }}</textarea> 
          </div>

        <div class="form-group">
          <label>Status:</label>
          <br>
          <label class="switch">
            <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="status">
            <span class="knob"></span>
          </label>
       </div>

       
    </div>

    <div class="box-footer">
      <button type="submit" class="btn btn-flat btn-primary">
        <i class="fa fa-plus-circle"></i> Add
      </button>
    </form>
      <a title="Go back" href="{{ route('detailadvertise.index') }}" class="btn btn-flat btn-default">
        <i class="fa fa-reply"></i> Back
      </a>
    </div>

  </div>
</div>
@endsection        
@section('custom-script')
  <script src="{{ url('js/detailads.js') }}"></script>
@endsection