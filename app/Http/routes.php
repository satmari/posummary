<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', 'WelcomeController@index');

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
	
// PRO table
Route::get('/pro', 'proController@index');
Route::get('/pro_all', 'proController@index_all');
Route::get('/update_pro', 'proController@update_pro');
Route::get('/update_pro_posum', 'proController@update_pro_posum');

Route::get('/update_pro_inteos', 'proController@update_pro_inteos');
Route::get('/update_pro_from_inteos', 'proController@update_pro_from_inteos');
Route::get('/update_destination', 'proController@update_destination');



Route::get('/pro/edit/{id}', 'proController@edit');
Route::post('/edit_save_pro/{id}', 'proController@edit_save');
Route::get('/pro/conf/{id}', 'proController@conf');
Route::get('/pro/strip/{id}', 'proController@strip');
Route::get('/pro/coois/{id}', 'proController@coois');

Route::get('/table', 'proController@table');

//PLO table
Route::get('/plo', 'ploController@index');
Route::get('/update_plo', 'ploController@update_plo');
Route::get('/plo/edit/{id}', 'ploController@edit');
Route::post('/edit_save_plo/{id}', 'ploController@edit_save');

// Daily Plan

Route::get('/daily_plan', 'daily_planController@index');
Route::get('/daily_plan_all', 'daily_planController@index_all');
Route::get('/import_daily_plan', 'daily_planController@import_daily_plan');
Route::post('date_daily_plan', 'daily_planController@date_daily_plan');

// MIS accounting

Route::get('margin_analysis', 'margin_analysisController@index');
Route::post('margin_analysis_post', 'margin_analysisController@margin_analysis_post');
Route::post('post_margin_analysis', 'importController@post_margin_analysis');

Route::post('pro_open_closed_post', 'margin_analysisController@pro_open_closed_post');
Route::post('post_pro_open_closed', 'importController@post_pro_open_closed');

Route::get('plm_costing', 'margin_analysisController@plm_costing');
Route::post('post_plm_costing', 'importController@post_plm_costing');

// Future Orders
Route::get('future_orders', 'future_orderController@index');
Route::post('future_order_1', 'future_orderController@future_order_1');
Route::post('portImportfuture_orders', 'importController@portImportfuture_orders');
Route::get('future_order_status', 'future_orderController@future_order_status');
Route::post('future_order_2', 'future_orderController@future_order_2');
Route::get('future_order_update', 'future_orderController@future_order_update');
Route::post('portUpdatefuture_orders', 'importController@portUpdatefuture_orders');


// // BOM Cons
// Route::get('bom_cons', 'margin_analysisController@bom_cons');
// Route::post('bom_cons_post', 'importController@bom_cons_post');

// // Bom cons ratio
// Route::get('bom_cons_ratio', 'margin_analysisController@bom_cons_ratio');
// Route::post('bom_cons_ratio_post', 'importController@bom_cons_ratio_post');


// Import 
Route::get('/import', 'importController@index');
Route::post('postImportPro', 'importController@postImportPro');
Route::post('postImportPlo', 'importController@postImportPlo');
Route::post('portImportSkedaStatus', 'importController@portImportSkedaStatus');
Route::post('portImportNumberOfLines', 'importController@portImportNumberOfLines');
Route::post('portImportdaily_plan', 'importController@portImportdaily_plan');

// Import SAP
Route::get('/import_sap', 'import_sapController@index');
Route::post('postImport_mb51', 'import_sapController@postImport_mb51');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
