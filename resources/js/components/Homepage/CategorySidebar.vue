<template>


    <div class="side-menu animate-dropdown mb-2 header-nav-screen">
        <div role="button" @click="hideCategoryBar" class="head">
        <i v-if="collpase" class="icon fa fa-align-left fa-fw"></i>
        <i v-if="!collpase" class="icon fa fa-align-justify fa-fw"></i> {{ translate('staticwords.Categories') }}

        </div>
        <nav id="collapseExample" class="collapse show megamenu-horizontal">

            <ul class="nav">


                <ul class="nav flex-column flex-nowrap overflow-hidden">



                    <li v-for="category in categories" :key="category.id" class="nav-item">

                        <div class="row">
                            <div class="col-10">
                                <a role="button" class="nav-link text-truncate" @click.prevent="guest_price == 0 || login == 1 ? redirectMe(category.id,'p') : '#'">
                                    <i v-if="category.icon != ''" :class="`fa ${category.icon}`"></i>
                                    <span class="d-inline">
                                        {{category.title[lang] ? category.title[lang] : category.title[fallbacklang]}}
                                    </span>
                                </a>
                            </div>

                            <div v-if="category.subcategory.length > 0" class="col-2">
                                <a class="c_icon_plus float-right collapsed nav-link text-truncate"
                                    :href="`#submenu${category.id}`" data-toggle="collapse">
                                    <i class="fa fa-plus-square-o"></i>
                                </a>
                            </div>

                        </div>

                        <div v-if="category.subcategory.length > 0" :key="category.id" class="collapse"
                            :id="`submenu${category.id}`" aria-expanded="false">
                            <ul class="flex-column pl-2 nav">

                                <div :key="subcategory.id" v-for="subcategory in category.subcategory">
                                    <div class="row">

                                        <div class="col-10">
                                            <a role="button" class="nav-link text-truncate"
                                                @click.prevent="guest_price == 0 || login == 1 ? redirectMe(subcategory.id,'s') : '#'">
                                                <i :class="`fa ${subcategory.icon}`"></i>
                                                <span class="d-inline">
                                                    {{subcategory.title[lang] ? subcategory.title[lang] : subcategory.title[fallbacklang]}}
                                                </span>
                                            </a>
                                        </div>

                                        <div v-if="subcategory.childcategory.length > 0" class="col-2">
                                            <a class="c_icon_plus float-right collapsed nav-link text-truncate"
                                                :href="`#childmenu${subcategory.id}`" data-toggle="collapse">
                                                <i class="fa fa-plus-square-o"></i>
                                            </a>
                                        </div>
                                        
                                    </div>

                                    <div v-if="subcategory.childcategory.length > 0" :class="'collapse'"
                                        :id="`childmenu${subcategory.id}`" aria-expanded="false">
                                        <ul class="flex-column nav pl-4">
                                            <li :key="childcategory.id"
                                                v-for="childcategory in subcategory.childcategory" class="nav-item">

                                                <a role="button" class="nav-link p-1"
                                                    @click.prevent="guest_price == 0 || login == 1 ? redirectMe(childcategory.id,'c') : '#'"> <i
                                                        class="fa fa-star-o"></i>
                                                    {{childcategory.title[lang] ? childcategory.title[lang] : childcategory.title[fallbacklang]}}
                                                </a>

                                            </li>
                                        </ul>
                                    </div>

                                </div>


                            </ul>
                        </div>
                    </li>

                </ul>




            </ul>

            <!-- /.nav -->
        </nav>
        
        <!-- /.megamenu-horizontal -->
    </div>

</template>

<script>
    axios.defaults.baseURL = baseUrl;

    export default {
        props: ['fallbacklang', 'lang', 'categories','guest_price','login'],
        data(){
            return {
                collpase : true
            }
        },
        methods: {
            hideCategoryBar(){

                let status = $('#collapseExample').is(':hidden');

                $('#collapseExample').slideToggle();

                if(status == false){
                    this.collpase = false;
                    
                }else{
                    this.collpase = true;
                }

            },
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
        }
    }
</script>

<style>

</style>