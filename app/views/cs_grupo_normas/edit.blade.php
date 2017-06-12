@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($cs_grupo_norma, array('class' => 'form', 'method' => 'PUT', 'url' => 'cs_grupo_norma/update/'.$cs_grupo_norma->id)) }}
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

        <div class="row_1 @if ( $errors->has('grupo_norma')) has-error @endif">
            {{ Form::label('grupo_norma', 'Grupo Norma:') }}
              {{ Form::text('grupo_norma', Input::old('grupo_norma'), array('placeholder'=>'Grupo Norma')) }}
            {{ $errors->first('grupo_norma', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('cs_grupo_norma.index', 'Cancelar', $cs_grupo_norma->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop