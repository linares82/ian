@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('estatus_requisito-index')) 
			<td>{{ link_to_route('estatus_requisito.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('estatus_requisito-edit')) 
			<td>{{ link_to_route('estatus_requisito.edit', 'Editar', array($estatus_requisito->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($estatus_requisito, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'estatus_requisito/destroy/'.$estatus_requisito->id)) }}
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
				<td><b>Estatus</b></td><td>{{{ $estatus_requisito->estatus }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $estatus_requisito->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $estatus_requisito->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
