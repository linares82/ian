@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('aa_eme-index')) 
			<td>{{ link_to_route('aa_eme.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('aa_eme-edit')) 
			<td>{{ link_to_route('aa_eme.edit', 'Editar', array($aa_eme->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($aa_eme, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'aa_eme/destroy/'.$aa_eme->id)) }}
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
				<th>Eme</th>
				<th>Detalle</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Eme</b></td><td>{{{ $aa_eme->eme }}}</td>
					<td><b>Detalle</b></td><td>{{{ $aa_eme->detalle }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $aa_eme->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $aa_eme->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
