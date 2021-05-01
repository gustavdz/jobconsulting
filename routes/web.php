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
    Route::get('/home/{param?}', 'HomeController@index')->name('home');
    Route::post('/activar', 'HomeController@activar')->name('activar');

    #user - empresas
    Route::get('/user', 'UserController@index')->name('user');
    Route::get('/user-aspirante', 'UserController@indexAspirante')->name('user.aspirante');
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
    Route::get('/ofertas/{id}/aplicar', 'OfertasController@detalle')->name('ofertas.aplicar');
    Route::post('/ofertas/aplicaciones', 'OfertasController@aplicaciones')->name('ofertas.aplicaciones');
    Route::post('/ofertas/aplicaciones/profile', 'OfertasController@profile')->name('ofertas.aplicaciones.profile');
    Route::post('/ofertas/aplicaciones/estado', 'OfertasController@changeStatus')->name('ofertas.aplicaciones.profile');
    Route::post('/ofertas/habilidad', 'OfertasController@habilidad')->name('ofertas.habilidad');
    Route::get('/ofertas/{id}/preguntas', 'PreguntasController@index')->name('ofertas.preguntas');
    Route::post('/ofertas/preguntas', 'PreguntasController@data')->name('ofertas.preguntas.data');
    Route::post('/preguntas', 'PreguntasController@store')->name('ofertas.preguntas.store');
    Route::post('/pregunta/delete', 'PreguntasController@delete')->name('ofertas.preguntas.delete');

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

    #categorias
    Route::get('/categorias', 'CategoriasController@index')->name('categorias');
    Route::post('/categorias/data', 'CategoriasController@data')->name('categorias.data');
    Route::post('/categorias', 'CategoriasController@post')->name('categorias.post');
    Route::post('/categorias/delete', 'CategoriasController@delete')->name('categorias.delete');

    #habilidades
    Route::get('/habilidades', 'HabilidadesController@index')->name('habilidades');
    Route::post('/habilidades/data', 'HabilidadesController@data')->name('habilidades.data');
    Route::post('/habilidades', 'HabilidadesController@post')->name('habilidades.post');
    Route::post('/habilidades/delete', 'HabilidadesController@delete')->name('habilidades.delete');

    #reportes
    Route::get('/reportes', 'ReportesController@index')->name('reportes');
    Route::get('/reportes/postulantes-registros-mes', 'ReportesController@postulantes_registros_mes')->name('postulantes-registros-mes');
    Route::post('/reportes/dataPostulanteRegistro{desde?}{hasta?}', 'ReportesController@dataPostulanteRegistro')->name('dataPostulanteRegistro');
    Route::get('/reportes/aplicaciones-mes', 'ReportesController@aplicaciones_mes')->name('aplicaciones-mes');
    Route::post('/reportes/dataAplicacionesRegistro{desde?}{hasta?}', 'ReportesController@dataAplicacionesRegistro')->name('dataAplicacionesRegistro');
    Route::get('/reportes/postulantes-ofertas', 'ReportesController@postulantes_ofertas')->name('postulantes-ofertas');
    Route::post('/reportes/dataPostulantesOfertasRegistro{desde?}{hasta?}', 'ReportesController@dataPostulantesOfertasRegistro')->name('dataPostulantesOfertasRegistro');
    #Route::get('/prueba', 'OfertasController@publicPostFB');

});
