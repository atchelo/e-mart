@extends("admindesk/layouts.master")
@section('title',"Slider |")
@section("body")
  <div class="box">
    <div class="box-header with-border">
        <div class="box-title">
          Sliders


        </div>

        <a href=" {{url('admindesk/slider/create')}} " class="pull-right btn btn-success">+ Create</a>
    </div>

    <div class="box-body">
       <table id="full_detail_table" class="width100 table table-bordered table-striped">
                       <thead>
                        <tr class="table-heading-row">
                          
                          <th>ID</th>
                          <th>Slider Content</th>
                          <th>Status</th>
                          <th>Action</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1;?>
                        @foreach($sliders as $key=> $slider)
                        <tr>
                        <td>{{$i++}}</td>
                        <td>
                          <div class="row">
                            <div class="col-md-4">
                              <img src=" {{url('images/slider/'.$slider->image)}}" class="width200px height120">
                            </div>
                            <div class="col-md-6">
                              <p><b>Linked To:</b> 
                              @if($slider->link_by =='cat')
                                (Category : <b>{{ $slider->category['title'] ?? 'None' }}</b>)
                              @elseif($slider->link_by == 'sub') 
                                (Subcategory: <b>{{ $slider->subcategory['title'] ?? 'None' }}</b>)
                              @elseif($slider->link_by == 'child')
                               ( Child Category: <b>{{ $slider->child['title'] ?? 'None' }}</b>)
                              @elseif($slider->link_by == 'pro')
                                (Product: <b>{{ $slider->products['name'] ?? 'None' }}</b>)
                              @elseif($slider->link_by == 'url')
                                (URL: <b>{{ $slider->url }}</b>)
                              @elseif($slider->link_by == 'none') 
                                <b>None</b>
                              @endif
                             </p>
                              @if(isset($slider->topheading))
                                <p><b>Heading Text:</b> {{ $slider->topheading }}</p>
                              @endif
                              @if(isset($slider->heading))
                                 <p><b>Subheading Text:</b> {{ $slider->heading }}</p>
                              @endif
                              @if(isset($slider->buttonname))
                                <p><b>Button Text:</b> {{ $slider->buttonname }}</p>
                              @endif
                            </div>
                          </div>
                        </td>
                        <td>
                          <form action="{{ route('slider.quick.update',$slider->id) }}" method="POST">
                              {{csrf_field()}}
                              <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This cannot be done in demo !" disabled="" @endif class="btn btn-xs {{ $slider->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $slider->status ==1 ? 'Active' : 'Deactive' }}
                              </button>
                          </form>
                        <td>

                          <div class="row">
                            <div class="col-md-2">
                              <a href="{{url('admindesk/slider/'.$slider->id.'/edit')}} " class="btn btn-info btn-sm">
                                <i class="fa fa-pencil"></i>
                               </a>
                            </div>
                            <div  class="col-md-2 marginleft-5">
                              <button @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#{{$slider->id}}slider" @else disabled="" title="This action cannot be done in demo !" @endif class="btn btn-sm btn-danger">
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
  </div>
@foreach($sliders as $key=> $slider)
   <div id="{{$slider->id}}slider" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this slider? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admindesk/slider/'.$slider->id)}}" class="pull-right">
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