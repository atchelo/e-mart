$(function () {

    	"use strict";
      
      var table = $('#ticket_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'ticketno', name: 'ticketno'},
              {data: 'title', name: 'title'},
              {data: 'from', name: 'from'},
              {data: 'status', name: 'status'},
              {data: 'view', name: 'view'}
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });
      
});