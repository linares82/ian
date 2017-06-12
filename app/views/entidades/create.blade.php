@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'entidad.store', 'class' => 'form', 'files' => true)) }}
    <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Crear" style="padding:10px;">  

        <div class="row_1 @if ($errors->has('rzon_social')) has-error @endif">
            {{ Form::label('rzon_social', 'Razón Social:') }}
            {{ Form::text('rzon_social', Input::old('rzon_social'), array('placeholder'=>'Rzon_social')) }}
            {{ $errors->first('rzon_social', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('responsable')) has-error @endif">
            {{ Form::label('responsable', 'Responsable:', array('class'=>'col-md-2 control-label')) }}
            {{ Form::text('responsable', Input::old('responsable'), array('class'=>'form-control', 'placeholder'=>'Responsable')) }}
            @if ($errors->has('responsable')) <div class="errorMessage">{{ $errors->first('responsable') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('dir1')) has-error @endif">
            {{ Form::label('dir1', 'Dirección 1:') }}
              {{ Form::text('dir1', Input::old('dir1'), array('placeholder'=>'Dir1')) }}
            @if ($errors->has('dir1')) <div class="errorMessage">{{ $errors->first('dir1') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('dir2')) has-error @endif">
            {{ Form::label('dir2', 'Dirección 2:') }}
              {{ Form::text('dir2', Input::old('dir1'), array('placeholder'=>'Dir1')) }}
            @if ($errors->has('dir2')) <div class="errorMessage">{{ $errors->first('dir2') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('rfc')) has-error @endif">
            {{ Form::label('rfc', 'Rfc:') }}
            {{ Form::text('rfc', Input::old('rfc'), array('placeholder'=>'Rfc')) }}
            @if ($errors->has('rfc')) <div class="errorMessage">{{ $errors->first('rfc') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('abreviatura')) has-error @endif">
            {{ Form::label('abreviatura', 'Abreviatura:') }}
            {{ Form::text('abreviatura', Input::old('abreviatura'), array('placeholder'=>'Abreviatura')) }}
            @if ($errors->has('abreviatura')) <div class="errorMessage">{{ $errors->first('abreviatura') }}</div> @endif
        </div>

		<div class="row_2 @if ($errors->has('tema')) has-error @endif">
            {{ Form::label('tema', 'Tema:') }}
			{{ Form::text('tema', Input::old('tema'), array('placeholder'=>'metro-blue o metro-gray o metro-orange o metro-red o metro-green')) }}
            @if ($errors->has('tema')) <div class="errorMessage">{{ $errors->first('tema') }}</div> @endif
        </div>
		
        <div class="row_1 @if ($errors->has('logo')) has-error @endif">
            {{ Form::label('logo', 'Logo:') }}
              {{ Form::file('logo') }}
            @if ($errors->has('logo')) <div class="errorMessage">{{ $errors->first('logo') }}</div> @endif
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('entidad.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
			</div>
    </div>

{{ Form::close() }}

@stop


