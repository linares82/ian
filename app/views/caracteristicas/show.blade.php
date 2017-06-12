@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('caracteristica-index')) 
			<td>{{ link_to_route('caracteristica.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('caracteristica-edit')) 
			<td>{{ link_to_route('caracteristica.edit', 'Editar', array($caracteristica->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($caracteristica, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'caracteristica/destroy/'.$caracteristica->id)) }}
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
			<tr class="alt">
					<td><b>caracteristica</b></td>
					<td>{{{ $caracteristica->caracteristica }}}</td>
					<td><b></b></td>
					<td></td>
				</tr>
				<thead>
					<th colspan="4" style="width:100%">Manipulación de registros</th>
				</thead>
                <tr class="alt">
					<td><b>U. Alta</b></td>
					<td>{{{ $caracteristica->uAlta->username }}}</td>
					<td><b>F. Alta</b></td>
					<td>{{{ $caracteristica->created_at }}}</td>
				</tr>
				<tr>
					<td><b>U. Mod.</b></td>
					<td>{{{ $caracteristica->uMod->username }}}</td>
					<td><b>F. Mod.</b></td>
					<td>{{{ $caracteristica->updated_at }}}</td>
				</tr>
				<tr class="alt">
					<td><b>F. Eliminado</b></td>
					<td>{{{ $caracteristica->deleted_at }}}</td>
					<td><b> </b></td>
					<td> </td>
				</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
