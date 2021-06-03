@extends('admindesk.layouts.master')
@section('title','Manual Payment Gateway')
@section('body')
@component('components.box',['border' => 'with-border'])
@slot('header')
<div class="box-title">
    Manual Payment Gateway
</div>

<div class="pull-right">
    <a data-toggle="modal" data-target="#addPaymentModal" href="" class="btn btn-md btn-success">
        <i class="fa fa-plus"></i> Add New
    </a>
</div>

@endslot

@slot('boxBody')
<table style="width:100%" id="full_detail_table" class="table table-bordered">
    <thead>
        <th>
            #
        </th>
        <th>
            Payment Gateway Name
        </th>
        <th>
            Action
        </th>
    </thead>
    <tbody>
        @foreach($methods as $key=> $m)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{  ucfirst($m->payment_name) }}</td>
            <td>
                <a data-toggle="modal" data-target="#editPaymentmethod{{ $m->id }}" class="btn btn-sm btn-success">
                    <i class="fa fa-pencil"></i>
                </a>

            <a data-toggle="modal" data-target="#deletepaymentmethod{{ $m->id }}" class="btn btn-sm btn-danger">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>

        <!-- Edit Payment Method Modal -->

        <div data-backdrop="false" id="editPaymentmethod{{ $m->id }}" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="editPaymentModal-title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="editPaymentModal-title">Edit Payment method: {{ $m->payment_name }}
                        </h5>

                    </div>
                    <div class="modal-body">
                        <form action="{{ route('manual.payment.gateway.update',$m->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="form-group">
                                <label for="">
                                    Payment method name: <span class="text-red">*</span>
                                </label>
                                <input required type="text" value="{{ $m['payment_name'] }}" name="payment_name"
                                    class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="">
                                    Payment Instructions : <span class="text-red">*</span>
                                </label>

                                <textarea name="description" id="" cols="30" rows="5"
                                    class="form-control editor">{!! $m['description'] !!}</textarea>

                            </div>

                            <div class="form-group">
                                <label for="">
                                    Image :
                                </label>
                                <input type="file" class="form-control" name="thumbnail">
                            </div>

                            <div class="form-group">
                                <label>Status :</label>
                                <br>
                                <label class="switch">
                                    <input id="status" type="checkbox" name="status"
                                        {{ $m['status'] == 1 ? "checked" : "" }}>
                                    <span class="knob"></span>
                                </label>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Payment -->
    <div id="deletepaymentmethod{{ $m->id }}" class="delete-modal modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="delete-icon"></div>
                </div>
                <div class="modal-body text-center">
                  <h4 class="modal-heading">Are You Sure ?</h4>
                <p>Do you really want to delete this Payment method <b>{{ $m->payment_name }}</b>? This process cannot be undone.</p>
                </div>
                <div class="modal-footer">
                  <form method="post" action="{{ route('manual.payment.gateway.delete',$m->id) }}" class="pull-right">
                    @csrf
                    <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <!-- END -->

        @endforeach
    </tbody>
</table>
@endslot

@endcomponent

<!-- Create Payment Method Modal -->

<div data-backdrop="false" id="addPaymentModal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="addPaymentModal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="addPaymentModal-title">Add new payment method</h5>

            </div>
            <div class="modal-body">
                <form action="{{ route('manual.payment.gateway.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="">
                            Payment method name: <span class="text-red">*</span>
                        </label>
                        <input required type="text" value="{{ old('payment_name') }}" name="payment_name"
                            class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="">
                            Payment Instructions : <span class="text-red">*</span>
                        </label>

                        <textarea name="description" id="" cols="30" rows="5"
                            class="form-control editor">{!! old('description') !!}</textarea>

                    </div>

                    <div class="form-group">
                        <label for="">
                            Image :
                        </label>
                        <input type="file" class="form-control" name="thumbnail">
                    </div>

                    <div class="form-group">
                        <label>Status :</label>
                        <br>
                        <label class="switch">
                            <input id="status" type="checkbox" name="status" {{ old('status') ? "checked" : "" }}>
                            <span class="knob"></span>
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-success">
                            <i class="fa fa-plus-circle"></i> Create
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection