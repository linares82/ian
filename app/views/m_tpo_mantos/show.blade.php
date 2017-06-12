@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('m_tpo_manto-index')) 
			<td>{{ link_to_route('m_tpo_manto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('m_tpo_manto-edit')) 
			<td>{{ link_to_route('m_tpo_manto.edit', 'Editar', array($m_tpo_manto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($m_tpo_manto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'm_tpo_manto/destroy/'.$m_tpo_manto->id)) }}
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
				<td><b>Tipo</b></td><td>{{{ $m_tpo_manto->tpo_manto }}}</td>
				<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $m_tpo_manto->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $m_tpo_manto->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $m_tpo_manto->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $m_tpo_manto->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $m_tpo_manto->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
