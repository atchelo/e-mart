@extends("admindesk/layouts.master")
@section('title','All '. ucfirst(app('request')->input('filter')) .' | ')
@section("body")

  @component('components.box')
      @slot('header')
        <div class="box-title">
            {{ __('All ' .ucfirst(app('request')->input('filter'))) }}
            @if(app('request')->input('q'))
            <br>
            <a href="{{ route('users.index',['filter' => app('request')->input('filter')]) }}" class="btn btn-sm btn-danger">
              <i class="fa fa-times"></i> {{__("Clear Search")}}
            </a>
            @endif
        </div>

       
        @slot('rightbar')
          <form action="" method="GET" class="pull-left">
            <input type="hidden" name="filter" value="{{ app('request')->input('filter') ?? '' }}">
            <input value="{{ app('request')->input('q') ?? '' }}" name="q" type="text" class="form-control" placeholder="Search {{ app('request')->input('filter') }}">
          </form>
            &nbsp;&nbsp;
          <a href="{{ route('users.create',['type' => app('request')->input('filter')]) }}" class="pull-right btn btn-md btn-success">
            <i class="fa fa-plus-circle"></i> Add New
          </a>
        @endslot
       
      @endslot

      @slot('boxBody')
        <div class="row">
          @if(count($users)>0)
          @foreach($users as $user)

         
          <div class="col-md-4">
            <div  class="box box-solid box-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class=" text-dark widget-user-header">
                <h3 class="widget-user-username"> {{ $user->name }} 
                 
                </h3>
                <h6 class="widget-user-desc">{{ $user->email }}</h6>
                  
              </div>
              <div class="widget-user-image">
                @if($user->image !='' && file_exists(public_path().'/images/user/'.$user->image))
                  <img class="img-circle" src="{{ url('images/user/'.$user->image) }}" alt="User Avatar">
                @else
                  <img class="img-circle" src="{{ Avatar::create($user->name)->toBase64() }}" alt="User Avatar">
                @endif
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                    <h5 class="description-header">{{ $user->purchaseorder()->count() }}</h5>
                    <small class="description-text">{{ __("Total Purchase") }}</small>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                    <h5 class="description-header">{{ date('Y-m-d',strtotime($user->created_at)) }}</h5>
                      <small class="description-text">Member Since</small>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">{{ $user->mobile ?? "Not Updated" }}</h5>
                      <small class="description-text">
                        <i class="fa fa-phone"></i>
                      </small>
                    </div>
                    <!-- /.description-block -->
                  </div>

                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                    <form action="{{ route('login.as',Crypt::encrypt($user->id)) }}" method="POST">
                        @csrf
                        <button title="{{ __("Login as $user->name") }}" type="submit" class="btn btn-sm btn-info">
                            <i class="fa fa-key"></i>
                        </button>
                      </form>
                    </div>
                    <!-- /.description-block -->
                  </div>

                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <small class="description-text">
                      <form action="{{ route('user.quick.update',$user->id) }}" method="POST">
                          @csrf
                      <button title="{{ $user->status == 1 ? "Active" : "Deactive" }}" type="submit" class="btn btn-sm {{ $user->status == '1' ? "btn-success" : "btn-danger"  }}">
                              @if($user->status == 1)
                                <i class="fa fa-check-circle-o"></i>
                              @else
                              <i class="fa fa-ban"></i>
                              @endif
                          </button>
                        </form>
                      </small>
                    </div>
                    <!-- /.description-block -->
                  </div>

                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <small class="description-text">
                        <a title="Edit Profile" href="{{ route('users.edit',[$user->id,'name' => $user->name]) }}" class="btn btn-sm bg-teal">
                          <i class="fa fa-pencil"></i>
                        </a>
                      </small>
                    </div>
                    <!-- /.description-block -->
                  </div>

                </div>
                <!-- /.row -->
              </div>

              <div class="box-footer">
                <a data-toggle="modal" data-target="#{{ $user->id }}deleteuser" class="btn btn-block btn-danger">
                   <i class="fa fa-trash"></i>
                </a>
              </div>
            </div>
          </div>

          <div id="{{ $user->id }}deleteuser" class="delete-modal modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="delete-icon"></div>
                </div>
                <div class="modal-body text-center">
                  <h4 class="modal-heading">Are You Sure ?</h4>
                <p>Do you really want to delete user {{ $user->name }}? This process cannot be undone.</p>
                </div>
                <div class="modal-footer">
                  <form method="post" action="{{url('admindesk/users/'.$user->id)}}" class="pull-right">
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
          @else
            <div class="text-center col-md-12">
              <h2 class="text-primary">
                No Users found {{ app('request')->input('q') ? 'with name '.app('request')->input('q') : '' }}
              </h2>
            </div>
          @endif
        </div>
      @endslot

      @slot('boxfooter')
        <div class="text-center">
          {!! $users->appends(Request::except('page'))->links() !!}
        </div>
      @endslot
  @endcomponent

@endsection