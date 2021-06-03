window.axios = require('axios');


window.Vue = require('vue');
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

Vue.config.productionTip = false;

Vue.component('track-order', require('./components/Trackorder.vue').default);
Vue.component('track-skelton', require('./components/Skelton.vue').default);

const app = new Vue({
    el : '#trackorder'
});