@extends("admindesk/layouts.master")
@section('title','Block Detail Page Advertising | ')
@section("body")


    <div class="box" >
      <div class="box-header with-border">
        <div class="box-title">List Block Detail Page Ads</div>

        <a href=" {{url('admindesk/detailadvertise/create')}} " class="pull-right btn btn-success owtbtn">+ Add New Block Detail Advertise</a>
      </div>

      
      <div class="box-body">
        <table id="full_detail_table" class="width100 table table-bordered table-striped">
         <thead>
            <tr>
              <th>ID</th>
              <th>Preview</th>
              <th>Ad Position</th>
              <th>Details</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
         
           @foreach($details as $key => $detail)

            <tr>
              <td>{{ $key+1 }}</td>
              <td>
                @if($detail->linkby != 'adsense')
                  <img src="{{ url('images/detailads/'.$detail->adimage) }}" alt="" class="width-hight">
                @else
                  <b>Google adsense preview not available !</b>
                @endif
              </td>
              <td>

                @if($detail->position == 'category')
                  <p><b>On Category Page</b></p> 
                @else
                  <p><b>On Product Detail Page</b></p>
                @endif

                 <p><b>Display On:</b>
                  
                  @php
                  
                    
                    $detailpage  = App\Category::where('id',$detail->linked_id)->first();

                    if(!isset($detailpage)){
                      $detailpage = App\Product::where('id',$detail->linked_id)->first();
                    }

                  @endphp
        
                 @if(isset($detailpage))
                    @if(isset($detailpage['name'])) 
                        {{ $detailpage['name'] ?? '-' }} 
                    @else 
                        {{ $detailpage['title'] ?? '-' }} 
                    @endif
                 @endif
                 </p>
              </td>
              <td>
                <p><b>Linked To:</b>
                 @if(isset($detailpage))
                    @if($detail->linkby == 'detail')
                        {{ $detail->product['name'] ?? '-' }}
                    @elseif($detail->linkby == 'category')
                      {{ $detail->category['title'] ?? '-' }}
                    @elseif($detail->linkby == 'url')
                      Custom URL
                    @elseif($detail->linkby == 'adsense')
                      Google Adsense Script
                    @endif</p>
                        @if($detail->top_heading !='')
                            <p><b>Heading Text:</b> {{ $detail->top_heading }}</p>
                        @endif
    
                        @if($detail->btn_text != '')
                          <p><b>Button text:</b> {{ $detail->btn_text }}</p>
                        @endif
                    @endif
              </td>
              <td>
                <form action="{{ route('detail_button.quick.update',$detail->id) }}" method="POST">
                    {{csrf_field()}}
                    <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" title="This operation is disabled in demo !" @endif class="btn btn-xs {{ $detail->status==1 ? "btn-success" : "btn-danger" }}">
                      {{ $detail->status ==1 ? 'Active' : 'Deactive' }}
                    </button>
                </form> 
              </td>
              
              <td>
                  <a href="{{route('detailadvertise.edit',$detail->id)}}"class="btn btn-sm btn-info"> 
                      <i class="fa fa-pencil"></i>
                     </a>
                   <a data-toggle="modal" data-target="#{{$detail->id}}deleteAds" class="btn btn-sm btn-danger">
                      <i class="fa fa-trash"></i>
                  </a>           
              </td>

            </tr>
            @endforeach
			</tbody>
                      </table>
                  
                    </div>
                    <!-- /.box-body -->
                  </div>
                
 @foreach($details as $detail)
         <div id="{{ $detail->id }}deleteAds" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this brand? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{route('detailadvertise.destroy',$detail->id)}}" class="pull-right">
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