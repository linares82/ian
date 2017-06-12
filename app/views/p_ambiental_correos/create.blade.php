@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'p_ambiental_correo.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('bnd_envio')) has-error @endif">
            {{ Form::label('bnd_envio', 'Bnd_envio:') }}
              {{ Form::input('number', 'bnd_envio', Input::old('bnd_envio')) }}
            {{ $errors->first('bnd_envio', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('bnd_responsable')) has-error @endif">
            {{ Form::label('bnd_responsable', 'Bnd_responsable:') }}
              {{ Form::input('number', 'bnd_responsable', Input::old('bnd_responsable')) }}
            {{ $errors->first('bnd_responsable', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('bnd_jefe')) has-error @endif">
            {{ Form::label('bnd_jefe', 'Bnd_jefe:') }}
              {{ Form::input('number', 'bnd_jefe', Input::old('bnd_jefe')) }}
            {{ $errors->first('bnd_jefe', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('ccp')) has-error @endif">
            {{ Form::label('ccp', 'Ccp:') }}
              {{ Form::text('ccp', Input::old('ccp'), array('placeholder'=>'Ccp')) }}
            {{ $errors->first('ccp', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_ult_envio')) has-error @endif">
            {{ Form::label('fec_ult_envio', 'Fec_ult_envio:') }}
              {{ Form::text('fec_ult_envio', Input::old('fec_ult_envio'), array('placeholder'=>'Fec_ult_envio')) }}
            {{ $errors->first('fec_ult_envio', '<div class="errorMessage">:message</div>') }}
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
					  {{ link_to_route('p_ambiental_correo.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
				</div>
			</div>
    </div>

{{ Form::close() }}

@stop


