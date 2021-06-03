<script>
  @if($enable_hotdeal->home == "1")

  $(function () {

    "use strict";

     var d = new Date();
      var datestring = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
      ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
       var pausecontent = new Array();
       var hotdeals = '{{ count($hotdeals) }}';
    
        @foreach($hotdeals as $key => $val)
            
            var start = '{{$val['start']}}';
            var end = "{{ $val['end'] }}";

            if(start <= datestring && end >= datestring){
              
              pausecontent.push('{{ $val }}');
             

            }else{

            }
        
        @endforeach
       
       if(pausecontent.length == 0){
         $('.hot-deals').remove();
       }
   
    
  });
@endif
</script>