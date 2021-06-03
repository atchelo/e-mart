"use strict";
// Define your library strictly...
$(document).on('click', 'input:radio', function() {
  var a = $(this).attr('id');
  if($(this).is(':checked')) {
    $('#see' + a).prop('checked', true);
  }
});
$(document).on('click', 'input:checkbox', function() {
  var a = $(this).attr('id');
  myString = a.replace('see', '');
  if($(this).is(':checked')) {} else {
    $('#' + myString).each(function() {
      var z = $('#' + myString).attr('p');
      console.log(z);
    })
  }
});
$(document).on('click', '.a', function() {
  if($(this).is(':checked')) {
    var parents_id = $(this).attr('parents_id');
    var t = $('#categories_' + parents_id).prop('checked', true);
  } else {}
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

function readURL1(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#preview2').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image2").on('change', function() {
  readURL1(this);
});

function readURL2(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#preview3').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image3").on('change', function() {
  readURL2(this);
});

function readURL3(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#preview4').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image4").on('change', function() {
  readURL3(this);
});

function readURL4(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#preview5').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image5").on('change', function() {
  readURL4(this);
});

function readURL5(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#preview6').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image6").on('change', function() {
  readURL5(this);
});
$('#image1').on('change', function() {
  var filename = $("#image1").val();
  if(/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen...");
  } else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image2').on('change', function() {
  var filename = $("#image2").val();
  if(/^\s*$/.test(filename)) {
    $(".file-upload2").removeClass('active');
    $("#noFile2").text("No file chosen...");
  } else {
    $(".file-upload2").addClass('active');
    $("#noFile2").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image3').on('change', function() {
  var filename = $("#image3").val();
  if(/^\s*$/.test(filename)) {
    $(".file-upload3").removeClass('active');
    $("#noFile3").text("No file chosen...");
  } else {
    $(".file-upload3").addClass('active');
    $("#noFile3").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image4').on('change', function() {
  var filename = $("#image4").val();
  if(/^\s*$/.test(filename)) {
    $(".file-upload4").removeClass('active');
    $("#noFile4").text("No file chosen...");
  } else {
    $(".file-upload4").addClass('active');
    $("#noFile4").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image5').on('change', function() {
  var filename = $("#image5").val();
  if(/^\s*$/.test(filename)) {
    $(".file-upload5").removeClass('active');
    $("#noFile5").text("No file chosen...");
  } else {
    $(".file-upload5").addClass('active');
    $("#noFile5").text(filename.replace("C:\\fakepath\\", ""));
  }
});
$('#image6').on('change', function() {
  var filename = $("#image6").val();
  if(/^\s*$/.test(filename)) {
    $(".file-upload6").removeClass('active');
    $("#noFile6").text("No file chosen...");
  } else {
    $(".file-upload6").addClass('active');
    $("#noFile6").text(filename.replace("C:\\fakepath\\", ""));
  }
});
