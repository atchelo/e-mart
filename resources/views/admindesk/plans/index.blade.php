@extends('admindesk.layouts.master')
@section('title','Plans | ')
@section('body')
@component('components.box',['border' => 'with-border'])

@slot('header')
<div class="box-title">
    {{ __("Plans")}}
</div>

<a href="{{ route('seller.subs.plans.create') }}" class="pull-right btn btn-md btn-success">
    <i class="fa fa-plus"></i> {{__("Create new plan")}}
</a>
@endslot

@slot('boxBody')

<table style="width: 100%" id="plans" class="table table-striped table-bordered">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Price</th>
        <th>Period</th>
        <th>Features</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
</table>

@endslot

@endcomponent
@endsection
@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#plans').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("seller.subs.plans.index") }}',
            language: {
                searchPlaceholder: "Search in plans..."
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'seller_plans.id',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'name',
                    name: 'seller_plans.name'
                },
                {
                    data: 'price',
                    name: 'seller_plans.price'
                },
                {
                    data: 'period',
                    name: 'seller_plans.validity'
                },
                {
                    data: 'features',
                    name: 'features',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'status',
                    name: 'seller_plans.status',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable : false
                },
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            order: [
                [0, 'DESC']
            ]
        });

    });
</script>
@endsection