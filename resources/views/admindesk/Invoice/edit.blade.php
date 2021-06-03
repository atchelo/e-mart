@extends("admindesk/layouts.master")
@section('title','Invoice Setting |')
@section("body")

   
          <div class="box" >
            <div class="box-header with-border">
                <div class="box-title">Invoice Setting</div>
              </div>
              <div class="box-body">
                   
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admindesk/invoice/')}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Order Prefix:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="order_prefix" value="{{$Invoice->order_prefix ?? ''}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">(Please Enter Order Prefix)</p>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Invoice Prefix:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="prefix" value="{{$Invoice->prefix ?? ''}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">(Please Enter Prefix)</p>
                        </div>
                      </div>
                        
					           <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Invoice Postfix:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="postfix" value="{{$Invoice->postfix ?? ''}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">(Please Enter Postfix)</p>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Invoice No. Start From:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="inv_start" value="{{$Invoice->inv_start ?? ''}}" class="form-control col-md-7 col-xs-12">
                          <br> <br>
                          <div class="well custom-well">
                            
                            <p>Note : Invoice No. is That Like From Where you want to Start Your Invoice No. </p>
                            <p>If your <b>Prefix:</b> ABC, <b>Postfix:</b> XYZ or <b>Invoice No. Start From
                            :</b> 001</p>
                           
                            <p>Than your first Invoice no. will be:</p>
                            <p><b>ABC001XYZ</b>
                              <br>
                            </p>
                           
                          </div>

                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          COD Prefix:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="cod_prefix" value="{{$Invoice->cod_prefix ?? ''}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">(Please Enter COD Prefix)</p>
                        </div>
                      </div>


                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          COD Postfix:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="cod_postfix" value="{{$Invoice->cod_postfix ?? ''}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">(Please Enter COD Postfix)</p>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Terms:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="terms" value="{{$Invoice->terms ?? ''}}" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">(Enter terms which display on invoice bottom )</p>
                        </div>
                      </div>

                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Seal:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="first-name" name="seal" class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">(It will display on Invoice at bottom right )</p>
                        </div>

                        <div class="col-md-offset-3 col-md-6">
                          <div class="well">
                            @php
                               $seal = @file_get_contents(public_path().'/images/seal/'.$Invoice->seal);
                            @endphp
                            @if($seal)
                            <p><b>Preview:</b></p>
                            <img class="max-width100" src="{{ url('images/seal/'.$Invoice->seal) }}" title="Current Seal" alt="{{ $Invoice->seal }}"/>
                            @else
                            <p>No Image Found !</p>
                            @endif
                          </div>
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Sign:
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="first-name" name="sign"  class="form-control col-md-7 col-xs-12">
                          <p class="txt-desc">(It will display on Invoice at bottom left )</p>
                        </div>

                        <div class="col-md-offset-3 col-md-6">
                          <div class="well">
                            @php
                               $sign = @file_get_contents(public_path().'/images/sign/'.$Invoice->sign);
                            @endphp
                            @if($sign)
                            <p><b>Preview:</b></p>
                            <img class="max-width50" src="{{ url('images/sign/'.$Invoice->sign) }}" title="Current Seal" alt="{{ $Invoice->sign }}"/>
                            @else
                            <p>No Image Found !</p>
                            @endif
                          </div>
                        </div>
                      </div>




                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        
                          <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="This operation is disabled in demo !" disabled="" @endif class="btn btn-md col-md-4 btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>
                      </div>

                    </form>
                  </div>
        
@endsection