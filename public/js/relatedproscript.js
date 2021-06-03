"use strict";
        
     // Define your library strictly...
  function changesetting(){

  	if ($('#rel_set').is(':checked')) {
  			$.ajax({

  			method : 'GET',
  			data   :  { status : 1 },
  			url    : url,
  			beforeSend: function() {
	            $('.preL').fadeIn();
	            $('.preloader3').fadeIn();
	            $('.box,.main-header,.main-sidebar').css({ '-webkit-filter':'blur(5px)'});
            },
            success : function(data){

				 $('.preL').fadeOut();
	             $('.preloader3').fadeOut();
	             $('.box,.main-header,.main-sidebar').css({ '-webkit-filter':''});

            	if(data == 'success'){

            		$('#manuallyProShow').show('fast');

	            	 var animateIn = "lightSpeedIn";
                     var animateOut = "lightSpeedOut";

	                    PNotify.success({
	                      title: 'Updated',
	                      text: 'Setting Updated !',
	                      icon : 'fa fa-check-circle',
	                      modules: {
	                        Animate: {
	                          animate: true,
	                          inClass: animateIn,
	                          outClass: animateOut
	                        }
	                      }
	                    });

            		}else{

            			var animateIn = "lightSpeedIn";
                     	var animateOut = "lightSpeedOut";

	                    PNotify.notice({
	                      title: 'Oops !',
	                      text: 'Error in updating setting !',
	                      icon : 'fa fa-times',
	                      modules: {
	                        Animate: {
	                          animate: true,
	                          inClass: animateIn,
	                          outClass: animateOut
	                        }
	                      }
	                    });

            		}
            }
  		});
  	}else{
  		$.ajax({

  			method : 'GET',
  			url    : url,
  			data   :  { status : 0 },
  			beforeSend: function() {
                $('.preL').fadeIn();
                $('.preloader3').fadeIn();
                $('.box,.main-header,.main-sidebar').css({ '-webkit-filter':'blur(5px)'});
            },
            success : function(data){
  	
            	$('#manuallyProShow').hide('fast');

            	 $('.preL').fadeOut();
                 $('.preloader3').fadeOut();
                 $('.box,.main-header,.main-sidebar').css({ '-webkit-filter':''});

            	if(data == 'success'){

                     var animateIn = "lightSpeedIn";
                     var animateOut = "lightSpeedOut";

	                    PNotify.success({
	                      title: 'Updated',
	                      text: 'Setting Updated !',
	                      icon : 'fa fa-check-circle',
	                      modules: {
	                        Animate: {
	                          animate: true,
	                          inClass: animateIn,
	                          outClass: animateOut
	                        }
	                      }
	                    });

            		}else{

            			var animateIn = "lightSpeedIn";
                     	var animateOut = "lightSpeedOut";

	                    PNotify.notice({
	                      title: 'Oops !',
	                      text: 'Error in updating setting !',
	                      icon : 'fa fa-times',
	                      modules: {
	                        Animate: {
	                          animate: true,
	                          inClass: animateIn,
	                          outClass: animateOut
	                        }
	                      }
	                    });

            		}
            }
  		});
  	}

 }