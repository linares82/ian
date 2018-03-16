@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora_ff-index')) 
			<td>{{ link_to_route('bitacora_ff.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora_ff-edit')) 
			<td>{{ link_to_route('bitacora_ff.edit', 'Editar', array($bitacora_ff->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora_ff, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora_ff/destroy/'.$bitacora_ff->id)) }}
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
				<td><b>Fuente Fija</b>
				</td><td>{{{ $bitacora_ff->fuenteFija->planta }}}</td>
				<td><b>Fecha</b></td>
				<td>{{{ $bitacora_ff->fecha }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Turno</b></td>
				<td>{{{ $bitacora_ff->turno->turno }}}</td>
				<td><b>Consumo</b></td>
				<td>{{{ $bitacora_ff->consumo }}}</td>
			</tr>
			<tr>
				<td><b>% de Capacidad Diseño</b></td>
				<td>{{{ $bitacora_ff->capacidad_diseno }}}</td>
				<td><b>Temperatura Promedio de Gases</b></td>
				<td>{{{ $bitacora_ff->tp_gases }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Temperatura Promedio de Chimenea</b></td>
				<td>{{{ $bitacora_ff->tp_chimenea }}}</td>
				<td><b>F. Ultimo Manto.</b></td>
				<td>{{{ $bitacora_ff->fec_ult_manto }}}</td>
			</tr>
			<tr>
				<td><b>Desc. Ultimo Manto.</b></td>
				<td>{{{ $bitacora_ff->desc_manto }}}</td>
				<td><b>Obs.</b></td>
				<td>{{{ $bitacora_ff->obs }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Responsable</b></td>
				<td>{{{ $bitacora_ff->responsableFf->nombre }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $bitacora_ff->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $bitacora_ff->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $bitacora_ff->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $bitacora_ff->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $bitacora_ff->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
