@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('probabilidad-index')) 
			<td>{{ link_to_route('probabilidad.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('probabilidad-edit')) 
			<td>{{ link_to_route('probabilidad.edit', 'Editar', array($probabilidad->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($probabilidad, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'probabilidad/destroy/'.$probabilidad->id)) }}
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
				<th>Probabilidad</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_is</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $probabilidad->probabilidad }}}</td>
					<td>{{{ $probabilidad->usu_alta_id }}}</td>
					<td>{{{ $probabilidad->usu_mod_is }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('probabilidads.destroy', $probabilidad->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('probabilidads.edit', 'Edit', array($probabilidad->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
