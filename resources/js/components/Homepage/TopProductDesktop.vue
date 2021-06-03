<template>
    <div v-if="top_products.length != 0">
        <div class="mt-2 top_cat_header feature-product-block">
            <h3 class="cat_title">{{ translate('staticwords.tpc') }}</h3>
        </div>
        <section v-for="(product,index) in top_products" :key="product.index"
            :class="{'mt-0' : index == 0, 'mt-1' : index > 0}"
            class="section-random2 section new-arriavls feature-product-block">
            <h3 class="section-title">
                {{product.category_name[lang]  ? product.category_name[lang] : product.category_name[fallbacklang]}}
            </h3>
            <div>
                <product-slider v-if="product.products" :products="product.products" :date="date" :lang="lang" :fallbacklang="fallbacklang"
                    :login="login" :guest_price="guest_price"></product-slider>
                <div v-else>
                        <slider-skelton :item="6"></slider-skelton>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        props: [
            'lang', 'fallbacklang', 'login', 'guest_price', 'date','top_products','rtl'
        ],
        data() {
            return {
                products: [],
                loading: true,
            }
        }
    }
</script>