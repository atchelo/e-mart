@php
   $pro = App\Product::find($sliders->product_id)
@endphp
@if($pro)
@foreach($pro->subvariants as $key=> $orivar)
@if($orivar->def ==1)

  @php 
      $var_name_count = count($orivar['main_attr_id']);
     
      $name = array();
      $var_name;
         $newarr = array();
        for($i = 0; $i<$var_name_count; $i++){
          $var_id =$orivar['main_attr_id'][$i];
          $var_name[$i] = $orivar['main_attr_value'][$var_id];
            
            $name[$i] = App\ProductAttributes::where('id',$var_id)->first();
            
        }


      try{
       echo $link = url('details').'/'.$sliders->product_id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
      }catch(Exception $e)
      {
        echo $link = url('details').'/'.$sliders->product_id.'?'.$name[0]['attr_name'].'='.$var_name[0];
      }
  @endphp

@endif
@endforeach
@endif