@extends("admindesk/layouts.master")
@section('title','All Childcategories |')
@section("body")


<div class="box">
  <div class="box-header with-border">
    <div class="box-title">Child Category</div>

    <a href=" {{url('admindesk/grandcategory/create')}} " class="pull-right btn btn-success">+ Add New Childcategory</a>
    <br><br>
    <div class="callout callout-success">
      <p><i class="fa fa-info-circle"></i> Drag and Drop to sort the Childcategories</p>
    </div>

  </div>
  <div class="box-body">
    <table id="full_detail_table" class="tcl width100 table table-bordered table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Category Title</th>
          <th>Status</th>
          <th>Featured</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1;?>
        @foreach($cats as $key=> $cat)
        <tr class="row1" data-id="{{ $cat->id }}">
          <td>{{$i++}}</td>
          <td>
            @if($cat->image != '' && file_exists(public_path().'images/grandcategory/'.$cat->image) )
            <img src=" {{url('images/grandcategory/'.$cat->image)}}" class="width-hight" title="{{ $cat->title }}">
            @else

            <img title="{{ $cat->title }}" src="{{ Avatar::create($cat->title)->toBase64() }}" />

            @endif
          </td>

          <td>
            <p><b>Name: </b> <span class="font-weight500">{{ $cat->title }}</span></p>
            <p><b>Description: </b><span class="font-weight500">{{ strip_tags($cat->description) }}</span></p>
            <p><b>Subcategory: </b><span class="font-weight500">{{ isset($cat->subcategory) ? $cat->subcategory->title : '' }}</span></p>
          </td>


          <td>

            <form method="POST" action="{{ route('child.quick.update',$cat->id) }}">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-xs {{ $cat->status ==1 ? 'btn-success' : 'btn-danger' }}">
                {{ $cat->status==1 ? 'Active' : 'Deactive' }}
              </button>
            </form>

          </td>
          <td>
            <form method="POST" action="{{ route('child.featured.quick.update',$cat->id) }}">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-xs {{ $cat->featured ==1 ? 'btn-success' : 'btn-danger' }}">
                {{ $cat->featured==1 ? 'Yes' : 'No' }}
              </button>
            </form>
          </td>
          <td>
            <p> <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
              <span class="font-weight500">{{ date('M jS Y',strtotime($cat->created_at)) }},</span></p>
            <p><i class="fa fa-clock-o" aria-hidden="true"></i>
              <span class="font-weight500">{{ date('h:i A',strtotime($cat->created_at)) }}</span></p>

            <p class="greydashedborder"></p>

            <p>
              <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
              <span class="font-weight500">{{ date('M jS Y',strtotime($cat->updated_at)) }}</span>
            </p>

            <p><i class="fa fa-clock-o" aria-hidden="true"></i>
              <span class="font-weight500">{{ date('h:i A',strtotime($cat->updated_at)) }}</span></p>

          </td>
          <td>



            <ul class="nav table-nav">
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                  Action <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li role="presentation"><a role="menuitem" tabindex="-1"
                      href="{{url('admindesk/grandcategory/'.$cat->id.'/edit')}}">
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Childcategory</a></li>


                  <li role="presentation" class="divider"></li>
                  <li role="presentation">
                    <a @if(env('DEMO_LOCK')==0) data-toggle="modal" href="#{{$cat->id}}child" @else
                      title="This operation is disabled in demo !" disabled @endif>
                      <i class="fa fa-trash-o" aria-hidden="true"></i>Delete
                    </a>
                  </li>
                </ul>
              </li>
            </ul>




          </td>




        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- /.box-body -->
</div>




@foreach($cats as $key=> $cat)
<div id="{{ $cat->id }}child" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete this Childcategory? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{url('admindesk/grandcategory/'.$cat->id)}}" class="pull-right">
          {{csrf_field()}}
          {{method_field("DELETE")}}


          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection
@section('custom-script')
<script>
  var url = {
    !!json_encode(url('/reposition/childcategory/')) !!
  };
</script>
<script src="{{asset('js/childcategory.js')}}"></script>
@endsection