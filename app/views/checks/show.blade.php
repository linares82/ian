@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('check-index')) 
			<td>{{ link_to_route('check.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('check-edit')) 
			<td>{{ link_to_route('check.edit', 'Editar', array($check->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($check, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'check/destroy/'.$check->id)) }}
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
			<tr >
				<td><b>check</b></td>
				<td>{{{ $check->cli->cliente }}}</td>
				<td><b>Solicitud</b></td>
				<td>{{{$check->solicitud}}} </td>
			</tr>
			<tr class="alt">
				<td><b>Detalle</b></td>
				<td>{{{ $check->detalle }}}</td>
				<td><b>F. Apertura</b></td>
				<td>{{{$check->fec_apertura}}}</td>
			</tr>
			<tr >
				<td><b>F. Cierre</b></td>
				<td>{{{ $check->fec_cierre }}}</td>
				<td><b></b></td>
				<td> </td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $check->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $check->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $check->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $check->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $check->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
