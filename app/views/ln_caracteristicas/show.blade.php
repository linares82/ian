@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('ln_caracteristica-index')) 
			<td>{{ link_to_route('ln_caracteristica.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('ln_caracteristica-edit')) 
			<td>{{ link_to_route('ln_caracteristica.edit', 'Editar', array($ln_caracteristica->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($ln_caracteristica, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'ln_caracteristica/destroy/'.$ln_caracteristica->id)) }}
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
				<th>Reg_impacto_id</th>
				<th>Caracteristica_id</th>
				<th>Efecto_id</th>
				<th>Desc_efecto</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $ln_caracteristica->reg_impacto_id }}}</td>
					<td>{{{ $ln_caracteristica->caracteristica_id }}}</td>
					<td>{{{ $ln_caracteristica->efecto_id }}}</td>
					<td>{{{ $ln_caracteristica->desc_efecto }}}</td>
					<td>{{{ $ln_caracteristica->usu_alta_id }}}</td>
					<td>{{{ $ln_caracteristica->usu_mod_id }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ln_caracteristicas.destroy', $ln_caracteristica->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('ln_caracteristicas.edit', 'Edit', array($ln_caracteristica->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
