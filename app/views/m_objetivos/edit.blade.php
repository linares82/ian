@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($m_objetivo, array('class' => 'form', 'method' => 'PUT', 'url' => 'm_objetivo/update/'.$m_objetivo->id)) }}
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

        <div class="row_1 @if ( $errors->has('objetivo')) has-error @endif">
            {{ Form::label('objetivo', 'Equipo:') }}
              {{ Form::text('objetivo', Input::old('objetivo'), array('placeholder'=>'Objetivo')) }}
            {{ $errors->first('objetivo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('m_objetivo.index', 'Cancelar', $m_objetivo->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop