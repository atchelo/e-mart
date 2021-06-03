
<form id="demo-form2" method="post" action="{{url('admindesk/product_faq')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
        

                 <br>
                 <label for="exampleInputSlug">Question:</label>
                   <input type="text" id="first-name" name="question" value="{{old('question')}}" class="form-control col-md-7 col-xs-12">
                   <p class="txt-desc">Please Enter Product Question</p>
                
                  <br>
 s
                  <input type="hidden" name="pro_id" value="{{$pro_id}}">

                  <label for="exampleInputSlug">Ans :</label>
                  <textarea cols="2" id="editor1" name="answer" rows="5" class="form-control col-md-7 col-xs-12">
                  {{old('answer')}}
                  </textarea>
                  <p class="txt-desc">Please Enter Product Answer</p>
                  <br>
                 <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>       
  </form>

