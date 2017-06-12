@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($ca_planta, array('class' => 'form', 'method' => 'PUT', 'url' => 'ca_planta/update/'.$ca_planta->id)) }}
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

        <div class="row_1 @if ( $errors->has('planta')) has-error @endif">
            {{ Form::label('planta', 'Planta:') }}
              {{ Form::text('planta', Input::old('planta'), array('placeholder'=>'Planta')) }}
            {{ $errors->first('planta', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('ubicacion')) has-error @endif">
            {{ Form::label('ubicacion', 'Ubicacion:') }}
              {{ Form::text('ubicacion', Input::old('ubicacion'), array('placeholder'=>'Ubicacion')) }}
            {{ $errors->first('ubicacion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('obs')) has-error @endif">
            {{ Form::label('obs', 'Obs:') }}
              {{ Form::text('obs', Input::old('obs'), array('placeholder'=>'Obs')) }}
            {{ $errors->first('obs', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tipo_planta')) has-error @endif">
            {{ Form::label('tipo_planta', 'Tipo Planta:') }}
              {{ Form::text('tipo_planta', Input::old('tipo_planta'), array('placeholder'=>'Tipo Planta')) }}
            {{ $errors->first('tipo_planta', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('c_tratamiento')) has-error @endif">
            {{ Form::label('c_tratamiento', 'C. Tratamiento:') }}
              {{ Form::text('c_tratamiento', Input::old('c_tratamiento'), array('placeholder'=>'C. Tratamiento')) }}
            {{ $errors->first('c_tratamiento', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('ca_planta.index', 'Cancelar', $ca_planta->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop