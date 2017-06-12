@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('tweet-index')) 
			<td>{{ link_to_route('tweet.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('tweet-edit')) 
			<td>{{ link_to_route('tweet.edit', 'Editar', array($tweet->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($tweet, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'tweet/destroy/'.$tweet->id)) }}
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
			<tr>
				<th>Mantenimiento_id</th>
				<th>Documento</th>
				<th>Archivo</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><b>Mantenimiento_id</b></td><td>{{{ $tweet->mantenimiento_id }}}</td>
					<td><b>Documento</b></td><td>{{{ $tweet->documento }}}</td>
					<td><b>Archivo</b></td><td>{{{ $tweet->archivo }}}</td>
					<td><b>Usu_alta_id</b></td><td>{{{ $tweet->usu_alta_id }}}</td>
					<td><b>Usu_mod_id</b></td><td>{{{ $tweet->usu_mod_id }}}</td>

			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
