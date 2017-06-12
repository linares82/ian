@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('doc_proyecto-index')) 
			<td>{{ link_to_route('doc_proyecto.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('doc_proyecto-edit')) 
			<td>{{ link_to_route('doc_proyecto.edit', 'Editar', array($doc_proyecto->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('menus-destroy')) 
			<td>{{ Form::model($doc_proyecto, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'doc_proyecto/destroy/'.$doc_proyecto->id)) }}
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
				<th>Documento</th>
				<th>Usu_alta_id</th>
				<th>Usu_mod_id</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{{ $doc_proyecto->documento }}}</td>
					<td>{{{ $doc_proyecto->usu_alta_id }}}</td>
					<td>{{{ $doc_proyecto->usu_mod_id }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('doc_proyectos.destroy', $doc_proyecto->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('doc_proyectos.edit', 'Edit', array($doc_proyecto->id), array('class' => 'btn btn-info')) }}
                    </td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
