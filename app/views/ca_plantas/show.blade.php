@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('ca_planta-index')) 
			<td>{{ link_to_route('ca_planta.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('ca_planta-edit')) 
			<td>{{ link_to_route('ca_planta.edit', 'Editar', array($ca_planta->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($ca_planta, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'ca_planta/destroy/'.$ca_planta->id)) }}
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
				<td><b>Planta</b></td>
				<td>{{{ $ca_planta->planta }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<tr class="alt">
				<td><b>Ubicacion</b></td>
				<td>{{{ $ca_planta->ubicacion }}}</td>
				<td><b>Obs</b></td>
				<td>{{{ $ca_planta->obs }}}</td>
			</tr>
			<tr>
				<td><b>Tipo Planta</b></td>
				<td>{{{ $ca_planta->tipo_planta }}}</td>
				<td><b>C. Tratamiento</b></td>
				<td>{{{ $ca_planta->c_tratamiento }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $ca_planta->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $ca_planta->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $ca_planta->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $ca_planta->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $ca_planta->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
