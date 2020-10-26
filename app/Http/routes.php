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
Route::get('/update_pro', 'proController@update_pro');
Route::get('/update_pro_inteos', 'proController@update_pro_inteos');
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

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
