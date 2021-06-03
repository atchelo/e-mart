<template>
    <div>
        <div id="product-tabs-slider" class="mt-2 scroll-tabs">
            <div class="more-info-tab clearfix ">

                <h3 class="new-product-title pull-left">{{ translate('staticwords.newprods') }}</h3>
                <div class="scroller scroller-left"><i class="fa fa-angle-left"></i></div>
                <div class="scroller scroller-right"><i class="fa fa-angle-right"></i></div>

                <!-- /.nav-tabs -->
            </div>



            <b-tabs pills vertical nav-wrapper-class="w-45" content-class="mt-3">
                
               

                <b-tab @click="loadTab('all')" title="All">
                    <product-slider v-if="tabbed_products" :products="tabbed_products" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="login" :guest_price="guest_price"></product-slider>
                </b-tab>

                <b-tab @click="loadTab(cat.id)" v-for="(cat,index) in tabbed_cats" :key="index" :title="cat.title[lang]  ? cat.title[lang] : cat.title[fallbacklang]">
                    <product-slider v-if="!loading" :products="allproducts" :date="date" :lang="lang" :fallbacklang="fallbacklang"
                        :login="login" :guest_price="guest_price"></product-slider>
                    <div v-else>
                        <slider-skelton :item="6"></slider-skelton>
                    </div>
                </b-tab>
            </b-tabs>

        </div>


    </div>
</template>

<script>

    export default {
        props: [
            'lang', 'date', 'fallbacklang', 'login', 'guest_price','tabbed_products','tabbed_cats'
        ],
        data() {
            return {
                allproducts: [],
                loading : true
            }
        },
        methods: {

            
            async loadTab(cat) {

                this.loading = true;

                $('.home-owl-carousel').trigger('destroy.owl.carousel');

                await axios.get(`/vue/click-tabbed-products/${cat}`).then(res => {

                    this.allproducts = res.data;

                    this.loading = false;

                }).catch(err => console.log(err));
            }

        }
    }
</script>

<style>

</style>