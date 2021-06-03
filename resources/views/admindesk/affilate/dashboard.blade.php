@extends('admindesk.layouts.master')
@section('title','Affiliate Reports | ')
@section('body')
@component('components.box',['border' => 'with-border'])

    @slot('header')
        <div class="box-title">
            {{ __("Affiliate Reports")}}
        </div>
    @endslot

    @slot('boxBody')
        <table id="report" class="table table-bordered">
            <thead>
                <th>
                    #
                </th>
               
                <th>
                    Refered user
                </th>
                <th>
                    Refered by
                </th>
                <th>
                    Date
                </th>
                <th>
                    Amount
                </th>
            </thead>
            <tbody>

            </tbody>
            <tfoot align="right">
                <tr>
                    <th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </th>
                </tr>
            </tfoot>
        </table>
    @endslot

@endcomponent
@endsection
@section('custom-script')
    <script>

        $(function () {
            "use strict";
            var table = $('#report').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admindesk.affilate.dashboard") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'affilate_histories.id', searchable : false},
                    {data : 'refered_user', name : 'fromRefered.name'},
                    {data : 'user', name : 'user.name'},
                    {data : 'created_at', name : 'affilate_histories.created_at'},
                    {data : 'amount', name : 'affilate_histories.amount'},
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    // converting to interger to find total
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace("{{ $defaultCurrency->symbol }}", '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var grandtotal = api
                            .column( 4 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
                        
                            
                        // Update footer by showing the total with the reference of the column index 
                    $( api.column( 3).footer() ).html('Total');
                        $( api.column( 4 ).footer() ).html("{{ $defaultCurrency->symbol }}"+grandtotal.toFixed(2));
                    },
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print','colvis'
                ],
                order : [[0,'DESC']]
            });
            
        });

    </script>  
@endsection