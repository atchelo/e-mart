@component('mail::message')
# {{ $defcurrency }} {{ $amount }} {{ $msg1 }}
<hr>
<b>Transcation ID: <b>{{ $txnid }}</b></b>

@component('mail::button', ['url' => '/userwallet'])
	{{ $msg2 }} <b>{{ $defcurrency }} {{ sprintf("%.2f",$balance) }}</b>
@endcomponent
<hr>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
