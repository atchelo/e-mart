<script>
    $(function () {

      'use strict';
      
      var table = $('#userTable').DataTable({
          processing: true,
          serverSide: true,
          responsive : true,
          searchdelay : 500,
          ajax: {
          url: "{{ route('users.index') }}",
            data: function (d) {
                  d.filter = $('.filter').val()
              }
          },
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable : false,orderable : false},
              {data: 'image', name: 'image',searchable : false},
              {data : 'detail', name: 'users.name'},
              {data : 'timestamp', name : 'users.created_at', searchable : false},
              {data : 'status', name: 'users.status',searchable : false},
              {data : 'action', data : 'action',searchable : false,orderable : false}       
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'desc']]
      });

      $('.filter').on('change',function(){
        table.draw();
      });
      
    });
  </script>