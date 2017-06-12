@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 's_comentarios_procedimiento.store', 'class' => 'form')) }}
    <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Crear" style="padding:10px;">  

            <div class="row">
                <div class="col-md-10 col-md-offset-2">

                    @if ($errors->any())
                        <div class="errorSumary">
                            Por favor corregir los siguientes errores de captura: 
                            <ul >
                                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                            </ul>
                        </div>
                        
                    @endif

                </div>
            </div>

        <div class="row_1 @if ( $errors->has('s_procedimiento_id')) has-error @endif">
            {{ Form::label('s_procedimiento_id', 'S_procedimiento_id:') }}
              {{ Form::input('number', 's_procedimiento_id', Input::old('s_procedimiento_id')) }}
            {{ $errors->first('s_procedimiento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('comentario')) has-error @endif">
            {{ Form::label('comentario', 'Comentario:') }}
              {{ Form::text('comentario', Input::old('comentario'), array('placeholder'=>'Comentario')) }}
            {{ $errors->first('comentario', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('estatus_id')) has-error @endif">
            {{ Form::label('estatus_id', 'Estatus_id:') }}
              {{ Form::input('number', 'estatus_id', Input::old('estatus_id')) }}
            {{ $errors->first('estatus_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('usu_alta_id')) has-error @endif">
            {{ Form::label('usu_alta_id', 'Usu_alta_id:') }}
              {{ Form::input('number', 'usu_alta_id', Input::old('usu_alta_id')) }}
            {{ $errors->first('usu_alta_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('usu_mod_id')) has-error @endif">
            {{ Form::label('usu_mod_id', 'Usu_mod_id:') }}
              {{ Form::input('number', 'usu_mod_id', Input::old('usu_mod_id')) }}
            {{ $errors->first('usu_mod_id', '<div class="errorMessage">:message</div>') }}
        </div>


				<div class="row_buttons">
					  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
					  {{ link_to_route('s_comentarios_procedimiento.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
				</div>
			</div>
    </div>

{{ Form::close() }}

@stop


