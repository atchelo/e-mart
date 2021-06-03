
<script>

  "use strict";

  function shareURL(){
     var currentpage = window.location.href;

     $.ajax({

        type : 'GET',
        data : {url : currentpage},
        datatype : 'html',
        url  : '{{ route('share') }}',
        success : function(response){

           $('.share-content').html('');
           $('.share-content').append(response.cururl);
        }

     });
  }
       
  
 $(function() {

   shareURL();

 $("#nmovimentos").change(function(){
   var newValue = $(this).val();
   var stock = "<?php echo $pro->qty; ?>"

   if (newValue >= stock)
       alert("Out Of Stock..");

 });



   
    var d = new Date();
     var datestring = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
     ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
      var pausecontent = new Array();
      var hotdeals = '{{ count($hotdeals) }}';

       <?php foreach ($hotdeals as $key => $val) {?>
           var start = '{{$val->hotdeal->start}}';
           var end = "{{ $val->hotdeal->end }}";

           if(start <= datestring && end >= datestring){

             pausecontent.push('{{ $val }}');


           }else{

           }

         <?php }?>

      if(pausecontent.length == 0){
        $('.hot-deals').remove();
      }


 });

 var varid = new Array();
 var varqty = new Array();
 var variantprice = new Array();
 var variantofferprice = new Array();


 
$(function() {

 var conversion_rate = '{{ $conversion_rate }}';
     var u=[];
     var u2=[];
     var attrId = [];
     var atrbName = [];
     var atrbId = [];
     var indexnum = [];

     var t1 = 0;
    $('.xyz').each(function(index){
       var t = $(this).attr('s');
       var a2 = $(this).attr('val');
         if(t1 == a2){
             $(this).css('display', 'none');
             $(this).remove();
             t1 = $(this).attr('val');            
         }
        else{

           t1 = $(this).attr('val');
         }


      attrId.push($(this).attr('attr_id'));
      u.push($(this).attr('name'));


    });
    

    $('.atrbName').each(function (index){
     atrbName.push($(this).attr('id'));
     atrbId.push($(this).attr('value'));
     indexnum.push($(this).attr('indexnum'));

    });


    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

      for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
              return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          }
        }
    };

    

var arr2 = [];
for (var i =0; i<atrbName.length; i++) {

  var tech2 = getUrlParameter(atrbId[i]);
  arr2.push({key: atrbName[i], value: tech2});

}

var defresponse = null;
var data = null;
var setdefvariant = null;

 $.ajax({
       url:"{{ url('onloadvariant/'.$pro->id)}}",
       method:'GET',
       datatype:'html',
       data: {arr : arr2},

       success:function(response)
       {
        if (response == "") {

            /** if variant not found run a script to set default variant */

            $.ajax({
                  
                  async: false,
                  type: "GET",
                  data: {arr : arr2},
                  url:"{{ url('/variantnotfound/'.$pro->id)}}",
                  success: function (getresponse) {
                    defresponse = getresponse.data;
                    setdefvariant = getresponse.setdefvariant;
                    swal({
                      title: getresponse.msg,
                      text: "Pricing is showing now for default variant !",
                      icon: 'warning'
                    });
                  }
              });

              var exist = window.location.href;
              var url = new URL(exist);
              var query_string = url.search;
              var search_params = new URLSearchParams(query_string);
              // new value of "id" is set to "101"
              $.each(setdefvariant, function(key, values){
                search_params.set(key, values);
              });
              // change the search property of the main url
              url.search = search_params.toString();
              var new_url = url.toString();
              // the new url string
              window.history.pushState('page2', 'Title', new_url);
 
         }

        
       if(response != ''){

         data = response;

       }else{

         data = defresponse;
         
       }

       var url = '{{ url('/variantimages/') }}';

       var videothumbnail = '{{ $pro->video_thumbnail }}';

       var videothumburl = "{{ url('/images/videothumbnails') }}";

       var videourl = "{{ $pro->video_preview }}";

      $('.single-product-gallery-item').html('');
        
      $('.single-product-gallery-item').append('<center><img alt="miniproductimage" src='+url+'/'+data.variantimages['image1']+' class="img zoom-img drift-demo-trigger" data-zoom='+url+'/'+data.variantimages['image1']+'></center>');

        driftzoom();


       $('.galleryContainer').html('<div id="productgalleryItems" class="owl-carousel product-galley-custom-em custom-carousel owl-theme"></div>');

       if(videothumbnail != '')
       {
         $('.product-galley-custom-em').append("<div class='provarbox' align='center'><img onclick=\"playvideo('"+videourl+"')\" alt='productimage' class=\"videothumbnail box-image\" src=\""+videothumburl+"/"+videothumbnail+ "\"></div>");

       }

         var imgarray = new Array();

         imgarray.push(data.variantimages['image1']);
         imgarray.push(data.variantimages['image2']);
         imgarray.push(data.variantimages['image3']);
         imgarray.push(data.variantimages['image4']);
         imgarray.push(data.variantimages['image5']);
         imgarray.push(data.variantimages['image6']);
         
         //Removing Null value from array 
          imgarray = imgarray.filter(function (el) {
           return el != null;
         });

         

        $(imgarray).each(function( index ) {

          $(".product-galley-custom-em").append("<div class='provarbox' align='center' onclick=\"changeImage('"+url+"/"+imgarray[index]+"')\"><img alt='productimage' class=\"box-image\" src=\""+url+"/"+imgarray[index]+ "\"></div>");

        });

       
        
        var rtl = false;

        @if(isset($selected_language) && $selected_language->rtl_available == 1)
          rtl = true;
        @endif

        var owl = $("#productgalleryItems");
          owl.owlCarousel({
              responsive:{
                0:{
                    items:3
                },
                600:{
                    items:3
                },
                1100:{
                    items:4
                }
            },
            slideSpeed : 300,
            autoPlay : true,
            smartSpeed: 1500,
            margin : 10,
            rtl : rtl,
            loop:true,
            video:true,
            nav : true,
            rewindNav: true,
            navText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"]
        });

       
      var stock = +(data['stock']);

       @php
         $commision_setting = App\CommissionSetting::first();

         if($commision_setting->type == "flat"){
            $commission_amount = $commision_setting->rate;
           if($commision_setting->p_type == 'f'){

       @endphp

       var commission = +'{{ $commission_amount }}';
       var saleprice = +'{{ $pro->vender_offer_price }}';

       var venderprice = +'{{ $pro->vender_price }}';
       var variantprice = +data['price'];

       
       @if($pro->tax_r !='')
         
         @php
           $cit = $commission_amount*$pro->tax_r/100;
           $cit = sprintf("%2.f",$cit);
         @endphp

           var cit = +'{{ $cit }}';
          
           var totalprice = venderprice + variantprice + commission + cit;

           if(saleprice != 0){
              var totalsaleprice = saleprice + variantprice + commission + cit;
           }else{
              var totalsaleprice = 0;
           }
         
       @else
         
         var totalprice = venderprice + variantprice + commission;

         if(saleprice != 0){
            var totalsaleprice = saleprice + variantprice + commission;
         }else{
            var totalsaleprice = 0;
         }

       @endif

           totalprice = Math.round(totalprice * 100) / 100;
           totalsaleprice = Math.round(totalsaleprice * 100) / 100;
           var guestpricenable = '{{$price_login}}';

           var conversion_rate = +'{{round($conversion_rate, 4)}}';
                             totalsaleprice = +totalsaleprice;

           var cartofferprice = totalsaleprice;

           totalsaleprice = totalsaleprice * conversion_rate;
           totalprice = +totalprice;

           var cartprice = totalprice;

                         totalprice = totalprice * conversion_rate;
                         totalprice = Math.round(totalprice * 100) / 100;
                         totalsaleprice = Math.round(totalsaleprice * 100) / 100;

       var login_check = '{{ Auth::check() }}';

       if (guestpricenable == "0" || login_check) {

         if(saleprice == 0)
       {
         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];

         variantprice.push(totalprice);
       }else{

         var getdisprice = totalprice-totalsaleprice;

         var xvalue = getdisprice/totalprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);


         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         if(saleprice != 0){
             $('.progress-text').html('');
             $('.progress-text').html(actualper+'% Off');
         }

         

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalsaleprice);
         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(totalsaleprice);
         variantprice.push(totalprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }
     @php
   }else{

     @endphp


       var commission = +'{{$commission_amount}}';
       var saleprice = +'{{ $pro->vender_offer_price }}';
       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];

       var totalprice = (venderprice + variantprice) * commission;
       var totalsaleprice = (saleprice + variantprice) * commission;
       var buyerprice = (venderprice + variantprice)+(totalprice/100);
      if(saleprice !=0){
         var buyersaleprice = (saleprice + variantprice)+(totalsaleprice/100);
       }else{
         var buyersaleprice = 0;
       }
       var guestpricenable = '{{ $price_login }}';
       var conversion_rate = +'{{round($conversion_rate, 4)}}';
                         buyersaleprice = +buyersaleprice;

       var cartofferprice = buyersaleprice;

                         buyersaleprice = buyersaleprice * conversion_rate;
                         buyerprice = +buyerprice;

       var cartprice = buyerprice;

                         buyerprice = buyerprice * conversion_rate;
                         buyerprice = Math.round(buyerprice * 100) / 100;
                         buyersaleprice = Math.round(buyersaleprice * 100) / 100;
          var login_check = '{{ Auth::check() }}';
       if (guestpricenable == '0' || login_check) {

       if(saleprice == 0)
       {
         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyerprice);

         variantofferprice = [];
         variantprice = [];

         variantprice.push(buyerprice);

       }else{


         var getdisprice = buyerprice-buyersaleprice;

         var xvalue = getdisprice/buyerprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);


         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyersaleprice);
         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyerprice);

         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(buyersaleprice);
         variantprice.push(buyerprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }

     @php

   }


 }
 else{
   
   $commission_cat = App\Commission::where('category_id',$pro->category_id)->first();

   if(isset($commission_cat)){

      $commission_amount = $commission_cat->rate;

   if($commission_cat->type == "f"){
     @endphp
       var commission = +'{{$commission_amount}}';
       var saleprice = +'{{ $pro->vender_offer_price }}';
       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];
      
       @if($pro->tax_r !='')
        
        @php
            $cit = $commission_amount*$pro->tax_r/100;
            $cit = sprintf("%2.f",$cit);
        @endphp

         var cit = +'{{ $cit }}';

         var totalprice = venderprice + variantprice + commission + cit;
         

         if(saleprice != 0){
           var totalsaleprice = saleprice + variantprice + commission + cit;
         }else{
           var totalsaleprice = 0;
         }
       @else
       var totalprice = venderprice + variantprice + commission;

       if(saleprice !=0){
         var totalsaleprice = saleprice + variantprice + commission;
       }else{
         var totalsaleprice = 0;
       }
       @endif

       

          

            var conversion_rate = +'{{round($conversion_rate, 4)}}';
                         totalsaleprice = +totalsaleprice;


            var cartofferprice = totalsaleprice;
            totalsaleprice = totalsaleprice * conversion_rate;
            totalprice = +totalprice;
            var cartprice = totalprice;
            totalprice = totalprice * conversion_rate;
            totalprice = Math.round(totalprice * 100) / 100;
            totalsaleprice = Math.round(totalsaleprice * 100) / 100;

       var guestpricenable = '{{$price_login}}';
       var login_check = '{{ Auth::check() }}';
       if (guestpricenable == '0' || login_check) {

         if(saleprice == 0)
       {
         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];

         variantprice.push(totalprice);
       }else{


         var getdisprice = totalprice-totalsaleprice;

         var xvalue = getdisprice/totalprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);


         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalsaleprice);
         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(totalsaleprice);
         variantprice.push(totalprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }

     @php
   }else{
     @endphp

       var commission = +'{{$commission_amount}}';
       var saleprice = +'{{ $pro->vender_offer_price }}';
       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];

       var totalprice = (venderprice + variantprice) * commission;
       var totalsaleprice = (saleprice + variantprice) * commission;
       var buyerprice = (venderprice + variantprice)+(totalprice/100);

       if(saleprice !=0){
         var buyersaleprice = (saleprice + variantprice)+(totalsaleprice/100);
       }else{
         var buyersaleprice = 0;
       }


       var conversion_rate = +'{{round($conversion_rate, 4)}}';
                         buyersaleprice = +buyersaleprice;

       var cartofferprice = buyersaleprice;

                         buyersaleprice = buyersaleprice * conversion_rate;
                         buyerprice = +buyerprice;
       var cartprice = buyerprice;
                         buyerprice = buyerprice * conversion_rate;
                         buyerprice = Math.round(buyerprice * 100) / 100;
                         buyersaleprice = Math.round(buyersaleprice * 100) / 100;

       var guestpricenable = '{{$price_login}}';
        var login_check = '{{ Auth::check() }}';

       if (guestpricenable == '0' || login_check) {

       if(saleprice == 0)
       {
         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyerprice);

         variantofferprice = [];
         variantprice = [];

         variantprice.push(buyerprice);

       }else{


         var getdisprice = buyerprice-buyersaleprice;

         var xvalue = getdisprice/buyerprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);

         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyersaleprice);
         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyerprice);

         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(buyersaleprice);
         variantprice.push(buyerprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }


     @php
   }
 }else{

   @endphp


       var saleprice = +'{{ $pro->vender_offer_price }}';
       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];

       var totalprice = venderprice + variantprice;
       if(saleprice !=0){
       var totalsaleprice = saleprice + variantprice;
       }else{
         var totalsaleprice = 0;
       }
           totalprice = Math.round(totalprice * 100) / 100;
           totalsaleprice = Math.round(totalsaleprice * 100) / 100;
       var guestpricenable = '{{$price_login}}';

       var conversion_rate = +'{{round($conversion_rate, 4)}}';
                         totalsaleprice = +totalsaleprice;
       var cartofferprice = totalsaleprice;

                         totalsaleprice = totalsaleprice * conversion_rate;
                         totalprice = +totalprice;

       var cartprice = totalprice;
                         totalprice = totalprice * conversion_rate;
                         totalprice = Math.round(totalprice * 100) / 100;
                         totalsaleprice = Math.round(totalsaleprice * 100) / 100;

        var login_check = '{{ Auth::check() }}';

       if (guestpricenable == '0' || login_check) {

         if(saleprice == 0)
       {
         
         $('.dtl-price-main').html("<i class='{{session()->get('currency')['value']}}'></i>"+totalprice);
         variantofferprice = [];
         variantprice = [];

         variantprice.push(totalprice);
       }else{

         var getdisprice = totalprice-totalsaleprice;

         var xvalue = getdisprice/totalprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);


         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').append("<i class='{{ session()->get('currency')['value'] }}'></i>"+" "+totalsaleprice);
         $('.dtl-price-strike-main').html("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(totalsaleprice);
         variantprice.push(totalprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }

   @php

 }
 }
@endphp


       
       var selling_date = '{{$pro->selling_start_at}}';
      
       var current_date = '{{date("Y-m-d H:i:s")}}';


       varid = [];
       varid.push(data['id']);


       if(variantofferprice.length == 0){
         variantofferprice = [];
         variantofferprice.push(0);
       }



       if(selling_date <= current_date){
         if(stock > 0 && stock <= 5)
                 {


                   $('.stockval').text("Hurry Up ! Only "+data['stock']+" left");

                   $('.quantity-container').html('<div><div class="qty-count"><form action="" method="post">{{ csrf_field() }}<div><div class="cart-quantity"><div class="quant-input"></div></div><div class="add-btn"><button type="submit" class="btn btn-primary">{{ __('staticwords.AddtoCart') }}</button></div></div></form></div>');
                   $('#cartForm').append('<form action="" method="post">{{ csrf_field() }} <button type="submit" class="btn btn-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART <span class="sr-only">(current)</span></button></form>');
                 }
                 else if(stock == 0){

                   $('.notifymeblock').html('<button type="button" data-target="#notifyMe" data-toggle="modal" class="m-1 p-2 btn btn-md btn-block btn-primary">NOTIFY ME</button>');
                   $('.notifyForm').attr('action','{{ url("/subscribe/for/product/stock") }}/'+data['id']);

                   $('.stockval').text("Out of Stock");
                   $('.quantity-container').remove();
                   $('.quantity-container form').remove();
                   $('#cartForm').append('<button class="btn btn btn-cart-oos"><i class="fa fa-shopping-cart" aria-hidden="true"></i> OUT OF STOCK <span class="sr-only">(current)</span></button>');

                 }else{
                   @if($price_login != 1)
                   $('.stockval').text("In Stock");
                    $('.quantity-container').html('<div><div class="qty-count"><form action="" method="post">{{ csrf_field() }}<div><div class="cart-quantity"><div class="quant-input"></div></div><div class="add-btn"><button type="submit" class="btn btn-primary">{{ __('staticwords.AddtoCart') }}</button></div></div></form></div>');
                    $('#cartForm').append('<form action="" method="post">{{ csrf_field() }} <button type="submit" class="btn btn-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{ __('staticwords.AddtoCart') }} <span class="sr-only">(current)</span></button></form>');
                   @endif
                 }
       }else{
          $('.stockval').text("Coming Soon !");
          $('.quantity-block').hide();
       }



     $('.quant-input').html('<input type="number" id="nmovimentos" name="quantity" value="'+data['min_order_qty']+'" min="'+data['min_order_qty']+'" max="'+data['stock']+'" maxorders="'+data['max_order_qty']+'">');

      $('.quant-input').html('');
      $('.quant-input').append('<input type="number" value="'+data['min_order_qty']+'" min="'+data['min_order_qty']+'" max="'+data['stock']+'" maxorders="'+data['max_order_qty']+'" value="1" class="qty-section">');

     varqty =  [];
     var tx = $('.quant-input input').val();
     varqty.push(tx);
     var formurl = '{{ url("add_item/$pro->id")}}/'+varid+'/'+cartprice+'/'+cartofferprice+'/'+varqty;

     $('.quantity-container form').attr("action",formurl);
     $('#cartForm form').attr("action",formurl);

     @auth 
     checkwish(varid);

     @endauth

     $(".quant-input input").on('change',function(){

         var newValue = +$(this).val();
         var stock = +$(this).attr('max');
         var minOrder = +$(this).attr('min');
         var maxOrder = +$(this).attr('maxorders');

         varqty = [];

         varqty.push(newValue);

         var formurl;

          

         if(newValue > maxOrder ){
              swal({
               title: "Sorry !",
               text: 'Product maximum quantity limit is '+maxOrder,
               icon: 'warning'
             });
              $(this).val(maxOrder);
                formurl = '{{ url("add_item/$pro->id")}}/'+varid+'/'+cartprice+'/'+cartofferprice+'/'+maxOrder;
         
               $('.quantity-container form').attr("action",formurl);
               $('#cartForm form').attr("action",formurl);     
              return false;
         }


         if (stock == 0)
         {
             swal({
               title: "Stock Out !",
               text: 'Product is out of stock !',
               icon: 'error'
             });

             formurl = '{{ url("add_item/$pro->id")}}/'+varid+'/'+cartprice+'/'+cartofferprice+'/'+varqty;
         
             $('.quantity-container form').attr("action",formurl);
             $('#cartForm form').attr("action",formurl);     
             return false;
         }

         if(newValue < minOrder){
             swal({
               title: "Sorry !",
               text: 'Product minimum quantity must is '+minOrder,
               icon: 'warning'
             });
             $(this).val(minOrder);
             formurl = '{{ url("add_item/$pro->id")}}/'+varid+'/'+cartprice+'/'+cartofferprice+'/'+minOrder;
             $('.quantity-container form').attr("action",formurl);
             $('#cartForm form').attr("action",formurl);     
             return false;
         }

         formurl = '{{ url("add_item/$pro->id")}}/'+varid+'/'+cartprice+'/'+cartofferprice+'/'+varqty;
         
         $('.quantity-container form').attr("action",formurl);
         $('#cartForm form').attr("action",formurl);     

       });


       $(".full_var_box div").each(function(i){
          $(this).parent().css('display','block');
       });

        
        
         
           $('#pro_section').html('');
           $('#pro_section').append('<div id="pro-img"></div><div id="pro-title"></div>');
           $('#pro-img').append('<img alt="miniproductimage" height="30px" alt="product_img" src='+url+'/'+data.variantimages['image1']+' title="{{ $pro->name }} ('+u2+')">');

           
           
           var countslide = 0;
           $(imgarray).each(function(index){
               
                 countslide++;
                  
           });

           if(countslide > 3){
             countslide = 3;
           }
         for(var i=0; i<u.length; i++) {
               
               var tech = getUrlParameter(u[i]);
                $('.xyz').each(function(index){
                 var a2 = $(this).attr('val');

                 if(a2 == tech){

                       $(this).css({"border" : "1.5px solid rgb(20, 126, 210)"});
                       $(this).attr('s', "1");

                 }

               });

           }



           $('.xyz').each(function(index){
               var t = $(this).attr('s');

             if(t == 1){
               u2.push($(this).attr('valname'));
             }

           });

           $('.productVars').text(" ( "+u2+" ) ");
           $('title').append('&nbsp;('+u2+')');
           $('#pro-title').append('{{ $pro->name }}&nbsp;('+u2+')');
     }

         

       
 });

});



//change variant function 

function tagfilter(d,attr,indexNum){

     

     var exist=window.location.href;

     var url = new URL(exist);

     var query_string = url.search;

     var search_params = new URLSearchParams(query_string);

     search_params.set(d, attr);

     // change the search property of the main url
     url.search = search_params.toString();
     var u=[];
     var u2 =[];
     var attrId = [];
     // the new url string
     var new_url = url.toString();

      $('.xyz').each(function(index){
       var t = $(this).attr('s');


       if(t==1)
       {
         u.push($(this).attr('name'));
         attrId.push($(this).attr('attr_id'));
       }
       
      });


     window.history.pushState('page2', 'Title', new_url);

     var getUrlParameter = function getUrlParameter(sParam) {
         var sPageURL = window.location.search.substring(1),
             sURLVariables = sPageURL.split('&'),
             sParameterName,
             i;

         for (i = 0; i < sURLVariables.length; i++) {
             sParameterName = sURLVariables[i].split('=');

             if (sParameterName[0] === sParam) {
                 return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
             }
         }
     };

     var arr = [];
     var arr2 = [];
     for (var i =0; i<u.length; i++) {

        var tech = getUrlParameter(u[i]);
        arr2.push({key: attrId[i], value: tech});

     }

     arr.push(arr2);
      $.ajax({
       url:"{{ url('onclickloadvariant/'.$pro->id)}}",
       method:'GET',
       datatype:'html',
       data: {attr_name: d, value: attr, arr : arr2},

       success:function(data)
       {

       var saleprice = +'{{ $pro->vender_offer_price }}';



        
       @php
         $commision_setting = App\CommissionSetting::first();

         if($commision_setting->type == "flat"){
            $commission_amount = $commision_setting->rate;
           if($commision_setting->p_type == 'f'){

       @endphp

       var commission = +'{{$commission_amount}}';
       var saleprice = +'{{ $pro->vender_offer_price }}';

       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];

       
       @if($pro->tax_r !='')
         
         @php
           $cit = $commission_amount*$value->pro->tax_r/100;
           $cit = sprintf("%2.f",$cit);
         @endphp

           var cit = +'{{ $cit }}';
          
           var totalprice = venderprice + variantprice + commission + cit;

           if(saleprice != 0){
              var totalsaleprice = saleprice + variantprice + commission + cit;
           }else{
              var totalsaleprice = 0;
           }
         
       @else
         
         var totalprice = venderprice + variantprice + commission;

         if(saleprice != 0){
            var totalsaleprice = saleprice + variantprice + commission;
         }else{
            var totalsaleprice = 0;
         }

       @endif

           totalprice = Math.round(totalprice * 100) / 100;
           totalsaleprice = Math.round(totalsaleprice * 100) / 100;
           var guestpricenable = '{{$price_login}}';

           var conversion_rate = +'{{round($conversion_rate, 4)}}';
                             totalsaleprice = +totalsaleprice;

           var cartofferprice = totalsaleprice;

           totalsaleprice = totalsaleprice * conversion_rate;
           totalprice = +totalprice;

           var cartprice = totalprice;

                         totalprice = totalprice * conversion_rate;
                         totalprice = Math.round(totalprice * 100) / 100;
                         totalsaleprice = Math.round(totalsaleprice * 100) / 100;

       var login_check = '{{ Auth::check() }}';

       if (guestpricenable == "0" || login_check) {

         if(saleprice == 0)
       {
         $('.dtl-price-main').html('');
         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];

         variantprice.push(totalprice);
       }else{

         var getdisprice = totalprice-totalsaleprice;

         var xvalue = getdisprice/totalprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);


         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').html('');

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalsaleprice);

         $('.dtl-price-strike-main').html('');

         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(totalsaleprice);
         variantprice.push(totalprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }
     @php
   }else{

     @endphp



       var commission = +'{{$commission_amount}}';



       @if($pro->vender_offer_price !=0 || $pro->vender_offer_price !='' || $pro->vender_offer_price != null)
         var saleprice = +'{{ $pro->vender_offer_price }}';
       @else
         var saleprice = 0;
       @endif


       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];


       var totalprice = (venderprice + variantprice) * commission;

       if(saleprice != 0){
         var totalsaleprice = (saleprice + variantprice) * commission;
       }else{
         var totalsaleprice = 0;
       }


       var buyerprice = (venderprice + variantprice)+(totalprice/100);
       if(saleprice != 0){
           var buyersaleprice = (saleprice + variantprice)+(totalsaleprice/100);
       }else{
           var buyersaleprice =  0;
       }

       var guestpricenable = '{{ $price_login }}';
       var conversion_rate = +'{{round($conversion_rate, 4)}}';
                         buyersaleprice = +buyersaleprice;
       var cartofferprice = buyersaleprice;
                         buyersaleprice = buyersaleprice * conversion_rate;
                         buyerprice = +buyerprice;
       var cartprice = buyerprice;
                         buyerprice = buyerprice * conversion_rate;
                         buyerprice = Math.round(buyerprice * 100) / 100;
                         buyersaleprice = Math.round(buyersaleprice * 100) / 100;
          var login_check = '{{ Auth::check() }}';
       if (guestpricenable == '0' || login_check) {

       if(saleprice == 0)
       {
         $('.dtl-price-main').html('');
         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyerprice);

         variantofferprice = [];
         variantprice = [];

         variantprice.push(buyerprice);

       }else{


         var getdisprice = buyerprice-buyersaleprice;

         var xvalue = getdisprice/buyerprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);


         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').html('');
         $('.dtl-price-strike-main').html('');

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyersaleprice);
         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyerprice);

         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(buyersaleprice);
         variantprice.push(buyerprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }

     @php

   }


 }
 else{
   $commission_cat = App\Commission::where('category_id',$pro->category_id)->first();
   if(isset($commission_cat)){
      $commission_amount = $commission_cat->rate;
   if($commission_cat->type == "f"){
     @endphp
       var commission = +'{{$commission_amount}}';
       var saleprice = +'{{ $pro->vender_offer_price }}';
       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];
     
     @if($pro->tax_r !='')

       @php

         $cit = $commission_amount*$pro->tax_r/100;

       @endphp

       var cit = +'{{ $cit }}';

       var totalprice = venderprice + variantprice + commission + cit;

       if(saleprice !=0){
         var totalsaleprice = saleprice + variantprice + commission + cit;
       }else{
         var totalsaleprice = 0;
       }

     @else

       var totalprice = venderprice + variantprice + commission;

       if(saleprice !=0){
         var totalsaleprice = saleprice + variantprice + commission;
       }else{
         var totalsaleprice = 0;
       }
    @endif
           totalprice = Math.round(totalprice * 100) / 100;
           totalsaleprice = Math.round(totalsaleprice * 100) / 100;


            var conversion_rate = +'{{round($conversion_rate, 4)}}';
                         totalsaleprice = +totalsaleprice;
            var cartofferprice = totalsaleprice;
                         totalsaleprice = totalsaleprice * conversion_rate;
                         totalprice = +totalprice;
            var cartprice = totalprice;
                         totalprice = totalprice * conversion_rate;
                         totalprice = Math.round(totalprice * 100) / 100;
                         totalsaleprice = Math.round(totalsaleprice * 100) / 100;

       var guestpricenable = '{{$price_login}}';
       var login_check = '{{ Auth::check() }}';
       if (guestpricenable == '0' || login_check) {

         if(saleprice == 0)
       {
         $('.dtl-price-main').html('');
         $('.dtl-price-main').html("<i class='{{session()->get('currency')['value']}}'></i>"+totalprice);
         variantofferprice = [];
         variantprice = [];

         variantprice.push(totalprice);
       }else{


         var getdisprice = totalprice-totalsaleprice;

         var xvalue = getdisprice/totalprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);


         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').html('');
         $('.dtl-price-strike-main').html('');

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalsaleprice);
         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(totalsaleprice);
         variantprice.push(totalprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }

     @php
   }else{
     @endphp

       var commission = +'{{$commission_amount}}';

       @if($pro->vender_offer_price !=0 || $pro->vender_offer_price !='' || $pro->vender_offer_price != null)
         var saleprice = +'{{ $pro->vender_offer_price }}';
       @else
         var saleprice = 0;
       @endif

       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];

       var totalprice = (venderprice + variantprice) * commission;
       if(saleprice != 0){
         var totalsaleprice = (saleprice + variantprice) * commission;
       }else{
         var totalsaleprice = 0;
       }


       var buyerprice = (venderprice + variantprice)+(totalprice/100);

         if(saleprice != 0){
           var buyersaleprice = (saleprice + variantprice)+(totalsaleprice/100);
         }else{
           var buyersaleprice = 0;
         }

       var conversion_rate = +'{{round($conversion_rate, 4)}}';
                         buyersaleprice = +buyersaleprice;
       var cartofferprice = buyersaleprice;

                         buyersaleprice = buyersaleprice * conversion_rate;
                         buyerprice = +buyerprice;
       var cartprice = buyerprice;
                         buyerprice = buyerprice * conversion_rate;
                         buyerprice = Math.round(buyerprice * 100) / 100;
                         buyersaleprice = Math.round(buyersaleprice * 100) / 100;

       var guestpricenable = '{{$price_login}}';
        var login_check = '{{ Auth::check() }}';

       if (guestpricenable == '0' || login_check) {

       if(saleprice == 0)
       {
         $('.dtl-price-main').html('');

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyerprice);

         variantofferprice = [];
         variantprice = [];

         variantprice.push(buyerprice);

       }else{


         var getdisprice = buyerprice-buyersaleprice;

         var xvalue = getdisprice/buyerprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);

         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').html('');
         $('.dtl-price-strike-main').html('');

         $('.dtl-price-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyersaleprice);
         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+buyerprice);

         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(buyersaleprice);
         variantprice.push(buyerprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }


     @php
   }
 }else{

   @endphp


       @if($pro->vender_offer_price !=0 || $pro->vender_offer_price !='' || $pro->vender_offer_price != null)
         var saleprice = +'{{ $pro->vender_offer_price }}';
       @else
         var saleprice = 0;
       @endif

       var venderprice = +'{{$pro->vender_price}}';
       var variantprice = +data['price'];

       var totalprice = venderprice + variantprice;

       if(saleprice !=0){
         var totalsaleprice = saleprice + variantprice;
       }else{
         var totalsaleprice = 0;
       }

           totalprice = Math.round(totalprice * 100) / 100;
           totalsaleprice = Math.round(totalsaleprice * 100) / 100;
       var guestpricenable = '{{$price_login}}';

        var conversion_rate = +'{{round($conversion_rate, 4)}}';
                         totalsaleprice = +totalsaleprice;
        var cartofferprice = totalsaleprice;

                         totalsaleprice = totalsaleprice * conversion_rate;
                         totalprice = +totalprice;
        var cartprice = totalprice;
                         totalprice = totalprice * conversion_rate;
                         totalprice = Math.round(totalprice * 100) / 100;
                         totalsaleprice = Math.round(totalsaleprice * 100) / 100;

        var login_check = '{{ Auth::check() }}';

       if (guestpricenable == '0' || login_check) {

         if(saleprice == 0)
       {

         $('.dtl-price-main').html('');

         $('.dtl-price-main').text("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];

         variantprice.push(totalprice);
       }else{

         var getdisprice = totalprice-totalsaleprice;

         var xvalue = getdisprice/totalprice;

         var dpercent = xvalue*100;

         var actualper = Math.round(dpercent);


         $('.progress-bar').attr('aria-valuenow',actualper);

         $('.progress-bar').css('width',actualper+'%');

         $('.progress-text').html('');

         $('.progress-text').html(actualper+'% Off');

         $('.dtl-price-main').html('');
         $('.dtl-price-strike-main').html('');

         $('.dtl-price-main').append("<i class='{{ session()->get('currency')['value'] }}'></i>"+" "+totalsaleprice);
         $('.dtl-price-strike-main').append("<i class='{{session()->get('currency')['value']}}'></i>"+" "+totalprice);
         variantofferprice = [];
         variantprice = [];
         variantofferprice.push(totalsaleprice);
         variantprice.push(totalprice);
       }

       }else{
         $('.dtl-price-main').text('Login to view price');
       }

   @php

 }
 }
@endphp


         $('.xyz').each(function(index){
           var x = $(this).attr('s');
           var y = $(this).attr('name');
           var z = $("#"+d+attr).attr('s');

           if(y==d)
           {
             $(this).attr('s',0);
            $("#"+d+attr).attr('s', 1);
             var a = $("#"+d+attr).attr('s');
             if(a == 1){
               $(this).css({"border" : "1.5px solid rgb(209 207 207)"});

               $("#"+d+attr).css({"border" : "1.5px solid rgb(20, 126, 210)"});

                   $('.xyz').each(function(index){
               var t = $(this).attr('s');
               var varName = $(this).parent().attr('s');
             if(t == 1){
               var id = d+attr;
               var checkId = $(this).attr('id');
               if(id == checkId){
                var start_index = indexNum;
                var number_of_elements_to_remove = 2;
                   var removed_elements = u2.splice(start_index, number_of_elements_to_remove)

               }
               else{
                 u2.push($(this).attr('valname'));
               }

             }

           });


             }


           }


         });

     u2.splice(indexNum, 0, $("#"+d+attr).attr('valname'));
     varid = [];
     varid.push(data['id']);


         if(data != ''){

          var url = '{{ url('/variantimages/') }}';
          
          $('.single-product-gallery-item').html('');

          var url = '{{ url('/variantimages/') }}';

          var videothumbnail = '{{ $pro->video_thumbnail }}';

          var videothumburl = "{{ url('/images/videothumbnails') }}";

          var videourl = "{{ $pro->video_preview }}";

          $('.single-product-gallery-item').html('');
          
          $('.single-product-gallery-item').append('<center><img alt="miniproductimage" src='+url+'/'+data.variantimages['image1']+' class="img zoom-img drift-demo-trigger" data-zoom='+url+'/'+data.variantimages['image1']+'></center>');

          driftzoom();


          $('.galleryContainer').html('<div id="productgalleryItems" class="owl-carousel product-galley-custom-em custom-carousel owl-theme"></div>');

          if(videothumbnail != '')
          {
            $('.product-galley-custom-em').append("<div class='provarbox' align='center'><img onclick=\"playvideo('"+videourl+"')\" alt='productimage' class=\"videothumbnail box-image\" src=\""+videothumburl+"/"+videothumbnail+ "\"></div>");

          }
        
  
           var imgarray = new Array();
  
           imgarray.push(data.variantimages['image1']);
           imgarray.push(data.variantimages['image2']);
           imgarray.push(data.variantimages['image3']);
           imgarray.push(data.variantimages['image4']);
           imgarray.push(data.variantimages['image5']);
           imgarray.push(data.variantimages['image6']);
  
           //Removing Null value from array 
            imgarray = imgarray.filter(function (el) {
             return el != null;
           });
  
           
  
          $(imgarray).each(function( index ) {
  
            $(".product-galley-custom-em").append("<div class='provarbox' align='center' onclick=\"changeImage('"+url+"/"+imgarray[index]+"')\"><img alt='productimage' class=\"box-image img-fluid\" src=\""+url+"/"+imgarray[index]+ "\"></div>");
  
          });

          var rtl = false;

          @if(isset($selected_language) && $selected_language->rtl_available == 1)
            rtl = true;
          @endif
  
          var owl = $("#productgalleryItems");
            owl.owlCarousel({
                responsive:{
                  0:{
                      items:3
                  },
                  600:{
                      items:3
                  },
                  1100:{
                      items:4
                  }
              },
              slideSpeed : 300,
              autoPlay : true,
              smartSpeed: 1500,
              margin : 10,
              nav : true,
              rtl : rtl,
              loop : true,
              rewindNav: true,
              navText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"]
          });
         

           $('#pro_section').html('');
           $('#pro_section').append('<div id="pro-img"></div><div id="pro-title"></div>');
           $('#pro-img').append('<img alt="miniproductimage" height="30px" alt="product_img" src='+url+'/'+data.variantimages['image1']+' title="{{ $pro->name }} ('+u2+')">');

          


         }else{  

         }

         if(variantofferprice.length == 0){
           variantofferprice = [];
           variantofferprice.push(0);
         }
        var stock = +(data['stock']);


        var formurl = '{{ url("add_item/$pro->id")}}/'+varid+'/'+cartprice+'/'+cartofferprice+'/'+varqty;

        if(stock > 0 && stock <= 5)
         {
           @if($price_login != 1)
           $('.stockval').text("Hurry Up ! Only "+data['stock']+" left");
            $('.quantity-container').html('<div><div class="qty-count"><form action="'+formurl+'" method="post">{{ csrf_field() }}<div><div class="cart-quantity"><div class="quant-input"></div></div><div class="add-btn"><button type="submit" class="btn btn-primary">Add to Cart</button></div></div></form></div>');
             $('#cartForm').html('');
             $('#cartForm').append('<form action="'+formurl+'" method="post">{{ csrf_field() }} <button type="submit" class="btn btn-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART <span class="sr-only">(current)</span></button></form>');
           @endif

           $('.notifymeblock').html('');
         }
         else if(stock == 0){

          $('.notifymeblock').html('<button type="button" data-target="#notifyMe" data-toggle="modal" class="m-1 p-2 btn btn-md btn-block btn-primary">NOTIFY ME</button>');
          $('.notifyForm').attr('action','{{ url("/subscribe/for/product/stock") }}/'+data['id']);

           $('.stockval').text("Out of Stock");
           $('.quantity-container').remove();
           $('.quantity-container form').remove();
           $('#cartForm').html('');
           $('#cartForm').append('<button class="btn btn-cart-oos"><i class="fa fa-info-circle" aria-hidden="true"></i> OUT OF STOCK <span class="sr-only">(current)</span></button>');

         }else{
           $('.notifymeblock').html('');
           $('.stockval').text("In Stock");
           @if($price_login != 1)
             $('.qty-parent-cont').html('<div class="quantity-container"></div>');

             $('.quantity-container').html('<div><div class="qty-count"><form action="'+formurl+'" method="post">{{ csrf_field() }}<div><div class="cart-quantity"><div class="quant-input"></div></div><div class="add-btn"><button type="submit" class="btn btn-primary">Add to Cart</button></div></div></form></div>');



            $('#cartForm').html('');

            $('#cartForm').append('<form action="'+formurl+'" method="post">{{ csrf_field() }} <button type="submit" class="btn btn-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART <span class="sr-only">(current)</span></button></form>');
            @endif
         }

         $('.quant-input').html('<input type="number" id="nmovimentos" name="quantity" value="'+data['min_order_qty']+'" min="'+data['min_order_qty']+'" max="'+data['stock']+'" maxorders="'+data['max_order_qty']+'">');

         $('.quant-input').html('');
         $('.quant-input').append('<input type="number" value="'+data['min_order_qty']+'" min="'+data['min_order_qty']+'" max="'+data['stock']+'" maxorders="'+data['max_order_qty']+'" value="1" class="qty-section">');
     @auth
     checkwish(varid);
     @endauth

      $(".quant-input input").on('change',function(){

         var newValue = +$(this).val();
         var stock = +$(this).attr('max');
         var minOrder = +$(this).attr('min');
         var maxOrder = +$(this).attr('maxorders');

       

         if(newValue > maxOrder ){
              swal({
               title: "Sorry !",
               text: 'Product maximum quantity limit reached !',
               icon: 'warning'
             });
              $(this).val(maxOrder);
              return false;
         }


         if (stock == 0)
         {
             swal({
               title: "Stock Out !",
               text: 'Product is out of stock !',
               icon: 'error'
             });
             return false;
         }

         if(newValue < minOrder){
             swal({
               title: "Sorry !",
               text: 'Product minimum quantity limit reached !',
               icon: 'warning'
             });
             $(this).val(min);
             return false;
         }

         varqty = [];

         varqty.push(newValue);

         var formurl = '{{ url("add_item/$pro->id")}}/'+varid+'/'+cartprice+'/'+cartofferprice+'/'+varqty;

         $('.quantity-container form').attr("action",formurl);
         $('#cartForm form').attr("action",formurl);
        

       });


       shareURL();
      
       $('.xyz').each(function(index){
               var t = $(this).attr('s');

             if(t == 1){
               u2.push($(this).attr('valname'));
             }

           });

           var uniqueArray = getUnique(u2);

       $('.productVars').text(" ( "+uniqueArray+" ) ");
       var title = '{{$title}}';
       var producttitle = '{{ $pro->name }}';
       $('title').text(title+' - '+producttitle+' ('+uniqueArray+')');
       $('#pro-title').html('{{ $pro->name }}&nbsp;('+uniqueArray+')');
       if (data == "") {

            

             $('.dtl-price-main').html('Product Option Not Available');
             $('.progress-text').hide();
             $('.progress').hide();
             $('.dtl-price-strike-main').html('');
             
             if(indexNum == 0){
               $('.stockval').text("Not Available");
                $('.quantity-container form').remove();
               swal({
                       title: "Sorry !",
                       text: ""+uniqueArray[0]+" Not Available In "+uniqueArray[1]+"",
                       icon: "warning"
                     });
             }else{
               $('.stockval').text("Not Available");

                 swal({
                       title: "Sorry !",
                       text: "" +uniqueArray[1]+" Not Available In " +uniqueArray[0]+"",
                       icon: "warning"
                     });
             }

         }else{

         }

       } //success function close
   });//ajax function close
}//main function closed

function getUnique(array){
        var uniqueArray = [];
        
        // Loop through array values
        for(i=0; i < array.length; i++){
            if(uniqueArray.indexOf(array[i]) === -1) {
                uniqueArray.push(array[i]);
            }
        }
        return uniqueArray;
}



function driftzoom(){

    

    new Drift(document.querySelector('.drift-demo-trigger'), {
     paneContainer: document.querySelector('#details-container'),
     inlinePane: 500,
     inlineOffsetY: -85,
     containInline: true,
     hoverBoundingBox: true,
     zoomFactor: 3,
     handleTouch: true,
     showWhitespaceAtEdges: false
   });

 }

  function checkwish(varid){
    
   var wishurl = '{{ url("AddToWishList/") }}/'+varid;
   var removeWishUrl = '{{ url('removeWishList') }}/'+varid;
    $.ajax({
       method : "GET",
       url  : "{{ url('check/variant/inwish') }}",
       data : {varid : varid},

       success : function(data){

          if(data == 'InWish'){

           $('.favorite-button-box').html('');
           
            $('.favorite-button-box').append('<a mainid="' + varid + '" data-remove="'+removeWishUrl+'" class="btn btn-primary removeFrmWish bg-primary" data-toggle="tooltip" data-placement="right" title="Remove From Wishlist" href="#"><i class="fa fa-heart"></i></a>');
          
          }else{
            $('.favorite-button-box').html('');
          
            $('.favorite-button-box').append('<a mainid="' + varid + '" data-add="'+wishurl+'" class="btn btn-primary addtowish" data-toggle="tooltip" data-placement="right" title="Add to Wishlist" href="#"><i class="fa fa-heart"></i></a>');
            
          }

           
       }
    });
 }


 </script>