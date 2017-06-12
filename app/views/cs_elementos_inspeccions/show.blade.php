@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('cs_elementos_inspeccion-index')) 
			<td>{{ link_to_route('cs_elementos_inspeccion.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('cs_elementos_inspeccion-edit')) 
			<td>{{ link_to_route('cs_elementos_inspeccion.edit', 'Editar', array($cs_elementos_inspeccion->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($cs_elementos_inspeccion, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'cs_elementos_inspeccion/destroy/'.$cs_elementos_inspeccion->id)) }}
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
				<td><b>Grupo Norma</b></td>
				<td>{{{ $cs_elementos_inspeccion->grupoNorma->grupo_norma }}}</td>
				<td><b>Norma</b></td>
				<td>{{{ $cs_elementos_inspeccion->normaVinculada->norma }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Elemento</b></td>
				<td>{{{ $cs_elementos_inspeccion->elemento }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $cs_elementos_inspeccion->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $cs_elementos_inspeccion->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $cs_elementos_inspeccion->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $cs_elementos_inspeccion->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $cs_elementos_inspeccion->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
