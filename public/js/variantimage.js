  "use strict";
        
    // Define your library strictly...
 
	$('#defimage').on('change',function(){
		
		var defimage = $('#defimage').val();
		var opttext = $('#defimage option:selected').text();
		$.ajax({
			url : url,
			data : {defimage: defimage},
			method : 'GET',
			success : function(data){
				
				if(opttext == 'Image 1'){
					$('#btn-single').hide();
					$('#btn-dis1').show();

					$('#btn-single2').show();
					$('#btn-dis2').hide();

					$('#btn-single3').show();
					$('#btn-dis3').hide();

					$('#btn-single4').show();
					$('#btn-dis4').hide();

					$('#btn-single5').show();
					$('#btn-dis5').hide();

					$('#btn-single6').show();
					$('#btn-dis6').hide();

				}else if(opttext == 'Image 2'){
					
					
					$('#btn-single2').hide();
					$('#btn-dis2').show();

					$('#btn-single').show();
					$('#btn-dis1').hide();

					$('#btn-single3').show();
					$('#btn-dis3').hide();

					$('#btn-single4').show();
					$('#btn-dis4').hide();

					$('#btn-single5').show();
					$('#btn-dis5').hide();

					$('#btn-single6').show();
					$('#btn-dis6').hide();
				}
				else if(opttext == 'Image 3'){
					
					
					$('#btn-single3').hide();
					$('#btn-dis3').show();

					$('#btn-single').show();
					$('#btn-dis1').hide();

					$('#btn-single2').show();
					$('#btn-dis2').hide();

					$('#btn-single4').show();
					$('#btn-dis4').hide();

					$('#btn-single5').show();
					$('#btn-dis5').hide();

					$('#btn-single6').show();
					$('#btn-dis6').hide();
				}
				else if(opttext == 'Image 4'){
					
					
					$('#btn-single4').hide();
					$('#btn-dis4').show();

					$('#btn-single').show();
					$('#btn-dis1').hide();

					$('#btn-single2').show();
					$('#btn-dis2').hide();

					$('#btn-single3').show();
					$('#btn-dis3').hide();

					$('#btn-single5').show();
					$('#btn-dis5').hide();

					$('#btn-single6').show();
					$('#btn-dis6').hide();
				}
				else if(opttext == 'Image 5'){
					
					
					$('#btn-single5').hide();
					$('#btn-dis5').show();

					$('#btn-single').show();
					$('#btn-dis1').hide();

					$('#btn-single2').show();
					$('#btn-dis2').hide();

					$('#btn-single3').show();
					$('#btn-dis3').hide();

					$('#btn-single4').show();
					$('#btn-dis4').hide();

					$('#btn-single6').show();
					$('#btn-dis6').hide();
				}
				else if(opttext == 'Image 6'){
					
					
					$('#btn-single6').hide();
					$('#btn-dis6').show();

					$('#btn-single').show();
					$('#btn-dis1').hide();

					$('#btn-single2').show();
					$('#btn-dis2').hide();

					$('#btn-single3').show();
					$('#btn-dis3').hide();

					$('#btn-single4').show();
					$('#btn-dis4').hide();

					$('#btn-single5').show();
					$('#btn-dis5').hide();
				}
			}
				

		});
});