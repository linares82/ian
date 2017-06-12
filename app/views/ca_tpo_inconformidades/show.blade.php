@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('ca_tpo_inconformidad-index')) 
			<td>{{ link_to_route('ca_tpo_inconformidad.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('ca_tpo_inconformidad-edit')) 
			<td>{{ link_to_route('ca_tpo_inconformidad.edit', 'Editar', array($ca_tpo_inconformidade->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($ca_tpo_inconformidade, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'ca_tpo_inconformidad/destroy/'.$ca_tpo_inconformidade->id)) }}
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
				<td><b>T. Inconformidad</b></td>
				<td>{{{ $ca_tpo_inconformidade->tpo_inconformidad }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $ca_tpo_inconformidade->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $ca_tpo_inconformidade->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $ca_tpo_inconformidade->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $ca_tpo_inconformidade->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $ca_tpo_inconformidade->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
