@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_procedimiento-index')) 
			<td>{{ link_to_route('a_procedimiento.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_procedimiento-edit')) 
			<td>{{ link_to_route('a_procedimiento.edit', 'Editar', array($a_procedimiento->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_procedimiento, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_procedimiento/destroy/'.$a_procedimiento->id)) }}
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
				<td><b>Procedimiento</b></td>
				<td>{{{ $a_procedimiento->procedimiento->procedimiento }}}</td>
				<td><b>Descripcion</b></td>
				<td>{{{ $a_procedimiento->descripcion }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Inicio Vigencia</b></td>
				<td>{{{ $a_procedimiento->fec_ini_vigencia }}}</td>
				<td><b>F. Fin Vigencia</b></td>
				<td>{{{ $a_procedimiento->fec_fin_vigencia }}}</td>
			</tr>
			<tr>	
				<td><b>Archivo</b></td>
				<td>{{{ $a_procedimiento->archivo }}}</td>
				<td><b>Aviso</b></td>
				<td>{{{ $a_procedimiento->avisoBnd->bnd }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Dias Aviso</b></td>
				<td>{{{ $a_procedimiento->dias_aviso }}}</td>
				<td><b>Obs</b></td>
				<td>{{{ $a_procedimiento->obs }}}</td>
			</tr>
			<tr class="alt">	
				<td><b>Responsables</b></td>
				<td>{{{ $a_procedimiento->responsable->nombre }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $a_procedimiento->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $a_procedimiento->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $a_procedimiento->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $a_procedimiento->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $a_procedimiento->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
			@if(isset($a_procedimiento->archivo) and $a_procedimiento->archivo<>"" and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_procedimientos/'.$a_procedimiento->archivo))
			<th colspan="4" style="width:100%"> 
				<iframe src="{{ asset('uploads/'.$cia.'/'.$usuario.'/a_procedimientos/'.$a_procedimiento->archivo) }}" style="width:100%; height:500px" frameborder="0"> </iframe>
			</th>
			@endif
		</tbody>
	</table>
	</div>

	<table id="dg" 
			class="easyui-datagrid" 
			title="Comentarios y Cambios de estatus" 
			style="width:auto;height:230px"
			toolbar="#toolbar" data-options="pageList:[10,20,40,80], singleSelect:true,
			url:'{{route('a_comentarios_procedimiento.contentListIndex', array('a_procedimiento'=>$a_procedimiento->id))}}',
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
