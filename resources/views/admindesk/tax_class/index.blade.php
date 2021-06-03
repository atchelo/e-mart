@extends("admindesk/layouts.master")
@section('title','All Tax Classes | ')
@section("body")

              <div class="box box-primary" >
                <div class="box-header with-border">
                  <h3 class="box-title">Tax Classes</h3>
                    <div class="panel-heading">
                          <a href=" {{url('admindesk/tax_class/create')}} " class="btn btn-success owtbtn">+ Add Tax Class</a>
                        </div>       
                      <div class="box-body">
                        <table id="full_detail_table" class="width100 table table-hover table-responsive">
                      <thead>
                        <tr class="table-heading-row">
                          <th>ID</th>
                          <th>Tax Title</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1;?>
                        @foreach($taxs as $tax)
                        
                        <tr>
                        <td>{{$i++}}</td>
                        <td>{{$tax->title}}</td>
                        <td>{{$tax->des}}</td>
                        
                       
                           <td>
                            <div class="row">
                              <div class="col-md-2">
                                 <a href=" {{url('admindesk/tax_class/'.$tax->id.'/edit')}} " class="btn btn-sm btn-info">
                                  <i class="fa fa-pencil"></i>
                                  </a>
                              </div>
                              <div class="col-md-2">
                                <button data-toggle="modal" data-target="#{{$tax->id}}tax" class="btn btn-sm btn-danger">
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


         
        
@foreach($taxs as $tax)
        <div id="{{ $tax->id }}tax" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this tax? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{url('admindesk/tax_class/'.$tax->id)}}" class="pull-right">
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
