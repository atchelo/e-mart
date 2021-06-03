@extends("admindesk/layouts.master")
@section('title','All Reviews and Ratings | ')
@section("body")

    <div class="box" >
      <div class="box-header">
        <h3 class="box-title">
    Reviews
    </h3>
      </div>
      <!-- /.box-header -->
        <div class="panel-heading">
      
    </div>  
      <div class="box-body">
        <table id="full_detail_table" class="width100 table table-bordered table-striped">
         <thead>
            <tr>
              <th>Id</th>
              <th>Product</th>
              <th>User</th>
              <th>Review</th>
              <th>Quality</th>
              <th>Price</th>
              <th>Value</th>
              <th>Remark</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1;
          $review_t = 0;
          $price_t = 0;
          $value_t = 0;
          $sub_total = 0;
          $count =  count($reviews);
          ?>
           @foreach($reviews as $review)

            <tr>
              <td>{{$i++}}</td>
              <td>{{$review->pro ?  $review->pro->name : 'Deleted Product'}}</td>
              <td>{{$review->users['name']}}</td>
              
              <td>{{$review->review}}</td>
              <td>{{$review->qty}}</td>
              <td>{{$review->price}}</td>
              <td>{{$review->value}}</td>
              <td>
                {{$review->remark}}
                </td>  
              <td> 
                 <form action="{{ route('review.quick.update',$review->id) }}" method="POST">
                              {{csrf_field()}}
                              <button type="submit" class="btn btn-xs {{ $review->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $review->status ==1 ? 'Active' : 'Deactive' }}
                              </button>
                  </form>
              </td>
              <td>

                <div class="row">
                  <div class="col-md-2">
                    <a href="{{url('admindesk/review/'.$review->id.'/edit')}}"class="btn btn-info">
                        <i class="fa fa-pencil"></i>
                    </a>
                  </div>
                  <div class="margin-left-15 col-md-2">
                    <button @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{$review->id}}review" @else disabled="disabled" title="This action is disabled in demo !" @endif class="btn btn-md btn-danger">
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
            
@foreach($reviews as $review)
  
   <div id="{{ $review->id }}review" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this review? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
               <form method="post" action="{{url('admindesk/review/'.$review->id)}}" class="pull-right">
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