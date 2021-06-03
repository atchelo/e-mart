@extends("admindesk/layouts.master")
@section('title',"Site Languages |")
@section("body")
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title">
				Site Languages
			</div>

			<a title="Click to add new language" data-toggle="modal" data-target="#addLang" class="btn btn-primary btn-md pull-right">
				+ Add New Language
			</a>
		</div>

		<div class="box-body">

      <div class="nav-tabs-custom">

        <!-- Nav tabs -->
        <ul id="myTabs" class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Languages</a></li>
          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Update Static Word Translations</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
  
          <div role="tabpanel" class="tab-pane active" id="home">
            <br>
            <table class="table table-bordered">
          <thead>
            <th>
              #
            </th>
            <th>
              Display Name
            </th>
            <th>
              Language Code
            </th>
            <th>
              Default
            </th>
            <th>
              Action
            </th>
          </thead>
          <tbody>
            @foreach($allLang as $key=> $lang)
              <tr>
                <td>
                  {{ $key+1 }}
                </td>
                <td>
                  {{ $lang->name }}
                </td>
                <td>
                  {{ ucfirst($lang->lang_code) }}
                </td>
                <td>
                  @if($lang->def == 1)
                    <i class="text-green fa fa-check-circle"></i>
                  @else
                    <i class="text-red fa fa-times"></i>
                  @endif
                </td>
                <td>
                  <a data-toggle="modal" data-target="#editLang{{ $lang->id }}" title="Edit Language" class="btn btn-sm btn-flat btn-primary">
                      <i class="fa fa-pencil"></i>
                  </a>

                  <a @if(env('DEMO_LOCK') == 0) data-target="#delModal{{ $lang->id }}" title="Delete Language" data-toggle="modal" @else disabled title="This action is disabled in demo !" @endif class="btn btn-sm btn-flat btn-danger">
                    <i class="fa fa-trash"></i>
                  </a>

                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
          </div>
          <div role="tabpanel" class="tab-pane" id="profile">
            <br>
            <table class="table table-bordered">
          <thead>
            <th>
              #
            </th>
            <th>
              Display Name
            </th>
            <th>
              Language Code
            </th>
            <th>
              Default
            </th>
            <th>
              Action
            </th>
          </thead>
          <tbody>
            @foreach($allLang as $key=> $lang)
              <tr>
                <td>
                  {{ $key+1 }}
                </td>
                <td>
                  {{ $lang->name }}
                </td>
                <td>
                  {{ ucfirst($lang->lang_code) }}
                </td>
                <td>
                  @if($lang->def == 1)
                    <i class="text-green fa fa-check-circle"></i>
                  @else
                    <i class="required fa fa-times"></i>
                  @endif
                </td>
                <td>
                  <a href="{{ route('static.trans',$lang->lang_code) }}" title="Edit Static Words For Language {{ $lang->name }}" class="btn btn-sm btn-flat btn-primary">
                      <i class="fa fa-pencil"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
          </div>
          
        </div>

      </div>

			
		</div>
	</div>

<!--ADD LANGAUGE Modal -->
<div class="modal fade" id="addLang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Language</h4>
      </div>
      
      <div class="modal-body">
        <form action="{{ route('site.lang.store') }}" method="POST">
        	@csrf
         <div class="form-group">
            <label>Language Name: <span class="required">*</span></label>
            <input name="name" type="text" class="form-control" placeholder="enter language name"/>
          </div>

          <div class="form-group">
            <label>Language Code: <span class="required">*</span></label>
            <input type="text" name="lang_code" class="form-control" placeholder="enter language code"/>
          </div>

          <div class="form-group">
            <label>Default:</label>
            <br>
            <label class="switch">
                <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="def">
                <span class="knob"></span>
            </label>
          </div>

          <div class="form-group">
            <label>RTL:</label>
            <br>
            <label class="switch">
                <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="rtl_available">
                <span class="knob"></span>
            </label>
          </div>

          <button type="submit" class="btn btn-flat btn-primary btn-md">
            <i class="fa fa-save"></i> Save
          </button>


        </form>
      </div>
      
    </div>
  </div>
</div>

@foreach($allLang as $key=> $lang)
<!-- Delete Lang Modal -->
 <div id="delModal{{ $lang->id }}" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this language? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
               <form method="post" action="{{route('site.lang.delete',$lang->id)}}" class="pull-right">
                             {{csrf_field()}}
                             {{method_field("DELETE")}}
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
</div>

<!-- edit lang Modal -->
<div class="modal fade" id="editLang{{ $lang->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Language {{ $lang->display_name }}</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('site.lang.update',$lang->id) }}" method="POST">
        	@csrf
         	
         	<div class="form-group">
         		<label>Edit Language Name: <span class="required">*</span></label>
         		<input name="name" value="{{ $lang->name }}" type="text" class="form-control" placeholder="enter language name"/>
         	</div>

         	<div class="form-group">
         		<label>Edit Language Code: <span class="required">*</span></label>
         		<input value="{{ $lang->lang_code }}" type="text" name="lang_code" class="form-control" placeholder="enter language code"/>
         	</div>

         	<div class="form-group">
         		<label>Default:</label>
         		<br>
         		<label class="switch">
		            <input {{ $lang->def == 1 ? 'checked' : "" }} type="checkbox" class="quizfp toggle-input toggle-buttons" name="def">
		            <span class="knob"></span>
		        </label>
         	</div>

          <div class="form-group">
            <label>RTL:</label>
            <br>
            <label class="switch">
                <input {{ $lang->rtl_available == 1 ? 'checked' : '' }} type="checkbox" class="quizfp toggle-input toggle-buttons" name="rtl_available">
                <span class="knob"></span>
            </label>
          </div>

         	<button type="submit" class="btn btn-flat btn-primary btn-md">
         		<i class="fa fa-save"></i> Save
         	</button>
        </form>
      </div>
      
    </div>
  </div>
</div>
@endforeach

@endsection
