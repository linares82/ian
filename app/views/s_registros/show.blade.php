@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('s_registro-index')) 
			<td>{{ link_to_route('s_registro.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('s_registro-edit')) 
			<td>{{ link_to_route('s_registro.edit', 'Editar', array($s_registro->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($s_registro, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 's_registro/destroy/'.$s_registro->id)) }}
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
				<td><b>Grupo</b></td>
				<td>{{{ $s_registro->grupo->grupo_norma }}}</td>
				<td><b>Norma</b></td>
				<td>{{{ $s_registro->norma->norma }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Elemento</b></td>
				<td>{{{ $s_registro->elemento->elemento }}}</td>
				<td><b>Detalle</b></td>
				<td>{{{ $s_registro->detalle }}}</td>
			</tr>
			<tr>	
				<td><b>F. Registro</b></td>
				<td>{{{ $s_registro->fec_registro }}}</td>
				<td><b>Archivo</b></td>
				<td>{{{ $s_registro->archivo }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Responsable</b></td>
				<td>{{{ $s_registro->responsable->nombre }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $s_registro->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $s_registro->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $s_registro->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $s_registro->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $s_registro->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
			@if(isset($s_registro->archivo) and $s_registro->archivo<>"" and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_registros/'.$s_registro->archivo))
			<th colspan="4" style="width:100%"> 
				<iframe src="{{ asset('uploads/'.$cia.'/'.$usuario.'/s_registros/'.$s_registro->archivo) }}" style="width:100%; height:500px" frameborder="0"> </iframe>
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
			url:'{{route('s_comentarios_registro.contentListIndex', array('s_registro'=>$s_registro->id))}}',
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
