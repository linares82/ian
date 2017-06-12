@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('permissions-index')) 
			<td>{{ link_to_route('permission.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('permissions-edit')) 
			<td>{{ link_to_route('permission.edit', 'Editar', array($permission->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('permissions-destroy')) 
			<td>{{ Form::model($permission, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'permission/destroy/'.$permission->id)) }}
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
					<td style="width:25%"><b>Nombre</b></td>
					<td style="width:25%">{{{ $permission->name }}}</td>
					<td style="width:25%"><b>Valor</b></td>
					<td style="width:25%">{{{ $permission->value }}}</td>
				</tr>
				<tr class="alt">
					<td><b>Descripción</b></td>
					<td>{{{ $permission->description }}}</td>
					<td><b></b></td>
					<td></td>
				</tr>
				<thead>
					<th colspan="4" style="width:100%">Manipulación de registros</th>
				</thead>
				<tr>
					<td><b>F. Alta</b></td>
					<td>{{{ $permission->created_at }}}</td>
					<td style="width:25%"><b>F. Mod.</b></td>
					<td style="width:25%">{{{ $permission->created_at }}}</td>
				</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
