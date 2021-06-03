$(function () {
      "use strict";
      var table = $('#brandTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          language: {
            searchPlaceholder: "Search Brands..."
          },
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false},
              {data : 'name', name : 'name'},
              {data : 'image', name : 'image'},
              {data : 'status', name : 'status'},
              {data : 'action', name : 'action'},
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });
      
});