<template>
    <div class="row no-pad"> 
        
        <div v-for="cat in products" :key="cat.id" class="col-12">
            <h3 class="section-title mt-1">
                {{cat.category_name[lang]  ? cat.category_name[lang] : cat.category_name[fallbacklang]}}
            </h3>
            <div class="row">
                <div v-for="product in cat.products" :key="product.productid" class="col-6">
                <div class="item item-carousel">

                <div class="products">
                    <div class="product">
                        <div class="product-image">
                            <div :class="{'pro-img-box' : product.stock == 0 }" class="image">

                                <a :href="product.producturl"
                                    :title="product.productname[lang]  ? product.productname[lang] : product.productname[fallbacklang]">

                                    <span v-if="product.thumbnail">
                                        <img class="lazy" :class="{'filterdimage' : product.stock == 0}"
                                            :data-src="product.thumbnail" alt="product_image" />
                                        <img :class="{'filterdimage' : product.stock == 0 }"
                                            class="lazy hover-image" :data-src="product.hover_thumbnail"
                                            alt="product_image" />
                                    </span>


                                    <span v-else>
                                        <img :class="{'filterdimage' : product.stock == 0 }" class="owl-lazy"
                                            :title="product.productname[lang]  ? product.productname[lang] : product.productname[fallbacklang]"
                                            :src="`${baseurl}'/images/no-image.png'}`" alt="No Image" />
                                    </span>


                                </a>
                            </div>


                            <h6 v-if="product.stock == 0" align="center" class="oottext">
                                <span>{{ translate('staticwords.Outofstock') }}</span></h6>

                            <h6 v-if="product.stock != 0 && product.selling_start_at != null && product.selling_start_at >= date"
                                align="center" class="oottext2"><span>{{ translate('staticwords.ComingSoon') }}</span>
                            </h6>

                            <!-- /.image -->




                            <div v-if="product.featured == 1" class="tag hot">
                                <span>{{ translate('staticwords.Hot') }}</span></div>


                            <div v-else-if="product.offerprice != 0" class="tag sale">
                                <span>{{ translate('staticwords.Sale') }}</span></div>

                            <div v-else class="tag new"><span>{{ translate('staticwords.New') }}</span></div>

                        </div>


                        <!-- /.product-image -->

                        <div class="product-info text-left">
                            <h3 class="name text-truncate"><a
                                    :href="product.producturl">{{ product.productname[lang]  ? product.productname[lang] : product.productname[fallbacklang] }}</a>
                            </h3>


                            <div v-if="product.rating != 0" class="pull-left">
                                <div class="star-ratings-sprite"><span :style="{ 'width' : `${product.rating}%` }"
                                        class="star-ratings-sprite-rating"></span></div>
                            </div>

                            <div v-else class="no-rating">No Rating</div>

                            <!-- Product-price -->

                            <div v-if="guest_price == '0'" class="product-price">
                                <span class="price">

                                    <div v-if="product.offerprice == 0">
                                        <span class="price"><i :class="product.symbol"></i>
                                            {{ product.mainprice }}</span>
                                    </div>


                                    <div v-else>
                                        <span class="price"><i
                                                :class="product.symbol"></i>{{ product.offerprice }}</span>
                                        <span class="price-before-discount"><i
                                                :class="product.symbol"></i>{{ product.mainprice }}</span>
                                    </div>

                                </span>
                            </div>

                            <!-- /.product-price -->

                        </div>

                        <div
                            v-if="product.stock != 0 && product.selling_start_at != null && product.selling_start_at >= date">

                        </div>
                        <div v-else class="cart clearfix animate-effect">
                            <div class="action">
                                <ul class="list-unstyled">

                                    <!-- cart condition -->

                                    <li v-show="guest_price == '0'" id="addCart" class="lnk wishlist">

                                        <form @submit.prevent="addToCart(product.cartURL)">
                                            <button :title="translate('staticwords.AddtoCart')" type="submit"
                                                class="addtocartcus btn"><i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </form>



                                    </li>

                                    <span v-if="login == 1">

                                        <li v-if="product.is_in_wishlist == 1" class="lnk wishlist active">
                                            <a :mainid="product.variantid"
                                                :title="translate('staticwords.RemoveFromWishlist')"
                                                class="add-to-cart removeFrmWish active color000 cursor-pointer"
                                                :data-remove="`/removeWishList/${product.variantid}`"> <i
                                                    class="icon fa fa-heart"></i> </a>
                                        </li>

                                        <li v-else class="lnk wishlist">
                                            <a :title="translate('staticwords.AddToWishList')"
                                                :mainid="product.variantid"
                                                class="add-to-cart addtowish cursor-pointer text-white"
                                                :data-add="`/AddToWishList/${product.variantid}`"> <i
                                                    class="activeOne icon fa fa-heart"></i>
                                            </a>
                                        </li>


                                    </span>

                                    <li class="lnk"> <a class="add-to-cart"
                                            :href="`/addto/comparison/${product.productid}`"
                                            :title="translate('staticwords.Compare')"> <i class="fa fa-signal"
                                                aria-hidden="true"></i> </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.action -->
                        </div>

                        <!-- /.cart -->
                    </div>
                    <!-- /.product -->

                </div>
                <!-- /.products -->
            </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            "products", "guest_price", "login", "fallbacklang", "lang", "date"
        ],
        methods: {
            fireLazyLoad() {
                $('.lazy').lazy({

                    effect: "fadeIn",
                    effectTime: 1000,
                    scrollDirection: 'both',
                    threshold: 0

                });
            },
        },
        created() {

            var vm = this;

            Vue.nextTick(function () {

                vm.fireLazyLoad();

            }.bind(vm));
        }
    }
</script>

<style>

</style>