<template>
  <div v-if="sliders.length > 0 && enable == 1">
      <div v-if="!loading" id="main-slider" class="fade-in mainslider owl-z mt-1 mb-lg-0 mb-4 mb-sm-4 mb-xs-8 owl-carousel owl-theme">

        <div v-for="(slider,index) in sliders" :key="index" class="item backgroundcover"
            :style="{ 'background-image' : `url('${slider.image}')` , 'background-size' : 'cover' }">

            <div class="container-fluid">
                <div class="caption bg-color vertical-center text-left">
                    <div v-show="slider.heading != ''" class="slider-header fadeInDown-1"><span
                            :style="{'color' : slider.subheadingcolor}">{{ slider.heading[lang] ? slider.heading[lang] : slider.heading[fallbacklang] }}</span>
                    </div>
                    <div v-show="slider.topheading != ''" class="big-text fadeInDown-1"> <span
                            :style="{'color' : slider.headingtextcolor}">{{ slider.topheading[lang]  ? slider.topheading[lang] : slider.topheading[fallbacklang] }}</span>
                    </div>
                    <div v-show="slider.moredesc != ''" class="excerpt fadeInDown-2 hidden-xs"> <span
                            :style="{ 'color' : slider.descriptionTextColor }">{{ slider.moredesc }}</span>
                    </div>
                    <div v-show="slider.buttonname != ''" class="button-holder fadeInDown-3"> <a
                            :style="{'color' : slider.btntextcolor, 'background' : slider.btnbgcolor }"
                            :href="slider.linkedTo"
                            class="btn-lg btn btn-uppercase shop-now-button">{{ slider.buttonname[lang] ? slider.buttonname[lang] : slider.buttonname[fallbacklang] }}</a>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div v-else>
        <b-skeleton-img no-aspect height="200px"></b-skeleton-img>
    </div>
  </div>
</template>

<script>

axios.defaults.baseURL = baseUrl;

import SliderSkelton from './SliderSkelton';

export default {
    data(){
        return {
            loading  : true,
            rtl : rtl,
            lang : '',
            fallbacklang : '',
            sliders : [],
            enable : '',
        }
    },
    components : {
       SliderSkelton
    },
    methods : {
            installOwlCarousel: function (rtl) {

                 $('.mainslider').each(function () {

                    var owl = $(this);

                    var itemPerLine = owl.data('item');

                    if (!itemPerLine) {
                        itemPerLine = 4;
                    }

                    $(owl).owlCarousel({
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 1
                            },
                            1100: {
                                items: 1
                            }
                        },
                        slideSpeed: 1500,
                        smartSpeed: 1500,
                        loop: true,
                        margin: 10,
                        nav: true,
                        lazyLoad: true,
                        autoplay: true,
                        autoplayTimeout: 3000,
                        autoplayHoverPause: true,
                        rtl: rtl
                    });
                    
                 })
            }
    },
    async created(){


        await axios.get('/vue/get/slider').then(res => {
            
            this.sliders = res.data.sliders;
            this.lang = res.data.lang;
            this.fallbacklang = res.data.fallbacklang;

            this.enable = res.data.enable;

            this.loading = false;

            this.$nextTick(()=>{
                this.installOwlCarousel(rtl);
            });

        });
    }
}
</script>

<style>

</style>