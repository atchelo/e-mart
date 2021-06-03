"use strict";
// Define your library strictly...
$(function() {
  $('.my-colorpicker2').colorpicker();
  $('.my-colorpicker').colorpicker();
});
$("#adImage").on('change', function() {
  readURL1(this);
});

function readURL1(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#adPreview').attr('src', e.target.result).css({
        'width': '200px',
        'height': '200px'
      });
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$('.show_btn').on('change', function() {
  if($(this).is(':checked')) {
    $('#buttongroup').show('slow');
  } else {
    $('#buttongroup').hide('slow');
  }
});
$('#linkby').on('change', function() {
  var opt = $(this).val();
  if(opt == 'adsense') {
    $('#customad').hide();
  } else {
    $('#customad').show();
  }
  if(opt != 'adsense') {
    $('#adsenseBox').hide();
  } else {
    $('#adsenseBox').show();
  }
  if(opt == 'category') {
    $('#probox,#urlbox').hide();
    $('#catbox').show();
  }
  if(opt == 'detail') {
    $('#probox').show();
    $('#linkedPro').show();
    $('#catbox,#urlbox').hide();
  }
  if(opt == 'url') {
    $('#probox').hide();
    $('#catbox').hide();
    $('#urlbox').show();
  }
});
$('#position').on('change', function() {
  var opt = $('#position').val();
  if(opt == 'category') {
    $('#linkedPro').hide();
    $('#linkedCat').show();
  } else {
    $('#linkedPro').show();
    $('#linkedCat').hide();
  }
});