@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('s_procedimiento-index')) 
			<td>{{ link_to_route('s_procedimiento.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('s_procedimiento-edit')) 
			<td>{{ link_to_route('s_procedimiento.edit', 'Editar', array($s_procedimiento->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($s_procedimiento, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 's_procedimiento/destroy/'.$s_procedimiento->id)) }}
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
				<td><b>T. Procedimiento</b></td>
				<td>{{{ $s_procedimiento->tpoProcedimiento->tpo_procedimiento }}}</td>
				<td><b>T. Documento</b></td>
				<td>{{{ $s_procedimiento->tpoDocumento->tpo_doc }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Descripcion</b></td>
				<td>{{{ $s_procedimiento->descripcion }}}</td>
				<td><b>Archivo</b></td>
				<td>{{{ $s_procedimiento->archivo }}}</td>
			</tr>
			<tr >	
				<td><b>Responsable</b></td>
				<td>{{{ $s_procedimiento->responsable->nombre }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $s_procedimiento->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $s_procedimiento->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $s_procedimiento->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $s_procedimiento->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $s_procedimiento->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
			@if(isset($s_procedimiento->archivo) and $s_procedimiento->archivo<>"" and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_procedimientos/'.$s_procedimiento->archivo))
			<th colspan="4" style="width:100%"> 
				<iframe src="{{ asset('uploads/'.$cia.'/'.$usuario.'/s_procedimientos/'.$s_procedimiento->archivo) }}" style="width:100%; height:500px" frameborder="0"> </iframe>
			</th>
			@endif
		</tbody>
	</table>
	</div>
	<table id="dg" 
			class="easyui-datagrid" 
			title="Comentarios y Cambios de estatus" 
			style="auto;height:230px"
			toolbar="#toolbar" 
			data-options="pageList:[10,20,40,80], singleSelect:true,
			url:'{{route('s_comentarios_procedimiento.contentListIndex', array('s_registro'=>$s_procedimiento->id))}}',
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
