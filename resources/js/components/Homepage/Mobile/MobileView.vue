<template>
     <section id="home-product-tab" class="mb-0 mt-3 home-product-tab-main-block">
        
                  <div class="container">
                      <div class="row home-product-tab">
                          <ul class="nav nav-tabs">
                            <li class="nav-item tab-width"><a data-toggle="tab" class="nav-link active"
                                    href="#newproductsM">{{ translate('staticwords.newprods') }}</a></li>
                            <li class="nav-item tab-width"><a class="nav-link" data-toggle="tab"
                                    href="#topcatsM">{{ translate('staticwords.tpc') }}</a></li>
                            <li class="nav-item tab-width"><a class="nav-link" data-toggle="tab"
                                    href="#featuredM">{{ translate('staticwords.Featured') }}</a></li>
                          </ul>

                          <div class="tab-content">
                              <div id="newproductsM" class="tab-pane fade in show active">
                                  <div class="new-product-block">
                                      <div class="container">
                                          <div class="row">
                                              <div style="width:100%" class="small-screen-scroll-tabs scroll-tabs outer-top-vs">
                                                <div class="tab-content outer-top-xs">
                                                    <div class="product-slider">
                                                        <div class="product-slider-main-block">
                                                            
                                                                <mobile-product v-if="!loading" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="login" :guest_price="guest_price" :products="products"></mobile-product>

                                                                <mobile-skelton v-else></mobile-skelton>

                                                        </div>
                                                    </div>
                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              
                              <div id="topcatsM" class="tab-pane fade in show">
                                <div class="new-product-block">
                                    <div class="container">
                                        <div class="row">
                                            <div style="width:100%" class="small-screen-scroll-tabs scroll-tabs outer-top-vs">
                                              <div class="tab-content outer-top-xs">
                                                  <div class="product-slider">
                                                      <div class="product-slider-main-block">
                                                          <div class="row no-pad"> 
                                                              

                                                              <MobileTopProductsVue v-if="!loading" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="login" :guest_price="guest_price" :products="top_products"/>
                                                              <mobile-skelton v-else></mobile-skelton>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>

                              <div id="featuredM" class="tab-pane fade in show">
                                <div class="new-product-block">
                                    <div class="container">
                                        <div class="row">
                                            <div style="width:100%" class="small-screen-scroll-tabs scroll-tabs outer-top-vs">
                                              <div class="tab-content outer-top-xs">
                                                  <div class="product-slider">
                                                      <div class="product-slider-main-block">
                                                            
                                                            <mobile-product v-if="!loading" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="login" :guest_price="guest_price" :products="featuredproducts"></mobile-product>

                                                            <mobile-skelton v-else></mobile-skelton>
                                                             
                                                          
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
                </section>
</template>

<script>
import MobileTopProductsVue from './MobileTopProducts.vue'
export default {
    props : [
        "products","guest_price","login","fallbacklang","lang","date","featuredproducts","top_products"
    ],
    components : {
        MobileTopProductsVue
    },
    data(){
        return {
            loading : true
        }
    },
    created() {
        setTimeout(() => {
            this.loading = false
        }, 1800);
    }
}
</script>