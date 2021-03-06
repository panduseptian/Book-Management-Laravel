<?php

use Illuminate\Support\Facades\Route;

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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/user', 'UserController');
Route::get('user/delete/{id}', 'UserController@destroy');

Route::resource('/author', 'AuthorController');
Route::get('author/delete/{id}', 'AuthorController@destroy');

Route::resource('/book', 'BookController');
Route::get('book/delete/{id}', 'BookController@destroy');