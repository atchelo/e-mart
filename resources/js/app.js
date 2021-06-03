// require('./bootstrap');

require('jquery-countdown');

window.Vue = require('vue');

window.axios = require('axios');

Vue.use(BootstrapVue);

import VueSnackbar from 'vue-snack' 

import BootstrapVue, { BTab,BTabs,AlertPlugin, BModal, SkeletonPlugin, SpinnerPlugin } from 'bootstrap-vue';//Importing

Vue.component('homepage', require('./components/Homepage/homepage.vue').default);



Vue.component('slider', require('./components/Homepage/Slider.vue').default);

Vue.component('blogslider', require('./components/Homepage/blogslider.vue').default);

Vue.component('featured-products', require('./components/Homepage/Featuredproducts.vue').default);

Vue.component('top-products-d', require('./components/Homepage/TopProductDesktop.vue').default);

Vue.component('new-products-d', require('./components/Homepage/NewProducts.vue').default);

Vue.component('product-slider', require('./components/Homepage/ProductSlider.vue').default);

Vue.component('slider-skelton', require('./components/Homepage/SliderSkelton.vue').default);

Vue.component('mobile-view', require('./components/Homepage/Mobile/MobileView.vue').default);

Vue.component('mobile-product', require('./components/Homepage/Mobile/MobileProduct.vue').default);

Vue.component('mobile-skelton', require('./components/Homepage/Mobile/MobileSkelton.vue').default);

Vue.component('category-sidebar', require('./components/Homepage/CategorySidebar.vue').default);

Vue.component('sidebar-desktop', require('./components/Homepage/SidebarDesktop.vue').default);

Vue.component('testimonials', require('./components/Homepage/Testimonials.vue').default);

Vue.component('special-offer', require('./components/Homepage/SpecialOffer.vue').default);

Vue.component('hot-deal', require('./components/Homepage/Hotdeal.vue').default);

Vue.component('top-menu-d', require('./components/Homepage/Menubar.vue').default);

Vue.component('mobile-menu-sidebar', require('./components/Homepage/Mobile/MobileMenuSidebar.vue').default);

Vue.component('mobile-category-sidebar', require('./components/Homepage/Mobile/MobileCategorySidebar.vue').default);

Vue.component('cart-total-d',require('./components/CartTotal.vue').default);

Vue.component('noti-d',require('./components/Notifications-d.vue').default);

Vue.component('mobile-wish-count',require('./components/Homepage/Mobile/MobileWishlist.vue').default);

Vue.component('main-wish-count',require('./components/Homepage/Wishlistcount.vue').default);

Vue.component('compare-m-count',require('./components/Homepage/Mobile/CompareCount.vue').default);

Vue.component('compare-c-count',require('./components/Comparedesktop.vue').default);

Vue.prototype.translate=require('./VueTranslation/Translation').default.translate;

Vue.use(VueSnackbar);

Vue.config.productionTip= false;

const app = new Vue({
    el : '#app'
});

const menubar = new Vue({
    el : '#menubar'
});

const mobilesidebar = new Vue({
    el : '#mobilesidebar'
});

const mobilemenubar = new Vue({
    el : '#mobilemenubar'
});

const carttotald = new Vue({
    el : '#cart-total-d'
});

try{
    const notifications = new Vue({
        el : '#notifications'
    });

    const mobilewishlist = new Vue({
        el : '#mobilewishlist'
    });

    const dwishlistcount = new Vue({
        el : '#desktop-wis-count'
    });
    
}catch(err){

}



const comparecountd = new Vue({
    el : '#comparedesktop'
});

const comparecountm = new Vue({
    el : '#comparemobile'
});

import EventBus from './EventBus';

axios.get('/vue/sidebar/categories').then(res => {

    let categories = res.data.categories;
    let hotdeals = res.data.hotdeals;
    let testimonials = res.data.testimonials;
    let specialoffers = res.data.specialoffers;
    let guest_price = res.data.guest_price;
    let login = res.data.logged_in;
    let date = res.data.date;
    let lang = res.data.lang;
    let fallbacklang = res.data.fallback_local;

    EventBus.$emit('loadmobilecategorysidebar',categories,lang,fallbacklang,login,guest_price);

    EventBus.$emit('loaddesktopcategorysidebar',categories,lang,fallbacklang,login,guest_price,date,testimonials,specialoffers,hotdeals);

}).catch(err => console.log(err));

axios.get('/vue/sidebarconfigs').then(res => {
    EventBus.$emit('sidebarconfig',res.data);
}).catch(err => console.log(err));