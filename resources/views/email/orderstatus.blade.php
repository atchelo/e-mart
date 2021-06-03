@component('mail::message')

{{ __('For Order') }} <b>#{{ $inv_cus->order_prefix.$inv->order->order_id }}</b> {{ __('following item has been') }} {{ $status }}.

@php
	$orivar = App\AddSubVariant::withTrashed()->findorfail($inv->variant_id);
	$i=0;
	$varcount = count($orivar->main_attr_value);
@endphp
<p>{{ __('Item ') }} <b>{{$orivar->products->name}}</b>
(@foreach($orivar->main_attr_value as $key=> $orivars)
<?php $i++; ?>
@php
$getattrname = App\ProductAttributes::where('id',$key)->first()->attr_name;
$getvarvalue = App\ProductValues::where('id',$orivars)->first();
@endphp
@if($i < $varcount)
@if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
@if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
{{ $getvarvalue->values }},
@else
{{ $getvarvalue->values }}{{ $getvarvalue->unit_value }},
@endif
@else
{{ $getvarvalue->values }},
@endif
@else
@if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null)
@if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour")
{{ $getvarvalue->values }}
@else
{{ $getvarvalue->values }}{{ $getvarvalue->unit_value }}
@endif
@else
{{ $getvarvalue->values }}
@endif
@endif
@endforeach
) 
{{ __('has been') }} <b>{{ $status }}</b>.
</p>
{{ __('Thanks,') }}
<br>
{{ config('app.name') }}
@endcomponent
