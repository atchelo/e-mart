"use strict";
// Define your library strictly...
function checkPincode($id) {
  var id = $id;
  $("#pincode" + id).show();
  var code = $("#pincode" + id).val();
  var urlLike = baseUrl + '/pincode-add';
  $.ajax({
    type: 'GET',
    url: urlLike,
    data: {
      code: code,
      id: id
    },
    success: function(data) {
      $("#show-pincode" + id).text(data);
    }
  });
}

$('#pincodesystem').on('change', function() {
  if($(this).is(':checked')) {
    $.ajax({
      url: baseUrl + '/enablepincodesystem',
      method: 'GET',
      data: {
        enable: 1
      },
      beforeSend: function() {
        $('.preL').fadeIn();
        $('.preloader3').fadeIn();
        $('.box,.main-header,.main-sidebar').css({
          '-webkit-filter': 'blur(5px)'
        });
      },
      success: function(data) {
        $('#countryTable').show('fast');
        location.reload();
        
      }
    });
  } else {
    $.ajax({
      url: baseUrl + '/enablepincodesystem',
      method: 'GET',
      data: {
        enable: 0
      },
      beforeSend: function() {
        $('.preL').fadeIn();
        $('.preloader3').fadeIn();
        $('.box,.main-header,.main-sidebar').css({
          '-webkit-filter': 'blur(5px)'
        });
      },
      success: function(data) {
        $('#countryTable').hide('fast');
        location.reload();

      }
    });
  }
});


$(function () {

    var table = $('#countryTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: baseUrl+'/admindesk/destination',
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
              {data: 'name', name: 'allcountry.nicename'},
              {data : 'view', name: 'view', orderable: false, searchable: false}         
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'asc']]
      });
      
});
