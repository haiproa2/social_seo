<?php
Route::group(['middleware' => 'web', 'prefix' => 'thanh-vien', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
    Route::get('/', 'UserController@index');
    Route::get('/dang-nhap', [
		'as'=>'frontend.user.login',
		'uses'=>'UserController@getLogin'
    ]);
    Route::get('/dang-xuat', [
		'as'=>'frontend.user.logout',
		'uses'=>'UserController@getLogout'
    ]);
    Route::post('/dang-nhap', [
		'as'=>'frontend.user.postLogin',
		'uses'=>'UserController@postLogin'
    ]);
});