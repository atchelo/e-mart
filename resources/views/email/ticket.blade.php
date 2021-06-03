@component('mail::message')
{{ __('#') }} {{ "\#" }}{{ $hd->ticket_no }} {{ __('has been created !') }}

#{{ $hd->issue_title }}
{{ strip_tags($hd->issue) }}

<hr>
{{ __('Sorry for the trouble which occurs to you,') }}
<br>
{{ __('We will get in touch with this email id for further process.') }}
<br>
{{ config('app.name') }}
@endcomponent
