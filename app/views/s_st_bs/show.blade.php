@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('s_st_b-index')) 
			<td>{{ link_to_route('s_st_b.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('s_st_b-edit')) 
			<td>{{ link_to_route('s_st_b.edit', 'Editar', array($s_st_b->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($s_st_b, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 's_st_b/destroy/'.$s_st_b->id)) }}
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
				<td><b>Estatus</b></td><td>{{{ $s_st_b->estatus }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $s_st_b->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $s_st_b->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
