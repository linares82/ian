@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('cs_tpo_deteccion-index')) 
			<td>{{ link_to_route('cs_tpo_deteccion.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('cs_tpo_deteccion-edit')) 
			<td>{{ link_to_route('cs_tpo_deteccion.edit', 'Editar', array($cs_tpo_deteccion->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($cs_tpo_deteccion, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'cs_tpo_deteccion/destroy/'.$cs_tpo_deteccion->id)) }}
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
				<th>Tpo_deteccion</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Tpo_deteccion</b></td><td>{{{ $cs_tpo_deteccion->tpo_deteccion }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $cs_tpo_deteccion->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $cs_tpo_deteccion->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
