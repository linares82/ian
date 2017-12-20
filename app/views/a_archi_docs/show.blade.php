@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_archi_doc-index')) 
			<td>{{ link_to_route('a_archi_doc.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_archi_doc-edit')) 
			<td>{{ link_to_route('a_archi_doc.edit', 'Editar', array($a_archi_doc->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_archi_doc, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_archi_doc/destroy/'.$a_archi_doc->id)) }}
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
				<th>A_archivo_id</th>
				<th>Documento</th>
				<th>Archivo</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>A_archivo_id</b></td><td>{{{ $a_archi_doc->a_archivo_id }}}</td>
					<td><b>Documento</b></td><td>{{{ $a_archi_doc->documento }}}</td>
					<td><b>Archivo</b></td><td>{{{ $a_archi_doc->archivo }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $a_archi_doc->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $a_archi_doc->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
