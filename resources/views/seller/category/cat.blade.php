@extends('admindesk.layouts.sellermaster')
@section('title','All Categories | ')
@section('body')
<div class="box">
	<div class="box-header with-border">
		<div class="box-title">
			
			All Categories

		</div>
	
	</div>

	<div class="box-body">
		<table id="allcats" class="table table-bordered table-striped">
				<thead>
					<th>
						#
					</th>
					<th width="15%">
						Thumbnail
					</th>
					<th width="50%">
						Name
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
		      
		      var table = $('#allcats').DataTable({
		          processing: true,
		          serverSide: true,
		          ajax: "{{ route('seller.get.categories') }}",
		          columns: [
		              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
		              {data : 'thumbnail', name : 'thumbnail'},
		              {data : 'name', name : 'name'},
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