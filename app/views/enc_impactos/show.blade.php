@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('enc_impacto-index')) 
			<td>{{ link_to_route('enc_impacto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('enc_impacto-edit')) 
			<td>{{ link_to_route('enc_impacto.edit', 'Editar', array($enc_impacto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($enc_impacto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'enc_impacto/destroy/'.$enc_impacto->id)) }}
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
				<td style="width:25%"><b>Proyecto</b></td>
				<td style="width:25%">{{{ $enc_impacto->proyecto }}}</td>
				<td style="width:25%"><b>Tipo de Impacto</b></td>
				<td style="width:25%">{{{ $enc_impacto->tipoImpacto->tipo_impacto }}}</td>
				
			</tr>
			<tr class="alt">
				<td style="width:25%"><b>Fecha</b></td>
				<td style="width:25%">{{{ $enc_impacto->fecha }}}</td>
				<td style="width:25%"><b>Calle</b></td>
				<td style="width:25%">{{{ $enc_impacto->up_calle }}}</td>
			</tr>
			<tr>
				<td style="width:25%"><b>No.</b></td>
				<td style="width:25%">{{{ $enc_impacto->up_no }}}</td>
				<td style="width:25%"><b>Colonia</b></td>
				<td style="width:25%">{{{ $enc_impacto->up_colonia }}}</td>
			</tr>
			<tr class="alt">
				<td style="width:25%"><b>CP</b></td>
				<td style="width:25%">{{{ $enc_impacto->up_cp }}}</td>
				<td style="width:25%"><b>Delegación</b></td>
				<td style="width:25%">{{{ $enc_impacto->up_delegacion }}}</td>
			</tr>
			<tr>
				<td style="width:25%"><b>Superficie del Predio</b></td>
				<td style="width:25%">{{{ $enc_impacto->up_sup_predio }}}</td>
				<td style="width:25%"><b>Longitud</b></td>
				<td style="width:25%">{{{ $enc_impacto->longitud }}}</td>
			</tr>
			<tr class="alt">
				<td style="width:25%"><b>Latitud</b></td>
				<td style="width:25%">{{{ $enc_impacto->latitud }}}</td>
				<td style="width:25%"><b>Altitud</b></td>
				<td style="width:25%">{{{ $enc_impacto->altitud }}}</td>
			</tr>
			<tr>
				<td style="width:25%"><b>UTM X</b></td>
				<td style="width:25%">{{{ $enc_impacto->utm_x }}}</td>
				<td style="width:25%"><b>UTM Y</b></td>
				<td style="width:25%">{{{ $enc_impacto->utm_y }}}</td>
			</tr>
			<tr class="alt">
				<td><b>Breve descripción del proyecto</b></td>
				<td>{{{ $enc_impacto->notas }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">DATOS DEL PROMOVENTE</th>
			</thead>
			<tr>
				<td style="width:25%"><b>Promovente</b></td>
				<td style="width:25%">{{{ $enc_impacto->cliente->cliente }}}</td>
				<td style="width:25%"><b>Calle</b></td>
				<td style="width:25%">{{{ $enc_impacto->od_calle }}}</td>
			</tr>
			<tr>
				<td style="width:25%"><b>No.</b></td>
				<td style="width:25%">{{{ $enc_impacto->od_no }}}</td>
				<td style="width:25%"><b>Colonia</b></td>
				<td style="width:25%">{{{ $enc_impacto->od_colonia }}}</td>
			</tr>
			<tr class="alt">
				
				<td style="width:25%"><b>CP</b></td>
				<td style="width:25%">{{{ $enc_impacto->od_cp }}}</td>
				<td style="width:25%"><b>Delegación</b></td>
				<td style="width:25%">{{{ $enc_impacto->od_delegacion }}}</td>
			</tr>
			<tr>
				
				<td style="width:25%"><b>RFC</b></td>
				<td style="width:25%">{{{ $enc_impacto->od_rfc }}}</td>
				<td style="width:25%"><b>Teléfono</b></td>
				<td style="width:25%">{{{ $enc_impacto->od_telefono }}}</td>
			</tr>
			<tr class="alt">
				
				<td style="width:25%"><b></b>Correo electrónico</td>
				<td style="width:25%">{{{ $enc_impacto->od_correo }}}</td>
				<td><b></b></td>
				<td></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">DATOS DEL REPRESENTANTE LEGAL (EN SU CASO)</th>
			</thead>
			<tr>
				<td style="width:25%"><b>A. Paterno</b></td>
				<td style="width:25%">{{{ $enc_impacto->rl_ape_pat }}}</td>
				<td style="width:25%"><b>A. Materno</b></td>
				<td style="width:25%">{{{ $enc_impacto->rl_ape_mat }}}</td>
			</tr>
			<tr class="alt">
				<td style="width:25%"><b>Nombre</b></td>
				<td style="width:25%">{{{ $enc_impacto->rl_nombre }}}</td>
				<td style="width:25%"><b>Identificación Oficial Vigente</b></td>
				<td style="width:25%">{{{ $enc_impacto->rl_id_vigente }}}</td>
			</tr>
			<tr>
				<td style="width:25%"><b>No.</b></td>
				<td style="width:25%">{{{ $enc_impacto->rl_id_no }}}</td>
				<td style="width:25%"><b>Instrumento No.</b></td>
				<td style="width:25%">{{{ $enc_impacto->rl_no_instrumento }}}</td>
			</tr>
			<tr class="alt">
				<td style="width:25%"><b>Autorizados</b></td>
				<td style="width:25%">{{{ $enc_impacto->rl_autorizados }}}</td>
				<td style="width:25%"><b></b></td>
				<td style="width:25%"></td>
			</tr>
			<thead>
				<th colspan="4" style="width:100%">Manipulación de registros</th>
			</thead>
            <tr class="alt">
				<td><b>U. Alta</b></td>
				<td>{{{ $enc_impacto->uAlta->username }}}</td>
				<td><b>F. Alta</b></td>
				<td>{{{ $enc_impacto->created_at }}}</td>
			</tr>
			<tr>
				<td><b>U. Mod.</b></td>
				<td>{{{ $enc_impacto->uMod->username }}}</td>
				<td><b>F. Mod.</b></td>
				<td>{{{ $enc_impacto->updated_at }}}</td>
			</tr>
			<tr class="alt">
				<td><b>F. Eliminado</b></td>
				<td>{{{ $enc_impacto->deleted_at }}}</td>
				<td><b> </b></td>
				<td> </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
