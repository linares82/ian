@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('p_correo_bitacora-index')) 
			<td>{{ link_to_route('p_correo_bitacora.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('p_correo_bitacora-edit')) 
			<td>{{ link_to_route('p_correo_bitacora.edit', 'Editar', array($p_correo_bitacora->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($p_correo_bitacora, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'p_correo_bitacora/destroy/'.$p_correo_bitacora->id)) }}
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
				<td><b>Enviar</b></td>
				<td>{{{ $p_correo_bitacora->bndEnviar->bnd }}}</td>
				<td><b>Bitacora</b></td>
				<td>{{{ $p_correo_bitacora->bitacora->bitacora }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Responsable</b></td>
				<td>{{{ $p_correo_bitacora->empleado->nombre }}}</td>
				<td><b>Enviar al Jefe</b></td>
				<td>{{{ $p_correo_bitacora->bndJefe->bnd_jefe }}}</td>
			</tr>
			<tr>
				<td><b>Dias Plazo Minimo</b></td>
				<td>{{{ $p_correo_bitacora->dias_plazo }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $p_correo_bitacora->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $p_correo_bitacora->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $p_correo_bitacora->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $p_correo_bitacora->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $p_correo_bitacora->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
