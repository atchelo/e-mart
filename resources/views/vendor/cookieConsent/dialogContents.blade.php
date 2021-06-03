<style>
    #cookieWrapper {
        position: fixed;
        bottom: 5px;
        left: 100px;
        right: 100px;
        z-index: 100;
        margin: 0 auto;
        border-radius: 0.5em;
        box-shadow: 0px 0px 2px grey;
        max-width: 50%;
    }
</style>

	<div id="cookieWrapper" class="animated zoomIn bg-primary text-white w-100 py-3 text-center cookierbar js-cookie-consent cookie-consent">
	    <span class="cookie-consent__message">
	        {!! trans('cookieConsent::texts.message') !!}&nbsp;&nbsp;
	    </span>

	    <button class="btn btn-sm btn-warning js-cookie-consent-agree cookie-consent__agree">
	        {{ trans('cookieConsent::texts.agree') }}
	    </button>

    </div>


