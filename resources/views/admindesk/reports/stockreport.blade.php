@extends('admindesk.layouts.master')
@section('title','Stock reports all products')
@section('body')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Stock Report
            </div>
        </div>

        <div class="box-body">
            <table id="stock_report" class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th>Product name</th>
                    <th>Variant detail</th>
                    <th>Store name</th>
                    <th>Stock</th>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        $(function () {
            "use strict";
            var table = $('#stock_report').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admindesk.stock.report") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'products.name'},
                    {data : 'variant', name : 'variant'},
                    {data : 'store_name', name : 'products.store.name'},
                    {data : 'stock', name : 'add_sub_variants.stock'}
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print','colvis'
                ],
                order : [[0,'DESC']]
            });
            
        });
    </script>
@endsection