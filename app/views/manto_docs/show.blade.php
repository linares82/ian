@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('manto_doc-index')) 
			<td>{{ link_to_route('manto_doc.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('manto_doc-edit')) 
			<td>{{ link_to_route('manto_doc.edit', 'Editar', array($manto_doc->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($manto_doc, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'manto_doc/destroy/'.$manto_doc->id)) }}
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
				<th>Mantenimiento_id</th>
				<th>Documento</th>
				<th>Archivo</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Mantenimiento_id</b></td><td>{{{ $manto_doc->mantenimiento_id }}}</td>
					<td><b>Documento</b></td><td>{{{ $manto_doc->documento }}}</td>
					<td><b>Archivo</b></td><td>{{{ $manto_doc->archivo }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $manto_doc->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $manto_doc->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
