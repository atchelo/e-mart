<?php

use App\Http\Controllers\Subs\PaymentController;
use Illuminate\Support\Facades\Route;

Route::name('pay.subscription.')->prefix('/pay/for/subscription')->group(function(){

    Route::post('paytm',[PaymentController::class,'paytm'])->name('paytm');
    Route::post('paytm/success',[PaymentController::class,'paytmsuccess'])->name('paytm.success');

    Route::post('razorpay',[PaymentController::class,'razorpay'])->name('razorpay');

    Route::post('paypal',[PaymentController::class,'paypal'])->name('paypal');
    Route::get('paypal/success',[PaymentController::class,'paypalSuccess'])->name('paypal.success');

    Route::post('stripe',[PaymentController::class,'stripe'])->name('stripe');
});