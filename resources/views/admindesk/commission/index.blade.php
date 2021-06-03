@extends("admindesk/layouts.master")
@section('title','Commission List')
@section("body")

            <div class="col-xs-12">
              <div class="box" >
                <div class="box-header">
                  <div class="box-title">Commission List</div>
                   
                          <a href=" {{url('admindesk/commission/create')}} " class="btn btn-success pull-right">+ Add New Commission</a>
                      </div>      
                      <div class="box-body">
                        <table id="full_detail_table" class="width100 table table-hover table-responsive">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Category</th>
                          <th>Rate</th>
                          <th>Type</th>
                          <th>Status</th>
                           <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1;?>
                        @foreach($commissions as $commission)
                        
                        <tr>
                        <td>{{$i++}}</td>
                        <td>{{$commission->category['title']}}</td>
                        
                         <td>{{$commission->rate}}</td>
                        <td> 
                          @if($commission->type == 'p')
      								      {{'Percentage'}}
  							         @else($commission->type == 'f')
                            {{'Fix Amount'}}
      						        @endif
          							</td>
                        <td>
                          <form action="{{ route('commission.quick.update',$commission->id) }}" method="POST">
                              {{csrf_field()}}
                              <button type="submit" class="btn btn-xs {{ $commission->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $commission->status ==1 ? 'Active' : 'Deactive' }}
                              </button>
                          </form>
                           </td>
                           <td>
                            <div class="row">
                              <div class="col-md-2">
                                <a href=" {{url('admindesk/commission/'.$commission->id.'/edit')}} " class="btn btn-sm btn-info">
                                  <i class="fa fa-pencil"></i>
                                </a>
                              </div>
                              <div class="col-md-2">
                                <button @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{ $commission->id }}cm" @else disabled="" title="This operation is disabled in demo !" @endif class="btn btn-sm btn-danger">
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


         
        </div>

        @foreach($commissions as $commission)
             <div id="{{ $commission->id }}cm" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this commission? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            
                            <form method="post" action="{{url('admindesk/commission/'.$commission->id)}}" class="pull-right">
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
