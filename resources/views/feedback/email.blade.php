@component('mail::message')
# {{ $feedback['name'] }} {{ __('write a feedback on') }} {{ config('app.name') }}

{{ $feedback['msg'] }}.
<br>
{{ __('I Rated ') }}
@component('mail::button', ['url' => '#'])
{{ $feedback['rate'].'/5' }}
@endcomponent

{{ __('From,') }}
<br>
{{ $feedback['name'] }}
@endcomponent
