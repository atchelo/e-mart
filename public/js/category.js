$( function() {
  "use strict";

  $( ".cattable" ).sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
          });
          function sendOrderToServer() {
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.row1').each(function(index,element) {
              order.push({
                id: $(this).attr('data-id'),
                position: index+1
              });
            });
            $.ajax({
              type: "POST", 
              dataType: "json", 
              url: url,
              data: {
                 order: order,
                _token: token
              },
              success: function(response) {
                  if (response.status == "success") {
                    console.log(response);
                  } else {
                    console.log(response);
                  }
              }
            });
          }
        
});
