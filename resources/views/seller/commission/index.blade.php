@extends("admindesk/layouts.sellermaster")
@section('title','Commission Setting | ')
@section("body")
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Commission Setting (Applied by admin)</h3>
          </div>
              <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Rate</th>
                    <th>Amount Type</th>
                    <th>Commision Type</th>

                  </tr>
                </thead>
                <tbody>
                  <?php $i=1;?>
                  @foreach($commissions as $commission)
                  @if($commission->type=='flat')
                  <tr>
                  <td>{{$i++}}</td>
                  <td>{{$commission->category->title ?? 'All'}}</td>
                  
                   <td>{{$commission->rate ?? ''}}</td>
                  <td> 
                    @if($commission->p_type == 'p')
								      {{'Percentage'}}
					         @else($commission->p_type == 'f')
                      {{'Fix Amount'}}
                   
						        @endif
    							</td>
                  <td>
                    @if($commission->type == 'c')
                          {{'Category'}}
                      @else
                          {{'Flat For All'}}
                    @endif
                  </td>
                  
                  </tr>
                  @else
                  @foreach(App\Commission::get() as $commission)
                  
                  <tr>
                  <td>{{$i++}}</td>
                  <td>{{$commission->category->title ?? ''}}</td>
                  
                  <td>{{$commission->rate ?? ''}}</td>
                  <td> 
                    @if($commission->type == 'p')
                      {{'Percentage'}}
                   @else
                      {{'Fix Amount'}}
                    
                    @endif
                  </td>
                  <td>
                    @if($commission->type == 'flat')
                         {{'Flat For All'}}
                      @else
                          {{'Category'}}
                    @endif
                  </td>
                  
                  </tr>
                  
                  @endforeach
                  @endif
                  @endforeach
                  
                  </tbody>
                </table>
            
              </div>
              <!-- /.box-body -->
            </div>
         
@endsection
