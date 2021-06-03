$(function () {
  "use strict";
  var table = $('#citytable').DataTable({
      processing: true,
      serverSide: true,
      ajax: url,
      columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable : false, searchable : false},
          {data: 'cityname', name: 'allcities.name'},
          {data : 'statename', name: 'allstates.name'},
          {data : 'country', name: 'allcountry.nicename'}    
      ],
      dom : 'lBfrtip',
      buttons : [
        'csv','excel','pdf','print','colvis'
      ],
      order : [[0,'asc']]
  });
  
});
