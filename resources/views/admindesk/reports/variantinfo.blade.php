@foreach($main_attr_value as $k => $getvar)

    {{-- Getting Attribute Names --}}
    @php
    $getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name
    @endphp
    {{-- Getting Attribute Values --}}


    @php
        $getvalname = App\ProductValues::where('id',$getvar)->first();
    @endphp

    <b>{{ $getattrname }}</b> : 

    @if(isset($getvalname) && strcasecmp($getvalname['values'], $getvalname['unit_value']) !=0 &&
    $getvalname->unit_value != null )

    @if($getvalname->proattr->attr_name == "Color" || $getvalname->proattr->attr_name ==
    "Colour" || $getvalname->proattr->attr_name == "color" ||
    $getvalname->proattr->attr_name == "colour")
    {{ $getvalname['values'] }}
    @else
    {{ $getvalname['values'] }}{{ $getvalname->unit_value }},
    @endif


    @else
    {{ $getvalname['values'] ?? ''}},
    @endif
@endforeach