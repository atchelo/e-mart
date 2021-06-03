
            <span class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              <label>
                Auto Detect:
              </label>
            </span>

             <div class="col-md-9 col-sm-9 col-xs-12">

             <label class="switch"> 
             
              <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="auto_detect" onchange="autoDetectLocation('auto-detect')" id="auto-detect" {{$auto_geo->auto_detect=="1"?'checked':''}}>
              <span class="knob"></span> 

              </label>
              
              <label for="auto-detect"></label> 
              <div class="geoLocation-add" ><span class="you-are-login">Currently you are login from </span><img class="country-loding" src="{{ url('images/circle.gif') }}"><span class="location-name"></span> <i class="fa fa-map-marker map-icon" aria-hidden="true"></i></div>

            </div>

          
          <div class="col-md-3 col-sm-3 col-xs-6 select-geo">         
            <label>
              Geo Location:
            </label>
          
           
          
        </div>

      <div class="col-md-6 col-sm-6 col-xs-6 select-geo">  
        <select name="geoLocation" class="form-control" id="GeoLocationId">
            
             <option value="0">Not Available</option>
                      @foreach($all_country as $c)
                         
                        
                         <option value="{{$c->id}}" {{ $c->id == $auto_geo->default_geo_location ? 'selected="selected"' : '' }}>
                            {{$c->nicename}}
                         </option>

                      @endforeach
         </select>
       </div>
        <p></p>

        @if($auto_geo->auto_detect=="1")
          
          <div id="baseCurrencyBox">
            <span class="control-label col-md-3 col-sm-12 col-xs-12 currency-by-country margin-top-10">
              <label>
                Currency by Country:
              </label>
            </span>
             <div class="col-md-9 col-sm-9 col-xs-12 currency-by-country">
                <label class="switch">
                 <input type="checkbox" name="by-country" onchange="currencybycountry('by-country')" id="by-country" {{$auto_geo->currency_by_country=="1"?'checked':''}}>
                 <span class="knob"></span>
                </label>
                <i class="currency-info">Only working with AUTO DETECT feature. Currency will be selected base on country.</i>
              </div>
          </div>

        @else

           <div class="display-none" id="baseCurrencyBox">
            <span class="control-label col-md-3 col-sm-12 col-xs-12 currency-by-country margin-top-10">
              <label>
                Currency by Country:
              </label>
            </span>
             <div class="col-md-9 col-sm-9 col-xs-12 currency-by-country">
                <label class="switch">
                 <input type="checkbox" name="by-country" onchange="currencybycountry('by-country')" id="by-country" {{$auto_geo->currency_by_country=="1"?'checked':''}}>
                 <span class="knob"></span>
                </label>
                <i class="currency-info">Only working with AUTO DETECT feature. Currency will be selected base on country.</i>
              </div>
          </div>

        @endif


            
 
            <!-- Table -->
      <form class="{{ $auto_geo->currency_by_country=="1" ? "" : 'display-none' }}" id="cur_by_country" method="post" action="{{url('admindesk/location')}}">
               @csrf
          <table class="table">
             
              <thead>
                <tr>
                  <th scope="col">Currency</th>
                  <th scope="col">Countries</th>
                  <th scope="col">Action</th>
                 
                </tr>
              </thead>
              <tbody>

                @if(!empty($check_cur))
                
                
                      @foreach($check_cur as $currency)
                     
                       
                      <tr>
                       
                      <td>
                        
                       ({{$currency->currency->symbol}}){{$currency->currency->code}}
                       <input type="hidden" id="currency_id{{$currency->id}}" name="multi_curr{{$currency->id}}" value="{{$currency->currency->code}}">
                        <input type="hidden" id="multi_currency{{$currency->id}}" name="multi_currency{{$currency->id}}" value="{{$currency->id}}">
                      </td>
                      <td>
                       
                      <div>

                      <select class="js-example-basic-multiple" id="country_id{{$currency->id}}" name="country{{$currency->id}}[]" multiple="multiple">  
                      @foreach($all_country as $country)
                          
                            <option @if(!empty($currency->currencyLocationSettings)) @foreach(explode(',', $currency->currencyLocationSettings->country_id) as $c) @if($c == $country->id) {{ 'selected' }} @endif @endforeach @endif value="{{$country->id}}">{{$country->nicename}}
                            </option>


                            @endforeach
                      </select>
                         
                    </div>
                      </td>
                      
                       
                       <td>
                        
                        <a onclick="SelectAllCountry2('country_id{{$currency->id}}','btnid{{$currency->id}}')" id="btnid{{$currency->id}}"class="btn btn-info" isSelected="no"> 
                          <span>Select All  </span><i class="fa fa-check-square-o"></i>
                         </a>
                         <a onclick="RemoveAllCountry2('country_id{{$currency->id}}','btnid{{$currency->id}}')" id="btnid{{$currency->id}}"class="btn btn-danger" isSelected="yes"> 
                          <span>Remove All  </span><i class="fa fa-window-close"></i>
                         </a>
                       
                       </td>
                     </tr>
                              
                     @endforeach
                    @endif
                 <tr>
                  <td colspan="2">
                  <div class="pull-left">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                  </div>
                </td>
                </tr>

                 
                
              </tbody>
              
              

          </table>
</form>
     
<script>var baseUrl = "<?= url('/') ?>";</script>
<script src="{{ url('js/currency.js') }}"></script>

