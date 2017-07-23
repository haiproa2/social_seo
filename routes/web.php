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

	Route::post('/delete-image', ['as' => 'backend.ajax.deleteImage', 'uses' => 'AdminController@ajaxDeleteImage']);

	Route::group(['prefix' => 'permission', 'middleware' => 'ability:root,v_permission'], function(){
		Route::get('/', ['as' => 'backend.permission', 'uses' => 'Admin\PermissionController@index']);
		Route::get('/create', ['as' => 'backend.permission.create', 'uses' => 'Admin\PermissionController@create', 'middleware'=>'ability:root,c_permission']);
		Route::post('/create', ['as' => 'backend.permission.store', 'uses' => 'Admin\PermissionController@store', 'middleware'=>'ability:root,c_permission']);
		Route::get('{id}', ['as' => 'backend.permission.view', 'uses' => 'Admin\PermissionController@view']);
		Route::get('{id}/edit', ['as' => 'backend.permission.edit', 'uses' => 'Admin\PermissionController@edit', 'middleware'=>'ability:root,u_permission']);
		Route::post('{id}/edit', ['as' => 'backend.permission.update', 'uses' => 'Admin\PermissionController@update', 'middleware'=>'ability:root,u_permission']);
		Route::get('{id}/delete', ['as'=>'backend.permission.delete', 'uses'=>'Admin\PermissionController@destroy', 'middleware'=>'ability:root,d_permission']);
		Route::get('deletes/{listid}', ['as'=>'backend.permission.deletes', 'uses'=>'Admin\PermissionController@destroy', 'middleware'=>'ability:root,d_permission']);
	});
	Route::group(['prefix' => 'role', 'middleware' => 'ability:root|admin,v_role'], function(){
		Route::get('/', ['as' => 'backend.role', 'uses' => 'Admin\RoleController@index']);
		Route::get('/create', ['as' => 'backend.role.create', 'uses' => 'Admin\RoleController@create', 'middleware'=>'ability:root|admin,c_role']);
		Route::post('/create', ['as' => 'backend.role.store', 'uses' => 'Admin\RoleController@store', 'middleware'=>'ability:root|admin,c_role']);
		Route::get('{id}', ['as' => 'backend.role.view', 'uses' => 'Admin\RoleController@view']);
		Route::get('{id}/edit', ['as' => 'backend.role.edit', 'uses' => 'Admin\RoleController@edit', 'middleware'=>'ability:root|admin,u_role']);
		Route::post('{id}/edit', ['as' => 'backend.role.update', 'uses' => 'Admin\RoleController@update', 'middleware'=>'ability:root|admin,u_role']);
		Route::get('{id}/delete', ['as'=>'backend.role.delete', 'uses'=>'Admin\RoleController@destroy', 'middleware'=>'ability:root|admin,d_role']);
		Route::get('deletes/{listid}', ['as'=>'backend.role.deletes', 'uses'=>'Admin\RoleController@destroy', 'middleware'=>'ability:root|admin,d_role']);
	});
	Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
		Route::get('/', ['as' => 'backend.user', 'uses' => 'Admin\UserController@index']);
		Route::post('/', ['as' => 'backend.user.saveDetail', 'uses' => 'Admin\UserController@saveDetail']);
		Route::get('/list', ['as' => 'backend.user.list', 'uses' => 'Admin\UserController@listUsers', 'middleware'=>'ability:root|admin,v_user']);
		Route::post('/list', ['as' => 'backend.user.updatePosition', 'uses' => 'Admin\UserController@updatePosition', 'middleware'=>'ability:root,u_user']);
		Route::get('/create', ['as' => 'backend.user.create', 'uses' => 'Admin\UserController@create', 'middleware'=>'ability:root|admin,c_user']);
		Route::post('/create', ['as' => 'backend.user.store', 'uses' => 'Admin\UserController@store', 'middleware'=>'ability:root|admin,c_user']);
		Route::get('{id}', ['as' => 'backend.user.view', 'uses' => 'Admin\UserController@view', 'middleware'=>'ability:root|admin,v_user']);
		Route::get('{id}/edit', ['as' => 'backend.user.edit', 'uses' => 'Admin\UserController@edit', 'middleware'=>'ability:root|admin,u_user']);
		Route::post('{id}/edit', ['as' => 'backend.user.update', 'uses' => 'Admin\UserController@update', 'middleware'=>'ability:root|admin,u_user']);
		Route::get('{id}/active', ['as' => 'backend.user.active', 'uses' => 'Admin\UserController@activeStatus', 'middleware'=>'ability:root|admin,u_user']);
		Route::get('{id}/delete', ['as'=>'backend.user.delete', 'uses'=>'Admin\UserController@destroy', 'middleware'=>'ability:root|admin,d_user']);
		Route::get('deletes/{listid}', ['as'=>'backend.user.deletes', 'uses'=>'Admin\UserController@destroy', 'middleware'=>'ability:root|admin,d_user']);
	});
	Route::group(['prefix' => 'option', 'middleware'=>'role:root'], function(){
		Route::get('/', ['as' => 'backend.option', 'uses' => 'Admin\OptionController@index']);
		Route::get('/create', ['as' => 'backend.option.create', 'uses' => 'Admin\OptionController@create']);
		Route::post('/create', ['as' => 'backend.option.store', 'uses' => 'Admin\OptionController@store']);
		Route::get('{id}', ['as' => 'backend.option.view', 'uses' => 'Admin\OptionController@view']);
		Route::get('{id}/edit', ['as' => 'backend.option.edit', 'uses' => 'Admin\OptionController@edit']);
		Route::post('{id}/edit', ['as' => 'backend.option.update', 'uses' => 'Admin\OptionController@update']);
		Route::get('{id}/active', ['as' => 'backend.option.active', 'uses' => 'Admin\OptionController@activeStatus']);
		Route::get('{id}/delete', ['as'=>'backend.option.delete', 'uses'=>'Admin\OptionController@destroy']);
		Route::get('deletes/{listid}', ['as'=>'backend.option.deletes', 'uses'=>'Admin\OptionController@destroy']);
	});
});
