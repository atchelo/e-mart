@extends("admindesk/layouts.master")
@section('title','All Units |')
@section("body")
 
      <div class="box">

        <div class="box-header with-border">
          <div class="box-title">Add Unit Type & Values</div>
            <a data-target="#addunit" data-toggle="modal" class="pull-right btn btn-success owtbtn">+ Add Unit</a> 
        </div>

       

        <div class="box-body">
          <table class="table table-responsive">
            <thead>
              <tr>
                <th>#</th>
                <th>Unit Type</th>
                <th>Manage Values</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
             
                @foreach(App\Unit::all() as $key=> $unit)
                 <tr>
                <td>{{$key+1}}</td>
                <td>{{ $unit->title }}</td>
                <td width="60%">
                  
                  <p>
                    @isset($unit->unitvalues)
                      @foreach($unit->unitvalues as $uv)
                        <b>{{ $uv->unit_values }}</b>: {{ $uv->short_code }},
                      @endforeach
                    @endisset
                  </p>
                  @if($unit->title != 'Color' && $unit->title != 'Colour' && $unit->title != 'colour' && $unit->title != 'color')
                    <a href="{{ route('unit.values',$unit->id) }}">Manage Values</a>
                  @endif
                </td>

                <td>
                  <a data-target="#edit{{ $unit->id }}" data-toggle="modal" class="btn btn-sm btn-primary">
                    <i class="fa fa-pencil"></i>
                  </a>

                </td>
                
                

                </tr>
                @endforeach
              
            </tbody>
          </table>
        </div>

      </div>

      @foreach(App\Unit::all() as $key=> $unit)
  <!-- Modal -->
            <div class="modal fade" id="edit{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit {{ $unit->title }}</h4>
                  </div>
                  <div class="modal-body">
                       <div class="row">
                         <div class="col-md-offset-1 col-md-10">
                           <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/unit/'.$unit->id)}}" >
                        {{csrf_field()}}
                          {{ method_field('PUT') }}
                        
                          <div class="form-group">
                            <label for="">Edit Title:</label>
                            <input type="text" name="title" class="form-control" value="{{ $unit->title }}">
                          </div>

                          <input type="submit" value="Update" class="btn btn-md btn-primary">

                        </form>  
                         </div>
                       </div>
                  </div>
                 
                </div>
              </div>
            </div>
        @endforeach
    

    <!-- Modal -->
      <div class="modal fade" id="addunit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Add Unit</h4>
            </div>

            <div class="modal-body">

                <form method="post" enctype="multipart/form-data" action="{{url('admindesk/unit')}}">
                  {{csrf_field()}}

                <div class="form-group">
                  
                  <label>
                    Title: <span class="required">*</span>
                  </label>
                  
                  <input type="text" name="title" class="form-control">
                </div>

                  <div class="form-group">
                  <label for="first-name">
                    Status:
                  </label>
                  <br>
                  <label class="switch">
                    <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="status">
                    <span class="knob"></span>
                  </label>
                </div>
            
                <button type="submit" class="btn btn-md btn-primary">
                    <i class="fa fa-plus"></i> ADD
                </button>
                
        
              </form>

            </div>
            
          </div>
        </div>
      </div>
@endsection
