@extends("admindesk/layouts.master")
@section('title','Footer Social Icon Setting')
@section("body")

  
    <div class="box" >
      <div class="box-header">
        <h3 class="box-title">
   Footer Social Icon Setting
    </h3>
      </div>
      <!-- /.box-header -->
        <div class="panel-heading">
      <a title="Click to add new social icon for footer" href=" {{url('admindesk/social/create')}} " class="btn btn-success owtbtn">+ Add new social icon</a>
    </div>  
      <div class="box-body">
        <table id="full_detail_table" class="table table-bordered table-striped width100">
         <thead>
            <tr class="table-heading-row">
              <th>ID</th>
              <th>Url</th>
              <th>Icon</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1;
          ?>
           @foreach($socials as $social)

            <tr>
              <td>{{$i++}}</td>
              <td>{{$social->url}}</td>
              <td>

           {{ ucfirst($social->icon) }}
          
         </td> 
        
     
              </td>
              <td>
               <form action="{{ route('social.quick.update',$social->id) }}" method="POST">
                              {{csrf_field()}}
                              <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This action cannot be done in demo !" @endif class="btn btn-xs {{ $social->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $social->status ==1 ? 'Active' : 'Deactive' }}
                              </button>
                </form>
              </td>
              <td>
                
                 
                <a href="{{url('admindesk/social/'.$social->id.'/edit')}}"class="btn btn-sm btn-info"> <i class="fa fa-pencil"></i>
                </a>
                  
                 <a @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{$social->id}}scl" @else dis
                  title="This action is disabled in demo !" @endif class="btn btn-sm btn-danger">
                    <i class="fa fa-trash"></i>
                 </a>
                
                    
                        
              </td>

               <div id="{{ $social->id }}scl" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this Icon? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{url('admindesk/social/'.$social->id)}}" class="pull-right">
                          {{csrf_field()}}
                          {{method_field("DELETE")}}
                         
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
            </tr>
            @endforeach
      
          </tbody>
        </table>
    
      </div>
      <!-- /.box-body -->
    </div>
  

@endsection