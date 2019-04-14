<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//require $_SERVER['DOCUMENT_ROOT'].'/public/define.php';

Route::get('/','Auth\AuthController@index');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
Route::get('page/{page}', 'PageController@view');
Route::get('media/{type}/{id}', 'MediaController@show');
Route::get('image/{id}/{year}/{month}/{day}/{slug}', [
	'as' 		=> 'images.show',
	'uses' 	=> 'ImagesController@show'
]);
Route::get('image/{id}', [
	'as' 		=> 'images.showById',
	'uses' 	=> 'ImagesController@showById'
]);