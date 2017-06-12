@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_comentarios_nc-index')) 
			<td>{{ link_to_route('a_comentarios_nc.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_comentarios_nc-edit')) 
			<td>{{ link_to_route('a_comentarios_nc.edit', 'Editar', array($a_comentarios_nc->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_comentarios_nc, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_comentarios_nc/destroy/'.$a_comentarios_nc->id)) }}
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
				<th>No_confomrmidad_id</th>
				<th>Comentario</th>
				<th>Costo</th>
				<th>Estatus_id</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>No_confomrmidad_id</b></td><td>{{{ $a_comentarios_nc->no_confomrmidad_id }}}</td>
					<td><b>Comentario</b></td><td>{{{ $a_comentarios_nc->comentario }}}</td>
					<td><b>Costo</b></td><td>{{{ $a_comentarios_nc->costo }}}</td>
					<td><b>Estatus_id</b></td><td>{{{ $a_comentarios_nc->estatus_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $a_comentarios_nc->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $a_comentarios_nc->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
