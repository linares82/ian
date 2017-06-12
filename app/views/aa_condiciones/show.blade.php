@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('aa_condicione-index')) 
			<td>{{ link_to_route('aa_condicione.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('aa_condicione-edit')) 
			<td>{{ link_to_route('aa_condicione.edit', 'Editar', array($aa_condicione->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($aa_condicione, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'aa_condicione/destroy/'.$aa_condicione->id)) }}
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
				<th>Condicion</th>
				<th>Detalle</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Condicion</b></td><td>{{{ $aa_condicione->condicion }}}</td>
					<td><b>Detalle</b></td><td>{{{ $aa_condicione->detalle }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $aa_condicione->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $aa_condicione->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
