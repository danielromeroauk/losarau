<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /user/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /user
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /user/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function estado_cuenta()
	{
		$user = User::find(Auth::user()->id);

		return View::make('users.cuenta', compact('user'));
	}

	public function login()
	{
		// El formulario de login está en el menú top de la página de inicio.
		return Redirect::to('/');
	}

	public function autenticar()
	{
		$input = Input::only('nit', 'password');

		if (Auth::attempt($input))
		{
			return Redirect::route('estado_cuenta');
		}
		else
		{
			return Redirect::back()->withInput();
		}
	} #autenticar

	public function cambiar_password()
	{
		return View::make('users.cambiar_password');
	}

	public function actualizar_password()
	{
		$input = Input::all();

		$credenciales = [
			'nit' => Auth::user()->nit,
			'password' => $input['password_actual']
		];

		if (Auth::attempt($credenciales))
		{
			$reglas = [
				'nuevo_password' => 'required|min:5|confirmed'
			];

			$validador = Validator::make($input, $reglas);

			if ($validador->passes())
			{
				Auth::user()->password = Hash::make($input['nuevo_password']);
				Auth::user()->save();

				Session::flash('mensaje', 'Clave cambiada con éxito.');

				return Redirect::route('estado_cuenta');
			}
			else
			{
				return Redirect::back()->withErrors($validador);
			}
		}
		else
		{
			return Redirect::route('logout');
		}
	} #actualizar_password

	public function logout()
	{
		Auth::logout();
		Session::flush();

		return Redirect::back();
	}

} #UserController