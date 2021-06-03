@extends('admindesk.layouts.sellermaster')
@section('title','My Subscriptions | ')
@section('body')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            My Subscription
        </div>

        <a href="{{ url('/seller/plans') }}" class="pull-right btn btn-md btn-success">
           <i class="fa fa-credit-card"></i> {{ __("Upgrade Plan")}}
        </a>
    </div>

    <div class="box-body">
        <table id="subs_list" class="table table-bordered">
            <thead>
                <th>
                    #
                </th>
                <th>
                    Plan name
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Transcation ID
                </th>
                <th>
                    Start date
                </th>
                <th>
                    End date
                </th>
                <th>
                    Status
                </th>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#subs_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("seller.my.subscriptions") }}',
            language: {
                searchPlaceholder: "Search in list..."
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'name',
                    name: 'plan.name'
                },
                {
                    data: 'amount',
                    name: 'seller_subscriptions.paid_amount'
                },
                {
                    data: 'txn_id',
                    name: 'seller_subscriptions.txn_id'
                },
                {
                    data: 'start_date',
                    name: 'seller_subscriptions.start_date'
                },
                {
                    data: 'end_date',
                    name: 'seller_subscriptions.end_date'
                },
                {
                    data: 'status',
                    name: 'seller_subscriptions.status',
                    searchable: false,
                    orderable : false
                },
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            order: [
                [4, 'DESC']
            ]
        });

    });
</script>
@endsection