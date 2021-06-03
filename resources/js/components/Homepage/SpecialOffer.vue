<template>
        <div class="mb-lg-2 mb-md-1 mb-sm-1 sidebar-widget">
            <h3 class="section-title">{{ translate('staticwords.sp') }}</h3>
            <div class="sidebar-widget-body outer-top-xs">
                <div :class="{'owl-rtl' : rtl == true}"
                    class="owl-carousel special-offer-carousel special-offer custom-carousel owl-theme">
                    <div v-for="item in specialoffers" :key="item.productid" class="item">
                        <div class="products special-product">
                            <div class="product">
                                <div class="product-micro">
                                    <div class="row product-micro-row">
                                        <div class="col col-5">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a :href="item.producturl">
                                                        <img class="owl-lazy" :data-src="item.thumbnail" />
                                                        <img class="owl-lazy hover-image"
                                                            :data-src="item.hover_thumbnail" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-6">
                                            <div class="product-info">
                                                <h3 class="name">
                                                    <a :href="item.producturl">
                                                        {{item.productname[lang] ? item.productname[lang] : item.productname[fallbacklang]}}
                                                    </a>
                                                </h3>

                                                <div class="pull-left">
                                                    <div v-if="item.rating != 0" class="star-ratings-sprite"><span
                                                            :style="{'width' : `${item.rating}%`}"
                                                            class="star-ratings-sprite-rating"></span></div>
                                                    <div v-else>
                                                        No Rating
                                                    </div>
                                                </div>

                                                <div v-if="guest_price == '0' || login == 1" class="product-price">
                                                    <span class="price">

                                                        <div v-if="item.offerprice == 0">
                                                            <span class="price">
                                                                <i v-if="item.position == 'l' || item.position == 'ls'" :class="item.symbol"></i>
                                                                <span v-if="item.position == 'ls'">&nbsp;</span>
                                                                {{ item.mainprice }}</span>

                                                                <span v-if="item.position == 'rs'">&nbsp;</span>
                                                                <i v-if="item.position == 'r' || item.position == 'rs'" :class="item.symbol"></i>
                                                        </div>


                                                        <div v-else>
                                                            <span class="price">
                                                                <i :class="item.symbol"></i>
                                                                    {{ item.offerprice }}
                                                            </span>
                                                            <span class="price-before-discount">
                                                                <i v-if="item.position == 'l' || item.position == 'ls'" :class="item.symbol"></i>
                                                                <span v-if="item.position == 'ls'">&nbsp;</span>
                                                                
                                                                {{ item.mainprice }}

                                                                <span v-if="item.position == 'rs'">&nbsp;</span>
                                                                <i v-if="item.position == 'r' || item.position == 'rs'" :class="item.symbol"></i>
                                                            </span>
                                                        </div>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        props: ['specialoffers', 'lang', 'fallbacklang', 'guest_price', 'login'],
        data() {
            return {
                rtl: rtl,
                loading: true
            }
        },
        created() {
            // setTimeout(() => {

            var vm = this;

            Vue.nextTick(function () {

                $(".special-offer-carousel").owlCarousel({
                    items: 1,
                    itemsTablet: [978, 1],
                    itemsDesktopSmall: [979, 2],
                    itemsDesktop: [1199, 1],
                    nav: true,
                    slideSpeed: 300,
                    pagination: false,
                    lazyLoad: true,
                    paginationSpeed: 400,
                    navText: ["<i class='icon fa fa-angle-left'></i>",
                        "<i class='icon fa fa-angle-right'></i>"
                    ],
                    rtl: rtl
                });

            }.bind(vm));

            this.loading = false;

            // }, 3000);
        }
    }
</script>