@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('rev_requisitos_ln-index')) 
			<td>{{ link_to_route('rev_requisitos_ln.index', 'Lista', array('id'=>$rev_requisitos_ln->rev_requisitos_id), array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('rev_requisitos_ln-edit')) 
			<td>{{ link_to_route('rev_requisitos_ln.edit', 'Editar', array($rev_requisitos_ln->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($rev_requisitos_ln, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'rev_requisitos_ln/destroy/'.$rev_requisitos_ln->id)) }}
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
				<td><b>Impacto</b></td><td>{{{ $rev_requisitos_ln->impacto->impacto }}}</td>
				<td><b>Condicion</b></td><td>{{{ $rev_requisitos_ln->condicion->condicion }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Area</b></td><td>{{{ $rev_requisitos_ln->area->area }}}</td>
				<td><b>Norma</b></td><td>{{{ $rev_requisitos_ln->norma }}}</td>
			</tr>
			<tr>
				<td><b>Estatus</b></td><td>{{{ $rev_requisitos_ln->estatus->estatus }}}</td>
				<td><b>Importancia</b></td><td>{{{ $rev_requisitos_ln->importancia->importancia }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Responsable</b></td><td>{{{ $rev_requisitos_ln->responsable->nombre }}}</td>
				<td><b>Dias Advertencia1</b></td><td>{{{ $rev_requisitos_ln->dias_advertencia1 }}}</td>
			</tr>
			<tr>
				<td><b>Dias Advertencia2</b></td><td>{{{ $rev_requisitos_ln->dias_advertencia2 }}}</td>
				<td><b>Dias Advertencia3</b></td><td>{{{ $rev_requisitos_ln->dias_advertencia3 }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. cumplimiento</b></td><td>{{{ $rev_requisitos_ln->fec_cumplimiento }}}</td>
				<td><b>Observaciones</b></td><td>{{{ $rev_requisitos_ln->observaciones }}}</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $rev_requisitos_ln->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $rev_requisitos_ln->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $rev_requisitos_ln->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $rev_requisitos_ln->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $rev_requisitos_ln->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
