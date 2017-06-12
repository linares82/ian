@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('ln_dossier-index')) 
			<td>{{ link_to_route('ln_dossier.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('ln_dossier-edit')) 
			<td>{{ link_to_route('ln_dossier.edit', 'Editar', array($ln_dossier->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($ln_dossier, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'ln_dossier/destroy/'.$ln_dossier->id)) }}
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
				<th>Dossier_id</th>
				<th>Modulo_id</th>
				<th>Doc_dossier_id</th>
				<th>Fec_planeada</th>
				<th>Fec_obs</th>
				<th>Datos_relevantes</th>
				<th>Estatus_id</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $ln_dossier->dossier_id }}}</td>
					<td>{{{ $ln_dossier->modulo_id }}}</td>
					<td>{{{ $ln_dossier->doc_dossier_id }}}</td>
					<td>{{{ $ln_dossier->fec_planeada }}}</td>
					<td>{{{ $ln_dossier->fec_obs }}}</td>
					<td>{{{ $ln_dossier->datos_relevantes }}}</td>
					<td>{{{ $ln_dossier->estatus_id }}}</td>
					<td>{{{ $ln_dossier->usu_alta_id }}}</td>
					<td>{{{ $ln_dossier->usu_mod_id }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ln_dossiers.destroy', $ln_dossier->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('ln_dossiers.edit', 'Edit', array($ln_dossier->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
