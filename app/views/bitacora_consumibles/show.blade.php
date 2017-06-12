@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora_consumible-index')) 
			<td>{{ link_to_route('bitacora_consumible.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora_consumible-edit')) 
			<td>{{ link_to_route('bitacora_consumible.edit', 'Editar', array($bitacora_consumible->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora_consumible, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora_consumible/destroy/'.$bitacora_consumible->id)) }}
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
				<td><b>Consumible_id</b></td>
				<td>{{{ $bitacora_consumible->consumible->consumible }}}</td>
				<td><b>Consumo</b></td>
				<td>{{{ $bitacora_consumible->consumo }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Fecha Lectura</b></td>
				<td>{{{ $bitacora_consumible->fecha }}}</td>
				<td><b>Costo</b></td>
				<td>{{{ $bitacora_consumible->costo }}}</td>
			</tr>
			<tr>
				<td><b>Periodo De:</b></td>
				<td>{{{ $bitacora_consumible-> fec_inicio }}}</td>
				<td><b>Periodo A:</b></td>
				<td>{{{ $bitacora_consumible->fec_fin }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>F. Ambiental</b></td>
				<td>{{{ $bitacora_consumible->factor_indicador }}}</td>
				<td><b>I. Ambiental</b></td>
				<td>{{{ $bitacora_consumible->factor_calculado }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $bitacora_consumible->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $bitacora_consumible->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $bitacora_consumible->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $bitacora_consumible->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $bitacora_consumible->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
