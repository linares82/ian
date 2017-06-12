@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('subequipo-index')) 
			<td>{{ link_to_route('subequipo.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('subequipo-edit')) 
			<td>{{ link_to_route('subequipo.edit', 'Editar', array($subequipo->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($subequipo, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'subequipo/destroy/'.$subequipo->id)) }}
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
				<tr>
					<td><b>Equipo</b></td>
					<td>{{{ $subequipo->rEquipo->objetivo }}}</td>
					<td><b>Subequipo</b></td>
					<td>{{{$subequipo->subequipo}}}</td>
				</tr>
				<tr class="alt">
					<td><b>Clase</b></td>
					<td>{{{ $subequipo->clase }}}</td>
					<td><b>Marca</b></td>
					<td>{{{$subequipo->marca}}}</td>
				</tr>
				<tr>
					<td><b>Modelo</b></td>
					<td>{{{
					$subequipo->no_serie }}}</td>
					<td><b>No. Serie</b></td>
					<td>{{{$subequipo->no_serie}}}</td>
				</tr>
				<tr class="alt">
					<td><b>Fecha Carga</b></td>
					<td>{{{ $subequipo->fecha_carga }}}</td>
					<td><b>Area</b></td>
					<td>{{{$subequipo->rArea->area}}}</td>
				</tr>
				<tr>
					<td><b>Ubicacion</b></td>
					<td>{{{ $subequipo->ubicacion }}}</td>
					<td><b></b></td>
					<td></td>
				</tr>
				
				
			<thead>
					<th colspan="4" style="width:100%">Manipulación de registros</th>
				</thead>
                <tr class="alt">
					<td><b>U. Alta</b></td>
					<td>{{{ $subequipo->uAlta->username }}}</td>
					<td><b>F. Alta</b></td>
					<td>{{{ $subequipo->created_at }}}</td>
				</tr>
				<tr>
					<td><b>U. Mod.</b></td>
					<td>{{{ $subequipo->uMod->username }}}</td>
					<td><b>F. Mod.</b></td>
					<td>{{{ $subequipo->updated_at }}}</td>
				</tr>
				<tr class="alt">
					<td><b>F. Eliminado</b></td>
					<td>{{{ $subequipo->deleted_at }}}</td>
					<td><b> </b></td>
					<td> </td>
				</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
