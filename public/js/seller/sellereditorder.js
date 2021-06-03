 function changeStatus(id) {
	  var status = $('#status' + id).val();
	  $.ajax({
	    headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
	    type: 'GET',
	    url: url+'/'+id,
	    data: {
	      status: status
	    },
	    beforeSend: function() {
	      $('.preL').fadeIn();
	      $('.preloader3').fadeIn();
	    },
	    success: function(data) {
	      $('#singleorderstatus' + data.id).html('');
	      if(data.status == 'pending') {
	        $('#singleorderstatus' + data.id).append('<span class="label label-default">' + data.status.charAt(0).toUpperCase() + data.status.slice(1) + '</span>');
	      }
	      if(data.status == 'processed') {
	        $('#singleorderstatus' + data.id).append('<span class="label label-info">' + data.status.charAt(0).toUpperCase() + data.status.slice(1) + '</span>');
	      }
	      if(data.status == 'shipped') {
	        $('#singleorderstatus' + data.id).append('<span class="label label-primary">' + data.status.charAt(0).toUpperCase() + data.status.slice(1) + '</span>');
	      }
	      if(data.status == 'delivered') {
	        $('#singleorderstatus' + data.id).append('<span class="label label-success">' + data.status.charAt(0).toUpperCase() + data.status.slice(1) + '</span>');
	        $('#canbtn' + data.id).remove();
	        $('#fullcanbtn').remove();
	      }
	      if(data.status == 'returned') {
	        $('#singleorderstatus' + data.id).append('<span class="label label-danger">' + data.status.charAt(0).toUpperCase() + data.status.slice(1) + '</span>');
	      }
	      if(data.status == 'return_request') {
	        $('#singleorderstatus' + data.id).append('<span class="label label-warning">Return Request</span>');
	      }
	      if(data.status == 'cancel_request') {
	        $('#singleorderstatus' + data.id).append('<span class="label label-warning">Cancelation Request</span>');
	      }
	      $('#ifnologs').html('');
	      if(userrole == 'a') {
	        $('#logs').prepend('<p><small>' + data.lastlogdate + ' • For Order <b>' + data.proname + '( ' + data.variant + ' ) [' + data.invno + ']</b>: <span class="required"><b>'+username+'</b> (Admin)</span> changed status to <b>' + data.dstatus + '</b> </small></p>');
	      } else {
	        $('#logs').prepend('<p><small>' + data.lastlogdate + ' • For Order ' + data.proname + '(' + data.variant + ')[' + data.invno + ']: <span class="text-blue"><b>'+username+' (Vendor)</b></span> changed status to <b>' + data.dstatus + ' </b></small></p>');
		  }
		  
		  toastr.success('For ' + data.invno + ' status changed to ' + data.dstatus, data.dstatus, {timeOut: 2500});
	   
	      
	      $('.preL').fadeOut();
		  $('.preloader3').fadeOut();
		  
	    }
	  });
	}