"use strict";

// Define your library strictly...
$(function () {

  $('.menu-ham').on('click', function () {
    $('.menu-new').animate({
      left: '0px'
    }, 100)
  });
  $('.close-menu-new').on('click', function () {
    $('.menu-new').animate({
      left: '-260px'
    }, 100);
    $('.closeNav').animate({
      left: '-260px'
    }, 100)
  });
  $('[data-toggle="popover"]').popover();



  $('.search-field').on('change', function () {
    var x = $('.search-field').val();
    keyword(x);
  });
  $('.search-field').on('keyup', function () {
    var x = $('.search-field').val();
    keyword(x);
  });
  $(".toggle-password").on('click', function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  $('#password, #confirm_password').on('keyup', function () {
    if ($('#password').val() == $('#confirm_password').val()) {
      $('#message').html('Password Matched').css('color', 'green').show();
    } else $('#message').html('Password Not Matching').css('color', 'red').show();
  });
  $('#btn_reset').on('click', function () {
    document.getElementById("form1").reset();
    $('#message').hide();
  });
  $('.changed_language').on('change', function () {
    var lang = $(this).val();
    $.ajax({
      url: baseUrl + '/changelang',
      type: 'GET',
      data: {
        lang: lang
      },
      success: function (data) {
        location.reload();
      }
    });
  });
});



var sticky = new Sticky('[data-sticky]');
sticky.destroy('[data-sticky]');

$('.currency').on("change",function(){
    var d = $(this).val();

    $.ajax({
      method: 'GET',
      url: baseUrl + '/change-currency/' + d,
      success: function (data) {
        window.location.reload();
      }
    });


});

function val() {
 
  d = document.getElementById("currency").value;
  $.ajax({
    method: 'GET',
    url: baseUrl + '/change-currency/' + d,
    success: function (data) {
      window.location.reload();
    }
  });
}

function val2() {
  d = document.getElementById("currencySmall").value;
  $.ajax({
    method: 'GET',
    url: baseUrl + '/change-currency/' + d,
    success: function (data) {
      window.location.reload();
    }
  });
}

function keyword(x) {
  var test = x;
  // Check browser support
  if (typeof (Storage) !== "undefined") {
    // Store
    sessionStorage.setItem("searchItem", test);
  } else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
  }
}

function catPage(url) {
  $("#dropdown ul").hide();
  window.location.href = url;
}

(function ($) {
  $('#starRating').starRating({
    callback: function (value) {
      $('.getStar').val(+value);
    }
  })
}(jQuery));

// Hot Deal Countdown 
var d = new Date();
var datestring = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
if ($('.timing-wrapper').length) {
  $('.timing-wrapper').each(function () {
    var $this = $(this),
      finalDate = $(this).data('countdown');
    var $this1 = $(this),
      finalDate1 = $(this).data('startat');
    if (datestring >= finalDate1) {
      $this.countdown(finalDate, function (event) {
        var $this = $(this).html(event.strftime('' + '<div class="box-wrapper"><div class="date box"> <span class="key">%D</span> <span class="value">DAYS</span> </div> </div> ' + '<div class="box-wrapper"><div class="hour box"> <span class="key">%H</span> <span class="value">HRS</span> </div> </div> ' + '<div class="box-wrapper"><div class="minutes box"> <span class="key">%M</span> <span class="value">MINS</span> </div> </div> ' + '<div class="box-wrapper"><div class="seconds box"> <span class="key">%S</span> <span class="value">SEC</span> </div> </div> '));
      });
    }
  });
}

function gotourl(url) {
  window.location.href = url;
}
var hidWidth;
var scrollBarWidths = 40;
var widthOfList = function () {
  var itemsWidth = 0;
  $('.list li').each(function () {
    var itemWidth = $(this).outerWidth();
    itemsWidth += itemWidth;
  });
  return itemsWidth;
};
var widthOfHidden = function () {
  return (($('.wrapper').outerWidth()) - widthOfList() - getLeftPosi()) - scrollBarWidths;
};
var reAdjust = function () {
  if (($('.wrapper').outerWidth()) < widthOfList()) {
    $('.scroller-right').show();
  } else {
    $('.scroller-right').hide();
  }
}
reAdjust();
$(window).on('resize', function (e) {
  reAdjust();
});
$('.scroller-right').on('click', function () {
  $('.scroller-left').fadeIn('slow');
  $('.scroller-right').fadeOut('slow');
  $('.list').animate({
    left: "+=" + widthOfHidden() + "px"
  }, 'slow', function () {});
});
$('.scroller-left').on('click', function () {
  $('.scroller-right').fadeIn('slow');
  $('.scroller-left').fadeOut('slow');
  $('.list').animate({
    left: "-=" + getLeftPosi() + "px"
  }, 'slow', function () {});
});

setTimeout(function () {
  $('.hideAlert').slideUp();
}, 2500);

var acc = document.getElementsByClassName("accordion");
var i;
for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function () {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}

$('.dropdown-cart-one').on('click', function () {
  $('.cart-checkout').removeAttr('style');
});

function logout() {
  $(".logout-form").submit();
  event.preventDefault();
}


$(function () {
  $('.toggle-menu').on('click',function () {
    $('.exo-menu').fadeIn().toggleClass('display');
  });
});
$(function () {
  $(".mega-menu").on('hover',function () {
    $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("400");
    $(this).toggleClass('open');
  }, function () {
    $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("400");
    $(this).toggleClass('open');
  });
  $("form").on('submit', function () {
    Pace.restart();
  });

  $("a").on('click', function () {
    Pace.restart();
  });
});
$('.categoryrec').on('click', function () {
  var id = $(this).data('id');
  $('#childOpen' + id).toggle('fast');
});
$('.childrec').on('click', function () {
  var id = $(this).data('id');
  $('#childcollapseExample' + id).toggle('fast');
});


if (rightclick == '1') {
  $(function () {
    $(document).bind("contextmenu", function (e) {
      return false;
    });
  });
}

if (inspect == '1') {
  document.onkeydown = function (e) {
    if (e.keyCode == 123) {
      return false;
    }

    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
      return false;
    }

    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
      return false;
    }

    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
      return false;
    }

    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
      return false;
    }
  };
}

  

  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();



  $(window).on('load', function () {
    $('.front-preloader').fadeOut('slow');
  });

  $(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
});

$(document).on('click','.c_icon_plus',function(){

    var icon = $(this).children().html('');
    $(this).removeClass('c_icon_plus').addClass('c_icon_minus');
    icon.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');

});

$(document).on('click','.c_icon_minus',function(){

  var icon = $(this).children().html('');
  $(this).removeClass('c_icon_minus').addClass('c_icon_plus');
  icon.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');

});