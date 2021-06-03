@extends("admindesk/layouts.master")
@section('title','Manage All Options | ')

@section("body")
	<div class="box" >
		<div class="box-header with-border">
			<h4>Option values for : <b>{{ $proattr->attr_name }}</b></h4>
		</div>

		<div class="box-body">
			<div class="alert alert-warning">
				<i class="fa fa-info-circle" aria-hidden="true"></i> Once you created value option you can't Delete it ! You can only edit it
			</div>
			<div class="row">
				<div class="col-md-4">
					<h5>Add New Option Value for <b>{{ $proattr->attr_name }}</b></h5>
					
					<form method="POST" action="{{ route('pro.val.store',$proattr->id) }}">
						{{ csrf_field() }}

						<div class="form-group">
							<label for="">Value :</label>
							<input required="" type="text" name="value" class="form-control">
						</div>
						@if($proattr->attr_name == "Color" || $proattr->attr_name == "Colour")
							<div class="input-group my-colorpicker2 colorpicker-element">
				                  <input placeholder="Choose Color" name="unit_value" type="text" class="form-control">

				                  <div class="input-group-addon">
				                    <i></i>
				                  </div>
				            </div>
						@else
						<div class="form-group">
							@php
								$getunitvals = App\UnitValues::where('unit_id','=',$proattr->unit_id)->get();
							@endphp
							<select name="unit_value" id="" class="form-control">

								@isset($getunitvals)
									@foreach($getunitvals as $unitval)
										<option value="{{ $unitval->short_code }}">{{ $unitval->unit_values }} {{ "(".$unitval->short_code.")" }}</option>
									@endforeach
								@endisset
								
							</select>
						</div>
						@endif
						
						<br>
						<button class="btn btn-md btn-primary">
							<i class="fa fa-plus"></i> ADD
						</button>
						&nbsp;
						<a class="color111" href="{{ route('attr.index') }}">
						<button type="button" class="btn btn-md btn-default">
						<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> 
							Back
						</button>
					</a>
						<br><br>
					</form>
				</div>

				<div class="col-md-8">
					<table class="table table-bordered table-striped">
						<thead>
							<th>#</th>
							<th>Value</th>
							<th>Action</th>
						</thead>

						<tbody>
							<?php $i=0;?>
							@foreach($provalues as $proval)
							<?php $i++; ?>
								<tr>
									<td>{{$i}}</td>
									<td>
										
										@if(strcasecmp($proval->unit_value, $proval->values) !=0)

										@if($proattr->attr_name == "Color" || $proattr->attr_name == "Colour")
											
										<div class="inline-flex margin-left-minus-15">
                                          <div class="color-options">
                                            <ul>
                                               <li title="{{ $proval->values }}" class="color varcolor active"><a href="#" title=""><i style="color: {{ $proval->unit_value }}" class="fa fa-circle"></i></a>
                                                      <div class="overlay-image overlay-deactive">
                                                      </div>
                                                </li>
                                            </ul>
                                          </div>
                                       </div>
                                		<span class="tx-color">{{ $proval->values }}</span>

										@else
										{{ $proval->values }}{{ $proval->unit_value }}
										@endif
										@else
										{{ $proval->values }}
										@endif
									</td>
									<td>
										
										<button data-toggle="modal" href="#{{ $proval->id }}valedit" class="btn btn-sm btn-primary">
											<i class="fa fa-pencil"></i>
										</button>
											
									</td>

									
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	@foreach($provalues as $proval)
	<!-- Modal for Edit-->
	<div id="{{ $proval->id }}valedit" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
			  Edit Value: <b>{{ $proval->values }}</b>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

            	<div class="display-none" id="result{{ $proval->id }}">
            		
            	</div>

            	<div class="form-group">

            		<label for="">Edit Value:</label>
            		<input id="getValue{{ $proval->id }}" type="text" placeholder="Enter value" class="form-control" name="values" value="{{ $proval->values }}">
            		
				</div>

				@php
					$getunit = App\Unit::where('id','=',$proval->proattr->unit_id)->first();
				@endphp
				
				<div class="form-group">
						@if($proval->proattr->attr_name == "Color" || $proval->proattr->attr_name == "Colour")
							
							<div class="input-group my-colorpicker colorpicker-element">
				                  <input id="unit_val{{ $proval->id }}" value="{{ $proval->unit_value }}" placeholder="Choose Color" name="unit_value" type="text" class="form-control">

				                  <div class="input-group-addon">
				                    <i></i>
				                  </div>
				            </div>
						@else
					
					<select name="unit_value" id="unit_val{{ $proval->id }}" class="form-control">
						@isset($getunit->unitvalues)
							@foreach ($getunit->unitvalues as $uval)
								<option {{ $proval->unit_value == $uval->short_code ? "selected" : "" }} value="{{ $uval->short_code }}">{{ $uval->unit_values }}</option>
							@endforeach
						@endisset
					</select>

					@endif
				</div>
             	
            </div>
            <div class="modal-footer">
             
									
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">Cancel</button>
                <button @if(env('DEMO_LOCK') == 0) onclick="submit('{{ $proval->id }}','{{ $proattr->id }}')" type="submit" @else title="This action is disabled in demo !" disabled="disabled"  @endif id="update" class="btn btn-primary">Update</button>
             
            </div>
          </div>
        </div>
     </div>	
	<!--END-->
	@endforeach
@endsection

@section('custom-script')
<script>
	var url = {!!json_encode( url('admindesk/product/manage/values/update/') )!!};
</script>
<script src="{{ url('js/provalue.js') }}"></script>
@endsection