@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('imp_real-index')) 
			<td>{{ link_to_route('imp_real.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('imp_real-edit')) 
			<td>{{ link_to_route('imp_real.edit', 'Editar', array($imp_real->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($imp_real, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'imp_real/destroy/'.$imp_real->id)) }}
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
				<th>Imp_real</th>
				<th>Descripcion</th>
				<th>Usu_mod_id</th>
				<th>Usu_alta_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Imp_real</b></td><td>{{{ $imp_real->imp_real }}}</td>
					<td><b>Descripcion</b></td><td>{{{ $imp_real->descripcion }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $imp_real->usu_mod_id }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $imp_real->usu_alta_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
