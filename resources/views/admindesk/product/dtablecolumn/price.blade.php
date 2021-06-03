<p><b>Entered Price: </b> <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> {{ $vender_price }}</p>

@if($vender_offer_price != '')
<p><b>Entered Offer Price: </b> <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> {{ $vender_offer_price }}</p>
@endif

<small><a id="hellosk" class="cursor ptl" data-proid="{{ $id }}">Additional Price Detail</a></small>

  <!-- Modal -->
<div class="modal fade" id="priceDetail{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog {{ $vender_offer_price != '' ? "modal-lg" : "modal-md" }}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Summary of Pricing for {{ $name[app()->getLocale()] ?? $name[config('translatable.fallback_locale')] }}</h4>
      </div>
      <div id="pricecontent{{ $id }}" class="modal-body">
          
          

        
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

