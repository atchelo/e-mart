@extends("admindesk/layouts.master")
@section('title','Add Categories in Front Slider Tab | ')
@section("body")


  <div class="box" >
    <div class="box-header with-border">
      <h3 class="box-title">Add categories in front slider tab </h3>
    </div>
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/NewProCat')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
              
               <div class="form-group">
                    <label for="name" class="col-sm-2 col-md-3 control-label">Select Categories:</label>
                  <ul class="col-md-5"> 
                     <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                 <div class="panel panel-default">
                 @foreach(App\Category::where('status','1')->get(); as $item)  
                 <?php 
                 if(!empty($NewProCat)){
                        $parents = explode(",",$NewProCat->name);
                      }
                  ?>
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-parent="#accordion" aria-expanded="true" aria-controls="collapseOne">
                          <input id="categories_{{$item->id}}" @if(!empty($parents)) @foreach($parents as $p) {{ $p == $item->id ? "checked" : "" }} @endforeach @endif type="checkbox" class=" required_one categories" name="name[]" value="{{$item->id}}" >
                           
                            {{$item->title}}
                        </a>
                    </h4>
                </div>
                <span class="help-block hidden">Choose Category And Show Heading</span>
                @endforeach
            </div> 

            </div>  
            </ul> 
             
        </div>                             
 
              <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Status:
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                       <input id="toggle-event3" @if(!empty($NewProCat)) {{ $NewProCat->status ==1 ? "checked" : "" }} @endif type="checkbox" class="tgl tgl-skewed">
                       <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="toggle-event3"></label>
                       <input type="hidden" name="status" value="@if(!empty($NewProCat)) {{ $NewProCat->status }} @endif" id="status3">
                       <small class="txt-desc">(Please Choose Status )</small>
                      </div>
                </div>
            <div>
       
              <div class="box-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
                
          </div>
         
@endsection

