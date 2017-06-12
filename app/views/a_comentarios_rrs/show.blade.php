@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_comentarios_rr-index')) 
			<td>{{ link_to_route('a_comentarios_rr.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_comentarios_rr-edit')) 
			<td>{{ link_to_route('a_comentarios_rr.edit', 'Editar', array($a_comentarios_rr->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_comentarios_rr, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_comentarios_rr/destroy/'.$a_comentarios_rr->id)) }}
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
				<th>A_rr_id</th>
				<th>Comentario</th>
				<th>A_st_rr_id</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>A_rr_id</b></td><td>{{{ $a_comentarios_rr->a_rr_id }}}</td>
					<td><b>Comentario</b></td><td>{{{ $a_comentarios_rr->comentario }}}</td>
					<td><b>A_st_rr_id</b></td><td>{{{ $a_comentarios_rr->a_st_rr_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $a_comentarios_rr->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $a_comentarios_rr->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
