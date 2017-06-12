@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('imp_potencial-index')) 
			<td>{{ link_to_route('imp_potencial.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('imp_potencial-edit')) 
			<td>{{ link_to_route('imp_potencial.edit', 'Editar', array($imp_potencial->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($imp_potencial, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'imp_potencial/destroy/'.$imp_potencial->id)) }}
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
				<th>Imp_potencial</th>
				<th>Descripcion</th>
				<th>Usu_mod_id</th>
				<th>Usu_alta_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Imp_potencial</b></td><td>{{{ $imp_potencial->imp_potencial }}}</td>
					<td><b>Descripcion</b></td><td>{{{ $imp_potencial->descripcion }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $imp_potencial->usu_mod_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $imp_potencial->usu_alta_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
