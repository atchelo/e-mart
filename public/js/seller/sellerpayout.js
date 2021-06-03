"use strict";

  function trackstatus(id){
    
    
    $.ajax({
        type : 'GET',
        url  : url+'/'+id,
        dataType : 'html',
        success : function(data){
          
          $('#trackstatus').html('');
          $('#trackstatus').append(data);
          $('#trackmodal').modal('show');
        }
    });

    
  }

$(function (){

      var table = $('#completedPayouts').DataTable({
          processing: true,
          serverSide: true,
          responsive : true,
          dataType : 'json',
          ajax: sellerpayouturl,
          columns: [

              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'type', name: 'type'},
              {data: 'orderid', name: 'orderid'},
              {data: 'amount', name: 'amount'},
              {data: 'detail', name: 'detail'},
              {data: 'paidon', name: 'paidon'},
              {data: 'action', name: 'action'}
              
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'desc']]
      });
      
});