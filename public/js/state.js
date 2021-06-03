 $(function () {

      "use strict";
      
      var table = $('#state_table').DataTable({
          processing: true,
          serverSide: true,
          responsive : true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
              {data: 'statename', name: 'allstates.name'},
              {data : 'cname', name: 'allcountry.nicename'}         
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'asc']]
      });
      
});