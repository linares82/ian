@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'permission.store', 'class' => 'form', 'files' => true)) }}
    <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Crear" style="padding:10px;">  

        <div class="row_1 @if ($errors->has('rzon_social')) has-error @endif">
            {{ Form::label('name', 'Nombre:') }}
            {{ Form::text('name', Input::old('name'), array('placeholder'=>'Nombre')) }}
            @if ($errors->has('name')) <div class="errorMessage">{{ $errors->first('name') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('value')) has-error @endif">
            {{ Form::label('value', 'Valor:', array('class'=>'col-md-2 control-label')) }}
            {{ Form::text('value', Input::old('value'), array('class'=>'form-control', 'placeholder'=>'Valor')) }}
            @if ($errors->has('value')) <div class="errorMessage">{{ $errors->first('value') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('description')) has-error @endif">
            {{ Form::label('description', 'Descripción:') }}
              {{ Form::text('description', Input::old('description'), array('placeholder'=>'Descripción')) }}
            @if ($errors->has('description')) <div class="errorMessage">{{ $errors->first('description') }}</div> @endif
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('permission.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
			</div>
    </div>

{{ Form::close() }}

@stop


