"use strict";
// Define your library strictly...
function changeLang() {
  var lang = $('#changed_lng').val();
  $.ajax({
    url: baseUrl + '/changelang',
    type: 'GET',
    data: {
      lang: lang
    },
    success: function(data) {
      location.reload();
    }
  });
}
$(function() {
  var i = 1;
  $('#add').on('click', function() {
    i++;
    $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input name="prokeys[]" class="form-control" type="text" placeholder="Product Attribute"/></td><td><input type="text" name="provalues[]" placeholder="Attribute Value" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove">X</button></td></tr>');
  });
  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
  });

  $('#category_id').on('change', function () {
    var up = $('#upload_id').empty();
    var up2 = $('#grand').empty();
    var cat_id = $(this).val();
    if (cat_id) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: baseUrl + '/admin/dropdown',
        data: {
          catId: cat_id
        },
        success: function (data) {

          up.append('<option value="">Please Choose</option>');
          $.each(data, function (id, title) {
            up.append($('<option>', {
              value: id,
              text: title
            }));
          });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });
  
  $('#upload_id').on('change', function () {
    var up = $('#grand').empty();
    var cat_id = $(this).val();
    if (cat_id) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: baseUrl + '/admin/gcat',
        data: {
          catId: cat_id
        },
        success: function (data) {

          up.append('<option value="">Please Choose</option>');
          $.each(data, function (id, title) {
            up.append($('<option>', {
              value: id,
              text: title
            }));
          });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });
 
});
$(document).ajaxStart(function() {
  Pace.restart();
});
$(function() {
  $("#datepicker1, #datepicker2").addClass('datepicker');
  $(".datepicker").datepicker({
    dateFormat: "yy-mm-dd"
  });
});
$(".toggle-password").on('click', function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if(input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

function readURL(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#preview1').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image1").on('change', function() {
  readURL(this);
});
$(".abc").on('click', function() {
  return confirm("Do you want to delete this ?");
});
$(function() {
 
  $('.select2').select2();
  $('.js-example-basic-single').select2({
    placeholder: "Search to select category",
    allowClear: true,
  });
  $('.select2-search__field').css('width', '100%');
});

$(function() {
  $('#toggle-event').on('change',function() {
    $('#status').val(+$(this).prop('checked'))
  })
  $('#toggle-event1').on('change',function() {
    $('#status1').val(+$(this).prop('checked'))
  })
  $('#toggle-event2').on('change',function() {
    $('#status2').val(+$(this).prop('checked'))
  })
  $('#toggle-event3').on('change',function() {
    $('#status3').val(+$(this).prop('checked'))
  })
  $('#new').on('change',function() {
    $('#status0').val(+$(this).prop('checked'))
  })
  $('#toggle-event4').on('change',function() {
    $('#status4').val(+$(this).prop('checked'))
  })
  $('#toggle-event5').on('change',function() {
    $('#status5').val(+$(this).prop('checked'))
  })
});
$("#checkboxAll").on('click', function() {
  $('input:checkbox').not(this).prop('checked', this.checked);
});
$('#full_detail_table2').DataTable({
  responsive: true,
  "sDom": "<'row'><'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-sm-12'p>>",
  "language": {
    "paginate": {
      "previous": '<i class="fa fa-angle-left"></i>',
      "next": '<i class="fa fa-angle-right"></i>'
    }
  },
  buttons: [{
    extend: 'print',
    exportOptions: {
      columns: ':visible'
    }
  }, 'csvHtml5', 'excelHtml5', 'colvis', ],
  'deferRender': true,
  'deferLoading': 10,
  'iDisplayLength': 10
});
$(function() {
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if(activeTab) {
    $('#ordertabs a[href="' + activeTab + '"]').tab('show');
  }
  $('#events').on('change', function() {
    $('#featureds').val(+$(this).prop('checked'))
  });
  $('#toggle-event2').on('change', function() {
    $('#featured').val(+$(this).prop('checked'))
  })
  $('#toggle-event5').on('change', function() {
    $('#frees').val(+$(this).prop('checked'))
  });
  $('#frees').on('change', function() {
    $('#shipping').val(+$(this).prop('checked'))
  })
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if(activeTab) {
    $('#myTab a[href="' + activeTab + '"]').tab('show');
  }
});
$('.select2').select2({
  width: '100%',
  placeholder: "Search....",
  allowClear: true
});
$('#full_detail_table').DataTable({
  responsive: true,
  "sDom": "<'row'><'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-sm-12'p>>",
  "language": {
    "paginate": {
      "previous": '<i class="fa fa-angle-left"></i>',
      "next": '<i class="fa fa-angle-right"></i>'
    }
  },
  buttons: [{
    extend: 'print',
    exportOptions: {
      columns: ':visible'
    }
  }, 'csvHtml5', 'excelHtml5', 'colvis', ],
  'deferRender': true,
  'deferLoading': 10,
  'iDisplayLength': 10
});
$(function() {
  // Define your library strictly...
  $('#datetimepicker1').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss'
  });
});
$('#tax_manual').on('change', function() {
  if($('#tax_manual').is(':checked')) {
    $('#manual_tax').show();
    $('#tax_class').hide();
    $('#tax_class_box').removeAttr('required');
    $('#tax_r').attr('required', '');
    $('#tax_name').attr('required', '');
  } else {
    $('#tax_class').show();
    $('#manual_tax').hide();
    $('#tax_class_box').attr('required', '');
    $('#tax_r').removeAttr('required');
    $('#tax_name').removeAttr('required');
  }
});
$('#choose_policy').on('change', function() {
  var get = $(this).val();
  if(get == 0) {
    $('#return_policy').removeAttr('required');
    $('#policy').hide('slow');
  } else if(get == 1) {
    $('#policy').show('slow');
    $('#return_policy').attr('required', 'required');
  } else {
    $('#return_policy').removeAttr('required');
    $('#policy').hide('slow');
  }
});
$(function() {
  $('[data-toggle="popover"]').popover({
    placement: 'top',
    trigger: 'hover',
  });
  $('#datetimepicker2').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss'
  });
  $('.icp-auto').iconpicker();
  $('.preL').fadeOut('fast');
  $('.preloader3').fadeOut('fast');
  $('body').attr('scroll', 'yes');
  $('body').css('overflow', 'auto');
  $('form').on('submit', function() {
    $('.preL').fadeIn();
    $('.preloader3').fadeIn();
    $('body').attr('scroll', 'no');
    $('body').css('overflow', 'hidden');
  });
  $('.lcpdate').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss'
  });
});

function submitform(id) {
  $('locform' + id).on('submit', function() {
    var emp = $(this).serialize();
    console.log(emp);
  });
}

function markread(id) {
  // Define your library strictly...
  var a = $('#countNoti').text();
  $.ajax({
    url: baseUrl + "/usermarkreadsingle",
    type: "GET",
    data: {
      id1: id
    },
    success: function(result) {
      if(a > 0) {
        var b = a - 1;
        if(b > 0) {
          $('#countNoti').text(b);
          $('#' + id).css('background', 'white');
        } else {
          $('#countNoti').hide('fast');
        }
      }
    }
  });
}

tinymce.init({
  selector: '#editor1,#editor2,.editor',
  height: 350,
  menubar: 'edit view insert format tools table tc',
  autosave_ask_before_unload: true,
  autosave_interval: "30s",
  autosave_prefix: "{path}{query}-{id}-",
  autosave_restore_when_empty: false,
  autosave_retention: "2m",
  image_advtab: true,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks fullscreen',
    'insertdatetime media table paste wordcount'
  ],
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
  content_css: '//www.tiny.cloud/css/codepen.min.css'
});

function sellerlogout(){
   $(".sellerlogout").submit();
   event.preventDefault();
}