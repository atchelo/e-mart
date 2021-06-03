@extends("admindesk/layouts.master")
@section('title','Edit Block Detail Page Advertisements | ')
@section("body")
<div class="col-md-6">
  <div class="box">
    
    <div class="box-header with-border">
      <a class="btn btn-default btn-flat" href="{{ route('detailadvertise.index') }}"><i class="fa fa-reply"></i></a>
      <div class="box-title">
        Edit Block Detail Page Advertisements #{{ $detail->id }}
      </div>
    </div>
    
    <div class="box-body">
        <form action="{{route('detailadvertise.update',$detail->id)}}" method="POST" enctype="multipart/form-data">
          @csrf
          {{ method_field('PUT') }}
          <div class="form-group">
            <label>Select Position: <span class="required">*</span></label>
            <select required="" name="position" id="position" class="form-control">
                <option {{ $detail->position == 'category' ? "selected" : "" }} value="category">On Category Page</option>
                <option {{ $detail->position == 'prodetail' ? "selected" : "" }} value="prodetail">On Product Detail Page</option>
            </select>
          </div>

            <div id="linkedPro" class="form-group {{ $detail->position == 'prodetail' ? '' : 'display-none' }}">
          <label>Display Product Page: <span class="required">*</span></label>
          <select name="linkedPro" id="" class="select2 form-control">
              @foreach(App\Product::where('status','=','1')->get() as $pro)
                <option {{ $detail->linked_id == $pro->id ? "selected" : "" }} value="{{ $pro->id }}">{{ $pro->name }}</option>
              @endforeach
          </select>
          <small class="help-block"><i class="fa fa-question-circle"></i> Select a product page where you want to display this ad.</small>
        </div>

        <div id="linkedCat" class="form-group {{ $detail->position == 'category' ? '' : 'display-none' }}">
          <label>Display Category Page: <span class="required">*</span></label>
          <select  name="linkedCat" id="" class="select2 form-control">
              @foreach(App\Category::where('status','=','1')->get() as $cat)
                <option {{ $detail->linked_id == $cat->id ? "selected" : "" }} value="{{ $cat->id }}">{{ $cat->title }}</option>
              @endforeach
          </select>
          <small class="help-block"><i class="fa fa-question-circle"></i> Select a category page where you want to display this ad.</small>
        </div>

          <div class="form-group">
            <label>Link By: <span class="required">*</span></label>
            <select required="" name="linkby" id="linkby" class="form-control">
                <option {{ $detail->linkby == 'category' ? "selected" : "" }} value="category">By Category Page</option>
                <option {{ $detail->linkby == 'detail' ? "selected" : "" }} value="detail">By Product Page</option>
                <option {{ $detail->linkby == 'url' ? "selected" : "" }} value="url">By Custom URL</option> 
                <option {{ $detail->linkby == 'adsense' ? "selected" : "" }} value="adsense">By Google Adsense</option>
            </select>
          </div>

      
 
          <div class="{{ $detail->linkby == 'adsense' ? 'display-none' : "" }}" id="customad">

            <div class="form-group">
              <label>Choose Image: <span class="required">*</span></label>
              <input id="adImage" type="file" class="form-control" name="adimage">
            </div>

            <div class="form-group">
              <label>Preview: </label>
              <br>
              <img class="img-responsive" id="adPreview" src="{{ url('images/detailads/'.$detail->adimage) }}">
            </div>

            <div id="catbox" class="form-group {{ $detail->linkby == 'category' ? '' : 'display-none' }}">
              <label>Select Category: <span class="required">*</span></label>
              <select name="cat_id" id="" class="select2 form-control">
                  @foreach(App\Category::where('status','=','1')->get() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                  @endforeach
              </select>
            </div>

            <div id="probox" class="form-group {{ $detail->linkby == 'detail' ? '' : 'display-none' }}">
              <label>Select Product: <span class="required">*</span></label>
              <select name="pro_id" id="" class="select2 form-control">
                  @foreach(App\Product::where('status','=','1')->get() as $pro)
                    <option {{ $detail->pro_id == $pro->id ? "selected" : "" }} value="{{ $pro->id }}">{{ $pro->name }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Heading Text: </label>
              <input value="{{ $detail->top_heading }}" name="top_heading" placeholder="Enter heading text" type="text" class="form-control" id="heading">
            </div>

            <div class="form-group">
               <label>Heading Text Color: </label>
               <div class="input-group my-colorpicker2 colorpicker-element">
                <input value="{{ $detail->hcolor }}" placeholder="Choose Color" name="hcolor" type="text" class="form-control">
                <div class="input-group-addon">
                    <i></i>
                  </div>
               </div>
            </div>

             <div class="form-group">
              <label>Subheading Text: </label>
              <input value="{{ $detail->sheading }}" name="sheading" placeholder="Enter subheading text" type="text" class="form-control" id="top_heading">
            </div>

            <div class="form-group">
               <label>Subheading Text Color: </label>
               <div class="input-group my-colorpicker2 colorpicker-element">
                <input value="{{ $detail->scolor }}" placeholder="Choose Color" name="scolor" type="text" class="form-control">
                <div class="input-group-addon">
                    <i></i>
                  </div>
               </div>
            </div>

             <div class="form-group">
              <label>Show Button:</label>
              <br>
              <label class="switch">
                <input {{ $detail->show_btn == 1 ? "checked" : "" }} type="checkbox" class="show_btn toggle-input toggle-buttons" name="show_btn">
                <span class="knob"></span>
              </label>
            </div>

            <div id="urlbox" class="form-group {{ $detail->linkby == 'url' ? "" : 'display-none' }}">
              <label>Custom URL: </label>
              <input value="{{ $detail->url }}" placeholder="http://" type="url" class="form-control" id="url" name="url">
            </div>

            <div class="{{ $detail->show_btn == 1 ? "" : 'display-none' }}" id="buttongroup">
              <div class="form-group">
              <label>Button Text: </label>
              <input value="{{ $detail->btn_text }}" placeholder="Enter button text" type="text" class="form-control" id="btn_txt" name="btn_txt">
            </div>

           <div class="form-group">
               <label>Button Text Color: </label>
               <div class="input-group my-colorpicker2 colorpicker-element">
                <input value="{{ $detail->btn_txt_color }}" placeholder="Choose Color" name="btn_txt_color" type="text" class="form-control">
                <div class="input-group-addon">
                    <i></i>
                  </div>
               </div>
            </div>

            <div class="form-group">
               <label>Button Background Color: </label>
               <div class="input-group my-colorpicker2 colorpicker-element">
                  <input value="{{ $detail->btn_bg_color }}" placeholder="Choose Color" name="btn_bg" type="text" class="form-control">
                  <div class="input-group-addon">
                    <i></i>
                  </div>
               </div>
            </div>
            </div>

          </div>

          <div id="adsenseBox" class="form-group {{ $detail->linkby == 'adsense' ? '' : 'display-none' }}">
            <label>Google Adsense Code: </label>
            <textarea name="adsensecode" cols="30" rows="5" placeholder="Paste your Adsense code script here" class="form-control">{{ $detail->adsensecode }}</textarea> 
          </div>


      <div class="form-group">
          <label>Status:</label>
          <br>
          <label class="switch">
            <input type="checkbox" {{ $detail->status == 1 ? "checked" : "" }} class="quizfp toggle-input toggle-buttons" name="status">
            <span class="knob"></span>
          </label>
       </div>
       
    </div>

    <div class="box-footer">
      <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" !@endif class="btn btn-flat btn-primary">
        <i class="fa fa-save"></i> Update
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