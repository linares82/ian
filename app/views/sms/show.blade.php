@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('sm-index')) 
			<td>{{ link_to_route('sm.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('sm-edit')) 
			<td>{{ link_to_route('sm.edit', 'Editar', array($sm->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
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
				<td><b>Monto</b></td>
				<td>{{{ $sm->monto }}}</td>
				<td><b></b></td>
				<td></td>
				
			</tr>
			<tr class="alt">
				<td><b>U. Mod.</b></td>
				<td>{{{ $sm->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $sm->updated_at }}}</td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
