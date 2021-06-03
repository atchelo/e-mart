 $(function () {

     "use strict";

          $('.kk').on('click',function () {
             var shiping_id  = $(this).attr("id");
                $.ajax({

                     headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url: url,
                data: {catId: shiping_id},
                dataType: 'html',
                success:function(data){
                    
                  $('#flash-message').html(data).slideDown(500);
    
               }

              });
               
                   setTimeout(function() {
                      $("#flash-message").slideUp(500);
                  }, 2000); 
            });
});