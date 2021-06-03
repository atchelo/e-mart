@php

echo Share::Page($currentUrl,null,[],'<div class="row">', '</div>')
      ->facebook()
      ->twitter()
      ->telegram()
      ->whatsapp();
@endphp