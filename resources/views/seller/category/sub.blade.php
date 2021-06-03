@extends('admindesk.layouts.sellermaster')
@section('title','All Subcategories | ')
@section('body')
<div class="box">
	<div class="box-header with-border">
		<div class="box-title">
			
			All Subcategories

		</div>
	
	</div>

	<div class="box-body">
		<table id="subcats" class="table table-bordered table-striped">
				<thead>
					<th>
						#
					</th>
					<th>
						Thumbnail
					</th>
					<th width="20%">
						Name
					</th>
					<th width="20%">
						Parent Category Name
					</th>
					<th>
						Details
					</th>
				</thead>

				<tbody>
					
				</tbody>
		</table>
	</div>
</div>
@endsection
@section('custom-script')
	<script>
		$(function () {

		      "use strict";
		      
		      var table = $('#subcats').DataTable({
		          processing: true,
		          serverSide: true,
		          ajax: "{{ route('seller.get.subcategories') }}",
		          columns: [
		              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
		              {data : 'thumbnail', name : 'thumbnail'},
		              {data : 'name', name : 'name'},
		              {data : 'parentcat', name : 'category.title'},
		              {data : 'details', name : 'details'}
		          ],
		          dom : 'lBfrtip',
		          buttons : [
		            'csv','excel','pdf','print','colvis'
		          ],
		          order : [[0,'DESC']]
		      });
		      
		});
	</script>
@endsection