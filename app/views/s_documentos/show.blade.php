@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('s_documento-index')) 
			<td>{{ link_to_route('s_documento.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('s_documento-edit')) 
			<td>{{ link_to_route('s_documento.edit', 'Editar', array($s_documento->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($s_documento, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 's_documento/destroy/'.$s_documento->id)) }}
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
				<td><b>Documento</b></td>
				<td>{{{ $s_documento->documento->cat_doc }}}</td>
				<td><b>Descripcion</b></td>
				<td>{{{ $s_documento->descripcion }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>F. Inicio Vigencia</b></td>
				<td>{{{ $s_documento->fec_ini_vigencia }}}</td>
				<td><b>F. Fin Vigencia</b></td>
				<td>{{{ $s_documento->fec_fin_vigencia }}}</td>
			</tr>
			<tr>	
				<td><b>Aviso</b></td>
				<td>{{{ $s_documento->bnd->bnd }}}</td>
				<td><b>Dias_aviso</b></td>
				<td>{{{ $s_documento->dias_aviso }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Archivo</b></td>
				<td>{{{ $s_documento->archivo }}}</td>
				<td><b>Observaciones</b></td>
				<td>{{{ $s_documento->observaciones }}}</td>
			</tr>
			<tr >	
				<td><b>Responsable</b></td>
				<td>{{{ $s_documento->responsable->nombre }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>

			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $s_documento->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $s_documento->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $s_documento->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $s_documento->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $s_documento->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
			@if(isset($s_documento->archivo) and $s_documento->archivo<>"" and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_documentos/'.$s_documento->archivo))
			<th colspan="4" style="width:100%"> 
				<iframe src="{{ asset('uploads/'.$cia.'/'.$usuario.'/s_documentos/'.$s_documento->archivo) }}" style="width:100%; height:500px" frameborder="0"> </iframe>
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
			url:'{{route('s_comentarios_documento.contentListIndex', array('s_documento'=>$s_documento->id))}}',
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
