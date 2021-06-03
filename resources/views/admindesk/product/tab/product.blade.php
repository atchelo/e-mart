<h3>Create Product :</h3>
<hr>
<form id="demo-form2" method="post" enctype="multipart/form-data"
  action="{{url('admindesk/products/')}}"  data-parsley-validate
  class="form-horizontal form-label-left">
@csrf
  <div class="row">
    <div class="col-md-6">
      <label for="first-name">
        Product Name: <span class="required">*</span>
      </label>
      <input required="" placeholder="Please enter product name" type="text" id="first-name" name="name"
        value="{{ old('name') }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label>
        Select Brand: <span class="required">*</span>
      </label>
      <select required="" name="brand_id" class="form-control col-md-7 col-xs-12">
        <option value="">Please Select</option>
        @if(!empty($brands_products))
          @foreach($brands_products as $brand)
          <option value="{{$brand->id}}" {{ $brand->id == old('brand_id') ? 'selected="selected"' : '' }}>
            {{$brand->name}} </option>
          @endforeach
        @endif
      </select>
    </div>

    <div class="margin-top-15 col-md-4">
      <label for="first-name">
        Category: <span class="required">*</span>
      </label>
      <select required="" name="category_id" id="category_id" class="form-control select2">
        <option value="">Please Select</option>
        @if(!empty($categorys))
          @foreach($categorys as $category)
            <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected="selected"' : '' }}>
              {{$category->title}} 
            </option>
          @endforeach
        @endif
      </select>
    </div>

    <div class="margin-top-15 col-md-4">
      <label>
        Subcategory: <span class="required">*</span>
      </label>
      <select required="" name="child" id="upload_id" class="form-control select2">
        <option value="">Please Select</option>
        
      </select>
    </div>

    <div class="margin-top-15 col-md-4">
      <label>
        Childcategory:
      </label>
      <select name="grand_id" id="grand" class="form-control select2">
        <option value="">Please choose</option>
        
      </select>
    </div>

    <div class="last_btn col-md-6">
      <label>
        Select Store:
      </label>
      <select required="" name="store_id" class="form-control select2">


        @foreach($stores as $store)
          <optgroup label="Store Owner • {{ $store->owner }}">
            <option {{ old('store_id') == $store->storeid ? "selected" : "" }} value="{{ $store->storeid }}">
              {{ $store->storename }}</option>
          </optgroup>
        @endforeach


      </select>
      <small class="txt-desc">(Please Choose Store Name )</small>
    </div>

    <div class="last_btn col-md-6">
      <label>Upload product catlog:</label>
      <input type="file" class="form-control" name="catlog">
      <small class="txt-desc">(Catlog file max size: 1MB ) | Supported files : pdf,docs,docx,ppt,txt</small>
    </div>


    <div class="margin-top-15 col-md-12">
      <label for="first-name"> Key Features :
      </label>
      <textarea class="form-control" id="editor2" name="key_features">{!! old('key_features') !!}</textarea>
    </div>

    <div class="margin-top-15 col-md-12">
      <label for="first-name">Description:</label>
      <textarea id="editor1" value="{{old('des' ?? '')}}" name="des" class="form-control">{{ old('des' ?? '')}}</textarea>
      <small class="txt-desc">(Please Enter Product Description)</small>
    </div>

    <div class="margin-top-15 col-md-6">
      <label for="first-name">Product Video Preview: </label>
    <input name="video_preview" value="{{ old('video_preview') }}" type="text" class="form-control" placeholder="eg: https://youtube.com/watch?v=">
      <small class="text-muted">
          • Supported urls are : <b>Youtube,vimeo, only.</b>
      </small>
    </div>

    <div class="margin-top-15 col-md-6">
      <label for="first-name">Product Video Thumbnail:</label>
      <input name="video_thumbnail" type="file" class="form-control" class="form-control">
      <small class="text-muted">
          • Max upload size is <b>500KB.</b>
      </small>
    </div>

    <div class="margin-top-15 col-md-4">
      <label for="warranty_info">Warranty:</label>

      <label>(Duration)</label>
      <select class="form-control" name="w_d" id="">
        <option>None</option>
        @for($i=1;$i<=12;$i++) <option {{ old('w_d') == $i ? "selected" : "" }} value="{{ $i }}">{{ $i }}</option>
          @endfor
      </select>
    </div>

    <div class="margin-top-15 col-md-4">
      <label>Days/Months/Year:</label>
      <select class="form-control" name="w_my" id="">
        <option>None</option>
        <option {{ old('w_my') == 'day' ? "selected" : "" }} value="day">Day</option>
        <option {{ old('w_my') == 'month' ? "selected" : "" }} value="month">Month</option>
        <option {{ old('w_my') == 'year' ? "selected" : "" }} value="year">Year</option>
      </select>
    </div>

    <div class="margin-top-15 col-md-4">
      <label>Type:</label>
      <select class="form-control" name="w_type" id="">
        <option>None</option>
        <option {{ old('w_type') == 'Guarantee' ? "selected" : "" }} value="Guarantee">Guarantee</option>
        <option {{ old('w_type') == 'Warranty' ? "selected" : "" }} value="Warranty">Warranty</option>
      </select>
    </div>

    <div class="margin-top-15 col-md-6">

      <label>
        Start Selling From:
      </label>
      <div class='input-group date' id='datetimepicker1'>
        <input value="{{ old('selling_start_at') }}" name="selling_start_at" type='text' class="form-control" />
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>

    </div>


    <div class="margin-top-15 col-md-6">
      <label>
        Tags:
      </label>
      <input value="{{ old('tags') }}" placeholder="Please enter tag seprated by Comma(,)" type="text" name="tags"
        class="form-control">

    </div>

    <div class="margin-top-15 col-md-12">
      <div class="row">
        <div class="col-md-6">
          <label>
            Model:
          </label>

          <input type="text" id="first-name" name="model" class="form-control" placeholder="Please Enter Model Number"
            value="{{ old('model') }}">
        </div>

        <div class="col-md-6">
          <label for="first-name">
            SKU:
          </label>
          <input type="text" id="first-name" name="sku" value="{{ old('sku') }}" placeholder="Please enter SKU"
            class="form-control">
        </div>



      </div>
    </div>

    <div class="margin-top-15 col-md-12">
      <label class="switch">

        <input {{ old('tax_r') ? "checked" : "" }} type="checkbox" id="tax_manual"
          class="toggle-input toggle-buttons" name="tax_manual">
        <span class="knob"></span>

      </label>
      <label class="ptax">Price Including Tax ?</label>

    </div>


    <div class="margin-top-15 col-md-4">

      <label>
        Price: <span class="required">*</span>
        <span class="help-block">(Price you entering is IN {{ $defCurrency->currency->code }})</span>
      </label>
      <input pattern="[0-9]+(\.[0-9][0-9]?)?" title="Price Format must be in this format : 200 or 200.25" required=""
        type="text"  name="price" value="{{ old('price') }}" class="form-control">
      <br>
      <small class="text-muted"><i class="fa fa-question-circle"></i> Don't put comma whilt entering PRICE</small>

    </div>

    <div class="margin-top-15 col-md-4">

      <label>
        Offer Price:
        <span class="help-block">(Offer Price you entering is IN {{ $defCurrency->currency->code }})</span>
      </label>
      <input title="Offer price Format must be in this format : 200 or 200.25" pattern="[0-9]+(\.[0-9][0-9]?)?"
        type="text" name="offer_price" class="form-control"
        value="{{ old('offer_price') }}">
      <br>
      <small class="text-muted"><i class="fa fa-question-circle"></i> Don't put comma whilt entering OFFER PRICE</small>

    </div>

    <div class="margin-top-15 col-md-4">

      <label>
        Gift Packaging Charge:
        <span class="help-block">(Gift Packaging Charge you entering is IN {{ $defCurrency->currency->code }})</span>
      </label>
      <input title="Gift Packaging price Format must be in this format : 200 or 200.25" pattern="[0-9]+(\.[0-9][0-9]?)?"
        type="text" name="gift_pkg_charge" class="form-control"
        value="{{ old('gift_pkg_charge') }}">
      <br>
      <small class="text-muted"><i class="fa fa-question-circle"></i> PUT 0 if you don't want to enable gift packaging for this product.</small>

    </div>

    <div class="{{ old('tax_r') !='' ? "" : 'display-none' }}" id="manual_tax">

      <div class="margin-top-15 col-md-6">
        <label>Tax Applied (In %) <span class="required">*</span></label>
        <div class="input-group">
          <input {{ old('tax_r') ? "required" : "" }} value="{{ old('tax_r') }}" id="tax_r" type="number"
            min="0" class="form-control" name="tax_r" placeholder="0">
          <span class="input-group-addon">%</span>
        </div>
      </div>

      <div class="margin-top-15 col-md-6">
        <label>Tax Name: <span class="required">*</span></label>
        <input {{ old('tax_r') ? "required" : "" }} type="text" id="tax_name" class="form-control"
          name="tax_name" title="Tax rate must without % sign" placeholder="Enter Tax Name"
          value="{{ old('tax_name') }}">
      </div>

    </div>


    <div class="margin-top-15 col-md-12">
      <div class="{{ old('tax_r') ? 'display-none' : "" }}" id="tax_class">
        <label>
          Tax Classes:
        </label>
        <select {{ !old('tax_r') ? "required" : "" }} name="tax" id="tax_class_box" class="form-control">
          <option value="">Please Choose..</option>
          @foreach(App\TaxClass::all() as $tax)
          <option value="{{$tax->id}}"
            @if(!empty($products)){{ $tax->id == old('tax') ? 'selected="selected"' : '' }}@endif>{{$tax->title}}
          </option>
          @endforeach
        </select>
        <small class="txt-desc">(Please Choose Yes Then Start Sale This Product )</small>
        <img src="{{(url('images/info.png'))}}" data-toggle="modal" data-target="#taxmodal" class="height-15"><br>

      </div>
    </div>


    <div class="margin-top-15 col-md-4">


      <label>
        Free Shipping:
      </label>

      <input {{ old('free_shipping') == "0" ? '' : "checked" }} class="tgl tgl-skewed" name="free_shipping"
        id="frees" type="checkbox">
      <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="frees"></label>

      <small class="txt-desc">(If Choose Yes Then Free Shipping Start) </small>

    </div>

    <div class="margin-top-15 col-md-4">
      <label for="first-name">
        Featured:
      </label>

      <input {{ old('featured') ? '' : "checked" }} class="tgl tgl-skewed" id="toggle-event2"  type="checkbox" name="featured">
      <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="toggle-event2"></label>

      <small class="txt-desc">(If enable than Product will be featured )</small>
    </div>

    <div class="margin-top-15 col-md-4">
      <label for="first-name">
        Status:
      </label>

      <input {{ old('status') == "0" ? '' : "checked" }} class="tgl tgl-skewed" name="status" id="toggle-event3" type="checkbox"/>
      <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>


      <small class="txt-desc">(Please Choose Status) </small>
    </div>

    <div class="margin-top-15 col-md-12">
      <label for="first-name">
        Cancel Available:
      </label>

      <input id="toggle-event4" class="tgl tgl-skewed" type="checkbox" {{ old('cancel_avl') == "0" ? '' : "checked" }}>
      <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event4"></label>
    <input value="{{ old('cancel_avl') ?? "0" }}" type="hidden"
        name="cancel_avl" id="status4">
      <small class="txt-desc">(Please Choose Cancel Available )</small>
    </div>

    <div class="margin-top-15 col-md-12">
      <label for="first-name">
        Cash On Delivery:
      </label>

      <input id="codcheck" name="codcheck" class="tgl tgl-skewed" type="checkbox" {{ old('codcheck') ? 'checked' : "" }}/>
      <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="codcheck"></label>

      <small class="txt-desc">(Please Choose Cash on Delivery Available On This Product or Not)</small>
    </div>

    <div class="last_btn col-md-6">

      <label for="">Return Available :</label>
      <select required="" class="col-md-4 form-control" id="choose_policy" name="return_avbls">
        <option value="">Please choose an option</option>
        <option {{ old('return_avbls') =='1' ? "selected" : "" }} value="1">Return Available</option>
        <option {{ old('return_avbls') =='0' ? "selected" : "" }} value="0">Return Not Available</option>
      </select>
      <br>
      <small class="text-desc">(Please choose an option that return will be available for this product or not)</small>


    </div>

    <div id="policy" class="{{ old('return_avbls') == 1 ? '' : 'display-none' }} last_btn col-md-6">
      <label>
        Select Return Policy: <span class="required">*</span>
      </label>
      <select name="return_policy" class="form-control col-md-7 col-xs-12">
        <option value="">Please choose an option</option>

        @foreach(App\admin_return_product::where('created_by',Auth::user()->id)->get() as $policy)
        <option {{ old('return_policy') == $policy->id ? "selected" : "" }}
          value="{{ $policy->id }}">{{ $policy->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-12">
      <br>
        <div class="row">
          <div class="col-md-4">
            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> Create Product</button>
          </div>
        </div>
    </div>

    <!-- Main Row end-->
  </div>
</form>