"use strict";
// Define your library strictly...
$('#shippingcheck').on('click', function() {
  if($('#shippingcheck').is(':checked')) {
    $('#myModal').modal('hide');
  } else {
    $('#myModal').modal({
      backdrop: 'static',
      keyboard: false
    });
  }
});
$(function() {
  $("input[type=text]").prop('required', true);
  $("#pincode").autocomplete({
    source: function(request, response) {
      $.ajax({
        url: baseUrl + "/pincode/finder",
        data: {
          term: request.term
        },
        dataType: "json",
        success: function(data) {
          var resp = $.map(data, function(obj) {
            return {
              label: obj.label,
              value: obj.value,
              state: obj.id,
              city: obj.city,
              country: obj.findcountry
            }
          });
          response(resp);
        }
      });
    },
    select: function(event, ui) {
      var cnt = ui.item.country;
      var state = ui.item.state;
      var c = ui.item.city;
      if(ui.item.value) {
        this.value = ui.item.value.replace(/\D/g, '');
        var urlLike1 = baseUrl + '/choose_state';
        var up1 = $('#upload_id');
        var country_id = cnt;
        if(country_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike1,
            data: {
              catId: country_id
            },
            success: function(data) {
              $.each(data, function(id, title) {
                up1.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#country_id option").each(function() {
                if($(this).val() == cnt) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
              $("#upload_id option").each(function() {
                if($(this).val() == state) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
        var up = $('#city_id').empty();
        var urlLike = baseUrl + '/choose_city';
        if(state) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: state
            },
            success: function(data) {
              up.append('<option value="">Please Choose</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#city_id option").each(function() {
                if($(this).val() == c) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
          });
        }
        return false;
      }
    },
    minLength: 3
  });
  $("#billing_pincode").autocomplete({
    source: function(request, response) {
      $.ajax({
        url: baseUrl + "/pincode/finder",
        data: {
          term: request.term
        },
        dataType: "json",
        success: function(data) {
          var resp = $.map(data, function(obj) {
            return {
              label: obj.label,
              value: obj.value,
              state: obj.id,
              city: obj.city,
              country: obj.findcountry
            }
          });
          response(resp);
        }
      });
    },
    select: function(event, ui) {
      var cnt = ui.item.country;
      var state = ui.item.state;
      var c = ui.item.city;
      if(ui.item.value) {
        this.value = ui.item.value.replace(/\D/g, '');
        var urlLike1 = baseUrl + '/choose_state';
        var up1 = $('#billing_state');
        var country_id = cnt;
        if(country_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike1,
            data: {
              catId: country_id
            },
            success: function(data) {
              $.each(data, function(id, title) {
                up1.append($('<option>', {
                  value: id,
                  text: title
                }));
              });

              $("#billing_country option").each(function() {

                if($(this).val() == cnt) {
                    $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }

              });

              $("#billing_state option").each(function() {
                if($(this).val() == state) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
        var up = $('#billing_city').empty();
        var urlLike = baseUrl + '/choose_city';
        if(state) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: state
            },
            success: function(data) {
              up.append('<option>Please Choose</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#billing_city option").each(function() {
                if($(this).val() == c) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
          });
        }
        return false;
      }
    },
    minLength: 3
  });
});

function fillbillingaddress() {
  var radioValue = $("input[name='seladd2']:checked").val();
  $('#sameasship').prop('checked', false);
  $('#shipval').val('0');
  if(radioValue) {
    $.ajax({
      data: {
        id: radioValue
      },
      type: 'GET',
      url: baseUrl + '/getaddress/list',
      success: function(data) {
        $('#savedaddress').modal('hide');
        $('#billing_name').val(data.name);
        $('#billing_email').val(data.email);
        $('#billing_mobile').val(data.phone);
        $('#billing_pincode').val(data.pin_code);
        $('#billing_address').val(data.address);
        var up1 = $('#billing_state');
        var country_id = data.country_id;
        var state = data.state_id;
        if(country_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: baseUrl + '/choose_state',
            data: {
              catId: country_id
            },
            success: function(data) {
              $.each(data, function(id, title) {
                up1.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#billing_country option").each(function() {
                if($(this).val() == country_id) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
              $("#billing_state option").each(function() {
                if($(this).val() == state) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
        var up = $('#billing_city').empty();
       
        var city = data.city_id;
        if(state) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: baseUrl + '/choose_city',
            data: {
              catId: state
            },
            success: function(data) {
              up.append('<option value="">Please Choose</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#billing_city option").each(function() {
                if($(this).val() == city) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
          });
        }
        return false;
      }
    });
  } else {
    alert('Please select address !');
  }
}

function sameship() {

  if($('#sameasship').is(':checked')) {
    $('#shipval').val('1');
    var get = 1;
    $.ajax({
      type: 'GET',
      url: baseUrl + '/getaddress/default',
      data: {
        flag: get
      },
      beforeSend: function() {
        $('.preL').fadeIn('fast');
        $('.loaderT').fadeIn('fast');
        $('body').attr('scroll', 'no');
        $('body').css('overflow', 'hidden');
      },
      success: function(data) {
        $('#billing_name').val(data.name);
        $('#billing_email').val(data.email);
        $('#billing_mobile').val(data.phone);
        $('#billing_pincode').val(data.pin_code);
        $('#billing_address').val(data.address);

        $('.preL').fadeOut('fast');
        $('.loaderT').fadeOut('fast');
        $('body').attr('scroll', 'yes');
        $('body').css('overflow', 'auto');
        
        var up1 = $('#billing_state');
        var country_id = data.country_id;
        var state = data.state_id;
        
        if(country_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: baseUrl + '/choose_state',
            data: {
              catId: country_id
            },
            success: function(data) {
              $.each(data, function(id, title) {
                up1.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#billing_country option").each(function() {

                $(this).removeAttr("selected");

                if($(this).val() == country_id) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
              $("#billing_state option").each(function() {
                if($(this).val() == state) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
        var up = $('#billing_city').empty();
        
        var city = data.city_id;
        if(state) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: baseUrl + '/choose_city',
            data: {
              catId: state
            },
            success: function(data) {
              up.append('<option value="">Please Choose City</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#billing_city option").each(function() {
                if($(this).val() == city) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
          });
        }
        return false;
      }
    });
  } else {
    $("input").prop('required', true);
    $('#shipval').val('0');
    document.getElementById("billingForm").reset();
    $('#billing_country').prop('selectedIndex',0);

    $('#billing_state,#billing_city').empty();
    $('#billing_state,#billing_city').prop('selectedIndex',0);


  }
}

function fillbillingaddress() {
  var getaddressID;
  var radioValue = $("input[name='seladd2']:checked").val();
  $('#sameasship').prop('checked', false);
  $('.radiofrommodal' + radioValue).prop('checked', true);
  $('#shipval').val('0');
  if(radioValue) {
    $.ajax({
      data: {
        id: radioValue
      },
      type: 'GET',
      url: baseUrl + '/getaddress/list',
      success: function(data) {
        $('#savedaddress').modal('hide');
        document.getElementById("billingForm").reset();
        $('#billing_name').val(data.name);
        $('#billing_email').val(data.email);
        $('#billing_mobile').val(data.phone);
        $('#billing_pincode').val(data.pin_code);
        $('#billing_address').val(data.address);
        var urlLike1 = baseUrl + '/choose_state';
        var up1 = $('#billing_state');
        var country_id = data.country_id;
        var state = data.state_id;
        if(country_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike1,
            data: {
              catId: country_id
            },
            success: function(data) {
              $.each(data, function(id, title) {
                up1.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#billing_country option").each(function() {
                if($(this).val() == country_id) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
              $("#billing_state option").each(function() {
                if($(this).val() == state) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
        var up = $('#billing_city').empty();
        var urlLike = baseUrl + '/choose_city';
        var city = data.city_id;
        if(state) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: state
            },
            success: function(data) {
              up.append('<option value="">Please Choose</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
              $("#billing_city option").each(function() {
                if($(this).val() == city) { // EDITED THIS LINE
                  $(this).attr("selected", "selected");
                } else {
                  $(this).removeAttr("selected");
                }
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
          });
        }
        return false;
      }
    });
  } else {
    alert('Please select address !');
  }
}

function localpickupcheck(id) {
  var cartid = id;
  if($('#ship' + id).is(':checked')) {
    $.ajax({
      method: 'GET',
      data: {
        cartid: cartid
      },
      beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.loaderT').fadeIn('fast');
        $('body').attr('scroll', 'no');
        $('body').css('overflow', 'hidden');
      },
      url: baseUrl + '/check/localpickup/isApply',
      success: function(data) {
        $('#shipping' + id).text(data.pershipping);
        $('#totalprice' + id).text(data.totalprice);
        $('#totalshipping').text(data.totalshipping);
        $('#grandtotal').text(data.grandtotal);
        location.reload();
      }
    });
  } else {
    $.ajax({
      method: 'GET',
      data: {
        cartid: cartid
      },
      beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.loaderT').fadeIn('fast');
        $('body').attr('scroll', 'no');
        $('body').css('overflow', 'hidden');
      },
      url: baseUrl + '/back/localpickup/notapply',
      success: function(data) {
        $('#shipping' + id).text(data.pershipping);
        $('#totalprice' + id).text(data.totalprice);
        $('#totalshipping').text(data.totalshipping);
        $('#grandtotal').text(data.grandtotal);
        location.reload();
      }
    });
  }
}
$('#orderRev').on('click', function() {
  setTimeout(function() {
    $('#o_tab').removeClass('fa fa-check');
    $('#o_tab').html('4');
    $('#payment_box').removeAttr('data-toggle');
    $('#payment_box').addClass('collapsed');
    $('#collapseFive').removeClass('show');
  }, 1000);
});

try{
  new Card({
    form: document.querySelector('#credit-card'),
    container: '.card-wrapper'
  });
}catch(err){
  
}

$('#final_step').on('click', function() {

  $.ajax({
    type : 'GET',
    url  : baseUrl + '/verifypayment',
    data : {carttotal: carttotal},
    dataType : 'json',
    beforeSend : function(){
       $('.payment-verify-preloader').fadeIn('fast');
    },
    success : function(data){
      


      if(data[0] == 200){

        $('.jsonstatus').html('Status : <i class="lightgreen fa fa-check-circle-o" aria-hidden="true"></i> Verified !');

        setTimeout(function() {
          $('#o_tab').html('');
          $('#o_tab').addClass('fa fa-check');
          $('#payment_box').attr('data-toggle', 'collapse');
          $('#payment_box').removeClass('collapsed');
          $('#payment_box').attr('data-parent', '#accordion');
          $('#payment_box').attr('href', '#collapseFive');
          $('#orderRev').addClass('collapsed');
          $('#collapseFour').removeClass('show');
          $('#collapseFive').addClass('collapse show');
          $('#collapseFive').css('height', 'auto');

          $('.payment-verify-preloader').fadeOut('fast');
        }, 1000);


      }else{
        
        $('.jsonstatus').html('Status : <i class="text-danger fa fa-info-circle" aria-hidden="true"></i> Cart Value Modified !');
        
        setTimeout(function() {
          $('.payment-verify-preloader').fadeOut('fast');
          location.reload();
        },1000);

      }


    }
  });

  
});

$(function() {
  
  $(document).ready(function() {
    var up = $('#billing_state');
    var country_id = $('#billing_country').val();

    if(country_id) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: baseUrl + '/choose_state',
        data: {
          catId: country_id
        },
        success: function(data) {
          
          $.each(data, function(id, title) {
            up.append($('<option>', {
              value: id,
              text: title
            }));
          });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });

  $('#billing_country').on('change', function() {
    var up = $('#billing_state').empty();
    var up1 = $('#billing_city').empty();
    var cat_id = $(this).val();

    if(cat_id) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: baseUrl + '/choose_state',
        data: {
          catId: cat_id
        },
        success: function(data) {
          up.append('<option value="">Please Choose</option>');
          up1.append('<option value="">Please Choose</option>');
          $.each(data, function(id, title) {
            up.append($('<option>', {
              value: id,
              text: title
            }));
          });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });

 
  $(document).ready(function() {
    
    var cat_id = $('#billing_state').val();
    console.log(cat_id);
    if(cat_id) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: baseUrl + '/choose_city',
        data: {
          catId: cat_id
        },
        success: function(data) {
          $.each(data, function(id, title) {
            $('#billing_state').append($('<option>', {
              value: id,
              text: title
            }));
          });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });
  $('#billing_state').on('change', function() {
    var up = $('#billing_city').empty();
    var cat_id = $(this).val();
    if(cat_id) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: baseUrl + '/choose_city',
        data: {
          catId: cat_id
        },
        success: function(data) {
          up.append('<option value="">Please Choose</option>');
          $.each(data, function(id, title) {
            up.append($('<option>', {
              value: id,
              text: title
            }));
          });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  });
});


