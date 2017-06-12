@extends('layouts.tabs')

@section('contenido_tab')

 <div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
 
	<div class="datagrid">
		
	<table>
	<tr><td> <h3>Informe de Impacto Ambiental</h3> </td></tr>
	<tr><td>Cliente: {{{ $enc_impacto->cliente->cliente }}} </td></tr>
	<tr><td>Tipo de Impacto: {{{ $enc_impacto->tipoImpacto->tipo_impacto }}} </td></tr>
	<tr><td>Fecha: {{{ $enc_impacto->fecha }}}</td></tr>
	</table>
	
	@foreach($enc_impacto->regImpactos as $reg_impacto)
	<table>
		<thead>
			<th class="alt" colspan="5">
				<table width="100%">
					<th><td>Factor:{{{ $reg_impacto->factor->factor }}} </td></th>
					<th><td>Rubro:{{{ $reg_impacto->rubro->rubro }}} </td></th>
					<th><td>Especifico:{{{ $reg_impacto->especifico->especifico }}}</td></th>
				</table>
			</th>
		</thead>
		<tbody>
		<tr class="alt">
			<td style="width:16%">Caracteristica</td>
			<td style="width:16%">Ponderación del Impacto</td>
			<td style="width:22%">Descripción</td>
			<td style="width:22%">Resarción</td>
			<td style="width:24%">Evaluación</td>
			<!-- <td>Duración de la Acción</td>
			<td>Continuidad del Efecto</td>
			<td>Reversibilidad</td>
			<td>Probabilidad</td>
			<td>Mitigación del Efecto</td>
			<td>Intensidad del Impacto</td> -->
		</tr>
		@foreach($reg_impacto->lnCaracteristicas as $ln_caracteristica)
			@if($ln_caracteristica->efecto_id<>1)
			<tr>
				<td>{{{ $ln_caracteristica->caracteristica->caracteristica }}}</td>
				<td>{{{ $ln_caracteristica->efecto->efecto." - ".$ln_caracteristica->efecto->descripcion }}}</td>
				<td>{{{ $ln_caracteristica->descripcion }}}</td>
				<td>{{{ $ln_caracteristica->resarcion }}}</td>
				<td>
					<table>
						<tr><td>Emisión del Efecto: {{{ $ln_caracteristica->emisionEfecto->emision_efecto }}} </td></tr>
						<tr><td>Duración de la Acción: {{{ $ln_caracteristica->duracionAccion->duracion_accion }}}</td></tr>
						<tr><td>Continuidad del Efecto: {{{ $ln_caracteristica->continuidadEfecto->continuidad_efecto }}}</td></tr>
						<tr><td>Reversibillidad: {{{ $ln_caracteristica->reversibilidad->reversibilidad }}}</td></tr>
						<tr><td>Probabilidad: {{{ $ln_caracteristica->probabilidad->probabilidad }}}</td></tr>
						<tr><td>Mitigación del Efecto: {{{ $ln_caracteristica->mitigacion->mitigacion }}}</td></tr>
						<tr><td>Intensidad del Impacto: {{{ $ln_caracteristica->intensidadImpacto->intensidad_impacto }}}</td></tr>
					</table>
				</td>
			</tr>
			@endif
		@endforeach
		</tbody>
	</table>
	@endforeach
	<table >
		<thead><tr class="alt"><th> Segmento </th> <th> Total </th> <th> Porcentaje </th></tr></thead>
		@foreach($segmentos as $s)
		<tr><td> {{{ $s->efecto }}} </td> <td> {{{ $s->total }}} </td> <td> {{{ round(($s->total*100)/$total, 2) }}} % </td></tr>
		@endforeach
		<tr><td><b> Total </b></td> <td> {{{ $total }}} </td> <td> {{{ ($total*100)/$total }}} % </td> </tr>
	</table>
	</div>
</div>
</div>

@stop
