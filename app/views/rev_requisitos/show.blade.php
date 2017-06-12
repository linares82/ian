@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('rev_requisito-index')) 
			<td>{{ link_to_route('rev_requisito.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('rev_requisito-edit')) 
			<td>{{ link_to_route('rev_requisito.edit', 'Editar', array($rev_requisito->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($rev_requisito, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'rev_requisito/destroy/'.$rev_requisito->id)) }}
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
				<td><b>Entidad</b></td><td>{{{ $rev_requisito->cia->abreviatura }}}</td>
				<td><b>Año</b></td><td>{{{ $rev_requisito->anio }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Mes</b></td><td>{{{ $rev_requisito->mes->mes }}}</td>
				<td><b></b></td><td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $rev_requisito->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $rev_requisito->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $rev_requisito->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $rev_requisito->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $rev_requisito->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
