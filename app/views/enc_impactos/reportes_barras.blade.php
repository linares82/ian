@extends('layouts.tabs')

@section('contenido_tab')
	
	{{ link_to_route('enc_impacto.index', 'Regresar', '', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }} 
	<iframe src="{{ asset('reportes/enc_impacto/enc_impacto_barras.pdf') }}" style="width:100%; height:500px" frameborder="0"> </iframe>
		
@stop
@stop