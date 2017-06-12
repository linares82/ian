@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('mcheck-index')) 
			<td>{{ link_to_route('mcheck.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('mcheck-edit')) 
			<td>{{ link_to_route('mcheck.edit', 'Editar', array($mcheck->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($mcheck, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'mcheck/destroy/'.$mcheck->id)) }}
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
				<td style="width:25%"><b>Area de chequeo</b></td>
				<td style="width:25%">{{{ $mcheck->achequeo->area }}}</td>
				<td style="width:25%"><b>Norma</b></td>
				<td style="width:25%">{{{ $mcheck->normas->norma }}}</td>
				
				
			</tr>
			<tr class="alt">
				<td style="width:25%"><b>No Conformidad</b></td>
				<td style="width:25%">{{{ $mcheck->no_conformidad }}}</td>
				<td style="width:25%"><b>Correccion</b></td>
				<td style="width:25%">{{{ $mcheck->correccion }}}</td>
				
			</tr>
			<tr>
				<td><b>Requisito</b></td>
				<td>{{{ $mcheck->requisito }}}</td>
				<td style="width:25%"><b>RNC</b></td>
				<td style="width:25%">{{{ $mcheck->rnc }}}</td>
				
				
			</tr>
			<tr class="alt">
				<td style="width:25%"><b>Minimo VSM</b></td>
				<td style="width:25%">{{{ $mcheck->minimo_vsm }}}</td>
				<td style="width:25%"><b>Maximo VSM</b></td>
				<td style="width:25%">{{{ $mcheck->maximo_vsm }}}</td>
				
			</tr>
			<tr>
				<td><b>Orden</b></td>
				<td>{{{ $mcheck->orden }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $mcheck->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $mcheck->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $mcheck->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $mcheck->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $mcheck->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
