$(function () {

      "use strict";
      
      var table = $('#store_table').DataTable({
          processing: true,
          serverSide: true,
          responsive : true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'logo', name: 'logo', searchable:false},
              {data: 'info', name: 'info'},
              {data: 'username', name: 'username'},
              {data: 'status', name: 'status'},
              {data: 'apply', name: 'apply',searchable:false},
              {data: 'rd', name: 'rd',searchable:false},
              {data: 'action', name: 'action',searchable:false},
                 
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'desc']]
      });
      
});