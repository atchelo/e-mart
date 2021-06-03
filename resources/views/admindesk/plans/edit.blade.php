@extends('admindesk.layouts.master')
@section('title','Edit Plan: '.$plan->name.' | ')
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

        <form action="{{ route('seller.subs.plans.update',$plan->id) }}" method="POST">
            @csrf
            @method("PUT")
            <div class="form-group">
                <label>Plan name: <span class="text-danger">*</span></label>
                <input value="{{ $plan->name }}" name="name" required type="text" class="form-control" placeholder="eg: Premium">
            </div>

            <div class="form-group">
                <label>Plan price: <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-addon">
                        {{ $defaultCurrency->symbol }}
                    </span>
                    <input value="{{ $plan->price }}" required type="number" name="price" min="1" step="0.01" class="form-control" placeholder="eg: 10">
                </div>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="detail" class="form-control editor" rows="3">{{ $plan->detail }}</textarea>

            </div>

            <div class="form-group">
                <label>Place validity: <span class="text-danger">*</span></label>
                <input value="{{ $plan->validity }}" name="validity" min="1" required type="number" step="1" class="form-control" placeholder="eg: 1">
                <small class="text-muted">
                    <i class="fa fa-question-circle"></i> Validity of your plan in numbers eg: 1 month, year, week day
                </small>
            </div>

            <div class="form-group">
                <label>Plan period: <span class="text-danger">*</span></label>
                <select required name="period" id="" class="form-control select2"
                    data-placeholder="Please select plan period">
                    <option value="">Please select plan period</option>
                    <option {{ $plan->period == 'day' ? "selected" : "" }} value="day">Day</option>
                    <option {{ $plan->period == 'week' ? "selected" : "" }} value="week">Week</option>
                    <option {{ $plan->period == 'month' ? "selected" : "" }} value="month">Month</option>
                    <option {{ $plan->period == 'year' ? "selected" : "" }} value="year">Year</option>
                </select>
            </div>

            <div class="form-group">
                <label>Product create/upload limit: <span class="text-danger">*</span></label>
                <input value="{{ $plan->product_create }}" name="product_create" min="1" required type="number" step="1" class="form-control"
                    placeholder="100">
            </div>

            <div class="form-group">
                <label>Enable CSV Product Upload:</label>
                <br>
                <label class="switch">
                    <input {{ $plan->csv_product == 1 ? "checked" : "" }} type="checkbox" name="csv_product" />
                    <span class="knob"></span>
                </label>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <br>
                <label class="switch">
                    <input {{ $plan->status == 1 ? "checked" : "" }} type="checkbox" name="status" />
                    <span class="knob"></span>
                </label>
            </div>

            <div class="form-group">
                <button class="btn btn-md btn-success">
                    <i class="fa fa-save"></i> {{__("Update")}}
                </button>
            </div>

        </form>

        @endslot

        @endcomponent
    </div>
</div>
@endsection