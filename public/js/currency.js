"use strict";

$(function() {
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if(activeTab) {
    $('#currencyTabs a[href="' + activeTab + '"]').tab('show');
  }
});
$(function() {
  var urlLike = baseUrl + '/admindesk/currency_codeShow';
  $('.seladv').on('change',function() {
    var id = $(this).attr('id');
    var currency_id = $(this).val();
    if(currency_id) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: urlLike,
        data: {
          currency_id: currency_id,
          id: id
        },
        success: function(data) {
          console.log(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });
});

function UpdateFormData(id) {
  var currency = $("#currency_id" + id).val();
  var country = $("#country_id" + id).val();
  var multi_currency = $("#multi_currency" + id).val();
  var urlLike = baseUrl + '/admindesk/editlocation';
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "GET",
    url: urlLike,
    data: {
      currency: currency,
      country: country,
      multi_currency: multi_currency
    },
    success: function(data) {
      console.log(data);
      $("#rate").val(data);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.log(XMLHttpRequest);
    }
  });
}

function testing() {
  $('.js-example-responsive').select2({
    width: "100%"
  });
}

function removerow(id) {
  $('#' + id).remove();
}

function tt(id) {
  $('#toggle-event5' + id).on('change',function() {
    $('#status5' + id).val(+$(this).prop('checked'));
  })
}
$(function() {
  $('#toggle-checkout').on('change',function() {
    $('#checkout').val(+$(this).prop('checked'))
  })
  $('#toggle-cart').on('change',function() {
    $('#cart').val(+$(this).prop('checked'))
  })
  $('#myTab li:first-child a').tab('show')
});




function SelectAllCountry2(id, btnid) {
  var cou = id;
  var cou2 = $('#' + btnid).attr('isSelected');
  if(cou2 == 'no') {
    $(this).attr('isSelected', 'yes');
    $('#' + cou).find('option').prop("selected", "selected");
    $('#' + cou).find('option').trigger("change");
    $('#' + cou).find('option').on('click');
  } else {
    $(this).attr('isSelected', 'no');
    $('#' + cou).find('option').prop("selected", "");
    $('#' + cou).find('option').trigger("change");
  }
}

function RemoveAllCountry2(id, btnid) {
  var cou = id;
  var cou2 = $('#' + btnid).attr('isSelected');
  $(this).attr('isSelected', 'no');
  $('#' + cou).find('option').prop("selected", "");
  $('#' + cou).find('option').trigger("change");
}

function enabel_currency() {
  var checkVal = $('#enabel').is(':checked');
  if(checkVal == true) {
    var urlLike = baseUrl + '/admindesk/enable_multicurrency';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        enable_multicurrency: 1,
      },
      success: function(data) {
        console.log(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  } else {
    var urlLike = baseUrl + '/admindesk/enable_multicurrency';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        enable_multicurrency: 0,
      },
      success: function(data) {
        console.log(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
}
$(function() {
  var defaultCur = $("#auto-detect").is(':checked');
  if(defaultCur == true) {
    $('.select-geo').slideUp('fast');
    $('.geoLocation-add').fadeIn('fast');
    $('.country-loding').fadeIn('fast');
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        auto: 1
      },
      success: function(data) {
        $('.country-loding').fadeOut();
        var urlx = data['isoCode'];
        console.log(urlx);
        $('.location-name').html(data['country'] + '  ' + '<img src="' + urlx + '" height="15px"> ')
        setTimeout(function() {
          $('.location-name').fadeIn('slow');
          $('.map-icon').fadeIn('slow');
        }, 500);
        // console.log(data);
        $("#by-country").prop('disabled', false);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  } else {
    $('.select-geo').slideDown('fast');
    $('.geoLocation-add').fadeOut('fast');
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        auto: 0
      },
      success: function(data) {
        $('.location-name').fadeOut('slow');
        $('.map-icon').fadeOut('slow');
        $("#by-country").prop('disabled', true);
        $("#by-country").prop('checked', false);
        currencybycountry('by-country');
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
  Defaultgeolocation();
});
$('#GeoLocationId').on('change', function() {
  Defaultgeolocation();
});

function Defaultgeolocation() {
  var urlLike = baseUrl + '/admindesk/auto_detect_location';
  var country_id = $('#GeoLocationId').val();
  console.log(country_id);
  if(country_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        country_id: country_id
      },
      success: function(data) {
        console.log(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
}

function autoDetectLocation(id) {
  var defaultCur = $("#" + id).is(':checked');
  if(defaultCur == true) {
    $('#baseCurrencyBox').show('fast');
    $('.select-geo').slideUp('fast');
    $('.geoLocation-add').fadeIn('fast');
    $('.country-loding').fadeIn('fast');
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        auto: 1
      },
      success: function(data) {
        $('.country-loding').fadeOut();
        var urlx = data['isoCode'];
        $('.location-name').html(data['country'] + '  ' + '<img src="' + urlx + '" height="15px"> ')
        setTimeout(function() {
          $('.location-name').fadeIn('slow');
          $('.map-icon').fadeIn('slow');
        }, 500);
        $("#by-country").prop('disabled', false);
        // console.log(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  } else {
    $('#baseCurrencyBox').hide('fast');
    $('.select-geo').slideDown('fast');
    $('.geoLocation-add').fadeOut('fast');
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        auto: 0
      },
      success: function(data) {
        $('.location-name').fadeOut('slow');
        $('.map-icon').fadeOut('slow');
        $("#by-country").prop('disabled', true);
        $("#by-country").prop('checked', false);
        currencybycountry('by-country');
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
}

function currencybycountry(id) {
  var defaultCoun = $("#" + id).is(':checked');
  if(defaultCoun == true) {
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        currencybyc: 1
      },
      success: function(data) {
        $('#cur_by_country').show();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  } else {
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        currencybyc: 0
      },
      success: function(data) {
        $('#cur_by_country').hide();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
}

function checkoutSetting() {
  var cart_page = $("#cart_page").is(':checked');
  if(cart_page == true) {
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        cart_page: 1
      },
      success: function(data) {
        console.log(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  } else {
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        cart_page: 0
      },
      success: function(data) {
        var animateIn = "lightSpeedIn";
        var animateOut = "lightSpeedOut";
        swal({
          title: "Success ",
          text: 'Setings Updated !',
          icon: 'success'
        });
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
}

function checkoutSettingCheckout() {
  var checkVar = $("#checkout_currency").is(':checked');
  if(checkVar == true) {
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        checkout_currency: 1
      },
      success: function(data) {
        var animateIn = "lightSpeedIn";
        var animateOut = "lightSpeedOut";
        swal({
          title: "Success ",
          text: 'Settings Updated !',
          icon: 'success'
        });
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  } else {
    var urlLike = baseUrl + '/admindesk/auto_detect_location';
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: urlLike,
      data: {
        checkout_currency: 0
      },
      success: function(data) {
        var animateIn = "lightSpeedIn";
        var animateOut = "lightSpeedOut";
        swal({
          title: "Success ",
          text: 'Settings Updated !',
          icon: 'success'
        });
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
}

function CheckoutCurrencySubmitForm() {
  $('.pay_m').each(function(z) {
    var payval = $(this).val();
    var default_checkout = $("#default_checkout" + z).is(':checked');
    var payment = $('#payment_checkout' + z).val();
    var currency_checkout = $('#currency_checkout' + z).val();
    var checkout_currency_status = $('#checkout_currency_status' + z).val();
    var currencyId = $('#currencyId' + z).val();
    var urlLike = baseUrl + '/admindesk/checkOutUpdate';
    if(default_checkout == true) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: urlLike,
        data: {
          default_checkout: 1,
          payment: payment,
          currency_checkout: currency_checkout,
          checkout_currency_status: checkout_currency_status,
          currencyId: currencyId
        },
        success: function(data) {},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    } else {
      var urlLike = baseUrl + '/admindesk/checkOutUpdate';
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: urlLike,
        data: {
          default_checkout: 0,
          payment: payment,
          currency_checkout: currency_checkout,
          checkout_currency_status: checkout_currency_status,
          currencyId: currencyId
        },
        success: function(data) {},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });
  var animateIn = "lightSpeedIn";
  var animateOut = "lightSpeedOut";
  swal({
    title: "Success ",
    text: 'Settings Updated !',
    icon: 'success'
  });
}

function default_check(id) {
  var default_checkout = $("#default_checkout" + id).is(':checked');
  var urlLike = baseUrl + '/admindesk/defaul_check_checkout';
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "GET",
    url: urlLike,
    data: {
      default_checkout: 1,
      id: id
    },
    success: function(data) {},
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.log(XMLHttpRequest);
    }
  });
}