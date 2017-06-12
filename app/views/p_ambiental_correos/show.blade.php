@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('p_ambiental_correo-index')) 
			<td>{{ link_to_route('p_ambiental_correo.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('p_ambiental_correo-edit')) 
			<td>{{ link_to_route('p_ambiental_correo.edit', 'Editar', array($p_ambiental_correo->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($p_ambiental_correo, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'p_ambiental_correo/destroy/'.$p_ambiental_correo->id)) }}
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
				<th>Bnd_envio</th>
				<th>Bnd_responsable</th>
				<th>Bnd_jefe</th>
				<th>Ccp</th>
				<th>Fec_ult_envio</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Bnd_envio</b></td><td>{{{ $p_ambiental_correo->bnd_envio }}}</td>
					<td><b>Bnd_responsable</b></td><td>{{{ $p_ambiental_correo->bnd_responsable }}}</td>
					<td><b>Bnd_jefe</b></td><td>{{{ $p_ambiental_correo->bnd_jefe }}}</td>
					<td><b>Ccp</b></td><td>{{{ $p_ambiental_correo->ccp }}}</td>
					<td><b>Fec_ult_envio</b></td><td>{{{ $p_ambiental_correo->fec_ult_envio }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $p_ambiental_correo->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $p_ambiental_correo->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
