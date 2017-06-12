@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('continuidad_efecto-index')) 
			<td>{{ link_to_route('continuidad_efecto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('continuidad_efecto-edit')) 
			<td>{{ link_to_route('continuidad_efecto.edit', 'Editar', array($continuidad_efecto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($continuidad_efecto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'continuidad_efecto/destroy/'.$continuidad_efecto->id)) }}
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
				<th>Continuidad_efecto</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_is</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $continuidad_efecto->continuidad_efecto }}}</td>
					<td>{{{ $continuidad_efecto->usu_alta_id }}}</td>
					<td>{{{ $continuidad_efecto->usu_mod_is }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('continuidad_efectos.destroy', $continuidad_efecto->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('continuidad_efectos.edit', 'Edit', array($continuidad_efecto->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
