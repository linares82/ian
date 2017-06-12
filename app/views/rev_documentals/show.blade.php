@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('rev_documental-index')) 
			<td>{{ link_to_route('rev_documental.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('rev_documental-edit')) 
			<td>{{ link_to_route('rev_documental.edit', 'Editar', array($rev_documental->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($rev_documental, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'rev_documental/destroy/'.$rev_documental->id)) }}
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
				<td><b>Entidad</b></td><td>{{{ $rev_documental->cia->abreviatura }}}</td>
				<td><b>Año</b></td><td>{{{ $rev_documental->anio }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Mes</b></td><td>{{{ $rev_documental->mes->mes }}}</td>
				<td><b></b></td><td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $rev_documental->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $rev_documental->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $rev_documental->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $rev_documental->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $rev_documental->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
