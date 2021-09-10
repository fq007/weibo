<?php

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

/*
 * 注册  start
 */
Route::get("signup","UserController@create")->name('signup');
Route::get('signup/confirm/{token}',"UserController@confirmEmail")->name('confirm_email');
/*
 * 注册 end
 */

/*
 * 用户 start
 */
Route::resource('user','UserController');
Route::get('/users/{user}/edit','UserController@edit')->name('user.edit');
/*
 * 用户 end
 */

/*
 * 登录 登出 start
 */

Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout','SessionsController@destroy')->name('logout');

/*
 * 登录 登出 end
 */

/*
 * 重置密码 start
 */
Route::get('password/reset','PasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email','PasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}','PasswordController@showResetForm')->name('password.reset');
Route::post('password/reset','PasswordController@reset')->name('password.update');
/*
 * 重置密码 end
 */
