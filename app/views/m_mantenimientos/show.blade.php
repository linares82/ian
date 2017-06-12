@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('m_mantenimiento-index')) 
			<td>{{ link_to_route('m_mantenimiento.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('m_mantenimiento-edit')) 
			<td>{{ link_to_route('m_mantenimiento.edit', 'Editar', array($m_mantenimiento->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($m_mantenimiento, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'm_mantenimiento/destroy/'.$m_mantenimiento->id)) }}
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
				<td><b>Estatus</b></td><td>{{{ $m_mantenimiento->estatus->estatus }}}</td>
				<td><b>Obejtivo</b></td><td>{{{ $m_mantenimiento->objetivo->objetivo }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Elemento</b></td><td>{{{ $m_mantenimiento->elemento }}}</td>
				<td><b>Descripcion</b></td><td>{{{ $m_mantenimiento->descripcion }}}</td>
			</tr>
			<tr>
				<td><b>Herramientas</b></td><td>{{{ $m_mantenimiento->herramientas }}}</td>
				<td><b>Horas Inv.</b></td><td>{{{ $m_mantenimiento->horas_inv }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Planeada</b></td><td>{{{ $m_mantenimiento->fec_planeada }}}</td>
				<td><b>Tipo Manto.</b></td><td>{{{ $m_mantenimiento->tpoManto->tpo_manto }}}</td>
			</tr>
			<tr>
				<td><b>Clase Manto.</b></td><td>{{{ $m_mantenimiento->claseManto->clase_manto }}}</td>
				<td><b>Area</b></td><td>{{{ $m_mantenimiento->area->area }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Responsable</b></td><td>{{{ $m_mantenimiento->responsable->nombre }}}</td>
				<td><b>F. Real</b></td><td>{{{ $m_mantenimiento->fec_real }}}</td>
			</tr>
			<tr>
				<td><b>Costo</b></td><td>{{{ $m_mantenimiento->costo }}}</td>
				<td><b>Observaciones</b></td><td>{{{ $m_mantenimiento->observaciones }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $m_mantenimiento->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $m_mantenimiento->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $m_mantenimiento->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $m_mantenimiento->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $m_mantenimiento->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
