@extends("admindesk/layouts.master")
@section('title','All Hotdeals | ')
@section("body")


  <div class="col-xs-12">
    <div class="box" >
      <div class="box-header">
        <h3 class="box-title">Hot Deals</h3>
              <div class="panel-heading">
                  <a href="{{url('admindesk/hotdeal/create')}}" class="btn btn-success owtbtn">+ Add Deals</a>
              </div>       
          </div>
              <div class="box-body">
                  <table id="full_detail_table" class="width100 table table-bordered table-striped">
                    <thead>
                      <tr class="table-heading-row">
                        
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Model</th>
                        <th>Price</th>
                        <th>Offer price</th>
                        <th>Status</th>
						            <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; ?>

                      @foreach($products as $key=> $product)
                       @if(isset($product->pro))
                        <tr>
                          <td>{{ $key+1 }}</td>
                          <td>{{$product->pro->name}}</td>
            						  <td>{{$product->pro->model}}</td>
            							<td>{{$product->pro->vender_price}}</td>
            							<td>{{$product->pro->vender_offer_price}}</td>
                         	<td>
                            <form action="{{ route('hot.quick.update',$product->id) }}" method="POST">
                              {{csrf_field()}}
                              <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-xs {{ $product->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $product->status ==1 ? 'Active' : 'Deactive' }}
                              </button>
                            </form>
                          </td>
            							<td>

                            <div class="row">
                              <div class="col-md-2">
                                 <a href=" {{url('admindesk/hotdeal/'.$product->id.'/edit')}} " class="btn btn-sm btn-info">
                                  <i class="fa fa-pencil"></i>
                                  </a>
                              </div>
                              <div class="margin-left-15 col-md-2">
                                <button @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{$product->id}}deal" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-sm btn-danger">
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
                  </div>

                   @foreach($products as $product)
                   <div id="{{$product->id}}deal" class="delete-modal modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">Are You Sure ?</h4>
                          <p>Do you really want to delete this deal? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                       <form method="post" action="{{url('admindesk/hotdeal/'.$product->id)}}" class="pull-right">
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
