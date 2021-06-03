@extends("admindesk/layouts.master")
@section('title',"Manage $unit->title Values | ")
@section("body")
<div class="box" >
		
		<div class="box-header with-border">
			<h4>Option values for : <b>{{ $unit->title }}</b></h4>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-md-4">
					<h5>Add New Value for <b>{{ $unit->title }}</b></h5>

					<form method="POST" action="{{ route('store.val.unit',$unit->id) }} ">
						{{ csrf_field() }}

						<div class="form-group">
							<label for="">Value :</label>
							<input required="" type="text" name="unit_values" class="form-control">
						</div>

						<div class="form-group">
							<label>Short Code: </label>
							<input type="text" required class="form-control" name="short_code">
						</div>

						<button class="btn btn-md btn-primary">
							<i class="fa fa-plus"></i> ADD
						</button>
						&nbsp;
						<a  href="{{ route('unit.index') }}" class="color-11">
						<button type="button" class="btn btn-md btn-default">
						<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> 
							Back
						</button>
					</a>
						
					</form>
				</div>

				<div class="col-md-8">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Value</th>
								<th>Short Code</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@foreach($unit->unitvalues as $a => $unitval)
							<tr>
								<td>
									{{ $a+1 }}
								</td>

								<td>
									{{ $unitval->unit_values }}
								</td>

								<td>
									{{ $unitval->short_code }}
								</td>

								<td>
									<a data-target="#edit{{ $unitval->id }}" data-toggle="modal" class="btn btn-sm btn-primary">
										<i class="fa fa-pencil"></i>
									</a>

									<a @if(env('DEMO_LOCK') == 0) data-target="#del{{ $unitval->id }}" data-toggle="modal" @else title="This action is disabled in demo !" disabled @endif class="btn btn-sm btn-danger">
										<i class="fa fa-trash-o"></i>
									</a>
								</td>

			
                  <!--END-->
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				
			</div>
		</div>
	</div>
@foreach($unit->unitvalues as $a => $unitval)
	<!-- Edit Modal -->
            <div class="modal fade" id="edit{{ $unitval->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit {{ $unitval->unit_values }}</h4>
                  </div>
                  <div class="modal-body">
                     <form action="{{ route('edit.val.unit',$unitval->id) }}" method="POST">
                     	{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label for="">Title :</label>
							<input type="text" value="{{ $unitval->unit_values }}" class="form-control" name="unit_values">
						</div>

						<div class="form-group">
							<label>Short Code: </label>
							<input type="text" value="{{ $unitval->short_code }}" class="form-control" name="short_code">
						</div>

						<button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" title="This action is disabled in demo !"  @endif class="btn btn-md btn-primary">
							Update
						</button>


                     </form>
                  </div>
                 
                </div>
              </div>
            </div>

             <!--Modal for Delete-->
            <div id="del{{ $unitval->id }}" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete this? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      <form method="POST" action="{{ route('del.unit.val',$unitval->id) }}">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          
                        <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                      </form>
                    </div>
                  </div>
                </div>
          </div>
   @endforeach
@endsection