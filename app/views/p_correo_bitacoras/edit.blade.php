@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($p_correo_bitacora, array('class' => 'form', 'method' => 'PUT', 'url' => 'p_correo_bitacora/update/'.$p_correo_bitacora->id)) }}
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

        <div class="row_1 @if ( $errors->has('bnd_enviar')) has-error @endif">
            {{ Form::label('bnd_enviar', 'Enviar:') }}
              {{ Form::select('bnd_enviar', $bnds_ls, Input::old('bnd_enviar'))  }}
            {{ $errors->first('bnd_enviar', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('bitacora_id')) has-error @endif">
            {{ Form::label('bitacora_id', 'Bitacora:') }}
              {{ Form::select('bitacora_id', $bitacoras_ls, Input::old('bitacora_id'))  }}
            {{ $errors->first('bitacora_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('empleado_id')) has-error @endif">
            {{ Form::label('empleado_id', 'Empleado:') }}
              {{ Form::select('empleado_id', $empleados_ls, Input::old('empleado_id'))  }}
            {{ $errors->first('empleado_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('bnd_jefe')) has-error @endif">
            {{ Form::label('bnd_jefe', 'Enviar al Jefe:') }}
              {{ Form::select('bnd_jefe', $bnds_ls, Input::old('bnd_jefe'))  }}
            {{ $errors->first('bnd_jefe', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_plazo')) has-error @endif">
            {{ Form::label('dias_plazo', 'Dias Plazo Minimo:') }}
            {{ Form::input('number', 'dias_plazo', Input::old('dias_plazo')) }}
            {{ $errors->first('dias_plazo', '<div class="errorMessage">:message</div>') }}
        </div>


        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('p_correo_bitacora.index', 'Cancelar', $p_correo_bitacora->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop