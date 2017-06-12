@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora_accidente-index')) 
			<td>{{ link_to_route('bitacora_accidente.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora_accidente-edit')) 
			<td>{{ link_to_route('bitacora_accidente.edit', 'Editar', array($bitacora_accidente->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora_accidente, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora_accidente/destroy/'.$bitacora_accidente->id)) }}
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
				<td><b>Area</b></td>
				<td>{{{ $bitacora_accidente->area->area }}}</td>
				<td><b>Responsable</b></td>
				<td>{{{ $bitacora_accidente->responsable->nombre }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Persona</b></td>
				<td>{{{ $bitacora_accidente->persona->nombre }}}</td>
				<td><b>Accidente</b></td>
				<td>{{{ $bitacora_accidente->accidente->accidente }}}</td>
			</tr>
			<tr>
				<td><b>Descripcion</b></td>
				<td>{{{ $bitacora_accidente->descripcion }}}</td>
				<td><b>Procedimiento</b></td>
				<td>{{{ $bitacora_accidente->procedimiento }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Accion</b></td>
				<td>{{{ $bitacora_accidente->accion->accion }}}</td>
				<td><b>Investigacion</b></td>
				<td>{{{ $bitacora_accidente->investigacion }}}</td>
			</tr>
			<tr>
				<td><b>Costo_directo</b></td>
				<td>{{{ $bitacora_accidente->costo_directo }}}</td>
				<td><b>Costo_indirecto</b></td>
				<td>{{{ $bitacora_accidente->costo_indirecto }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Fecha</b></td>
				<td>{{{ $bitacora_accidente->fecha }}}</td>
				<td><b>Turno</b></td>
				<td>{{{ $bitacora_accidente->turno->turno }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $bitacora_accidente->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $bitacora_accidente->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $bitacora_accidente->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $bitacora_accidente->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $bitacora_accidente->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
