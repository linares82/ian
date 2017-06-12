@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora_residuo-index')) 
			<td>{{ link_to_route('bitacora_residuo.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora_residuo-edit')) 
			<td>{{ link_to_route('bitacora_residuo.edit', 'Editar', array($bitacora_residuo->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora_residuo, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora_residuo/destroy/'.$bitacora_residuo->id)) }}
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
				<td><b>Residuo</b></td>
				<td>{{{ $bitacora_residuo->residuos->residuo }}}</td>
				<td><b>Cantidad</b></td>
				<td>{{{ $bitacora_residuo->cantidad }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Fecha Generación</b></td>
				<td>{{{ $bitacora_residuo->fecha }}}</td>
				<td><b>Lugar Generación</b></td>
				<td>{{{ $bitacora_residuo->lugar_generacion }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Ubicación</b></td>
				<td>{{{ $bitacora_residuo->ubicacion }}}</td>
				<td><b>Dispocision</b></td>
				<td>{{{ $bitacora_residuo->dispocision }}}</td>
			</tr>
			<tr>
				<td><b>Transportista</b></td>
				<td>{{{ $bitacora_residuo->transportista }}}</td>
				<td><b>Responsable</b></td>
				<td>{{{ $bitacora_residuo->responsable->nombre }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Manifiesto</b></td>
				<td>{{{ $bitacora_residuo->manifiesto }}}</td>
				<td><b>Resp. Técnico Bitacora</b></td>
				<td>{{{ $bitacora_residuo->resp_tecnico }}}</td>
			</tr>
			<tr>
				<td><b>Requiere Vo. Bo.</b></td>
				<td>{{{ $bitacora_residuo->requiereVobo->bnd }}}</td>
				<td><b>Registro Residuos</b></td>
				<td>{{{ $bitacora_residuo->registroResiduos->bnd }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Peligrosidad</b></td>
				<td>{{{ $bitacora_residuo->peligrosidad }}}</td>
				<td><b>F. Ingreso almacén</b></td>
				<td>{{{ $bitacora_residuo->fec_ingreso }}}</td>
			</tr>
			<tr>
				<td><b>F. salida Almacén</b></td>
				<td>{{{ $bitacora_residuo->fec_salida }}}</td>
				<td><b>Cedula Operación Anual</b></td>
				<td>{{{ $bitacora_residuo->cedulaOperacion->bnd }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>F. Ambiental</b></td>
				<td>{{{ $bitacora_residuo->factor_indicador }}}</td>
				<td><b>I. Ambiental</b></td>
				<td>{{{ $bitacora_residuo->factor_calculado }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $bitacora_residuo->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $bitacora_residuo->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $bitacora_residuo->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $bitacora_residuo->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $bitacora_residuo->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
