@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('intensidad_impacto-index')) 
			<td>{{ link_to_route('intensidad_impacto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('intensidad_impacto-edit')) 
			<td>{{ link_to_route('intensidad_impacto.edit', 'Editar', array($intensidad_impacto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($intensidad_impacto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'intensidad_impacto/destroy/'.$intensidad_impacto->id)) }}
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
			<tr>
				<th>Intensidad_impacto</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_is</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $intensidad_impacto->intensidad_impacto }}}</td>
					<td>{{{ $intensidad_impacto->usu_alta_id }}}</td>
					<td>{{{ $intensidad_impacto->usu_mod_is }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('intensidad_impactos.destroy', $intensidad_impacto->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('intensidad_impactos.edit', 'Edit', array($intensidad_impacto->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
