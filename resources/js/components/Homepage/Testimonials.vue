<template>
  <div class="sidebar-widget advertisement-testimonial">
     
      <div class="advertisement custom-carousel owl-carousel owl-theme owl-drag owl-loaded">

            <div v-for="(item,index) in testimonial" :key="index" class="item">
                <div class="avatar">
                    <img class="owl-lazy" :data-src="item.image"/>
                </div>
                <div class="testimonials"><em>"</em> {{ item.des[lang] ? item.des[lang] : item.des[fallbacklang] }} <em>"</em></div>
                <div class="clients_author">{{ item.name[lang] ? item.name[lang] : item.name[fallbacklang] }}<span>{{ item.post[lang] ? item.post[lang] : item.post[fallbacklang] }}</span> </div>
            </div>

      </div>
      
  </div>

</template>

<script>
export default {
    props : ['testimonial','lang','fallback_lang'],
    data(){
        return {
            rtl : rtl,
            baseurl : baseUrl,
            loading : true
        }
    },
    created(){
       
    //    setTimeout(() => {
            var vm = this;

            Vue.nextTick(function () {
                    
                $(".advertisement").owlCarousel({
                    items : 1,
                    itemsTablet:[978,1],
                    itemsDesktopSmall :[979,1],
                    itemsDesktop : [1199,1],
                    slideSpeed : 300,
                    nav : true,
                    navText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"],
                    lazyLoad:true,
                    pagination: true,
                    rtl : rtl
                });

                this.loading = false;

            }.bind(vm));
    //    }, 3000);
       
    }
}
</script>

<style>

</style>