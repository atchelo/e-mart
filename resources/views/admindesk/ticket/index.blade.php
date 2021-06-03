@extends('admindesk.layouts.master')
@section('title','View All Support Tickets -')
@section('body')
<div class="box" >

	<div class="box-header with-border">
		<div class="box-title">View All Support Tickets</div>
	</div>

	<div class="box-body">
		
		<table id="ticket_table" class="width100 table table-hover table-responsive">
			<thead>
				<tr>
					<th>#</th>
					<th>Ticket No.</th>
					<th>Issue Title</th>
					<th>From</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				
				
			</tbody>
		</table>	
	</div>
</div>
@endsection

@section('custom-script')
<script>
var url = {!!json_encode( route('tickets.admindesk') )!!};
</script>
<script src="{{ url('js/ticket.js') }}"></script>
@endsection