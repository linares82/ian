@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('m_imp_potencial-index')) 
			<td>{{ link_to_route('m_imp_potencial.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('m_imp_potencial-edit')) 
			<td>{{ link_to_route('m_imp_potencial.edit', 'Editar', array($m_imp_potencial->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($m_imp_potencial, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'm_imp_potencial/destroy/'.$m_imp_potencial->id)) }}
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
				<th>Efecto_id</th>
				<th>Duracion_accion_id</th>
				<th>Imp_potencia_id</th>
				<th>Usu_mod_id</th>
				<th>Usu_alta_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Efecto_id</b></td><td>{{{ $m_imp_potencial->efecto_id }}}</td>
					<td><b>Duracion_accion_id</b></td><td>{{{ $m_imp_potencial->duracion_accion_id }}}</td>
					<td><b>Imp_potencia_id</b></td><td>{{{ $m_imp_potencial->imp_potencia_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $m_imp_potencial->usu_mod_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $m_imp_potencial->usu_alta_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
