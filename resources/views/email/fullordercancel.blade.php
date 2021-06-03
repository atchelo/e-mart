@component('mail::message')
# {{ __('Order #') }}{{ $inv_cus->order_prefix.$orderid }}

{{ __('Order') }} <b>#{{ $inv_cus->order_prefix.$orderid }} {{ __('has been') }} {{ $status }}</b>

<code class="font-size-12">{{ __('This is system generated mail please do not replay to this mail.') }}</code>

{{ __('Thanks,') }}
<br>
{{ config('app.name') }}
@endcomponent
