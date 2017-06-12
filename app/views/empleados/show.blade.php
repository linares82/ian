@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('empleado-index')) 
			<td>{{ link_to_route('empleado.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('empleado-edit')) 
			<td>{{ link_to_route('empleado.edit', 'Editar', array($empleado->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($empleado, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'empleado/destroy/'.$empleado->id)) }}
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
				<td><b>C. Interno</b></td>
				<td>{{{ $empleado->ctrl_interno }}}</td>
				<td><b>Nombre</b></td>
				<td>{{{ $empleado->nombre }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Direccion</b></td>
				<td>{{{ $empleado->direccion }}}</td>
				<td><b>Contacto</b></td>
				<td>{{{ $empleado->contacto }}}</td>
			</tr>
			<tr>
				<td><b>Mail</b></td>
				<td>{{{ $empleado->mail }}}</td>
				<td><b>Area</b></td>
				<td>{{{ $empleado->area->area }}}</td>
				
			</tr>
			<tr class="alt">
				<td><b>Puesto</b></td>
				<td>{{{ $empleado->puesto->puesto }}}</td>
				<td><b>Subordinados</b></td>
				<td>{{{ $empleado->bndSubordinados->bnd }}}</td>
			</tr>
			<tr>
				<td><b>Jefe</b></td>
				<td>{{{ ($empleado->jefe_id<>0)?$empleado->jefe->nombre:"" }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
					<th colspan="4" style="width:100%">Manipulación de registros</th>
				</thead>
                <tr class="alt">
					<td><b>U. Alta</b></td>
					<td>{{{ $empleado->uAlta->username }}}</td>
					<td><b>F. Alta</b></td>
					<td>{{{ $empleado->created_at }}}</td>
				</tr>
				<tr>
					<td><b>U. Mod.</b></td>
					<td>{{{ $empleado->uMod->username }}}</td>
					<td><b>F. Mod.</b></td>
					<td>{{{ $empleado->updated_at }}}</td>
				</tr>
				<tr class="alt">
					<td><b>F. Eliminado</b></td>
					<td>{{{ $empleado->deleted_at }}}</td>
					<td><b> </b></td>
					<td> </td>
				</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
