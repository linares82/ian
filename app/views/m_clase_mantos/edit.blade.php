@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($m_clase_manto, array('class' => 'form', 'method' => 'PUT', 'url' => 'm_clase_manto/update/'.$m_clase_manto->id)) }}
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

        <div class="row_1 @if ( $errors->has('clase_manto')) has-error @endif">
            {{ Form::label('clase_manto', 'Clase:') }}
              {{ Form::text('clase_manto', Input::old('clase_manto'), array('placeholder'=>'Clase')) }}
            {{ $errors->first('clase_manto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('m_clase_manto.index', 'Cancelar', $m_clase_manto->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop