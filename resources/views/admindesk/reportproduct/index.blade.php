@extends('admindesk.layouts.master')
@section('title','Reported Products | ')
@section('body')
	<div class="box" >
		<div class="box-header with-border">
			<div class="box-title">
				Reported Products
			</div>
		</div>

		<div class="box-body">
			<table id="reporttable" class="width100 table table-bordered table-hover">
				
				<thead>

					<th>#</th>
					<th>Report Detail</th>
					<th>Report Description</th>
					<th>Reported On</th>

				</thead>
				
				<tbody>
					
				</tbody>

			</table>
		</div>
	</div>
@endsection
@section('custom-script')
<script>
	var url = {!! json_encode( route('get.rep.pro') ) !!};
</script>
<script src="{{ url('js/report.js') }}"></script>
@endsection