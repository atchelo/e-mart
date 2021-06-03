<br>
<div class="row">
	<div class="col-md-3">
			<label>Show Related Product Manually:</label>
	</div>

	<div class="col-md-2">
		
			@if(isset($rel_setting))

			<label class="switch">
				<input type="checkbox" name="rel_setting" {{ $rel_setting->status == 1 ? "checked" : "" }} onchange="changesetting()" id="rel_set">
				<span class="knob"></span>
			</label> 

			@else

			<label class="switch">
				<input type="checkbox" name="rel_setting"  onchange="changesetting()" id="rel_set">
				<span class="knob"></span>
			</label> 

			@endif

			
	</div>
	<div class="col-md-12">
		<p class="help-block">
				<b>(If this turned on you can manually select related product for this particular product else if its turned off related product will show accodring to product's subcategory.)</b>
		</p>
	</div>
	
</div>  
<div class="@if(!isset($rel_setting)) 'display-none' @elseif($rel_setting->status == 1) 'display-none' @endif" id="manuallyProShow" class="box box-danger">
	<div class="box-header with-border">
			<div class="box-title">
				Related Products
			</div>

			<a data-toggle="modal" data-target="#relProModal" class="pull-right btn btn-primary owtbtn">+ Add/Update Related Products</a> 
	</div>

	<div class="box-body">
		<table class="table table-bordered">
			<tbody>
				
				@if(isset($products->relproduct->related_pro))
					@foreach($products->relproduct->related_pro as $relpro)
							@php
								$epro = App\Product::find($relpro);
							@endphp

					  @if(isset($epro))

							<tr>
								<td align="center">
									@if(isset($epro->subvariants[0]))
									<img  class="pro-img" title="{{ $epro->name }}" src="{{ url('variantimages/thumbnails/'.$epro->subvariants[0]->variantimages['main_image']) }}" alt="product-image">
									@else
										<img title="Make a variant first !" src="{{  Avatar::create($epro->name)->toBase64() }}"/>
									@endif
								</td>
								<td>
									<b>{{ $epro->name }}</b>
									<p>
										{{substr(strip_tags($epro->des), 0, 150)}}{{strlen(strip_tags(
                							$epro->des))>150 ? '...' : ""}}
                					</p>
								</td>
								
							</tr>
							
							

					  @endif
					@endforeach
				@endif

			</tbody>
		</table>
	</div>
</div>
<script>var url = {!!json_encode( route('prorelsetting',$products->id) )!!};</script>
<script src="{{ url('js/relatedproscript.js') }}"></script>
