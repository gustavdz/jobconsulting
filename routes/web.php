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

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    #user - empresas
    Route::get('/user', 'UserController@index')->name('user');
    Route::post('/user/data', 'UserController@data')->name('user.data');
    Route::post('/user', 'UserController@store')->name('user.post');

    #ofertas
    Route::get('/ofertas', 'OfertasController@index')->name('ofertas');
});
