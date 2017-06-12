@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'group.store', 'class' => 'form', 'files' => true)) }}
    <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Crear" style="padding:10px;">  

        <div class="row_1 @if ($errors->has('name')) has-error @endif">
            {{ Form::label('name', 'Nombre:') }}
            {{ Form::text('name', Input::old('name'), array('placeholder'=>'Nombre')) }}
            @if ($errors->has('name')) <div class="errorMessage">{{ $errors->first('name') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('permissions')) has-error @endif">
            
            @include('permissions.permissions-select', array('permissions'=> $permissions))
            
            @if ($errors->has('permissions')) <div class="errorMessage">{{ $errors->first('permissions') }}</div> @endif
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('group.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
			</div>
    </div>

{{ Form::close() }}

@stop
@section('js_local')
    <script type="text/javascript" src="{{ asset('js/base.js')}}"></script>
@stop


