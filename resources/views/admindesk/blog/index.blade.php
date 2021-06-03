@extends("admindesk/layouts.master")
@section('title','All Blog Post')
@section("body")


      
          <div class="box" >
            <div class="box-header">
              <h3 class="box-title">
                  All blog posts
              </h3>

              <a href=" {{url('admindesk/blog/create')}} " class="btn btn-success pull-right">+ Add new</a>
            </div>
        <!-- /.box-header -->
                
            <div class="box-body">

              <table id="full_detail_table" class="width100 table table-hover table-responsive">
                      <thead>
                        <tr class="table-heading-row">
                          <th>ID</th>
                          <th>Heading</th>
                          <th>Description</th>
                          <th>User</th>
                          <th>Image</th>
                          <th>Created at</th>
                          <th>Status</th>
						              <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1;?>
                        @foreach($blogs as $key=> $slider)
                        <tr>
                        <td>{{$i++}}</td>
                        <td>{{$slider->heading}}</td>
                        <td>{{substr(strip_tags($slider->des), 0, 50)}}{{strlen(strip_tags(
                $slider->des))>50 ? '...' : ""}}</td>
                        <td>{{$slider->user}}</td>
                         <td> <img width="80px" height="50px" src="{{url('images/blog/'.$slider->image)}}"></td>
                      
                      <td>{{$slider->created_at}}</td>
                      <td>
                        <form action="{{ route('blog.quick.update',$slider->id) }}" method="POST">
                              {{csrf_field()}}
                              <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-xs {{ $slider->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $slider->status ==1 ? 'Active' : 'Deactive' }}
                              </button>
                          </form>
                      </td>
                        <td>

                          
                               <a href=" {{url('admindesk/blog/'.$slider->id.'/edit')}} " class="btn btn-sm btn-info"><i class="fa fa-pencil"></i>
                              </a>
                           
                              <a @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{$slider->id}}blog" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                              </a>
                          
                         
                            
                        
                        </td>
    
                        </tr>
                        @endforeach
                       
                      </tbody>
                    </table>
                   </table>
                  </div>
                </div>
              </div>



 @foreach($blogs as $key=> $slider)
    <div id="{{ $slider->id }}blog" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this blog? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{url('admindesk/blog/'.$slider->id)}}" class="pull-right">
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