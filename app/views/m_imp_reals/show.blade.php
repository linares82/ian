@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('m_imp_real-index')) 
			<td>{{ link_to_route('m_imp_real.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('m_imp_real-edit')) 
			<td>{{ link_to_route('m_imp_real.edit', 'Editar', array($m_imp_real->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($m_imp_real, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'm_imp_real/destroy/'.$m_imp_real->id)) }}
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
				<th>Probabilidad_id</th>
				<th>Imp_real_id</th>
				<th>Usu_mod_id</th>
				<th>Usu_alta_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Efecto_id</b></td><td>{{{ $m_imp_real->efecto_id }}}</td>
					<td><b>Probabilidad_id</b></td><td>{{{ $m_imp_real->probabilidad_id }}}</td>
					<td><b>Imp_real_id</b></td><td>{{{ $m_imp_real->imp_real_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $m_imp_real->usu_mod_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $m_imp_real->usu_alta_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
