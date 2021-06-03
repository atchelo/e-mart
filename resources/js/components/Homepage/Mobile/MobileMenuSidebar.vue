<template>
  <div>
      <li v-for="(menu,index) in menus" :key="index">
			
           
            <a v-if="menu.show_cat_in_dropdown != 1 && menu.show_child_in_dropdown != 1" @click="menu.link_by =='cat'  ? redirectMe(menu.cat_id,'p') : '#'" role="button" class="bignavbar"
                :href="menu.link_by == 'page' ? `/show/${menu.gotopage.slug}` : menu.url"><i
                    v-if="menu.icon != null" :class="`fa ${menu.icon}`"></i>
                {{ menu.title[lang] ? menu.title[lang] : menu.title[fallback_lang]}}

            </a>

		</li>
  </div>
</template>

<script>

import EventBus from '../../../EventBus';

export default {
    data(){
        return {
            menus : [],
            lang : '',
            fallback_lang : ''
        }
    },
    methods : {
        redirectMe(id, type) {
                if (type == 'p') {

                    axios.get('/vue/get/category/url', {
                            params: {
                                id: id
                            }
                        })
                        .then(res => {

                            if (res.data.status && res.data.status == 'fail') {
                                let config = {
                                    text: res.data.message,
                                    button: 'CLOSE'
                                }
                                this.$snack['danger'](config);
                            } else {
                                location.href = res.data;
                            }

                        })
                        .catch(err => console.log(err));

                } else if (type == 's') {


                    axios.get('/vue/get/subcategory/url', {
                            params: {
                                id: id
                            }
                        })
                        .then(res => {


                            if (res.data.status && res.data.status == 'fail') {
                                let config = {
                                    text: res.data.message,
                                    button: 'CLOSE'
                                }
                                this.$snack['danger'](config);
                            } else {
                                location.href = res.data;
                            }

                        })
                        .catch(err => console.log(err));

                } else {

                    axios.get('/vue/get/childcategory/url', {
                            params: {
                                id: id
                            }
                        })
                        .then(res => {

                            if (res.data.status && res.data.status == 'fail') {
                                let config = {
                                    text: res.data.message,
                                    button: 'CLOSE'
                                }
                                this.$snack['danger'](config);
                            } else {
                                location.href = res.data;
                            }

                        })
                        .catch(err => console.log(err));

                }
            }
    },
    created(){
        EventBus.$on('loadmenu', (payload,l,fl) => {

             this.menus = payload;
             this.lang = l;
             this.fallback_lang = fl;

        });
    }
}
</script>

<style>

</style>