@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('m_tpo_riesgo-index')) 
			<td>{{ link_to_route('m_tpo_riesgo.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('m_tpo_riesgo-edit')) 
			<td>{{ link_to_route('m_tpo_riesgo.edit', 'Editar', array($m_tpo_riesgo->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($m_tpo_riesgo, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'm_tpo_riesgo/destroy/'.$m_tpo_riesgo->id)) }}
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
				<th>Tpo_riesgo</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Tpo_riesgo</b></td><td>{{{ $m_tpo_riesgo->tpo_riesgo }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $m_tpo_riesgo->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $m_tpo_riesgo->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
