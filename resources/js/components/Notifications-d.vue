<template>
    <section>
        <a :title="translate('staticwords.notification')" href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
            <sup v-if="count > 0" id="countNoti" class="bell-badge">
                {{ count }}
            </sup>
        </a>



        <ul id="dropdown" class="z-index99 dropdown-menu">
            <li class="notiheadergrey header">
                {{ translate('staticwords.Youhave') }}
                <b>{{ count }}</b>
                {{ translate('staticwords.notification') }} !
                <a class="color111 float-right" :href="`${baseUrl}/clearall`">{{ translate('staticwords.MarkallasRead') }}</a>

            </li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu notification-menu">
                <div v-if="count > 0">
                    <li v-for="noti in notifications" :key="noti.id" class="notiheaderlightgrey hey1" :id="noti.id"
                        @click="markread(noti.id)">
                        <p></p>
                        <small class="padding5P float-right"><i class="fa fa-clock-o" aria-hidden="true"></i>
                            {{ noti.date }}</small>
                        <a class="font-weight600 color111"
                            :href="noti.n_type == 'order' ? `view/order/${noti.data.url}` : `/mytickets`"
                            @click="markread(noti.id)"><i class="fa fa-circle-o" aria-hidden="true"></i>
                            {{ noti.data.data }}
                        </a>

                        <p></p>

                    </li>
                </div>
                <div v-else>
                    <li class="notiheaderlightgrey">
                        No notifications
                    </li>
                </div>
            </ul>
        </ul>
    </section>
</template>

<script>
    axios.defaults.baseURL = baseUrl;

    export default {
        data() {
            return {
                count: 0,
                notifications: [],
                baseUrl : baseUrl
            }
        },
        methods: {
            loadnotifications() {
                axios.get('/vue/user/notifications').then(res => {
                    this.count = res.data.count;
                    this.notifications = res.data.notifications;

                });
            },
            markread(id) {
                axios.get('/usermarkreadsingle', {
                    params: {
                        id1: id
                    }
                }).then(res => {

                    this.loadnotifications();

                }).catch(err => console.log(err));
            }
        },
        created() {
            this.loadnotifications();
        }
    }
</script>

<style>

</style>