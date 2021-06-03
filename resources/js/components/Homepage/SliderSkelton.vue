<template>
        <div :key="Math.random().toString(30).substring(6)" class="owl-carousel skelton-owl-carousel custom-carousel owl-theme outer-top-xs">
           
            <div v-for="(i,index) in item" :key="index" class="item item-carousel">

                <div class="products">
                    <div class="product">
                        <div class="product-image">
                            <div class="image p-2">
                                    <b-skeleton-img height="250px"></b-skeleton-img>
                            </div>
                            
                        </div>

                        <div class="product-info p-1">
                            <h3 class="name">
                                <b-skeleton animation="throb" height="10px" width="60%"></b-skeleton> <!-- productnmae-->
                            </h3>
                            <div class="no-rating">
                                <b-skeleton animation="throb" height="8px" width="20%"></b-skeleton> <!-- no rating -->
                            </div>
                            <div class="product-price mt-2">
                                <b-skeleton animation="throb" height="9px" width="30%"></b-skeleton> <!-- price -->
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

       </div>
</template>

<script>
export default {
    props : [
        'item'
    ],
    data(){
        return {
            rtl : rtl
        }
    },
    methods : {
        installOwlCarousel(rtl) {

                $('.skelton-owl-carousel').each(function () {

                    var owl = $(this);

                    var itemPerLine = owl.data('item');

                    if (!itemPerLine) {
                        itemPerLine = 4;
                    }
                    owl.owlCarousel({
                        items: 6,
                        itemsTablet: [978, 1],
                        itemsDesktopSmall: [979, 2],
                        itemsDesktop: [1199, 1],
                        nav: true,
                        margin : 10,
                        rtl : rtl,
                        slideSpeed: 300,
                        pagination: false,
                        lazyLoad: true,
                        navText: ["<i class='icon fa fa-angle-left'></i>",
                            "<i class='icon fa fa-angle-right'></i>"
                        ],
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: this.item,
                                nav: false,
                                dots: false,
                            },
                            600: {
                                items: this.item,
                                nav: false,
                                dots: false,
                            },
                            768: {
                                items: this.item,
                                nav: false,
                            },
                            1100: {
                                items: this.item,
                                nav: true,
                                dots: true,
                            }
                        }
                    });
                });
            },
    },
    mounted(){

        
            var vm = this;

            Vue.nextTick(function () {

                vm.installOwlCarousel(this.rtl);

            }.bind(vm));
        
       
    }
}
</script>

<style>

</style>