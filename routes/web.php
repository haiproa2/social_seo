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
Route::get('dang-xuat', ['as' => 'auth.getLogout', 'uses' => 'Auth\LoginController@logout']);
// Registration Routes...
Route::get('dang-ky', ['as' => 'auth.getRegister', 'uses' => 'Auth\LoginController@showRegistrationForm']);
Route::post('dang-ky', ['as' => 'auth.postRegister', 'uses' => 'Auth\LoginController@register']);
// Password Reset Routes...
Route::get('quen-mat-khau', ['as' => 'auth.getFormForget', 'uses' => 'Auth\LoginController@showLinkRequestForm']);
Route::post('quen-mat-khau', ['as' => 'auth.postFormForget', 'uses' => 'Auth\LoginController@sendResetLinkEmail']);
Route::get('doi-mat-khau/{token}', ['as' => 'auth.getRequest', 'uses' => 'Auth\LoginController@showResetForm']);
Route::post('doi-mat-khau', ['as' => 'auth.postRequest', 'uses' => 'Auth\LoginController@reset']);

Route::get('/home', 'HomeController@index')->name('home');
