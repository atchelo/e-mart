$(function () {

      "use strict";

      var table = $('#country_table').DataTable({
          processing: true,
          serverSide: true,
          responsive : true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable : false, searchable : false},
              {data: 'nicename', name: 'allcountry.nicename'},
              {data : 'iso', name: 'allcountry.iso'},
              {data : 'iso3', name: 'allcountry.iso3'},
              {data : 'action', name: 'action', orderable : false, searchable : false}    
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'asc']]
      });
      
});