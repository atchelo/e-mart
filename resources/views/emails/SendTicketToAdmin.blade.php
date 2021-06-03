@component('mail::message')
# {{ "\#" }}{{ $hd->ticket_no }} {{ __('ticket request has been Recieved from') }} {{ $get_user_name }} !

#{{ $hd->issue_title }}
{{ strip_tags($hd->issue) }}

<br>
{{ config('app.name') }}
@endcomponent