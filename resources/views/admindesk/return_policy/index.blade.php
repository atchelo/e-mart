@extends("admindesk/layouts.master")
@section('title','Return Policy Settings | ')
@section("body")

  
    <div class="box" >
      <div class="box-header">
        <h3 class="box-title">Return Policy</h3>
      </div>
      <!-- /.box-header -->
        <div class="panel-heading">
          <a href=" {{url('admindesk/return-policy/create')}} " class="btn btn-success owtbtn">+ Add Return Policy</a>
      </div>  
      <div class="box-body">
        <table id="full_detail_table" class="width100 table table-hover table-responsive">
         <thead>
            <tr class="table-heading-row">
              <th>Id</th>
              <th>Policy Name</th>
              <th>Return Amount</th>
              <th>Return Days </th>
              <th>Description</th>
              <th>Status </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
             <?php $i = 1;  ?>
              @foreach($pro_return as $banks)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$banks->name}}</td>
                  <td>{{$banks->amount}}</td>
                  <td>{{$banks->days}}</td>
                  <td>{{substr(strip_tags($banks->des), 0, 50)}}{{strlen(strip_tags(
                $banks->des))>50 ? '...' : ""}}</td>
                  <td>
                    <form action="{{ route('banks.quick.update',$banks->id) }}" method="POST">
                              {{csrf_field()}}
                              <button type="submit" class="btn btn-xs {{ $banks->status==1 ? "btn-success" : "btn-danger" }}">
                                {{ $banks->status ==1 ? 'Active' : 'Deactive' }}
                              </button>
                    </form>
                  </td>
                <td>
                  <div class="row">
                    <div class="col-md-2">
                      <a href="{{url('admindesk/return_policy/edit/'.$banks->id)}}"class="btn btn-sm btn-info">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </div>
                    <div  class="margin-left-15 col-md-2">
                      <a @if(env('DEMO_LOCK') == 0) href="{{url('admindesk/return_policy/destroy/'.$banks->id)}}"  onclick="return confirm('Are you sure? Want to proceed?')" @else title="This action is disabled in demo !" disabled @endif class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                    </div>
                  </div>
                    
                    <br>
                    
                    </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>

@endsection
