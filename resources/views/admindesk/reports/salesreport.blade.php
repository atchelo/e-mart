@extends('admindesk.layouts.master')
@section('title','Sales reports all products')
@section('body')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Sales Report
            </div>
        </div>

        <div class="box-body">
            <table id="sales_report" class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th>Product name</th>
                    <th>Variant detail</th>
                    <th>Store name</th>
                    <th>Total sales</th>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        $(function () {
            "use strict";
            var table = $('#sales_report').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admindesk.sales.report") }}',
                language: {
                    searchPlaceholder: "Search in sales reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'products.name'},
                    {data : 'variant', name : 'variant',searchable : false},
                    {data : 'store_name', name : 'products.store.name'},
                    {data : 'sales', name : 'sales'}
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