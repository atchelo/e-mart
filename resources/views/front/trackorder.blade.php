@extends('front.layout.master')
@section('stylesheet')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}"/>
@endsection
@section('title','Track order | ')
@section('body')

<div class="mb-1" id="trackorder">
    <track-order :trackid="'{{ app('request')->input('trackingid') }}'"></track-order>
</div>


@endsection
@section('script')
   <script>var baseURL = @json(url('/'));</script>
   <script src="{{ url('js/trackorder.js') }}"></script> 
@endsection