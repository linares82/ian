@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('s_estatus_procedimiento-index')) 
			<td>{{ link_to_route('s_estatus_procedimiento.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('s_estatus_procedimiento-edit')) 
			<td>{{ link_to_route('s_estatus_procedimiento.edit', 'Editar', array($s_estatus_procedimiento->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($s_estatus_procedimiento, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 's_estatus_procedimiento/destroy/'.$s_estatus_procedimiento->id)) }}
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
			<tr>
				<th>Estatus</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Estatus</b></td><td>{{{ $s_estatus_procedimiento->estatus }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $s_estatus_procedimiento->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $s_estatus_procedimiento->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
