@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora_planta-index')) 
			<td>{{ link_to_route('bitacora_planta.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora_planta-edit')) 
			<td>{{ link_to_route('bitacora_planta.edit', 'Editar', array($bitacora_planta->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora_planta, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora_planta/destroy/'.$bitacora_planta->id)) }}
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
				<td>{{{ $bitacora_planta->planta->planta }}}</td>
				<td><b>Fecha</b></td>
				<td>{{{ $bitacora_planta->fecha }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Turno</b></td>
				<td>{{{ $bitacora_planta->turno->turno }}}</td>
				<td><b>Agua Entrada</b></td>
				<td>{{{ $bitacora_planta->agua_entrada }}}</td>
			</tr>
			<tr>
				<td><b>Agua Salida</b></td>
				<td>{{{ $bitacora_planta->agua_salida }}}</td>
				<td><b>Quimicos Usados</b></td>
				<td>{{{ $bitacora_planta->q_usados }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Quimicos Existentes</b></td>
				<td>{{{ $bitacora_planta->q_existentes }}}</td>
				<td><b>Tiempo de Operación</b></td>
				<td>{{{ $bitacora_planta->tiempo_operacion }}}</td>
			</tr>
			<tr>
				<td><b>Motivo de Paro</b></td>
				<td>{{{ $bitacora_planta->motivo_paro }}}</td>
				<td><b>Vol. de Lodos en el Mes</b></td>
				<td>{{{ $bitacora_planta->vol_lodos }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Disp. de Lodos</b></td>
				<td>{{{ $bitacora_planta->disp_lodos }}}</td>
				<td><b>F. Ult. Manto</b></td>
				<td>{{{ $bitacora_planta->fec_ult_manto }}}</td>
			</tr>
			<tr>
				<td><b>Desc. Ultimo Manto.</b></td>
				<td>{{{ $bitacora_planta->desc_manto }}}</td>
				<td><b>Obs.</b></td>
				<td>{{{ $bitacora_planta->obs }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Responsable</b></td>
				<td>{{{ $bitacora_planta->responsable->nombre }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $bitacora_planta->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $bitacora_planta->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $bitacora_planta->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $bitacora_planta->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $bitacora_planta->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
