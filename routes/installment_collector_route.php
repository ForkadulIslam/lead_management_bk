<?php
/**
 * Created by PhpStorm.
 * User: Fire
 * Date: 10/20/2017
 * Time: 4:59 PM
 */

Route::group(['prefix'=>'system/module'],function(){
    Route::resource('installment_collector','InstallmentCollector');

    Route::get('collector_payment_report','CollectorPaymentCrud@collector_payment_report');
    Route::post('post_collector_payment_report','CollectorPaymentCrud@post_collector_payment_report');
    Route::resource('collector_payment','CollectorPaymentCrud');
});