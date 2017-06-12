@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('a_rr_ambientale-index')) 
			<td>{{ link_to_route('a_rr_ambientale.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('a_rr_ambientale-edit')) 
			<td>{{ link_to_route('a_rr_ambientale.edit', 'Editar', array($a_rr_ambientale->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($a_rr_ambientale, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'a_rr_ambientale/destroy/'.$a_rr_ambientale->id)) }}
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
				<td><b>Material</b></td>
				<td>{{{ $a_rr_ambientale->material->material }}}</td>
				<td><b>Categoria</b></td>
				<td>{{{ $a_rr_ambientale->categoria->categoria }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Documento</b></td>
				<td>{{{ $a_rr_ambientale->documento_id }}}</td>
				<td><b>Descripcion</b></td>
				<td>{{{ $a_rr_ambientale->descripcion }}}</td>
			</tr>
			<tr>
				<td><b>F. Fin Vigencia</b></td>
				<td>{{{ $a_rr_ambientale->fec_fin_vigencia }}}</td>
				<td><b>Archivo</b></td>
				<td>{{{ $a_rr_ambientale->archivo }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Aviso</b></td>
				<td>{{{ $a_rr_ambientale->avisoBnd->bnd }}}</td>
				<td><b>Dias_aviso</b></td>
				<td>{{{ $a_rr_ambientale->dias_aviso }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Responsable</b></td>
				<td>{{{ $a_rr_ambientale->responsable->nombre }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $a_rr_ambientale->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $a_rr_ambientale->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $a_rr_ambientale->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $a_rr_ambientale->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $a_rr_ambientale->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
			@if(isset($a_rr_ambientale->archivo) and $a_rr_ambientale->archivo<>"" and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_rr_ambientales/'.$a_rr_ambientale->archivo))
			<th colspan="4" style="width:100%"> 
				<iframe src="{{ asset('uploads/'.$cia.'/'.$usuario.'/a_rr_ambientales/'.$a_rr_ambientale->archivo) }}" style="width:100%; height:500px" frameborder="0"> </iframe>
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
			url:'{{route('a_comentarios_rr.contentListIndex', array('a_rr'=>$a_rr_ambientale->id))}}',
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
