@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('checkl-index')) 
			<td>{{ link_to_route('checkl.index', 'Lista', array('id'=>$checkl->check_id), array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('checkl-edit')) 
			<td>{{ link_to_route('checkl.edit', 'Editar', array($checkl->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($checkl, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'checkl/destroy/'.$checkl->id)) }}
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
			
			<tr >
				<td><b>Area</b></td>
				<td>{{{ $checkl->area->area }}}</td>
				<td><b>No Conformidad</b></td>
				<td>{{{$checkl->no_conformidad}}} </td>
			</tr>
			<tr class="alt">
				<td><b>especifico</b></td>
				<td>{{{ $checkl->especifico }}}</td>
				<td><b>Requisito</b></td>
				<td>{{{$checkl->requisito}}}</td>
			</tr>
			<tr >
				<td><b>RNC</b></td>
				<td>{{{ $checkl->rnc }}}</td>
				<td><b>Minimo VSM</b></td>
				<td> {{{$checkl->minimo_vsm}}}</td>
			</tr>
			<tr class="alt">
				<td><b>Maximo VSM</b></td>
				<td>{{{ $checkl->maximo_vsm }}}</td>
				<td><b>Cumplimiento</b></td>
				<td>{{{$checkl->cumple->cumplimiento}}}</td>
			</tr>
			<tr >
				<td><b>M. Min.</b></td>
				<td>{{{ $checkl->monto_min }}}</td>
				<td><b>M. Max.</b></td>
				<td> {{{$checkl->monto_max}}}</td>
			</tr>
			<tr class="alt">
				<td><b>Correccion</b></td>
				<td>{{{ $checkl->correccion }}}</td>
				<td><b>Correccion</b></td>
				<td>{{{ $checkl->correccion_detallada }}}</td>
			</tr>
			<tr >
				<td><b>T. en Semanasa</b></td>
				<td>{{{$checkl->t_semanas}}}</td>
				<td><b>Responsable</b></td>
				<td>{{{ $checkl->responsable }}}</td>
			</tr>
			<tr >
				<td><b>M. Estimado</b></td>
				<td> {{{$checkl->monto_estimado}}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $checkl->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $checkl->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $checkl->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $checkl->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $checkl->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
