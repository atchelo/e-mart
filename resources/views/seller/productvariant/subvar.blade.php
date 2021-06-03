@extends("admindesk/layouts.sellermaster")
@section('title','Add Product Variant -')
@section("body")

	<div class="box" >

		
		
		<div class="box-header with-border">
			<div class="box-title">
				Add Product Variant For <b>{{ $findpro->name }}</b>
			</div>
		</div>
	
	 
		<div class="box-body">
			<div class="row">
			<div class="col-md-12">
					
				<div>

  <!-- Nav tabs -->
    <form enctype="multipart/form-data" action="{{ route('seller.manage.stock.post',$findpro->id) }}" method="POST">
						{{ csrf_field() }}
  <ul class="nav nav-tabs" role="tablist" id="myTab">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Add Variant</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Pricing & Weight</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Inventory</a></li>

    <li role="presentation"><a href="#varimage" aria-controls="messages" role="tab" data-toggle="tab">Variant Images</a></li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane fade in active" id="home">
    	<br>
    		<div class="box box-info">
				<div class="box-header with-border">
					<div class="box-title">
						Add Stock
					</div>
				</div>

				<div class="box-body">
					
					<div class="row">
						<div class="col-md-2">
							<label>
								Product Attributes:
							</label>
						</div>

					
						<div class="col-md-10">
							@foreach($findpro->variants as $key=> $var)

						<div class="panel panel-default">
							<div class="panel-heading">
							  <label>
							  	<input required class="categories" type="checkbox" name="main_attr_id[]" id="categories_{{ $var->attr_name }}" child_id="{{$key}}" value="{{ $var->attr_name }}">
							    
                          @php
                              $key = '_'; 
                          @endphp
                          @if (strpos($var->getattrname->attr_name, $key) == false)
                          
                            {{ $var->getattrname->attr_name }}
                             
                          @else
                            
                            {{str_replace('_', ' ', $var->getattrname->attr_name)}}
                            
                          @endif
							</label>
							</div>

						<div class="panel-body">
							@foreach($var->attr_value as $a => $value)
							@php
								$nameofvalue = App\ProductValues::where('id','=',$value)->first();
							@endphp
							<label>
								
								<input required class="a a_{{ $var->attr_name }}" parents_id="{{ $var->attr_name }}" value="{{ $value }}" type="radio" name="main_attr_value[{{$var->attr_name}}]" id="{{ $key }}">

									@if(strcasecmp($nameofvalue->unit_value, $nameofvalue->values) !=0)

										@if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name == "Colour")
										                  <div class="margin-left-15 display-flex">
                                          <div class="color-options">
                                            <ul>
                                               <li title="{{ $nameofvalue->values }}" class="color varcolor active"><a href="#" title=""><i style="color: {{ $nameofvalue->unit_value }}" class="fa fa-circle"></i></a>
                                                      <div class="overlay-image overlay-deactive">
                                                      </div>
                                                </li>
                                            </ul>
                                          </div>
                                       </div>
                                      <span class="tx-color">{{ $nameofvalue->values }}</span>
										@else
										{{ $nameofvalue->values }}{{ $nameofvalue->unit_value }}
										@endif
									@else
										{{ $nameofvalue->values }}
									@endif

							
							</label>
							@endforeach

							
						</div>




					</div>

					@endforeach
					
					<label>Set Default Variant : 
							<input type="checkbox" name="def">
							</label>
						

					

						</div>
						 
					</div>
					

					
				</div>
			</div>
	</div>
   

    <div role="tabpanel" class="tab-pane fade" id="profile">
    	<br>
    	<div class="col-md-6">
    		<div class="form-group">
							<label for="">Additional Price For This Variant::</label>
							
							<div class="row">
								
								<div class="col-md-6">
									<input required value="{{ old('price') }}" placeholder="Enter Price ex 499.99" type="number" step=0.01 class="form-control" name="price">
	
								</div>
							</div>
							<small class="help-block">Please enter Price In Positive or Negative <br></small>
							
							<p class="dashed-border padding-8">
								<b>Ex. </b>If for this product price is 100 and you enter +10 than price will be 110
								<br> OR <br>
							If for this product price is 100 and you enter -10 than price will be 90
							</p>
		    </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-4">
                <label for="weight">Weight:</label>
                <input type="number" step=0.01 name="weight" class="form-control" value="0.00" placeholder="0.00">
            </div>
            <div class="col-md-6 margin-top-25">
              <select name="w_unit" class="select2 form-control">
                <option value="">Please Choose</option>
                @php
                  $unit = App\Unit::find(1);
                @endphp
                @if(isset($unit))
                  @foreach($unit->unitvalues as $unitVal)
                      <option value="{{ $unitVal->id }}">{{ ucfirst($unitVal->short_code) }} ({{ $unitVal->unit_values }})</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          
        </div>
    	</div>
    	
    </div>

    <div role="tabpanel" class="tab-pane fade" id="messages">
    	<br>
    	<div class="col-md-6">
    		<div class="form-group">
							<label for="">Add Stock:</label>
							<input required min="1" type="number" class="form-control" name="stock" placeholder="Enter stock" value="{{ old('stock') }}" >
			</div>
			
			<div class="form-group">
							<label for="">Min Qty :</label>
							<input required value="{{ old('min_order_qty')  }}" min="1" type="number" class="form-control" name="min_order_qty" placeholder="Enter Min Qty For order">
			</div>

			<div class="form-group">
							<label for="">Max Qty :</label>
							<input value="{{ old('max_order_qty') }}" min="1" type="number" class="form-control" name="max_order_qty" placeholder="Enter Max Qty For order">
			</div>
    	</div>
    		
    </div>

     <div role="tabpanel" class="tab-pane fade" id="varimage">
     	<br>

      <div class="alert alert-warning">
          <p><i class="fa fa-info-circle" aria-hidden="true"></i> Important</p>

          <ul>
            <li>Altleast two variant image is required !</li>
            <li>Default image will be <b><i>Image 1</i></b> later you can change default image in edit variant section</li>
          </ul>
      </div>	

     	<div class="row">
     		<div class="col-md-2">
     			<div class="product-var-class panel panel-primary bg-primary">
     				<label class="padding-one">Image 1</label>

     				  <div align="center" class="padding-0 panel-body">
     					
              <img class="test1 margin-bottom-10" id="preview1" align="center" width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
     					
     				   
     				</div>
            
           <div class="box-shadow-two file-upload">
                <div class="file-select">
                  <div class="file-select-button" id="fileName">Choose File</div>
                  <div class="file-select-name" id="noFile">No file chosen...</div> 
                  <input name="image1" type="file" name="chooseFile" id="image1">
                </div>
            </div>
              
           
     			</div>
     			
     		</div>

     		<div class="col-md-2">
          <div class="product-var-class panel panel-primary bg-primary">
            <label class="padding-one">Image 2</label>

            <div class="panel-body padding-0 text-center">
              
              <img class="test2 margin-bottom-10" id="preview2" align="center" width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
              
               
            </div>
            
           <div class="box-shadow-two file-upload2">
                <div class="file-select2">
                  <div class="file-select-button2" id="fileName2">Choose File</div>
                  <div class="file-select-name2" id="noFile2">No file chosen...</div> 
                  <input required name="image2" type="file" name="chooseFile" id="image2">
                </div>
            </div>
              
           
          </div>
          
        </div>

        <div class="col-md-2">
          <div class="panel panel-primary bg-primary product-var-class">
            <label class="box-shadow-two">Image 3</label>

            <div align="center" class="panel-body padding-0">
              
              <img class="test3 margin-bottom-10" id="preview3" align="center" width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
              
               
            </div>
            
           <div class="box-shadow-two file-upload3">
                <div class="file-select3">
                  <div class="file-select-button3" id="fileName3">Choose File</div>
                  <div class="file-select-name3" id="noFile3">No file chosen...</div> 
                  <input name="image3" type="file" name="chooseFile" id="image3">
                </div>
            </div>
              
           
          </div>
          
        </div>

        <div class="col-md-2">

          <div class="box-shadow-two panel panel-primary bg-primary">
            <label class="padding-one">Image 4</label>

            <div align="center" class="padding-0 panel-body">
              
              <img class="margin-top-5 margin-bottom-10" id="preview4" align="center" width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
              
               
            </div>
            
           <div class="box-shadow-two file-upload4">
                <div class="file-select4">
                  <div class="file-select-button4" id="fileName4">Choose File</div>
                  <div class="file-select-name4" id="noFile4">No file chosen...</div> 
                  <input name="image4" type="file" name="chooseFile" id="image4">
                </div>
            </div>
              
           
          </div>
          
        </div>

          <div class="col-md-2">

         <div class="panel panel-primary bg-primary product-var-class">
            <label class="padding-one">Image 5</label>

            <div align="center" class="padding-0 panel-body">
              
              <img class="test5 margin-bottom-10" id="preview5" align="center" width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
              
               
            </div>
            
           <div class="box-shadow-two file-upload5">
                <div class="file-select5">
                  <div class="file-select-button5" id="fileName5">Choose File</div>
                  <div class="file-select-name5" id="noFile5">No file chosen...</div> 
                  <input name="image5" type="file" name="chooseFile" id="image5">
                </div>
            </div>
              
           
          </div>
          
        </div>


          <div class="col-md-2">

          <div class="product-var-class panel panel-primary bg-primary">
             <label class="padding-one">Image 6</label>

            <div align="center" class="padding-one panel-body">
              
              <img class="test6 margin-bottom-10px" id="preview6" align="center" width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
              
               
            </div>
            
           <div class="box-shadow-two file-upload6">
                <div class="file-select6">
                  <div class="file-select-button6" id="fileName6">Choose File</div>
                  <div class="file-select-name6" id="noFile6">No file chosen...</div> 
                  <input name="image6" type="file" name="chooseFile" id="image6">
                </div>
            </div>
              
           
          </div>
          
        </div>
     		
     	
     		
     		
     		

     		

     	</div>
     </div>

 </div>

  <div class="col-md-12">
  	<a href="{{ route('seller.add.var',$findpro->id) }}" class="margin-left-15 pull-right btn btn-md btn-default">
	   		<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
			 Back
	</a>

  	<button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" title="This action is disabled in demo !" @endif class="pull-right btn btn-md btn-primary"><i class="fa fa-plus"></i> Add Stock
   </button>

 
	   	
	
  </div>

	</form>
  </div>

</div>

			
		</div>
		</div>

	</div>
@endsection
@section('custom-script')
  
  <script>var baseUrl = "<?= url('/') ?>";</script>
	<script src="{{ url('js/sellervariant.js') }}"></script>
  
@endsection