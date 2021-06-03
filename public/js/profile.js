"use strict";
// Define your library strictly...
$('#edit1').on('click', function() {
  $('#fname,#mail').removeAttr("disabled");
  $('#save_btn1').show('slow');
  $('#cancel1').show('slow');
  $('#edit1').hide('slow');
});
$('#cancel1').on('click', function() {
  $('#fname,#mail').attr("disabled", "disabled");
  $('#save_btn1').hide('slow');
  $('#cancel1').hide('slow');
  $('#edit1').show('slow');
});
$('#edit2').on('click', function() {
  $('#mob,#phone').removeAttr("disabled");
  $('#save_btn2').show('slow');
  $('#cancel2').show('slow');
  $('#edit2').hide('slow');
});
$('#cancel2').on('click', function() {
  $('#mob,#phone').attr("disabled", "disabled");
  $('#save_btn2').hide('slow');
  $('#cancel2').hide('slow');
  $('#edit2').show('slow');
});
$('#edit3').on('click', function() {
  $('#country_id,#upload_id,#city_id').removeAttr("disabled");
  $('#save_btn3').show('slow');
  $('#cancel3').show('slow');
  $('#edit3').hide('slow');
});
$('#cancel3').on('click', function() {
  $('#country_id,#upload_id,#city_id').attr("disabled", "disabled");
  $('#save_btn3').hide('slow');
  $('#cancel3').hide('slow');
  $('#edit3').show('slow');
});
$('#edit4').on('click', function() {
  $('#addr,#pin').removeAttr("disabled");
  $('#save_btn4').show('slow');
  $('#cancel4').show('slow');
  $('#edit4').hide('slow');
});
$('#cancel4').on('click', function() {
  $('#addr,#pin').attr("disabled", "disabled");
  $('#save_btn4').hide('slow');
  $('#cancel4').hide('slow');
  $('#edit4').show('slow');
});
$('#edit5').on('click', function() {
  $('#user_img').removeAttr("disabled");
  $('#save_btn5').show('slow');
  $('#cancel5').show('slow');
  $('#edit5').hide('slow');
});
$('#cancel5').on('click', function() {
  $('#user_img').attr("disabled", "disabled");
  $('#save_btn5').hide('slow');
  $('#cancel5').hide('slow');
  $('#edit5').show('slow');
});
