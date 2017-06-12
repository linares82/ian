@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('st_reg_impacto-index')) 
			<td>{{ link_to_route('st_reg_impacto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('st_reg_impacto-edit')) 
			<td>{{ link_to_route('st_reg_impacto.edit', 'Editar', array($st_reg_impacto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($st_reg_impacto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'st_reg_impacto/destroy/'.$st_reg_impacto->id)) }}
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
				<th>St_reg_impacto</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $st_reg_impacto->st_reg_impacto }}}</td>
					<td>{{{ $st_reg_impacto->usu_alta_id }}}</td>
					<td>{{{ $st_reg_impacto->usu_mod_id }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('st_reg_impactos.destroy', $st_reg_impacto->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('st_reg_impactos.edit', 'Edit', array($st_reg_impacto->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
