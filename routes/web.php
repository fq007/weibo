<?php

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

/*
 * 注册  start
 */
Route::get("signup","UserController@create")->name('signup');
/*
 * 注册 end
 */

Route::resource('user','UserController');

/*
 * 登录 登出 start
 */

Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::get('logout','SessionsController@destroy')->name('logout');

/*
 * 登录 登出 end
 */