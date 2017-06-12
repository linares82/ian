@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('ca_consumible-index')) 
			<td>{{ link_to_route('ca_consumible.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('ca_consumible-edit')) 
			<td>{{ link_to_route('ca_consumible.edit', 'Editar', array($ca_consumible->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($ca_consumible, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'ca_consumible/destroy/'.$ca_consumible->id)) }}
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
				<td><b>Consumible</b></td>
				<td>{{{ $ca_consumible->consumible }}}</td>
				<td><b>Unidad</b></td>
				<td>{{{ $ca_consumible->unidad }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $ca_consumible->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $ca_consumible->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $ca_consumible->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $ca_consumible->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $ca_consumible->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
