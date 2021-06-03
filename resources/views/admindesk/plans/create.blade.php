@extends('admindesk.layouts.master')
@section('title','Create a new plan | ')
@section('body')
<div class="row">
    <div class="col-md-8">
        @component('components.box',['border' => 'with-border'])

        @slot('header')
        <div class="box-title">
            {{ __("Create a new plan")}}
        </div>

        <a href="{{ route('seller.subs.plans.index') }}" class="pull-right btn btn-md btn-default">
            <i class="fa fa-arrow-left"></i> {{__("Back")}}
        </a>
        @endslot

        @slot('boxBody')

        <form action="{{ route('seller.subs.plans.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Plan name: <span class="text-danger">*</span></label>
                <input value="{{ old('name') }}" name="name" required type="text" class="form-control" placeholder="eg: Premium">
            </div>

            <div class="form-group">
                <label>Plan price: <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-addon">
                        {{ $defaultCurrency->symbol }}
                    </span>
                    <input value="{{ old('price') }}" required type="number" name="price" min="1" step="0.01" class="form-control" placeholder="eg: 10">
                </div>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="detail" class="form-control editor" rows="3">{{ old('detail') }}</textarea>

            </div>

            <div class="form-group">
                <label>Place validity: <span class="text-danger">*</span></label>
                <input value="{{ old('validity') }}" name="validity" min="1" required type="number" step="1" class="form-control" placeholder="eg: 1">
                <small class="text-muted">
                    <i class="fa fa-question-circle"></i> Validity of your plan in numbers eg: 1 month, year, week day
                </small>
            </div>

            <div class="form-group">
                <label>Plan period: <span class="text-danger">*</span></label>
                <select required name="period" id="" class="form-control select2"
                    data-placeholder="Please select plan period">
                    <option value="">Please select plan period</option>
                    <option {{ old('period') == 'day' ? "checked" : "" }} value="day">Day</option>
                    <option {{ old('period') == 'week' ? "checked" : "" }} value="week">Week</option>
                    <option {{ old('period') == 'month' ? "checked" : "" }} value="month">Month</option>
                    <option {{ old('period') == 'year' ? "checked" : "" }} value="year">Year</option>
                </select>
            </div>

            <div class="form-group">
                <label>Product create/upload limit: <span class="text-danger">*</span></label>
                <input value="{{ old('product_create') }}" name="product_create" min="1" required type="number" step="1" class="form-control"
                    placeholder="100">
            </div>

            <div class="form-group">
                <label>Enable CSV Product Upload:</label>
                <br>
                <label class="switch">
                    <input {{ old('csv_product') ? "checked" : "" }} type="checkbox" name="csv_product" />
                    <span class="knob"></span>
                </label>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <br>
                <label class="switch">
                    <input {{ old('status') ? "checked" : ""}} type="checkbox" name="status" />
                    <span class="knob"></span>
                </label>
            </div>

            <div class="form-group">
                <button class="btn btn-md btn-success">
                    <i class="fa fa-plus"></i> {{__("Create")}}
                </button>
            </div>

        </form>

        @endslot

        @endcomponent
    </div>
</div>
@endsection