@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('rev_documentoal_ln-index')) 
			<td>{{ link_to_route('rev_documentoal_ln.index', 'Lista', array('id'=>$rev_documentoal_ln->rev_documental_id), array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('rev_documentoal_ln-edit')) 
			<td>{{ link_to_route('rev_documentoal_ln.edit', 'Editar', array($rev_documentoal_ln->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($rev_documentoal_ln, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'rev_documentoal_ln/destroy/'.$rev_documentoal_ln->id)) }}
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
				<td><b>T. Documento</b></td><td>{{{ $rev_documentoal_ln->tpoDocumento->tpo_doc }}}</td>
				<td><b>Documento</b></td><td>{{{ $rev_documentoal_ln->documento->r_documento }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Grupo</b></td><td>{{{ $rev_documentoal_ln->grupoNorma->grupo_norma }}}</td>
				<td><b>Norma</b></td><td>{{{ $rev_documentoal_ln->norma->norma }}}</td>
			</tr>
			<tr>
				<td><b>Importancia</b></td><td>{{{ $rev_documentoal_ln->importancia->importancia }}}</td>
				<td><b>Responsable</b></td><td>{{{ $rev_documentoal_ln->responsable->nombre }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Dias Advertencia 1</b></td><td>{{{ $rev_documentoal_ln->dias_advertencia1 }}}</td>
				<td><b>Dias Advertencia 2</b></td><td>{{{ $rev_documentoal_ln->dias_advertencia2 }}}</td>
			</tr>
			<tr>
				<td><b>Dias Advertencia 3</b></td><td>{{{ $rev_documentoal_ln->dias_advertencia3 }}}</td>
				<td><b>F. Cumplimiento</b></td><td>{{{ $rev_documentoal_ln->fec_cumplimiento }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Vencimiento</b></td><td>{{{ $rev_documentoal_ln->fec_vencimiento }}}</td>
				<td><b>Archivo</b></td><td>{{{ $rev_documentoal_ln->archivo }}}</td>
			</tr>
			<tr>
				<td><b>Observaciones</b></td><td>{{{ $rev_documentoal_ln->observaciones }}}</td>
				<td><b>Estatus</b></td><td>{{{ $rev_documentoal_ln->estatus->estatus }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $rev_documentoal_ln->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $rev_documentoal_ln->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $rev_documentoal_ln->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $rev_documentoal_ln->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $rev_documentoal_ln->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
			@if(isset($rev_documentoal_ln->archivo) and $rev_documentoal_ln->archivo<>"" and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/rev_documentoal_lns/'.$rev_documentoal_ln->archivo))
			<th colspan="4" style="width:100%"> 
				<iframe src="{{ asset('uploads/'.$cia.'/'.$usuario.'/rev_documentoal_lns/'.$rev_documentoal_ln->archivo) }}" style="width:100%; height:500px" frameborder="0"> </iframe>
			</th>
			@endif
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
