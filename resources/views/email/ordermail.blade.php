@component('mail::message')

@component('mail::button', ['url' => '#'])
{{ __('Order') }} <b>{{ __('#') }}{{$inv_cus->order_prefix.$neworder->order_id}}</b>
@endcomponent

<h2 align="center">{{ __('Order #') }}{{ $inv_cus->order_prefix.$neworder->order_id }} {{ __('placed successfully !') }}</h2>
<hr>
<table align="center" class="table table-bordered">
<thead>
<th>{{ __('Order Date') }}</th>
<th>{{ __('Pay Method') }}</th>
<th>{{ __('TXN ID') }}</th>
</thead>
<tbody>
<tr>
<td>
{{ date('d/m/Y',strtotime($neworder->created_at)) }}
</td>
<td>
<center>{{ $neworder->payment_method }}</center>
</td>
<td>
{{ $neworder->transaction_id }}
</td>
</tr>
</tbody>
</table> 
<hr>
<br>
<table class="table table-striped table-bordered">
<thead>
<tr>
<th colspan="2">{{ __('Product Detail') }}</th>
<th align="">{{ __('Qty') }}</th>
<th align="">{{ __('Subtotal') }}</th>
</tr>
</thead>
@foreach($neworder->invoices as $invoice)
	<tr>
		

<td align="center">
	@php
		$orivar = App\AddSubVariant::withTrashed()->findorfail($invoice->variant_id);

		$varcount = count($orivar->main_attr_value);
		$i=0;
			$var_name_count = count($orivar['main_attr_id']);
			unset($name);
      	$name = array();
      	$var_name;

        $newarr = array();
        for($i = 0; $i<$var_name_count; $i++){
          $var_id =$orivar['main_attr_id'][$i];
          $var_name[$i] = $orivar['main_attr_value'][$var_id];
           
            $name[$i] = App\ProductAttributes::where('id',$var_id)->first();
            
        }


      try{
        $url = url('details').'/'.$orivar->products->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
      }catch(Exception $e)
      {
        $url = url('details').'/'.$orivar->products->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
      }

		@endphp
<img width="70px" height="70px" src="{{url('variantimages/'.$orivar->variantimages['image2'])}}" alt="">
</td>
<td width="50%">
<a class="margin-left-15" target="_blank" title="Click to view" href="{{ url($url) }}"><b>{{$orivar->products->name}}</b>
<small>
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
</small>
</a>
<small class="margin-left-15"><b>{{ __('Sold By:') }}</b> {{$orivar->products->store->name}}</small>
</td>
</td>
<td align="center">
{{ $invoice->qty }}
</td>
<td align="center">
{{  $paidcurrency }} {{ round($invoice->qty*$invoice->price+$invoice->tax_amount+$invoice->shipping,2) }}
</td>
</tr>
@endforeach					
</table>
<hr>
<table class="table table-bordered width100" align="right">
<tr>
<td>{{ __('Handling Charge:') }}</td>
<td><b>{{ $paidcurrency }} + {{ $neworder->handlingcharge ? $neworder->handlingcharge : "0.00" }}</b></td>
</tr>
<tr>
<td>{{ __('Coupon Discount:') }}</td>
<td><b>{{ $paidcurrency }} - {{ sprintf("%.2f",$neworder->discount) }}</td>
</tr>
<tr>
<td>{{ __('Grand Total:') }}</td>
<td><b>{{ $paidcurrency }} @if($neworder->discount != 0 ) {{ ($neworder->order_total-$neworder->discount)+$neworder->handlingcharge  }} @else {{ $neworder->order_total+$neworder->handlingcharge }}@endif</b>
</td>
</tr>
</table>
<p>{{ __('Thanks,') }}</p>
<p>{{ config('app.name') }}</p>
<br><br>
<code class="font-size-12">{{ __('This is system generated mail please do not replay to this mail.') }}</code>
@endcomponent