@extends("admindesk/layouts.master")
@section('title','All Menu List | ')
@section("body")
@inject('pages','App\Page')
  <div class="box">
   <div class="box-header with-border">
      <div class="box-title">
        Menu Management
      </div>

      
    </div>

    <div class="box-body">

      <!-- Help Modal -->
      <div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Example of Footer Widgets & Footer Sections</h4>
            </div>

            <div class="modal-body">
              <img src="{{ url('images/footerhelp.png') }}" title="Footer Help Example" alt="help-footer" class="img-responsive">
            </div>
           
          </div>
        </div>
      </div>

      <div class="nav-tabs-custom">

        <!-- Nav tabs -->
        <ul id="myTab" class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#allmenus" aria-controls="home" role="tab" data-toggle="tab">Top Menus</a></li>

           <li role="presentation"><a href="#footermenus" aria-controls="home" role="tab" data-toggle="tab">Footer Menus</a></li>
          
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

          <div role="tabpanel" class="tab-pane active" id="allmenus">
               <a type="button" class="btn btn-danger btn-md z-depth-0" data-toggle="modal" data-target="#bulk_delete"><i class="fa fa-trash"></i> Delete Selected</a> 
              <a title="Create a new footer menu" href="{{ route('menu.create') }}" class="btn btn-md btn-primary">
                + Create 
              </a>

              <p style="padding: 8px" class="p-1 text-white pull-right bg-green">
                <i class="fa fa-info-circle"></i> Drag and Drop to sort the menu order.
              </p>
              <br><br>
              <table id="menu_table" class="width100 table table-bordered table-striped table-hover">
                <thead>
                    <th>
                      <div class="inline">
                        <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all"/>
                        <label for="checkboxAll" class="material-checkbox"></label>
                      </div>
                    </th>
                    <th>#</th>
                    <th>Title</th>
                    <th>Additonal Detail</th>
                    <th>Action</th>
                </thead>

                <tbody id="menucontent">
                  
                </tbody>
              </table>


    
          </div>

           <div role="tabpanel" class="tab-pane fadein" id="footermenus">
             <a type="button" class="btn btn-danger btn-md z-depth-0" @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#bulk_delete_fm" @else disabled title="This action is disabled in demo !" @endif><i class="fa fa-trash"></i> Delete Selected</a> 
              <a title="Create a new footer menu" data-toggle="modal" data-target="#createnewfootermenu" class="btn btn-md btn-primary">
                + Create
              </a>

              <button data-toggle="modal" data-target="#help" class="pull-right btn btn-md btn-default" title="Help?">
          <i class="fa fa-question-circle"></i> Help
      </button>

              <div class="modal fade" id="createnewfootermenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Create new footer menu</h4>
                    </div>

                    <div class="modal-body">
                      <form action="{{ route('footermenu.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                          <label>Menu title: <span class="required">*</span></label>
                          <input name="title" type="text" class="form-control" required placeholder="enter menu title">
                        </div>
                        
                        <div class="form-group">
                          <label>Link by: <span class="required">*</span></label>
                          <select required class="form-control" name="link_by" id="link_by">
                            <option value="page">Pages</option>
                            <option value="url">URL</option>
                          </select>
                        </div>
  
                        <div class="form-group" id="pagebox">
                          <label>Select pages: <span class="required">*</span></label>
                          <select required="" class="form-control" name="page_id" id="page_id">
                            @foreach($pages->where('status','=','1')->get() as $page)
                              <option value="{{ $page->id }}">{{ $page->name }}</option>
                            @endforeach
                          </select>
                        </div>

                         <div id="urlbox" class="form-group display-none">
                            <label>URL: <span class="required">*</span></label>
                            <input class="form-control" type="url" placeholder="enter custom url" name="url" id="inputurl">
                         </div>

                         <div class="form-group">
                           <label>Widget Position: <span class="required">*</span></label>
                           <select name="widget_postion" id="position" class="form-control">
                             <option value="footer_wid_3">Footer Widget 3</option>
                             <option value="footer_wid_4">Footer Widget 4</option>
                           </select>
                         </div>

                         <div class="form-group">
                            <label>Status:</label>
                            <br>
                            <label class="switch">
                                <input type="checkbox" name="status">
                                <span class="knob"></span>
                            </label>
                         </div>

                         <div class="form-group">
                           <button class="btn btn-md btn-primary" type="submit">Create</button>
                         </div>

                      </form>
                    </div>
                    
                  </div>
                </div>
              </div>
            <br><br>
            <table id="full_detail_table" class="width100 table table-bordered table-striped table-hover">
              @inject('footermenus','App\FooterMenu')
              <thead>
                <tr>
                  <th>
                      <div class="inline">
                        <input id="checkboxAll_fm" type="checkbox" class="filled-in" name="checked_fm[]" value="all"/>
                        <label for="checkboxAll_fm" class="material-checkbox"></label>
                      </div>
                    </th>
                  <th>#</th>
                  <th>Menu Title</th>
                  <th>Info.</th>
                  <th>Action</th>
                </tr>
              </thead>
      
              <tbody>
                @foreach($footermenus->get() as $key => $fm)
                  <tr>
                    <td>
                      <div class="inline">
                          <input type="checkbox" form="bulk_delete_form_fm" class="fm_menus_cbox filled-in material-checkbox-input" name="checked_fm[]" value="{{$fm->id}}" id="fm{{$fm->id}}">
                          <label for="fm{{$fm->id}}" class="material-checkbox"></label>
                      </div>
                    </td>
                    <td>{{ $key + 1 }}</td>
                    <td><b>{{ $fm->title }}</b></td>
                    <td>
                      <p>
                        @if($fm->link_by == 'page')
                          <b>Linked to:</b> Page
                        @else
                          <b>Linked to:</b> URL
                        @endif
                      </p>

                      <p>
                        <b>Widget Position:</b> {{ $fm->widget_postion == 'footer_wid_3' ? "Footer Widget 3" : "Footer Widget 4" }}
                      </p>

                      <p> <b>Status: </b>
                        @if($fm->status == '1')
                          <span class="label label-success">Active</span>
                        @else
                          <span class="label label-danger">Deactive</span>
                        @endif
                      </p>
                    </td>

                    <td>
                      <ul class="nav table-nav">
                        <li class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            Action <span class="caret"></span>
                          </a>
                          <ul class="dropdown-menu">
                              
                              <li role="presentation">
                                <a href="#editmenuModal{{ $fm->id }}" data-toggle="modal" title="Edit Menu" role="menuitem" tabindex="0"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Menu
                                </a>
                              </li>
 
                              <li role="presentation" class="divider"></li>
                              <li role="presentation">
                                <a @if(env('DEMO_LOCK') == 0) data-toggle="modal" href="#{{ $fm->id }}footermenudel" @else disabled title="This action is disabled in demo !" @endif>
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

      </div>
        
    </div>
  </div>

@foreach($footermenus->get() as $key => $fm)
  <div class="modal fade" id="editmenuModal{{ $fm->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Create new footer menu</h4>
        </div>

        <div class="modal-body">
          <form action="{{ route('footermenu.update',$fm->id) }}" method="POST">
            @csrf

            <div class="form-group">
              <label>Menu title: <span class="required">*</span></label>
              <input name="title" value="{{ $fm->title }}" type="text" class="form-control" required placeholder="enter menu title">
            </div>
            
            <div class="form-group">
              <label>Link by: <span class="required">*</span></label>
              <select required class="form-control link_by_edit" name="link_by" id="link_by_edit">
                <option {{ $fm->link_by == 'page' ? "selected" : "" }} value="page">Pages</option>
                <option {{ $fm->link_by == 'url' ? "selected" : "" }} value="url">URL</option>
              </select>
            </div>

            <div class="form-group pagebox_edit {{ $fm->link_by == 'page' ? '' : 'display-none' }}" id="pagebox_edit" >
              <label>Select pages: <span class="required">*</span></label>
              <select {{ $fm->link_by == 'page' ? 'required' : '' }} class="form-control page_id_edit" name="page_id" id="page_id_edit">
                @foreach($pages->where('status','=','1')->get() as $page)
                  <option {{ $fm->page_id == $page->id ? "selected"  : "" }} value="{{ $page->id }}">{{ $page->name }}</option>
                @endforeach
              </select>
            </div>

             <div id="urlbox_edit" class="urlbox_edit form-group {{ $fm->link_by == 'url' ? '' : 'display-none' }}">
                <label>URL: <span class="required">*</span></label>
                <input value="{{ $fm->url }}" class="form-control" type="url" placeholder="enter custom url" name="url" id="inputurl-edit">
             </div>

             <div class="form-group">
               <label>Widget Position: <span class="required">*</span></label>
               <select name="widget_postion" id="position" class="form-control">
                 <option {{ $fm->widget_postion == 'footer_wid_3' ? "selected" : "" }} value="footer_wid_3">Footer Widget 3</option>
                 <option {{ $fm->widget_postion == 'footer_wid_4' ? "selected" : "" }} value="footer_wid_4">Footer Widget 4</option>
               </select>
             </div>

             <div class="form-group">
                <label>Status:</label>
                <br>
                <label class="switch">
                    <input type="checkbox" name="status" {{ $fm->status == 1 ? "checked" : "" }}>
                    <span class="knob"></span>
                </label>
             </div>

             <div class="form-group">
               <button class="btn btn-md btn-primary" @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This action is disabled in demo !" @endif>Update</button>
             </div>

          </form>
        </div>
        
      </div>
    </div>
  </div>
@endforeach
 
 @foreach($footermenus->get() as $key => $fm)
  <div id="{{ $fm->id }}footermenudel" class="delete-modal modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
          </div>
          <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this menu? This process cannot be undone.</p>
          </div>
          <div class="modal-footer">
           <form method="post" action="{{ route('footermenu.delete',$fm->id) }}" class="pull-right">
                      {{csrf_field()}}
                      @method('delete')
                      
          
              <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
              <button type="submit" class="btn btn-danger">Yes</button>
            </form>
          </div>
        </div>
      </div>
  </div>
 @endforeach

  <!-- Top menu Bulk Delete Modal -->
      <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete these top menus? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
             <form id="bulk_delete_form" method="post" action="{{ route('bulk.delete.topmenu') }}">
                @csrf
                @method('DELETE')
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>

        <!-- Footer menu Bulk Delete Modal -->
      <div id="bulk_delete_fm" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete these footer menus? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
             <form id="bulk_delete_form_fm" method="post" action="{{ route('bulk.delete.fm') }}">
                @csrf
                @method('DELETE')
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>

@endsection
@section('custom-script')
  <script>
    var url  = {!!json_encode(route('menu.index'))!!};
    var sorturl = {!!json_encode(route('menu.sort'))!!};
    var customcatid = null;
  </script>
  <script src="{{ url('js/menu.js') }}"></script>
  <script src="{{ url('js/footermenu.js') }}"></script>
@endsection