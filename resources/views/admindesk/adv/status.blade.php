<a @if(env('DEMO_LOCK') == 0) href="{{ route('adv.quick.update',$id) }}" @else disabled title="This operation is disabled is demo !" @endif class="btn btn-sm btn-flat {{ $status == 1 ? "bg-green" : "btn-danger" }}">
	{{ $status == 1 ? "Active" : "Deactive" }}
</a>