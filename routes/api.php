<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** Single Homepage API */
Route::get('homepage', 'Api\MainController@homepage');
/**  */

Route::get('/change-currency','Api\CurrencyController@changeCurrency');

/** Login register and logout with refresh token api */
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('register', 'Api\Auth\RegisterController@register');

/** Three level Categories with product without products api */
Route::get('categories', 'Api\MainController@categories');
Route::get('subcategories', 'Api\MainController@subcategories');
Route::get('childcategories', 'Api\MainController@childcategories');
Route::get('category/{id}', 'Api\MainController@getcategoryproduct');
Route::get('subcategory/{id}', 'Api\MainController@getsubcategoryproduct');
Route::get('childcategory/{id}', 'Api\MainController@getchildcategoryproduct');

/** Offer,Hotdeals,Sliders,brands,Page api */
Route::get('/brands', 'Api\MainController@brands');
Route::get('/brands/{id}/products', 'Api\BrandController@getBrandProducts');
Route::get('/page/{slug}', 'Api\MainController@page');

/** Menus API */
Route::get('topmenus', 'Api\MainController@menus');
Route::get('footermenus', 'Api\MainController@footermenus');

/** Genreal FAQs Apis */
Route::get('faqs', 'Api\MainController@faqs');

/* Blogs APIs*/
Route::get('/blog/post/{slug}', 'Api\MainController@blogdetail');

/** User Profile APIs */
Route::middleware(['auth:api'])->group(function () {

    /** Logout and refresh tokens */
    
    Route::post('logout', 'Api\Auth\LoginController@logout');
    Route::post('refresh', 'Api\Auth\LoginController@refresh');

    Route::get('myprofile', 'Api\MainController@userprofile');
    Route::get('mywallet', 'Api\MainController@mywallet');

    Route::get('manageaddress', 'Api\MainController@getuseraddress');
    Route::post('create-address','Api\MainController@createaddress');

    Route::get('billing-address','Api\MainController@listbillingaddress');
    Route::post('create-billing-address','Api\MainController@createbillingaddress');

    Route::get('mybanks', 'Api\MainController@getuserbanks');
    Route::get('notifications', 'Api\MainController@myNotifications');
    
    /**Cart API's */
    Route::get('cart','Api\CartController@yourCart');
    Route::post('addtocart','Api\CartController@addToCart');
    Route::post('remove/cart/item','Api\CartController@cartItemRemove');
    Route::post('clear-cart','Api\CartController@clearCart');
    Route::post('increase-quantity/in/cart','Api\CartController@increaseQuantity');

    /** Wishlist Collection & Wishlist */
    Route::get('wishlist', 'Api\ProductController@wishlist');
    Route::post('wishlist/remove/{wishlistid}', 'Api\ProductController@removeitemfromWishlist');

    Route::get('wishlist/collection','Api\WishlistController@listCollection');
    Route::get('wishlist/collection/{id}','Api\WishlistController@listCollectionItemsByID');
    Route::post('wishlist/create-collection','Api\WishlistController@createCollection');
    
    /** Apply Coupans */
    Route::post('/apply-coupans','Api\CoupanApplyController@apply');
    Route::post('/remove-coupan','Api\CoupanApplyController@removeCoupan');

    /** Pincode fetch with address for logged in user */
    Route::get('/search/pincode/auth/','Api\MainController@fetchPinCodeAddressForAuthUser');

    /** Order Review  */

    Route::post('/order-review','Api\OrderController@orderReview');

    /** Local Pickup apply and remove */
    Route::post('/localpickup/apply','Api\OrderController@localpickupapply');
    Route::post('/localpickup/remove','Api\OrderController@localpickupremove');

    Route::post('/rpay/paymentid','Api\PaymentController@getPaymentID');

    /** Confirm Order API */

    Route::post('/confirm/order','Api\PaymentController@confirmOrder');

});

/** Add Item in wishlist */

Route::post('wishlist/add/{variantid}', 'Api\ProductController@additeminWishlist');

/** Product detail page */

Route::get('details/{productid}/{variantid}', 'Api\ProductController@detailProduct');

/* Delivery Location API*/
Route::get('/delivery-check','Api\ProductController@checkPincode');

/** General Configuration */
Route::get('/configs','Api\ConfigController@getConfigs');

/** Payment Methods */
Route::get('/payment-list','Api\ConfigController@getPaymentMethods');

/** List of coutries , states, cities */
Route::get('/countries','Api\MainController@listofcountries');
Route::get('/states/{countryid}','Api\MainController@listofstates');
Route::get('/city/{stateid}','Api\MainController@listofcities');

/** Search Cities */
Route::get('/search/city/','Api\MainController@searchcity');

/** Pincode fetch with address for guest user */
Route::get('/search/pincode/guest/','Api\MainController@fetchPinCodeAddressForGuest');
