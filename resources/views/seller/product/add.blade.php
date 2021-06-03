@extends("admindesk.layouts.sellermaster")

@section("body")


        <div class="col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Product</h3>
                    <div class="panel-heading">
                          <a href=" {{url('vender/add_product/')}} " class="btn btn-success pull-right owtbtn">< Back</a> 
                        </div>   
                    
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('vender/add_product')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                        <input type="hidden" name="vender_id" value="{{$vender_id}}">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Product name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="name" value=" {{old('name')}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter product </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Category
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="category_id" class="form-control col-md-7 col-xs-12" id="category_id">
                          <option value="0">Please Select</option>
                          @foreach($categorys as $category)
                          <option value="{{$category->id}}">{{$category->title}} </option>
                          @endforeach
                        </select>
                          <p class="txt-desc">Please Choose Category </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Sub Category
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="child" class="form-control col-md-7 col-xs-12" id="upload_id">
                          </select>
                          <p class="txt-desc">Please Choose Sub Category </p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                         Select Brand
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="brand_id"  class="form-control col-md-7 col-xs-12">
                          <option value="0">Please Select</option>
                          @foreach($brands as $brand)
                          <option value="{{$brand->id}}">{{$brand->name}} </option>
                          @endforeach
                        </select>
                          <p class="txt-desc">Please Choose Brand Name </p>
                        </div>
                      </div>    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                         Select Store *
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="store_id"  class="form-control col-md-7 col-xs-12">
                            <option value="0">Please Select Store Name</option>
                          @foreach($stores as $store)
                          <option value="{{$store->id}}">{{$store->name}} </option>
                          @endforeach
                        </select>
                          <p class="txt-desc">Please Choose Store Name </p>
                        </div>
                      </div>                       
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <textarea cols="2" id="editor1"  value="{{old('des')}}" name="des" rows="5" >
                           {{old('des')}} 
                         </textarea>
                         <p class="txt-desc">Please Enter Description</p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Tags 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="tags"  data-role="tagsinput" value="{{old('tags')}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Tags </p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Model Number
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="model" class="form-control col-md-7 col-xs-12" value="{{old('model')}}" >
                          <p class="txt-desc">Please Enter Model Number </p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          SKU *
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="sku" value="{{old('sku')}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter SKU </p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Price *
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="price" value="{{old('price')}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Price </p>
                        </div>
                      </div>
                      
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Stock 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" id="first-name" name="qty" value="1" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter Quantity  </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                         Product Image<span>
                           *
                         </span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="first-name" name="image" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Choose Image </p>
                        </div>
                      </div>
                      
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Dimension 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="dimension" class="form-control col-md-7 col-xs-12" value="{{old('dimension')}}" >
                          <p class="txt-desc">Please Enter dimension </p>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Weight 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="weight" value="{{old('weight')}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">Please Enter weight in Kg</p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Featured 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="checkbox" name="fe" checked data-toggle="toggle">
                         <p class="txt-desc">Please Choose Featured </p>
                        </div>
                        </div>
                       </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Status 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="checkbox" name="togle" checked data-toggle="toggle">
                         <p class="txt-desc">Please Choose Status </p>
                        </div>
                       </div>
                      <div class="switch">
                      </div>
                    
              <!-- /.box-body -->

              <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                 
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
                <button class="btn btn-default "><a href="{{url('vender/add_product')}}" class="links">Cancel</a></button>
          </div>
          <!-- /.box -->
        </div>

        <!-- footer content -->
@endsection

