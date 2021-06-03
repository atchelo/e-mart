@extends("admindesk/layouts.master")
@section('title','Commission List Per Category | ')
@section("body")
  
            <div class="col-xs-12">
              <div class="box" >
                <div class="box-header">
                  <h3 class="box-title">Commission List</h3>
                        
                      <div class="box-body">
                        
                        <div class="callout callout-success">
                          <i class="fa fa-info-circle"></i> Note:
                          <p>If you enable commission by per category than in side menu you can see a new commission menu where you can create commission for each category and define rates too.</p>
                        </div>

                        <table id="full_detail_table" class="width100 table table-hover table-responsive">
                      <thead>
                        <tr class="table-heading-row">
                          <th>ID</th>
                          <th>Rate</th>
                          <th>Type</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($commission_settings as $key=> $commission)
                        
                        <tr>
                        <td>{{ $key+1 }}</td>
                        <td>@if($commission->type != 'c') {{$commission->rate}} {{ $commission->p_type == 'f' ? "Fix Amount" : "%" }} @else Linked to category (check rate under commision menu for each category)@endif </td>
                        <td> 
                          @if($commission->type == 'c')
      								      {{'Category'}}
  							           @elseif($commission->type == 'flat')
                            {{'Flat For All'}}
      						        @endif
          							</td>
                       <td>

                       
                         
                             <a title="Edit Commission setting" href=" {{url('admindesk/commission_setting/'.$commission->id.'/edit')}} " class="btn btn-sm btn-info">
                                <i class="fa fa-pencil"></i>
                              </a>
                         
                           
                          
                         
                          
                            
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


        <!-- /page content -->
@endsection
