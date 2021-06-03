@extends('admindesk.layouts.master')
@section('title',"Tickets - $ticket->ticket_no")
@section('body')
<div class="box col-md-8">
	<div class="box-header with-border">
		<div class="box-title">
			<a title="goback" href="{{ url('admindesk/tickets') }}">
				<i class="fa fa-chevron-circle-left"></i>
			</a> Ticket #{{ $ticket->ticket_no }} {{ $ticket->issue_title }} By : {{ $ticket->users_t ? $ticket->users_t->name : 'User not found !' }}

			@if($ticket->status =="open")
			<p class="label label-info">
				<i class="fa fa-bullhorn" aria-hidden="true"></i>
				{{ ucfirst($ticket->status) }}
			</p>
			@elseif($ticket->status=="pending")
			<p class="label label-default">
				<i class="fa fa-clock-o"></i> 
				{{ ucfirst($ticket->status) }}
			</p>
			@elseif($ticket->status=="closed")
			<p class="label label-danger">
				<i class="fa fa-ban"></i> 
				{{ ucfirst($ticket->status) }}
			</p>
			@elseif($ticket->status=="solved")
				<p class="label label-success">
					<i class="fa fa-check"></i> {{ ucfirst($ticket->status) }}
				</p>
			@endif


		</div>

	</div>


	<div class="row">
		<div class="box-body col-md-8">



			<div class="box box-danger">



				<div class="box-body">
					<div id="msg" class="well" class="c box-body-style "></div>
					@if($ticket->image != null)

					<img src="{{ url('images/helpDesk/'.$ticket->image) }}" class="img-responsive" alt="attached_image"
						title="Attached Image">

					@endif
					<br>
					<blockquote>
						{!! $ticket->issue !!}
					</blockquote>

					<div class="form-group">
						<label>Change Status:</label>
						<select id="getStatus" onchange="status('{{ $ticket->id }}')" class="select2 form-control"
							name="status" id="">
							<option {{ $ticket->status =="open" ? "selected" : ""}} value="pending">Pending</option>
							<option {{ $ticket->status =="open" ? "selected" : ""}} value="open">Open</option>
							<option {{ $ticket->status =="closed" ? "selected" : ""}} value="closed">Closed</option>
							<option {{ $ticket->status =="solved" ? "selected" : "" }} value="solved">Solved</option>
						</select>
					</div>

				</div>



				<div class="box-footer">



					<div class="col-md-4">
						<button id="rpy_btn" class="btn btn-sm btn-primary">Reply</button>
					</div>

					<br><br>
					<div class="collapse c" id="replay">
						<form action="{{ route('ticket.replay',$ticket->ticket_no) }}" method="POST">
							{{ csrf_field() }}
							<textarea class="form-control" name="msg" id="editor1" cols="30" rows="10"></textarea>
							<br>
							<button type="submit" class="btn btn-md btn-primary">Send Mail</button>
							<button type="button" id="cancel_btn" class="btn btn-md btn-danger">Cancel</button>
						</form>



					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('custom-script')
<script>
	var url = {
		!!json_encode(url('admindesk/update/ticket/')) !!
	};
	var redirecturl = {
		!!json_encode(route('ticket.show', $ticket - > ticket_no)) !!
	};
</script>
<script src="{{asset('js/ticketshow.js')}}"></script>
@endsection