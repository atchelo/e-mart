<template>
    <div class="mb-1" v-if="advertise.length > 0">
        <div v-for="(adv,index) in advertise" :key="index">
            <div class="row" v-if="adv.layout == 'Single image layout'">

                <div class="col-md-12">
                     <a :href="adv.image1link"><img class="img-fluid lazy" :data-src="adv.image1" :alt="adv.image1"></a>
                </div>

            </div>

            <div class="row" v-if="adv.layout == 'Three Image Layout'">
                <div class="col-4 col-sm-4 col-xs-4 mt-2">
                    <a :href="adv.image1link"><img class="img-fluid lazy" :data-src="adv.image1" :alt="adv.image1"></a>
                </div>

                <div class="col-4 col-sm-4 col-xs-4 mt-2">
                    <a :href="adv.image2link"><img class="img-fluid lazy" :data-src="adv.image2" :alt="adv.image2"></a>
                </div>

                <div class="col-4 col-sm-4 col-xs-4 mt-2">
                    <a :href="adv.image3link"><img class="img-fluid lazy" :data-src="adv.image3" :alt="adv.image3"></a>
                </div>
            </div>

            <div class="row" v-if="adv.layout == 'Two equal image layout'">

                <div class="col-md-6 col-xs-6 col-sm-12 mt-2">
                    <a :href="adv.image1link"><img class="img-fluid lazy" :data-src="adv.image1" :alt="adv.image1"></a>
                </div>

                <div class="col-md-6 col-xs-6 col-sm-12 mt-2">
                    <a :href="adv.image2link"><img class="img-fluid lazy" :data-src="adv.image2" :alt="adv.image2"></a>
                </div>

            </div>

            <div class="mt-2 row" v-if="adv.layout == 'Two non equal image layout'">

                <div class="col-md-8 d-lg-block d-md-block d-none">
                    <a :href="adv.image1link"><img class="img-fluid lazy" :data-src="adv.image1" :alt="adv.image1"></a>
                </div>

                <div class="col-md-4 d-lg-block d-md-block d-none">
                    <a :href="adv.image2link"><img class="img-fluid lazy" :data-src="adv.image2" :alt="adv.image2"></a>
                </div>

            </div>

                
        </div>
    </div>
</template>

<script>
    axios.defaults.baseURL = baseUrl;

    export default {
        data() {
            return {
                advertise: []
            }
        },
        props : ["position"],
        methods: {

            lazyLoad() {
                $('.lazy').lazy({

                    effect: "fadeIn",
                    effectTime: 1000,
                    scrollDirection: 'both',
                    threshold: 0

                });
            }

        },
        created() {

            axios.get('/vue/ads/beforeslider',{
                params : {
                    position : this.position
                }
            }).then(res => {
                this.advertise = res.data;

                this.$nextTick(() => {
                    this.lazyLoad();
                });

            }).catch(err => console.log(err));

        }

    }
</script>