@extends('layouts.tabs')

@section('contenido_tab')

<div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
	<table>
		<tr>
			@if (Sentry::getUser()->hasAccess('users-index')) 
			<td>{{ link_to_route('user.index', 'Lista', null, array('class'=>'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('users-edit')) 
			<td>{{ link_to_route('user.edit', 'Editar', array($user->id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}</td>
			@endif
			@if (Sentry::getUser()->hasAccess('users-destroy')) 
			<td>{{ Form::model($user, array('style' => 'display: form-horizontal;', 'method' => 'POST', 'url' => 'user/destroy/'.$user->id)) }}
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
					<td style="width:25%"><b>Usuario</b></td>
					<td style="width:25%">{{{ $user->username }}}</td>
					<td style="width:25%"><b>Email</b></td>
					<td style="width:25%">{{{ $user->email }}}</td>
				</tr>
				<tr class="alt">
					<td style="width:25%"><b>Multientidad</b></td>
					<td style="width:25%">{{{ User::find($user->id)->multiEntidad->bnd }}}</td>
					<td style="width:25%"><b>Entidad</b></td>
					<td style="width:25%">{{{ User::find($user->id)->Entidad->abreviatura }}}</td>
				</tr>
				<tr >
					<td style="width:25%"><b>Permisos</b></td>
					<td>
					@foreach($userPermissions as $permission)
							{{{ $permission->name }}}
						<br/>
					@endforeach
					</td>
					<td style="width:25%"><b>Grupos</b></td>
					<td>
					@foreach($groups as $group)
						@if(($user->inGroup($group)))
							{{{ $group->name }}} <br/>
						@endif
					@endforeach
					</td>
				</tr>
				<thead>
					<th colspan="4" style="width:100%">Manipulación de registros</th>
				</thead>
				<tr>
					<td><b>F. Alta</b></td>
					<td>{{{ $user->created_at }}}</td>
					<td style="width:25%"><b>F. Mod.</b></td>
					<td style="width:25%">{{{ $user->created_at }}}</td>
				</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>
@stop
