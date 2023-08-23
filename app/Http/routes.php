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


// Import 
Route::get('/import', 'importController@index');
Route::post('postImportPro', 'importController@postImportPro');
Route::post('postImportPlo', 'importController@postImportPlo');
Route::post('portImportSkedaStatus', 'importController@portImportSkedaStatus');
Route::post('portImportNumberOfLines', 'importController@portImportNumberOfLines');

// Import SAP
Route::get('/import_sap', 'import_sapController@index');
Route::post('postImport_mb51', 'import_sapController@postImport_mb51');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
