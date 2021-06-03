"use strict";
// Define your library strictly...
function readURL1(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#slider_preview').css({
        'width': "100%",
        'height': "500px"
      });
      $('#slider_preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image").on('change', function() {
  readURL1(this);
});
$('#link_by').on('change', function() {
  var v = $(this).val();
  if(v == 'cat') {
    $('#category_id').show();
    $('#subcat_id').hide();
    $('#child').hide();
    $('#pro').hide();
    $('#url_box').hide();
    $('#cat').attr('required', '');
    $('#subcat').removeAttr('required');
    $('#child').removeAttr('required');
    $('#pro').removeAttr('required');
    $('#url').removeAttr('required');
  } else if(v == 'sub') {
    $('#category_id').hide();
    $('#subcat_id').show();
    $('#child').hide();
    $('#pro').hide();
    $('#url_box').hide();
    $('#subcat').attr('required', '');
    $('#cat').removeAttr('required');
    $('#child').removeAttr('required');
    $('#pro').removeAttr('required');
    $('#url').removeAttr('required');
  } else if(v == 'child') {
    $('#category_id').hide();
    $('#subcat_id').hide();
    $('#child').show();
    $('#pro').hide();
    $('#url_box').hide();
    $('#child').attr('required', '');
    $('#cat').removeAttr('required');
    $('#subcat').removeAttr('required');
    $('#pro').removeAttr('required');
    $('#url').removeAttr('required');
  } else if(v == 'pro') {
    $('#category_id').hide();
    $('#subcat_id').hide();
    $('#child').hide();
    $('#pro').show();
    $('#url_box').hide();
    $('#pro').attr('required', '');
    $('#cat').removeAttr('required');
    $('#subcat').removeAttr('required');
    $('#child').removeAttr('required');
    $('#url').removeAttr('required');
  } else if(v == 'url') {
    $('#url_box').show();
    $('#category_id').hide();
    $('#subcat_id').hide();
    $('#child').hide();
    $('#pro').hide();
    $('#pro').removeAttr('required');
    $('#cat').removeAttr('required');
    $('#subcat').removeAttr('required');
    $('#child').removeAttr('required');
    $('#url').attr('required', '');
  } else {
    $('#category_id').hide();
    $('#subcat_id').hide();
    $('#child').hide();
    $('#pro').hide();
    $('#url_box').hide();
    $('#pro').removeAttr('required');
    $('#cat').removeAttr('required');
    $('#subcat').removeAttr('required');
    $('#child').removeAttr('required');
    $('#url').removeAttr('required');
  }
});
