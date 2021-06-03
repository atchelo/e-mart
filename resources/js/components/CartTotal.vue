<template>
    <div class="items-cart-inner">
        <div v-b-toggle.cart-sidebar class="basket">
            <div class="basket-item-count">
                <span class="count">
                    {{totalitem}}
                </span>
            </div>
            <div class="total-price-basket">
                <span class="lbl">{{ translate('staticwords.Yourcart') }}</span>
                <i v-if="currency.position == 'l' || currency.position == 'ls'" :class="currency.value"></i>
                <span v-if="currency.position == 'ls'">&nbsp;</span>
                <span class="value" id="total_cart">
                    {{total}}
                </span>

                <span v-if="currency.position == 'rs'">&nbsp;</span>
                <i v-if="currency.position == 'r' || currency.position == 'rs'" :class="currency.value"></i>


            </div>
        </div>

        <b-sidebar backdrop width="390px" header-class="p-3 bg-primary text-white" id="cart-sidebar" :right="rtl == true ? false : true"
            :title="`${translate('staticwords.Yourcart')} (${totalitem})`" shadow>
            
            <div v-if="cartitems.length" class="px-3 py-2">
                <div :class="{'mt-2' : index > 0}" v-for="(item,index) in cartitems" :key="item.id" class="p-1 row">
                        
                        <div class="col-md-4">
                            <img class="img-fluid" :src="item.image" alt="product_image">
                        </div>
                        <div class="col-md-8">
                            <p> <b>{{item.name[lang]  ? item.name[lang] : item.name[fallbacklang]}} x ({{item.qty}})</b> <br> 

                                <span v-for="(variant,index2) in item.variant" :key="index2" class="mt-1">
                                    (<span>{{variant.var_name}} {{variant.attr_name}} </span>)
                                </span> 
                                
                                
                                <br> <span class="mt-2">
                                
                                 <i v-if="currency.position == 'l' || currency.position == 'ls'" :class="currency.value"></i>
                                <span v-if="currency.position == 'ls'">&nbsp;</span>

                                <span>
                                    {{item.price}}
                                </span>

                                <span v-if="currency.position == 'rs'">&nbsp;</span>
                                <i v-if="currency.position == 'r' || currency.position == 'rs'" :class="currency.value"></i>
                                
                                </span> </p>
                            
                        </div>
                        <!-- <div class="col-md-2">
                            <form method="POST" @submit.prevent="login == 1 ? removelogincart(item.id) : removeguestcart(item.variantid)">
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div> -->
                </div>
            </div>
            <div v-else>
                <h4 class="mt-5 text-center">
                    Your cart is empty
                </h4>
            </div>


             <div class="fixed-bottom text-light" style="padding-left:15px;padding-right:15px;">

                 <div class="text-dark row" :style="{'background' : '#f2f4f5 !important'}">

                     <div class="p-3 col-md-6">
                         <h6 class="ml-auto">{{translate('staticwords.Subtotal')}} </h6>
                      </div>
                     <div class="p-3 col-md-6 pull-left">
                         <h6 class="text-right">
                            <i v-if="currency.position == 'l' || currency.position == 'ls'" :class="currency.value"></i>
                            <span v-if="currency.position == 'ls'">&nbsp;</span>
                            <span class="value" id="total_cart">
                                {{subtotal}}
                            </span>

                            <span v-if="currency.position == 'rs'">&nbsp;</span>
                            <i v-if="currency.position == 'r' || currency.position == 'rs'" :class="currency.value"></i>
                        </h6>
                     </div>

                     <div class="p-3 col-md-6">
                         <h6 class="mr-auto">{{translate('staticwords.Shipping')}} </h6>
                      </div>
                     <div class="p-3 col-md-6 pull-right">
                         <h6 class="text-right">
                            <i v-if="currency.position == 'l' || currency.position == 'ls'" :class="currency.value"></i>
                            <span v-if="currency.position == 'ls'">&nbsp;</span>
                            <span class="value" id="total_cart">
                                {{shipping}}
                            </span>

                            <span v-if="currency.position == 'rs'">&nbsp;</span>
                            <i v-if="currency.position == 'r' || currency.position == 'rs'" :class="currency.value"></i>
                        </h6>
                     </div>

                 </div>

                 <div class="row bg-primary">

                     <div class="p-3 col-md-6">
                         <h5 class="mr-auto">{{translate('staticwords.Total')}} </h5>
                      </div>
                     <div class="p-3 col-md-6 pull-right">
                         <h5 class="text-right">
                            <i v-if="currency.position == 'l' || currency.position == 'ls'" :class="currency.value"></i>
                            <span v-if="currency.position == 'ls'">&nbsp;</span>
                            <span class="value" id="total_cart">
                                {{total}}
                            </span>

                            <span v-if="currency.position == 'rs'">&nbsp;</span>
                            <i v-if="currency.position == 'r' || currency.position == 'rs'" :class="currency.value"></i>
                        </h5>
                     </div>
                 </div>

                  <div v-if="total != 0" class="row" :style="{'background' : '#f2f4f5 !important'}">
                     <div class="p-3 col-md-6">
                         <a :href="`${baseUrl}/cart`" class="btn btn-md btn-outline-primary">
                             {{translate('staticwords.viewcart')}}
                         </a>
                      </div>
                     <div class="p-3 col-md-6 text-right">
                        
                        <a :href="`${baseUrl}/checkout`" class="btn btn-md btn-primary">
                            {{translate('staticwords.Checkout')}}
                         </a>

                     </div>

                 </div>



            </div>
        </b-sidebar>

    </div>
</template>

<script>
    import EventBus from '../EventBus';

    export default {
        data() {
            return {
                currency: {

                },
                totalitem: 0,
                subtotal : 0,
                total: 0,
                baseUrl : baseUrl,
                rtl : rtl,
                cartitems : [],
                lang : '',
                fallbacklang : '',
                shipping : '',
                login : ''
            }
        },
        methods: {
            loadcart() {

                axios.get('/cart/total').then(res => {

                    this.total = res.data.total;
                    this.totalitem = res.data.count;
                    this.currency = res.data.currency;

                    this.cartitems = res.data.items;

                    this.fallbacklang = res.data.fallback_local;

                    this.lang = res.data.lang;

                    this.subtotal = res.data.subtotal;

                    this.shipping = res.data.shipping;

                    this.login = res.data.login;

                }).catch(err => console.log(err));

            },

            // removelogincart(id){

            // },

            // removeguestcart(variantid){

            //     alert('x');

            //     axios.post(`/vue/remove/cart/guest/${variantid}`).then(res => {
            //         console.log(res.data);
            //     }).catch(err => {
            //         console.log(err);
            //     })

            // }   

        },
        created() {

            this.loadcart();

            EventBus.$on('re-loadcart', (payload) => {
                this.loadcart();
            });

        }
    }
</script>

<style>
    .b-sidebar.b-sidebar-right>.b-sidebar-header .close {
        margin-left: auto !important;
        margin-right: 0 !important;
        color: #ffffff !important;
    }

    #cart-sidebar___title__ {
        position: absolute;
        font-weight: 500;
    }
</style>