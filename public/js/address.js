"use strict";
   
   function pincodetry(id)
   {
    $("#pincode"+id).autocomplete({
        
        source: function(request, response) {
            $.ajax({
            url: findpincodeurl,
            data: {
                    term : request.term
            },
            dataType: "json",
            success: function(data){
              
               var resp = $.map(data,function(obj){

                   return {
                           label: obj.label,
                           value: obj.value,
                           state : obj.id,
                           city : obj.city,
                           country : obj.findcountry
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

                if(ui.item.value)
                {
                  
                    this.value = ui.item.value.replace(/\D/g,'');

                    
                    var up1 = $('#upload_id'+id).empty();
                    var country_id = cnt;
             
            if(country_id){

              $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: choosestateurl,
                data: {catId: country_id},
                success:function(data){   
                  
                 $.each(data, function(id, title) {
                    up1.append($('<option>', {
                      value:id, 
                      text:title}));
                  });

                 $("#edit_country_id"+id+ " option").each(function(){

                        if($(this).val() == cnt){ 
                            $(this).attr("selected","selected");  

                        }else{
                           $(this).removeAttr("selected"); 
                        }

                  });

                  $("#upload_id"+id+ " option").each(function(){

                        if($(this).val() == state){ 
                            $(this).attr("selected","selected");  

                        }else{
                           $(this).removeAttr("selected"); 
                        }

                  });

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  console.log(XMLHttpRequest);
                }
              });
            }
                  
            
            var up = $('#city_id'+id).empty();
           
            if(state){
             
              $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: choosecityurl,
                data: {catId: state},
                success:function(data){   

                    up.append('<option value="">Please Choose</option>');
                  $.each(data, function(id, title) {
                    up.append($('<option>', {value:id, text:title}));
                  });
                    $("#city_id"+id+" option").each(function(){
                      if($(this).val()==c){ 
                          $(this).attr("selected","selected");    
                      }else{
                        $(this).removeAttr("selected");  
                      }
                  }); 
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  
                }
              });
            }
                  return false;

                }
        }

   

 });
}

  function getstate(id){
           
            var ups = $('#upload_id'+id).empty();
            var up1 = $('#city_id'+id).empty();
            var cat_id = $('#edit_country_id'+id).val();
            console.log(cat_id);
            if(cat_id){
              $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: choosestateurl,
                data: {catId: cat_id},
                success:function(data){   
                 

                  ups.append('<option value="">Please Choose</option>');
                  // up1.append('<option value="0">Please Choose</option>');
                  $.each(data, function(id, title) {
                    ups.append($('<option>', {value:id, text:title}));
                  });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  console.log(XMLHttpRequest);
                }
              });
            }

  }  

  function getcity(id){
            var up = $('#city_id'+id).empty();
            
            var cat_id = $('#upload_id'+id).val();    
            
            if(cat_id){
             
              $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: choosecityurl,
                data: {catId: cat_id},
                success:function(data){   
                  
                  $.each(data, function(id, title) {
                    up.append($('<option>', {value:id, text:title}));
                  });

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  
                }
              });
            }
  }




    $( "#pincode" ).autocomplete({
        
        source: function(request, response) {
            $.ajax({
            url: findpincodeurl,
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
              
               var resp = $.map(data,function(obj){

                 
                   return {
                           label: obj.label,
                           value: obj.value,
                           state : obj.id,
                           city : obj.city,
                           country : obj.findcountry
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

                if(ui.item.value)
                {
                  
                    this.value = ui.item.value.replace(/\D/g,'');

                  
                    var up1 = $('#upload_id');
                    var country_id = cnt;
             
            if(country_id){

              $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: choosestateurl,
                data: {catId: country_id},
                success:function(data){   
                  
                 $.each(data, function(id, title) {
                    up1.append($('<option>', {
                      value:id, 
                      text:title}));
                  });

                 $("#country_id option").each(function(){

                        if($(this).val() == cnt){ // EDITED THIS LINE
                            $(this).attr("selected","selected");  

                        }else{
                           $(this).removeAttr("selected"); 
                        }

                  });

                  $("#upload_id option").each(function(){

                        if($(this).val() == state){ // EDITED THIS LINE
                            $(this).attr("selected","selected");  

                        }else{
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
            
              
            
            if(state){
             
              $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: choosecityurl,
                data: {catId: state},
                success:function(data){   

                    up.append('<option value="">Please Choose</option>');
                  $.each(data, function(id, title) {
                    up.append($('<option>', {value:id, text:title}));
                  });
                    $("#city_id option").each(function(){
                      if($(this).val()==c){ // EDITED THIS LINE
                          $(this).attr("selected","selected");    
                      }else{
                        $(this).removeAttr("selected");  
                      }
                  }); 
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  
                }
              });
            }
                  return false;

                }
        },

   
 
    minLength: 3

 });
