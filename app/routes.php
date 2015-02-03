<?php

Route::get('/', function()
{
	return View::make('inicio');
});

Route::get('historia', function()
{
	return View::make('informacion.historia');
});

Route::get('mision', function()
{
	return View::make('informacion.mision');
});

Route::get('vision', function()
{
	return View::make('informacion.vision');
});

Route::get('objetivos', function()
{
	return View::make('informacion.objetivos');
});

Route::get('tramites/solicitud-de-credito', function()
{
	return View::make('informacion.solicitudDeCredito');
});

Route::get('tramites/reestructuracion-de-credito', function()
{
	return View::make('informacion.reestructuracionDeCredito');
});

Route::get('tramites/desembolso-de-credito', function()
{
	return View::make('informacion.desembolsoDeCredito');
});

Route::get('tramites/constitucion-de-hipoteca', function()
{
	return View::make('informacion.constitucionDeHipoteca');
});

Route::get('tramites/cancelacion-de-hipoteca', function()
{
	return View::make('informacion.cancelacionDeHipoteca');
});

Route::group(['before' => 'auth'], function()
{
	Route::get('estado-de-mi-cuenta', [
		'as' => 'estado_cuenta',
		'uses' => 'UserController@estado_cuenta'
	]);

	Route::get('cambiar-clave', [
		'as' => 'cambiar_password',
		'uses' => 'UserController@cambiar_password'
	]);

	Route::post('actualizar-clave', [
		'as' => 'actualizar_password',
		'uses' => 'UserController@actualizar_password'
	]);

	Route::get('logout', [
		'as' => 'logout',
		'uses' => 'UserController@logout'
	]);

	Route::get('subir-archivos', [
		'as' => 'subir_archivos',
		'uses' => 'HomeController@subir_archivos'
	]);

	Route::post('subir-archivo', [
		'as' => 'subir_archivo',
		'uses' => 'HomeController@subir_archivo'
	]);

	Route::get('registrar-pagos', 'HomeController@registrar_pagos');
	Route::get('registrar-estados', 'HomeController@registrar_estados');

}); #auth

Route::group(['before' => 'guest'], function()
{
	Route::get('login', [
		'as' => 'login',
		'uses' => 'UserController@login'
	]);

	Route::post('login', [
		'as' => 'autenticar',
		'uses' => 'UserController@autenticar'
	]);

}); #guest

Route::get('daniel', function()
{
	$user = new User();
	$user->nit = '1116786822';
	$user->nombre = 'DANIEL GUILLERMO ROMERO GELVEZ';
	$user->password = Hash::make('123');
	$user->save();

	return 'Usuario creado: '. $user;
});