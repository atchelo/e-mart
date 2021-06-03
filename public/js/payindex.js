$(function () {

      "use strict";
            
      var table = $('#payouttable').DataTable({
          processing: true,
          serverSide: true,
          responsive : true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data : 'type', name: 'type'},
              {data : 'orderid', name: 'orderid'},
              {data : 'amount', name: 'amount'},
              {data : 'detail', name: 'detail'},
              {data : 'action', name: 'action'} 
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'desc']]
          
      });
      
});