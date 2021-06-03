"use strict";

$(function () {
      $("#paypal_email").hide();
      $("#paytem_mobile").hide();
});

function valueChanged() {
      if($('.paypal').is(":checked")) $("#paypal_email").show("slow");
      else $("#paypal_email").hide();
      if($('.paytem').is(":checked")) $("#paytem_mobile").show("slow");
      else $("#paytem_mobile").hide();
}

$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

