@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('ca_aa_doc-index')) 
			<td>{{ link_to_route('ca_aa_doc.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('ca_aa_doc-edit')) 
			<td>{{ link_to_route('ca_aa_doc.edit', 'Editar', array($ca_aa_doc->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($ca_aa_doc, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'ca_aa_doc/destroy/'.$ca_aa_doc->id)) }}
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
				<td><b>Material</b></td>
				<td>{{{ $ca_aa_doc->Material->material }}}</td>
				<td><b>Categoria</b></td>
				<td>{{{ $ca_aa_doc->Categoria->categoria }}}</td>
			<tr class="alt">
				<td><b>Documento</b></td>
				<td>{{{ $ca_aa_doc->doc }}}</td>
				<td><b></b></td>
				<td></td>
			
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $ca_aa_doc->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $ca_aa_doc->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $ca_aa_doc->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $ca_aa_doc->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $ca_aa_doc->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
