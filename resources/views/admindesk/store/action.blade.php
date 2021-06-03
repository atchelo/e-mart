<ul class="nav table-nav">
  <li class="dropdown">
  <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
    Action <span class="caret"></span>
  </a>
  <ul class="dropdown-menu dropdown-menu-right">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="{{url('admindesk/stores/'.$id.'/edit')}}">
      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Store</a></li>
      
      
      <li role="presentation" class="divider"></li>
      <li role="presentation">
        <a @if(env('DEMO_LOCK') == 0) data-toggle="modal" href="#{{$id}}deletestore" @else disabled title="This action is disabled in demo !" @endif>
          <i class="fa fa-trash-o" aria-hidden="true"></i>Delete
        </a>
      </li>
  </ul>
  </li>
</ul>

<div id="{{ $id }}deletestore" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete this store? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{url('admindesk/stores/'.$id)}}" class="pull-right">
            {{csrf_field()}}
            {{method_field("DELETE")}}
                           
      
          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>
