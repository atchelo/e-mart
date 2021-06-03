<a data-toggle="modal" data-target="#trashModal{{ $id }}" title="Delete Comment" class="btn btn-danger btn-sm btn-flat">
	<i class="fa fa-trash-o"></i>
</a>

<!-- Delete Modal -->
<div id="trashModal{{ $id }}" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this blog comment? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('comment.delete',$id) }}" class="pull-right">
                              {{csrf_field()}}
                              {{method_field("DELETE")}}
                                
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
   </div>
