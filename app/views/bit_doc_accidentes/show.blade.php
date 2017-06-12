@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bit_doc_accidente-index')) 
			<td>{{ link_to_route('bit_doc_accidente.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bit_doc_accidente-edit')) 
			<td>{{ link_to_route('bit_doc_accidente.edit', 'Editar', array($bit_doc_accidente->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bit_doc_accidente, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bit_doc_accidente/destroy/'.$bit_doc_accidente->id)) }}
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
				<th>Bitacora_accidente</th>
				<th>Documento</th>
				<th>Archivo</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Bitacora_accidente</b></td><td>{{{ $bit_doc_accidente->bitacora_accidente }}}</td>
					<td><b>Documento</b></td><td>{{{ $bit_doc_accidente->documento }}}</td>
					<td><b>Archivo</b></td><td>{{{ $bit_doc_accidente->archivo }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
