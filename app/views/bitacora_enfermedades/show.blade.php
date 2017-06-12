@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora_enfermedade-index')) 
			<td>{{ link_to_route('bitacora_enfermedade.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora_enfermedade-edit')) 
			<td>{{ link_to_route('bitacora_enfermedade.edit', 'Editar', array($bitacora_enfermedade->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora_enfermedade, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora_enfermedade/destroy/'.$bitacora_enfermedade->id)) }}
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
				<td>{{{ $bitacora_enfermedade->area->area }}}</td>
				<td><b>Persona</b></td>
				<td>{{{ $bitacora_enfermedade->persona->nombre }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Enfermedad</b></td>
				<td>{{{ $bitacora_enfermedade->enfermedad->enfermedad }}}</td>
				<td><b>Descripcion</b></td>
				<td>{{{ $bitacora_enfermedade->descripcion }}}</td>
			</tr>
			<tr>
				<td><b>Accion</b></td>
				<td>{{{ $bitacora_enfermedade->accion->accion }}}</td>
				<td><b>Costo Directo</b></td>
				<td>{{{ $bitacora_enfermedade->costo_directo }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Costo Indirecto</b></td>
				<td>{{{ $bitacora_enfermedade->costo_indirecto }}}</td>
				<td><b>Fecha</b></td>
				<td>{{{ $bitacora_enfermedade->fecha }}}</td>
			</tr>
			<tr>
				<td><b>Turno</b></td>
				<td>{{{ $bitacora_enfermedade->turno->turno }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $bitacora_enfermedade->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $bitacora_enfermedade->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $bitacora_enfermedade->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $bitacora_enfermedade->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $bitacora_enfermedade->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
