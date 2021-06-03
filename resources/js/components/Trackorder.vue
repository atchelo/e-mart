<template>
    <div>
        <div class="breadcrumb">
            <div class="container-fluid">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="/">Home</a></li>
                        <li class='active'>TrackOrder</li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="body-content">
            <div class="container-fluid">
                <div class="track-order-page">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="heading-title">Track your Order</h2>
                            <span class="title-tag inner-top-ss">Please enter your Order ID in the box below and press
                                Enter.
                                This was given to you on your order page and in the confirmation email you should have
                                received.
                            </span>
                            <form :class="{'was-validated' : result.status == 'success'}" @submit.prevent="tracktheorder()" class="register-form outer-top-xs"
                                role="form" no-validate>
                                <div class="form-group">
                                    
                                    <label class="info-title" for="exampleOrderId1">Tracking ID</label>
                                    <input :class="{'is-invalid' : result.status == 'fail'}" v-model="trackingID" required type="text"
                                        class="form-control unicase-form-control text-input">
                                </div>
                                <button type="submit"
                                    class="btn-upper btn btn-primary checkout-page-button">Track</button>
                            </form>
                        </div>

                        <div v-if="loading" class="col-md-12">
                           <track-skelton></track-skelton> 
                        </div>

                        <div v-if="result && result.status == 'success'" class="col-md-12">
                            <hr>
                            <h4>Order Summary</h4>
                            <hr>
                            <div class="row bg-light p-2">
                                <div class="col-lg-3 col-sm-6 col-xs-6">
                                    <h5>Order details</h5>
                                    <hr>
                                    <p><b>Parent Order ID:</b> {{result.order.parent_order_id}}</p>
                                    <p><b>Placed on: </b> {{result.order.placed_on}}</p>
                                    <p><b>Total Amount: </b> {{result.order.amount}}</p>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-xs-6">
                                    <h5>Customer details</h5>
                                    <hr>
                                    <p><b>Customer name:</b> {{ result.order.address.customer_name }}</p>
                                    <p><b>Contact no:</b> {{ result.order.address.customer_phone }} </p>
                                    <p><b>Email : </b> {{ result.order.address.customer_email }}</p>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-xs-6">
                                    <h5>Shipping details</h5>
                                    <hr>
                                    <p class="font-weight-bold">{{ result.order.address.address }}</p>
                                    <p class="font-weight-bold">{{ result.order.address.city }},
                                        {{ result.order.address.state }}, {{ result.order.address.country }}</p>
                                    <p class="font-weight-bold">{{ result.order.address.pincode }}</p>
                                </div>
                            </div>

                            <div class="text-center track">
                                <div :class="{'active' : result.order.orderstatus == 'pending' || result.order.orderstatus == 'processed' || result.order.orderstatus == 'shipped' || result.order.orderstatus == 'delivered' || result.order.orderstatus == 'return_request' || result.order.orderstatus == 'ret_ref' || result.order.orderstatus == 'refunded' || result.order.orderstatus == 'canceled'}"
                                    class="step"> <span class="text-center icon"> <i class="fa fa-inbox"></i> </span>
                                    <span class="text">Pending</span> </div>

                                <div :class="{'active' : result.order.orderstatus == 'processed' || result.order.orderstatus == 'shipped' || result.order.orderstatus == 'delivered' || result.order.orderstatus == 'return_request' || result.order.orderstatus == 'ret_ref' || result.order.orderstatus == 'refunded' || result.order.orderstatus == 'canceled'}"
                                    class="step"> <span class="text-center icon"> <i class="fa fa-rocket"></i> </span>
                                    <span class="text"> Proccessed</span> </div>

                                <div v-if="result.order.orderstatus != 'canceled'"
                                    :class="{'active' : result.order.orderstatus == 'shipped' || result.order.orderstatus == 'delivered' || result.order.orderstatus == 'return_request' || result.order.orderstatus == 'ret_ref' || result.order.orderstatus == 'refunded'}"
                                    class="step"> <span class="text-center icon"> <i class="fa fa-truck"></i> </span>
                                    <span class="text"> Shipped </span> </div>

                                <div v-if="result.order.orderstatus != 'canceled'"
                                    :class="{'active' : result.order.orderstatus == 'delivered' || result.order.orderstatus == 'return_request' || result.order.orderstatus == 'ret_ref' || result.order.orderstatus == 'refunded'}"
                                    class="step"> <span class="text-center icon"> <i class="fa fa-check"></i> </span>
                                    <span class="text">Delivered</span> 
                                </div>

                                <div v-if="result.order.orderstatus == 'canceled'"
                                    :class="{'active step-danger' : result.order.orderstatus == 'canceled'}" class="step"> <span
                                        class="text-center icon" :style="{background : 'orange'}"> <i class="fa fa-check"></i> </span> <span
                                        class="text">Cancelled</span> </div>

                                <div v-if="result.order.orderstatus == 'return_request' || result.order.orderstatus == 'refunded' || result.order.orderstatus == 'ret_ref'"
                                    :class="{'active step-danger' : result.order.orderstatus == 'return_request' || result.order.orderstatus == 'ret_ref' || result.order.orderstatus == 'refunded'}"
                                    class="step"> <span :style="{background : 'orange'}" class="text-center icon"> <i
                                            class="fa fa-exclamation-triangle"></i> </span> <span class="text">Return
                                        requested</span> </div>

                                <div v-if="result.order.orderstatus == 'return_request' || result.order.orderstatus == 'ret_ref' || result.order.orderstatus == 'refunded'"
                                    :class="{'active step-danger' : result.order.orderstatus == 'ret_ref' || result.order.orderstatus == 'refunded'}"
                                    class="step"> <span :style="{background : 'orange'}" class="text-center icon"> <i
                                            class="fa fa-check"></i> </span> <span class="text">Returned</span> </div>
                            </div>

                            <div v-if="result.order.trackinglogs && result.order.trackinglogs.length">
                                <table align="center"
                                    class="bg-light col-lg-7 col-sm-12 col-md-12 table table-bordered">

                                    <tbody>
                                        <tr v-for="log in result.order.trackinglogs" :key="log.id">
                                            <td class="font-weight-normal">
                                                Your order is {{log.log}}
                                            </td>
                                            <td>
                                                {{log.created_at}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <h4 class="text-center">No tracking logs available currently</h4>
                            </div>

                        </div>

                        <div v-if="result && result.status == 'fail' " class="col-md-12">
                            <h4 class="text-center">
                                {{result.msg}}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    axios.defaults.baseURL = baseURL;


    export default {
        props: ['trackid'],
        data() {
            return {
                trackingID: this.trackid,
                result: [],
                loading : true,
            }
        },
        methods: {
            tracktheorder() {

                this.loading = true;

                this.result = [];

                  var exist = window.location.href;
                  var url = new URL(exist);
                  var query_string = url.search;
                  var search_params = new URLSearchParams(query_string);
                  search_params.set('trackingid', this.trackingID);
                  url.search = search_params.toString();
                  var new_url = url.toString();
                  window.history.pushState('page2', 'Title', new_url);

                this.trackorder();
            },
            trackorder() {

                axios.post('/track/order', {
                    trackingid: this.trackingID
                }).then(res => {

                    this.result = res.data;
                    this.loading = false;

                }).catch(err => console.log(`Error: ${err}`));


            }
        },
        created() {

            this.trackorder();

        }
    }
</script>

<style scoped>
    .track {
        position: relative;
        background-color: #ddd;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 60px;
        margin-top: 50px
    }

    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        position: relative
    }

    .track .step.active:before {
        background: #20d447;
    }

    .track .step-danger.active:before {
        background: orange !important;
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .step.active .icon {
        background: #20d447;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .step.active .text {
        font-weight: 400;
        color: #000
    }

    .track .text {
        display: block;
        margin-top: 7px;
        text-align: center !important;
    }
</style>