@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($condicione, array('class' => 'form', 'method' => 'PUT', 'url' => 'condicione/update/'.$condicione->id)) }}
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

        <div class="row_1 @if ( $errors->has('impacto_id')) has-error @endif">
            {{ Form::label('impacto_id', 'Impacto_id:') }}
              {{ Form::select('impacto_id', $impactos_ls, Input::old('impacto_id'))  }}
            {{ $errors->first('impacto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('condicion')) has-error @endif">
            {{ Form::label('condicion', 'Condicion:') }}
              {{ Form::text('condicion', Input::old('condicion'), array('placeholder'=>'Condicion')) }}
            {{ $errors->first('condicion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('condicione.index', 'Cancelar', $condicione->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop