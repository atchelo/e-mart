@extends("admindesk.layouts.master")
@section('title','Create new tax class')
@section("body")
<div class="box">
  <div class="box-header with-border">
    <div class="box-title">
      Add new tax class
    </div>

    <a title="Go back" href=" {{url('admindesk/tax_class')}} " class="btn btn-success pull-right owtbtn">< Back</a>
  </div>

  <div class="box-body">
     <div class="x_content">
                    
                    <form class="form-horizontal form-label-left" method="post">
                       {{csrf_field()}}
                      <div class="tax-form">
                        <h2 class="tax-heading">Tax Class</h2>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            Tax Class Title <span class="required">*</span>
                          </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                            <input placeholder="Please enter tax class" type="text" name="title" id="titles" class="form-control col-md-7 col-xs-12">
                            
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            Description <span  class="required">*</span>
                          </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input placeholder="Please enter tax class description" type="text" name="des" id="des" class="form-control col-md-7 col-xs-12">
                              
                            </div>
                        </div>
                      </div>
                    
                        <fieldset>
                          <legend>Tax Rates</legend>
                          <table id="full_detail_tables" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr class="table-heading-row">
                              <th>Tax Rate</th>
                              <th>Based On</th>
                              <th>Priority</th>
                        </tr>
                    </thead>
                      <tbody class="xyz">
                           
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="3"></td>
                            <td class="text-left"><button type="button" onclick="addRow();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Rule"><i class="fa fa-plus-circle"></i></button></td>
                          </tr>
                        </tfoot>
                          </table>
                 
                     
                     
                           
                      </fieldset>

                      <a onclick="SubmitFormData();"  class="btn btn-info">
                        <i class="fa fa-save"></i> Save
                      </a>
                      
                       </form>
                <!-- /.box -->
                </div>
  </div>
</div>
@endsection
@section('custom-script')
  @include('admindesk.tax_class.taxclassscript')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/taxclass.js') }}"></script>
@endsection