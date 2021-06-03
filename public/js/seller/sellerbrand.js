$(function () {

      "use strict";
      
      var table = $('#brandTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searhable : false},
              {data : 'image', name : 'image'},
              {data : 'name', name : 'name'},
              {data : 'status', name : 'status'}
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });
      
});