@component('mail::message')
{{ __('# Re') }} {{ "\#" }}{{ $hd->ticket_no }} {{ $hd->issue_title }} !

{{ strip_tags($newmsg) }}

<hr>
<p>{{ __("Hi if this doesn't resolve your issue replay this mail or If resolve than replay with Mark as Solved !") }}</p>

{{ __('Thanks,') }}
<br>
{{ config('app.name') }}
@endcomponent
