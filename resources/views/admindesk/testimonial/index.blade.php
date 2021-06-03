@extends("admindesk/layouts.master")
@section('title','Testimonials')
@section("body")
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Testimonial</h3>
    <a href=" {{url('admindesk/testimonial/create')}} " class="btn btn-success pull-right">+ Add New</a>
  </div>
    <div class="box-body">
      <table id="full_detail_table" class="width100 table table-bordered table-striped">
        <thead>
          <tr class="table-heading-row">
            <th>ID</th>
            <th>Name</th>
            <th>Feedback</th>
            <th>Designation</th>
            <th>Image</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1;?>
          @foreach($clients as $clint)

          <tr>
            <td>{{$i++}}</td>
            <td>{{$clint->name}}</td>
            <td>{{strip_tags($clint->des)}}</td>
            <td>{{$clint->post}}</td>
            <td><img src="{{url('images/testimonial/'.$clint->image)}}" class="height-50"></td>
            <td>{{$clint->rating}}</td>
            <td>
              <form action="{{ route('clint.quick.update',$clint->id) }}" method="POST">
                {{csrf_field()}}
                <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled="disabled"
                  title="This operation is disabled in demo" @endif
                  class="btn btn-xs {{ $clint->status==1 ? "btn-success" : "btn-danger" }}">
                  {{ $clint->status ==1 ? 'Active' : 'Deactive' }}
                </button>
              </form>
            </td>
            <td>
              <div class="row">
                <div class="col-md-2">
                  <a href="{{url('admindesk/testimonial/'.$clint->id.'/edit')}}" class="btn btn-sm btn-info">
                    <i class="fa fa-pencil"></i>
                  </a>
                </div>
                <div class="col-md-2 margin-left-15">
                  <button @if(env('DEMO_LOCK')==0) data-toggle="modal" data-target="#{{$clint->id}}cli" @else
                    disabled="disabled" title="This operation is disabled in demo" @endif class="btn btn-sm btn-danger">
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
              </div>



            </td>

          </tr>
          @endforeach

        </tbody>
      </table>

    </div>
    <!-- /.box-body -->
  </div>
</div>

@foreach($clients as $clint)
<div id="{{$clint->id}}cli" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete this testimonial? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">

        <form method="post" action="{{url('admindesk/testimonial/'.$clint->id)}}" class="pull-right">
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


<!-- /page content -->
@endsection