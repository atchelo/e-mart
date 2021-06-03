@extends("admindesk/layouts.master")
@section('title','All Pages | ')
@section("body")


<div class="box">
  <div class="box-header with-border">
    <div class="box-title">Pages</div>
    <a href="{{url('admindesk/page/create')}}" class="btn btn-success pull-right">+ Add new</a>
  </div>

  <div class="box-body">
    <table id="full_detail_table" class="width100 table table-hover table-responsive">
      <thead>
        <tr class="table-heading-row">
          <th>ID</th>
          <th>Page Name</th>
          <th>Description</th>
          <th>Slug</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1;?>
        @foreach($pages as $page)

        <tr>
          <td>{{$i++}}</td>
          <td>{{$page->name}}</td>
          <td>{{substr(strip_tags($page->des), 0, 70)}}{{strlen(strip_tags(
                $page->des))>70 ? '...' : ""}}</td>
          <td>{{$page->slug}}</td>
          <td>
            <form action="{{ route('page.quick.update',$page->id) }}" method="POST">
              {{csrf_field()}}
              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled title="This action is disabled ion demo !"
                @endif class="btn btn-xs {{ $page->status==1 ? "btn-success" : "btn-danger" }}">
                {{ $page->status ==1 ? 'Active' : 'Deactive' }}
              </button>
            </form>
          <td>

            <div class="row">

              <a href=" {{url('admindesk/page/'.$page->id.'/edit')}} " class="btn btn-sm btn-info">
                <i class="fa fa-pencil"></i>
              </a>


              <button @if(env('DEMO_LOCK')==0) data-toggle="modal" data-target="#{{$page->id}}page" @else disabled
                title="This action is disabled ion demo !" @endif class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
              </button>

            </div>


          </td>


        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
  <!-- /.box-body -->
</div>

@foreach($pages as $page)
<div id="{{ $page->id }}page" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete this page? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{url('admindesk/page/'.$page->id)}}" class="pull-right">
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