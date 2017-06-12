@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('reversibilidad-index')) 
			<td>{{ link_to_route('reversibilidad.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('reversibilidad-edit')) 
			<td>{{ link_to_route('reversibilidad.edit', 'Editar', array($reversibilidad->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($reversibilidad, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'reversibilidad/destroy/'.$reversibilidad->id)) }}
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
				<th>Reversibilidad</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_is</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $reversibilidad->reversibilidad }}}</td>
					<td>{{{ $reversibilidad->usu_alta_id }}}</td>
					<td>{{{ $reversibilidad->usu_mod_is }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('reversibilidads.destroy', $reversibilidad->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('reversibilidads.edit', 'Edit', array($reversibilidad->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
