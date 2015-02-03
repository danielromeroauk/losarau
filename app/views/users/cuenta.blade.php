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
            @if(Session::has('users_no_registrados'))
				<div class="alert alert-danger">
					<ul>
					@foreach(Session::get('users_no_registrados') as $u)
						<li>{{$u}}</li>
					@endforeach
					</ul>
				</div>
			@endif
        </ul>

        <h2>Estado</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th class="text-right">Vencido</th>
                    <th class="text-right">No vencido</th>
                </tr>
            </thead>
            <tbody>
               @foreach($user->estados as $estado)
                <tr>
                    <td>{{ $estado->concepto }}</td>
                    <td class="text-right">
                    	{{ is_numeric($estado->vencido) ? number_format($estado->vencido, 0, ',', '.') : 0 }}
                    </td>
                    <td class="text-right">
                    	{{ is_numeric($estado->no_vencido) ? number_format($estado->no_vencido, 0, ',', '.') : 0 }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Pagos</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Forma de pago</th>
                    <th class="text-right">Seguro</th>
                    <th class="text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->pagos as $pago)
                <tr>
                    <td>{{ date_format(new DateTime($pago->fecha_pago), 'Y-m-d') }}</td>
                    <td>{{ $pago->forma_pago }}</td>
                    <td class="text-right">
                    	{{ is_numeric($pago->seguro) ? number_format($pago->seguro, 0, ',', '.') : 0 }}
                    </td>
                    <td class="text-right">
                    	{{ is_numeric($pago->valor) ? number_format($pago->valor, 0, ',', '.') : 0 }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@stop