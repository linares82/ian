@extends('layouts.master2')
@section('titulo')
SIAM
@stop
@section('contenido1')
	<div class="welcome" style="padding:30px;">
		<h1>Bienvenido.</h1>
	</div>
	<div class="welcome" style="width:300px;margin:0 auto">
		<img src="{{ asset('uploads/cias/'.$logo) }}" style="width:300px"/>
	</div>
	<div class="welcome" style="width:300px;margin:0 auto; text-align:center">
		<h3 style="">Tu eres la pieza mas importante de este sistema</h3>
	</div>

@stop
