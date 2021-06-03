<template>
    <li>
        <a title="Your Comparison list" :href="`${baseUrl}/comparisonlist`">
            <i class="fa fa-signal"></i> {{ translate('staticwords.Compare') }}
            ({{total}})
        </a>
    </li>
</template>

<script>
    import EventBus from '../../../EventBus';

    export default {
        data() {
            return {
                total: 0,
                baseUrl : baseUrl
            }
        },
        created() {
            EventBus.$on('compare-data', (payload) => {

                this.total = payload;
            });
        }
    }
</script>

<style>

</style>