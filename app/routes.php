<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('/recuperarContraseña', function()
{
	return View::make('recuperarContraseña');
});

Route::post('recuperarContraseña', array('uses' => 'systemController@recuperarContraseña'));

Route::post('login', array('uses' => 'systemController@login'));

/*Route::get('login', function()
{
	return View::make('adminMaestros.inicio');
});
*/

Route::get('logout', array('uses' => 'systemController@logout'));

//Ruta para la funcion mostrarusuarios en el controlador systemController
Route::get('usuarios', array('uses' => 'systemController@mostrarUsuarios'));

Route::get('buscar', function()
{
	return View::make('adminMaestros.buscar');
});

/*Route::get('crearUsuario', function()
{
	return View::make('adminMaestros.create');
});*/

Route::get('busqueda', array('uses' => 'systemController@busqueda'));

//Ruta para dirigirse a la pagina de administracion de los Roles
Route::get('administracionRoles', array('uses' => 'rolController@index'));

//Ruta para dirigirse a la pagina de creacion de un nuevo Rol
Route::get('administracionRoles/crearRol', function()
{
	return View::make('adminMaestros.crearRol');
});

//Ruta para ajax, para extraer los usuarios relacionados con un rol
Route::get('procesos/usuariosRoles', array('uses' => 'procesoController@usuariosRoles'));

//Ruta al a accion de guardar un nuevo rol rolController
Route::resource('administracionRoles', 'rolController');

Route::resource('adminMaestro', 'adminMaestroController');

Route::resource('adminSecundario', 'adminSecundarioController');

Route::resource('usuarioNormal', 'usuarioNormalController');

Route::resource('procesos', 'procesoController');

Route::resource('procesos/tareas', 'tareaController');

Route::resource('procesos/tareas/paralela', 'tareaParalelaController');

Route::resource('bandeja', 'respuestaTareasController');

//Ruta para la creacion de las tareas con respecto al id del proceso
Route::get('/procesos/tareas/create/{id}', array('uses' => 'tareaController@create'));

//Ruta para la creacion de las tareas paralelas con respecto a un id de una tarea normal
Route::get('/procesos/tareas/create/paralela/{id}', array('uses' => 'tareaParalelaController@create'));

//Ruta para iniciar el proceso
Route::get('/procesos/iniciar/{id}', array('uses' => 'procesoController@iniciarProceso'));

//Ruta para contestar una tarea y activar la(s) siguiente
Route::get('/bandeja/responder/{id}', array('uses' => 'respuestaTareasController@responder'));

//Ruta para la edicion del SuperUsuario
Route::get('/edit', array('uses' => 'systemController@edit'));

//Ruta para guardar la edicion de SuperUsuario
Route::put('/update/{email}', array('uses' => 'systemController@update'));

//Ruta para los creditos
Route::get('/creditos', function()
{
     if(Session::get('tipoSession') == 'usuarioNormal')
	return View::make('usuarioNormales.creditos');
	else
     return View::make('creditos');
});

//Ruta para la bandeja de procesos disponibles a ejecutar
Route::get('/bandejaProcesos', array('uses' => 'procesoController@mostrarProcesos'));

//Ruta para mostrar los procesos instancia que estan en ejecucuion o terminados
Route::get('/procesos/instancia/{id}', array('uses' => 'procesoController@instanciasProcesos'));

//Ruta para eliminar una instancia de un proceso
Route::delete('/procesos/instancia/{id}', array('uses' => 'procesoController@eliminarInstancia'));

?>


