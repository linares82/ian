@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('aa_aspecto-index')) 
			<td>{{ link_to_route('aa_aspecto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('aa_aspecto-edit')) 
			<td>{{ link_to_route('aa_aspecto.edit', 'Editar', array($aa_aspecto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($aa_aspecto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'aa_aspecto/destroy/'.$aa_aspecto->id)) }}
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
				<td><b>Aspectos</b></td>
				<td>{{{ $aa_aspecto->aspectos }}}</td>
				<td><b>Detalle</b></td>
				<td>{{{ $aa_aspecto->detalle }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $aa_aspecto->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $aa_aspecto->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $aa_aspecto->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $aa_aspecto->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $aa_aspecto->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
