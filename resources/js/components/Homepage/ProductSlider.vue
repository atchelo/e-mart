<template>
    <div>

        <div :key="Math.random().toString(36).substring(7)"
            class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

            <div v-for="product in products" :key="product.productid" class="item item-carousel">

                <div class="products">
                    <div class="product">
                        <div class="product-image">
                            <div :class="{'pro-img-box' : product.stock == 0 }" class="image">

                                <a :href="product.producturl"
                                    :title="product.productname[lang]  ? product.productname[lang] : product.productname[fallbacklang]">

                                    <span v-if="product.thumbnail">
                                        <img class="owl-lazy" :class="{'filterdimage' : product.stock == 0}"
                                            :data-src="product.thumbnail" alt="product_image" />
                                        <img :class="{'filterdimage' : product.stock == 0 }"
                                            class="owl-lazy hover-image" :data-src="product.hover_thumbnail"
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
                            
                            <div v-if="product.featured == 1" class="tag hot">
                                <span>{{ translate('staticwords.Hot') }}</span></div>


                            <div v-else-if="product.offerprice != 0" class="tag sale">
                                <span>{{ translate('staticwords.Sale') }}</span></div>

                            <div v-else class="tag new"><span>{{ translate('staticwords.New') }}</span></div>

                        </div>


                        <!-- /.product-image -->

                        <div class="product-info" :class="{'text-left' : rtl == false, 'text-right' : rtl == true}">
                            <h3 class="text-truncate name"><a
                                    :href="product.producturl">{{ product.productname[lang]  ? product.productname[lang] : product.productname[fallbacklang] }}</a>
                            </h3>


                            <div v-if="product.rating != 0" :class="{'pull-left' : rtl == false, 'pull-right' : rtl == true}">
                                <div class="star-ratings-sprite"><span :style="{ 'width' : `${product.rating}%` }"
                                        class="star-ratings-sprite-rating"></span></div>
                            </div>

                            <div v-else class="no-rating">No Rating</div>

                            <!-- Product-price -->

                            <div v-if="guest_price == '0' || login == 1" class="product-price">
                                <span class="price">

                                    <div v-if="product.offerprice == 0">
                                        <span class="price">
                                            <i v-if="product.position == 'l' || product.position == 'ls'" :class="product.symbol"></i>
                                            <span v-if="product.position == 'ls'">&nbsp;</span>

                                            {{ product.mainprice }}

                                            <span v-if="product.position == 'rs'">&nbsp;</span>
                                             <i v-if="product.position == 'r' || product.position == 'rs'" :class="product.symbol"></i>

                                        </span>
                                    </div>


                                    <div v-else>
                                        <span class="price">
                                            <i v-if="product.position == 'l' || product.position == 'ls'" :class="product.symbol"></i>
                                            <span v-if="product.position == 'ls'">&nbsp;</span>

                                            {{ product.offerprice }}

                                            <span v-if="product.position == 'rs'">&nbsp;</span>
                                            <i v-if="product.position == 'r' || product.position == 'rs'" :class="product.symbol"></i>
                                        </span>
                                        <span class="price-before-discount">
                                            <i v-if="product.position == 'l' || product.position == 'ls'" :class="product.symbol"></i>
                                            <span v-if="product.position == 'ls'">&nbsp;</span>

                                            {{ product.mainprice }}

                                            <span v-if="product.position == 'rs'">&nbsp;</span>
                                             <i v-if="product.position == 'r' || product.position == 'rs'" :class="product.symbol"></i>
                                        </span>
                                    </div>

                                </span>
                            </div>

                            <!-- /.product-price -->

                        </div>

                        <div v-if="product.stock != 0 && product.selling_start_at != null && product.selling_start_at >= date">

                        </div>
                        <div v-else class="cart clearfix animate-effect">
                            <div class="action">
                                <ul class="list-unstyled">

                                    <!-- cart condition -->

                                    <li v-show="guest_price == '0' || login == 1" id="addCart" class="lnk wishlist">

                                        <form @submit.prevent="addToCart(product.cartURL)">
                                            <button :title="translate('staticwords.AddtoCart')" type="submit"
                                                class="addtocartcus btn"><i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </form>

                                    </li>

                                    <span v-if="login == 1">

                                        <li :class="{'active' : product.is_in_wishlist == 1}" class="lnk wishlist">

                                            <form @submit.prevent="addtowish(product.variantid)">
                                                <button type="submit" :class="{'text-dark' : product.is_in_wishlist == 1}"
                                                    class="addtocartcus btn"><i class="fa fa-heart"></i>
                                                </button>
                                            </form>
                                        </li>


                                    </span>

                                    <li class="lnk"> 
                                        <form @submit.prevent="addToCompare(product.productid)">
                                            <button :title="translate('staticwords.Compare')" type="submit"
                                                class="addtocartcus btn"><i class="fa fa-signal"></i>
                                            </button>
                                        </form>
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
            <!-- /.item -->
        </div>

    </div>

</template>

<script>
    import EventBus from '../../EventBus';
    axios.defaults.baseURL = baseUrl;
    export default {
        props: ['products', 'date', 'lang', 'fallbacklang', 'login', 'guest_price'],
        data(){
            return {
                rtl : rtl,
                baseUrl : baseUrl
            }
        },
        methods: {
            installOwlCarousel(rl) {
                
                $('.home-owl-carousel').each(function () {

                    var owl = $(this);

                    var itemPerLine = owl.data('item');

                    if (!itemPerLine) {
                        itemPerLine = 4;
                    }
                    owl.owlCarousel({
                        items: 3,
                        itemsTablet: [978, 1],
                        itemsDesktopSmall: [979, 2],
                        itemsDesktop: [1199, 1],
                        nav: true,
                        rtl: rl,
                        slideSpeed: 300,
                        margin: 10,
                        pagination: false,
                        lazyLoad: true,
                        navText: ["<i class='icon fa fa-angle-left'></i>",
                            "<i class='icon fa fa-angle-right'></i>"
                        ],
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: 3,
                                nav: false,
                                dots: false,
                            },
                            600: {
                                items: 3,
                                nav: false,
                                dots: false,
                            },
                            768: {
                                items: 4,
                                nav: false,
                            },
                            1100: {
                                items: 5,
                                nav: true,
                                dots: true,
                            }
                        }
                    });
                });
            },

            addToCart(cartURL) {
                axios.post(cartURL).then(res => {

                    if (res.data.status == 'success') {
                        let config = {
                            text: res.data.msg,
                            button: 'CLOSE'
                        }

                        EventBus.$emit('re-loadcart',1);
                        
                        this.$snack['success'](config);


                    } else {
                        let config = {
                            text: res.data.msg,
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                }).catch(err => {

                    let config = {
                        text: 'Something went wrong !',
                        button: 'CLOSE'
                    }

                    this.$snack['danger'](config);

                    console.log(err)
                });
            },

            addToCompare(id){

                axios.post(`${baseUrl}/vue/add/to/comparison`,{
                    id : id
                })
                     .then(res => {


                            if (res.data.status == 'success') {
                                let config = {
                                    text: res.data.message,
                                    button: 'CLOSE'
                                }
                                this.$snack['success'](config);

                                EventBus.$emit('re-load-comparison',1);

                            } else {
                                let config = {
                                    text: res.data.message,
                                    button: 'CLOSE'
                                }
                                this.$snack['danger'](config);
                            }

                        }).catch(err => {
                            
                            let config = {
                                    text: "Something went wrong !",
                                    button: 'CLOSE'
                            }
                            this.$snack['danger'](config);

                        });
            },
            addtowish(id){

                
                axios.get('/vue/add_or_removewishlist/',{
                    params : {
                        variantid : id
                    }
                }).then(res => {

                    let config = {
                        text: res.data.message,
                        button: 'CLOSE'
                    }

                    if(res.data.status == 'fail'){
                        this.$snack['danger'](config);
                    }else{
                        this.$snack['success'](config);
                        EventBus.$emit('re-load-wish',1);
                    }   
                    

                }).catch(err => {
                    let config = {
                        text: 'Something went wrong !',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                    console.log(err);
                });


            },
            createOwl() {

                var vm = this;

                Vue.nextTick(function () {
                
                    vm.installOwlCarousel(this.rtl);

                }.bind(vm));
                

            },
        },
        created() {

            this.createOwl();

        }


    }
</script>

<style>

</style>