@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_rr_amb_doc-index')) 
			<td>{{ link_to_route('a_rr_amb_doc.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_rr_amb_doc-edit')) 
			<td>{{ link_to_route('a_rr_amb_doc.edit', 'Editar', array($a_rr_amb_doc->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_rr_amb_doc, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_rr_amb_doc/destroy/'.$a_rr_amb_doc->id)) }}
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
				<th>A_rr_ambiental_id</th>
				<th>Documento</th>
				<th>Archivo</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>A_rr_ambiental_id</b></td><td>{{{ $a_rr_amb_doc->a_rr_ambiental_id }}}</td>
					<td><b>Documento</b></td><td>{{{ $a_rr_amb_doc->documento }}}</td>
					<td><b>Archivo</b></td><td>{{{ $a_rr_amb_doc->archivo }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
