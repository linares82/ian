@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('gd_producto-index')) 
			<td>{{ link_to_route('gd_producto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('gd_producto-edit')) 
			<td>{{ link_to_route('gd_producto.edit', 'Editar', array($gd_producto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('gd_productos-destroy')) 
			<td>{{ Form::model($gd_producto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'gd_producto/destroy/'.$gd_producto->id)) }}
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
			<th colspan="4" style="width:100%">Información del Item</th>
		</thead>

		<tbody>
			<tr>
					<td style="width:25%"><b>Producto</b></td>
					<td style="width:25%">{{{ $gd_producto->producto }}}</td>
					<td style="width:25%"><b>Abreviación</b></td>
					<td style="width:25%">{{{ $gd_producto->abreviacion }}}</td>
			</tr>
			<tr class="alt">
					<td><b>U. Alta</b></td>
					<td>{{{ $gd_producto->uAlta->username }}}</td>
					<td><b>F. Alta</b></td>
					<td>{{{ $gd_producto->created_at }}}</td>
			</tr>
			<tr >
					<td><b>U. Mod.</b></td>
					<td>{{{ $gd_producto->uMod->username }}}</td>
					<td><b>F. Mod.</b></td>
					<td>{{{ $gd_producto->uodated_at }}}</td>
			</tr>
			<tr class="alt">
					<td><b>F. Eliminado</b></td>
					<td>{{{ $gd_producto->deleted_at }}}</td>
					<td><b> </b></td>
					<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
