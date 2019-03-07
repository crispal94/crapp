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


Route::get ('proestado', 'ReportesController@proestado');

Route::get('vis',function(){
  return view('pdf.template');
});

Route::get ('pdfprueba', 'PdfController@github');

Route::get ('crearoles', 'HomeController@crearoles');
Route::get ('crearhabilidad', 'HomeController@crearhabilidad');

Route::get('/test', function()
{
	$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
    $beautymail->send('email.welcome', [], function($message)
    {
        $message
			->from('info@pure.ec','Christian')
			->to('crispal94@hotmail.com', 'John Smith')
			->subject('Welcome!');
    });

});

Route::get('/', 'HomeController@index')->name('home');

Route::get('email', 'HomeController@email');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function () {
//USUARIOS
Route::resource('usuarios','UsuariosController');
Route::get('usuarios/{id}/delete', [
    'as' => 'usuarios.delete',
    'uses' => 'UsuariosController@destroy',
]);

Route::get('perfil/{id}/editar', [
    'as' => 'profile.edicion',
    'uses' => 'UsuariosController@perfil',
]);

Route::put('perfil/{id}/editar', [
    'as' => 'profile.edicionpost',
    'uses' => 'UsuariosController@perfilpost',
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
Route::group(['middleware' => 'can:crear-proyecto'], function () {
Route::resource('proyectos','ProyectosController');
Route::post('proyectos/bajaproyecto','ProyectosController@bajaproyecto');
Route::get('proyectos/{id}/delete', [
    'as' => 'proyectos.delete',
    'uses' => 'ProyectosController@destroy',
]);
});

Route::get('proyectos/create/getrecursos','ProyectosController@getrecursos');
Route::get('proyectos/{id}/edit/getrecursos','ProyectosController@getrecursos');


//ACTIVIDADES - DETALLE
Route::get('actividades','ActividadesController@index');
Route::get('actividades/getproyectos','ActividadesController@getproyectos');
Route::post('actividades/ingresaractividad','ActividadesController@ingresaractividad');
Route::post('actividades/editaractividad','ActividadesController@editaractividad');


//ACTIVIDADES - AVANCES - SEGUIMIENTO
Route::get('avances','AvancesController@index');
Route::get('avances/seguimiento/{id}','AvancesController@seguimiento');
Route::get('avances/seguimiento/{id}/editar/{idavance}','AvancesController@editar');
Route::post('avances/seguimiento/{id}/postavance','AvancesController@postavance');
Route::post('avances/seguimiento/{id}/editaravance','AvancesController@editaravance');
Route::get('avances/getproyectos','AvancesController@getproyectos');

//REPORTES
Route::get('reportes','ReportesController@index');
Route::get('reportes/getproyectos','ReportesController@getproyectos');
Route::get('reportes/seguimiento/{id}','ReportesController@seguimiento');
Route::get('reportes/seguimiento/{id}/reporte','ReportesController@reporte');
Route::post('reportes/proyectos',[
        'as' => 'reportes.proyectos',
        'uses' => 'ReportesController@imprimir'
    ]);

//REPORTES NOVEDADES
Route::get('novedades','ReportesNovedadesController@index');
Route::get('novedades/getproyectos','ReportesNovedadesController@getproyectos');
Route::get('novedades/getnovedades','ReportesNovedadesController@getnovedades');
Route::post('novedades/novedades',[
        'as' => 'reportes.novedades',
        'uses' => 'ReportesNovedadesController@imprimir'
    ]);


//REPORTES HISTORIA
Route::get('historia','ReportesHistoriaController@index');
Route::get('historia/getproyectos','ReportesHistoriaController@getproyectos');
Route::post('historia/imprimir',[
        'as' => 'reportes.historia',
        'uses' => 'ReportesHistoriaController@imprimir'
    ]);
});


Route::get('404',['as'=>'404','uses'=>'ErrorController@notfound']);
Route::get('500',['as'=>'500','uses'=>'ErrorController@fatal']);
