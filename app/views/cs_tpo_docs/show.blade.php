@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('cs_tpo_doc-index')) 
			<td>{{ link_to_route('cs_tpo_doc.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('cs_tpo_doc-edit')) 
			<td>{{ link_to_route('cs_tpo_doc.edit', 'Editar', array($cs_tpo_doc->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($cs_tpo_doc, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'cs_tpo_doc/destroy/'.$cs_tpo_doc->id)) }}
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
				<td><b>T. Procedimiento</b></td>
				<td>{{{ $cs_tpo_doc->tpoProcedimiento->tpo_procedimiento }}}</td>
				<td><b>T. Documento</b></td>
				<td>{{{ $cs_tpo_doc->tpo_doc }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $cs_tpo_doc->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $cs_tpo_doc->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $cs_tpo_doc->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $cs_tpo_doc->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $cs_tpo_doc->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
