<?php
/**
 * Created by PhpStorm.
 * User: Fire
 * Date: 10/20/2017
 * Time: 4:59 PM
 */

Route::group(['prefix'=>'system/module'],function(){
    Route::resource('other_finance_receive','OtherFinanceReceiveCrud',['except'=>['create','edit','show']]);
    Route::resource('other_finance_payment','OtherFinancePaymentCrud',['except'=>['create','edit','show']]);
    Route::any('search_finance_payment','OtherFinancePaymentCrud@search_finance_payment');
    Route::any('search_finance_receive','OtherFinanceReceiveCrud@search_finance_receive');
});