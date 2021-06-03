@component('mail::message')
# Your Item {{ $vars->products->name }} is back in stock

@php
    $orivar = $vars;
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
{{ __('is back in') }} <b>stock</b>.
</p>

@component('mail::button', ['url' => ''])
Buy Now
@endcomponent

<p>{{ $msg2 }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
