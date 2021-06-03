"use strict";

function submit(id,attr_id){
 	
 	var v = $('#getValue'+id).val();
	var uv = $('#unit_val'+id).val();
 	
 	$.ajax({
 	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
    type : 'GET',
   	data : {newval: v, uval: uv},
    url  : url+'/'+id+'/'+attr_id,
    success : function(data){
        $('#result'+id).html(data).slideDown(500);

        window.setTimeout(function(){

		        location.reload();

		    }, 2500);

    }
  });

 	setTimeout(function() {
         $('#result'+id).slideUp(500);
    }, 2000); 
}

	
$(function () {

	$('.my-colorpicker2').colorpicker();
	$('.my-colorpicker').colorpicker();

});