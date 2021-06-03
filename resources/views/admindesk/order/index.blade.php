@extends("admindesk/layouts.master")
@section('title',"All Orders |")
@section("body")

@section('data-field')
Orders
@endsection

  
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">
          Orders
        </h3>
      </div>
        <div class="panel-heading">
            <a type="button" class="btn btn-danger btn-md z-depth-0" data-toggle="modal" data-target="#bulk_delete"><i class="fa fa-trash"></i> Delete Selected</a>
        </div>


      <!-- /.box-header -->
      <div class="box-body">
        <table id="all_orders" class="width100 table table-bordered table-striped">
         <thead>
            <tr>
               <th>
                <div class="inline">
                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                <label for="checkboxAll" class="material-checkbox"></label>
              </div>

              </th>
              <th>ID</th>
              <th>Order Type</th>
              <th>Order Id</th>
              <th>Customer Name</th>
              <th>Total Qty</th>
              <th>Total Amount</th>
              <th>Order Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>


          </tbody>
        </table>

      </div>
      <!-- /.box-body -->
    </div>


<!--bulk delete modal -->

<div id="bulk_delete" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete these orders? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
             <form id="bulk_delete_form" method="post" action="{{ route('order.bulk.delete') }}">
              @csrf
              {{ method_field('DELETE') }}
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>

@endsection

@section('custom-script')
  <script>
      $(function () {
        "use strict";
        var table = $('#all_orders').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('order.index') }}",
            language: {
              searchPlaceholder: "Search orders..."
            },
            columns: [
                {data: 'checkbox', name: 'checkbox', searchable : false, orderable : false},
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                {data : 'order_type', name : 'orders.payment_method'},
                {data : 'order_id', name : 'orders.order_id'},
                {data : 'customer_dtl', name : 'user.name'},
                {data : 'total_qty', name : 'orders.qty_total'},
                {data : 'total_amount', name : 'orders.order_total'},
                {data : 'order_date', name : 'orders.created_at'},
                {data: 'action', name: 'action', searchable : false, orderable : false}
            ],
            dom : 'lBfrtip',
            buttons : [
              'csv','excel','pdf','print','colvis'
            ],
            order : [[7,'DESC']]
        });
        
  });
  </script>
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/order.js') }}"></script>
@endsection