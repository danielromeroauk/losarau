<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function subir_archivos()
	{
		return View::make('datos.subir_archivos');
	}

	public function subir_archivo()
	{
		$file = Input::file('file');
		$nombre = $file->getClientOriginalName();
		$ubicacion = public_path() .'/uploads/';

		$subir = $file->move($ubicacion, $nombre);

	} #subir_archivos

	public function registrar_pagos()
	{
		$file = public_path() .'/uploads/pagos.txt';

		Pago::truncate(); // Se limpia la tabla pagos.

		if (file_exists($file))
		{
			$lineas = file($file);

			foreach ($lineas as $key => $linea)
			{
				if ($key === 0)
				{
					continue;
				}

				$palabras = preg_split('[,]', htmlspecialchars($linea));

				if (count($palabras) < 5)
				{
					continue;
				}
				$nit = $palabras[0];
				$nombre = $palabras[1];
				$valor = $palabras[2];
				$seguro = $palabras[3];
				$fecha_pago = $this->organizarFecha($palabras[4]);
				$forma_pago = $palabras[5];

				$user = $this->verificar_usuario($nit, $nombre);

				if ($user)
				{
					$this->agregar_pago($user->id, $valor, $seguro, $fecha_pago, $forma_pago);
				}

			} #foreach

			unlink($file); // Elimina el archivo del disco duro.

			Session::flash('mensaje', 'Pagos registrados con éxito.');

		} #file_exists
		else
		{
			Session::flash('mensaje', 'El archivo pagos.txt no existe.');
		}

		return Redirect::route('estado_cuenta');

	} #actualizar_pagos

	private function verificar_usuario($nit, $nombre)
	{
		$user = User::where('nit', '=', $nit)->first();

		if (! $user)
		{
			$user = new User();
			$user->nit = $nit;
			$user->nombre = $nombre;
			$user->password = Hash::make($nit);
			$user->save();
		}

		return $user;
	} #verificar_usuario

	private function agregar_pago($user_id, $valor, $seguro, $fecha_pago, $forma_pago)
	{
		$pago = new Pago();
		$pago->user_id = $user_id;
		$pago->valor = $valor;
		$pago->seguro = $seguro;
		$pago->fecha_pago = $fecha_pago;
		$pago->forma_pago = $forma_pago;
		$pago->save();
	}

	public function registrar_estados()
	{
		$file = public_path() .'/uploads/estados.txt';

		Estado::truncate(); // Se limpia la tabla estados.

		if (file_exists($file))
		{
			$lineas = file($file);

			foreach ($lineas as $key => $linea)
			{
				if ($key === 0)
				{
					continue;
				}

				$palabras = preg_split('[,]', htmlspecialchars($linea));

				if (count($palabras) < 4)
				{
					continue;
				}
				$nit = $palabras[0];
				$concepto = $palabras[2];
				$vencido = $palabras[3];
				$no_vencido = $palabras[4];

				$this->agregar_estado($nit, $concepto, $vencido, $no_vencido);


				Session::flash('mensaje', 'Estados registrados exitosamente.');

			} #foreach

			unlink($file); // Elimina el archivo del disco duro.

		} #file_exists
		else
		{
			Session::flash('mensaje', 'El archivo estados.txt no existe.');
		}

		return Redirect::route('estado_cuenta');

	} #actualizar_estados

	private function agregar_estado($nit, $concepto, $vencido, $no_vencido)
	{
		Session::set('users_no_registrados', array());

		$user = User::where('nit', '=', $nit)->first();

		if ($user)
		{
			$estado = new Estado;
			$estado->user_id = $user->id;
			$estado->concepto = $concepto;
			$estado->vencido = $vencido;
			$estado->no_vencido = $no_vencido;
			$estado->save();
		}
		else
		{
			Session::push('users_no_registrados', $nit);
		}
	}

	private function organizarFecha($texto)
	{
		$fecha = preg_split('[/]', $texto);
		return (0 + $fecha[2])."-".(0 + $fecha[1])."-".(0 + $fecha[0]);
	}

} #HomeController
