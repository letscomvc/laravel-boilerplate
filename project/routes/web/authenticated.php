<?php
/**
 * Authenticated routes
 * Middleware 'auth'
 */

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/users/pagination', 'UserController@pagination')->name('users.pagination');
