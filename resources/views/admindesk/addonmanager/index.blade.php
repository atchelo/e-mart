@extends('admindesk.layouts.master')
@section('title','Addon Manager | ')
@section('body')


@component('components.box',['border' => 'with-border'])
@slot('header')
<div class="box-title">
    {{ __("Addon Manager")}}
</div>

<a data-target="#installnew" data-toggle="modal" class="pull-right btn btn-md btn-success">
    <i class="fa fa-plus-circle"></i> {{__("Install new add-on")}}
</a>
@endslot

@slot('boxBody')


<table id="modules" class="table table-bordered">
    <thead>
        <th>#</th>
        <th>Logo</th>
        <th>Name</th>
        <th>Status</th>
        <th>Version</th>
        <th>Action</th>
    </thead>

    <tbody>

    </tbody>
</table>

<div data-backdrop="static" data-keyboard="false" id="installnew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="my-modal-title">
                    <b>{{ __("Install new add on") }}</b>
                </h5>
                
            </div>
            <div class="modal-body">
                <form action="{{ route('addon.install') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Enter purchase code: <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Envanto purchase code of your addon" class="form-control" name="purchase_code">
                    </div>

                    <div class="form-group">
                        <label>Choose zip file: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="addon_file">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md bg-purple">
                            <i class="fa fa-arrow-right"></i> {{__("Install")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endslot

@endcomponent
@endsection
@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#modules').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("admindesk/addon-manger") }}',
            language: {
                searchPlaceholder: "Search Modules..."
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'image',
                    name: 'image',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'version',
                    name: 'version'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            order: [
                [0, 'DESC']
            ]
        });

        $('#modules').on('change', '.toggle_addon', function (e) { 

            var modulename = $(this).data('addon');

            if($(this).is(':checked')){
                var status = 1;
            }else{
                var status = 0;
            }

            $.ajax({
                url : '{{ url("admindesk/toggle/module") }}',
                method : 'POST',
                data : {status : status, modulename : modulename},
                success :function(data){
                    table.draw();

                    if(data.status == 'success'){
                        toastr.success(data.msg,{timeOut: 1500});
                    }else{
                        toastr.error(data.msg, 'Oops!',{timeOut: 1500});
                    }
                    
                },
                error : function(jqXHR,err){
                    console.log(err);
                }
            });

        });

    });
</script>
@endsection