@php
	$inv = App\Invoice::first();
@endphp

<p><b>#{{ $inv->order_prefix }}{{ $orderid }}</b></p>
<p><small>Invoice No: <b>#{{ $inv->prefix }}{{ $invid }}{{ $inv->prefix }}</b></small></p>
@if($paidvia == 'Paypal')
<small><a class="cursor-pointer" onclick="trackstatus('{{ $txn_id }}')" title="Click to track payout status live">Track Payout Status Live</a></small>
@endif