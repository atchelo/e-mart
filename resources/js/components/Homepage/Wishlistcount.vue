<template>
    <a :href="`${baseUrl}/wishlist`" :title="translate('staticwords.Wishlist')">{{ translate('staticwords.Wishlist') }}
        (<span id="wishcount">{{wishcount}}</span>)
    </a>
</template>

<script>
import EventBus from '../../EventBus';

    export default {
        data(){
            return {
                wishcount : 0,
                baseUrl : baseUrl
            }
        },
        methods : {
            loadcount(){

                 axios.get('/vue/wishlist/count').then(res => {

                    this.wishcount = res.data;
                    
                    EventBus.$emit('wishlist-count',this.wishcount);

                }).catch(err => console.log(err));

            }
        },
        created(){
           this.loadcount();

           EventBus.$on('re-load-wish', (payload) => {
                this.loadcount();
           });
        }
    }
</script>

<style>

</style>