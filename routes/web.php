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
