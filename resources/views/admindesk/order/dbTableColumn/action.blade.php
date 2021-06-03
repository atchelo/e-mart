<button @if(env('DEMO_LOCK') == 0) data-target="#{{ $id }}orderModel" data-toggle="modal" @else disabled="" title="This action is disabled in demo !" @endif class="btn btn-sm btn-danger">
    <i class="fa fa-trash-o"></i>
</button>

<div id="{{ $id }}orderModel" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">Are You Sure ?</h4>
          <p>Do you really want to delete this order <b>{{ $order_id }}</b>? This process cannot be undone.</p>
        </div>
        <div class="modal-footer">
         <form method="POST" action="{{ route('order.delete',$id) }}">
              @csrf
              {{ method_field("DELETE") }}

            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-danger">Yes</button>
          </form>
        </div>
      </div>
    </div>
</div>


<a title="Print Order" href="{{ route('order.print',$id) }}" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i></a>