@extends('layouts.master')

@section('contenido')

<div class="container">
	{{Form::open([
		'route' => 'subir_archivo',
		'files' => true,
		'class' => 'dropzone',
		'id' => 'my-dropzone',
		'method' => 'POST'
	])}}

	{{Form::close()}}
</div>

@stop

@section('javascript')

@parent

{{HTML::style('packages/dropzone/css/dropzone.css')}}
{{HTML::script('packages/dropzone/dropzone.min.js')}}

<script>
Dropzone.options.myDropzone = {
	autoProcessQueue: true
};
</script>

@stop