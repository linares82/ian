@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('cs_norma-index')) 
			<td>{{ link_to_route('cs_norma.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('cs_norma-edit')) 
			<td>{{ link_to_route('cs_norma.edit', 'Editar', array($cs_norma->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($cs_norma, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'cs_norma/destroy/'.$cs_norma->id)) }}
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
				<td><b>Grupo Norma</b></td>
				<td>{{{ $cs_norma->grupo_norma_id }}}</td>
				<td><b>Norma</b></td>
				<td>{{{ $cs_norma->norma }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Archivo</b></td>
				<td>{{{ $cs_norma->archivo }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $cs_norma->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $cs_norma->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $cs_norma->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $cs_norma->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $cs_norma->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
			@if(isset($cs_norma->archivo) and $cs_norma->archivo<>"" and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/cs_normas/'.$cs_norma->archivo))
			<th colspan="4" style="width:100%"> 
				<iframe src="{{ asset('uploads/'.$cia.'/'.$usuario.'/cs_normas/'.$cs_norma->archivo) }}" style="width:100%; height:500px" frameborder="0"> </iframe>
			</th>
			@endif
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
