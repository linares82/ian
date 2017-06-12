@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('groups-index')) 
			<td>{{ link_to_route('group.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('groups-edit')) 
			<td>{{ link_to_route('group.edit', 'Editar', array($group->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('group-destroy')) 
			<td>{{ Form::model($group, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'group/destroy/'.$group->id)) }}
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
					<td style="width:25%">{{{ $group->name }}}</td>
					<td style="width:25%"><b></b></td>
					<td style="width:25%"></td>
				</tr>
				<tr class="alt">
					<td style="width:25%"><b>Permisos</b></td>
					<td>
					@foreach($groupPermissions as $permission)
							{{{ $permission->name }}}
						<br/>
					@endforeach
					</td>
					<td style="width:25%"><b></b></td>
					<td style="width:25%"></td>
				</tr>
				<thead>
					<th colspan="4" style="width:100%">Manipulación de registros</th>
				</thead>
				<tr>
					<td><b>F. Alta</b></td>
					<td>{{{ $group->created_at }}}</td>
					<td style="width:25%"><b>F. Mod.</b></td>
					<td style="width:25%">{{{ $group->created_at }}}</td>
				</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
