@component('mail::message')
# {{$msg}} {{ $pro }}

## {{ __('By') }} {{ $user }}

@component('mail::button', ['url' => config('app.url').'/admindesk/'.'review_approval'])
{{ __('You can view and approve this review by clicking here') }}
@endcomponent

<p>{{ __("or if this don't work manually copy this link and paste it") }}</p>
<a href="{{ config('app.url').'/admindesk/'.'review_approval' }}">{{ config('app.url').'/admindesk/'.'review_approval' }}</a>
<hr>
<code>
{{ __('This review is currently not active after approve this it will be visible on product page to other users.') }}
</code>
<hr>
<code class="font-size-12">{{ __('This is system generated mail please do not replay to this mail.') }}</code>
<br>
{{ __('Thanks,') }}
<hr>
{{ config('app.name') }}
@endcomponent
