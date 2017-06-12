@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('ca_fuentes_fija-index')) 
			<td>{{ link_to_route('ca_fuentes_fija.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('ca_fuentes_fija-edit')) 
			<td>{{ link_to_route('ca_fuentes_fija.edit', 'Editar', array($ca_fuentes_fija->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($ca_fuentes_fija, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'ca_fuentes_fija/destroy/'.$ca_fuentes_fija->id)) }}
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
				<td>{{{ $ca_fuentes_fija->planta }}}</td>
				<td><b>Marca</b></td>
				<td>{{{ $ca_fuentes_fija->marca }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Ubicacion</b></td>
				<td>{{{ $ca_fuentes_fija->ubicacion }}}</td>
				<td><b>Obs</b></td>
				<td>{{{ $ca_fuentes_fija->obs }}}</td>
			</tr>
			<tr>
				<td><b>C. Térmica</b></td>
				<td>{{{ $ca_fuentes_fija->c_termica }}}</td>
				<td><b>Tipo Combustible</b></td>
				<td>{{{ $ca_fuentes_fija->tipo_combustible }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $ca_fuentes_fija->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $ca_fuentes_fija->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $ca_fuentes_fija->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $ca_fuentes_fija->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $ca_fuentes_fija->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
