 $(function () {

     "use strict";
      
      var table = $('#reporttable').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'info', name: 'info'},
              {data: 'rdtl', name: 'rdtl'},
              {data: 'rpon', name: 'rpon'}
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });
      
});