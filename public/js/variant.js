"use strict";
// Define your library strictly...
function checkall() {
  if ($('#sel_all').is(':checked')) {
    $('input:checkbox').each(function () {
      $(this).prop('checked', true);
    });
  } else {
    $('input:checkbox').each(function () {
      $(this).prop('checked', false);
    });
  }
}
$(".sel_all").on('click', 'td-text', function () {
  $('input:checkbox').not(this).prop('checked', this.checked);
});



$('.setdefButton').on('click', function () {

  

  var proid = $(this).data('proid');
  var id = $(this).attr('id');

  $.ajax({
    url: baseUrl + '/admin/setdef/using/ajax/' + id,
    data: 'pro_id=' + proid,
    success: function (data) {

      if (data['count'] <= 1) {
        swal({
          title: "Oops !",
          text: data['msg'],
          icon: 'warning'
        });


      } else {

        setTimeout(function () {
          var animateIn = "lightSpeedIn";
          var animateOut = "lightSpeedOut";
          PNotify.success({
            title: 'Success',
            text: data['msg'],
            icon: 'fa fa-check-circle-o',
            modules: {
              Animate: {
                animate: true,
                inClass: animateIn,
                outClass: animateOut
              }
            }
          });
        }, );


      }

    }
  });

  window.setTimeout(function () {
    PNotify.closeAll();
  }, 2000);
});



$('#attr_name').on('change', function () {
  var get = $('#attr_name').val();
  var getoptiontext = $('#attr_name option:selected').html();
  getoptiontext = $.trim(getoptiontext);
  var up = $('#attr_value');
  up.html($(''));
  $.ajax({
    method: 'GET',
    data: "sendval=" + get,
    datatype: "json",
    url: baseUrl + '/admin/get/productvalues',
    success: function (data) {
      $('#sel_box').html('');
      $('#sel_box').append('<label><input onclick="checkall()" type="checkbox" id="sel_all"/> Select All</label><br>');
      $('#sel_all').prop('checked', false);
      $.each(data, function (i) {
        if (data[i].unit_value != null && data[i].values.toUpperCase() != data[i].unit_value.toUpperCase()) {
          if (getoptiontext == "Color" || getoptiontext == "Colour") {
            up.append($('<label> <input class="margin-left-8" type="checkbox" name="attr_value[]" value="' + data[i].id + '"><div class="inline-flex margin-left-minus-15"><div class="color-options"><ul><li title="' + data[i].values + '" class="color varcolor active"><a href="#" title=""><i style="color: ' + data[i].unit_value + '" class="fa fa-circle"></i></a><div class="overlay-image overlay-deactive"></div></li></ul></div></div><span class="tx-color">' + data[i].values + '</span></label>'));
          } else {
            up.append($('<input class="margin-left-8" type="checkbox" name="attr_value[]" value="' + data[i].id + '">&nbsp' + data[i].values + data[i].unit_value + '</label>'));
          }
        } else {
          up.append($('<label> <input class="margin-left-8" type="checkbox" name="attr_value[]" value="' + data[i].id + '">&nbsp' + data[i].values + '</label>'));
        }
      });
    }
  });
});
$('#attr_name2').on('change', function () {
  var get = $('#attr_name2').val();
  var getoptiontext = $('#attr_name2 option:selected').html();
  getoptiontext = $.trim(getoptiontext);
  var up = $('#attr_value2');
  up.html($(''));
  $.ajax({
    method: 'GET',
    data: "sendval=" + get,
    datatype: "json",
    url: baseUrl + '/admin/get/productvalues',
    success: function (data) {
      $.each(data, function (i) {
        if (data[i].unit_value != null && data[i].values.toUpperCase() != data[i].unit_value.toUpperCase()) {
          if (getoptiontext == "Color" || getoptiontext == "Colour") {
            up.append($('<label> <input required class="margin-left-8" type="radio" name="attr_value2" value="' + data[i].id + '"><div class="inline-flex margin-left-minus-15"><div class="color-options"><ul><li title="' + data[i].values + '" class="color varcolor active"><a href="#" title=""><i style="color: ' + data[i].unit_value + '" class="fa fa-circle"></i></a><div class="overlay-image overlay-deactive"></div></li></ul></div></div><span class="tx-color">' + data[i].values + '</span></label>'));
          } else {
            up.append($('<input required class="margin-left-8" type="radio" name="attr_value2" value="' + data[i].id + '">&nbsp' + data[i].values + data[i].unit_value + '</label>'));
          }
        } else {
          up.append($('<label> <input required class="margin-left-8" type="radio" name="attr_value2" value="' + data[i].id + '">&nbsp' + data[i].values + '</label>'));
        }
      });
    }
  });
});
$(document).on('click', '.hasCheck', function () {
  if ($(this).is(':checked')) {} else {
    var parents_id = $(this).attr('id');
    $('.a').each(function (index) {
      $('#ch' + parents_id).prop('checked', false);
    });
    $('.b').each(function (index) {
      $('#ch2' + parents_id + index).prop('checked', false);
    });
    $('.c').each(function (index) {
      $('#ch3' + parents_id + index).prop('checked', false);
    });
  }
});
$(document).on('click', 'input:radio', function () {
  $(".hasCheck").each(function (index) {
    var parents_id = $(this).attr('id');
    $('.a').each(function (i) {
      if ($('#ch' + parents_id).is(':checked')) {
        $('#' + parents_id).prop('checked', true);
      }
    });
    $('.b').each(function (i) {
      if ($('#ch2' + parents_id + i).is(':checked')) {
        $('#' + parents_id).prop('checked', true);
      }
    });
    $('.c').each(function (i) {
      if ($('#ch3' + parents_id + i).is(':checked')) {
        $('#' + parents_id).prop('checked', true);
      }
    });
  });
});

function formty() {
  $("input:checkbox:not(:checked)").each(function (i) {
    checked = $(this);
    // if(checked) {
    var c = checked.attr('child_id');
    var c1 = $('#ch' + c).attr({
      value: '0',
      type: 'hidden'
    });
    $('.b').each(function (index) {
      var c2 = $('#ch2' + c + index).attr({
        value: '0',
        type: 'hidden'
      });
    });
    $('.c').each(function (index) {
      var c2 = $('#ch3' + c + index).attr({
        value: '0',
        type: 'hidden'
      });
    });
  })
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#preview1').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image1").on('change', function () {
  readURL(this);
});

function readURL1(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#preview2').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image2").on('change', function () {
  readURL1(this);
});

function readURL2(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#preview3').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image3").on('change', function () {
  readURL2(this);
});

function readURL3(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#preview4').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image4").on('change', function () {
  readURL3(this);
});

function readURL4(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#preview5').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image5").on('change', function () {
  readURL4(this);
});

function readURL5(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#preview6').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image6").on('change', function () {
  readURL5(this);
});
var url = baseUrl + '/images/imagechoosebg.png';
$('#btn-single').on('click', function () {
  var getval = $('#btn-single').val();
  var id = $('#btn-single').attr('cusid');
  $.ajax({
    url: baseUrl + '/delete/varimage1/' + id,
    type: "GET",
    data: {
      getval: getval
    },
    success: function (data) {
      $('#preview1').attr('src', '' + url + '');
      $('#btn-single').hide();
      $("#defimage option[value='" + getval + "']").remove();
    }
  });
});
$('#btn-single2').on('click', function () {
  var getval = $('#btn-single2').val();
  var id = $('#btn-single2').attr('cusid');
  $.ajax({
    url: baseUrl + '/delete/varimage2/' + id,
    type: "GET",
    data: {
      getval: getval
    },
    success: function (data) {
      $('#preview2').attr('src', '' + url + '');
      $('#btn-single2').hide();
      $("#defimage option[value='" + getval + "']").remove();
    }
  });
});
$('#btn-single3').on('click', function () {
  var getval = $('#btn-single3').val();
  var id = $('#btn-single3').attr('cusid');
  $.ajax({
    url: baseUrl + '/delete/varimage3/' + id,
    type: "GET",
    data: {
      getval: getval
    },
    success: function (data) {
      $('#preview3').attr('src', '' + url + '');
      $('#btn-single3').hide();
      $("#defimage option[value='" + getval + "']").remove();
    }
  });
});
$('#btn-single4').on('click', function () {
  var getval = $('#btn-single4').val();
  var id = $('#btn-single4').attr('cusid');
  $.ajax({
    url: baseUrl + '/delete/varimage4/' + id,
    type: "GET",
    data: {
      getval: getval
    },
    success: function (data) {
      $('#preview4').attr('src', '' + url + '');
      $('#btn-single4').hide();
      $("#defimage option[value='" + getval + "']").remove();
    }
  });
});
$('#btn-single5').on('click', function () {
  var getval = $('#btn-single5').val();
  var id = $('#btn-single5').attr('cusid');
  $.ajax({
    url: baseUrl + '/delete/varimage5/' + id,
    type: "GET",
    data: {
      getval: getval
    },
    success: function (data) {
      $('#preview5').attr('src', '' + url + '');
      $('#btn-single5').hide();
      $("#defimage option[value='" + getval + "']").remove();
    }
  });
});
$('#btn-single6').on('click', function () {
  var getval = $('#btn-single6').val();
  var id = $('#btn-single6').attr('cusid');
  $.ajax({
    url: baseUrl + '/delete/varimage6/' + id,
    type: "GET",
    data: {
      getval: getval
    },
    success: function (data) {
      $('#preview6').attr('src', '' + url + '');
      $('#btn-single6').hide();
      $("#defimage option[value='" + getval + "']").remove();
    }
  });
});
$('#image1').on('change', function () {
  var filename = $("#image1").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen...");
  } else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image2').on('change', function () {
  var filename = $("#image2").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload2").removeClass('active');
    $("#noFile2").text("No file chosen...");
  } else {
    $(".file-upload2").addClass('active');
    $("#noFile2").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image3').on('change', function () {
  var filename = $("#image3").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload3").removeClass('active');
    $("#noFile3").text("No file chosen...");
  } else {
    $(".file-upload3").addClass('active');
    $("#noFile3").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image4').on('change', function () {
  var filename = $("#image4").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload4").removeClass('active');
    $("#noFile4").text("No file chosen...");
  } else {
    $(".file-upload4").addClass('active');
    $("#noFile4").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image5').on('change', function () {
  var filename = $("#image5").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload5").removeClass('active');
    $("#noFile5").text("No file chosen...");
  } else {
    $(".file-upload5").addClass('active');
    $("#noFile5").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image6').on('change', function () {
  var filename = $("#image6").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload6").removeClass('active');
    $("#noFile6").text("No file chosen...");
  } else {
    $(".file-upload6").addClass('active');
    $("#noFile6").text(filename.replace("C:\\fakepath\\", ""));
  }
});