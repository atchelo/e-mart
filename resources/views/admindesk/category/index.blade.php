@extends("admindesk/layouts.master")
@section('title','All Categories |')
@section("body")
  
    <div class="box" >
      <div class="box-header with-border">
        
        <div class="box-title">Category</div>

        <a href=" {{url('admindesk/category/create')}} " class="btn btn-success pull-right">+ Add New Category</a>
        <br><br>
        <div class="callout callout-success">
          <p><i class="fa fa-info-circle"></i> Drag and Drop to sort the categories</p>
        </div>
      
           
         
        </div>
        
      <div class="box-body">
        <table id="full_detail_table" class="cattable width100 table table-bordered table-striped">
          <thead>
            <tr class="table-heading-row">
              <th>ID</th>
              <th>Detail</th>
              <th>Icon</th>
              <th>Status</th>
              <th>Featured</th>
              <th>Added/ Updated on</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1;  ?>
            @foreach($category as $cat)
            <tr class="row1" data-id="{{$cat->id}}">
            <td>{{$i++}}</td>
            
            <td>
              @if($cat->image != '' && file_exists(public_path().'/images/category/'.$cat->image) )

              <img class="margin-right-15 width-hight" align="left" src="{{url('images/category/'.$cat->image)}}" title="{{ $cat->title }}">

              @else
               <img class="margin-right-15" align="left" title="{{ $cat->title }}" src="{{ Avatar::create($cat->title)->toBase64() }}" />

              @endif
              <p><b>Name: </b><span class="font-weight500">{{$cat->title}}</span></p>
              <p><b>Description: </b><span class="font-weight500">{{substr(strip_tags($cat->description), 0, 100)}}{{strlen(strip_tags(
               $cat->description))>100 ? '...' : ""}}</span></p>
            </td>

            <td>
              <p class="font-size-18"><i class="fa {{$cat->icon}}"></i></p>
            </td>
            
            <td> 
              <form method="POST" action="{{ route('cat.quick.update',$cat->id) }}">
                {{ csrf_field() }}
                <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This operation is disabled in demo !" disabled="" @endif class="btn btn-xs {{ $cat->status ==1 ? 'btn-success' : 'btn-danger' }}">
                  {{ $cat->status==1 ? 'Active' : 'Deactive' }}
                </button>
              </form>
            </td>
            <td> 
              <form method="POST" action="{{ route('cat.featured.quick.update',$cat->id) }}">
                {{ csrf_field() }}
                <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This operation is disabled in demo !" disabled="" @endif class="btn btn-xs {{ $cat->featured ==1 ? 'btn-success' : 'btn-danger' }}">
                  {{ $cat->featured==1 ? 'Yes' : 'No' }}
                </button>
              </form>
            </td>
           <td>
                            <p> <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> 
                              <span class="font-weight500">{{ date('M jS Y',strtotime($cat->created_at)) }}</span></p>
                            <p ><i class="fa fa-clock-o" aria-hidden="true"></i> 
                              <span class="font-weight500">{{ date('h:i A',strtotime($cat->created_at)) }}</span></p>
                            
                            <p class="greydashedborder"></p>
                            
                            <p>
                               <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 
                               <span class="font-weight500">{{ date('M jS Y',strtotime($cat->updated_at)) }}</span>
                            </p>
                           
                            <p><i class="fa fa-clock-o" aria-hidden="true"></i> 
                              <span class="font-weight500">{{ date('h:i A',strtotime($cat->updated_at)) }}</span></p>
                            
                          </td>
            <td>

              


                            <ul class="nav table-nav">
                              <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                  Action <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{url('admindesk/category/'.$cat->id.'/edit')}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Category</a></li>
                                    
                                    
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation">
                                      <a @if(env('DEMO_LOCK') == 0) data-toggle="modal" href="#{{ $cat->id }}deletecat" @else disabled title="This operation is disabled in demo !" @endif>
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>Delete
                                      </a>
                                    </li>
                                </ul>
                              </li>
                            </ul>
              
                
            </td>

     

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  
   @foreach($category as $cat)
    <div id="{{ $cat->id }}deletecat" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this category? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
             <form method="post" action="{{url('admindesk/category/'.$cat->id)}}" class="pull-right">
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
@section('custom-script')
  <script>
    var url = {!! json_encode(url('reposition/category')) !!};
  </script>
  <script src="{{ url('js/category.js') }}"></script>
@endsection


