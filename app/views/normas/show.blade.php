@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('norma-index')) 
			<td>{{ link_to_route('norma.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('norma-edit')) 
			<td>{{ link_to_route('norma.edit', 'Editar', array($norma->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($norma, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'norma/destroy/'.$norma->id)) }}
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
			<thead>
			<th colspan="4" style="width:100%">Información</th>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $norma->norma }}}</td>
					<td>{{{ $norma->usu_alta_id }}}</td>
					<td>{{{ $norma->usu_mod_id }}}</td>
                    
			</tr>
			<tr class="alt">
				<td><b>Norma</b></td>
				<td>{{{ $norma->norma }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $rubro->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $rubro->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $rubro->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $rubro->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $rubro->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
