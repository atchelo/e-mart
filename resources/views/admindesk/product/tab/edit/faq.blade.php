  <div class="panel-heading">
      <a data-toggle="modal" data-target="#addFAQ" class="btn btn-success owtbtn"><i class="fa fa-plus-circle"></i> Add FAQ</a> 
      <br>
    </div>  
        <table id="example1" class="table table-bordered table-striped">
         <thead>
            <tr>
              <th>#</th>
              <th>Product Name</th>
              <th>Question</th>
              <th>Answer</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
         
           @foreach($faqs as $key => $f)

            <tr>
              <td>{{$key+1}}</td>
              <td>{{$f->product['name']}}</td>
              <td>{{ $f->question }}</td>
              <td>{!!$f->answer!!}</td>
              <td>
                  <a title="Edit FAQ" data-toggle="modal" data-target="#editfaq{{ $f->id }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-pencil"></i>
                  </a>
                   <a title="Delete this FAQ?" data-toggle="modal" data-target="#{{ $f->id }}faqdel" class="btn btn-sm btn-danger">
                     <i class="fa fa-trash"></i>
                   </a>
                        
              </td>
            </tr>
            @endforeach
      
          </tbody>
        </table>
    
@foreach($faqs as $key => $f)
    <div id="{{ $f->id }}faqdel" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this faq? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{url('admindesk/product_faq/'.$f->id)}}" class="pull-right">
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

@foreach($faqs as $key => $f)
<!-- EDIT FAQ Modal -->
<div class="modal fade" id="editfaq{{ $f->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit FAQ: {{ $f->question }}</h4>
      </div>
      <div class="modal-body">
       <form id="demo-form2" method="post" action="{{route('product_faq.update',$f->id)}}">
        {{ method_field("PUT") }}
          @csrf
          <div class="form-group">
            <label for="">Question: <span class="required">*</span></label>
            <input required="" type="text" name="question" value="{{ $f->question }}" class="form-control">
          </div>  

          <div class="form-group">
            <label for="">Answer: <span class="required">*</span></label>
            <textarea required="" cols="10" id="answerarea" name="answer" rows="5" class="form-control">{{ $f->answer }}</textarea>
            <input type="hidden" readonly name="pro_id" value="{{ $products->id }}">
             <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter answer for above question ! </small>
          </div> 

          <button type="submit" class="btn btn-primary">
                           <i class="fa fa-plus-save"></i> Save
                        </button>
               
                     
        </form>
      </div>
      
    </div>
  </div>
</div>
@endforeach 

<!-- Create FAQ Modal -->
<div class="modal fade" id="addFAQ" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add new FAQ</h4>
      </div>
      <div class="modal-body">
       <form id="demo-form2" method="post" action="{{url('admindesk/product_faq')}}">
          @csrf
          <div class="form-group">
            <label for="">Question: <span class="required">*</span></label>
            <input type="text" name="question" value="{{old('question')}}" class="form-control">
             <small class="text-muted"><i class="fa fa-question-circle"></i> Please write question !</small>
          </div>  

          <div class="form-group">
            <label for="">Answer: <span class="required">*</span></label>
            <textarea cols="10" id="editor1" name="answer" rows="5" class="form-control">{{old('answer')}}</textarea>
            <input type="hidden" readonly name="pro_id" value="{{ $products->id }}">
             <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter answer for above question ! </small>
          </div> 

          <button type="submit" class="btn btn-primary">
                           <i class="fa fa-plus-circle"></i> Create
                        </button>
               
                     
        </form>
      </div>
      
    </div>
  </div>
</div>
