<template>
    <div>
        <li v-for="menu in menus" :key="menu.id"
            :class="{'mega-drop-down' : menu.show_cat_in_dropdown == 1 || menu.show_child_in_dropdown == 1}">
            <a @click="menu.link_by =='cat'  ? redirectMe(menu.cat_id,'p') : '#'" role="button" class="bignavbar"
                :href="menu.link_by == 'page' ? `/show/${menu.gotopage.slug}` : menu.url"><i
                    v-if="menu.icon != null" :class="`fa ${menu.icon}`"></i>
                {{ menu.title[lang] ? menu.title[lang] : menu.title[fallback_local]}}

                <span v-if="menu.menu_tag == 1" :style="{'background-color' : menu.tag_bg,'color' : menu.tag_bg}"
                    title="Tag Text" class="menu-label new_menu hidden-xs">
                    <span :style="{ 'color' : menu.tag_color }">
                        {{ menu.tag_text[lang] ? menu.tag_text[lang] : menu.tag_text[fallback_local]}}
                    </span>
                </span>

            </a>

            <div v-if="menu.show_cat_in_dropdown == 1 || menu.show_child_in_dropdown == 1"
                class="desktopmegamenu mega-menu mr-2 ml-2">
                <div class="mega-menu-wrap">

                    <div class="row">
                        <div :class="{'col-md-9' : menu.bannerimage != null, 'col-md-12' : menu.bannerimage == null}">
                            <div class="row">
                                
                                <div class="p-3"  v-for="(value, key) in menu.megamenu.slice(0,menu.megamenu.length)" :key="key"
                                    :class="{'col-3' : menu.megamenu.length >= 4, 'col-6' : menu.megamenu.length == 2,'col-4' : menu.megamenu.length == 3, 'col-12' : menu.megamenu.length == 1 ,'f3efef' : key % 2 == 0 }">



                                    <span v-for="(v,index) in value" :key="index">
                                        <h4 v-if="v.type == 'category'" class="maintitle mega-title">
                                            <a role="button" class="text-dark"
                                                @click="v.cattype == 'primary' ?  redirectMe(v.id,'p') : redirectMe(v.id,'s')">

                                                {{ v.title }} &nbsp;&nbsp;<i class="playicon fa fa-play"
                                                    aria-hidden="true"></i>


                                            </a>
                                        </h4>


                                        <ul style="position: relative;top: 8px;" v-if="v.type == 'subcategory'"
                                            class="mt-2 w150 description">
                                            <li>

                                                <a role="button"
                                                    @click="v.cattype == 'subcat' ?  redirectMe(v.id,'s') : redirectMe(v.id,'c')">

                                                    {{v.title}}
                                                </a>

                                            </li>

                                        </ul>


                                        <span style="position: relative;top: 15px;" v-if="v.type == 'detail'">

                                            <p>
                                                {{v.title.length > 30 ? v.title.substring(0,30)+'...' : v.title}}
                                            </p>


                                        </span>


                                    </span>




                                </div>



                            </div>
                        </div>

                        <div v-if="menu.bannerimage != null" :style="[rtl == false ? {'background-position': 'right top'} : {'background-position': 'left top'} , {'background-size' : 'contain'}, {'background-repeat': 'no-repeat'},{'background-image' : `url('${baseUrl}/images/menu/${menu.bannerimage}')`}]" class="text-right col-md-3">
                            <a target="blank" :href="menu.img_link">
                                <!-- <img class="banner-img" :src="`/images/menu/${menu.bannerimage}`"> -->
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </div>
</template>

<script>
    axios.defaults.baseURL = baseUrl;

    import EventBus from '../../EventBus';

    export default {
        data() {
            return {
                menus: [],
                lang: '',
                fallback_local: '',
                rtl : rtl,
                baseUrl : baseUrl
            }
        },
        methods: {

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
        async created() {

            await axios.get('/vue/top/menus').then(res => {
                this.menus = res.data.menus;
                this.lang = res.data.lang;
                this.fallback_local = res.data.fallback_local;

                /** Fire a emit to load same menu on mobile menu sidebar */

                EventBus.$emit('loadmenu', this.menus, this.lang, this.fallback_local);


            }).catch(err => console.log(err));

        }
    }
</script>

<style>
    .menu-label {
        position: absolute;
        text-transform: uppercase;
        top: -10px;
        display: inline;
        padding: 4px 6px;
        font-size: 10px;
        font-family: 'Barlow', sans-serif;
        right: 23px;
        line-height: normal;
        letter-spacing: 1px;
        border-radius: 2px;
    }

    .menu-label::after {
        border-color: currentColor rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) rgba(0, 0, 0, 0);
    }

    .menu-label:after {

        border-width: 6px 7px 0 6px;
        right: 18px;
        top: 90%;
        border-style: solid;
        content: "";
        display: block;
        height: 0;
        position: absolute;
        -webkit-transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -o-transitio: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
        width: 0;
        z-index: 100;
    }

    @-moz-document url-prefix() {

        .header-style-1 .header-nav .navbar-default .navbar-collapse .navbar-nav>li .menu-label {
            position: relative;
            top: -25px !important;
            right: -25px !important;
        }
    }

    .banner-img{
        max-width: 100%;
        height: 556.6px;
    }
</style>