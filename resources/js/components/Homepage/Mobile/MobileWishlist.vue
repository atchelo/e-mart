<template>
    <div>
        <div class="dropdown-divider"></div>
        <li>
            <a :href="`${baseUrl}/wishlist`" :title="translate('staticwords.Wishlist')">
                <i class="fa fa-heart"></i>&nbsp;&nbsp;{{ translate('staticwords.Wishlist') }} ({{ wishcount }})</a>
        </li>
        <div class="dropdown-divider"></div>
    </div>
</template>

<script>
    import EventBus from '../../../EventBus';

    axios.defaults.baseURL = baseUrl;
    export default {
        data(){
            return {
                wishcount : 0,
                baseUrl : baseUrl
            }
        },
        created(){
            EventBus.$on('wishlist-count', (payload) => {
                this.wishcount = payload;
            });
        }
    }
</script>

<style>

</style>