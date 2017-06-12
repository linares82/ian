@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('matriz-index')) 
			<td>{{ link_to_route('matriz.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('matriz-edit')) 
			<td>{{ link_to_route('matriz.edit', 'Editar', array($matriz->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($matriz, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'matriz/destroy/'.$matriz->id)) }}
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
				<td style="width:25%"><b>Tipo de Impacto</b></td>
				<td style="width:25%">{{{ $matriz->tipoImpacto->tipo_impacto }}}</td>
				<td style="width:25%"><b>Factor</b></td>
				<td style="width:25%">{{{ $matriz->factor->factor }}}</td>
				
			</tr>
			<tr class="alt">
				<td style="width:25%"><b>Rubro</b></td>
				<td style="width:25%">{{{ $matriz->rubro->rubro }}}</td>
				<td><b>Especifico</b></td>
				<td>{{{ $matriz->especifico->especifico }}}</td>
			</tr>
			<tr >
				<td style="width:25%"><b>Documentos</b></td>
				<td style="width:25%" colspan="3">
					@foreach($matriz->caracteristicas as $c)
					{{{ $c->caracteristica }}} <br>
					@endforeach
				</td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $matriz->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $matriz->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $matriz->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $matriz->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $matriz->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
