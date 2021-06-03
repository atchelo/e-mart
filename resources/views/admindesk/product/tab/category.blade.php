<form id="demo-form2" method="post" action="{{route('category.store')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
                  <br>      
                 <label for="exampleInputSlug">Category:<sup class="required">*</sup></label>
                  <input type="text" placeholder="Enter Your category " class="form-control" name="category" id="exampleInputPassword1" value="" colmd>
                
                  <br>
                  <label for="exampleInputSlug"> Icon:<sup class="required">*</sup></label>
                  <input type="text" class="form-control" name="icon"  placeholder="Enter Your Short icon" id="exampleInputPassword1" value="" >
                
                  <br>
                <label for="Image">Choose image:<sup class="required">*</sup></label>
                <input type="file" name="image" class="form-control">
                <br>
                
                   <br>
                  <label for="exampleInputSlug">Featured:<sup class="required">*</sup></label>
                  <input data-width="90" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger" id="events" type="checkbox" data-toggle="toggle">
                  <input type="hidden" name="featured" id="featureds" value="0" >

                  <br>


                 <br>
                  <label for="exampleInputDetails">Status:<sup class="required">*</sup></label>


                   <input data-width="90" data-on="Active" data-off="Deactive" data-onstyle="success" data-offstyle="danger" id="toggle-event5" type="checkbox" data-toggle="toggle">
                  <input type="hidden" name="status" id="status5">
                  </select>
                
               
                
                 <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>       
  </form>


