<a title="Delete ?" @if(env('DEMO_LOCK')==0) data-toggle="modal" data-target="#delete{{ $id }}" @else
  disabled="disabled" title="This operation is disabled in Demo !" @endif class="btn btn-sm btn-danger">
  <i class="fa fa-trash"></i>
</a>

<div id="delete{{ $id }}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete this subscription? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{ route('seller.subs.delete.subscription',$id) }}" class="pull-right">
            
            @csrf
            @method('DELETE')

          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>