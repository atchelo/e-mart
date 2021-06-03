"use strict";
// Define your library strictly...
$('#password, #confirm_password').on('keyup', function() {
  if($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Password Matched').css('color', 'green').show();
  } else $('#message').html('Password Not Matching').css('color', 'red').show();
});
$('#btn_reset').on('click', function() {
  document.getElementById("form1").reset();
  $('#message').hide();
});

function showMore(orderid) {
  $('#expandThis' + orderid).toggle('fast');
  $('#showless' + orderid).show('fast');
  $('#moretext' + orderid).hide();
}

function showLess(orderid) {
  $('#expandThis' + orderid).toggle('fast');
  $('#showless' + orderid).hide();
  $('#moretext' + orderid).show('fast');
}

function trackorder(id) {
  $('.preL').fadeIn('fast');
  $('.loaderT').fadeIn('fast');
  $('body').attr('scroll', 'no');
  $('body').css('overflow', 'hidden');
  setTimeout(function() {
    $('#trackrow' + id).fadeIn('fast');
    $('#btn_track' + id).attr('disabled', 'disabled');
    $('.preL').fadeOut('fast');
    $('.loaderT').fadeOut('fast');
    $('body').attr('scroll', 'yes');
    $('body').css('overflow', 'auto');
  }, 800);
}

function showOrder(id) {
  $('.preL').fadeIn('fast');
  $('.loaderT').fadeIn('fast');
  $('body').attr('scroll', 'no');
  $('body').css('overflow', 'hidden');
  setTimeout(function() {
    $('#trackrow' + id).fadeOut('fast');
    $('#btn_track' + id).removeAttr('disabled');
    $('.preL').fadeOut('fast');
    $('.loaderT').fadeOut('fast');
    $('body').attr('scroll', 'yes');
    $('body').css('overflow', 'auto');
  }, 800);
}
$('.source_check').on('click', function() {
  var source = $(this).val();
  if(source == 'bank') {
    $('#bank_id').show();
    $('#bank_id').attr('required', 'required');
  } else {
    $('#bank_id').hide();
    $('#bank_id').removeAttr('required');
  }
});

function hideBank(id) {
  $('#bank_id_single' + id).hide();
  $('#bank_id_single' + id).removeAttr('required');
}

function showBank(id) {
  $('#bank_id_single' + id).show();
  $('#bank_id_single' + id).attr('required', 'required');
}
