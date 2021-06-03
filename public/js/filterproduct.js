"use strict";

  var minVal;
  var maxVal;

  $(document).ready(function(){
    
    $('.kdrop').css({'margin-left' : '-190px'});

  })

  var lprice = +lprice;
  lprice = lprice.toFixed(2);
  var hprice = +hprice;
  hprice = hprice.toFixed(2);
  if (lprice == hprice) {
      lprice = 0;
  }
  minVal = lprice;
  maxVal = hprice;

  var brandAvl = brandAvl;
  var sliding  = sliding;
  var tag_chk  = tag_chk;

if (tag_chk == "yes") {
      $('#amountstart').val(minVal);
      $('#amountend').val(maxVal);
      var exist = window.location.href;
      var url = new URL(exist);
      var query_string = url.search;
      var search_params = new URLSearchParams(query_string);
      search_params.set('start', lprice);
      search_params.set('end', hprice);
      url.search = search_params.toString();
      var new_url = url.toString();

      window.history.pushState('page2', 'Title', new_url);
}