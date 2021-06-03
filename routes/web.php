<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/** Development Routes */

Route::get('/phpinfo',function(){
    return phpinfo();
});

Route::get('/t',function(){

    return auth()->user()->activeSubscription;

});


Route::any('/notify/payhere', 'PayhereController@notify');

Route::get('/ota/update', 'OtaUpdateController@getotaview');

Route::post('prelogin/ota/check','OtaUpdateController@prelogin')->name('prelogin.ota.check');

Route::get('/dont-show-popup','OfferPopUpController@dontShow')->name('offer.pop.not.show');


// Route::get('/dontuse',function(){
//   $images = \DB::table('variant_images')->get();

//   foreach($images as $img){

//       \DB::table('variant_images')->where('id','=',$img->id)->update(['image1' => str_replace(".png","",$img->image1) , 'image2' => str_replace(".png","",$img->image2), 'image3' => str_replace(".png","",$img->image3), 'image4' => str_replace(".png","",$img->image4), 'image5' => str_replace(".png","",$img->image5), 'image6' => str_replace(".png","",$img->image6), 'main_image' => str_replace(".png","",$img->main_image) ]);

//       //\DB::table('variant_images')->where('id','=',$img->id)->update(['image1' => $img->image1.'.jpg' , 'image2' => $img->image2.'.jpg', 'main_image' => $img->main_image.'.jpg' ]);
//   }
// });

/** Should Removed in Production mode */

Route::post('/sendsms','TwilloController@sendsms');

Route::get('/change-currency/{id}', 'MainController@currency');

Route::post('/change-domain','MainController@changedomain');

Route::group(['middleware' => ['web','switch_lang']], function () {

    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::get('store/{uuid}/{title}','ViewStoreController@view')->name('store.view');

    /** Installer Routes */

    Route::get('verifylicense', 'InstallerController@verifylicense')->name('verifylicense');

    Route::get('/install/procceed/verifyapp', 'InstallerController@verify')->name('verifyApp');

    Route::post('verifycode', 'InitializeController@verify');

    Route::get('/install/procceed/EULA', 'InstallerController@eula')->name('eulaterm');

    Route::get('/install/procceed/serverCheck', 'InstallerController@serverCheck')->name('servercheck');

    Route::post('/install/procceed/EULA', 'InstallerController@storeeula')->name('store.eula');

    Route::post('/install/procceed/serverCheck', 'InstallerController@storeserver')->name('store.server');

    Route::get('/install/procceed/step1', 'InstallerController@index')->name('installApp');

    Route::get('/search/items', 'SearchController@ajaxSearch')->name('ajaxsearch');

    Route::post('store/step1', 'InstallerController@step1')->name('store.step1');

    Route::get('/install/procceed/step2', 'InstallerController@getstep2')->name('get.step2');
    Route::get('/install/procceed/step3', 'InstallerController@getstep3')->name('get.step3');
    Route::get('/install/procceed/step4', 'InstallerController@getstep4')->name('get.step4');
    Route::get('/install/procceed/step5', 'InstallerController@getstep5')->name('get.step5');
    Route::post('stored/step2', 'InstallerController@step2')->name('store.step2');
    Route::post('stored/step3', 'InstallerController@storeStep3')->name('store.step3');
    Route::post('stored/step4', 'InstallerController@storeStep4')->name('store.step4');
    Route::post('stored/step5', 'InstallerController@storeStep5')->name('store.step5');

    /** End */
    

    Route::group(['middleware' => ['maintainence_mode']], function () {

        Auth::routes(['verify' => true]);

        Route::post('register', 'Auth\RegisterController@register')->name('register');

        Route::get('/contact-us','ContactController@index')->name('contact.us');

        Route::post('/contact-us','ContactController@getConnect')->name('get.connect');

        Route::group(['middleware' => ['IsInstalled', 'is_verified', 'isActive', 'two_fa','switch_lang']], function () {

            
            Route::get('/','Web\HomeController@newHomepage')->name('mainindex')->middleware('visiting_track');

            Route::post('/subscribe/for/product/stock/{varid}', 'ProductNotifyController@post')->name('pro.stock.subs');

            Route::get('/share', 'MainController@share')->name('share');

            Route::post('/menu/sort', 'MenuController@sort')->name('menu.sort');

            Route::get('/download/catlog/{catlog}','ProductController@download')->name('download.catlog');

            Route::get('/seller/plans','SellerSubscriptionController@frontendplans')->name('front.seller.plans');

            Route::get('/seller/payforplans/','SellerSubscriptionController@paymentscreen')->name('seller.plans.payment.screen');

            Route::post('/seller/payforplans/','SellerSubscriptionController@paymentscreen')->name('seller.plans.payment.screen');

            // Route::get('/verify', 'Auth\RegisterController@getotpview')->name('verify.otp');

            // Route::get('resendotp', 'Auth\RegisterController@resendotp')->name('resend.otp');

            // Route::get('cancelotp', 'Auth\RegisterController@cancelotp')->name('cancel.otp');

            Route::post('/success/aamarpay','AamarpayController@success')->name('amarpay.success');

            Route::get('/blog', 'BlogController@frontindex')->name('front.blog.index');

            Route::get('/blogsearch', 'BlogController@search')->name('blog.search');

            Route::get('/blog/post/{slug}', 'BlogController@show')->name('front.blog.show');

            Route::get('details/{id}', 'MainController@details_product'); // Product Detail Page

            Route::get('cart/', 'CartController@create_cart')->name('user.cart');
            Route::post('add_item/{id}/{variantid}/{varprice}/{varofferprice}/{qty}', 'CartController@add_item')->name('add.cart');
            Route::get('create_deal/', 'CartController@create_deal');
            Route::get('addtocart/{id}', 'CartController@index');
            Route::get('remove_cart/{id}', 'CartController@remove_cart')->name('rm.session.cart');
            Route::get('remove_table_cart/{id}', 'CartController@remove_table_cart')->name('rm.cart');;
            Route::post('update_table_cart/{id}', 'CartController@update_table_cart');
            Route::post('update_cart/{id}', 'CartController@update_cart');
            Route::get('update_cart/{id}', 'CartController@update_cart');
            Route::get('check/', 'MainController@check');
            Route::post('user_review/{id}', 'MainController@user_review');
            Route::get('category_show/{id}', 'MainController@category_show');
            Route::get('detail/{id}', 'MainController@detail');
            Route::get('brandshow/{id}/{catid}', 'MainController@brandshow');
            Route::get('tags/{id}/{catid}', 'MainController@tags');
            Route::get('shopbycat/{id}', 'MainController@shopbycat');
            Route::post('coupan_apply/', 'MainController@coupan_apply');
            Route::get('coupan_destroy/', 'MainController@coupan_destroy');
            Route::get('rentdays/', 'CartController@rent_update')->name('rentdays');
            Route::get('test/', 'CartController@test');
            Route::get('search/', 'MainController@search');
            Route::get('/comparisonlist', 'MainController@comparisonList')->name('compare.list');;
            Route::get('addto/comparison/{id}', 'MainController@docomparison')->name('compare.product');
            Route::get('/remove/product/{id}/comparsion', 'MainController@removeFromComparsion')->name('remove.compare.product');
            Route::get('bankDetail', 'MainController@bankdetail');
            Route::get('edit_blog/{id}', 'MainController@edit_blog');
           
            Route::post('newsletter', 'NewsletterController@store');
            Route::get('checkoutasguest', 'MainController@guestCheckout')->name('guest.checkout');
            Route::post('apply/for/seller/proccess', 'MainController@store_vender')->name('apply.seller.store');
            Route::get('return_product/{id}', 'ReturnProductController@show_return');
            Route::post('cancel_product/{id}', 'ReturnProductController@cancel_product')->name('cancel.item');
            Route::get('fcategory/', 'MainController@fcategory');
            Route::get('update/', 'MainController@refresh_data');

            Route::post('user/process_to_guest/', 'MainController@process_to_guest');

            Route::post('/feedback/send', 'SendFeedBackController@send')->name('send.feedback');

            Route::post('/comment', 'CommentController@store')->name('post.comment');
            Route::post('/comments/', 'CommentController@subcomment');

            Route::get('/home', function () {
                return redirect('/');
            });

        });

            /*Seller Login Routes*/

            Route::get('/seller/login', 'GuestController@sellerloginview')->name('seller.login.page')->middleware('switch_lang');
            Route::post('/seller/secure/login', 'GuestController@dosellerlogin')->name('seller.login.do');

            /**/

            /*User Login Routes*/

            Route::post('/process/login/', 'CustomLoginController@doLogin')->name('normal.login')->middleware("throttle:1,1");

            Route::post('/proccess/login/reftocart/', 'GuestController@cartlogin')->name('ref.cart.login');

            /*End*/

            /*Guest Checkout process*/

            Route::post('/process/to/checkout/as/guest', 'GuestController@guestregister')->name('ref.guest.register');

            /** End */

            /*Register routes if user coming from checkout window*/

            Route::get('/process/to/register', 'GuestController@referfromcheckoutwindow')->name('referfromcheckoutwindow');
            Route::post('/process/to/register', 'GuestController@storereferfromcheckoutwindow')->name('storeuserfromchwindow');

            /*end*/

        Route::get('/changelang', 'GuestController@changelang')->name('changelang');

        Route::post('/cart/removecoupan/', 'CouponApplyController@remove')->name('removecpn');

        Route::get('/shop', 'MainController@categoryf')->name('filtershop')->middleware('switch_lang');

        Route::get('choose_state', 'GuestController@choose_state');

        Route::get('choose_city', 'GuestController@choose_city');

        Route::post('cart/applycoupon', 'CouponApplyController@apply')->name('apply.cpn');

        Route::get('/performcurrencyoperation', 'InstallerController@currencyOperation');

        Route::post('/comment/{postid}', 'BlogCommentController@store')->name('blog.comment.store');

        Route::get('/product/{id}/all/reviews', 'ProductController@allreviews')->name('allreviews');

        Route::get('/onloadvariant/{id}', 'AddSubVariantController@ajaxGet2');

        Route::get('/variantnotfound/{id}', 'AddSubVariantController@getDefaultforFailed');

        Route::get('login/{service}', 'Auth\LoginController@redirectToProvider')->name('sociallogin');

        Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.login.callback');

        Route::get('load/more/product/comment', 'CommentController@loadmore');

        Route::get('pincodeforaddress/', 'GuestController@getPinAddress')->name('pincodeforaddress');

        Route::get('/order-placed-successfully', function () {
            require_once base_path().'/app/Http/Controllers/price.php';
            return view('home.thankyou', compact('conversion_rate'));
        })->name('order.done')->middleware('switch_lang');

        Route::get('/setstart', 'GuestController@changeCur');

        Route::get('/category', 'MainController@category');
        Route::get('/categoryfilter', 'MainController@categoryfilter');

        Route::get('/faq', 'GuestController@faq')->middleware('switch_lang');

        Route::get('/show/{slug}', 'GuestController@showpage')->name('page.slug')->middleware('switch_lang');;

        Route::post('/empty/{token}/cart', 'CartController@emptyCart')->name('s.cart');

        Route::get('/onclickloadvariant/{id}', 'AddSubVariantController@ajaxGet');

        Route::view('checkoutProcess', 'front.chkoutnotlogin')->name('guest.check');

        Route::get('/getproductvar/testing', 'AddSubVariantController@gettingvar');

        Route::get('filter/brand/', 'MainController@brandfilter');

        Route::get('filter/variant/', 'MainController@variantfilter');

        Route::get("pincode-check", "PinCodController@pincode_check");

        Route::get("admin/gcat", "ProductController@gcato")->middleware('switch_lang');;
        Route::get("admin/dropdown", "ProductController@upload_info")->middleware('switch_lang');

        Route::get('admin/choose_state', 'UserController@choose_country');
        Route::get('admin/choose_city', 'UserController@choose_city');

        Route::get('/loadmore', 'LoadMoreController@index');
        Route::post('/loadmore/load_data', 'LoadMoreController@load_data')->name('loadmore.load_data');

        Route::get('ajax-form-submit', 'CommentController@ajex');
        Route::post('save-form', 'CommentController@ajex_submit');

        Route::get('checkout/', 'CheckoutController@index')->middleware('switch_lang');

        Route::post('/valid-2fa','TwoFactorController@login')->middleware('auth');

        /** Authorized Routes */

        Route::group(['middleware' => ['auth','is_verified','two_fa','switch_lang']], function () {

            Route::get('/user/affiliate/settings','AffilateController@userdashboard')->name('user.affiliate.settings');

            Route::get('/2fa','TwoFactorController@get2fa')->name('2fa.get');

            Route::post('/generate2faSecret','TwoFactorController@generate2faSecret');

            Route::post('/2fa-valid','TwoFactorController@valid2FA');

            Route::post('/disable-2fa','TwoFactorController@disable2FA');

            Route::get('/track/order','TrackOrderController@view')->name('track.order');

            Route::post('/track/order','TrackOrderController@get')->name('track.order.result');
            
            Route::get('apply-for-seller', 'MainController@applyforseller')->name('applyforseller');

            Route::post('paidvia/manualpay/{token}', 'ManualPaymentGatewayController@checkout')->name('manualpay.checkout');

            

            Route::post('payvia/iyzcio/proccess', 'IyzcioController@pay')->name('iyzcio.pay');
            Route::post('payvia/iyzcio/success', 'IyzcioController@callback')->name('iyzcio.callback');

            Route::post('/payvia/sslcommerze', 'SslCommerzPaymentController@index')->name('payvia.sslcommerze');
            Route::post('payvia/sslcommerze/success', 'SslCommerzPaymentController@success');
            Route::post('payvia/sslcommerze/fail', 'SslCommerzPaymentController@fail');
            Route::post('payvias/sslcommerze/cancel', 'SslCommerzPaymentController@cancel');
            Route::post('/payvia/sslcommerze/ipn', 'SslCommerzPaymentController@ipn');

            Route::get('check/variant/inwish', 'GuestController@checkInWish');

            Route::get('addtTocartfromWishList/{id}', 'MainController@addtTocartfromWishList');
            Route::get('AddToWishList/{id}', 'MainController@AddToWishList');
            Route::get('wishlist/', 'MainController@wishlist_show')->name('my.wishlist');
            Route::get('removeWishList/{id}', 'MainController@removeWishList');

            Route::post('process/billing-address', 'CheckoutController@add')->name('checkout');

            Route::get('order-review', 'CheckoutController@orderReview')->name('order.review');

            Route::get('profile/', 'CheckoutController@show_profile')->name('user.profile')->middleware('switch_lang');
            Route::get('edit_profile/', 'CheckoutController@edit_profile');
            Route::post('update_profile/{id}', 'CheckoutController@update');
            Route::get('order', 'CheckoutController@order')->name('user.order')->middleware('switch_lang');;
            Route::get('trackorder/{id}', 'CheckoutController@trackorder');
            Route::post('/changepass/{id}', 'CheckoutController@changepass')->name('pass.update');

            Route::get('/mywallet', 'WalletController@showWallet')->name('user.wallet.show')->middleware('switch_lang');;

            Route::post('/wallet/payment', 'WalletController@choosepaymentmethod')->name('wallet.choose.paymethod')->middleware('switch_lang');

            /*Add money using Paytm in wallet*/
            Route::post('/wallet/addmoney/using/paytm', 'WalletController@addMoneyViaPaytm')->name('wallet.add.using.paytm');
            Route::post('/wallet/success/using/paytm', 'WalletController@paytmsuccess');
            /*END*/

            /*Add money using Braintree in wallet*/
            Route::post('/wallet/braintree/accesstoken', 'WalletController@walletaccesstokenBT')->name('wallet.access.token.bt');
            Route::post('/wallet/addmoney/using/braintree', 'WalletController@addMoneyViaBraintree')->name('wallet.add.using.bt');
            Route::post('/wallet/success/using/braintree', 'WalletController@braintreesuccess');
            /*END*/

            /*Add money using Stripe in wallet*/
            Route::post('/wallet/addmoney/using/stripe', 'WalletController@addMoneyViaStripe')->name('wallet.add.using.stripe');
            Route::post('/wallet/success/using/stripe', 'WalletController@stripesuccess');
            /*END*/

            /*Add money using Paypal in wallet*/
            Route::post('/wallet/addmoney/using/paypal', 'WalletController@addMoneyViaPayPal')->name('wallet.add.using.paypal');
            Route::get('/wallet/success/using/paypal', 'WalletController@paypalSuccess');
            /*END*/

            /*Add money using razorpay in wallet*/
            Route::post('/wallet/addmoney/using/razorpay', 'WalletController@addMoneyViaRazorPay')->name('wallet.add.using.razorpay');
            /*End

            /*Add money using instamojo in wallet*/
            Route::post('/wallet/addmoney/using/instamojo', 'WalletController@addMoneyViaInstamojo')->name('wallet.add.using.instamojo');

            Route::get('/wallet/success/using/instamojo', 'WalletController@instaSuccess');
            /*End*/

            /*Wallet checkout*/

            Route::post('checkout/with/method/wallet', 'WalletController@checkout')->name('checkout.with.wallet');

            /** End */

            Route::get('/verifypayment', 'VerifyPaymentController@paymentReVerify');

            Route::get('/helpdesk', 'HelpDeskController@get')->name('hdesk')->middleware('switch_lang');

            Route::post('/helpdesk/store', 'HelpDeskController@store')->name('hdesk.store');

            Route::post('/cashfree/pay','CashfreeController@pay')->name('cashfree.pay');

            Route::post('payviacashfree/success', 'CashfreeController@success');

            Route::post('pay/via/omise', 'OmiseController@pay')->name('pay.via.omise');

            Route::post('/pay/via/rave', 'RavePaymentController@pay')->name('rave.pay');

            Route::get('/rave/callback', 'RavePaymentController@callback')->name('rave.callback');

            Route::post('/moli/pay/','MolliePaymentController@pay')->name('mollie.pay');

            Route::get('/moli/pay/callback','MolliePaymentController@callback')->name('mollie.callback');

            Route::post('pay/via/skrill', 'SkrillController@pay')->name('skrill.pay');

            Route::get('pay/via/skrill/success', 'SkrillController@success')->name('skrill.success');

            Route::get('/payhere/callback', 'PayhereController@callback');

            Route::get('/braintree/accesstoken', 'BrainTreeController@accesstoken')->name('bttoken');

            Route::post('/braintree/process', 'BrainTreeController@process')->name('pay.bt');

            Route::post('/payviapaytm', 'PaytmController@payProcess')->name('payviapaytm');

            Route::post('/paidviapaytmsuccess', 'PaytmController@paymentCallback');

            Route::post('/payviapaystack', 'PaystackController@pay')->name('pay.via.paystack');

            Route::get('/paystack/callback', 'PaystackController@callback')->name('paystack.callback');

            Route::post('rpay', 'PayViaRazorPayController@payment')->name('rpay');

            Route::get('/load/comments/on/post/{id}', 'BlogController@loadcommentsOneditpost')->name('load.edit.postcomments');

            Route::delete('/destroy/comment/{id}', 'BlogController@deletecomment')->name('comment.delete');

            Route::post('load/more/posts/comment', 'BlogCommentController@loadmore');

            Route::get('/myfailedtranscations', 'CheckoutController@getFailedTranscation')->name('failed.txn')->middleware('switch_lang');

            Route::get('/payment/process', 'BrainTreeController@process')->name('payment.process');

            Route::get('paidsuccess', 'InstamojoController@success');

            Route::get('payment/status', 'PayuController@status')->name('payupay.status');

            Route::post('payment', 'PayuController@payment')->name('payviapayu');

            Route::get('/check/localpickup/isApply', 'LocalpickupController@apply')->name('localpickup');

            Route::get('/back/localpickup/notapply', 'LocalpickupController@reset')->name('reset.localpickup');

            Route::post('/giftcharge/isApply', 'Web\CartController@applygiftcharge')->name('apply.giftcharge');

            Route::post('/giftcharge/reset', 'Web\CartController@resetgiftcharge')->name('reset.giftcharge');

            Route::post('/return/final/procceed/paytosuser/{id}', 'ReturnOrderController@paytouser')->name('final.process');

            Route::get('/return/product/process/{id}', 'ReturnController@returnWindow')->name('return.window')->middleware('switch_lang');

            Route::post('/return/product/processed/{id}', 'ReturnController@process')->name('return.process');

            Route::get('/mybank', 'UserBankController@index')->name('mybanklist')->middleware('switch_lang');

            Route::post('/mybank', 'UserBankController@store')->name('user.bank.add');

            Route::post('/mybank/edit/{id}', 'UserBankController@update')->name('user.bank.update');

            Route::delete('mybank/{id}', 'UserBankController@delete')->name('user.bank.delete');

            Route::post('/cod/{token}', 'CodController@payviacod')->name('cod.process');

            Route::post('/bankTransfer/{token}', 'BankTransferController@payProcess')->name('bank.transfer.process');

            Route::post('/reportproduct/{id}', 'ReportProductController@post')->name('rep.pro');

            Route::get('/manageaddress', 'AddressController@getaddressView')->name('get.address')->middleware('switch_lang');

            Route::get('/pincode/finder', 'AddressController@pincodefinder')->name('findpincode');

            Route::post('/store/user/address/', 'AddressController@store')->name('address.store');

            Route::post('/store/user/address2/', 'AddressController@store2')->name('address.store2');

            Route::post('/store/user/address3/', 'AddressController@store3')->name('address.store3');

            Route::post('/update/user/address/{id}', 'AddressController@update')->name('address.update');

            Route::delete('/update/user/address/{id}', 'AddressController@delete')->name('address.del');

            Route::post('/empty/cart', 'CartController@empty')->name('empty.cart');

            Route::get('/process/billingaddress', 'CheckoutController@getBillingView')->name('get.billing.view');

            Route::post('process/billingaddress', 'CheckoutController@chooseaddress')->name('choose.address');

            Route::get('/getaddress/default', 'AddressController@ajaxaddress');

            Route::get('/getaddress/list', 'AddressController@ajaxaddressList');

            Route::get('/view/order/{orderid}', 'OrderController@viewUserOrder')->name('user.view.order')->middleware('switch_lang');

            Route::get('/getmyinvoice/{id}', 'OrderController@getUserInvoice')->name('user.get.invoice');

            Route::post('/order/complete/cancel/{id}', 'FullOrderCancelController@cancelOrder')->name('full.order.cancel');

            Route::get('markasread/user', 'AdminController@user_read')->name('mark_read_user');

            Route::get('markasread/order', 'AdminController@order_read')->name('mark_read_order');

            Route::get('markasread/ticket', 'AdminController@ticket_read')->name('mark_tkt_order');

            Route::get('clearall', 'AdminController@all_read')->name('clearall');

            Route::get('usermarkreadsingle', 'AdminController@single')->name('mrk');

            Route::get('mytickets', 'HelpDeskController@userticket')->name('user_t')->middleware('switch_lang');

            Route::get('paypal', 'PaymentController@index');
            Route::post('paypal', 'PaymentController@payWithpaypal');
            Route::get('status', 'PaymentController@getPaymentStatus');

            Route::get('payment/success', 'CheckoutController@success');
            Route::get('payment/payu', 'CheckoutController@payumoney');

            Route::get('instamojo', 'InstamojoController@index')->name('payment');
            Route::post('instamojo', 'InstamojoController@payment')->name('payviainsta');
            Route::get('strip', 'StripController@index');
            Route::post('strip', 'StripController@stripayment')->name('paytostripe');

            /*Admin + Seller Common Usable Routes */

            Route::group(['middleware' => ['SellerAdminMix']], function () {

                /*Quick Update Routes*/

                Route::post('/admin/quickupdate/unit/{id}', 'QuickUpdateController@unitUpdate')->name('unit.quick.update');

                Route::post('/admin/quickupdate/user/{id}', 'QuickUpdateController@userUpdate')->name('user.quick.update');

                Route::post('/admin/quickupdate/store/{id}', 'QuickUpdateController@storeUpdate')->name('store.quick.update');

                Route::get('/admin/quickupdate/menu/{id}', 'QuickUpdateController@menuUpdate')->name('menu.quick.update');

                Route::post('/admin/quickupdate/product/{id}', 'QuickUpdateController@productUpdate')->name('product.quick.update');

                Route::post('/admin/quickupdate/category/{id}', 'QuickUpdateController@catUpdate')->name('cat.quick.update');

                Route::post('/admin/quickupdate/subcategory/{id}', 'QuickUpdateController@subUpdate')->name('sub.quick.update');

                Route::post('/admin/quickupdate/childcategory/{id}', 'QuickUpdateController@childUpdate')->name('child.quick.update');

                Route::post('/admin/quickupdate/brand/{id}', 'QuickUpdateController@brandUpdate')->name('brand.quick.update');

                Route::post('/admin/quickupdate/detail_status/{id}', 'QuickUpdateController@detailUpdate')->name('detail_status.quick.update');

                Route::post('/admin/quickupdate/detail_button/{id}', 'QuickUpdateController@detail_button_Update')->name('detail_button.quick.update');

                Route::post('/admin/quickupdate/review/{id}', 'QuickUpdateController@reviewUpdate')->name('review.quick.update');

                Route::post('/admin/quickupdate/coupon/{id}', 'QuickUpdateController@couponUpdate')->name('coupon.quick.update');

                Route::post('/admin/quickupdate/tax/{id}', 'QuickUpdateController@taxUpdate')->name('tax.quick.update');

                Route::post('/admin/quickupdate/taxclass/{id}', 'QuickUpdateController@taxclassUpdate')->name('taxclass.quick.update');

                Route::post('/admin/quickupdate/commission/{id}', 'QuickUpdateController@commissionUpdate')->name('commission.quick.update');

                Route::post('/admin/quickupdate/banks/{id}', 'QuickUpdateController@banksUpdate')->name('banks.quick.update');

                Route::post('/admin/quickupdate/slider/{id}', 'QuickUpdateController@sliderUpdate')->name('slider.quick.update');

                Route::post('/admin/quickupdate/faq/{id}', 'QuickUpdateController@faqUpdate')->name('faq.quick.update');

                Route::post('/admin/quickupdate/blog/{id}', 'QuickUpdateController@blogUpdate')->name('blog.quick.update');

                Route::post('/admin/quickupdate/page/{id}', 'QuickUpdateController@pageUpdate')->name('page.quick.update');

                Route::post('/admin/quickupdate/social/{id}', 'QuickUpdateController@socialUpdate')->name('social.quick.update');

                Route::post('/admin/quickupdate/hotdeal/{id}', 'QuickUpdateController@hotdealUpdate')->name('hot.quick.update');

                Route::get('/admin/quickupdate/adv/{id}', 'QuickUpdateController@advUpdate')->name('adv.quick.update');

                Route::post('/admin/quickupdate/clint/{id}', 'QuickUpdateController@clintUpdate')->name('clint.quick.update');

                Route::post('/admin/quickupdate/home/widget/{id}', 'QuickUpdateController@widgethomeUpdate')->name('widget.home.quick.update');

                Route::post('/admin/quickupdate/shop/widget/{id}', 'QuickUpdateController@widgetshopUpdate')->name('widget.shop.quick.update');

                Route::post('/admin/quickupdate/page/widget/{id}', 'QuickUpdateController@widgetpageUpdate')->name('widget.page.quick.update');

                Route::post('/admin/quickupdate/category/fea/{id}', 'QuickUpdateController@catfeaUpdate')->name('cat.featured.quick.update');

                Route::post('/admin/quickupdate/subcategory/fea/{id}', 'QuickUpdateController@subfeaUpdate')->name('sub.featured.quick.update');

                Route::post('/admin/quickupdate/childcategory/fea/{id}', 'QuickUpdateController@childfeaUpdate')->name('child.featured.quick.update');

                Route::post('/admin/quickupdate/product/fea/{id}', 'QuickUpdateController@productfeaUpdate')->name('product.featured.quick.update');

                Route::post('/admin/quickupdate/spa/status/{id}', 'QuickUpdateController@specialoffer')->name('spo.status.quick.update');

                Route::post('/admin/quickupdate/store/request/{id}', 'QuickUpdateController@acpstore')->name('store.acp.quick.update');

                Route::post('/admin/quickadd/category', 'QuickAddController@quickAddCat')->name('quick.cat.add');

                Route::post('/admin/quickadd/subcategory', 'QuickAddController@quickAddSub')->name('quick.sub.add');

                /** Quick Updates Routes end */

                Route::get('update/orderstatus/{id}', 'VenderOrderController@updateStatus');

                Route::delete('/delete/order/{id}', 'VenderOrderController@delete')->name('order.delete');

                Route::post('/additonal/price/detail', 'VenderProductController@additionalPrice')->name('add.price.product');

                Route::get('/admin/quick/get/order/detail', 'OrderController@QuickOrderDetails')->name('quickorderdtls');

                Route::post('/add/common/variant/{id}', 'AddProductVariantController@storeCommon')->name('add.common');

                Route::delete('/delete/common/variant/{id}', 'AddProductVariantController@delCommon')->name('del.common');

                Route::resource("admin/product_faq", "FaqProductController");

                Route::get('/track/payput/status/{batchid}', 'SellerPaymenyController@track')->name('payout.status');

                Route::get('/update/{id}/relatedsetting/product', 'ProductController@prorelsetting')->name('prorelsetting');

                Route::post('/store/list/product/{id}', 'ProductController@relatedProductStore')->name('rel.store');

                Route::post('/product/{id}/specs/', 'ProductController@storeSpecs')->name('pro.specs.store');

                Route::post('/product/{id}/update/specs', 'ProductController@updateSpecs')->name('pro.specs.update');

                Route::delete('/products/{id}/delete/specs', 'ProductController@deleteSpecs')->name('pro.specs.delete');

                Route::get('/admin/cod/{orderid}/orderpayconfirm', 'VenderOrderController@codorderconfirm')->name('cod.pay.confirm');

                Route::post('/update/cancel-single-order/status/{id}', 'FullOrderCancelController@singleOrderStatus')->name('single.can.order');

                Route::get('/delete/varimage1/{id}', 'DeleteImageController@deleteimg1');
                Route::get('/delete/varimage2/{id}', 'DeleteImageController@deleteimg2');
                Route::get('/delete/varimage3/{id}', 'DeleteImageController@deleteimg3');
                Route::get('/delete/varimage4/{id}', 'DeleteImageController@deleteimg4');
                Route::get('/delete/varimage5/{id}', 'DeleteImageController@deleteimg5');
                Route::get('/delete/varimage6/{id}', 'DeleteImageController@deleteimg6');
                Route::get('/setdef/var/image/{id}', 'DeleteImageController@setdef');

                Route::get('/track/refund/live/api/{id}', 'TrackRefundController@singleOrderRefundTrack');

                Route::get('/track/refund/fullorder/live/api/{id}', 'TrackRefundController@fullOrderRefundTrack');

                Route::get('/admin/update/read-at/cancel/order', 'TrackRefundController@readorder');

                Route::post('/updatelocalpickup/delivery/date/{id}', 'LocalpickupController@updateDelivery')->name('update.local.delivery');

                Route::get('/admin/update/read-at/cancel/fullorder', 'TrackRefundController@readfullorder');

                Route::post('/update/commonvar/{id}', 'AddProductVariantController@updatecommon')->name('common.update');

            });

            /*End*/

            /*Seller Routes start*/

            Route::group(['middleware' => ['is_verified','is_vendor']], function () {

                Route::prefix('seller')->group(function () {

                    Route::get("sellerdashboard", "VenderController@dashbord")->name('seller.dboard');

                    Route::get("subscriptions", "VenderController@subscriptions")->name('seller.my.subscriptions');

                    Route::get('categories', 'ShippingInfoController@getcategories')->name('seller.get.categories');

                    Route::get('subcategories', 'ShippingInfoController@getsubcategories')->name('seller.get.subcategories');

                    Route::get('childcategories', 'ShippingInfoController@getchildcategories')->name('seller.get.childcategories');

                    Route::get('available/shipping', 'ShippingInfoController@getinfo')->name('seller.shipping.info');

                    Route::get('payout/complete/print/{id}/payouts', 'SellerPayoutController@printSlip')->name('vender.print.slip');

                    Route::get('payout/completed/show/{id}/payout', 'SellerPayoutController@showCompletePayout')->name('vender.payout.show.complete');

                    Route::get('/payouts', 'SellerPayoutController@index')->name('seller.payout.index');

                    Route::get('/returnOrders/detail/{id}', 'SellerReturnController@detail')->name('seller.order.detail');

                    Route::get('return/orders', 'SellerReturnController@index')->name('seller.return.index');

                    Route::get('show/returnOrder/{id}', 'SellerReturnController@show')->name('seller.return.order.show');

                    Route::get('brands', 'SellerBrandController@index')->name('seller.brand.index');

                    Route::get('product/attributes', 'SellerProductAttributeController@index')->name('seller.product.attr');

                    Route::post('requestforbrand/store', 'SellerBrandController@requestStore')->name('request.brand.store');

                    //Route::post('/full/order/update/{id}', 'SellerCancelOrderController@updatefullcancelorder')->name('seller.full.cancel.order.update');

                    Route::get('/ord/cancelled', 'SellerCancelOrderController@index')->name('seller.canceled.orders');

                    Route::get('/setdef/using/ajax/{id}', 'SellerAddvariantController@quicksetdefault');

                    Route::post('product/bulk_delete', 'VenderProductController@bulk_delete')->name('seller.pro.bulk.delete');

                    Route::get('/product/{id}/allvariants', 'VenderProductController@allvariants')->name('seller.pro.vars.all');

                    Route::post('/add/common/variant/{id}', 'SellerVariantController@storeCommon')->name('seller.add.common');

                    Route::delete('/delete/common/variant/{id}', 'SellerVariantController@delCommon')->name('seller.del.common');

                    /*Product Add Variant Route*/
                    Route::get('product/addvariant/{id}', 'SellerVariantController@getPage')->name('seller.add.var');

                    Route::post('product/addvariant/{id}', 'SellerVariantController@store')->name('seller.add.str');

                    Route::DELETE('product/delete/variant/{id}', 'SellerVariantController@destroy')->name('seller.del.subvar');

                    Route::post('product/update/variant/{id}', 'SellerVariantController@update')->name('seller.updt.var2');
                    /*AJAX ROUTE*/

                    Route::get('/manage/stock/{id}', 'SellerAddvariantController@getIndex')->name('seller.manage.stock');

                    Route::post('manage/stock/{id}', 'SellerAddvariantController@post')->name('seller.manage.stock.post');

                    Route::get('get/productvalues', 'SellerVariantController@getProductValues');

                    Route::get('product/editvariant/{id}', 'SellerAddvariantController@edit')->name('seller.edit.var');

                    Route::post('product/editvariant/{id}', 'SellerAddvariantController@update')->name('seller.updt.var');

                    Route::delete('product/delete/var/{id}', 'SellerAddvariantController@delete')->name('seller.del.var');
                    /*END*/

                    Route::get('importproducts', 'VenderProductController@importPage')->name('seller.import.product');

                    Route::post('importproducts', 'VenderProductController@storeImportProducts')->name('seller.import.store');

                    Route::get('invoicesetting', 'VenderController@getInvoiceSetting')->name('vender.invoice.setting');

                    Route::post('invoicesetting', 'VenderController@createInvoiceSetting')->name('vender.invoice.sop');

                    Route::delete("store/delete/{id}", "VenderController@destroy")->name('req.for.delete.store');
                    Route::resource("store", "VenderController");
                    Route::get("orders", "VenderController@order");
                    Route::get("enable", "VenderController@enable");

                    Route::name('my.')->group(function () {
                        Route::resource("products", "VenderProductController");
                    });

                    Route::get("commission", "VenderController@commission")->name('seller.commission');
                    Route::get("myprofile", "VenderController@profile")->name('get.profile');
                    Route::post("myprofile", "VenderController@updateprofile")->name('seller.profile.update');
                    Route::get("cod", "CodController@showcashOn");
                    Route::put("seller/cod/{id}", "CodController@editupdateOn");
                    Route::get("cod/edit/{id}", "CodController@editcashOn");
                    Route::resource("shipping", "VenderShippingController");
                    Route::get("shipping_update", "ShippingController@shipping");
                    Route::get("shipping_updates", "VenderShippingController@shipping");
                    Route::resource("reletdProduct", "RealatedProductController");
                    Route::get("reletdProduct_setting", "RealatedProductController@setting_show");
                    Route::post("reletdProduct_update", "RealatedProductController@setting_update");
                    Route::post("recipt_show/", "SellerPaymenyController@vendor_recipt_show");
                    Route::post('update/ship', 'ShippingWeightController@update');

                    Route::get('view/order/{id}', 'VenderOrderController@viewOrder')->name('seller.view.order');

                    Route::get('print/order/{id}', 'VenderOrderController@printOrder')->name('seller.print.order');

                    Route::get('print/{orderid}/invoice/{id}', 'VenderOrderController@printInvoice')->name('seller.print.invoice');

                    Route::get('order/{orderid}/edit', 'VenderOrderController@editOrder')->name('seller.order.edit');

                });

            });

            /*Seller Routes END*/

        });

        /** End Authorized Routes */

    });

    /** Admin Routes Start Not included in maintenance*/

    Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admindesk.login.form')->middleware('switch_lang');

    Route::post('/admin/secure/login', 'GuestController@adminLogin')->name('admindesk.login');

    Route::group(['middleware' => ['isActive', 'IsInstalled', 'switch_lang', 'is_admin', 'auth']], function () {

        Route::get('/clear-cache',function(){
            \Artisan::call('cache:clear');
            \Artisan::call('view:cache');
            \Artisan::call('view:clear');

            notify()->success("Cache has been cleared !");

            return back();
        });

        Route::name('admindesk.affilate.')->prefix('/admin/affiliate')->group(function(){

            Route::get('/settings','AffilateController@settings')->name('settings');
            Route::post('/settings','AffilateController@update')->name('update');
            Route::get('/reports','AffilateController@reports')->name('dashboard');

        });

        Route::name('seller.subs.')->prefix('/admin/seller/subscription')->group(function(){
            
            Route::resource('plans','SellerSubscriptionController');
            Route::get('subscribers','SellerSubscriptionController@listofsubscribers')->name('listofsubs');
            Route::delete('subscription/{id}/delete','SellerSubscriptionController@deleteSubscription')->name('delete.subscription');

        });

        Route::get('/admin/addon-manger','AddOnManagerController@index')->name('addonmanger.index');

        Route::post('/admin/toggle/module','AddOnManagerController@toggle');

        Route::post('/admin/addon/install','AddOnManagerController@install')->name('addon.install');

        Route::post('/admin/addon/delete','AddOnManagerController@delete')->name('addon.delete');

        Route::get('/admin/reports/stock-report','ReportController@stockreport')->name('admindesk.stock.report');

        Route::get('/admin/reports/sales-report','ReportController@salesreport')->name('admindesk.sales.report');

        Route::get('/admin/reports/most-view-products-report','ReportController@mostviewproducts')->name('admindesk.report.mostviewed');

        Route::view('system-status','systemstatus')->name('systemstatus');

        Route::post('/save/twillo/settings','TwilloController@savesettings')->name('change.twilo.settings');

        Route::post('/save/amarpay/settings','KeyController@saveamarpaysettings')->name('change.amarpay.settings');

        Route::post('/change/msg/channel','TwilloController@changechannel')->name('change.channel');

        Route::get('/admin/push-notifications','PushNotificationsController@index')->name('admindesk.push.noti.settings');

        Route::post('/admin/one-signal/keys','PushNotificationsController@updateKeys')->name('admindesk.onesignal.keys');

        Route::post('/admin/push-notifications','PushNotificationsController@push')->name('admindesk.push.notif');
        
        Route::get('/admin/offer-popup','OfferPopUpController@getSettings')->name('offer.get.settings');

        Route::post('/admin/offer-popup','OfferPopUpController@updateSettings')->name('offer.update.settings');

        Route::post('/update-dump-path','BackupController@updatedumpPath')->name('dump.path.update');

        Route::get('/admin/sms/settings','Msg91Controller@getSettings')->name('sms.settings');

        Route::post('/admin/sms/settings','Msg91Controller@updateSettings')->name('sms.update.settings');

        Route::get('admin/manual-payment-settings','ManualPaymentGatewayController@getindex')->name('manual.payment.gateway');

        Route::post('admin/manual-payment-settings','ManualPaymentGatewayController@store')->name('manual.payment.gateway.store');

        Route::post('admin/manual-payment-settings-update/{id}','ManualPaymentGatewayController@update')->name('manual.payment.gateway.update');

        Route::post('admin/manual-payment-settings-delete/{id}','ManualPaymentGatewayController@delete')->name('manual.payment.gateway.delete');

        Route::get('visiter-data','AdminController@visitorData')->name('get.visitor.data');

        Route::get('/admin/import-demo',function(){
           return view('admindesk.demo');
        })->name('admindesk.import.demo');

        Route::post('/admin/import/import-demo',function(){

            if(env('DEMO_LOCK') == 1){
                notify()->error('This action is disabled in demo !');
                return back();
            }

            \Artisan::call('import:demo');
            notify()->success('Demo Imported successfully !');
            return back();
        });

        Route::post('/admin/reset-demo',function(){

            if(env('DEMO_LOCK') == 1){
                notify()->error('This action is disabled in demo !');
                return back();
            }

            \Artisan::call('demo:reset');

            notify()->success('Demo reset successfully !');
            return back();
        });

        Route::get('/admin/theme-settings','ThemeController@index')->name('admindesk.theme.index');

        Route::post('/admin/theme-settings/update','ThemeController@applytheme')->name('admindesk.theme.update');

        Route::post('/login/as/{userid}/', 'GuestController@adminLoginAs')->name('login.as');

        Route::get('admin/backups/','BackupController@get')->name('admindesk.backup.settings');

        Route::get('admin/download/{filename}','BackupController@download')->name('admindesk.backup.download');

        Route::get('admin/backups/process','BackupController@process')->name('admindesk.backup.process');

        Route::get('/sitemap', 'SiteMapController@sitemapGenerator');

        Route::get('/sitemap/download', 'SiteMapController@download');

        Route::post('admin/iyzico/settings/update', 'KeyController@iyzicoUpdate')->name('iyzico.settings.update');

        Route::post('admin/sslcommerze/settings/update', 'KeyController@sslcommerzeUpdate')->name('sslcommerze.settings.update');

        Route::post('admin/payhere/settings/update', 'KeyController@payhereUpdate')->name('payhere.settings.update');

        Route::get('/user/term/settings/', 'TermsController@userterms')->name('get.user.terms');

        Route::post('/user/term/settings/{key}', 'TermsController@postuserterms')->name('update.term.setting');

        Route::post('/ota/update/proccess', 'OtaUpdateController@update')->name('update.proccess');

        Route::view('image/conversion', 'ota.imageconversion');

        Route::post('image/conversion/proccess', 'UpdaterScriptController@convert');

        Route::get('admin/excel', 'ProductController@excel')->name('index');
        Route::post('admin/import', 'ProductController@import')->name('import');

        Route::get('/admin/mail-settings', 'Configcontroller@getset')->name('mail.getset');
        Route::post('admin/mail-settings', 'Configcontroller@changeMailEnvKeys')->name('mail.update');

        Route::post('admin/update/paypal/setting', 'KeyController@savePaypal')->name('paypal.setting.update');
        Route::post('admin/update/stripe/setting', 'KeyController@saveStripe')->name('stripe.setting.update');
        Route::post('admin/update/braintree/setting', 'KeyController@saveBraintree')->name('bt.setting.update');

        //All variant Link//
        Route::get('/product/{id}/allvariants', 'ProductController@allvariants')->name('pro.vars.all');

        Route::get('/user/terms/settings', 'TermsController@userterms')->name('get.user.term.settings');

        Route::post('/user/terms/settings', 'TermsController@postuserterms')->name('post.user.term.settings');

        Route::get('/user/seller-terms/settings', 'TermsController@sellerterms')->name('get.seller.term.settings');

        Route::post('/user/seller-terms/settings', 'TermsController@postsellerterms')->name('post.seller.term.settings');

        Route::get('admin/wallet/settings', 'WalletController@adminWalletSettings')->name('admindesk.wallet.settings');

        Route::get('admin/wallet/settings/update', 'WalletController@updateWalletSettings')->name('admindesk.update.wallet.settings');

        Route::get('admin/widget/settings', 'WidgetsettingController@getSetting')->name('widget.setting');
        
        Route::post('admin/whatsapp/update/settings','WhatsappSettingsController@update')->name('wp.setting.update');

        Route::get('/maintaince-mode', 'MaintainenceController@getview')->name('get.view.m.mode');

        Route::post('/store/maintaince-mode', 'MaintainenceController@post')->name('get.m.post');

        Route::get('getsecretkey', 'GenerateApiController@getkey')->name('get.api.key');

        Route::post('createkey', 'GenerateApiController@createKey')->name('apikey.create');

        //Route::post('/admin/gift/wallet/point/{id}', 'WalletController@giftPoint')->name('admindesk.gift.point');

        Route::get('/admin/payment/setting/', 'KeyController@paymentsettings')->name('payment.gateway.settings');

        Route::delete('menu/topmenu/bulk_delete_top_menu', 'MenuController@bulk_delete_top_menu')->name('bulk.delete.topmenu');

        Route::delete('menu/footermenu/bulk_delete_top_menu', 'MenuController@bulk_delete_footer_menu')->name('bulk.delete.fm');

        Route::post('footermenu/store', 'FooterMenuController@store')->name('footermenu.store');
        Route::post('footermenu/udpate/{id}', 'FooterMenuController@update')->name('footermenu.update');
        Route::delete('delete/footermenu/{id}', 'FooterMenuController@delete')->name('footermenu.delete');

        Route::post('/reposition/category/', 'CategoryController@reposition')->name('cat.repos');

        Route::post('admin/quick/confirm/fullorder/{orderid}', 'QuickConfirmOrderController@quickconfirmfullorder')->name('quick.pay.full.order');

        Route::post('/reposition/subcategory/', 'SubCategoryController@reposition')->name('subcat.repos');

        Route::post('/reposition/childcategory/', 'GrandcategoryController@reposition')->name('childcat.repos');

        Route::post('/post/api/paytmupdate', 'KeyController@updatePaytm')->name('post.paytm.setting');

        Route::post('/admin/razorpay/setting', 'KeyController@updaterazorpay')->name('post.rpay.setting');

        Route::get('/admin/pwa/setting', 'PWAController@index')->name('pwa.setting.index');

        Route::post('/admin/pwa/update/setting', 'PWAController@updatesetting')->name('pwa.setting.update');

        Route::post('/admin/pwa/update/icons/setting', 'PWAController@updateicons')->name('pwa.icons.update');

        Route::get('/admin/advertise/', 'AdvController@selectLayout')->name('select.layout');

        Route::get('/admin/importproduts', 'ProductController@importPage')->name('import.page');

        Route::get('/admin/language', 'LanguageController@index')->name('site.lang');

        Route::get('/admin/edit/{lang}/staticTranslations', 'LanguageController@editStaticTrans')->name('static.trans');

        Route::post('/admin/update/{lang}/staticTranslations/content', 'LanguageController@updateStaticTrans')->name('static.trans.update');

        Route::post('/admin/language/store/lang/', 'LanguageController@store')->name('site.lang.store');

        Route::post('/admin/language/update/lang/{id}', 'LanguageController@update')->name('site.lang.update');

        Route::delete('/admin/language/delete/lang/{id}', 'LanguageController@delete')->name('site.lang.delete');

        Route::post('paytoseller/{venderid}/{orderid}', 'SellerPaymenyController@payoutprocess')->name('seller.pay');

        Route::post('paytoseller/via/bank/{venderid}/{orderid}', 'SellerPaymenyController@payoutviabank')->name('payout.bank');

        Route::post('paytoseller/via/manual/{venderid}/{orderid}', 'SellerPaymenyController@manualPayout')->name('manual.seller.payout');

        Route::get('/enablepincodesystem', 'PinCodController@enablesystem')->name('enable.pincode.system');

        Route::get('/admin/frontCategorySlider', 'CategorySliderController@get')->name('front.slider');

        Route::post('/admin/frontCategorySlider', 'CategorySliderController@post')->name('front.slider.post');

        Route::get('/admin/returnOrders/detail/{id}', 'ReturnOrderController@detail')->name('return.order.detail');

        Route::get('/admin/returnOrders', 'ReturnOrderController@index')->name('return.order.index');

        Route::get('/admin/update/returnOrder/{id}', 'ReturnOrderController@show')->name('return.order.show');

        Route::get('admin/ord/canceled', 'OrderController@getCancelOrders')->name('admindesk.can.order');

        Route::get('/admin/all/pro/reported', 'ReportProductController@get')->name('get.rep.pro');

        Route::get('/admin/setdef/using/ajax/{id}', 'AddSubVariantController@quicksetdefault');

        Route::get('/admin/onload/subcat', 'MenuController@onloadchildpanel');

        Route::get('/manage/stock/{id}', 'AddSubVariantController@getIndex')->name('manage.stock');

        Route::post('manage/stock/{id}', 'AddSubVariantController@post')->name('manage.stock.post');

        /*Product Attribute Routes*/
        Route::get('admin/product/attr', 'ProductAttributeController@index')->name('attr.index');

        Route::get('admin/product/attr/create', 'ProductAttributeController@create')->name('attr.add');

        Route::post('admin/product/attr/create', 'ProductAttributeController@store')->name('opt.str');

        Route::get('admin/product/attr/edit/{id}', 'ProductAttributeController@edit')->name('opt.edit');

        Route::post('admin/product/attr/edit/{id}', 'ProductAttributeController@update')->name('opt.update');

        Route::resource("admin/multiCurrency", "MultiCurrencyController");
        Route::get("admin/add_curr", "MultiCurrencyController@add_currency_ajax");
        Route::get("admin/currency_codeShow", "MultiCurrencyController@show");
        Route::get("admin/enable_multicurrency", "MultiCurrencyController@auto_detect_location");
        Route::get("admin/setDefault", "MultiCurrencyController@setDefault");
        Route::get("admin/editCurrency", "MultiCurrencyController@editCurrency");
        Route::get("admin/auto_change", "MultiCurrencyController@auto_change");
        Route::get("admin/auto_detect_location", "MultiCurrencyController@auto_detect_location");
        Route::post("/admin/auto_update_currency", "MultiCurrencyController@auto_update_currency")->name('auto.update.rates');
        Route::get("admin/deleteCurrency/{id}", "MultiCurrencyController@destroy");
        Route::post("admin/location", "MultiCurrencyController@addLocation");
        Route::get("admin/editlocation/", "MultiCurrencyController@editLocation");
        Route::get("admin/deleteLocation/", "MultiCurrencyController@deleteLocation");
        Route::get("admin/checkOutUpdate/", "MultiCurrencyController@checkOutUpdate");
        Route::get("admin/defaul_check_checkout/", "MultiCurrencyController@defaul_check_checkout");
        /*End*/

        /*Product Values*/
        Route::get('admin/product/manage/values/{id}', 'ProductValueController@get')->name('pro.val');

        Route::post('admin/product/manage/values/store/{id}', 'ProductValueController@store')->name('pro.val.store');

        Route::get('admin/product/manage/values/update/{id}/{attr_id}', 'ProductValueController@update')->name('pro.val.update');
        /*End*/

        /*Product Add Variant Route*/
        Route::get('admin/product/addvariant/{id}', 'AddProductVariantController@getPage')->name('add.var');

        Route::post('admin/product/addvariant/{id}', 'AddProductVariantController@store')->name('add.str');

        Route::delete('admin/product/delete/variant/{id}', 'AddProductVariantController@destroy')->name('del.subvar');

        Route::post('admin/product/update/variant/{id}', 'AddProductVariantController@update')->name('updt.var2');
        /*AJAX ROUTE*/

        Route::get('admin/get/productvalues', 'AddProductVariantController@getProductValues');

        Route::get('admin/product/editvariant/{id}', 'AddSubVariantController@edit')->name('edit.var');

        Route::post('admin/product/editvariant/{id}', 'AddSubVariantController@update')->name('updt.var');

        Route::delete('admin/product/delete/var/{id}', 'AddSubVariantController@delete')->name('del.var');
        /*END*/

        Route::post('admin/product/bulk_delete', 'ProductController@bulk_delete')->name('pro.bulk.delete');
        Route::post('admin/update/instamojo/settings', 'KeyController@instamojoupdate')->name('instamojo.update');
        Route::post('admin/update/payu/settings', 'KeyController@payuupdate')->name('store.payu.settings');
        Route::post('admin/update/paystack/settings', 'KeyController@paystackUpdate')->name('store.paystackupdate.settings');

        Route::post('admin/update/cashfree/settings','KeyController@updateCashfree')->name('cashfree.settings');
        Route::post('admin/update/skrill/settings','KeyController@updateSkrill')->name('skrill.settings');
        Route::post('admin/update/omise/settings','KeyController@updateOmise')->name('omise.settings');
        Route::post('admin/update/moli/settings','KeyController@updateMoli')->name('moli.settings');

        Route::post('admin/update/rave/settings','KeyController@updateRave')->name('rave.settings');

        Route::resource("admin/users", "UserController");
        Route::resource("admin/category", "CategoryController");
        Route::resource("admin/grandcategory", "GrandcategoryController");
        Route::resource("admin/subcategory", "SubCategoryController");
        Route::resource("admin/country", "CountryController");
        Route::resource("admin/state", "StateController");
        Route::resource("admin/city", "CityController");
        Route::resource("admin/pincode", "PinCodController");
        Route::get("myadmin", "AdminController@index")->name('admindesk.main');
        Route::get("admin/appliedform", "UserController@appliedform")->name('get.store.request');
        Route::get('admin/social-login-settings', 'Configcontroller@socialget')->name('gen.set');
        Route::resource('admin/invoice', 'InvoiceController');

        Route::post('admin/social/login/settings/update/{service}', 'Configcontroller@socialLoginUpdate')->name('social.login.service.update');

        Route::post('setting/sociallogin/fb', 'Configcontroller@slfb')->name('sl.fb');
        Route::post('setting/sociallogin/gl', 'Configcontroller@slgl')->name('sl.gl');
        Route::post('setting/sociallogin/gitlab', 'Configcontroller@gitlabupdate')->name('gitlab.update');

        Route::get('/admin/paytoseller/{id}', 'SellerPaymenyController@show')->name('seller.payfororder');

        Route::get("admin/icon", "AdminController@icon");
        Route::resource("admin/stores", "StoreController");
        Route::resource("admin/brand", "BrandController");
        Route::get('admin/requested-brands', 'BrandController@requestedbrands')->name('requestedbrands.admindesk');
        Route::resource("admin/tax", "TaxController");
        Route::resource("admin/tax_class", "TaxClassController");
        Route::get("admin/taxclassAdd", "TaxClassController@addRow");
        Route::get("admin/taxclassUpdate", "TaxClassController@update");
        Route::resource("admin/coupan", "CoupanController");
        Route::resource("admin/commission", "CommissionController");
        Route::resource("admin/commission_setting", "CommissionSettingController");
        Route::get("admin/sellerpayouts", "SellerPaymenyController@index")->name('seller.payouts.index');
        Route::get('admin/completed/payouts', 'SellerPaymenyController@complete')->name('seller.payout.complete');
        Route::get('admin/payout/complete/print/{id}/payouts', 'SellerPaymenyController@printSlip')->name('seller.print.slip');
        Route::get('admin/payout/completed/show/{id}/payout', 'SellerPaymenyController@showCompletePayout')->name('seller.payout.show.complete');

        Route::post("admin/recipt_show/", "SellerPaymenyController@recipt_show");
        Route::get("admin/subcat", "MenuController@upload_info");
        Route::resource("admin/shipping", "ShippingController");
        Route::get('/admin/shipping-price-weight', 'ShippingWeightController@get')->name('get.wt');
        Route::post('admin/shipping-price-weight/update', 'ShippingWeightController@update')->name('update.ship.wt');
        Route::resource("admin/order", "OrderController");
        Route::get('admin/pending/order', 'OrderController@pendingorder')->name('admindesk.pending.orders');
        Route::delete('order/bulkdelete', 'OrderController@bulkdelete')->name('order.bulk.delete');

        Route::get('admin/order/view/{id}', 'OrderController@show')->name('show.order');
        Route::get('/order/print/{id}', 'OrderController@printOrder')->name('order.print');
        Route::get('/order/{orderid}/invoice/{id}', 'OrderController@printInvoice')->name('print.invoice');
        Route::get('/admin/order/edit/{orderid}/', 'OrderController@editOrder')->name('admindesk.order.edit');

        Route::get("order/pending/", "OrderController@pending");
        Route::get("order/deliverd", "OrderController@deliverd");
        Route::resource("admin/slider", "SliderController");
        Route::resource("admin/faq", "FaqController");
        Route::resource("admin/cod", "CodController");

        Route::get("admin/product_faq/create/{id}", "FaqProductController@create");
        Route::resource('admin/return-policy/', 'ReturnProductController');
        Route::get('admin/return_policy/edit/{id}', 'ReturnProductController@edit');
        Route::PUT('admin/return_policy/update/{id}', 'ReturnProductController@update');
        Route::get("pincode-add", "PinCodController@pincode_add");
        Route::get("admin/available-destination", "PinCodController@show_destination");
        Route::get("admin/destination", "PinCodController@destination")->name('admindesk.desti');

        Route::get('admin/destination/listbycountry/{country}/pincode', 'PinCodController@getDestinationdata')->name('country.list.pincode');
        /** Custom CSS and JS */
        Route::get('/admin/custom-style-settings', 'CustomStyleController@addStyle')->name('customstyle');
        Route::post('/admin/custom-style-settings/addcss', 'CustomStyleController@storeCSS')->name('css.store');
        Route::post('/admin/custom-style-settings/addjs', 'CustomStyleController@storeJS')->name('js.store');
        /** End */
        Route::resource('admin/abuse/', 'AbusedController');
        Route::get('abuse/', 'AbusedController@show');

        Route::get('admin/tickets', 'HelpDeskController@viewbyadmin')->name('tickets.admindesk');

        Route::get('admin/ticket/{id}', 'HelpDeskController@show')->name('ticket.show');

        Route::get('admin/update/ticket/{id}', 'HelpDeskController@updateTicket');

        Route::post('/admin/replay/ticket/{id}', 'HelpDeskController@replay')->name('ticket.replay');

        Route::get('admin/return_policy/destroy/{id}', 'ReturnProductController@destroy');
        Route::get('admin/return_products_show/edit/{id}', 'ReturnProductController@edit_return_product');
        Route::put('admin/return_products_show/edit/{id}', 'ReturnProductController@update_return_product');
        Route::resource("admin/menu", "MenuController");
        Route::resource("admin/page", "PageController");
        Route::resource("admin/genral", "GenralController");
        Route::resource("admin/review", "ReviewController");
        Route::get("admin/review_approval", "ReviewController@review_approval")->name('r.ap');
        Route::resource("admin/seo", "SeoController");
        Route::resource("admin/social", "SocialController");
        Route::resource("admin/unit", "UnitController");
        Route::get('admin/unit/{id}/values', 'UnitController@getValues')->name('unit.values');
        Route::post('admin/unit/{id}/values', 'UnitController@storeValue')->name('store.val.unit');
        Route::put('admin/unit/edit/{id}/value', 'UnitController@editValue')->name('edit.val.unit');
        Route::delete('admin/units/delete/{id}', 'UnitController@unitvaldelete')->name('del.unit.val');

        Route::resource("admin/widget", "WidgetsettingController");
        Route::resource("admin/zone", "ZoneController");
        Route::resource("admin/testimonial", "TestimonialController");
        Route::resource("admin/special", "SpecialOfferController");
        Route::get("admin/sp_offer_widget", "SpecialOfferController@show_widget")->name('sp.offer.widget');
        Route::put("admin/sp_offer_widget", "SpecialOfferController@update_widget");
        Route::resource("admin/hotdeal", "HotdealController");
        Route::get("admin/reletd_Product/{id}", "RealatedProductController@create");
        Route::get("admin/product_image/", "ProductController@show_all_pro_image");
        Route::get("admin/product_image/delete/{id}", "ProductController@pro_delete");
        Route::resource("admin/reletdProduct", "RealatedProductController");
        Route::get("admin/reletdProduct_setting", "RealatedProductController@setting_show");
        Route::post("admin/reletdProduct_update", "RealatedProductController@setting_update");
        Route::resource("admin/products", "ProductController");
        Route::resource("admin/adv", "AdvController");
        Route::get("admin/shipping_update", "ShippingController@shipping");

        Route::post('/update/cancel-full-order/status/{id}', 'FullOrderCancelController@fullOrderStatus')->name('full.can.order');

        Route::get("admin/caty", "ProductController@gcat");
        Route::post("admin/images", "ProductController@images");
        Route::post('admin/edit_images/{id}', 'ProductController@edit_images');

        Route::resource('admin/bank_details', 'BankDetailController');
        Route::resource('admin/blog', 'BlogController');
        Route::resource('admin/blog_comment', 'BlogController');
        Route::resource('admin/footer', 'FooterController');
        Route::resource('admin/widget_footer', 'WidgetFooterController');
        Route::resource('admin/NewProCat', 'FrontCatController');

        Route::get("admin/order_print/{id}", "AdminController@order_print");

        Route::resource('admin/detailadvertise', 'DetailAdsController');

        Route::get("admin/dashbord-setting", "DashboardController@dashbordsetting")->name('admindesk.dash');
        Route::post("admin/dashbord-setting/{id}", "DashboardController@dashbordsettingu")->name('admindesk.dash.update');

        Route::post('admin/dashbord-setting/fb/{id}', 'DashboardController@fbSetting')->name('fb.update');
        Route::post('admin/dashbord-setting/tw/{id}', 'DashboardController@twSetting')->name('tw.update');
        Route::post('admin/dashbord-setting/ins/{id}', 'DashboardController@insSetting')->name('ins.update');

    });

    /** Admin Routes End */

});
