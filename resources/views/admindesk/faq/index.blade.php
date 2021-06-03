@extends("admindesk/layouts.master")
@section('title',"All FAQ's")
@section("body")
  <div class="box" >
    <div class="box-header with-border">
      <div class="box-title">
        All FAQ's
      </div>

      <a href=" {{url('admindesk/faq/create')}} " class="btn btn-success pull-right">+ Add New Faq</a>
    </div>

    <div class="box-body">
       <table id="full_detail_table" class="width100 table table-bordered table-striped">
                      <thead>
                        <tr class="table-heading-row">
                          <th>ID</th>
                          <th>Question</th>
                          <th>Answer</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1;?>
                        @foreach($faqs as $faq)
                        
                        <tr>
                        <td>{{$i++}}</td>
                        <td>{{$faq->que}}</td>
                        <td>{{substr(strip_tags($faq->ans), 0, 250)}}{{strlen(strip_tags(
                $faq->ans))>250 ? '...' : ""}}</td>
                         <td>
                          <form action="{{ route('faq.quick.update',$faq->id) }}" method="POST">
                              {{csrf_field()}}
                              <button type="submit" class="btn btn-xs {{ $faq->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $faq->status ==1 ? 'Active' : 'Deactive' }}
                              </button>
                          </form>
                        <td>
                         
                           
                              <a href=" {{url('admindesk/faq/'.$faq->id.'/edit')}} " class="btn btn-sm btn-info">
                                <i class="fa fa-pencil"></i>
                              </a>
                            
                            
                              <a @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{$faq->id}}faq" @else title="This operation is disabled in demo !" disabled @endif class="btn btn-sm btn-danger ">
                                <i class="fa fa-trash"></i>
                              </a>
                            
                         
                          
                            
                            
                        </td>
                       
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
    </div>
  </div>
 @foreach($faqs as $faq)
   <div id="{{ $faq->id }}faq" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this faq? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admindesk/faq/'.$faq->id)}}" class="pull-right">
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