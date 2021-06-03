@extends("admindesk/layouts.master")
@section('title','Choose Layout - Create Advertisement |')
@section("body")
  <div class="box">
    <div class="box-header with-border">
       <a title="G back !" href="{{ route('adv.index') }}" class="btn btn-md btn-default"><i class="fa fa-reply"></i>
          </a>
      <h3 class="box-title">Choose layout for advertisement</h3>
      <form action="{{ route('select.layout') }}" method="get">
      <button title="Click to continue..." type="submit" class="btn btn-md btn-flat btn-primary pull-right">
              
            Next <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>

      </button>
    </div>

    <div class="box-body">
      
        
        <div class="BLOCK1">
          <label>
          <div class="row">

            <div class="col-md-6">
             
              <input required="" type="radio" name="layout" value="Three Image Layout">
                <span class="h3">Three Image Layout</span>
                <br>
                <small class="left-15 text-muted">If you choose three image layout you have to upload all three images otherwise choose other layout.</small>
              
            </div>
            <div class="col-md-6">
              <img class="img-responsive" title="Three Image Layout" src="{{ url('images/advLayout3.png') }}" alt="three_image_adv_layout">
            </div>
          </div>
        </label>

          <hr>
          <label>
            <div class="row">
              <div class="col-md-6">
                
                  <input required="" type="radio" name="layout" value="Two non equal image layout">
                  <span class="h3">Two Non Equal Image Layout</span>
                  <br>
                  <small class="left-15 text-muted">If you choose two non equal image layout you have to upload all two images and one is larger than other image otherwise choose other layout.</small>
                
              </div>
              <div class="col-md-6">
                <img class="img-responsive" title="Two Non Equal Image Layout" src="{{ url('images/advLayout2.png') }}" alt="two_non_equal_image_adv_layout">
              </div>
            </div>
          </label>
          <hr>
          <label>
            <div class="row">
              <div class="col-md-6">
                
                  <input required="" type="radio" name="layout" value="Two equal image layout">
                  <span class="h3">Two Equal Image Layout</span>
                  <br>
                  <small class="left-15 text-muted">If you choose two equal image layout you have to upload all two images and both images have to be equal othersie choose other layout.</small>
               
              </div>
              <div class="col-md-6">
                <img class="img-responsive" title="Two Equal Image Layout" src="{{ url('images/advLayout1.png') }}" alt="two_equal_image_adv_layout">
              </div>
            </div>
         </label>
          <hr>
           <label>
           <div class="row">
            <div class="col-md-6">
             
                <input required="" type="radio" name="layout" value="Single image layout">
                <span class="h3">Single Image Layout</span>
                <br>
                <small class="left-15 text-muted">If you choose one single image layout you have to upload one image in given size.</small>
              
            </div>
            <div class="col-md-6">
              <img class="img-responsive" title="Single Image Layout" src="{{ url('images/singleImage.png') }}" alt="single_image_adv_layout">
            </div>
          </div>
        </label>
        </div>
        <hr>
       <div class="form-group">
          <button title="Click to continue..." type="submit" class="btn btn-md btn-flat btn-primary pull-right">
            Next <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>

          </button>
       </div>
      </form>
    </div>
  </div> 
@endsection