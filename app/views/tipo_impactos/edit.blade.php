@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($tipo_impacto, array('class' => 'form', 'method' => 'PUT', 'url' => 'tipo_impacto/update/'.$tipo_impacto->id)) }}
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

        <div class="row_1 @if ($errors->has('tipo_impacto')) has-error @endif">
            {{ Form::label('tipo_impacto', 'Tipo de Impacto:') }}
            {{ Form::text('tipo_impacto', Input::old('tipo_impacto'), array('placeholder'=>'Tipo de Impacto')) }}
            {{ $errors->first('tipo_impacto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('tipo_impacto.index', 'Cancelar', $tipo_impacto->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop