(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/page1Comp"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Homepage/Hotdeal.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Homepage/Hotdeal.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _EventBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../EventBus */ "./resources/js/EventBus.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['hotdeals', 'lang', 'fallbacklang', 'login', 'guest_price', 'date'],
  data: function data() {
    return {
      rtl: rtl,
      dealincart: 0,
      loading: true,
      baseurl: baseUrl
    };
  },
  methods: {
    redirectMe: function redirectMe() {
      window.location.href = "".concat(this.baseurl, "/cart");
    },
    addToCart: function addToCart(cartURL) {
      var _this = this;

      axios.post(cartURL).then(function (res) {
        if (res.data.status == 'success') {
          var config = {
            text: res.data.msg,
            button: 'CLOSE'
          };
          _EventBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('re-loadcart', 1);

          _this.$snack['success'](config);

          _this.dealincart = 1;
        } else {
          var _config = {
            text: res.data.msg,
            button: 'CLOSE'
          };

          _this.$snack['danger'](_config);
        }
      })["catch"](function (err) {
        var config = {
          text: 'Something went wrong !',
          button: 'CLOSE'
        };

        _this.$snack['danger'](config);

        console.log(err);
      });
    },
    timer: function timer() {
      var d = new Date();
      var datestring = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
      var pausecontent = new Array();
      $.each(this.hotdeals, function (key, value) {
        var start = value.start_date;
        var end = value.end_date;

        if (start <= datestring && end >= datestring) {
          pausecontent.push(value);
        }
      });

      if ($('.timing-wrapper').length) {
        $('.timing-wrapper').each(function () {
          var $this = $(this);
          var finalDate = $(this).data('countdown');
          var finalDate1 = $(this).data('startat');

          if (datestring >= finalDate1) {
            $this.countdown(finalDate, function (event) {
              var $this = $(this).html(event.strftime('' + '<div class="box-wrapper"><div class="date box"> <span class="key">%D</span> <span class="value">DAYS</span> </div> </div> ' + '<div class="box-wrapper"><div class="hour box"> <span class="key">%H</span> <span class="value">HRS</span> </div> </div> ' + '<div class="box-wrapper"><div class="minutes box"> <span class="key">%M</span> <span class="value">MINS</span> </div> </div> ' + '<div class="box-wrapper"><div class="seconds box"> <span class="key">%S</span> <span class="value">SEC</span> </div> </div> '));
            });
          }
        });
      }

      if (pausecontent.length == 0) {
        $('.hot-deals').remove();
      }
    }
  },
  created: function created() {
    // setTimeout(() => {
    var vm = this;
    this.loading = false;
    Vue.nextTick(function () {
      vm.hotdeals = this.hotdeals;
      $(".hot-deal-carousel").owlCarousel({
        items: 1,
        itemsTablet: [978, 1],
        itemsDesktopSmall: [979, 2],
        itemsDesktop: [1199, 1],
        nav: true,
        slideSpeed: 300,
        pagination: false,
        lazyLoad: true,
        paginationSpeed: 400,
        navText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"],
        rtl: rtl
      });
      this.timer();
    }.bind(vm)); // }, 3000);
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Homepage/Hotdeal.vue?vue&type=template&id=45eccf63&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Homepage/Hotdeal.vue?vue&type=template&id=45eccf63& ***!
  \*******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "mt-2 mb-lg-2 mb-md-1 mb-sm-1 sidebar-widget hot-deals" },
    [
      _c("h3", { staticClass: "section-title" }, [
        _vm._v(_vm._s(_vm.translate("staticwords.Hotdeals")))
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "owl-carousel hot-deal-carousel custom-carousel owl-theme outer-top-ss"
        },
        _vm._l(_vm.hotdeals, function(product) {
          return _c(
            "div",
            { key: product.productid, staticClass: "item hot-deals-item" },
            [
              _c("div", { staticClass: "products" }, [
                _c("div", { staticClass: "hot-deal-wrapper" }, [
                  _c(
                    "div",
                    {
                      staticClass: "image",
                      class: { "pro-img-box": product.stock == 0 }
                    },
                    [
                      _c(
                        "a",
                        {
                          attrs: {
                            href: product.producturl,
                            title: product.productname[_vm.lang]
                              ? product.productname[_vm.lang]
                              : product.productname[_vm.fallbacklang]
                          }
                        },
                        [
                          product.thumbnail
                            ? _c("span", [
                                _c("img", {
                                  staticClass: "owl-lazy",
                                  class: { filterdimage: product.stock == 0 },
                                  attrs: {
                                    "data-src": product.thumbnail,
                                    alt: "product_image"
                                  }
                                }),
                                _vm._v(" "),
                                _c("img", {
                                  staticClass: "owl-lazy hover-image",
                                  class: { filterdimage: product.stock == 0 },
                                  attrs: {
                                    "data-src": product.hover_thumbnail,
                                    alt: "product_image"
                                  }
                                })
                              ])
                            : _c("span", [
                                _c("img", {
                                  staticClass: "owl-lazy",
                                  class: { filterdimage: product.stock == 0 },
                                  attrs: {
                                    title: product.productname[_vm.lang]
                                      ? product.productname[_vm.lang]
                                      : product.productname[_vm.fallbacklang],
                                    src:
                                      _vm.baseurl + "'/images/no-image.png'}",
                                    alt: "No Image"
                                  }
                                })
                              ])
                        ]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "sale-offer-tag" }, [
                    _c("span", [
                      _vm._v(
                        "\n                  " +
                          _vm._s(product.off_in_percent) +
                          "%\n                  "
                      ),
                      _c("br"),
                      _vm._v("\n                    off")
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "countdown" }, [
                    _c("div", {
                      staticClass: "timing-wrapper",
                      attrs: {
                        "data-startat": product.start_date,
                        "data-countdown": product.end_date
                      }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "product-info text-center m-t-20" }, [
                  _c("h3", { staticClass: "name" }, [
                    _c("a", { attrs: { href: product.producturl } }, [
                      _vm._v(
                        _vm._s(
                          product.productname[_vm.lang]
                            ? product.productname[_vm.lang]
                            : product.productname[_vm.fallbacklang]
                        )
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  product.rating != 0
                    ? _c("div", { staticClass: "text-center" }, [
                        _c("div", { staticClass: "star-ratings-sprite" }, [
                          _c("span", {
                            staticClass: "star-ratings-sprite-rating",
                            style: { width: product.rating + "%" }
                          })
                        ])
                      ])
                    : _c("div", { staticClass: "no-rating" }, [
                        _vm._v("No Rating")
                      ]),
                  _vm._v(" "),
                  _vm.guest_price == "0" || _vm.login == 1
                    ? _c("div", { staticClass: "product-price" }, [
                        _c("span", { staticClass: "price" }, [
                          product.offerprice == 0
                            ? _c("div", [
                                _c("span", { staticClass: "price" }, [
                                  _c("i", { class: product.symbol }),
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(product.mainprice)
                                  )
                                ])
                              ])
                            : _c("div", [
                                _c("span", { staticClass: "price" }, [
                                  _c("i", { class: product.symbol }),
                                  _vm._v(_vm._s(product.offerprice))
                                ]),
                                _vm._v(" "),
                                _c(
                                  "span",
                                  { staticClass: "price-before-discount" },
                                  [
                                    _c("i", { class: product.symbol }),
                                    _vm._v(_vm._s(product.mainprice))
                                  ]
                                )
                              ])
                        ])
                      ])
                    : _c("div", [
                        _c("h5", { staticClass: "text-red" }, [
                          _vm._v("Login to view Price")
                        ])
                      ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "cart clearfix animate-effect" }, [
                  _c("div", { staticClass: "action" }, [
                    _c("ul", { staticClass: "list-unstyled" }, [
                      product.stock != 0 &&
                      product.selling_start_at != null &&
                      product.selling_start_at >= _vm.date
                        ? _c(
                            "h5",
                            {
                              staticClass: "text-success",
                              attrs: { align: "center" }
                            },
                            [
                              _c("span", [
                                _vm._v(
                                  _vm._s(
                                    _vm.translate("staticwords.ComingSoon")
                                  )
                                )
                              ])
                            ]
                          )
                        : _c("div", [
                            product.in_cart == 0 && _vm.dealincart == 0
                              ? _c(
                                  "form",
                                  {
                                    attrs: { method: "POST" },
                                    on: {
                                      submit: function($event) {
                                        $event.preventDefault()
                                        return _vm.addToCart(product.cartURL)
                                      }
                                    }
                                  },
                                  [
                                    _c(
                                      "li",
                                      {
                                        staticClass: "add-cart-button btn-group"
                                      },
                                      [
                                        _vm._m(0, true),
                                        _vm._v(" "),
                                        _c(
                                          "button",
                                          {
                                            staticClass:
                                              "btn btn-primary cart-btn",
                                            attrs: { type: "submit" }
                                          },
                                          [
                                            _vm._v(
                                              "\n                                " +
                                                _vm._s(
                                                  _vm.translate(
                                                    "staticwords.AddtoCart"
                                                  )
                                                ) +
                                                "\n                              "
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              : _c("div", [
                                  _c(
                                    "li",
                                    {
                                      staticClass: "add-cart-button btn-group",
                                      on: {
                                        click: function($event) {
                                          $event.preventDefault()
                                          return _vm.redirectMe($event)
                                        }
                                      }
                                    },
                                    [
                                      _vm._m(1, true),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn btn-primary cart-btn",
                                          attrs: { type: "button" }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                Deal in Cart\n                              "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                ])
                          ]),
                      _vm._v(" "),
                      product.stock == 0
                        ? _c(
                            "h5",
                            {
                              staticClass: "required",
                              attrs: { align: "center" }
                            },
                            [
                              _c("span", [
                                _vm._v(
                                  "\n                          " +
                                    _vm._s(
                                      _vm.translate("staticwords.Outofstock")
                                    ) +
                                    "\n                        "
                                )
                              ])
                            ]
                          )
                        : _vm._e()
                    ])
                  ])
                ])
              ])
            ]
          )
        }),
        0
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "btn btn-primary icon",
        attrs: { "data-toggle": "dropdown", type: "button" }
      },
      [_c("i", { staticClass: "fa fa-shopping-cart" })]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "btn btn-primary icon",
        attrs: { "data-toggle": "dropdown", type: "button" }
      },
      [_c("i", { staticClass: "fa fa-check" })]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Homepage/Hotdeal.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/Homepage/Hotdeal.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Hotdeal_vue_vue_type_template_id_45eccf63___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Hotdeal.vue?vue&type=template&id=45eccf63& */ "./resources/js/components/Homepage/Hotdeal.vue?vue&type=template&id=45eccf63&");
/* harmony import */ var _Hotdeal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Hotdeal.vue?vue&type=script&lang=js& */ "./resources/js/components/Homepage/Hotdeal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Hotdeal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Hotdeal_vue_vue_type_template_id_45eccf63___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Hotdeal_vue_vue_type_template_id_45eccf63___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Homepage/Hotdeal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Homepage/Hotdeal.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/Homepage/Hotdeal.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Hotdeal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Hotdeal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Homepage/Hotdeal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Hotdeal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Homepage/Hotdeal.vue?vue&type=template&id=45eccf63&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/Homepage/Hotdeal.vue?vue&type=template&id=45eccf63& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Hotdeal_vue_vue_type_template_id_45eccf63___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Hotdeal.vue?vue&type=template&id=45eccf63& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Homepage/Hotdeal.vue?vue&type=template&id=45eccf63&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Hotdeal_vue_vue_type_template_id_45eccf63___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Hotdeal_vue_vue_type_template_id_45eccf63___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);