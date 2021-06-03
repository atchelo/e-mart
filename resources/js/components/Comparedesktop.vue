<template>
    <div>
        <a title="Your Comparison list" :href="`${baseUrl}/comparisonlist`">
        {{ translate('staticwords.Compare') }}
        ({{total}})
    </a>
    </div>
</template>

<script>
axios.defaults.baseURL = baseUrl;
import EventBus from '../EventBus';

export default {
    data(){
        return {
            total : 0,
            baseUrl : baseUrl
        }
    },
    methods : {
        loadcomparison(){
            axios.get('/vue/compare/count').then(res => {
                this.total =  res.data;
                EventBus.$emit('compare-data',this.total);
            }).catch(err => console.log(err));
        }
    },
    created(){
        this.loadcomparison();

         EventBus.$on('re-load-comparison', (payload) => {
               this.loadcomparison();
        });
    }
}
</script>