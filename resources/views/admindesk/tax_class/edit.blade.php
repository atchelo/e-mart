@extends("admindesk/layouts.master")
@section('title','Edit Tax Class | ')
@section("body")


    <?php $key = 0; ?>
     
        <div class="box">
        <div class="box-header with-border">
          <div class="box-title"> Edit Tax Class</div>
           <a href=" {{url('admindesk/tax_class')}} " class="btn btn-success pull-right">< Back</a>
                        
                   
                  </div>
                  <div class="x_content">
                    <br />

                    <form class="form-horizontal form-label-left" method="post">
                       
                      <div class="tax-form">
                        <h2 class="tax-heading">Tax Class</h2>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            Tax Class Title <span class="required">*</span>
                          </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                            <input placeholder="Please enter Tax class" value="{{$tax->title}}" type="text" name="title" id="titles" class="form-control">
                            
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            Description <span class="required">*</span>
                          </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input placeholder="Please enter Tax class" value="{{$tax->des}}" type="text" name="des" id="des" class="form-control">
                              
                            </div>
                        </div>
                      </div>
                    
                        <fieldset>
                          <legend>Tax Rates</legend>
                          <table id="full_detail_tables" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr class="table-heading-row">
                              <th>Tax Rate <img src="{{(url('public/images/info.png'))}}"  class="height-15" data-toggle="popover" data-content="You Want to Choose Tax Class Then Apply same Tax Class And Tax Rate .">
                              </th>
                              <th>Based On <img src="{{(url('public/images/info.png'))}}" class="height-15" data-toggle="popover" data-content="You Want To Choose Billing address.. 
                             Then Billing Address And Zone Address Are Same Then Tax Will Be Applied,
                              And You Will Be Choose Store Address then Store Addrss And User Billing Address Is Same Then Tax Will Be Apply  ."></th>
                              <th>Priority <img src="{{(url('public/images/info.png'))}}" class="height-15" data-toggle="popover" data-content="1 Priority Is Higher Priority And All Numeric Number Is Lowest Priority,
                               Priority Are Accept Is Numeric Number."></th>
                        </tr>
                    </thead>
                      <tbody class="xyz">
                        <?php $counter=1;
                         ?>

                         
                  @if(isset($tax->priority))        
                    @foreach($tax->priority as $k=> $t)
                     
                     
                      <tr id="count{{$counter}}">
                        <td>

                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="taxRate_id" id="tax{{$counter}}" class="form-control col-md-7 col-xs-12">
                                @foreach(App\Tax::all() as $taxs)
                                <option value="{{$taxs->id}}" {{ $taxs->id == $tax->taxRate_id[$t] ? 'selected="selected"' : '' }}>{{$taxs->name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          </td>
                         
                              
                          <td>
                           
                        
                            
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="based_on" id="based_on{{$counter}}" class="form-control col-md-7 col-xs-12" >
                                  
                                  <option value="0">Please Choose</option>
                                  <option value="billing"{{ $tax->based_on[$t] =='billing' ? 'selected="selected"' : '' }} >Billing Address</option>
                                  <option value="store" {{ $tax->based_on[$t] =='store' ? 'selected="selected"' : '' }} >Store Address</option>
                                  
                                </select>
                              </div>
                            </div>
                            
                          </td>
                          <input type="hidden" id="ids" value="{{$tax->id}}">
                          <td>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="priority{{$counter}}" value="{{$t}}" name="priority" class="form-control col-md-7 col-xs-12">
                              </div>

                            </div>
                          </td>
                          <td>
                            <a onclick="removeRow('count{{$counter}}')" class="btn btn-danger owtbtn" ><i class="fa fa-minus-circle"></i></a>
                          </td>
                        </tr>
                           <?php $counter++;?>
                           
                          @endforeach
                        @endif
                          
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="3"></td>
                            <td class="text-left"><button type="button" onclick="addRow();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Rule"><i class="fa fa-plus-circle"></i></button></td>
                          </tr>
                        </tfoot>
                          </table>
                 
                     
                     
                           
                      </fieldset>

                      <a onclick="UpdateFormData();"  class="btn btn-info">
                        <i class="fa fa-save"></i> Save
                      </a>
                      <div id="msg"></div>
                       </form>
               
@endsection


@section('custom-script')
<script>var baseUrl = "<?= url('/') ?>";</script>
<script src="{{ url('js/taxclass.js') }}"></script>
@include('admindesk.tax_class.taxclassscript')
<script>
var taxid = {!! json_encode($tax->id) !!};
var urllike = {!! json_encode(url('admindesk/taxclassUpdate')) !!};
var redirecturl = {!! json_encode(route('tax_class.index')) !!};
</script>
<script src="{{url('js/edittaxclass.js')}}"></script>
@endsection