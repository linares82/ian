@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('m_estatus-index')) 
			<td>{{ link_to_route('m_estatus.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('m_estatus-edit')) 
			<td>{{ link_to_route('m_estatus.edit', 'Editar', array($m_estatus->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($m_estatus, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'm_estatus/destroy/'.$m_estatus->id)) }}
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
				<th>Usu_mod_id</th>
				<th>Usu_alta_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Estatus</b></td><td>{{{ $m_estatus->estatus }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $m_estatus->usu_mod_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $m_estatus->usu_alta_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
