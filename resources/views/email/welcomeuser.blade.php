@component('mail::message')
# {{ __('Welcome') }} {{ $user->name }}

{{ __('Welcome to our portal.') }}
<br>
{{ __('Your Registred email id with us is') }} {{ $user->email }}

@component('mail::button', ['url' => config('app.url')])
{{ __('Start Shopping !') }}
@endcomponent

{{ __('Thanks,') }}
<br>
{{ config('app.name') }}
@endcomponent
