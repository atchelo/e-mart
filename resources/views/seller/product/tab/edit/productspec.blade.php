<h3>Product Specification</h3>
<hr>
 <a type="button" class="btn btn-danger btn-md z-depth-0" data-toggle="modal" data-target="#bulk_delete"><i class="fa fa-trash"></i> Delete Selected</a> 
<hr>
<form action="{{ route('pro.specs.store',$products->id) }}" method="POST">
				  		@csrf
	<table class="table table-striped table-bordered">
		<thead>
			<th>
                <div class="inline">
                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all"/>
                <label for="checkboxAll" class="material-checkbox"></label>
              </div>
              
              </th>
			<th>Key</th>
			<th>Value</th>
			<th>#</th>
		</thead>

		<tbody>
			@if(isset($products->specs))
				@foreach($products->specs as $spec)
					<tr>
						<td>
		                    <div class="inline">
		                      <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$spec->id}}" id="checkbox{{$spec->id}}">
		                      <label for="checkbox{{$spec->id}}" class="material-checkbox"></label>
		                    </div>
	                    </td>
						<td>{{ $spec->prokeys }}</td>
						<td>{{ $spec->provalues }}</td>
						<td>
							
									<a data-toggle="modal" title="Edit" data-target="#edit{{ $spec->id }}" class="btn btn-sm btn-info">
										<i class="fa fa-pencil"></i>
									</a>
									
								
								
							</div>
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
  	<table class="table table-striped table-bordered" id="dynamic_field"> 
				  	
	       <tbody>
	       		 <tr> 
		            <td>
		               <input required="" name="prokeys[]" type="text" class="form-control" value="" placeholder="Product Attribute">
		            </td>

		            <td>
		             	<input required="" name="provalues[]" type="text" class="form-control" value="" placeholder="Attribute Value">
		            </td>  
		            <td>
		            	<button type="button" name="add" id="add" class="btn btn-xs btn-success">
		              	<i class="fa fa-plus"></i>
		            	</button>
		        	</td>  
	        	</tr>  
	       </tbody>
				     
    </table>
    <div class="container-fluid">
    	<button class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Add</button>
    </div>
</form>

@section('tab-modal-area')
@if(isset($products->specs))
	@foreach($products->specs as $spec)
		<div id="edit{{ $spec->id }}" class="delete-modal modal fade" role="dialog">
	        <div class="modal-dialog modal-md">
	          <!-- Modal content-->
	          <div class="modal-content">
	            <div class="modal-header">
	              <div class="modal-title">Edit : <b>{{ $spec->prokeys }}</b></div>
	            </div>
	            <div class="modal-body">
	              <form action="{{ route('pro.specs.update',$spec->id) }}" method="POST">
	              	  @csrf

	              	  <div class="form-group">
	              	  	<label>Attribute Key:</label>
	              	    <input required="" type="text" name="pro_key" value="{{ $spec->prokeys }}" class="form-control">
	              	  </div>

	              	  <div class="form-group">
	              	  	<label>Attribute Value:</label>
	              	  	<input required="" type="text" name="pro_val" value="{{ $spec->provalues }}" class="form-control">
	              	  </div>
					

						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
						<button type="reset" class="btn btn-danger translate-y-3" data-dismiss="modal">Cancel</button>
                		
					

	              </form>
	            </div>
	            
	          </div>
	        </div>
	      </div>
	@endforeach
@endif

@endsection



