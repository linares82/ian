@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('r_documento-index')) 
			<td>{{ link_to_route('r_documento.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('r_documento-edit')) 
			<td>{{ link_to_route('r_documento.edit', 'Editar', array($r_documento->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($r_documento, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'r_documento/destroy/'.$r_documento->id)) }}
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
			<th colspan="4" style="width:100%">Información</th>
		</thead>

		<tbody>
			<tr>
				<td><b>T. Documento</b></td><td>{{{ $r_documento->tpoDocumento->tpo_documento }}}</td>
				<td><b>Rocumento</b></td><td>{{{ $r_documento->r_documento }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $r_documento->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $r_documento->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $r_documento->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $r_documento->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $r_documento->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
