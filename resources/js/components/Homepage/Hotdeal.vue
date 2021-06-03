<template>
  <div class="mt-2 mb-lg-2 mb-md-1 mb-sm-1 sidebar-widget hot-deals">

      <h3 class="section-title">{{ translate('staticwords.Hotdeals') }}</h3>
      <div class="owl-carousel hot-deal-carousel custom-carousel owl-theme outer-top-ss">
        <div v-for="(product,index) in hotdeals" :key="index" class="item hot-deals-item">
              <div class="products">
                <div class="hot-deal-wrapper">
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

                  <div v-if="product.offerprice != 0" class="sale-offer-tag"><span>
                    {{product.off_percent}}%
                    <br>
                      off</span>
                  </div>

                   <div class="countdown">
                      <div class="timing-wrapper" :data-startat="product.start_date" :data-countdown="product.end_date"></div>
                  </div>

                </div>

                <div class="product-info text-center m-t-20">
                  <h3 class="name"><a :href="product.producturl">{{ product.productname[lang]  ? product.productname[lang] : product.productname[fallbacklang] }}</a>
                  </h3>


                 <div v-if="product.rating != 0" class="text-center">
                                <div class="star-ratings-sprite"><span :style="{ 'width' : `${product.rating}%` }"
                                        class="star-ratings-sprite-rating"></span></div>
                  </div>

                  <div v-else class="text-center no-rating">No Rating</div>

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
                  <div v-else>
                    <h5 class="text-red">Login to view Price</h5>
                  </div>

                  

                </div>

                <div class="cart clearfix animate-effect">
                  <div class="action">
                    <ul class="list-unstyled">

                        <h5 v-if="product.stock != 0 && product.selling_start_at != null && product.selling_start_at >= date" align="center" class="text-success">
                          <span>{{ translate('staticwords.ComingSoon') }}</span>
                        </h5>
                        <div v-else>
                          <form v-if="product.in_cart == 0 && dealincart == 0" method="POST" @submit.prevent="addToCart(product.cartURL)">
                          
                              <li class="add-cart-button btn-group">
                                <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i
                                    class="fa fa-shopping-cart"></i> </button>
                                <button class="btn btn-primary cart-btn" type="submit">
                                  {{translate('staticwords.AddtoCart')}}
                                </button>
                              </li>

                          </form>
                          <div v-else>
                              <li @click.prevent="redirectMe" class="add-cart-button btn-group">
                                <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i
                                    class="fa fa-check"></i> </button>
                                <button class="btn btn-primary cart-btn" type="button">
                                  Deal in Cart
                                </button>
                              </li>
                          </div>
                        </div>

                        <h5 v-if="product.stock == 0" class="required" align="center">
                          <span>
                            {{ translate('staticwords.Outofstock') }}
                          </span>
                        </h5>

                    </ul>
                  </div>
                </div>
              </div>
        </div>
      </div>
    
      
  </div>
</template>
<script>
import EventBus from '../../EventBus';

export default {
    props : ['hotdeals','lang','fallbacklang','login','guest_price','date'],
    data(){
      return {
        rtl : rtl,
        dealincart : 0,
        loading : true,baseurl : baseUrl,
      }
    },
    methods : {

      redirectMe(){
        window.location.href = `${this.baseurl}/cart`;
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

                    this.dealincart = 1;

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
      timer(){

              

              var d = new Date();
              var datestring = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
              ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
              var pausecontent = new Array();

              $.each(this.hotdeals, function(key, value) {

                var start = value.start_date;
                var end = value.end_date;

                if(start <= datestring && end >= datestring){
                      
                      pausecontent.push(value);   

                }

              });


              if ($('.timing-wrapper').length) {
                $('.timing-wrapper').each(function () {
                  
                  var $this = $(this);
                  var finalDate = $(this).data('countdown');
                  var finalDate1 = $(this).data('startat');

                  if (datestring >= finalDate1) {
                    $this.countdown(finalDate, function (event) {
                      var $this = $(this).html(event.strftime('' + '<div class="box-wrapper"><div class="date box"> <span class="key">%D</span> <span class="value">DAYS</span> </div> </div> ' + '<div class="box-wrapper"><div class="hour box"> <span class="key">%H</span> <span class="value">HRS</span> </div> </div> ' + '<div class="box-wrapper"><div class="minutes box"> <span class="key">%M</span> <span class="value">MINS</span> </div> </div> ' + '<div class="box-wrapper"><div class="seconds box"> <span class="key">%S</span> <span class="value">SEC</span> </div> </div> '));
                    });
                  }
                });
              }
              
              if(pausecontent.length == 0){
                $('.hot-deals').remove();
              }
              
      }
    },
    created(){
     

            this.loading = false;

            this.$nextTick(() => {

                this.hotdeals = this.hotdeals;

                $(".hot-deal-carousel").owlCarousel({
                    items : 1,
                    itemsTablet:[978,1],
                    itemsDesktopSmall :[979,2],
                    itemsDesktop : [1199,1],
                    nav : true,
                    slideSpeed : 300,
                    pagination: false,
                    lazyLoad:true,
                    paginationSpeed : 400,
                    responsiveClass: true,
                    responsive: {
                          0: {
                              items: 1,
                              nav: false,
                              dots: false,
                          },
                          600: {
                              items: 1,
                              nav: false,
                              dots: false,
                          },
                          768: {
                              items: 1,
                              nav: false,
                          },
                          1100: {
                              items: 1,
                              nav: true,
                              dots: true,
                          }
                    },
                    navText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"],
                    rtl : rtl
                });

                 this.timer();

            });
          
    }
}
</script>

<style>

</style>