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
    Route::post('/postulacion', 'OfertasController@postulacion')->name('postulacion.post');
    Route::get('/ofertas/{id}/aspirantes', 'OfertasController@ofertaDetalle')->name('ofertas.aspirantes');
    Route::post('/ofertas/aplicaciones', 'OfertasController@aplicaciones')->name('ofertas.aplicaciones');
    Route::post('/ofertas/aplicaciones/profile', 'OfertasController@profile')->name('ofertas.aplicaciones.profile');
    Route::post('/ofertas/aplicaciones/estado', 'OfertasController@changeStatus')->name('ofertas.aplicaciones.profile');

    #categorias
    Route::get('/categoria/{id}', 'OfertasController@ofertaCategoria')->name('oferta.categoria');

    #aspirante
    Route::get('/aspirante', 'AspirantesController@index')->name('aspirante');
    Route::get('/postulaciones', 'AspirantesController@postulaciones')->name('postulaciones');
    Route::post('/aspirante', 'AspirantesController@perfil')->name('aspirante.post');
    Route::post('/aspirante/view', 'AspirantesController@viewFormacion')->name('aspirante.formacion');
    Route::post('/aspirante/formacion', 'AspirantesController@formacion')->name('aspirante.formacion.post');
    Route::post('/aspirante/idioma/view', 'AspirantesController@viewIdioma')->name('aspirante.idioma');
    Route::post('/aspirante/idioma', 'AspirantesController@idioma')->name('aspirante.idioma.post');
    Route::post('/aspirante/referencia/view', 'AspirantesController@viewReferencia')->name('aspirante.referencia');
    Route::post('/aspirante/referencia', 'AspirantesController@referencia')->name('aspirante.referencia.post');
    Route::post('/aspirante/experiencia/view', 'AspirantesController@viewExperencia')->name('aspirante.experencia');
    Route::post('/aspirante/experiencia', 'AspirantesController@experencia')->name('aspirante.experencia.post');
    
    Route::post('/aspirante/formacion/delete', 'AspirantesController@formacion_delete')->name('aspirante.formacion.delete');
    Route::post('/aspirante/experiencia/delete', 'AspirantesController@experiencia_delete')->name('aspirante.experiencia.delete');
    Route::post('/aspirante/idioma/delete', 'AspirantesController@idioma_delete')->name('aspirante.idioma.delete');
    Route::post('/aspirante/referencia/delete', 'AspirantesController@referencia_delete')->name('aspirante.referencia.delete');

    #search
    Route::post('/search', 'AspirantesController@search')->name('search');

});
