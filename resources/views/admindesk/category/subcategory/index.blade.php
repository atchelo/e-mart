@extends("admindesk/layouts.master")
@section('title','All Subcategories |')
@section("body")
 
    <div class="box" >
      <div class="box-header with-border">
        <div class="box-title">
          Subcategory
        </div>

         <a href=" {{url('admindesk/subcategory/create')}} " class="pull-right btn btn-success">+ Add New Subcategory</a>
          <br><br>
          <div class="callout callout-success">
            <p><i class="fa fa-info-circle"></i> Drag and Drop to sort the Subcategories</p>
          </div>
     
         
       
        </div> 
      <div class="box-body">

            <table id="full_detail_table" class="subcattable width100 table table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Subcategory Detail</th>
             
              <th>Icon</th>
              
             
              <th>Status</th>
              <th>Featured</th>
              <th>Added/ Updated On</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="sortable">
             <?php $i=1;?>
             @foreach($subcategory as $key=> $cat)
                <tr class="row1" data-id="{{ $cat->id }}">
                  <td>{{$i++}}</td>
                  <td>
                    @if($cat->image != '' && file_exists(public_path().'images/subcategory/'.$cat->image) )
                      <img src=" {{url('images/subcategory/'.$cat->image)}}" width="100px" height="100px" title="{{ $cat->title }}">
                    @else
                    <img title="{{ $cat->title }}" src="{{ Avatar::create($cat->title)->toBase64() }}" />

                    @endif
                  </td>
                  <td>
                    <p><b>Name:</b> <span class="font-weight500">{{$cat->title}}</span></p>
                    <p class="font-weight500"><b>Description:</b> {{strip_tags($cat->description)}}</p>
                    <p class="font-weight500"><b>Parent Category:</b>  {{$cat->category['title'] ?? ''}}</p>
                   
                  </td>
                 
                  <td>
                    <p class="font-size-18"><i class="fa {{$cat->icon}}"></i></p></td>
               
                  <td>
                    
                  <form method="POST" action="{{ route('sub.quick.update',$cat->id) }}">
                    {{ csrf_field() }}
                    <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This operation is disabled in demo !" disabled="" @endif class="btn btn-xs {{ $cat->status ==1 ? 'btn-success' : 'btn-danger' }}">
                      {{ $cat->status==1 ? 'Active' : 'Deactive' }}
                    </button>
                  </form>
                 </td>
                    
                  
                  <td> 
                    <form method="POST" action="{{ route('sub.featured.quick.update',$cat->id) }}">
                      {{ csrf_field() }}
                      <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="This operation is disabled in demo !" @endif class="btn btn-xs {{ $cat->featured ==1 ? 'btn-success' : 'btn-danger' }}">
                        {{ $cat->featured==1 ? 'Yes' : 'No' }}
                      </button>
                    </form>
                  </td>
                   <td>
                            <p> <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> 

                              <span class="font-weight500">{{ date('M jS Y',strtotime($cat->created_at)) }},</span></p>
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
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{url('admindesk/subcategory/'.$cat->id.'/edit')}} "><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Subcategory</a></li>
                                    
                                    
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation">
                                      <a data-toggle="modal" href="#{{$cat->id}}sub">
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
       </table>
     </div>
   </div>


 

   @foreach($subcategory as $key=> $cat)
     <div id="{{ $cat->id }}sub" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this subcategory? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{url('admindesk/subcategory/'.$cat->id)}}" class="pull-right">
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
    var url = {!! json_encode(url('/reposition/subcategory/')) !!};
  </script>
  <script src="{{ url('js/subcategory.js') }}"></script>
@endsection