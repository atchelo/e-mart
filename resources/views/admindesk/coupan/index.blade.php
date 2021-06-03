@extends("admindesk/layouts.master")
@section('title','All Coupans |')
@section("body")
  <div class="box">
    <div class="box-header with-border">
      <div class="box-title">
        Coupons
      </div>

      <a title="Create new Coupon" href="{{ route('coupan.create') }}" class="pull-right btn bg-blue btn-flat">
        <i class="fa fa-plus"></i> Create
      </a>
    </div>

    <div class="box-body">
    	<table id="full_detail_table" class="table table-bordered table-striped">
    		<thead>
    			<th>ID</th>
    			<th>CODE</th>
    			<th>Amount</th>
    			<th>Max Usage</th>
    			<th>Detail</th>
    			<th>Action</th>
    		</thead>
    	

    	<tbody>
    		@foreach($coupans as $key=> $cpn)
	    		<tr>
	    			<td>{{ $key+1 }}</td>
	    			<td>{{ $cpn->code }}</td>
	    			<td>@if($cpn->distype == 'fix') <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i> @endif {{ $cpn->amount }}@if($cpn->distype == 'per')% @endif </td>
	    			<td>{{ $cpn->maxusage }}</td>
	    			<td>
	    				<p>Linked to : <b>{{ ucfirst($cpn->link_by) }}</b></p>
	    				<p>Expiry Date: <b>{{ date('d-M-Y',strtotime($cpn->expirydate)) }}</b></p>
	    				<p>Discount Type: <b>{{ $cpn->distype == 'per' ? "Percentage" : "Fixed Amount" }}</b></p>
	    			</td>
	    			<td>
	    				<a title="Edit coupon" href="{{ route('coupan.edit',$cpn->id) }}" class="btn btn-sm bg-blue btn-flat">
	    					<i class="fa fa-pencil"></i>
	    				</a>

	    				<a title="Delete coupon" @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#coupon{{ $cpn->id }}" @else title="This operation is disabled in demo !" disabled @endif class="btn btn-sm bg-red btn-flat">
	    					<i class="fa fa-trash"></i>
	    				</a>
	    			</td>

                    <div id="coupon{{ $cpn->id }}" class="delete-modal modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <div class="delete-icon"></div>
                            </div>
                            <div class="modal-body text-center">
                              <h4 class="modal-heading">Are You Sure ?</h4>
                              <p>Do you really want to delete this Coupon ? This process cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                 <form method="post" action="{{route('coupan.destroy',$cpn->id)}}" class="pull-right">
                                        {{csrf_field()}}
                                         {{method_field("DELETE")}}
                                          
                                 <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes</button>
                              </form>
                            </div>
                          </div>
                        </div>
                    </div>
	    		</tr>
    		@endforeach
    	</tbody>

    	</table>
    </div>
  </div>
@endsection