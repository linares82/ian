@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('reg_impacto-index')) 
			<td>{{ link_to_route('reg_impacto.index', 'Lista', array('id'=>$reg_impacto->enc_impacto_id), array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('reg_impacto-edit')) 
			<td>{{ link_to_route('reg_impacto.edit', 'Editar', array($reg_impacto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($reg_impacto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'reg_impacto/destroy/'.$reg_impacto->id)) }}
				{{ Form::submit('Eliminar', array('class' => 'easyui-linkbutton', 'style'=>'height:32px;width:100px;')) }}
				{{ Form::close() }}
			</td>
			@endif
		</tr>
	</table>

	<br/>

	<div class="datagrid">
	<table>
		<thead>
			<th colspan="4" style="width:100%">Información</th>
		</thead>

		<tbody>
			<tr>
				<td style="width:25%"><b>Factor</b></td>
				<td style="width:25%">{{{ $reg_impacto->factor->factor }}}</td>
				<td style="width:25%"><b>Rubro</b></td>
				<td style="width:25%">{{{ $reg_impacto->rubro->rubro }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Especifico</b></td>
				<td>{{{ $reg_impacto->especifico->especifico }}}</td>
				<td><b>Caracteristica</b></td>
				
			</tr>
			<tr class="alt">
				<td><b>Descripción</b></td>
				<td>{{{ $reg_impacto->descripcion }}}</td>
				<td><b>Medida de Resarción</b></td>
				<td>{{{ $reg_impacto->resarcion }}}</td>
			</tr>
			<tr>
				
				<td style="width:25%"><b>Emisión del efecto</b></td>
				<td style="width:25%">{{{ $reg_impacto->emisionEfecto->emision_efecto }}}</td>
				<td><b>Duración de la Acción</b></td>
				<td>{{{ $reg_impacto->duracionAccion->duracion_accion }}}</td>
			</tr>
			<tr class="alt">
				
				<td><b>Continuidad del Efecto</b></td>
				<td>{{{ $reg_impacto->continuidadEfecto->continuidad_efecto }}}</td>
				<td style="width:25%"><b>Reversibilidad</b></td>
				<td style="width:25%">{{{ $reg_impacto->reversibilidad->reversibilidad }}}</td>
			</tr>
			<tr>
				
				<td style="width:25%"><b>Probabilidad</b></td>
				<td style="width:25%">{{{ $reg_impacto->probabilidad->probabilidad }}}</td>
				<td><b>Sucept. de Mitigación </b></td>
				<td>{{{ $reg_impacto->mitigacion->mitigacion }}}</td>
			</tr>
			<tr class="alt">
				
				<td><b>Intensidad del Impacto</b></td>
				<td>{{{ $reg_impacto->intensidadImpacto->intensidad_impacto }}}</td>
				<td style="width:25%"><b>Reversibilidad</b></td>
				<td style="width:25%">{{{ $reg_impacto->reversibilidad->reversibilidad }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $reg_impacto->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $reg_impacto->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $reg_impacto->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $reg_impacto->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $reg_impacto->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
