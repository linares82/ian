@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($comentarios_b, array('class' => 'form', 'method' => 'PUT', 'url' => 'comentarios_b/update/'.$comentarios_b->id)) }}
     <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Editar" style="padding:10px;"> 

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

        <div class="row_1 @if ( $errors->has('bitacora_seguridad_id')) has-error @endif">
            {{ Form::label('bitacora_seguridad_id', 'Bitacora_seguridad_id:') }}
              {{ Form::input('number', 'bitacora_seguridad_id', Input::old('bitacora_seguridad_id')) }}
            {{ $errors->first('bitacora_seguridad_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('comentario')) has-error @endif">
            {{ Form::label('comentario', 'Comentario:') }}
              {{ Form::text('comentario', Input::old('comentario'), array('placeholder'=>'Comentario')) }}
            {{ $errors->first('comentario', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('costo')) has-error @endif">
            {{ Form::label('costo', 'Costo:') }}
              {{ Form::text('costo', Input::old('costo'), array('placeholder'=>'Costo')) }}
            {{ $errors->first('costo', '<div class="errorMessage">:message</div>') }}
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
  {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
  {{ link_to_route('comentarios_b.index', 'Cancelar', $comentarios_b->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
</div>

	</div>
</div>

{{ Form::close() }}

@stop