<template>
    <div>
        <div class="p-1">
            <b-skeleton class="pull-right" type="button"></b-skeleton>
        </div>
        <h3 class="section-title">
            <b-skeleton width="15%"></b-skeleton>
        </h3>
        <div class="blog-slider-container outer-top-xs">
            <div class="owl-responsive owl-carousel blog-slider custom-carousel">
                <div v-for="(i,index) in 3" :key="index" class="item">
                    <div class="blog-post">
                        <div class="blog-post-image">
                            <div class="image"><a :href="'#'">
                                    <b-skeleton-img></b-skeleton-img>
                                </a>
                            </div>
                        </div>
                        <!-- /.blog-post-image -->

                        <div class="blog-post-info text-left">
                            <h3 class="name">
                                <a>
                                    <b-skeleton></b-skeleton>
                                </a>
                            </h3>

                            <span class="info">
                                <b-skeleton></b-skeleton>
                            </span>
                            <p class="text">
                                <b-skeleton></b-skeleton>
                            </p>
                        </div>
                        <!-- /.blog-post-info -->

                    </div>
                    <!-- /.blog-post -->
                </div>
                <!-- /.item -->
            </div>
            <!-- /.owl-carousel -->
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            installOwlCarousel: function (rtl) {

                $(".blog-slider").owlCarousel({
                    items: 3,
                    itemsTablet: [978, 1],
                    itemsDesktopSmall: [979, 2],
                    itemsDesktop: [1199, 1],
                    nav: true,
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
                            items: 3,
                            nav: true,
                            dots: true,
                        }
                    }
                });

            }
        },
        data(){
            return {
                rtl : rtl
            }
        },
        created() {
            var vm = this;

            Vue.nextTick(function () {

                vm.installOwlCarousel(rtl);

            }.bind(vm));
        }
    }
</script>

<style>

</style>