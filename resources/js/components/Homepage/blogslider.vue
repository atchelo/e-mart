<template>
    <section v-if="blogs.length != 0">
        <section v-if="!loading" class="mt-2 section latest-blog">
            <a title="View all posts" :href="`${baseUrl}/blog`"
                class="pull-right btn btn-md btn-info">{{ translate('staticwords.vall') }}</a>
            <h3 class="section-title">{{translate('staticwords.lfromblog')}}</h3>

            <div class="blog-slider-container outer-top-xs">
                <div class="owl-responsive owl-carousel blog-slider custom-carousel">
                    <div v-for="blog in blogs" :key="blog.id" class="item">
                        <div class="blog-post">
                            <div class="blog-post-image">
                                <div class="image"><a
                                        :title="blog.heading[lang] ? blog.heading[lang] : blog.heading[fallbacklang]"
                                        :href="blog.url"><img :src="blog.image" :alt="blog.image"></a>
                                </div>
                            </div>
                            <!-- /.blog-post-image -->

                            <div class="blog-post-info text-left">
                                <h3 class="name"><a
                                        :href="blog.url">{{blog.heading[lang] ? blog.heading[lang] : blog.heading[fallbacklang]}}</a>
                                </h3>

                                <span class="info">By: {{blog.user[lang] }} &nbsp;|&nbsp;
                                    {{ blog.created_on }} | {{ blog.read_time }}</span>
                                <p class="text">
                                    {{blog.des[lang].length > 150 ? blog.des[lang].substring(0,150)+'...' : blog.des[lang]}}
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
            <!-- /.blog-slider-container -->
        </section>
        <section v-else class="mt-1 section latest-blog">
            <BlogSkelton />
        </section>
    </section>
</template>

<script>
    import BlogSkelton from './BlogSkelton.vue';

    axios.defaults.baseURL = baseUrl;

    export default {
        components: {
            BlogSkelton
        },
        methods: {
            installOwlCarousel: function (rtl) {

                $('.blog-slider').each(function () {

                    var owl = $(this);

                    var itemPerLine = owl.data('item');

                    if (!itemPerLine) {
                        itemPerLine = 4;
                    }

                    $(owl).owlCarousel({
                        items: 3,
                        itemsTablet: [978, 1],
                        itemsDesktopSmall: [979, 2],
                        itemsDesktop: [1199, 1],
                        nav: true,
                        rtl: rtl,
                        slideSpeed: 300,
                        pagination: false,
                        lazyLoad: false,
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
                });

            }
        },
        data() {
            return {
                loading: true,
                rtl: rtl,
                lang: '',
                fallbacklang: '',
                blogs: [],
                baseUrl: baseUrl
            }
        },
        async created() {



            await axios.get('/vue/blogs').then(res => {

                this.blogs = res.data.blogs;
                this.lang = res.data.lang;
                this.fallbacklang = res.data.fallbacklang;

                this.loading = false;

                this.$nextTick(() => {
                    this.installOwlCarousel(rtl);
                });

            }).catch(
                err => console.log(err)
            );

        }
    }
</script>