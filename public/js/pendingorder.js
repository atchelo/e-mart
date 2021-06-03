"use strict";

function orderget(id){

	$.ajax({
		method : 'GET',
		data : {orderid : id},
		url  : url,
		datatype : 'html',
		success : function(data){
			$('.quickorderview').html(data.orderview).css('right', '-1000px');
			setTimeout(function() {
				if($('#orderbox'+id).parent().hasClass('col-md-12')){
					$('#orderbox'+id).parent().removeClass('col-md-12').addClass('col-md-8');
				}
			}, 1);

			$('.quickorderview').animate({
		          right: '0px'
		      }).show();
			
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
	        console.log('Error: '+errorThrown);
	    }   
	});

}

function collapseorder(id){
	
	$('.quickorderview').animate({
		          right: '-1000px'
	});
	setTimeout(function() {
		if($('#orderbox'+id).parent().hasClass('col-md-8')){
		$('#orderbox'+id).parent().removeClass('col-md-8').addClass('col-md-12');
		$('.quickorderview').html('');
	}
}, 250);
	
}