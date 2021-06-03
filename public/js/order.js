"use strict";
// Define your library strictly...
function trackrefund(id) {
  var canorderid = id;
  $.ajax({
    type: 'GET',
    url: baseUrl + '/track/refund/live/api/' + canorderid,
    data: {
      orderid: canorderid
    },
    success: function (data) {

      if (data.code == 404) {
        swal({
          title: "Sorry ! ",
          text: data.msg,
          icon: 'error'
        });

        return false;
      }

      $('#ordertrack' + id).modal('show');
      $('#refundArea' + id).html('');
      $('#refundArea' + id).html(data);


    }
  });
}

function trackrefundFullCOrder(id) {
  var canorderid = id;
  $.ajax({
    type: 'GET',
    url: baseUrl + '/track/refund/fullorder/live/api/' + canorderid,
    data: {
      orderid: canorderid
    },
    success: function (data) {

      if (data.code == 404) {
        swal({
          title: "Sorry ! ",
          text: data.msg,
          icon: 'error'
        });

        return false;
      }

      $('#ordertrackfull' + id).modal('show');
      $('#refundAreafull' + id).html('');
      $('#refundAreafull' + id).html(data);


    }
  });
}


function updatefullorder(id) {
  var getval = $('.full_refund_status' + id).val();
  if (getval == 'pending') {
    $(".single_order_status" + id).append(new Option("Refund Pending", "Refund Pending"));
    $('.single_order_status' + id + ' option[value="refunded"]').remove();
    $('.single_order_status' + id + ' option[value="returned"]').remove();
  } else {
    $('.single_order_status' + id + ' option[value="Refund Pending"]').remove();
    $(".single_order_status" + id).append(new Option("Refunded", "refunded"));
    $(".single_order_status" + id).append(new Option("Returned", "returned"));
  }
}
$(function () {
  $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    $('#ordertabs a[href="' + activeTab + '"]').tab('show');
  }
});

function readfullorder(id) {
  var getunreadcount = $('#fcount').text();
  $.ajax({
    type: 'GET',
    url: baseUrl + '/admin/update/read-at/cancel/fullorder',
    data: {
      id: id
    },
    success: function (data) {
      if (getunreadcount != 0) {
        getunreadcount = getunreadcount - 1;
        $('#fcount').text(getunreadcount);
      }
    }
  });
}

function readorder(id) {
  var getunreadcount = $('#pcount').text();
  console.log(getunreadcount);
  $.ajax({
    type: 'GET',
    url: baseUrl + '/admin/update/read-at/cancel/order',
    data: {
      id: id
    },
    success: function (data) {
      if (getunreadcount != 0) {
        getunreadcount = getunreadcount - 1;
        $('#pcount').text(getunreadcount);
      }
    }
  });
}
$(function () {
  $('.preL').fadeOut('fast');
  $('.preloader3').fadeOut('fast');
  $('body').attr('scroll', 'yes');
  $('body').css('overflow', 'auto');
  $('form').on('submit', function () {
    $('.preL').fadeIn();
    $('.preloader3').fadeIn();
    $('body').attr('scroll', 'no');
    $('body').css('overflow', 'hidden');
  });
});
$('#refund_status').on('change', function () {
  var getval = $('#refund_status').val();
  if (getval == 'pending') {
    $("#order_status").append(new Option("Refund Pending", "Refund Pending"));
    $("#order_status option[value='refunded']").remove();
    $("#order_status option[value='returned']").remove();
  } else {
    $("#order_status option[value='Refund Pending']").remove();
    $("#order_status").append(new Option("Refunded", "refunded"));
    $("#order_status").append(new Option("Returned", "returned"));
  }
});

function singlerefundstatus(id) {
  var getval = $('#refund_status' + id).val();
  if (getval == 'pending') {
    $("#order_status" + id).append(new Option("Refund Pending", "Refund Pending"));
    $('#order_status' + id + ' option[value="refunded"]').remove();
    $('#order_status' + id + ' option[value="returned"]').remove();
  } else {
    $('#order_status' + id + ' option[value="Refund Pending"]').remove();
    $("#order_status" + id).append(new Option("Refunded", "refunded"));
    $("#order_status" + id).append(new Option("Returned", "returned"));
  }
}

function submitform(id) {
  $('locform' + id).on('submit', function () {
    var emp = $(this).serialize();
  });
}
$(function () {
  $('.lcpdate').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss'
  });
});
$('.source_check').on('click', function () {
  var source = $(this).val();
  if (source == 'bank') {
    $('#bank_id').show();
    $('#bank_id').attr('required', 'required');
  } else {
    $('#bank_id').hide();
    $('#bank_id').removeAttr('required');
  }
});

function hideBank(id) {
  $('#bank_id_single' + id).hide();
  $('#bank_id_single' + id).removeAttr('required');
}

function showBank(id) {
  $('#bank_id_single' + id).show();
  $('#bank_id_single' + id).attr('required', 'required');
}
$('#txn_fee').on('keyup', function () {
  var amount = $('#txn_amount').val();
  var fee = $('#txn_fee').val();
  var newamount = amount - fee;
  if (fee != '') {
    $('#txn_amount').val(newamount);
  } else {
    actualAmount = $('#actualAmount').val();
    $('#txn_amount').val(actualAmount);
  }
});
$('#pay_confirm').on('change', function () {
  var status = $(this).val();
  $.ajax({
    type: 'GET',
    url: baseUrl + '/admin/cod/' + orderid + '/orderpayconfirm',
    data: {
      _token: "{{csrf_token()}}",
      status: status
    },
    dataType: "json",
    beforeSend: function () {
      $('.preL').fadeIn();
      $('.preloader3').fadeIn();
    },
    success: function (data) {
      if (data.status == true) {

        toastr.success('Payment Status Successfully changed', 'Success', {timeOut: 2500});

       
      } else {

        toastr.error('Payment Change error look in browser console for more info !', 'Error', {timeOut: 2500});

      }
      $('.preL').fadeOut();
      $('.preloader3').fadeOut();
    }
  });
});