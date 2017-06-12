@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('tipo_impacto-index')) 
			<td>{{ link_to_route('tipo_impacto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('tipo_impacto-edit')) 
			<td>{{ link_to_route('tipo_impacto.edit', 'Editar', array($tipo_impacto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($tipo_impacto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'tipo_impacto/destroy/'.$tipo_impacto->id)) }}
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
			</tr>
			<tr class="alt">
					<td><b>Tipo de Impacto</b></td>
					<td>{{{ $tipo_impacto->tipo_impacto }}}</td>
					<td><b></b></td>
					<td></td>
				</tr>
				<thead>
					<th colspan="4" style="width:100%">Manipulación de registros</th>
				</thead>
                <tr class="alt">
					<td><b>U. Alta</b></td>
					<td>{{{ $tipo_impacto->uAlta->username }}}</td>
					<td><b>F. Alta</b></td>
					<td>{{{ $tipo_impacto->created_at }}}</td>
				</tr>
				<tr>
					<td><b>U. Mod.</b></td>
					<td>{{{ $tipo_impacto->uMod->username }}}</td>
					<td><b>F. Mod.</b></td>
					<td>{{{ $tipo_impacto->updated_at }}}</td>
				</tr>
				<tr class="alt">
					<td><b>F. Eliminado</b></td>
					<td>{{{ $tipo_impacto->deleted_at }}}</td>
					<td><b> </b></td>
					<td> </td>
				</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
