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
	Route::post('/get-slug', ['as' => 'backend.ajax.getSlug', 'uses' => 'AdminController@ajaxGetSlug']);

	Route::group(['prefix' => 'photo'], function(){
		Route::get('/', ['as' => 'backend.photo', 'uses' => 'Admin\PhotoController@index', 'middleware'=>'ability:root|admin,v_photo']);
	});
	Route::group(['prefix' => 'slider'], function(){
		Route::get('/', ['as' => 'backend.slider', 'uses' => 'Admin\PhotoController@sliderIndex', 'middleware'=>'ability:root|admin,v_slider']);
		Route::post('/', ['as' => 'backend.slider.updatePosition', 'uses' => 'Admin\PhotoController@sliderUpdatePosition', 'middleware'=>'ability:root|admin,u_slider']);
		Route::get('/create', ['as' => 'backend.slider.create', 'uses' => 'Admin\PhotoController@sliderCreate', 'middleware'=>'ability:root|admin,c_slider']);
		Route::post('/create', ['as' => 'backend.slider.store', 'uses' => 'Admin\PhotoController@sliderStore', 'middleware'=>'ability:root|admin,c_slider']);
		Route::get('{id}', ['as' => 'backend.slider.view', 'uses' => 'Admin\PhotoController@sliderView', 'middleware'=>'ability:root|admin,v_slider']);
		Route::get('{id}/edit', ['as' => 'backend.slider.edit', 'uses' => 'Admin\PhotoController@sliderEdit', 'middleware'=>'ability:root|admin,u_slider']);
		Route::post('{id}/edit', ['as' => 'backend.slider.update', 'uses' => 'Admin\PhotoController@sliderUpdate', 'middleware'=>'ability:root|admin,u_slider']);
		Route::get('{id}/active', ['as' => 'backend.slider.active', 'uses' => 'Admin\PhotoController@sliderActiveStatus', 'middleware'=>'ability:root|admin,u_slider']);
		Route::get('{id}/delete', ['as'=>'backend.slider.delete', 'uses'=>'Admin\PhotoController@sliderDestroy', 'middleware'=>'ability:root|admin,d_slider']);
		Route::get('deletes/{listid}', ['as'=>'backend.slider.deletes', 'uses'=>'Admin\PhotoController@sliderDestroy', 'middleware'=>'ability:root|admin,d_slider']);
	});
	Route::group(['prefix' => 'news'], function(){
		Route::group(['prefix' => 'category'], function(){
			Route::get('/', ['as' => 'backend.news.category', 'uses' => 'Admin\CategoryController@index', 'middleware'=>'ability:root|admin,v_news_cate']);
			Route::post('/', ['as' => 'backend.news.category.updatePosition', 'uses' => 'Admin\CategoryController@updatePosition', 'middleware'=>'ability:root|admin,u_news_cate']);
			Route::get('/create', ['as' => 'backend.news.category.create', 'uses' => 'Admin\CategoryController@create', 'middleware'=>'ability:root|admin,c_news_cate']);
			Route::post('/create', ['as' => 'backend.news.category.store', 'uses' => 'Admin\CategoryController@store', 'middleware'=>'ability:root|admin,c_news_cate']);
			Route::get('{id}', ['as' => 'backend.news.category.view', 'uses' => 'Admin\CategoryController@view', 'middleware'=>'ability:root|admin,v_news_cate']);
			Route::get('{id}/edit', ['as' => 'backend.news.category.edit', 'uses' => 'Admin\CategoryController@edit', 'middleware'=>'ability:root|admin,u_news_cate']);
			Route::post('{id}/edit', ['as' => 'backend.news.category.update', 'uses' => 'Admin\CategoryController@update', 'middleware'=>'ability:root|admin,u_news_cate']);
			Route::get('{id}/active', ['as' => 'backend.news.category.active', 'uses' => 'Admin\CategoryController@activeStatus', 'middleware'=>'ability:root|admin,u_news_cate']);
			Route::get('{id}/delete', ['as'=>'backend.news.category.delete', 'uses'=>'Admin\CategoryController@destroy', 'middleware'=>'ability:root|admin,d_news_cate']);
			Route::get('deletes/{listid}', ['as'=>'backend.news.category.deletes', 'uses'=>'Admin\CategoryController@destroy', 'middleware'=>'ability:root|admin,d_news_cate']);
		});

		Route::get('/', ['as' => 'backend.news', 'uses' => 'Admin\PostController@index', 'middleware'=>'ability:root|admin,v_news']);
		Route::post('/', ['as' => 'backend.news.updatePosition', 'uses' => 'Admin\PostController@updatePosition', 'middleware'=>'ability:root|admin,u_news']);
		Route::get('/create', ['as' => 'backend.news.create', 'uses' => 'Admin\PostController@create', 'middleware'=>'ability:root|admin,c_news']);
		Route::post('/create', ['as' => 'backend.news.store', 'uses' => 'Admin\PostController@store', 'middleware'=>'ability:root|admin,c_news']);
		Route::get('{id}', ['as' => 'backend.news.view', 'uses' => 'Admin\PostController@view', 'middleware'=>'ability:root|admin,v_news']);
		Route::get('{id}/edit', ['as' => 'backend.news.edit', 'uses' => 'Admin\PostController@edit', 'middleware'=>'ability:root|admin,u_news']);
		Route::post('{id}/edit', ['as' => 'backend.news.update', 'uses' => 'Admin\PostController@update', 'middleware'=>'ability:root|admin,u_news']);
		Route::get('{id}/active', ['as' => 'backend.news.active', 'uses' => 'Admin\PostController@activeStatus', 'middleware'=>'ability:root|admin,u_news']);
		Route::get('{id}/delete', ['as'=>'backend.news.delete', 'uses'=>'Admin\PostController@destroy', 'middleware'=>'ability:root|admin,d_news']);
		Route::get('deletes/{listid}', ['as'=>'backend.news.deletes', 'uses'=>'Admin\PostController@destroy', 'middleware'=>'ability:root|admin,d_news']);
	});
	Route::group(['prefix' => 'page'], function(){
		Route::get('/', ['as' => 'backend.page', 'uses' => 'Admin\PageController@index', 'middleware'=>'ability:root|admin,v_page']);
		Route::post('/', ['as' => 'backend.page.updatePosition', 'uses' => 'Admin\PageController@updatePosition', 'middleware'=>'ability:root|admin,u_page']);
		Route::get('/create', ['as' => 'backend.page.create', 'uses' => 'Admin\PageController@create', 'middleware'=>'ability:root|admin,c_page']);
		Route::post('/create', ['as' => 'backend.page.store', 'uses' => 'Admin\PageController@store', 'middleware'=>'ability:root|admin,c_page']);
		Route::get('{id}', ['as' => 'backend.page.view', 'uses' => 'Admin\PageController@view', 'middleware'=>'ability:root|admin,v_page']);
		Route::get('{id}/edit', ['as' => 'backend.page.edit', 'uses' => 'Admin\PageController@edit', 'middleware'=>'ability:root|admin,u_page']);
		Route::post('{id}/edit', ['as' => 'backend.page.update', 'uses' => 'Admin\PageController@update', 'middleware'=>'ability:root|admin,u_page']);
		Route::get('{id}/active', ['as' => 'backend.page.active', 'uses' => 'Admin\PageController@activeStatus', 'middleware'=>'ability:root|admin,u_page']);
		Route::get('{id}/delete', ['as'=>'backend.page.delete', 'uses'=>'Admin\PageController@destroy', 'middleware'=>'ability:root|admin,d_page']);
		Route::get('deletes/{listid}', ['as'=>'backend.page.deletes', 'uses'=>'Admin\PageController@destroy', 'middleware'=>'ability:root|admin,d_page']);
	});
	Route::group(['prefix' => 'config'], function(){
		Route::get('/', ['as' => 'backend.config', 'uses' => 'Admin\ConfigController@index', 'middleware'=>'ability:root|admin,v_config']);
		Route::post('/', ['as' => 'backend.config.update', 'uses' => 'Admin\ConfigController@update', 'middleware'=>'ability:root|admin,u_config']);
	});
	Route::group(['prefix' => 'permission'], function(){
		Route::get('/', ['as' => 'backend.permission', 'uses' => 'Admin\PermissionController@index', 'middleware' => 'ability:root,v_permission']);
		Route::get('/create', ['as' => 'backend.permission.create', 'uses' => 'Admin\PermissionController@create', 'middleware'=>'ability:root,c_permission']);
		Route::post('/create', ['as' => 'backend.permission.store', 'uses' => 'Admin\PermissionController@store', 'middleware'=>'ability:root,c_permission']);
		Route::get('{id}', ['as' => 'backend.permission.view', 'uses' => 'Admin\PermissionController@view', 'middleware' => 'ability:root,v_permission']);
		Route::get('{id}/edit', ['as' => 'backend.permission.edit', 'uses' => 'Admin\PermissionController@edit', 'middleware'=>'ability:root,u_permission']);
		Route::post('{id}/edit', ['as' => 'backend.permission.update', 'uses' => 'Admin\PermissionController@update', 'middleware'=>'ability:root,u_permission']);
		Route::get('{id}/delete', ['as'=>'backend.permission.delete', 'uses'=>'Admin\PermissionController@destroy', 'middleware'=>'ability:root,d_permission']);
		Route::get('deletes/{listid}', ['as'=>'backend.permission.deletes', 'uses'=>'Admin\PermissionController@destroy', 'middleware'=>'ability:root,d_permission']);
	});
	Route::group(['prefix' => 'role'], function(){
		Route::get('/', ['as' => 'backend.role', 'uses' => 'Admin\RoleController@index', 'middleware' => 'ability:root|admin,v_role']);
		Route::get('/create', ['as' => 'backend.role.create', 'uses' => 'Admin\RoleController@create', 'middleware'=>'ability:root|admin,c_role']);
		Route::post('/create', ['as' => 'backend.role.store', 'uses' => 'Admin\RoleController@store', 'middleware'=>'ability:root|admin,c_role']);
		Route::get('{id}', ['as' => 'backend.role.view', 'uses' => 'Admin\RoleController@view', 'middleware' => 'ability:root|admin,v_role']);
		Route::get('{id}/edit', ['as' => 'backend.role.edit', 'uses' => 'Admin\RoleController@edit', 'middleware'=>'ability:root|admin,u_role']);
		Route::post('{id}/edit', ['as' => 'backend.role.update', 'uses' => 'Admin\RoleController@update', 'middleware'=>'ability:root|admin,u_role']);
		Route::get('{id}/delete', ['as'=>'backend.role.delete', 'uses'=>'Admin\RoleController@destroy', 'middleware'=>'ability:root|admin,d_role']);
		Route::get('deletes/{listid}', ['as'=>'backend.role.deletes', 'uses'=>'Admin\RoleController@destroy', 'middleware'=>'ability:root|admin,d_role']);
	});
	Route::group(['prefix' => 'user'], function(){
		Route::get('/', ['as' => 'backend.user', 'uses' => 'Admin\UserController@index']);
		Route::post('/', ['as' => 'backend.user.saveDetail', 'uses' => 'Admin\UserController@saveDetail']);
		Route::get('/list', ['as' => 'backend.user.list', 'uses' => 'Admin\UserController@listUsers', 'middleware'=>'ability:root|admin,v_user']);
		Route::post('/list', ['as' => 'backend.user.updatePosition', 'uses' => 'Admin\UserController@updatePosition', 'middleware'=>'ability:root|admin,u_user']);
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
