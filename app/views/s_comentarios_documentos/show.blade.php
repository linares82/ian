@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('s_comentarios_documento-index')) 
			<td>{{ link_to_route('s_comentarios_documento.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('s_comentarios_documento-edit')) 
			<td>{{ link_to_route('s_comentarios_documento.edit', 'Editar', array($s_comentarios_documento->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($s_comentarios_documento, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 's_comentarios_documento/destroy/'.$s_comentarios_documento->id)) }}
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
				<th>S_documento_id</th>
				<th>Comentario</th>
				<th>Estatus_id</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>S_documento_id</b></td><td>{{{ $s_comentarios_documento->s_documento_id }}}</td>
					<td><b>Comentario</b></td><td>{{{ $s_comentarios_documento->comentario }}}</td>
					<td><b>Estatus_id</b></td><td>{{{ $s_comentarios_documento->estatus_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $s_comentarios_documento->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $s_comentarios_documento->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
