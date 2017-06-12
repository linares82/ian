@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_no_conformidade-index')) 
			<td>{{ link_to_route('a_no_conformidade.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_no_conformidade-edit')) 
			<td>{{ link_to_route('a_no_conformidade.edit', 'Editar', array($a_no_conformidade->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_no_conformidade, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_no_conformidade/destroy/'.$a_no_conformidade->id)) }}
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
				<td>{{{ $a_no_conformidade->fecha }}}</td>
				<td><b>Area</b></td>
				<td>{{{ $a_no_conformidade->area_id }}}</td>
			</tr>
			<tr class="alt">
				<td><b>T. Deteccion</b></td>
				<td>{{{ $a_no_conformidade->tpoDeteccion->tpo_deteccion }}}</td>
				<td><b>T. Bitacora</b></td>
				<td>{{{ $a_no_conformidade->tpoBitacora->tpo_bitacora }}}</td>
			</tr>
			<tr>
				<td><b>T. Inconformidad</b></td>
				<td>{{{ $a_no_conformidade->tpoInconformidad->tpo_inconformidad }}}</td>
				<td><b>No Conformidad</b></td>
				<td>{{{ $a_no_conformidade->no_conformidad }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Solucion</b></td>
				<td>{{{ $a_no_conformidade->solucion }}}</td>
				<td><b>Responsable</b></td>
				<td>{{{ $a_no_conformidade->responsable->nombre }}}</td>
			</tr>
			<tr>	
				<td><b>F. Planeada</b></td>
				<td>{{{ $a_no_conformidade->fec_planeada }}}</td>
				<td><b>F. Solución</b></td>
				<td>{{{ $a_no_conformidade->fec_solucion }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Costo</b></td>
				<td>{{{ $a_no_conformidade->costo }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $a_no_conformidade->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $a_no_conformidade->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $a_no_conformidade->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $a_no_conformidade->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $a_no_conformidade->deleted_at }}}</td>
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
			url:'{{route('a_comentarios_nc.contentListIndex', array('no_conformidad'=>$a_no_conformidade->id))}}',
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
