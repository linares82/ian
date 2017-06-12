@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('entidades-index')) 
			<td>{{ link_to_route('entidad.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('entidades-edit')) 
			<td>{{ link_to_route('entidad.edit', 'Editar', array($entidad->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('entidades-destroy')) 
			<td>{{ Form::model($entidad, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'entidad/destroy/'.$entidad->id)) }}
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
			<th colspan="4" style="width:100%">Información</th>
		</thead>

		<tbody>
			
				<tr>
					<td style="width:25%"><b>Razón social</b></td>
					<td style="width:25%">{{{ $entidad->rzon_social }}}</td>
					<td style="width:25%"><b>Abreviatura</b></td>
					<td style="width:25%">{{{ $entidad->abreviatura }}}</td>
				</tr>
				<tr class="alt">
					<td><b>Responsable</b></td>
					<td>{{{ $entidad->responsable }}}</td>
					<td><b>RFC</b></td>
					<td>{{{ $entidad->rfc }}}</td>
				</tr>
				<tr>
					<td style="width:25%"><b>Dirección 1</b></td>
					<td style="width:25%">{{{ $entidad->dir1 }}}</td>
					<td style="width:25%"><b>Dirección 2</b></td>
					<td style="width:25%">{{{ $entidad->dir2 }}}</td>
				</tr>
				<tr class="alt">
					<td><b>Responsable</b></td>
					<td>{{{ $entidad->responsable }}}</td>
					<td><b>RFC</b></td>
					<td>{{{ $entidad->rfc }}}</td>
				</tr>
				<thead>
					<th colspan="4" style="width:100%">Manipulación de registros</th>
				</thead>
                <tr class="alt">
					<td><b>U. Alta</b></td>
					<td>{{{ $entidad->uAlta->username }}}</td>
					<td><b>F. Alta</b></td>
					<td>{{{ $entidad->created_at }}}</td>
				</tr>
				<tr>
					<td><b>U. Mod.</b></td>
					<td>{{{ $entidad->uMod->username }}}</td>
					<td><b>F. Mod.</b></td>
					<td>{{{ $entidad->updated_at }}}</td>
				</tr>
				<tr class="alt">
					<td><b>F. Eliminado</b></td>
					<td>{{{ $entidad->deleted_at }}}</td>
					<td><b> </b></td>
					<td> </td>
				</tr>
				<th colspan="4" style="width:100%"> <img src="{{asset('uploads/cias/'.$entidad->logo)}}" alt="Logotipo" height="200"> </th>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
