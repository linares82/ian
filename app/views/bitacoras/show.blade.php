@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora-index')) 
			<td>{{ link_to_route('bitacora.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora-edit')) 
			<td>{{ link_to_route('bitacora.edit', 'Editar', array($bitacora->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora/destroy/'.$bitacora->id)) }}
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
				<th>Bitacora</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Bitacora</b></td><td>{{{ $bitacora->bitacora }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $bitacora->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $bitacora->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
