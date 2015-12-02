<?php

class HomeController extends BaseController
{

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
        $ubicacion = public_path() . '/uploads/';

        $subir = $file->move($ubicacion, $nombre);

    } #subir_archivos

    public function registrar_abonos()
    {
        $file = public_path() . '/uploads/abonos.csv';

        Abono::truncate(); // Se limpia la tabla abonos.

        if (file_exists($file)) {
            $lineas = file($file);

            foreach ($lineas as $key => $linea) {
                if ($key === 0) {
                    continue;
                }

                $palabras = preg_split('[,]', htmlspecialchars($linea));

                if (count($palabras) < 4) {
                    continue;
                }

                $nit = trim($palabras[0]);
                $nombre = trim($palabras[1]);
                $valor = trim($palabras[2]);
                $fecha_pago = $this->organizarFecha(trim($palabras[3]));
                $forma_pago = trim($palabras[4]);

                $user = $this->verificar_usuario($nit, $nombre);

                if ($user) {
                    $this->agregar_abono($user->id, $valor, $fecha_pago, $forma_pago);
                }

            } #foreach

            unlink($file); // Elimina el archivo del disco duro.

            Session::flash('mensaje', 'Abonos registrados con éxito.');

        } #file_exists
        else {
            Session::flash('mensaje', 'El archivo abonos.csv no existe.');
        }

        return Redirect::route('estado_cuenta');

    } #actualizar_pagos

    private function verificar_usuario($nit, $nombre)
    {
        $user = User::where('nit', '=', $nit)->first();

        if (!$user) {
            $user = new User();
            $user->nit = $nit;
            $user->nombre = $nombre;
            $user->password = Hash::make($nit);
            $user->save();
        }

        return $user;
    } #verificar_usuario

    private function agregar_abono($user_id, $valor, $fecha_pago, $forma_pago)
    {
        $pago = new Abono();
        $pago->user_id = $user_id;
        $pago->valor = $valor;
        $pago->fecha_pago = $fecha_pago;
        $pago->forma_pago = $forma_pago;
        $pago->save();
    }

    public function registrar_estados()
    {
        $file = public_path() . '/uploads/estados.csv';

        Estado::truncate(); // Se limpia la tabla estados.

        if (file_exists($file)) {
            $lineas = file($file);

            foreach ($lineas as $key => $linea) {
                if ($key === 0) {
                    continue;
                }

                $palabras = preg_split('[,]', htmlspecialchars($linea));

                if (count($palabras) < 12) {
                    continue;
                }
                $nit = $palabras[0];
                $pagare = trim($palabras[2]);
                $estado = trim($palabras[3]);
                $capital = trim($palabras[4]);
                $intereses = trim($palabras[5]);
                $mora = trim($palabras[6]);
                $seguro = trim($palabras[7]);
                $idiferido = trim($palabras[8]);
                $asistencia = trim($palabras[9]);
                $cinversion = trim($palabras[10]);
                $icausado = trim($palabras[11]);
                $total = trim($palabras[12]);

                $this->agregar_estado($nit, $pagare, $estado, $capital, $intereses, $mora, $seguro, $idiferido, $asistencia, $cinversion, $icausado, $total);


                Session::flash('mensaje', 'Estados registrados exitosamente.');

            } #foreach

            unlink($file); // Elimina el archivo del disco duro.

        } #file_exists
        else {
            Session::flash('mensaje', 'El archivo estados.csv no existe.');
        }

        return Redirect::route('estado_cuenta');

    } #actualizar_estados

    private function agregar_estado($nit, $pagare, $estado, $capital, $intereses, $mora, $seguro, $idiferido, $asistencia, $cinversion, $icausado, $total)
    {
        Session::set('users_no_registrados', array());

        $user = User::where('nit', '=', $nit)->first();

        if ($user) {
            $estadoTable = new Estado;
            $estadoTable->user_id = $user->id;
            $estadoTable->pagare = $pagare;
            $estadoTable->estado = $estado;
            $estadoTable->capital = $capital;
            $estadoTable->intereses = $intereses;
            $estadoTable->mora = $mora;
            $estadoTable->seguro = $seguro;
            $estadoTable->idiferido = $idiferido;
            $estadoTable->asistencia = $asistencia;
            $estadoTable->cinversion = $cinversion;
            $estadoTable->icausado = $icausado;
            $estadoTable->total = $total;
            $estadoTable->save();
        } else {
            Session::push('users_no_registrados', $nit);
        }
    }

    private function organizarFecha($texto)
    {
        $fecha = preg_split('[/]', $texto);

        return (0 + $fecha[2]) . "-" . (0 + $fecha[1]) . "-" . (0 + $fecha[0]);
    }

} #HomeController
