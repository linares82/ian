@extends('layouts.master')
<!-- Content Header (Page header) -->
@section('contenido1')
<section class="content-header">
	<h1>
		@yield('titulo_pagina')
		<small>@yield('descripcion_pagina')</small>
	</h1>
	<ol class="breadcrumb">
		<li class="active">@yield('brc1')</li>
		<li class="active">@yield('brc2')</li>
		<li class="active">@yield('brc3')</li>
		<li class="active">@yield('brc4')</li>
		<li class="active">@yield('brc5')</li>
		<li class="active">@yield('brc6')</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success">
				@yield('main')
			</div>
		</div>
	</div>
</section><!-- /.content -->
@stop