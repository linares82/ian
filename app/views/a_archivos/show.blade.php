@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_archivo-index')) 
			<td>{{ link_to_route('a_archivo.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_archivo-edit')) 
			<td>{{ link_to_route('a_archivo.edit', 'Editar', array($a_archivo->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_archivo, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_archivo/destroy/'.$a_archivo->id)) }}
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
				<td>{{{ $a_archivo->documento->doc }}}</td>
				<td><b>Archivo</b></td>
				<td>{{{ $a_archivo->archivo }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Inicio vigencia</b></td>
				<td>{{{ $a_archivo->fec_ini_vigencia }}}</td>
				<td><b>F. Fin Vigencia</b></td>
				<td>{{{ $a_archivo->fec_fin_vigencia }}}</td>
			</tr>
			<tr>	
				<td><b>Aviso</b></td>
				<td>{{{ $a_archivo->avisoBnd->bnd }}}</td>
				<td><b>Dias Aviso</b></td>
				<td>{{{ $a_archivo->dias_aviso }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Obs.</b></td>
				<td>{{{ $a_archivo->obs }}}</td>
				<td><b>Responsable</b></td>
				<td>$a_archivo->responsable->nombre</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $a_archivo->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $a_archivo->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $a_archivo->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $a_archivo->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $a_archivo->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
			@if(isset($a_archivo->archivo) and $a_archivo->archivo<>"" and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_archivos/'.$a_archivo->archivo))
			<th colspan="4" style="width:100%"> 
				<iframe src="{{ asset('uploads/'.$cia.'/'.$usuario.'/a_archivos/'.$a_archivo->archivo) }}" style="width:100%; height:500px" frameborder="0"> </iframe>
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
			url:'{{route('a_comentarios_archivo.contentListIndex', array('a_archivo'=>$a_archivo->id))}}',
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
