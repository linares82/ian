@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_comentarios_pendiente-index')) 
			<td>{{ link_to_route('a_comentarios_pendiente.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_comentarios_pendiente-edit')) 
			<td>{{ link_to_route('a_comentarios_pendiente.edit', 'Editar', array($a_comentarios_pendiente->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_comentarios_pendiente, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_comentarios_pendiente/destroy/'.$a_comentarios_pendiente->id)) }}
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
				<th>Pendiente_id</th>
				<th>Comentario</th>
				<th>Estatus_id</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Pendiente_id</b></td><td>{{{ $a_comentarios_pendiente->pendiente_id }}}</td>
					<td><b>Comentario</b></td><td>{{{ $a_comentarios_pendiente->comentario }}}</td>
					<td><b>Estatus_id</b></td><td>{{{ $a_comentarios_pendiente->estatus_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $a_comentarios_pendiente->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $a_comentarios_pendiente->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
