@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('s_comentarios_registro-index')) 
			<td>{{ link_to_route('s_comentarios_registro.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('s_comentarios_registro-edit')) 
			<td>{{ link_to_route('s_comentarios_registro.edit', 'Editar', array($s_comentarios_registro->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($s_comentarios_registro, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 's_comentarios_registro/destroy/'.$s_comentarios_registro->id)) }}
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
				<th>S_registros_id</th>
				<th>Comentario</th>
				<th>Estatus_id</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>S_registros_id</b></td><td>{{{ $s_comentarios_registro->s_registros_id }}}</td>
					<td><b>Comentario</b></td><td>{{{ $s_comentarios_registro->comentario }}}</td>
					<td><b>Estatus_id</b></td><td>{{{ $s_comentarios_registro->estatus_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $s_comentarios_registro->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $s_comentarios_registro->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
