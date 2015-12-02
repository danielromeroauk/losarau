@extends('layouts.master')

@section('title')
    Estado de mi cuenta
@stop

@section('contenido')
    <section class="container">
        <h1>Mi cuenta</h1>
        <ul class="list-group">
            <li class="list-group-item">
                Cédula: {{ $user->nit }}
            </li>
            <li class="list-group-item">
                Nombre: {{ $user->nombre }}
            </li>
            <li class="list-group-item">
                Fecha de corte: @include('users.fecha_corte')
            </li>
            @if(Session::has('mensaje'))
            <li class="list-group-item">
           		<p class="text-success">{{Session::get('mensaje')}}</p>
			</li>
            @endif
            @if(Session::has('users_no_registrados') && count(Session::get('users_no_registrados')) > 0)
				<div class="alert alert-danger">
				    <h3>Usuarios que no estaban registrados</h3>
					<ul>
					@foreach(Session::get('users_no_registrados') as $u)
						<li>{{$u}}</li>
					@endforeach
					</ul>
				</div>
			@endif
        </ul>

        @if(count($estados) > 0 )
            <h2>Estado</h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Pagaré</th>
                        <th>Estado</th>
                        <th class="text-right">Capital</th>
                        <th class="text-right">Intereses</th>
                        <th class="text-right">Mora</th>
                        <th class="text-right">Seguro</th>
                        <th class="text-right">IDiferido</th>
                        <th class="text-right">Asistencia</th>
                        <th class="text-right">Cinversión</th>
                        <th class="text-right">ICausado</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($estados as $estado)
                    <tr>
                        <td>{{ $estado->pagare }}</td>
                        <td>{{ $estado->estado }}</td>
                        <td class="text-right">
                            {{ is_numeric($estado->capital) ? number_format($estado->capital, 0, ',', '.') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ is_numeric($estado->intereses) ? number_format($estado->intereses, 0, ',', '.') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ is_numeric($estado->mora) ? number_format($estado->mora, 0, ',', '.') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ is_numeric($estado->seguro) ? number_format($estado->seguro, 0, ',', '.') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ is_numeric($estado->idiferido) ? number_format($estado->idiferido, 0, ',', '.') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ is_numeric($estado->asistencia) ? number_format($estado->asistencia, 0, ',', '.') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ is_numeric($estado->cinversion) ? number_format($estado->cinversion, 0, ',', '.') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ is_numeric($estado->icausado) ? number_format($estado->icausado, 0, ',', '.') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ is_numeric($estado->total) ? number_format($estado->total, 0, ',', '.') : 0 }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if(count($abonos) > 0)
            <h2>Abonos</h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Fecha de pago</th>
                        <th class="text-right">Valor</th>
                        <th>Forma de pago</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($abonos as $abono)
                    <tr>
                        <td>{{ date_format(new DateTime($abono->fecha_pago), 'Y-m-d') }}</td>
                        <td class="text-right">
                            {{ is_numeric($abono->valor) ? number_format($abono->valor, 0, ',', '.') : 0 }}
                        </td>
                        <td>{{ $abono->forma_pago }}</td>
                        <td class="text-right">
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
    </section>
@stop