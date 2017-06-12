@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('comentarios_b-index')) 
			<td>{{ link_to_route('comentarios_b.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('comentarios_b-edit')) 
			<td>{{ link_to_route('comentarios_b.edit', 'Editar', array($comentarios_b->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($comentarios_b, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'comentarios_b/destroy/'.$comentarios_b->id)) }}
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
				<th>Bitacora_seguridad_id</th>
				<th>Comentario</th>
				<th>Costo</th>
				<th>Estatus_id</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Bitacora_seguridad_id</b></td><td>{{{ $comentarios_b->bitacora_seguridad_id }}}</td>
					<td><b>Comentario</b></td><td>{{{ $comentarios_b->comentario }}}</td>
					<td><b>Costo</b></td><td>{{{ $comentarios_b->costo }}}</td>
					<td><b>Estatus_id</b></td><td>{{{ $comentarios_b->estatus_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $comentarios_b->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $comentarios_b->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
