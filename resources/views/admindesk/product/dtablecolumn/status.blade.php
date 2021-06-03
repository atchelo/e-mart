<form action="{{ route('product.quick.update',$id) }}" method="POST">
  @csrf
  <button @if($store['status'] != '1' ) title="Store is deactivated !" disabled="disabled" @endif type="submit" class="btn btn-xs {{ $status == '1' ? "btn-success" : "btn-danger" }}">
    {{ $status == '1' ? 'Active' : 'Deactive' }}
  </button>
</form> 