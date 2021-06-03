@component('mail::message')
# {{ $msg }}
@if($type == 'paypal')
<p>
<b>{{ __('Hello You recived a new payout! kindly go to your Paypal account and claim the amount else if it unclamied than its auto refund to us after 30 days of payment sent.') }}</b>
</p>
@else
<p>
<b>{{ __('Hello You recived a new payout! via banktransfer.') }}</b>
</p>
@endif
@component('mail::button', ['url' => '#'])
	{{ $currency }}	{{ $amount }}
@endcomponent
@if($type == 'paypal')
<code>
{{ __("If you don't have Paypal account check your email for Paypal payout email and signup with link that given by Paypal and claim the amount !") }}
</code>
@else
<code>
{{ __('Bank transfer take 2-3 days or same day for reflect amount in your bank. So kindly wait !') }}
</code>
@endif
<hr>
{{ __('Payout Summary') }}
<hr>
<div align="center">
<h2>{{ $currency }}	{{ $amount }}</h2>
</div>
<hr>
{{ __('Thanks, for using') }} {{ config('app.name') }} {{ __('for selling your product !') }}<br>
{{ config('app.name') }}
@endcomponent
