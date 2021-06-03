 <form action="{{ route('product.featured.quick.update',$id) }}" method="POST">
     @csrf
     <button type="submit" class="btn btn-xs {{ $featured == '1' ? "btn-success" : "btn-danger" }}">
         {{ $featured == '1' ? 'Yes' : 'No' }}
     </button>
 </form>
