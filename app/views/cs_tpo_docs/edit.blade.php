@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($cs_tpo_doc, array('class' => 'form', 'method' => 'PUT', 'url' => 'cs_tpo_doc/update/'.$cs_tpo_doc->id)) }}
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

        <div class="row_1 @if ( $errors->has('tpo_procedimiento_id')) has-error @endif">
            {{ Form::label('tpo_procedimiento_id', 'T. Procedimiento:') }}
              {{ Form::select('tpo_procedimiento_id', $tpo_procedimientos_ls, Input::old('tpo_procedimiento_id'))  }}
            {{ $errors->first('tpo_procedimiento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tpo_doc')) has-error @endif">
            {{ Form::label('tpo_doc', 'T. Documento:') }}
              {{ Form::text('tpo_doc', Input::old('tpo_doc'), array('placeholder'=>'T. Documento')) }}
            {{ $errors->first('tpo_doc', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('cs_tpo_doc.index', 'Cancelar', $cs_tpo_doc->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop