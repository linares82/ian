@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('bitacora_seguridad-index')) 
			<td>{{ link_to_route('bitacora_seguridad.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('bitacora_seguridad-edit')) 
			<td>{{ link_to_route('bitacora_seguridad.edit', 'Editar', array($bitacora_seguridad->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($bitacora_seguridad, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'bitacora_seguridad/destroy/'.$bitacora_seguridad->id)) }}
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
				<td><b>Fecha</b></td>
				<td>{{{ $bitacora_seguridad->fecha }}}</td>
				<td><b>Area</b></td>
				<td>{{{ $bitacora_seguridad->area->area }}}</td>
			</tr>
			<tr class="alt">
				<td><b>T. Detección</b></td>
				<td>{{{ $bitacora_seguridad->tpoDeteccion->tpo_deteccion }}}</td>
				<td><b>T. Bitacora</b></td>
				<td>{{{ $bitacora_seguridad->tpoBitacora->tpo_bitacora }}}</td>
			</tr>
			<tr>
				<td><b>T. Inconformidad</b></td>
				<td>{{{ $bitacora_seguridad->tpoInconformidad->tpo_inconformidad }}}</td>
				<td><b>Inconformidad</b></td>
				<td>{{{ $bitacora_seguridad->inconformidad }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Solucion</b></td>
				<td>{{{ $bitacora_seguridad->solucion }}}</td>
				<td><b>Responsable</b></td>
				<td>{{{ $bitacora_seguridad->responsable->nombre }}}</td>
			</tr>
			<tr>
				<td><b>F. Planeada</b></td>
				<td>{{{ $bitacora_seguridad->fec_planeada }}}</td>
				<td><b>F. Solucion</b></td>
				<td>{{{ $bitacora_seguridad->fec_solucion }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Grupo</b></td>
				<td>{{{ $bitacora_seguridad->grupoNorma->grupo_norma }}}</td>
				<td><b>Norma</b></td>
				<td>{{{ $bitacora_seguridad->normas->norma }}}</td>
			</tr>
			<tr>
				<td><b>Detalle Norma</b></td>
				<td>{{{ $bitacora_seguridad->norma }}}</td>
				<td><b>Costo</b></td>
				<td>{{{ $bitacora_seguridad->costo }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $bitacora_seguridad->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $bitacora_seguridad->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $bitacora_seguridad->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $bitacora_seguridad->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $bitacora_seguridad->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	<table id="dg" 
			class="easyui-datagrid" 
			title="Comentarios y Cambios de estatus" 
			style="width:auto;height:230px"
			toolbar="#toolbar" data-options="pageList:[10,20,40,80], singleSelect:true,
			url:'{{route('comentarios_bs.contentListIndex', array('bitacora_seguridad'=>$bitacora_seguridad->id))}}',
			autoRowHeight:false, pageSize:10, pagination:true, collapsible:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="id" sortable="true">Id</th>
				<th field="comentario" sortable="true">Comentario</th>
				<th field="costo" sortable="true">Costo</th>
				<th field="estatus" sortable="true">Estatus</th>
				<th field="username" sortable="true">Creado Por</th>
				<th field="created_at" sortable="true">Creado En</th>
			</tr>
		</thead>
	</table>
	</div>
</div>
@stop
