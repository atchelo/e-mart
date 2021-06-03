$(function () {
      "use strict";
      var table = $('#commenttable').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false},
              {data : 'name', name : 'name'},
              {data : 'comment', name : 'comment'},
              {data : 'action', name : 'action'},
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });
      
});