@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora_pendiente-index')) 
			<td>{{ link_to_route('bitacora_pendiente.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora_pendiente-edit')) 
			<td>{{ link_to_route('bitacora_pendiente.edit', 'Editar', array($bitacora_pendiente->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora_pendiente, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora_pendiente/destroy/'.$bitacora_pendiente->id)) }}
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
				<td><b>Pendiente</b></td>
				<td>{{{ $bitacora_pendiente->pendiente }}}</td>
				<td><b>Comentarios</b></td>
				<td>{{{ $bitacora_pendiente->comentarios }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Solucion</b></td>
				<td>{{{ $bitacora_pendiente->solucion }}}</td>
				<td><b>F. Planeada</b></td>
				<td>{{{ $bitacora_pendiente->fec_planeada }}}</td>
			</tr>
			<tr>	
				<td><b>F. Fin</b></td>
				<td>{{{ $bitacora_pendiente->fec_fin }}}</td>
				<td><b>Responsable</b></td>
				<td>{{{ $bitacora_pendiente->responsable->nombre }}}</td>	
			</tr>
			<tr class="alt">	
				<td><b>Aviso</b></td>
				<td>{{{ $bitacora_pendiente->avisoBnd->bnd }}}</td>
				<td><b>Dias_aviso</b></td>
				<td>{{{ $bitacora_pendiente->dias_aviso }}}</td>
			</tr>
			<tr>	
				<td><b>Estatus</b></td>
				<td>{{{ $bitacora_pendiente->estatus->estatus }}}</td>
				<td><b>Observaciones</b></td>
				<td>{{{ $bitacora_pendiente->observaciones }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $bitacora_pendiente->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $bitacora_pendiente->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $bitacora_pendiente->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $bitacora_pendiente->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $bitacora_pendiente->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	<table id="dg" 
			class="easyui-datagrid" 
			title="Comentarios y Cambios de estatus" 
			style="auto;height:230px"
			toolbar="#toolbar" 
			data-options="pageList:[10,20,40,80], singleSelect:true,
			url:'{{route('a_comentarios_pendiente.contentListIndex', array('bitacora_pendiente'=>$bitacora_pendiente->id))}}',
			autoRowHeight:false, pageSize:10, pagination:true, collapsible:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="id" sortable="true">Id</th>
				<th field="comentario" sortable="true">Comentario</th>
				<th field="estatus" sortable="true">Estatus</th>
				<th field="username" sortable="true">Creado Por</th>
				<th field="created_at" sortable="true">Creado En</th>
			</tr>
		</thead>
	</table>
	</div>
</div>
@stop
