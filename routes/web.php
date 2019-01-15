<?php

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

/*Route::get('/', function () {
    return view('app');
});*/

Route::get('/', 'HomeController@index')->name('home');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//USUARIOS
Route::resource('usuarios','UsuariosController');
Route::get('usuarios/{id}/delete', [
    'as' => 'usuarios.delete',
    'uses' => 'UsuariosController@destroy',
]);

//ROLES
Route::resource('roles','RolesController');
Route::get('roles/{id}/delete', [
    'as' => 'roles.delete',
    'uses' => 'RolesController@destroy',
]);

//PARAMETROS
Route::resource('parametros','ParamReferencialesController');
Route::get('parametros/{id}/delete', [
    'as' => 'parametros.delete',
    'uses' => 'ParamReferencialesController@destroy',
]);


//PRIORIDADES
Route::resource('prioridades','PrioridadesController');
Route::get('prioridades/{id}/delete', [
    'as' => 'prioridades.delete',
    'uses' => 'PrioridadesController@destroy',
]);

//GRUPO DE USUARIOS
Route::resource('grupousuarios','GrupoUsuariosController');
Route::get('grupousuarios/{id}/delete', [
    'as' => 'grupousuarios.delete',
    'uses' => 'GrupoUsuariosController@destroy',
]);

//TIPO DE ACTIVIDADES
Route::resource('tipoactividades','TipoActividadesController');
Route::get('tipoactividades/{id}/delete', [
    'as' => 'tipoactividades.delete',
    'uses' => 'TipoActividadesController@destroy',
]);

//ESTADOS
Route::resource('estados','EstadosController');
Route::get('estados/{id}/delete', [
    'as' => 'estados.delete',
    'uses' => 'EstadosController@destroy',
]);


//PROYECTOS - CABECERA
Route::resource('proyectos','ProyectosController');
Route::get('proyectos/{id}/delete', [
    'as' => 'proyectos.delete',
    'uses' => 'ProyectosController@destroy',
]);

Route::get('proyectos/create/getrecursos','ProyectosController@getrecursos');
Route::get('proyectos/{id}/edit/getrecursos','ProyectosController@getrecursos');


//ACTIVIDADES - DETALLE
Route::get('actividades','ActividadesController@index');
Route::get('actividades/getproyectos','ActividadesController@getproyectos');
Route::post('actividades/ingresaractividad','ActividadesController@ingresaractividad');
