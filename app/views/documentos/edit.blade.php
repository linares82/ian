@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($documento, array('class' => 'form', 'method' => 'PUT', 'url' => 'documento/update/'.$documento->id, 'files' => true)) }}
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

        <div class="row_1 @if ($errors->has('proyecto')) has-error @endif">
            {{ Form::hidden('enc_impacto_id', Input::old('enc_impacto_id'))  }}
            {{ Form::label('doc_proyecto_id', 'Documento:') }}
            {{ Form::select('doc_proyecto_id', $doc_proyectos_ls, Input::old('doc_proyecto_id'))  }}
            {{ $errors->first('doc_proyecto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols @if ($errors->has('nota')) has-error @endif">
            {{ Form::label('nota', 'Nota:') }}
            {{ Form::textArea('nota', Input::old('nota'), array('placeholder'=>'Nota', 'rows'=>'3', 'style'=>'width:100%;')) }}
            {{ $errors->first('nota', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="form-group">
            {{ Form::label('documento', 'Documento:') }}
            {{ Form::file('archivo') }}
            {{ $errors->first('documento', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('documento.index', 'Cancelar', array('id'=>$documento->enc_impacto_id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop