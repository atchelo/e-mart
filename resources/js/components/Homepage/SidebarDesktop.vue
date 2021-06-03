<template>
    <section>
       
        <div v-if="config.length && config[0].home == 1 && categories != null && categories.length != 0">
            <category-sidebar v-if="categories && categories.length > 0" :guest_price="guest_price" :login="login" :lang="lang" :fallbacklang="fallbacklang" :categories="categories"></category-sidebar>

            <div v-else>
                <div class="side-menu animate-dropdown mb-2 header-nav-screen">
                    <div role="button" class="head">
                    <i class="icon fa fa-align-left fa-fw"></i> {{ translate('staticwords.Categories') }}
                    </div>

                    <nav class="megamenu-horizontal">
                        <div :key="i" v-for="i in 10" class="row no-gutters p-1">
                            <div class="col-10">
                                <b-skeleton  animation="throb"></b-skeleton>
                            </div>
                            <div v-if="i%2 != 0" class="col-2">
                                <b-skeleton class="float-right " width="80%"></b-skeleton>
                            </div>
                        </div>
                    </nav>
                </div>

                
            </div>
        </div>
       
        <div v-if="config.length && config[1].home == 1 && hotdeals != null && hotdeals.length != 0">
             <hot-deal v-if="hotdeals && hotdeals.length > 0" :date="date" :guest_price="guest_price" :login="login" :hotdeals="hotdeals" :lang="lang" :fallbacklang="fallbacklang"></hot-deal>
            <div class="mt-2 mb-lg-2 mb-md-1 mb-sm-1 sidebar-widget hot-deals" v-else>
            
                <b-skeleton-img animation="throb" height="350px"></b-skeleton-img>

            </div>
        </div>

        <div v-if="config.length && config[2].home == 1 && specialoffers != null && specialoffers.length != 0">
            <special-offer v-if="specialoffers && specialoffers.length > 0" :guest_price="guest_price" :login="login" :lang="lang" :fallbacklang="fallbacklang" :specialoffers="specialoffers"></special-offer>

            <div v-else class="mb-lg-2 mb-md-1 mb-sm-1 sidebar-widget">
                <div class="sidebar-widget-body outer-top-xs">
                    <b-skeleton animation="throb" width="35%"></b-skeleton>
                    <b-skeleton-img height="200px"></b-skeleton-img>
                </div>
            </div>
        </div>
        

        <div v-if="config.length && config[3].home == 1 && testimonials != null && testimonials.length != 0">

            <testimonials v-if="testimonials && testimonials.length > 0" :lang="lang" :fallbacklang="fallbacklang" :testimonial="testimonials"></testimonials>

            <div v-else class="sidebar-widget advertisement-testimonial">
                <b-skeleton-img height="200px"></b-skeleton-img>
                <br>
                <b-skeleton animation="throb" width="85%"></b-skeleton>
                <b-skeleton animation="throb" width="55%"></b-skeleton>
                <b-skeleton animation="throb" width="70%"></b-skeleton>
            </div>

        </div>
        

    </section>
</template>
<script>

axios.defaults.baseURL = baseUrl;

import EventBus from '../../EventBus';

export default {
    
    data() {
        return {
            categories: [],
            lang : '',
            fallbacklang : '',
            testimonials : [],
            specialoffers : [],
            hotdeals : [],
            guest_price : '',
            login : '',
            date : '',
            config : []
        }
    },
    created() {


            EventBus.$on('sidebarconfig',(payload) => {
                this.config = payload;
            });

           
           EventBus.$on('loaddesktopcategorysidebar', (categories, lang, fallbacklang,login,guest_price,date,testimonials,specialoffers,hotdeals) => {

                this.categories = categories;
                this.lang = lang;
                this.hotdeals = hotdeals;
                this.fallbacklang = fallbacklang;
                this.testimonials = testimonials;
                this.specialoffers = specialoffers;

                this.login = login;
                this.guest_price = guest_price;

                this.date = date;
            });

            

    }
}
</script>