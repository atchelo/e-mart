@extends("admindesk/layouts.master")
@section('title','All Special Offers')
@section("body")

    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Special</h3>
              <div class="panel-heading">
                  <a href="{{url('admindesk/special/create')}}" class="btn btn-success owtbtn">+ Add Special Offer</a>
              </div>       
          </div>
              <div class="box-body">
                  <table id="example1" class="width100 table table-bordered table-striped">
                    <thead>
                      <tr class="header">
                       
                        <th>Id</th>
                        <th>Product Name</th>
                        <th>Status</th>
						            <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; ?>

                      @foreach($products as $product)
                       @if(isset($product->pro))
                        <tr>
                          <td>{{$i++}}</td>
                          <td>{{$product->pro->name}}</td>
            						  <td>
                            <form action="{{ route('spo.status.quick.update',$product->id) }}" method="Post">
                              {{csrf_field()}}
                              <button type="submit" class="btn btn-xs {{ $product->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $product->status ==1 ? "Active" : "Deactive" }}
                              </button>
                            </form>
                          </td>
            							<td>

                            <div class="row">
                              <div class="col-md-2">
                                <a href=" {{url('admindesk/special/'.$product->id.'/edit')}} " class="btn btn-info">
                                  <i class="fa fa-pencil"></i>
                                </a>
                              </div>
                              <div class="col-md-2">
                                <button @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{$product->id}}spo" @else disabled="" title="This action is disabled in demo" @endif class="btn btn-md btn-danger">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </div>
                            </div>
                           
                          
                            
                          </td>

                        
                        </tr>
                        @endif
                        @endforeach
                        
                        </table>
                          </tbody>
                      </div>
                      <!-- /.box-body -->
                    </div>
 

  @foreach($products as $product)
    <div id="{{ $product->id }}spo" class="delete-modal modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="delete-icon"></div>
              </div>
              <div class="modal-body text-center">
                <h4 class="modal-heading">Are You Sure ?</h4>
                <p>Do you really want to delete this? This process cannot be undone.</p>
              </div>
              <div class="modal-footer">
                  <form method="post" action="{{url('admindesk/special/'.$product->id)}}" class="pull-right">
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


