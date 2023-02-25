<?php

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

use App\Events\TaskEvent;

Route::get('/', 'AuthController@index');
Route::get('admin', 'Admin@index');
Route::post('/login','AuthController@login');
Route::get('/logout','AuthController@logout');

Route::get('event',function(){
   event(new TaskEvent('Hey how are you????'));
});

Route::get('get_contact_person','ClientCrud@get_contact_person');
Route::get('get_contact_person_by_client/{client_id}','DealsController@get_contact_person_by_client');
Route::get('get_contact_person_details/{id}','ClientCrud@get_contact_person_details');
Route::get('delete_contact_person/{id}','ClientCrud@delete_contact_person');
Route::get('get_clients','ClientCrud@get_clients');
Route::get('download_client','ClientCrud@download_client');
Route::get('check_existing_client','ClientCrud@check_existing_client');
Route::group(['prefix'=>'module'],function(){

    Route::any('client/search','ClientCrud@search');
    Route::any('client/table_action','ClientCrud@table_action');
    Route::get('client/collection','ClientCrud@collection');
    Route::any('client/search_invoice','ClientCrud@search_invoice');
    Route::get('client/contact_person_list','ClientCrud@contact_person_list');
    Route::get('client/edit_contact_person/{id}','ClientCrud@edit_contact_person');
    Route::get('client/contact_person_details/{id}','ClientCrud@contact_person_details');
    Route::patch('client/update_contact_person/{id}','ClientCrud@update_contact_person');
    Route::any('client/search_contact_person','ClientCrud@search_contact_person');
    Route::get('client/activity/{client_id}/{activity_type}','ClientCrud@client_activity');
    Route::resource('client','ClientCrud');

    Route::any('executive/search_call_history','ExecutiveCrud@search_call_history');
    Route::resource('executive','ExecutiveCrud');

    Route::get('deal/activity/{deal_id}/{activity_type}','DealsController@deal_activity');
    Route::any('deals/search','DealsController@search');
    Route::resource('deals','DealsController');

    Route::get('get_link_with_suggestion/{linked_with}','ActivityController@get_link_with_suggestion');
    Route::get('get_details_of_linked_with/{linked_with}/{id}','ActivityController@get_details_of_linked_with');

    Route::any('activity/search','ActivityController@search');
    Route::resource('activity','ActivityController');

    Route::any('campaign/search','CampaignController@search');
    Route::get('campaign/creative/{creative_id}','CampaignController@creative_report');
    Route::get('campaign/creative_preview/{creative_id}','CampaignController@creative_preview');
    Route::resource('campaign','CampaignController');


    Route::get('lead','LeadController@index');
    Route::get('lead/create','LeadController@create');
    Route::get('lead/activity_details/{lead_id}','LeadController@activity_details');
    Route::post('lead/store','LeadController@store');

    Route::any('calling_queue/search','CallingQueue@search');
    Route::post('calling_queue/create_from_follow_up_queue','CallingQueue@create_from_follow_up_queue');
    Route::post('calling_queue/search_follow_up','CallingQueue@search_follow_up');
    Route::get('calling_queue/follow_up','CallingQueue@get_follow_up');
    Route::resource('calling_queue','CallingQueue');

});

Route::get('send_daily_activity','Admin@send_daily_activity');
Route::get('send_daily_summary','Admin@send_daily_summary');
Route::get('client_wise_summary','Admin@client_wise_summary');

Route::get('vivo_campaign','LiveStatsController@vivo_campaign');




