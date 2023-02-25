<?php
/**
 * Created by PhpStorm.
 * User: Fire
 * Date: 10/20/2017
 * Time: 4:59 PM
 */

Route::group(['prefix'=>'system/module'],function(){
    Route::resource('branch_transaction','BranchTransactionCrud',['except'=>['create','edit','show']]);
    Route::any('search_branch_transaction','BranchTransactionCrud@search_branch_transaction');
});