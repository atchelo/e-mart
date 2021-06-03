<div class="row">

  <div class="{{ $product->vender_offer_price !='' ? "col-md-6" : "col-md-12" }}">
    <h4>Pricing Summary </h4>
    <hr>

    <div class="row">
      <div align="left" class="left-col col-md-6">
        <b>Product Price:</b>
      </div>
      <div align="right" class="right-col col-md-6">
        {{ sprintf("%.2f",$product->vender_price) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> 
        <br>
        <small> @if($product->tax_r != '') (Incl. of tax) @else (Excl. of Tax) @endif </small>
      </div>
    </div>
    
    
    <hr>
      <h4>Commission Summary</h4>
    <hr>

    @php

      $commision_setting = \DB::table('commission_settings')->first();
      $commissionRate = 0;
      $mpc = 0;
      $show_price = 0;
      $convert_price = 0;

if($commision_setting->type == "flat"){

$commission_amount = $commision_setting->rate;

$commissionRate = $commission_amount;

if($commision_setting->p_type == 'f'){

  $totalprice = $product->vender_price+$commission_amount;
  $totalsaleprice = $product->vender_offer_price + $commission_amount;

  if($product->vender_offer_price == 0){
     $show_price = $totalprice;
  }else{
    $totalsaleprice;
    $convert_price = $totalsaleprice =='' ? $totalprice:$totalsaleprice;
    $show_price = $totalprice;
  }

  
   
}else{

     $totalprice = ($product->vender_price)*$commission_amount;

     $totalsaleprice = ($product->vender_offer_price)*$commission_amount;

     $commissionRate = $totalprice/100;

     $mpc = $totalprice/100;
  
     $buyerprice = ($product->vender_price)+($totalprice/100);

     $buyersaleprice = ($product->vender_offer_price)+($totalsaleprice/100);

 
    if($product->vender_offer_price == NULL){
      $show_price =  round($buyerprice,2);
    }else{
      round($buyersaleprice,2);
     
      $convert_price = $buyersaleprice=='' ? $buyerprice:$buyersaleprice;
      $show_price = $buyerprice;
    }
 

}
}else{


$comm = \DB::table('commissions')->where('category_id',$product->category_id)->first();
if(isset($comm)){

  if($comm->type=='f'){

     $commissionRate = $comm->rate;

     $price = $product->vender_price + $comm->rate;

      if($vender_offer_price != null){
        $offer =  $product->vender_offer_price + $comm->rate;
      }

      if($product->vender_offer_price == 0 || $product->vender_offer_price == null){
          $show_price = $price;
      }else{
       
        $convert_price = $offer;
        $show_price = $price;
      }

    }else{

        $commissionRate = $comm->rate;

        $commission_amount = $comm->rate;

        $totalprice = ($product->vender_price)*$commission_amount;

        $totalsaleprice = ($product->vender_offer_price)*$commission_amount;

       
         $commissionRate = $totalprice/100;
         $mpc = $totalprice/100;
        

        $buyerprice = ($product->vender_price)+($totalprice/100);

        $buyersaleprice = ($product->vender_offer_price)+($totalsaleprice/100);

       
        if($product->vender_offer_price == 0){
           $show_price = round($buyerprice,2);
        }else{
          $convert_price =  round($buyersaleprice,2);
          
          $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
          $show_price = round($buyerprice,2);
        }
       
       
        
  }

 }
    }
    @endphp

    @php
      $ctax = 0;
      if($product->tax_r !=''){
      $p=100;
      $taxrate_db = $product->tax_r;
      $vp = $p+$taxrate_db;
      $tam = $commissionRate/$vp*$taxrate_db;
      $tam = sprintf("%.2f",$tam);
     
        $ctax = $tam;
      }
    @endphp

    <div class="row">
      <div align="left" class="left-col col-md-6">
        <b>Net Commission</b>:
      </div>
      <div align="right" class="right-col col-md-6">
        @if($product->tax_r =='')  {{ sprintf("%.2f",$commissionRate) }} @else  {{ sprintf("%.2f", $commissionRate-$ctax) }} @endif <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i>
      </div>
    </div>

   

    @if($product->tax_r !='')
    <div class="row">

      <div align="left" class="left-col col-md-6">
        <b>Commission Tax:</b>
      </div>

      <div align="right" class="right-col col-md-6">
        {{ sprintf("%.2f", $ctax) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i>
      </div>

    </div>
     
    <div class="row">
      <div align="left" class="left-col col-md-6">
        <b>Gross Commission:</b>
      </div>

      <div align="right" class="right-col col-md-6"> {{ sprintf("%.2f", $commissionRate) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> <br> <small>@if($product->tax_r !='') (Incl. of Tax) @endif</small></div>
    </div>
    
    @endif
  </div>
@if($product->vender_offer_price != '')
  <div class="col-md-6">
    <h4>Offer Pricing Summary</h4>
    <hr>
    <div class="row">
      <div align="left" class="left-col col-md-6">
        <b>Product Offer Price:</b>
      </div>
      <div align="right" class="right-col col-md-6">
        {{ sprintf("%.2f", $product->vender_offer_price) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i>
        <br>
        <small>@if($product->tax_r !='') (Incl. of tax) @else (Excl. of Tax) @endif</small>
      </div>
    </div>
    
    <hr>
      <h4>Commission Summary</h4>
    <hr>

    @php

      $commision_setting = \DB::table('commission_settings')->first();
      $commissionRate = 0;
      $mpc = 0;

if($commision_setting->type == "flat"){

$commission_amount = $commision_setting->rate;

$commissionRate = $commission_amount;


if($commision_setting->p_type == 'f'){

  $totalprice = $product->vender_price+$commission_amount;
  $totalsaleprice = $product->vender_offer_price + $commission_amount;

  if($product->vender_offer_price == 0){
     $show_price = $totalprice;
  }else{
    $totalsaleprice;
    $convert_price = $totalsaleprice =='' ? $totalprice:$totalsaleprice;
    $show_price = $totalprice;
  }

  
   
}else{

  $totalprice = ($product->vender_price)*$commission_amount;

  $totalsaleprice = ($product->vender_offer_price)*$commission_amount;

  if(!($totalsaleprice)){
    $commissionRate = $totalprice/100;
    $mpc = $totalprice/100;
  }else{
     $commissionRate = $totalsaleprice/100;
     $mpc = $totalprice/100;
  }

  $buyerprice = ($product->vender_price)+($totalprice/100);

  $buyersaleprice = ($product->vender_offer_price)+($totalsaleprice/100);

 
    if($product->vender_offer_price == NULL){
      $show_price =  round($buyerprice,2);
    }else{
       round($buyersaleprice,2);
     
      $convert_price = $buyersaleprice=='' ? $buyerprice:$buyersaleprice;
      $show_price = $buyerprice;
    }
 

}
}else{

$comm = \DB::table('commissions')->where('category_id',$product->category_id)->first();

if(isset($comm)){

  if($comm->type=='f'){

     $commissionRate = $comm->rate;

     $mpc = $comm->rate;

      $price = $product->vender_price + $comm->rate;

      if($product->vender_offer_price != null){
        $offer =  $product->vender_offer_price + $comm->rate;
      }

      if($product->vender_offer_price == 0 || $product->vender_offer_price == null){
          $show_price = $price;
      }else{
       
        $convert_price = $offer;
        $show_price = $price;
      }

    }else{

        $commissionRate = $comm->rate;

        $commission_amount = $comm->rate;

        $totalprice = $product->vender_price*$commission_amount;

        $totalsaleprice = $product->vender_offer_price*$commission_amount;

        if(!($totalsaleprice)){
          $commissionRate = $totalprice/100;
          $mpc = $totalprice/100;
        }else{
            $commissionRate = $totalsaleprice/100;
            $mpc = $totalprice/100;
        }

        $buyerprice = ($product->vender_price)+($totalprice/100);

        $buyersaleprice = ($product->vender_offer_price)+($totalsaleprice/100);

       
        if($product->vender_offer_price == 0){
           $show_price = round($buyerprice,2);
        }else{
          $convert_price =  round($buyersaleprice,2);
          
          $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
          $show_price = round($buyerprice,2);
        }
       
       
        
  }

 }
    }
    @endphp

    @php
      $ctax = 0;
      if($product->tax_r !=''){
        $p=100;
      $taxrate_db = $product->tax_r;
      $vp = $p+$taxrate_db;
      $tam = $commissionRate/$vp*$taxrate_db;
      $tam = sprintf("%.2f",$tam);
      $ctax = $tam;
      }
    @endphp
    <div class="row">
      <div align="left" class="left-col col-md-6">
        <b>Net Commission:</b>
      </div>

      <div align="right" class="right-col col-md-6">
         @if($product->tax_r =='')  {{ sprintf("%.2f", $commissionRate) }} @else {{   sprintf("%.2f",$commissionRate-$ctax) }} @endif <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i>
      </div>
    </div>
    

    @if($product->tax_r !='')

    <div class="row">

      <div align="left" class="left-col col-md-6">
        <b>Commission Tax:</b> 
      </div>

      <div align="right" class="right-col col-md-6">
         {{ sprintf("%.2f", $ctax) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i>
      </div>

    </div>

    <div class="row">
      <div align="left" class="left-col col-md-6">
        <b>Gross Commission:</b>
      </div>
      <div align="right" class="right-col col-md-6">
         {{ sprintf("%.2f", $commissionRate) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i>
        <br>
        <small>@if($product->tax_r !='') (Incl. of Tax) @endif</small>
      </div>
    </div>

    @endif
  </div>
@endif
      

</div>
 <div class="row">
   <div class="{{ $product->vender_offer_price !='' ? "col-md-6" : "col-md-12" }}">
    <hr>
      <h4>Final Selling Price</h4>
    <hr>
     @if($product->tax_r !='')
     <div class="row">
       <div align="left" class="left-col col-md-6">
         <b>Selling Price:</b>
       </div>
       <div align="right" class="right-col col-md-6">

         {{ sprintf("%.2f", $product->vender_price+$mpc ) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> <br> <small>(Incl. of Tax)</small>
        
       </div>
     </div>
      
    
      @else
        <div class="row">
          <div align="left" class="left-col col-md-6">
            <b>Selling Priced:</b>
          </div>
          <div align="right" class="right-col col-md-6">
             {{ sprintf("%.2f", $show_price) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> <br> <small>(Excl. of Tax)</small>
          </div>
        </div>
        
      

      @endif
   </div>
@if($product->vender_offer_price != '')
   <div class="col-md-6">
    <hr>
      <h4>Final Selling Offer Price</h4>
    <hr>
     @if($product->tax_r !='')

     <div class="row">
      <div align="left" class="left-col col-md-6">
        <b>Selling Offer Price:</b>
      </div>
      <div align="right" class="right-col col-md-6">
        {{ sprintf("%.2f", $product->vender_offer_price+$commissionRate) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> <br> <small>(Incl. of Tax)</small>
      </div>
      
    </div>
     
      
    @else
    <div class="row">
      <div align="left" class="left-col col-md-6">
        <b>Selling Offer Price:</b>
      </div>
      <div align="right" class="right-col col-md-6">
         {{ sprintf("%.2f", $convert_price) }} <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> <br> <small>(Excl. of Tax)</small>
      </div>
    </div>

    @endif
      
      
     
      
   </div>
@endif
 </div>