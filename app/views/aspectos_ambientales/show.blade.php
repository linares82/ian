@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('aspectos_ambientale-index')) 
			<td>{{ link_to_route('aspectos_ambientale.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('aspectos_ambientale-edit')) 
			<td>{{ link_to_route('aspectos_ambientale.edit', 'Editar', array($aspectos_ambientale->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($aspectos_ambientale, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'aspectos_ambientale/destroy/'.$aspectos_ambientale->id)) }}
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
				<td><b>Proceso</b></td><td>{{{ $aspectos_ambientale->proceso->proceso }}}</td>
				<td><b>Area</b></td><td>{{{ $aspectos_ambientale->area->area }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Actividad</b></td><td>{{{ $aspectos_ambientale->actividad }}}</td>
				<td><b>Descripcion</b></td><td>{{{ $aspectos_ambientale->descripcion }}}</td>
			</tr>
			<tr>
				<td><b>Aspecto</b></td><td>{{{ $aspectos_ambientale->aspecto->aspectos }}}</td>
				<td><b>5 Emes</b></td><td>{{{ $aspectos_ambientale->eme->eme }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Condicion</b></td><td>{{{ $aspectos_ambientale->condicion->condicion }}}</td>
				<td><b>Material</b></td><td>{{{ $aspectos_ambientale->impacto->impacto }}}</td>
			</tr>
			<tr>
				<td><b>Aspecto Legislado Nivel Federal</b></td><td>{{{ $aspectos_ambientale->alFederalBnd->bnd }}}</td>
				<td><b>Aspecto Legislado Nivel Estatal</b></td><td>{{{ $aspectos_ambientale->alEstatalBnd->bnd }}}</td>
			<tr class="alt">
				<td><b>Obj. Corporativo</b></td><td>{{{ $aspectos_ambientale->objCorporativoBnd->bnd }}}</td>
				<td><b>Quejas</b></td><td>{{{ $aspectos_ambientale->quejasBnd->bnd }}}</td>
			</tr>
			<tr>
				<td><b>Severidad</b></td><td>{{{ $aspectos_ambientale->severidad->efecto }}}</td>
				<td><b>I. Potencial</b></td><td>{{{ $aspectos_ambientale->bndPotencial->bnd }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Frecuencia</b></td><td>{{{ $aspectos_ambientale->frecuencia->duracion_accion }}}</td>
				<td><b>I. Real</b></td><td>{{{ $aspectos_ambientale->bndReal->bnd }}}</td>
			</tr>
			<tr>
				<td><b>Probabilidad</b></td><td>{{{ $aspectos_ambientale->probabilidad->probabilidad }}}</td>
				<td><b>Imp. Potencial</b></td><td>{{{ $aspectos_ambientale->impPotencial->imp_potencial }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Imp. Real</b></td><td>{{{ $aspectos_ambientale->impReal->imp_real }}}</td>
				<td><b>Observaciones</b></td><td>{{{ $aspectos_ambientale->observaciones }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Controles Opracionales</b></td><td>{{{ $aspectos_ambientale->ctrls_opracionales }}}</td>
				<td><b></b></td><td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $aspectos_ambientale->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $aspectos_ambientale->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $aspectos_ambientale->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $aspectos_ambientale->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $aspectos_ambientale->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
