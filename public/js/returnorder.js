"use Strict";

$('.source').on('click',function(){
	
	var source = $(this).val();

	if(source == 'orignal'){
		$('#bank_box').hide();
		$('#bank_id').hide();
		$('#bank_id').removeAttr('required');
	}else{
		$('#bank_box').show();
		$('#bank_id').show();
		$('#bank_id').attr('required','required');
	}
	
});