@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($ca_fuentes_fija, array('class' => 'form', 'method' => 'PUT', 'url' => 'ca_fuentes_fija/update/'.$ca_fuentes_fija->id)) }}
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
            {{ Form::label('planta', 'Fuente Fija:') }}
              {{ Form::text('planta', Input::old('planta'), array('placeholder'=>'Fuente Fija')) }}
            {{ $errors->first('planta', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('marca')) has-error @endif">
            {{ Form::label('marca', 'Marca:') }}
              {{ Form::text('marca', Input::old('marca'), array('placeholder'=>'Marca')) }}
            {{ $errors->first('marca', '<div class="errorMessage">:message</div>') }}
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

        <div class="row_1 @if ( $errors->has('c_termica')) has-error @endif">
            {{ Form::label('c_termica', 'C. Térmica:') }}
              {{ Form::text('c_termica', Input::old('c_termica'), array('placeholder'=>'C. Térmica')) }}
            {{ $errors->first('c_termica', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tipo_combustible')) has-error @endif">
            {{ Form::label('tipo_combustible', 'Tipo Combustible:') }}
              {{ Form::text('tipo_combustible', Input::old('tipo_combustible'), array('placeholder'=>'Tipo Combustible')) }}
            {{ $errors->first('tipo_combustible', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('ca_fuentes_fija.index', 'Cancelar', $ca_fuentes_fija->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop