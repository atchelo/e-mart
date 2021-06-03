"use strict";
// Define your library strictly...
function RemoveAllCountry2() {
  var cou2 = $('#btn_rem').attr('isSelected');
  $(this).attr('isSelected', 'no');
  $('#upload_id').find('option').prop("selected", "");
  $('#upload_id').find('option').trigger("change");
}

function SelectAllCountry2() {
  var cou2 = $('#btn_sel').attr('isSelected');
  if(cou2 == 'no') {
    $(this).attr('isSelected', 'yes');
    $('#upload_id').find('option').prop("selected", "selected");
    $('#upload_id').find('option').trigger("change");
    $('#upload_id').find('option').on('click');
  } else {
    $(this).attr('isSelected', 'no');
    $('#upload_id').find('option').prop("selected", "");
    $('#upload_id').find('option').trigger("change");
  }
}
$(function() {
  var urlLike = baseUrl + '/admindesk/choose_state';
  $('#country_id').on('change',function() {
    var up = $('#upload_id').empty();
    var cat_id = $(this).val();
    if(cat_id) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: urlLike,
        data: {
          catId: cat_id
        },
        success: function(data) {
          console.log(data);
          $.each(data, function(id, title) {
            up.append($('<option>', {
              value: id,
              text: title
            }));
          });
          $('#btn_sel').show('fast');
          $('#btn_rem').show('fast');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });
});
