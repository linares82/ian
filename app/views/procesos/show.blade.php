@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('proceso-index')) 
			<td>{{ link_to_route('proceso.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('proceso-edit')) 
			<td>{{ link_to_route('proceso.edit', 'Editar', array($proceso->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($proceso, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'proceso/destroy/'.$proceso->id)) }}
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
				<th>Proceso</th>
				<th>Detalle</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Proceso</b></td><td>{{{ $proceso->proceso }}}</td>
					<td><b>Detalle</b></td><td>{{{ $proceso->detalle }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $proceso->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $proceso->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
