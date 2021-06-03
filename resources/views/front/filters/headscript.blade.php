<script>


"use strict";
var tagsarray = new Array();
var brandsArr = new Array();
var variantArray = new Array();
var attrArray = new Array();
var url404 = "{{ url('images/nocart.jpg') }}";
$(function () {
    
  $(window).on('load',function() {
    $('.preL').fadeOut('fast');
    $('.preloader3').fadeOut('fast');
  });

  var lprice = +'{{$first_cat * round($conversion_rate, 4)}}';
  lprice = lprice.toFixed(2);
  var hprice = +'{{$last_cat * round($conversion_rate, 4)}}';
  hprice = hprice.toFixed(2);
  if(lprice == hprice) {
    lprice = 0;
  }
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
    for(i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');
      if(sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };
  var r = '{{ $conversion_rate }}';
  var start = getUrlParameter('start');
  var end = getUrlParameter('end');
  var prevCur = '{{ Session::get('previous_cur') }}';
  var currntCur = '{{ Session::get('current_cur') }}';
  var curchange = '{{ Session::get('currencyChanged') }}';
  var tag = getUrlParameter('tag');
  var category = getUrlParameter('category');
  var sid = getUrlParameter('sid');
  var chid = getUrlParameter('chid');
  var brandsVal = getUrlParameter('brands');
  var varValue = getUrlParameter('varValue');
  var varType = getUrlParameter('varType');
  var rating = getUrlParameter('ratings');
  var featured_check = getUrlParameter('featured');
  var keyword = getUrlParameter('keyword');
  var outki = getUrlParameter('oot');

  if(featured_check == 1) {
    $('#feapro').attr('checked', true)
  }

  if(outki == 1) {
    $('#exoot').attr('checked', true)
  }

  $('#rat_pro' + rating).attr('checked', true);
  if(varValue === undefined) {} else {
    variantArray = varValue.split(',');
  }
  if(varType === undefined) {} else {
    attrArray = varType.split(',');
  }
  $(variantArray).each(function(i) {
    $('.var_check_all').each(function(j) {
      var vVal = $(this).val();
      if(vVal == variantArray[i]) {
        $(this).prop('checked', true);
      }
    });
  });
  if(brandsVal === undefined) {} else {
    brandsArr = brandsVal.split(',');
  }
  $(brandsArr).each(function(i) {
    $('.brand_check').each(function(j) {
      var bVal = $(this).val();
      if(bVal == brandsArr[i]) {
        $(this).prop('checked', true);
      }
    });
  });
  if(tag === undefined) {} else {
    tagsarray = tag.split(',');
  }
  $(tagsarray).each(function(i) {
    $('.pro-tags-all').each(function(j) {
      var get_tag = $(this).attr('name');
      if(get_tag == tagsarray[i]) {
        $(this).addClass('active');
      }
    });
  });
  if(prevCur != currntCur && curchange == 'yes') {

    var exist = window.location.href;
    var url = new URL(exist);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    // new value of "id" is set to "101"
    search_params.set('start', lprice);
    search_params.set('end', hprice);
    // change the search property of the main url
    url.search = search_params.toString();
    var new_url = url.toString();
    // the new url string
    window.history.pushState('page2', 'Title', new_url);
    @php
    $newStatus = 'no';
    Session::put('currencyChanged', $newStatus);
    @endphp
   
    $('#amountstart').val(lprice);
    $('#amountend').val(hprice);
    $("#slider-range").slider({
      range: true,
      orientation: "horizontal",
      min: Number(lprice),
      max: Number(hprice),
      values: [Number(lprice), Number(hprice)],
      step: 0.1,
      slide: function(event, ui) {
        
      },
      stop: function(event,ui){
        if(ui.values[0] == ui.values[1]) {
          return false;
        }
        $("#amountstart").val(ui.values[0].toFixed(2));
        $("#amountend").val(ui.values[1].toFixed(2));
        priceslider(category, sid, chid);
      }
    });
  } else {
    
    $('#amountstart').val(start);
    $('#amountend').val(end);
    $("#slider-range").slider({
      range: true,
      orientation: "horizontal",
      min: Number(start),
      max: Number(end),
      values: [Number(start), Number(end)],
      step: 0.1,
      slide: function(event, ui) {
        
      },

      stop : function(event,ui){
        if(ui.values[0] == ui.values[1]) {
          return false;
        }
        $("#amountstart").val(ui.values[0].toFixed(2));
        $("#amountend").val(ui.values[1].toFixed(2));
        priceslider(category, sid, chid);
      }
    });
  }
}); 

</script>