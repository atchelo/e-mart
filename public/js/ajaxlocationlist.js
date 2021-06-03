"use strict";
        
  $('#country_id').on('change',function() {
          var up = $('#upload_id').empty();
            var up1 = $('#city_id').empty();
            var cat_id = $(this).val(); 
            
            if(cat_id){
              $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: baseUrl+'/choose_state',
                data: {catId: cat_id},
                success:function(data){   
                  $('#country_id').append('<option value="">Please Choose</option>');
                  up.append('<option value="">Please Choose</option>');
                  up1.append('<option value="">Please Choose</option>');
                  $.each(data, function(id, title) {
                    up.append($('<option>', {value:id, text:title}));
                  });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  console.log(XMLHttpRequest);
                }
              });
            }
          });

         

          $('#upload_id').on('change',function() {

               
            var up = $('#city_id').empty();
            var cat_id = $(this).val();    
            if(cat_id){

              $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: baseUrl+'/choose_city',
                data: {catId: cat_id},
                success:function(data){   
                  
                  up.append('<option value="0">Please Choose</option>');
                  $.each(data, function(id, title) {
                    up.append($('<option>', {value:id, text:title}));
                  });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  console.log(XMLHttpRequest);
                }
              });
            }
          });
 