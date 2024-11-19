<?php

use Illuminate\Support\Facades\Route;

Route::name('payments.')->prefix('payments')->namespace('Payments')->group(function () {
    Route::name('manual.')->prefix('manual')->group(function () {
        Route::post('bankwire', 'BankwireController@submit')->name('bankwire');
    });
    Route::name('webhooks.')->prefix('webhooks')->group(function () {
        Route::post('paypal', 'PaypalController@webhook')->name('paypal');
        Route::post('stripe', 'StripeController@webhook')->name('stripe');
        Route::post('mollie', 'MollieController@webhook')->name('mollie');
        Route::post('coinbase', 'CoinbaseController@webhook')->name('coinbase');
        Route::post('coingate', 'CoingateController@webhook')->name('coingate');
        Route::post('flutterwave', 'FlutterwaveController@webhook')->name('flutterwave');
        Route::post('paystack', 'PaystackController@webhook')->name('paystack');
        Route::post('razorpay', 'RazorpayController@webhook')->name('razorpay');
        Route::post('midtrans', 'MidtransController@webhook')->name('midtrans');
        Route::post('xendit', 'XenditController@webhook')->name('xendit');
        Route::post('iyzico', 'IyzicoController@webhook')->name('iyzico');
        Route::post('nowpayments', 'NowpaymentsController@webhook')->name('nowpayments');
        Route::post('uddoktapay', 'UddoktapayController@webhook')->name('uddoktapay');
        Route::post('mercadopago', 'MercadopagoController@webhook')->name('mercadopago');
        Route::post('sellix', 'SellixController@webhook')->name('sellix');
        Route::post('paddle', 'PaddleController@webhook')->name('paddle');
        Route::post('yookassa', 'YookassaController@webhook')->name('yookassa');
    });
    Route::name('ipn.')->prefix('ipn')->group(function () {
        Route::get('paypal', 'PaypalController@ipn')->name('paypal');
        Route::get('stripe', 'StripeController@ipn')->name('stripe');
        Route::get('mollie', 'MollieController@ipn')->name('mollie');
        Route::get('coinbase', 'CoinbaseController@ipn')->name('coinbase');
        Route::get('coingate', 'CoingateController@ipn')->name('coingate');
        Route::get('flutterwave', 'FlutterwaveController@ipn')->name('flutterwave');
        Route::post('paystack', 'PaystackController@ipn')->name('paystack');
        Route::post('razorpay', 'RazorpayController@ipn')->name('razorpay');
        Route::get('midtrans', 'MidtransController@ipn')->name('midtrans');
        Route::get('xendit', 'XenditController@ipn')->name('xendit');
        Route::post('iyzico', 'IyzicoController@ipn')->name('iyzico');
        Route::get('nowpayments', 'NowpaymentsController@ipn')->name('nowpayments');
        Route::get('uddoktapay', 'UddoktapayController@ipn')->name('uddoktapay');
        Route::get('mercadopago', 'MercadopagoController@ipn')->name('mercadopago');
        Route::get('sellix', 'SellixController@ipn')->name('sellix');
        Route::get('paddle', 'PaddleController@ipn')->name('paddle');
        Route::get('yookassa', 'YookassaController@ipn')->name('yookassa');
    });
});