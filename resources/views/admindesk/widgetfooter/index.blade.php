@extends("admindesk/layouts.master")
@section('title','Widgtes footer | ')
@section("body")

  <div class="col-xs-12">
    <div class="box" >
      <div class="box-header">
        <div class="box-title">
          Widget Footer
        </div>
      </div>
      <!-- /.box-header -->
        <div class="panel-heading">
      <a href=" {{url('admindesk/widget_footer/create')}} " class="btn btn-success owtbtn">+ Add Widget Footer</a>
    </div>  
      <div class="box-body">
        <table id="example1" class="width100 table table-bordered table-striped">
         <thead>
            <tr>
              <th>Id</th>
              <th>Widget Name</th>
              <th>Widget Psition</th>
              <th>Menu Name</th>
              <th>Url</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1;
          ?>
           @foreach($socials as $social)

            <tr>
              <td>{{$i++}}</td>
              <td>{{$social->widget_name}}</td>
              <td>{{$social->widget_position}}</td>
              <td>{{$social->menu_name}}</td>
              <td>{{$social->url}}</td>
              <td>
                @if($social->status=='1')
                {{'Yes'}}
                @else
                {{'No'}}
                @endif
              </td>
              <td>
                <a href="{{url('admindesk/widget_footer/'.$social->id.'/edit')}}"class="btn btn-info"> Edit</a>
                    <form method="post" action="{{url('admindesk/widget_footer/'.$social->id)}}" class="pull-right">
                          {{csrf_field()}}
                          {{method_field("DELETE")}}
                          <button @if(env('DEMO_LOCK') == 1) type="submit" @else title="This action is disabled in demo !" disabled="disabled" @endif class="btn btn-danger abc">Delete</button>
                    </form>
                        
              </td>
            </tr>
            @endforeach
      
          </tbody>
        </table>
    
      </div>
      <!-- /.box-body -->
    </div>
  </div>

@endsection
