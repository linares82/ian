@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($ca_residuo, array('class' => 'form', 'method' => 'PUT', 'url' => 'ca_residuo/update/'.$ca_residuo->id)) }}
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

        <div class="row_1 @if ( $errors->has('residuo')) has-error @endif">
            {{ Form::label('residuo', 'Residuo:') }}
              {{ Form::text('residuo', Input::old('residuo'), array('placeholder'=>'Residuo')) }}
            {{ $errors->first('residuo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('unidad')) has-error @endif">
            {{ Form::label('unidad', 'Unidad:') }}
              {{ Form::text('unidad', Input::old('unidad'), array('placeholder'=>'Unidad')) }}
            {{ $errors->first('unidad', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('peligroso')) has-error @endif">
            {{ Form::label('peligroso', 'Peligroso:') }}
              {{ Form::select('peligroso', $bnds_ls, Input::old('peligroso'))  }}
            {{ $errors->first('peligroso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('ca_residuo.index', 'Cancelar', $ca_residuo->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop