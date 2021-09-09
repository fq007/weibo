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