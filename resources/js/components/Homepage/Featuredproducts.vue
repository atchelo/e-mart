<template>
    <section class="mt-2 section new-arriavls feature-product-block">
        
        <h3 class="section-title">{{ translate('staticwords.fpro') }}</h3>
       
       <div>
           <product-slider v-if="products" :products="products" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="login" :guest_price="guest_price"></product-slider>

            <div v-else>
                <slider-skelton :item="6"></slider-skelton>
            </div>
       </div>
        
        <!-- /.home-owl-carousel -->
    </section>
</template>

<script>
    export default {
        props: ['products','date','lang','fallbacklang','login','guest_price']
    }
</script>
