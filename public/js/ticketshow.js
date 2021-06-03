"use strict";

function status(id){

	var get = $('#getStatus').val();

	$.ajax({

		headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

		type : 'GET',
		data : "ticketstatus="+get,
		datatype: "json",
		url  : url+'/'+id,

		success: function(data)
		{
			
			$('#msg').html(data).slideDown(500);
			var sendback = '/'
			 window.setTimeout(function(){

			    window.location.href = redirecturl;

			 }, 2500);
			
		}
	});

	setTimeout(function() {
              $("#msg").slideUp(500);
    }, 2000); 

}