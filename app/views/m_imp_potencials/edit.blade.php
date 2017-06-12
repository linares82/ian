@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($m_imp_potencial, array('class' => 'form', 'method' => 'PUT', 'url' => 'm_imp_potencial/update/'.$m_imp_potencial->id)) }}
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

        <div class="row_1 @if ( $errors->has('efecto_id')) has-error @endif">
            {{ Form::label('efecto_id', 'Efecto_id:') }}
              {{ Form::input('number', 'efecto_id', Input::old('efecto_id')) }}
            {{ $errors->first('efecto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('duracion_accion_id')) has-error @endif">
            {{ Form::label('duracion_accion_id', 'Duracion_accion_id:') }}
              {{ Form::input('number', 'duracion_accion_id', Input::old('duracion_accion_id')) }}
            {{ $errors->first('duracion_accion_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('imp_potencia_id')) has-error @endif">
            {{ Form::label('imp_potencia_id', 'Imp_potencia_id:') }}
              {{ Form::input('number', 'imp_potencia_id', Input::old('imp_potencia_id')) }}
            {{ $errors->first('imp_potencia_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('usu_mod_id')) has-error @endif">
            {{ Form::label('usu_mod_id', 'Usu_mod_id:') }}
              {{ Form::input('number', 'usu_mod_id', Input::old('usu_mod_id')) }}
            {{ $errors->first('usu_mod_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('usu_alta_id')) has-error @endif">
            {{ Form::label('usu_alta_id', 'Usu_alta_id:') }}
              {{ Form::input('number', 'usu_alta_id', Input::old('usu_alta_id')) }}
            {{ $errors->first('usu_alta_id', '<div class="errorMessage">:message</div>') }}
        </div>


<div class="row_buttons">
  {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
  {{ link_to_route('m_imp_potencial.index', 'Cancelar', $m_imp_potencial->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
</div>

	</div>
</div>

{{ Form::close() }}

@stop