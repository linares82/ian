@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('emision_efecto-index')) 
			<td>{{ link_to_route('emision_efecto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('emision_efecto-edit')) 
			<td>{{ link_to_route('emision_efecto.edit', 'Editar', array($emision_efecto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($emision_efecto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'emision_efecto/destroy/'.$emision_efecto->id)) }}
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
				<th>Emision_efecto</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_is</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $emision_efecto->emision_efecto }}}</td>
					<td>{{{ $emision_efecto->usu_alta_id }}}</td>
					<td>{{{ $emision_efecto->usu_mod_is }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('emision_efectos.destroy', $emision_efecto->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('emision_efectos.edit', 'Edit', array($emision_efecto->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
