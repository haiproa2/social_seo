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

Route::get('/', function () {
    return view('welcome');
})->name('fontend.index');

// Auth::routes();
Route::get('dang-nhap', ['as' => 'auth.getLogin', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('dang-nhap', ['as' => 'auth.postLogin', 'uses' => 'Auth\LoginController@login']);
Route::get('dang-xuat', ['as' => 'auth.logout', 'uses' => 'Auth\LoginController@logout']);
// Registration Routes...
Route::get('dang-ky', ['as' => 'auth.getRegister', 'uses' => 'Auth\LoginController@showRegistrationForm']);
Route::post('dang-ky', ['as' => 'auth.postRegister', 'uses' => 'Auth\LoginController@register']);
// Password Reset Routes...
Route::get('quen-mat-khau', ['as' => 'auth.getFormForget', 'uses' => 'Auth\LoginController@showLinkRequestForm']);
Route::post('quen-mat-khau', ['as' => 'auth.postFormForget', 'uses' => 'Auth\LoginController@sendResetLinkEmail']);
Route::get('doi-mat-khau/{token}', ['as' => 'auth.getRequest', 'uses' => 'Auth\LoginController@showResetForm']);
Route::post('doi-mat-khau', ['as' => 'auth.postRequest', 'uses' => 'Auth\LoginController@reset']);

Route::group(['prefix' => 'control', 'middleware' => 'auth'], function(){
	Route::get('/', ['as' => 'backend.index', 'uses' => 'Admin\DashboardController@index']);

	Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
		Route::get('/', ['as' => 'backend.user', 'uses' => 'Admin\UserController@index']);
		Route::post('/', ['as' => 'backend.user.saveDetail', 'uses' => 'Admin\UserController@saveDetail']);
		Route::get('/list', ['as' => 'backend.user.list', 'uses' => 'Admin\UserController@listUsers']);
		Route::post('/list', ['as' => 'backend.user.updatePosition', 'uses' => 'Admin\UserController@updatePosition']);
	});
});

Route::get('/home', 'HomeController@index')->name('home');
