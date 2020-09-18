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
    Route::post('/user', 'UserController@store')->name('user.store');
    Route::post('/user/delete', 'UserController@delete')->name('user.delete');
    Route::get('/user/edit', 'UserController@edit')->name('user.show');

    #ofertas
    Route::get('/ofertas', 'OfertasController@index')->name('ofertas');
    Route::post('/ofertas', 'OfertasController@store')->name('ofertas.store');
    Route::get('/ofertas/data', 'OfertasController@data')->name('ofertas.data');
    Route::post('/ofertas/show', 'OfertasController@show')->name('ofertas.show');
    Route::post('/ofertas/delete', 'OfertasController@delete')->name('ofertas.delete');
});
