@extends('admindesk.layouts.master')
@section('title','Most viewed products')
@section('body')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Most viewed products
            </div>
        </div>

        <div class="box-body">
            <table id="most_viewed" class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th>Product name</th>
                    <th>Total views</th>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        $(function () {
            "use strict";
            var table = $('#most_viewed').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admindesk.report.mostviewed") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'name'},
                    {data : 'views', name : 'views'}
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