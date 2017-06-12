@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('aa_proceso-index')) 
			<td>{{ link_to_route('aa_proceso.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('aa_proceso-edit')) 
			<td>{{ link_to_route('aa_proceso.edit', 'Editar', array($aa_proceso->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($aa_proceso, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'aa_proceso/destroy/'.$aa_proceso->id)) }}
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
				<td><b>Proceso</b></td>
				<td>{{{ $aa_proceso->proceso }}}</td>
				<td><b>Detalle</b></td>
				<td>{{{ $aa_proceso->detalle }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $aa_proceso->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $aa_proceso->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $aa_proceso->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $aa_proceso->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $aa_proceso->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
