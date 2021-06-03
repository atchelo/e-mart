 <a title="Edit Brand {{ $name }}" href="{{url('admindesk/brand/'.$id.'/edit')}}"class="btn btn-sm btn-info">
        <i class="fa fa-pencil"></i>
</a>
    
<a title="Delete Brand {{ $name }}" @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{$id}}deletebrand" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-sm btn-danger">
  <i class="fa fa-trash"></i>
</a>
    
