@extends('front.layout.master')
@section('title','404 | Page Not found !')
@section('body')
@php
   require base_path().'/app/Http/Controllers/price.php'; 
@endphp
<div class="body-content outer-top-bd">
    <div class="container">
        <div class="x-page inner-bottom-sm">
            <div class="row">
                <div class="col-md-12 x-text text-center">
                    <h1>404</h1>
                    <p>We are sorry, the page you've requested is not available. </p>
                    {{-- <form role="form" class="outer-top-vs outer-bottom-xs">
                        <input placeholder="Search" autocomplete="off">
                        <button class="  btn-default le-button">Go</button>
                    </form> --}}
                <a href="{{ url('/') }}"><i class="fa fa-home"></i> Go To Homepage</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection