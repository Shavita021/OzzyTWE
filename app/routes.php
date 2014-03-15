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

Route::post('login', array('uses' => 'systemController@login'));

/*Route::get('login', function()
{
	return View::make('adminMaestros.inicio');
});
*/

Route::get('logout', array('uses' => 'systemController@logout'));

//Ruta para la funcion mostrarusuarios en el controlador systemController
Route::get('mostrarUsuarios', array('uses' => 'systemController@mostrarUsuarios'));

Route::get('buscar', function()
{
	return View::make('adminMaestros.buscar');
});

Route::get('inicio', function()
{
	return View::make('adminMaestros.inicio');
});

Route::get('crearUsuario', function()
{
	return View::make('adminMaestros.create');
});

Route::get('busqueda', array('uses' => 'systemController@busqueda'));

Route::resource('adminMaestro', 'adminMaestroController');

Route::resource('adminSecundario', 'adminSecundarioController');

Route::resource('usuarioNormal', 'usuarioNormalController');

?>


